@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="account-page">
    <div class="account-container">

        <div class="account-badge">
            <span class="badge-check">✓</span>
            Pengaturan Akun Pelanggan
        </div>

        <div class="account-heading">
            <h1>PROFIL SAYA</h1>
            <span class="heading-line"></span>
            <p>
                Kelola informasi data diri, kontak pengiriman pribadi,
                dan pembaruan kata sandi akun SweetBites Anda dengan aman.
            </p>
        </div>

        <div class="account-grid">

            <!-- INFORMASI DIRI -->
            <section class="account-card profile-card">

                <div class="account-card-heading">
                    <div class="account-icon">▤</div>

                    <div class="account-card-title">
                        <div class="title-with-badge">
                            <h2>INFORMASI DIRI</h2>
                            <span class="verified-badge">✓ Terverifikasi</span>
                        </div>
                        <p>Data pribadi dan alamat pengiriman pesanan.</p>
                    </div>
                </div>

                <form action="{{ route('profile.password.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="account-field">
                        <label for="name">Nama Lengkap</label>
                        <div class="account-input-wrap">
                            <span class="field-icon">♙</span>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name', auth()->user()->name) }}"
                                placeholder="Masukkan nama lengkap"
                                required
                            >
                        </div>
                        @error('name')
                            <small class="field-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="account-field">
                        <label for="email">Email</label>
                        <div class="account-input-wrap">
                            <span class="field-icon">✉</span>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email', auth()->user()->email) }}"
                                placeholder="Masukkan email"
                                required
                            >
                        </div>
                        @error('email')
                            <small class="field-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="account-field">
                        <label for="no_hp">Nomor HP / WhatsApp</label>
                        <div class="account-input-wrap">
                            <span class="field-icon">☎</span>
                            <input
                                type="text"
                                id="no_hp"
                                name="no_hp"
                                value="{{ old('no_hp', auth()->user()->no_hp) }}"
                                placeholder="Masukkan nomor HP"
                                required
                            >
                        </div>
                        @error('no_hp')
                            <small class="field-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="account-field">
                        <label for="alamat">Alamat Pengiriman Utama</label>
                        <div class="account-input-wrap address-input">
                            <span class="field-icon">⌖</span>
                            <textarea
                                id="alamat"
                                name="alamat"
                                rows="2"
                                placeholder="Masukkan alamat lengkap"
                                required
                            >{{ old('alamat', auth()->user()->alamat) }}</textarea>
                        </div>
                        @error('alamat')
                            <small class="field-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="account-actions">
                        <button type="submit" class="account-btn btn-save">
                            <span>✓</span> Simpan Perubahan
                        </button>

                        <a href="{{ route('home') }}"
                           class="account-btn btn-cancel">
                            Batal
                        </a>
                    </div>
                </form>
            </section>

            <!-- UBAH PASSWORD -->
            <section class="account-card password-card">

                <div class="account-card-heading">
                    <div class="account-icon">♙</div>

                    <div class="account-card-title">
                        <h2>UBAH PASSWORD</h2>
                        <p>Perbarui keamanan akun dengan aman.</p>
                    </div>
                </div>

                <form action="{{ route('profile.password.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="account-field">
                        <label for="current_password">Password Saat Ini</label>
                        <div class="account-input-wrap">
                            <span class="field-icon">♙</span>
                            <input
                                type="password"
                                id="current_password"
                                name="current_password"
                                placeholder="Masukkan password saat ini"
                                autocomplete="current-password"
                                required
                            >
                        </div>
                        @error('current_password')
                            <small class="field-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="account-field password-field">
                        <label for="password">Password Baru</label>
                        <div class="account-input-wrap">
                            <span class="field-icon">♙</span>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Masukkan password baru"
                                autocomplete="new-password"
                                minlength="8"
                                required
                            >
                        </div>
                        @error('password')
                            <small class="field-error">{{ $message }}</small>
                        @enderror

                        <div class="password-hint">
                            <span>ⓘ</span>
                            <p>
                                Minimal 8 karakter dengan kombinasi
                                angka dan simbol.
                            </p>
                        </div>
                    </div>

                    <div class="account-field">
                        <label for="password_confirmation">
                            Konfirmasi Password
                        </label>
                        <div class="account-input-wrap">
                            <span class="field-icon">♙</span>
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                placeholder="Konfirmasi password baru"
                                autocomplete="new-password"
                                minlength="8"
                                required
                            >
                        </div>
                    </div>

                    <div class="security-notice">
                        <span class="security-icon">♢</span>
                        <p>
                            Setelah password diperbarui, Anda akan tetap
                            masuk di perangkat ini.
                        </p>
                    </div>

                    <div class="account-actions password-actions">
                        <button type="submit"
                                class="account-btn btn-password">
                            <span>♙</span> Simpan Password
                        </button>

                        <a href="{{ route('home') }}"
                           class="account-btn btn-cancel">
                            Batal
                        </a>
                    </div>
                </form>
            </section>

        </div>
    </div>
</div>

@endsection