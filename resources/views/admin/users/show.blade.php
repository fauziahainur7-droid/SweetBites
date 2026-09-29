@extends('layouts.admin')

@section('title', 'Detail User')

@section('content')
<a href="{{ route('admin.users.index') }}" class="btn btn-secondary mb-3">← Kembali</a>

<div class="card">
    <div class="card-body">
        <h3>{{ $user->name }}</h3>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>No HP:</strong> {{ $user->no_hp }}</p>
        <p><strong>Alamat:</strong> {{ $user->alamat }}</p>
        <p><strong>Bergabung:</strong> {{ $user->created_at->format('d/m/Y') }}</p>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection