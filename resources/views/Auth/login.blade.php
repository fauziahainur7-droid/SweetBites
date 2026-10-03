@extends('layouts.auth')

@section('title', 'Login - SweetBites')

@section('content')

<div class="login-page">
    <!-- FORM LOGIN -->
    <div class="login-card">

        <div class="login-header">

            <h1>SweetBites</h1>

            <p>Selamat Datang!</p>

        </div>

        <div class="login-body">

            <h2>Masuk ke Akun</h2>

            <p class="login-subtitle">
                Nikmati berbagai pilihan kue favoritmu
            </p>

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.process') }}" method="POST">

                @csrf

                <div class="login-input">

                    <label for="email">
                        Email
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="Masukkan email"
                        value="{{ old('email') }}"
                        required
                    >

                </div>

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

                <div class="login-options">

                    <label class="remember-me">

                        <input
                            type="checkbox"
                            name="remember"
                        >

                        <span>Ingat Saya</span>

                    </label>

                </div>

                <button
                    type="submit"
                    class="login-button"
                >
                    Masuk
                </button>

            </form>

            <div class="register-link">

                <span>Belum punya akun?</span>

                <a href="{{ route('register') }}">
                    Daftar Sekarang
                </a>

            </div>

        </div>

    </div>

    <!-- BAGIAN HIJAU BAWAH -->
    <div class="bakery-bottom">

        <div class="bottom-cookie">
            🍪
        </div>

        <div class="bottom-bread">
            🥖
        </div>

        <div class="bottom-cupcake">
            🧁
        </div>

        <div class="bottom-cake">
            🍰
        </div>

        <div class="bottom-text">
            <strong>SweetBites</strong>
            <span>Freshly Baked With Love</span>
        </div>

    </div>

</div>

@endsection