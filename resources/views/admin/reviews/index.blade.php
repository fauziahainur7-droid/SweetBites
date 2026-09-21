@extends('layouts.app')

@section('title', 'Manajemen Review')

@section('content')
<h2>Manajemen Review</h2>

<div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>User</th>
                    <th>Produk</th>
                    <th>Rating</th>
                    <th>Komentar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $review)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $review->user->name ?? '-' }}</td>
                        <td>{{ $review->product->nama_kue ?? '-' }}</td>
                        <td>
                            @for($i=1; $i<=5; $i++)
                                <span class="{{ $i <= $review->rating ? 'text-dark' : 'text-muted' }}">⭐</span>
                            @endfor
                        </td>
                        <td>{{ Str::limit($review->komentar, 30) }}</td>
                        <td>
                            <a href="{{ route('admin.reviews.show', $review->id) }}" class="btn btn-info btn-sm">Detail</a>
                            <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center">Belum ada review</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection