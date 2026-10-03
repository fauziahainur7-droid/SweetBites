@extends('layouts.admin')

@section('title', 'Manajemen Pembayaran')

@section('content')
<div class="pay-admin-page">

    {{-- Header --}}
    <div class="payment-header">
        <h1>Manajemen Pembayaran</h1>

        <div class="payment-toolbar">

            <div class="payment-search">
                <i class="bi bi-search"></i>
                <input
                    type="text"
                    id="paymentSearch"
                    placeholder="Cari pesanan atau nama pelanggan...">
            </div>

            <div class="payment-filters">
                <select id="statusFilter" class="payment-select">
                    <option value="all">Semua Status</option>
                    <option value="menunggu">Menunggu</option>
                    <option value="verifikasi">Verifikasi</option>
                    <option value="lunas">Lunas</option>
                    <option value="batal">Batal</option>
                </select>

                <span class="payment-count">
                    {{ $payments->count() }} Pembayaran Masuk
                </span>
            </div>

        </div>
    </div>

    {{-- Card Tabel --}}
    <div class="pay-admin-card">

        <div class="payment-table-wrapper">
            <table class="payment-table">
                <thead>
                    <tr>
                        <th style="width:60px;">NO</th>
                        <th style="width:220px;">NO. PESANAN</th>
                        <th>PELANGGAN</th>
                        <th style="width:140px;">TOTAL</th>
                        <th style="width:130px;">STATUS</th>
                        <th style="width:140px;">METODE</th>
                        <th style="width:280px;">AKSI</th>
                    </tr>
                </thead>
                <tbody id="paymentTableBody">

                    @forelse($payments as $payment)
                        @php
                            // 'gagal' (data lama) ditampilkan sebagai 'batal'
                            $statusKey = $payment->status === 'gagal' ? 'batal' : $payment->status;
                            $kode      = $payment->order->kode_pesanan ?? '-';
                            $nama      = $payment->order->user->name ?? '-';
                        @endphp
                        <tr
                            data-search="{{ mb_strtolower($kode . ' ' . $nama) }}"
                            data-status="{{ $statusKey }}">
                            <td class="cell-no">{{ $loop->iteration }}</td>
                            <td class="cell-code">{{ $kode }}</td>
                            <td class="cell-customer">{{ $nama }}</td>
                            <td class="cell-total">Rp {{ number_format($payment->total_bayar, 0, ',', '.') }}</td>
                            <td class="cell-status">
                                <span class="badge-status badge-{{ $statusKey }}">{{ ucfirst($statusKey) }}</span>
                            </td>
                            <td class="cell-method">{{ $payment->metode_pembayaran }}</td>
                            <td class="cell-action">
                                <div class="action-group">
                                    <a href="{{ route('admin.payments.show', $payment->id) }}" class="pay-btn-detail">Detail</a>

                                    <form action="{{ route('admin.payments.update-status', $payment->id) }}" method="POST" class="form-update">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" class="status-dropdown">
                                            @foreach(['menunggu' => 'Menunggu', 'verifikasi' => 'Verifikasi', 'lunas' => 'Lunas', 'batal' => 'Batal'] as $value => $label)
                                                <option value="{{ $value }}" @selected($statusKey === $value)>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn-update">Update</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="pay-admin-empty">
                                <i class="bi bi-credit-card-2-front"></i>
                                <strong>Belum ada pembayaran</strong>
                                <span>Pembayaran dari pelanggan akan muncul di sini.</span>
                            </td>
                        </tr>
                    @endforelse

                    {{-- Muncul saat hasil pencarian / filter kosong --}}
                    @if($payments->count())
                        <tr id="noResultRow" style="display:none;">
                            <td colspan="7" class="pay-admin-empty">
                                <i class="bi bi-search"></i>
                                <strong>Tidak ditemukan</strong>
                                <span>Coba kata kunci atau status yang lain.</span>
                            </td>
                        </tr>
                    @endif

                </tbody>
            </table>
        </div>

        {{-- Footer (tanpa paginator, karena pakai ->get()) --}}
        <div class="payment-footer">
            <span class="footer-info">
                Menampilkan <strong id="totalCountDisplay">{{ $payments->count() }}</strong> total pembayaran
            </span>
        </div>

    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput       = document.getElementById('paymentSearch');
        const statusFilter      = document.getElementById('statusFilter');
        const rows              = document.querySelectorAll('#paymentTableBody tr[data-search]');
        const noResultRow       = document.getElementById('noResultRow');
        const totalCountDisplay = document.getElementById('totalCountDisplay');

        function applyFilter() {
            const keyword = searchInput.value.toLowerCase().trim();
            const status  = statusFilter.value;
            let visible   = 0;

            rows.forEach(function (row) {
                const matchSearch = row.dataset.search.includes(keyword);
                const matchStatus = status === 'all' || row.dataset.status === status;
                const show = matchSearch && matchStatus;

                row.style.display = show ? '' : 'none';
                if (show) visible++;
            });

            if (noResultRow) noResultRow.style.display = visible === 0 ? '' : 'none';
            if (totalCountDisplay) totalCountDisplay.textContent = visible;
        }

        searchInput.addEventListener('input', applyFilter);
        statusFilter.addEventListener('change', applyFilter);
    });
</script>
@endsection