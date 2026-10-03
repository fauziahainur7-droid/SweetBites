@extends('layouts.admin')

@section('title', 'Detail User')

@section('content')
<div class="user-detail-page">

    <div class="user-detail-breadcrumb">
        <a href="{{ url('/admin/dashboard') }}">Admin</a>
        <span>›</span>
        <a href="{{ route('admin.users.index') }}">Manajemen User</a>
        <span>›</span>
        <span>Detail User</span>
    </div>

    <div class="user-detail-heading">
        <div>
            <h2>Detail User</h2>
            <p>
                Informasi lengkap akun dan kontak pengguna
                terdaftar di SweetBites Bakery.
            </p>
        </div>

        <span class="user-active-badge">
            <span class="active-dot"></span>
            Akun Terdaftar
        </span>
    </div>

    <div class="user-detail-card">

        <div class="user-detail-profile">
            <div class="user-detail-avatar">
                {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
            </div>

            <div class="user-detail-identity">
                <h3>{{ $user->name }}</h3>

                <span class="user-detail-role {{ $isAdmin ? 'role-admin' : 'role-customer' }}">
                    {{ $isAdmin ? 'Admin' : 'Pelanggan' }}
                </span>

                <p class="user-detail-id">
                    ID: SB-{{ str_pad($user->id, 6, '0', STR_PAD_LEFT) }}
                </p>
            </div>
        </div>

        <div class="user-detail-divider"></div>

        <div class="user-detail-information">

            <div class="user-info-row">
                <span class="user-info-label">Nama Lengkap</span>
                <span class="user-info-value">
                    {{ $user->name ?? '-' }}
                </span>
            </div>

            <div class="user-info-row">
                <span class="user-info-label">Email</span>
                <span class="user-info-value">
                    {{ $user->email ?: '-' }}
                </span>
            </div>

            <div class="user-info-row">
                <span class="user-info-label">No. HP</span>
                <span class="user-info-value">
                    {{ $user->no_hp ?: '-' }}
                </span>
            </div>

            <div class="user-info-row">
                <span class="user-info-label">Alamat</span>
                <span class="user-info-value">
                    {{ $user->alamat ?: '-' }}
                </span>
            </div>

            <div class="user-info-row">
                <span class="user-info-label">Bergabung</span>
                <span class="user-info-value">
                    {{ $user->created_at ? $user->created_at->format('d/m/Y') : '-' }}
                </span>
            </div>

            <div class="user-info-row">
                <span class="user-info-label">Jenis Akun</span>
                <span class="user-info-value">
                    {{ $isAdmin ? 'Administrator' : 'Pelanggan SweetBites' }}
                </span>
            </div>

        </div>

        <div class="user-detail-divider"></div>

        <div class="user-detail-actions">
            <a href="{{ route('admin.users.index') }}" class="btn-user-back">
                Kembali
            </a>
        </div>

    </div>
</div>
@endsection