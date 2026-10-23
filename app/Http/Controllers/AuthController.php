<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'user' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('user', $credentials['user'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return back()
                ->withInput()
                ->with('error', 'Username atau password salah.');
        }

        if (!in_array($user->role, ['admin', 'pimpinan', 'karyawan'], true)) {
            return back()
                ->with('error', 'Role akun tidak dikenali. Hubungi administrator.');
        }

        $request->session()->regenerate();

        $request->session()->put([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_role' => $user->role,
        ]);

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
