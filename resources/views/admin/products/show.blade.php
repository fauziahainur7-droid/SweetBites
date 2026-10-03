@extends('layouts.app')

@section('title', 'Detail Produk (Admin)')

@section('content')
<a href="{{ route('products.index') }}" class="btn btn-secondary mb-3">← Kembali</a>

<div class="card">
    <div class="card-body">
        <h2>{{ $product->nama_kue }}</h2>
        <p><strong>Kategori:</strong> {{ $product->category->nama_kategori ?? '-' }}</p>
        <p><strong>Harga:</strong> Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
        <p><strong>Stok:</strong> {{ $product->stok }}</p>
        <p><strong>Deskripsi:</strong> {{ $product->deskripsi }}</p>

        @if($product->gambar)
            <img src="{{ asset('storage/products/' . $product->gambar) }}" style="max-width:200px;">
        @endif

        <!-- TOMBOL ADMIN -->
        <div class="mt-3">
            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-dark">Edit</a>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection