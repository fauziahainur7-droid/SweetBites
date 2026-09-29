@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
<h2>Edit Produk</h2>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label>Upload Foto</label>
                        <input type="file" name="gambar" class="form-control">
                        @if($product->gambar) <small>File: {{ $product->gambar }}</small> @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama_kue" class="form-control" value="{{ $product->nama_kue }}" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label>Kategori</label>
                        <select name="kategori_id" class="form-control" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $product->kategori_id == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label>Harga</label>
                        <input type="number" name="harga" class="form-control" value="{{ $product->harga }}" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label>Stok</label>
                        <input type="number" name="stok" class="form-control" value="{{ $product->stok }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3">{{ $product->deskripsi }}</textarea>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-dark">Update</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection