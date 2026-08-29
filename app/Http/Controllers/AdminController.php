<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = Admin::all();

        return view('admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admins.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:128',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $data['password'] = Hash::make($data['password']);

        Admin::create($data);

        return redirect()->route('admins.index')
            ->with('success','Admin Berhasil Ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $admin = Admin::findOrFail($id);

        return view('admins.edit', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $admin = Admin::findOrFail($id);

        $data = $request->validate([
            'nama' => 'required|string|max:128',
            'email' => 'required|email|unique:admins,email,' . $id,
            'password' => 'nullable|min:8|confirmed'
        ]);

        // Hash password jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($data['password']);
        } else {

        // Hapus field password dari data jika tidak diisi
            unset($data['password']);
        }

        $admin->update($data);

        return redirect()->route('admins.index')
            ->with('success','Admin berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $admin = Admin::findOrFail($id);

        //ga bisa hapus admin terakhir
        if (Admin::count() <= 1) {
            return back()->with('error', 'Tidak bisa menghapus admin terakhir!');
        }

        $admin->delete();

        return redirect()->route('admins.index')
            ->with('success','Admin berhasil di hapus');
    }
}
