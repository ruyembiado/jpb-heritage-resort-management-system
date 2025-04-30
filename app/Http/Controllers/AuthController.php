<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        if (auth()->attempt($credentials)) {
            return redirect('/dashboard')->with('success', 'Login successful');
        }

        return back()
            ->withErrors(['error' => 'The provided credentials do not match our records.'])
            ->withInput($request->only('email'));
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/')->with('success', 'Logout successful');
    }
}
