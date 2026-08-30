@extends('layouts.app')

@section('content')

<h2>Edit Produk</h2>

<form action="{{ route('products.update', $product->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div>
        <label>Kategori</label>

        <select name="kategori_id" required>

            <option value="">-- Pilih Kategori --</option>

            @foreach ($categories as $category)
            <option
                value="{{ $category->id }}"
                {{ $product->kategori_id == $category->id ? 'selected' : '' }}>
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
            value="{{ old('nama_kue', $product->nama_kue) }}"
            required>
    </div>

    <br>

    <div>
        <label>Harga</label>

        <input
            type="number"
            name="harga"
            value="{{ old('harga', $product->harga) }}"
            required>
    </div>

    <br>

    <div>
        <label>Stok</label>

        <input
            type="number"
            name="stok"
            value="{{ old('stok', $product->stok) }}"
            required>
    </div>

    <br>

    <div>
        <label>Deskripsi</label>

        <textarea name="deskripsi">{{ old('deskripsi', $product->deskripsi) }}</textarea>
    </div>

    <br>

    <div>
        <label>Gambar</label>

        <input
            type="text"
            name="gambar"
            value="{{ old('gambar', $product->gambar) }}">
    </div>

    <br>

    <button type="submit">Update</button>

    <a href="{{ route('products.index') }}">
        Batal
    </a>

</form>

@endsection