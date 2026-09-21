@extends('layouts.app')

@section('title', 'Manajemen Produk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Manajemen Produk</h2>
    <a href="{{ route('admin.products.create') }}" class="btn btn-dark">+ Tambah Produk</a>
</div>

<div class="row mb-3">
    <div class="col-md-4">
        <select class="form-control">
            <option>Semua Kategori</option>
        </select>
    </div>
    <div class="col-md-4">
        <input type="text" class="form-control" placeholder="Cari Produk...">
    </div>
    <div class="col-md-4">
        <button class="btn btn-secondary">Cari</button>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Nama Kue</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $product->nama_kue }}</td>
                        <td>{{ $product->category->nama_kategori ?? '-' }}</td>
                        <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                        <td>{{ $product->stok }}</td>
                        <td>
                            <span class="badge bg-{{ $product->stok > 0 ? 'success' : 'danger' }}">
                                {{ $product->stok > 0 ? 'Aktif' : 'Habis' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-info btn-sm">Detail</a>
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-dark btn-sm">Edit</a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center">Belum ada produk</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $products->links() }}
    </div>
</div>
@endsection