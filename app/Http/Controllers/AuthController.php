<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
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
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('karyawan.index');
        }

        return back()
            ->withErrors(['email' => 'Email atau password salah.'])
            ->withInput($request->only('email'));
    }


    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function resetPassword(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'password.confirmed' => 'Konfirmasi password tidak sama.',
        ]);

        $admin = Admin::where('email', $data['email'])->first();
        if (! $admin) {
            return back()->withErrors(['email' => 'Email admin tidak ditemukan.'])->withInput($request->only('email'));
        }

        $admin->update(['password' => Hash::make($data['password'])]);

        return redirect()->route('login')->with('success', 'Password berhasil diubah. Silakan login dengan password baru.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
