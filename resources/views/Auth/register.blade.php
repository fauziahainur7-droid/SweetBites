@extends('layouts.app')

@section('content')

    <h2>Registrasi Pelanggan</h2>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('register.store') }}" method="POST">
        @csrf

        <div>
            <label>Nama</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>

        <div>
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div>
            <label>No. HP</label>
            <input type="text" name="no_hp" value="{{ old('no_hp') }}" required>
        </div>

        <div>
            <label>Alamat</label>
            <textarea name="alamat" required>{{ old('alamat') }}</textarea>
        </div>

        <div>
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <div>
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation" required>
        </div>

        <button type="submit">Daftar</button>
    </form>

    <p>
        Sudah punya akun?
        <a href="{{ route('login') }}">Login</a>
    </p>

@endsection