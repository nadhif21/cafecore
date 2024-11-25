<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input login
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        // Coba login dengan kredensial yang diberikan
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->intended(route('user.dashboard'));
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }
}
