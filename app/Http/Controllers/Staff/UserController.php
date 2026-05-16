<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    private const INTERNAL_ROLES = ['admin', 'receptionist', 'stylist'];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::query()->with(['role', 'staff', 'client'])
            ->whereHas('role', function ($query) {
                $query->whereIn('role_name', self::INTERNAL_ROLES);
            })
            ->when($request->id, function ($query, $id) {
                $query->where('id', $id);
            })
            ->when($request->username, function ($query, $username) {
                $query->where('username', 'like', '%' . $username . '%');
            })
            ->latest()->paginate(10)->withQueryString();

        return view('staff.users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('staff.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate the request
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', Password::default()],
            'role_id' => [
                'required',
                Rule::exists('roles', 'id')->where(fn ($query) => $query->whereIn('role_name', self::INTERNAL_ROLES)),
            ],
        ]);
        // create new user in the database
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

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load(['role', 'staff', 'client']);

        return view('staff.users.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $this->abortForClientAccount($user);

        return view('staff.users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $this->abortForClientAccount($user);

        // validate the request
        $request->validate([
            'username' => ['required', 'string', 'max:255',
                Rule::unique('users', 'username')->ignore($user),
            ],
            'email' => ['required', 'string', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($user),
            ],
            'password' => ['nullable', Password::default()],
            'role_id' => [
                'required',
                Rule::exists('roles', 'id')->where(fn ($query) => $query->whereIn('role_name', self::INTERNAL_ROLES)),
            ],
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->abortForClientAccount($user);

        $user->delete();
        // redirect to user list
        return to_route('staff.users.index')
            ->with('success', 'User deleted successfully.');
    }

    private function abortForClientAccount(User $user): void
    {
        abort_if($user->hasRole('client'), 404);
    }
}
