<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
{
    if (Auth::check()) {
        // Jika sudah login, arahkan ke halaman katalog yang sesuai
        if (Auth::user()->role === 'user') {
            return redirect()->route('user.catalog');
        } elseif (Auth::user()->role === 'admin') {
            return redirect()->route('admin.home');
        }
    }

    return view('login');
}


public function login(Request $request)
{
    // Validasi dan login pengguna
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        // Redirect ke halaman sesuai peran
        if (Auth::user()->role === 'user') {
            return redirect()->route('user.catalog');
        } elseif (Auth::user()->role === 'admin') {
            return redirect()->route('admin.home');
        }
    }

    // Jika gagal login, kembali ke halaman login
    return redirect()->route('login')->with('error', 'Invalid credentials');
}


    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function showRegisterForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,user',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('login')->with('success', 'Account created successfully. Please login.');
    }
}
