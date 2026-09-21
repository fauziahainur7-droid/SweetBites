@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
<h2>Manajemen User</h2>

<div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No HP</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->no_hp }}</td>
                        <td>
                            <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-dark btn-sm">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center">Belum ada user</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection