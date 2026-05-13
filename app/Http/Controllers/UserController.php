<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

    public function store(StoreUserRequest $request)
    {
        // validate the request
        $data = $request->validated();
        // create the user in the database
        $data['password'] = Hash::make($data['password']);
        $data['status'] = 'active';
        User::create($data);
        // redirect to dashboard
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

    public function update(UpdateUserRequest $request, User $user)
    {
        // validate the request
        $data = $request->validated();
        // update password only when provided
        if ($request->filled('password')) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        //update user in database
        $user->update($data);
        // redirect to user list
        return to_route('staff.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return to_route('staff.users.index')
            ->with('success', 'User deleted successfully.');
    }
}
