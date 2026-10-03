@extends('layouts.admin')

@section('title', 'Manajemen User')

@section('content')
<div class="user-management-page">

    <div class="user-breadcrumb">
        <a href="{{ url('/admin/dashboard') }}">Admin</a>
        <i class="bi bi-chevron-right"></i>
        <span>Manajemen User</span>
    </div>

    <div class="user-page-heading">
        <div class="user-heading-text">
            <h2>Manajemen User</h2>
            <p>Kelola akun pengelola toko dan daftar pelanggan terdaftar di SweetBites Bakery.</p>
        </div>

        <div class="user-heading-actions">
            <form action="{{ url('/admin/users') }}" method="GET" class="user-search-form">
                <i class="bi bi-search"></i>
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari user...">
                @if(request('search'))
                    <a href="{{ url('/admin/users') }}" class="user-clear-search" title="Hapus pencarian">
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </form>
        </div>
    </div>

    <div class="user-table-card">
        <div class="user-table-responsive">
            <table class="user-table">
                <thead>
                    <tr>
                        <th class="user-number-column">NO</th>
                        <th>NAMA</th>
                        <th>EMAIL</th>
                        <th>NO HP</th>
                        <th class="user-action-column">AKSI</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($users as $user)
                        @php
                            $isAdmin = \App\Models\Admin::where(
                                'email', $user->email
                            )->exists();
                        @endphp

                        <tr>
                            <td class="user-number">
                                {{ $users->firstItem() + $loop->index }}
                            </td>

                            <td>
                                <div class="user-name-cell">
                                    <span class="user-name">
                                        {{ $user->name }}
                                    </span>

                                    <span class="user-role {{ $isAdmin ? 'role-admin' : 'role-customer' }}">
                                        {{ $isAdmin ? 'Admin' : 'Pelanggan' }}
                                    </span>
                                </div>
                            </td>

                            <td class="user-email">
                                {{ $user->email }}
                            </td>

                            <td class="user-phone">
                                {{ $user->no_hp ?: '-' }}
                            </td>

                            <td>
                                <a href="{{ url('/admin/users/' . $user->id) }}"
                                   class="user-detail-button">
                                    <i class="bi bi-eye"></i>
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="user-empty">
                                <i class="bi bi-people"></i>
                                <strong>User tidak ditemukan</strong>
                                <span>Coba kata kunci pencarian yang lain.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($users, 'total'))
            <div class="user-table-footer">
                <div class="user-pagination-info">
                    @if($users->total() > 0)
                        Menampilkan
                        <strong>{{ $users->firstItem() }}</strong>
                        -
                        <strong>{{ $users->lastItem() }}</strong>
                        dari
                        <strong>{{ $users->total() }}</strong>
                        user terdaftar
                    @else
                        Tidak ada user terdaftar
                    @endif
                </div>

                <div class="user-pagination">
                    {{ $users->onEachSide(1)->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>

</div>
@endsection