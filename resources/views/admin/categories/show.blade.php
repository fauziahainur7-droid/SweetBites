@extends('layouts.app')

@section('title', 'Detail Kategori')

@section('content')
<a href="{{ route('admin.categories.index') }}" class="btn btn-secondary mb-3">← Kembali</a>

<div class="card">
    <div class="card-body">
        <h2>{{ $category->nama_kategori }}</h2>
        <p><strong>Deskripsi:</strong> {{ $category->deskripsi }}</p>
        <p><strong>Jumlah Produk:</strong> {{ $category->products->count() }}</p>
        <div class="mt-3">
            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-dark">Edit</a>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection