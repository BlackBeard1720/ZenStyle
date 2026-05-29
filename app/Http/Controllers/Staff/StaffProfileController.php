<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StaffProfileController extends Controller
{
    private const INTERNAL_ROLES = ['admin', 'receptionist', 'stylist'];

    public function index(Request $request)
    {
        $staffProfiles = Staff::query()->with(['user.role'])
            ->when($request->full_name, function ($query, $full_name) {
                $query->where('full_name', 'like', '%' . $full_name . '%');
            })
            ->latest()->paginate(10)->withQueryString();

        return view('staff.staff-profiles.index', ['staffProfiles' => $staffProfiles]);
    }

    public function create()
    {
        // Get all internal users who do NOT have a staff profile yet
        $availableUsers = User::query()
            ->whereHas('role', function ($query) {
                $query->whereIn('role_name', self::INTERNAL_ROLES);
            })
            ->whereDoesntHave('staff')
            ->get();

        return view('staff.staff-profiles.create', ['availableUsers' => $availableUsers]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => [
                'required',
                'exists:users,id',
                Rule::unique('staff', 'user_id'),
            ],
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20', Rule::unique('staff', 'phone')],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('staff', 'email')],
            'specialization' => ['nullable', 'string', 'max:255'],
            'avatar' => ['nullable', 'url', 'max:2048'],
            'salary' => ['nullable', 'numeric', 'min:0'],
            'hire_date' => ['nullable', 'date'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        Staff::create($request->all());

        return to_route('staff.staff-profiles.index')
            ->with('success', 'Staff profile created successfully.');
    }

    public function show(Staff $staff)
    {
        $staff->load('user.role');
        return view('staff.staff-profiles.show', ['staff' => $staff]);
    }

    public function edit(Staff $staff)
    {
        // Get available users PLUS the user currently assigned to this profile
        $availableUsers = User::query()
            ->whereHas('role', function ($query) {
                $query->whereIn('role_name', self::INTERNAL_ROLES);
            })
            ->where(function ($query) use ($staff) {
                $query->whereDoesntHave('staff')
                      ->orWhere('id', $staff->user_id);
            })
            ->get();

        return view('staff.staff-profiles.edit', [
            'staff' => $staff,
            'availableUsers' => $availableUsers
        ]);
    }

    public function update(Request $request, Staff $staff)
    {
        $request->validate([
            'user_id' => [
                'required',
                'exists:users,id',
                Rule::unique('staff', 'user_id')->ignore($staff->id),
            ],
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20', Rule::unique('staff', 'phone')->ignore($staff->id)],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('staff', 'email')->ignore($staff->id)],
            'specialization' => ['nullable', 'string', 'max:255'],
            'avatar' => ['nullable', 'url', 'max:2048'],
            'salary' => ['nullable', 'numeric', 'min:0'],
            'hire_date' => ['nullable', 'date'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $staff->update($request->all());

        return to_route('staff.staff-profiles.index')
            ->with('success', 'Staff profile updated successfully.');
    }

    public function destroy(Staff $staff)
    {
        $staff->delete();

        return to_route('staff.staff-profiles.index')
            ->with('success', 'Staff profile deleted successfully.');
    }
}
