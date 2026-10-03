@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<div class="login-page register-page">
    <!-- BACKGROUND HIJAU -->
    <div class="bakery-bottom"></div>


    <!-- REGISTER CARD -->
    <div class="login-card register-card">

        <!-- HEADER -->
        <div class="login-header">

            <h1>SweetBites</h1>

            <p>Buat Akun Baru</p>

        </div>


        <!-- BODY -->
        <div class="login-body">

            <h2>Daftar dan Mulai Berbelanja!</h2>

            <p class="login-subtitle">
                Buat akun untuk menikmati berbagai kue favorit SweetBites.
            </p>


            <form action="{{ route('register.store') }}" method="POST">

                @csrf


                <!-- NAMA -->
                <div class="login-input">

                    <label for="name">
                        Nama Lengkap
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Masukkan nama lengkap"
                        required
                    >

                    @error('name')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                <!-- EMAIL -->
                <div class="login-input">

                    <label for="email">
                        Email
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Masukkan email"
                        required
                    >

                    @error('email')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                <!-- NOMOR HP -->
                <div class="login-input">

                    <label for="no_hp">
                        Nomor HP
                    </label>

                    <input
                        type="text"
                        id="no_hp"
                        name="no_hp"
                        value="{{ old('no_hp') }}"
                        placeholder="Masukkan nomor HP"
                        required
                    >

                    @error('no_hp')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                <!-- ALAMAT -->
                <div class="login-input">

                    <label for="alamat">
                        Alamat
                    </label>

                    <textarea
                        id="alamat"
                        name="alamat"
                        rows="3"
                        placeholder="Masukkan alamat lengkap"
                        required
                    >{{ old('alamat') }}</textarea>

                    @error('alamat')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                <!-- PASSWORD -->
                <div class="register-password-row">

                    <div class="login-input">

                        <label for="password">
                            Password
                        </label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Masukkan password"
                            required
                        >

                    </div>


                    <div class="login-input">

                        <label for="password_confirmation">
                            Konfirmasi Password
                        </label>

                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="Ulangi password"
                            required
                        >

                    </div>

                </div>


                <!-- SYARAT -->
                <div class="register-terms">

                    <label>

                        <input
                            type="checkbox"
                            name="terms"
                            required
                        >

                        <span>
                            Saya Setuju dengan Syarat & Ketentuan
                        </span>

                    </label>

                </div>


                <!-- BUTTON -->
                <button
                    type="submit"
                    class="login-button"
                >
                    Daftar
                </button>


                <!-- LOGIN -->
                <div class="register-link">

                    Sudah Punya Akun?

                    <a href="{{ route('login') }}">
                        Login
                    </a>

                </div>

            </form>

        </div>

    </div>


    <!-- TEKS BAWAH -->
    <div class="bottom-text">

        <strong>SweetBites</strong>

        <span>
            Homemade bakery dengan rasa premium
        </span>

    </div>

</div>
@endsection