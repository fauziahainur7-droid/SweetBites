@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')

<div class="container mt-4 mb-5">

    <h2 class="mb-4">PROFIL SAYA</h2>

    <div class="row">

        <div class="col-md-6 mb-4">

            <div class="card h-100">
                <div class="card-body">

                    <h5>INFORMASI DIRI</h5>

                    <hr>

                    <form action="{{ route('profile.update') }}" method="POST">

                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">
                                Nama Lengkap
                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                value="{{ old('name', $user->name) }}"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Email
                            </label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                value="{{ old('email', $user->email) }}"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Nomor HP
                            </label>

                            <input
                                type="text"
                                name="no_hp"
                                class="form-control"
                                value="{{ old('no_hp', $user->no_hp) }}"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Alamat
                            </label>

                            <textarea
                                name="alamat"
                                class="form-control"
                                rows="3"
                                required
                            >{{ old('alamat', $user->alamat) }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-dark">
                            Simpan
                        </button>

                        <a href="{{ route('home') }}" class="btn btn-secondary">
                            Batal
                        </a>

                    </form>

                </div>
            </div>

        </div>


        <div class="col-md-6 mb-4">

            <div class="card h-100">
                <div class="card-body">

                    <h5>UBAH PASSWORD</h5>

                    <hr>

                    <form action="{{ route('profile.update') }}" method="POST">

                        @csrf
                        @method('PUT')

                        <input
                            type="hidden"
                            name="name"
                            value="{{ $user->name }}"
                        >

                        <input
                            type="hidden"
                            name="email"
                            value="{{ $user->email }}"
                        >

                        <input
                            type="hidden"
                            name="no_hp"
                            value="{{ $user->no_hp }}"
                        >

                        <input
                            type="hidden"
                            name="alamat"
                            value="{{ $user->alamat }}"
                        >

                        <div class="mb-3">
                            <label class="form-label">
                                Password Baru
                            </label>

                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                placeholder="Password baru"
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Konfirmasi Password
                            </label>

                            <input
                                type="password"
                                name="password_confirmation"
                                class="form-control"
                                placeholder="Konfirmasi password"
                            >
                        </div>

                        <button type="submit" class="btn btn-dark">
                            Simpan
                        </button>

                        <a href="{{ route('home') }}" class="btn btn-secondary">
                            Batal
                        </a>

                    </form>

                </div>
            </div>

        </div>

    </div>


    <div class="card mb-4">

        <div class="card-body">

            <h5>STATISTIK AKUN</h5>

            <hr>

            <div class="row text-center">

                <div class="col-md-4 mb-3">

                    <div class="border rounded p-4">

                        <h4>{{ $jumlahPesanan }}</h4>

                        <p class="mb-0">
                            Pesanan
                        </p>

                    </div>

                </div>

                <div class="col-md-4 mb-3">

                    <div class="border rounded p-4">

                        <h4>-</h4>

                        <p class="mb-0">
                            Rating
                        </p>

                    </div>

                </div>

                <div class="col-md-4 mb-3">

                    <div class="border rounded p-4">

                        <h4>-</h4>

                        <p class="mb-0">
                            Ulasan
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <div class="card">

        <div class="card-body">

            <h5>ALAMAT TERSAVE</h5>

            <hr>

            <strong>Alamat Utama</strong>

            <p class="mt-2 mb-0">
                {{ $user->alamat }}
            </p>

            <div class="mt-3">

                <a
                    href="{{ route('profile.edit') }}"
                    class="btn btn-sm btn-dark"
                >
                    Edit
                </a>

            </div>

        </div>

    </div>

</div>

@endsection