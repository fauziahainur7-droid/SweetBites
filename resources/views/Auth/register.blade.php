@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header text-center bg-dark text-white">
                <h4 class="mb-0"> SweetBites</h4>
                <small>Buat Akun Baru</small>
            </div>
            <div class="card-body">
                <h5 class="text-center">Daftar dan Mulai Berbelanja!</h5>
                <form action="{{ route('register.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Nomor HP</label>
                        <input type="text" name="no_hp" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Alamat</label>
                        <textarea name="alamat" class="form-control" rows="2" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3 mt-2 form-check">
                        <input type="checkbox" class="form-check-input" id="terms" required>
                        <label class="form-check-label" for="terms">Saya Setuju dengan Syarat & Ketentuan</label>
                    </div>
                    <button type="submit" class="btn btn-dark w-100">Daftar</button>
                </form>
                <div class="mt-3 text-center">
                    <a href="{{ route('login') }}">Sudah Punya Akun? Login</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection