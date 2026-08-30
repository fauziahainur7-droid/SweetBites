@extends('layouts.app')

@section('content')

<h2>Tambah Produk</h2>

<form action="{{ route('products.store') }}" method="POST">
    @csrf

    <div>
        <label>Kategori</label>
        <select name="kategori_id" required>
            <option value="">-- Pilih Kategori --</option>

            @foreach ($categories as $category)
            <option value="{{ $category->id }}">
                {{ $category->nama_kategori }}
            </option>
            @endforeach
        </select>
    </div>

    <br>

    <div>
        <label>Nama Kue</label>
        <input
            type="text"
            name="nama_kue"
            value="{{ old('nama_kue') }}"
            required>
    </div>

    <br>

    <div>
        <label>Harga</label>
        <input
            type="number"
            name="harga"
            value="{{ old('harga') }}"
            required>
    </div>

    <br>

    <div>
        <label>Stok</label>
        <input
            type="number"
            name="stok"
            value="{{ old('stok') }}"
            required>
    </div>

    <br>

    <div>
        <label>Deskripsi</label>
        <textarea name="deskripsi">{{ old('deskripsi') }}</textarea>
    </div>

    <br>

    <div>
        <label>Gambar</label>
        <input type="text" name="gambar" value="{{ old('gambar') }}">
    </div>

    <br>

    <button type="submit">Simpan</button>

    <a href="{{ route('products.index') }}">
        Batal
    </a>

</form>

@endsection