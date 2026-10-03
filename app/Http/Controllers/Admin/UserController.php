<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $adminEmails = \App\Models\Admin::query()
            ->pluck('email');

        $users = User::query()
            ->whereNotIn('email', $adminEmails)
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('no_hp', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function show(int $id)
    {
        $user = \App\Models\User::findOrFail($id);

        // Cek apakah user ini admin atau bukan
        $isAdmin = $user->role === 'admin'
            || $user->email === 'admin@sweetbites.com';   // ← sesuaikan caramu

        return view('admin.users.show', compact('user', 'isAdmin'));
    }
}
