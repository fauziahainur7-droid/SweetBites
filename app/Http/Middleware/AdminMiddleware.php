<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah user login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Cek apakah user adalah admin (cek di tabel admins)
        $admin = \App\Models\Admin::where('email', Auth::user()->email)->first();

        if (!$admin) {
            abort(403, 'Akses ditolak. Hanya untuk admin!');
        }

        return $next($request);
    }
}