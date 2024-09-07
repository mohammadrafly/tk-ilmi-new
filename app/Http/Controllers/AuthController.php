<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('auth.login', [
                'title' => 'Login'
            ]);
        }

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return back()->with([
                'success' => 'You are logged in!',
                'redirect' => route('dashboard.index'),
            ]);
        } else {
            return back()->withErrors([
                'email' => 'Invalid credentials, please try again.',
            ])->withInput($request->except('password'));
        }
    }

    public function register(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('auth.register', [
                'title' => 'Register'
            ]);
        }

        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'siswa'
        ]);

        Auth::login($user);

        return back()->with([
            'success' => 'Your account has been created. You will be redirected to the dashboard page shortly.',
            'redirect' => route('dashboard.index')
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with([
            'success' => 'You have been logged out.',
            'redirect' => route('login')
        ]);
    }
}
