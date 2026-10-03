<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
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
    $data = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt([
        'email' => $data['email'],
        'password' => $data['password'],
    ])) {

        $request->session()->regenerate();

        $isAdmin = \App\Models\Admin::where(
            'email',
            Auth::user()->email
        )->exists();

        if ($isAdmin) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('home');
    }

    return back()->with('error', 'Email atau password salah');
}

    public function register()
    {
        return view('auth.register');
    }

    public function storeRegister(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:128',

            'email' =>
                'required|email|unique:users,email',

            'password' =>
                'required|min:6|confirmed',

            'no_hp' =>
                'required|string|max:20',

            'alamat' =>
                'required|string',
        ]);

        $data['password'] =
            Hash::make($data['password']);

        User::create($data);

        return redirect()
            ->route('login')
            ->with(
                'success',
                'Registrasi berhasil. Silakan login!'
            );
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()
            ->route('home');
    }
}