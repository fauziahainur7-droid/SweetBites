@extends('layouts.app')

@section('content')

<h2>Data Produk</h2>

<a href="{{ route('products.create') }}">
    + Tambah Produk
</a>

<br><br>

@if (session('success'))
<p>{{ session('success') }}</p>
@endif

<table border="1" cellpadding="10" cellspacing="0">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Kue</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Deskripsi</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($products as $product)

        <tr>
            <td>{{ $loop->iteration }}</td>

            <td>{{ $product->nama_kue }}</td>

            <td>{{ $product->kategori_id }}</td>

            <td>
                Rp {{ number_format($product->harga, 0, ',', '.') }}
            </td>

            <td>{{ $product->stok }}</td>

            <td>{{ $product->deskripsi }}</td>

            <td>
                <a href="{{ route('products.edit', $product->id) }}">
                    Edit
                </a>

                <form
                    action="{{ route('products.destroy', $product->id) }}"
                    method="POST"
                    style="display:inline;">
                    @csrf
                    @method('DELETE')

                    <button type="submit">
                        Hapus
                    </button>
                </form>
            </td>
        </tr>

        @empty

        <tr>
            <td colspan="7">
                Belum ada produk.
            </td>
        </tr>

        @endforelse
    </tbody>
</table>

@endsection