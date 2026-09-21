<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Order;
use App\Models\Review;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman profil pelanggan
     */
    public function edit()
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        // Hitung jumlah pesanan milik user
        $jumlahPesanan = Order::where('user_id', Auth::id())->count();

        // Hitung jumlah ulasan milik user
        $jumlahUlasan = Review::where('user_id', Auth::id())->count();

        // Hitung rata-rata rating
        $rating = Review::where('user_id', Auth::id())->avg('rating');

        // Kalau belum pernah memberikan rating
        // tampilkan 0
        $rating = $rating ? number_format($rating, 1) : '0.0';

        return view('user.profile.edit', compact(
            'user',
            'jumlahPesanan',
            'jumlahUlasan',
            'rating'
        ));
    }

    /**
     * Mengupdate data profil user
     */
    public function update(Request $request)
    {
        // Ambil user yang sedang login
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:128',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string',
            'password' => 'nullable|min:6|confirmed',
        ]);

        // Update data profil
        $user->name = $request->name;
        $user->email = $request->email;
        $user->no_hp = $request->no_hp;
        $user->alamat = $request->alamat;

        // Kalau password diisi, ubah password
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Simpan perubahan
        $user->save();

        // Kembali ke halaman profil
        return redirect()
            ->route('profile.edit')
            ->with('success', 'Profil berhasil diperbarui!');
    }
}

