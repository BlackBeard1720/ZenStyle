<?php

namespace App\Http\Controllers\Staff\Auth;

use App\Http\Controllers\Controller;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class SessionController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('staff.auth.signin');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate the request
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        // attempt a login
        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('staff.dashboard'));
        }
        //redirect back if login fail
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate(); //hủy session cũ
        $request->session()->regenerateToken(); //tạo CSRF token mới
        return to_route('staff.login');
    }
}
