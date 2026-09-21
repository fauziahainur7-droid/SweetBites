@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<!-- HERO -->
<div class="text-center py-5 bg-light">
    <h1>SweetBites</h1>
    <p class="lead">"Rayakan Manisnya Kebahagiaan"</p>
    <p>Nikmati berbagai macam kue homemade berkualitas premium yang dibuat dengan bahan-bahan terbaik pilihan</p>
    <div class="mt-3">
        <a href="{{ route('catalog') }}" class="btn btn-dark">Belanja Sekarang</a>
        <a href="{{ route('catalog') }}" class="btn btn-outline-dark">Lihat Menu</a>
    </div>
</div>

<!-- STATS -->
<div class="row text-center my-5">
    <div class="col-md-3">
        <h2>89</h2>
        <p>Kue</p>
    </div>
    <div class="col-md-3">
        <h2>152</h2>
        <p>Pelanggan</p>
    </div>
    <div class="col-md-3">
        <h2>4.8</h2>
        <p>Rating</p>
    </div>
    <div class="col-md-3">
        <h2>12</h2>
        <p>Varian</p>
    </div>
</div>

<!-- KATEGORI POPULER -->
<div class="mt-4">

    <h4 class="mb-2">Kategori Populer</h4>

    <hr class="mt-0">

    <div class="d-flex flex-wrap gap-2 mb-4">

        @foreach($categories as $category)

            <a href="{{ route('catalog', ['category' => $category->id]) }}"
               class="btn btn-outline-dark">
                {{ $category->nama_kategori }}
            </a>

        @endforeach

    </div>

</div>

<!-- PRODUK UNGGULAN -->
<div class="row">
    <h3>Produk Unggulan</h3>
    @forelse($popularProducts ?? [] as $product)
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card">
            <div class="card-body text-center">
                <span style="font-size:3rem;">sweetbites</span>
                <h5 class="mt-2">{{ $product->nama_kue }}</h5>
                <div class="small">⭐ {{ $product->rating_avg ?? 4.5 }} ({{ $product->rating_count ?? 0 }})</div>
                <p class="fw-bold">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                <a href="{{ route('products.show', $product->id) }}" class="btn btn-dark btn-sm">Beli</a>
            </div>
        </div>
    </div>
    @empty
    <p class="text-muted">Belum ada produk</p>
    @endforelse
</div>

@endsection