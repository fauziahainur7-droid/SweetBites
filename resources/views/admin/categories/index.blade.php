@extends('layouts.admin')

@section('title', 'Manajemen Kategori')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Manajemen Kategori</h2>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-dark">+ Tambah Kategori</a>
</div>

<div class="card">
    <div class="card-body">
        <p>Total Kategori: {{ $categories->count() }}</p>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $cat)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $cat->nama_kategori }}</td>
                        <td>{{ $cat->deskripsi }}</td>
                        <td>
                            <a href="{{ route('admin.categories.show', $cat->id) }}" class="btn btn-info btn-sm">Detail</a>
                            <a href="{{ route('admin.categories.edit', $cat->id) }}" class="btn btn-dark btn-sm">Edit</a>
                            <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center">Belum ada kategori</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection