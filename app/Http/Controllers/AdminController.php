<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::latest()->get();

        return view(
            'admins.index',
            compact('admins')
        );
    }

    public function create()
    {
        return view('admins.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' =>
                'required|string|max:128',

            'email' =>
                'required|email|unique:admins,email',

            'password' =>
                'required|min:6|confirmed',
        ]);

        $data['password'] =
            Hash::make($data['password']);

        Admin::create($data);

        return redirect()
            ->route('admin.admins.index')
            ->with(
                'success',
                'Admin berhasil ditambahkan!'
            );
    }

    public function show(int $id)
    {
        $admin = Admin::findOrFail($id);

        return view(
            'admins.show',
            compact('admin')
        );
    }

    public function edit(int $id)
    {
        $admin = Admin::findOrFail($id);

        return view(
            'admins.edit',
            compact('admin')
        );
    }

    public function update(Request $request,int $id)
    {
        $admin = Admin::findOrFail($id);

        $data = $request->validate([
            'name' =>
                'required|string|max:128',

            'email' =>
                'required|email|unique:admins,email,' . $id,

            'password' =>
                'nullable|min:6|confirmed',
        ]);

        if ($request->filled('password')) {

            $data['password'] =
                Hash::make($request->password);

        } else {

            unset($data['password']);
        }

        $admin->update($data);

        return redirect()
            ->route('admin.admins.index')
            ->with(
                'success',
                'Admin berhasil diperbarui!'
            );
    }

    public function destroy(int $id)
    {
        $admin = Admin::findOrFail($id);

        if (Admin::count() <= 1) {
            return back()->with(
                'error',
                'Admin terakhir tidak boleh dihapus!'
            );
        }

        $admin->delete();

        return redirect()
            ->route('admin.admins.index')
            ->with(
                'success',
                'Admin berhasil dihapus!'
            );
    }
}