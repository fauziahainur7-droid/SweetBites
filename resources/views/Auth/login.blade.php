@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header text-center bg-dark text-white">
                <h4 class="mb-0"> SweetBites</h4>
                <small>Selamat Datang!</small>
            </div>
            <div class="card-body">
                <h5 class="text-center">Masuk ke Akun SweetBites Anda</h5>
                <form action="{{ route('login.process') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Ingat Saya</label>
                    </div>
                    <button type="submit" class="btn btn-dark w-100">Masuk</button>
                </form>
                <div class="mt-3 text-center">
                    <a href="{{ route('register') }}">Belum Punya Akun? Daftar Sekarang</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection