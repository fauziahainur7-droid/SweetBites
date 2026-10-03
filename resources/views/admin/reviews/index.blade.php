@extends('layouts.admin')

@section('title', 'Manajemen Review')

@section('content')
<div class="review-admin">

    {{-- Header --}}
    <div class="review-page-header">
        <div>
            <h1>Manajemen Review</h1>
            <p>Kelola umpan balik, rating produk, dan kepuasan pelanggan toko</p>
        </div>

        <div class="review-summary">
            <div class="review-summary-box">
                <span>Total Review</span>
                <strong>{{ $reviews->count() }} Ulasan</strong>
            </div>

            <div class="review-summary-box">
                <span>Rata-Rata Rating</span>
                @php
                    $averageRating = $reviews->count()
                        ? $reviews->avg('rating')
                        : 0;
                @endphp

                <div class="review-average">
                    <strong>{{ number_format($averageRating, 1) }}</strong>
                    <i class="fa-solid fa-star"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Search dan Filter --}}
    <div class="review-toolbar">
        <div class="review-search">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input
                type="text"
                id="reviewSearch"
                placeholder="Cari nama pelanggan, produk, atau komentar..."
            >
        </div>

        <div class="review-filter-group">
            <select id="reviewRatingFilter">
                <option value="">Semua Rating</option>
                <option value="5">★ 5 Bintang</option>
                <option value="4">★ 4 Bintang</option>
                <option value="3">★ 3 Bintang</option>
                <option value="2">★ 2 Bintang</option>
                <option value="1">★ 1 Bintang</option>
            </select>

            <select id="reviewSort">
                <option value="newest">Terbaru</option>
                <option value="highest">Rating Tertinggi</option>
                <option value="lowest">Rating Terendah</option>
            </select>
        </div>
    </div>

    {{-- Tabel Review --}}
    <div class="review-table-card">
        <div class="review-table-scroll">
            <table class="review-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Pelanggan</th>
                        <th>Produk</th>
                        <th>Rating</th>
                        <th>Komentar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody id="reviewTableBody">
                    @forelse($reviews as $review)
                        <tr
                            class="review-row"
                            data-rating="{{ $review->rating }}"
                            data-date="{{ $review->created_at ? $review->created_at->timestamp : 0 }}"
                        >
                            <td class="review-number">
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                <div class="review-customer">
                                    <div class="review-avatar">
                                        {{ strtoupper(substr($review->user->name ?? 'P', 0, 1)) }}
                                    </div>

                                    <div>
                                        <strong class="review-customer-name">
                                            {{ $review->user->name ?? '-' }}
                                        </strong>
                                        <span>Pelanggan SweetBites</span>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="review-product">
                                    <i class="fa-solid fa-cake-candles"></i>
                                    <span>{{ $review->product->nama_kue ?? '-' }}</span>
                                </div>
                            </td>

                            <td>
                                <div class="review-rating">
                                    <div class="review-stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fa-solid fa-star {{ $i <= $review->rating ? 'active' : '' }}"></i>
                                        @endfor
                                    </div>
                                    <span>{{ $review->rating }}/5</span>
                                </div>
                            </td>

                            <td class="review-comment">
                                {{ $review->komentar ?: '-' }}
                            </td>

                            <td>
                                <form
                                    action="{{ route('admin.reviews.destroy', $review->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus review ini?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="review-delete-button">
                                        <i class="fa-regular fa-trash-can"></i>
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr class="review-empty-row">
                            <td colspan="6">
                                Belum ada review pelanggan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer tabel --}}
        <div class="review-table-footer">
            <span>
                Menampilkan {{ $reviews->count() }} ulasan pelanggan
            </span>

            <span class="review-footer-brand">
                SweetBites
            </span>
        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('reviewSearch');
    const ratingFilter = document.getElementById('reviewRatingFilter');
    const sortSelect = document.getElementById('reviewSort');
    const tableBody = document.getElementById('reviewTableBody');

    function updateReviews() {
        const keyword = searchInput.value.toLowerCase().trim();
        const rating = ratingFilter.value;
        const rows = Array.from(
            tableBody.querySelectorAll('tr.review-row')
        );

        let visibleRows = rows.filter(function (row) {
            const matchesText = row.textContent.toLowerCase().includes(keyword);
            const matchesRating = !rating || row.dataset.rating === rating;

            return matchesText && matchesRating;
        });

        visibleRows.sort(function (a, b) {
            if (sortSelect.value === 'highest') {
                return Number(b.dataset.rating) - Number(a.dataset.rating);
            }

            if (sortSelect.value === 'lowest') {
                return Number(a.dataset.rating) - Number(b.dataset.rating);
            }

            return Number(b.dataset.date) - Number(a.dataset.date);
        });

        rows.forEach(function (row) {
            row.style.display = 'none';
        });

        visibleRows.forEach(function (row, index) {
            row.style.display = '';
            row.querySelector('.review-number').textContent = index + 1;
            tableBody.appendChild(row);
        });

        let emptyResult = tableBody.querySelector('.review-filter-empty');

        if (visibleRows.length === 0) {
            if (!emptyResult) {
                emptyResult = document.createElement('tr');
                emptyResult.className = 'review-filter-empty';
                emptyResult.innerHTML =
                    '<td colspan="6">Review tidak ditemukan.</td>';
                tableBody.appendChild(emptyResult);
            }
            emptyResult.style.display = '';
        } else if (emptyResult) {
            emptyResult.style.display = 'none';
        }
    }

    searchInput.addEventListener('input', updateReviews);
    ratingFilter.addEventListener('change', updateReviews);
    sortSelect.addEventListener('change', updateReviews);
});
</script>
@endsection