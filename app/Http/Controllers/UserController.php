<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query()->with('role')
            ->when($request->id, function ($query, $id) {
                $query->where('id', $id);
            })
            ->when($request->username, function ($query, $username) {
                $query->where('username', 'like', '%' . $username . '%');
            })
            ->latest()->paginate(10)->withQueryString();

        return view('staff.users.index', ['users' => $users]);
    }

    public function create()
    {
        return view('staff.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', Password::default()],
            'role_id' => ['required', 'exists:roles,id'],
        ]);
        // validate the request
        User::create([
            // create the user in the database
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'status' => 'active',
        ]);
        // redirect to user list
        return to_route('staff.users.index')
            ->with('success', 'User created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(User $user)
    {
        return view('staff.users.edit', ['user' => $user]);
    }

    public function update(Request $request, User $user)
    {
        // validate the request
        $request->validate([
            'username' => ['required', 'string', 'max:255',
                Rule::unique('users', 'username')->ignore($user),
            ],
            'email' => ['required', 'string', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($user),
            ],
            'password' => ['nullable', Password::default()],
            'role_id' => ['required', 'exists:roles,id'],
        ]);
        // update the user in the database
        $user->update([
            'username' => $request->username,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'password' => $request->filled('password')
                ? Hash::make($request->password)
                : $user->password,
        ]);
        // redirect to user list
        return to_route('staff.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        // redirect to user list
        return to_route('staff.users.index')
            ->with('success', 'User deleted successfully.');
    }
}
