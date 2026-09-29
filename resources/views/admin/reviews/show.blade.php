@extends('layouts.admin')

@section('title', 'Detail Review')

@section('content')
<div class="card">
    <div class="card-body">
        <h3>Detail Review</h3>
        <p><strong>User:</strong> {{ $review->user->name ?? '-' }}</p>
        <p><strong>Produk:</strong> {{ $review->product->nama_kue ?? '-' }}</p>
        <p><strong>Rating:</strong> 
            @for($i=1; $i<=5; $i++)
                <span class="{{ $i <= $review->rating ? 'text-dark' : 'text-muted' }}">⭐</span>
            @endfor
        </p>
        <p><strong>Komentar:</strong> {{ $review->komentar }}</p>
        <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection