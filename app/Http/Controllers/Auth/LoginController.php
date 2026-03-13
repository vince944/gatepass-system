<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email','password');

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->role == 'employee') {
                return redirect('/employee/dashboard');
            }

            if ($user->role == 'admin') {
                return redirect('/admin/dashboard');
            }

            if ($user->role == 'guard') {
                return redirect('/guard/dashboard');
            }

            if ($user->role == 'coordinator') {
                return redirect('/coordinator/dashboard');
            }

            return redirect('/dashboard');
        }

        return back()->with('error', 'Invalid email or password');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}