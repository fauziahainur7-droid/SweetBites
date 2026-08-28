<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showlogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($data)) {
            return redirect('/');
        }

        return back()->with('error','Email atau password salah');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function storeRegister(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email'=> 'required|email|unique:users,email',
            'password'=> 'required|min:8|confirmed',
            'no_hp' => 'required',
            'alamat' => 'required',
        ]);

        $data['password'] = Hash::make($data['password']);
        
        user::create($data);

        return redirect()
            ->route('login')
            ->with('success','Registrasi Berhasil.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return redirect()->route('login');
    }

}
