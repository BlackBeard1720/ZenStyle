<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(Request $request): View
    {
        $user = $request->user()->loadMissing(['role', 'staff']);

        return view('staff.profile.show', compact('user'));
    }



    public function update(Request $request): RedirectResponse
    {
        $user = $request->user()->loadMissing(['staff']);

        $staff = $user->staff;

        if (! $staff) {
            $staff = Staff::create([
                'user_id' => $user->id,
                'full_name' => $user->username ?: 'Staff User',
                'email' => $user->email,
                'status' => 'active',
            ]);
        }

        $hasUniquePhoneIndex = DB::table('information_schema.statistics')
            ->where('table_schema', DB::getDatabaseName())
            ->where('table_name', 'staff')
            ->where('column_name', 'phone')
            ->where('non_unique', 0)
            ->exists();

        // Profile ca nhan chi cho phep cap nhat avatar va phone. Cac thong tin khac do admin quan ly.
        $rules = [
            'phone' => ['nullable', 'string', 'max:20'],
            'avatar' => ['nullable', 'url', 'max:2048'],
        ];

        if ($hasUniquePhoneIndex) {
            $rules['phone'][] = Rule::unique('staff', 'phone')->ignore($staff->id);
        }

        $data = $request->validate($rules);

        $staff->update($data);

        return to_route('staff.profile.show')->with('success', 'Profile updated successfully.');
    }
}
