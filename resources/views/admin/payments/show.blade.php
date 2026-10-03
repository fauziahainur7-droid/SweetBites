@extends('layouts.admin')

@section('title', 'Detail Pembayaran')

@section('content')
@php
$metode = strtolower(trim($payment->metode_pembayaran ?? ''));

$isCod = $metode === 'cod';

$isWallet = in_array($metode, [
'e-wallet',
'ewallet',
'dompet digital',
'dana',
'ovo',
'gopay',
'shopeepay',
], true);

$statusLabel = match ($payment->status ?? '') {
'lunas' => 'Lunas / Terverifikasi',
'gagal' => 'Gagal / Ditolak',
'menunggu' => 'Menunggu Verifikasi',
'verifikasi' => 'Sedang Diverifikasi',
default => ucfirst($payment->status ?? 'Belum diketahui'),
};
@endphp

<div class="pd-page">

    <header class="pd-topbar">
        <a
            class="back-button"
            href="{{ route('admin.payments.index') }}">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali ke Daftar Pembayaran
        </a>

        <span class="pd-status-pill
            {{ $payment->status === 'lunas'
                ? 'is-success'
                : ($payment->status === 'gagal' ? 'is-danger' : 'is-warning') }}">
            {{ $statusLabel }}
        </span>
    </header>

    <main class="pd-main">

        {{-- RINGKASAN PEMBAYARAN --}}
        <section class="pd-card pd-summary">

            <div class="pd-summary-head">
                <div>
                    <span class="pd-eyebrow">SWEETBITES ADMIN</span>
                    <h1 class="pd-title">Detail Pembayaran</h1>
                    <p class="pd-subtitle">
                        Informasi pembayaran dan pesanan pelanggan.
                    </p>
                </div>
            </div>

            <div class="pd-metrics">

                <div class="pd-metric">
                    <span class="pd-metric-label">Nomor Pesanan</span>
                    <strong>
                        {{ $payment->order->kode_pesanan ?? '-' }}
                    </strong>
                </div>

                <div class="pd-metric">
                    <span class="pd-metric-label">Pelanggan</span>
                    <strong>
                        {{ $payment->order->user->name ?? '-' }}
                    </strong>
                    <small>
                        {{ $payment->order->user->email ?? '-' }}
                    </small>
                </div>

                <div class="pd-metric">
                    <span class="pd-metric-label">Metode Pembayaran</span>

                    <strong>
                        {{ $payment->metode_pembayaran ?? '-' }}
                    </strong>

                    <small>
                        @if($isCod)
                        Bayar di tempat
                        @elseif($isWallet)
                        Pembayaran melalui dompet digital
                        @else
                        Transfer ke rekening toko
                        @endif
                    </small>
                </div>

                <div class="pd-metric pd-metric-total">
                    <span class="pd-metric-label">Total Tagihan</span>
                    <strong>
                        Rp {{ number_format($payment->total_bayar, 0, ',', '.') }}
                    </strong>
                </div>

            </div>
        </section>

        {{-- DETAIL PEMBAYARAN --}}
        <div class="pd-grid">

            {{-- KOLOM KIRI --}}
            <section class="pd-card">

                <div class="pd-card-heading">
                    <div>
                        <h2>
                            {{ $isCod ? 'Informasi Pembayaran COD' : 'Bukti Pembayaran' }}
                        </h2>

                        <p>
                            @if($isCod)
                            Pembayaran dilakukan ketika pesanan diterima pelanggan.
                            @else
                            Periksa bukti pembayaran yang diunggah pelanggan.
                            @endif
                        </p>
                    </div>
                </div>

                <div class="pd-card-body">

                    @if($isCod)

                    <div class="pd-info-box pd-info-cod">
                        <div class="pd-info-icon">COD</div>

                        <div>
                            <h3>Bayar di Tempat</h3>
                            <p>
                                Pesanan menggunakan metode COD.
                                Pelanggan membayar ketika pesanan diterima.
                                Bukti transfer tidak diperlukan.
                            </p>
                        </div>
                    </div>

                    <div class="pd-detail-row">
                        <span>Status Pembayaran</span>
                        <strong>{{ $statusLabel }}</strong>
                    </div>

                    <div class="pd-detail-row">
                        <span>Status Pesanan</span>
                        <strong>
                            {{ ucfirst($payment->order->status ?? '-') }}
                        </strong>
                    </div>

                    @else

                    @if($payment->bukti_pembayaran)

                    <div class="pd-proof-frame">
                        <img
                            src="{{ route('admin.payments.proof', ['id' => $payment->id]) }}?v={{ $payment->updated_at->timestamp }}"
                            alt="Bukti pembayaran pelanggan"
                            class="pd-proof-img">
                    </div>

                    <div class="pd-proof-actions">

                        <a
                            href="{{ route('admin.payments.proof', ['id' => $payment->id]) }}"
                            target="_blank"
                            rel="noopener"
                            class="pd-btn pd-btn-light">
                            Perbesar Bukti
                        </a>

                        <a
                            href="{{ route('admin.payments.proof', ['id' => $payment->id]) }}"
                            download
                            class="pd-btn pd-btn-light">
                            Unduh Bukti
                        </a>

                    </div>

                    @else

                    <div class="pd-info-box pd-info-warning">
                        <div class="pd-info-icon">!</div>

                        <div>
                            <h3>Bukti Belum Tersedia</h3>
                            <p>
                                Pelanggan belum mengunggah bukti pembayaran.
                                Periksa pembayaran sebelum melakukan verifikasi.
                            </p>
                        </div>
                    </div>

                    @endif

                    <div class="pd-detail-row">
                        <span>Status Pembayaran</span>
                        <strong>{{ $statusLabel }}</strong>
                    </div>

                    <div class="pd-detail-row">
                        <span>Metode</span>
                        <strong>
                            {{ $payment->metode_pembayaran ?? '-' }}
                        </strong>
                    </div>

                    @endif

                </div>
            </section>

            {{-- KOLOM KANAN --}}
            <section class="pd-card">

                <div class="pd-card-heading">
                    <div>
                        <h2>
                            {{ $isCod ? 'Informasi Pesanan' : 'Verifikasi Pembayaran' }}
                        </h2>

                        <p>
                            {{ $isCod
                                ? 'Periksa ringkasan pesanan pelanggan.'
                                : 'Perbarui status setelah memeriksa pembayaran.' }}
                        </p>
                    </div>
                </div>

                <div class="pd-card-body">

                    <div class="pd-detail-row">
                        <span>Tanggal Pembayaran</span>
                        <strong>
                            {{ optional($payment->created_at)->format('d-m-Y H:i') ?? '-' }}
                        </strong>
                    </div>

                    <div class="pd-detail-row">
                        <span>Total Tagihan</span>
                        <strong>
                            Rp {{ number_format($payment->total_bayar, 0, ',', '.') }}
                        </strong>
                    </div>

                    @if(!$isCod)

                    <form
                        action="{{ route('admin.payments.update-status', $payment->id) }}"
                        method="POST"
                        class="pd-form"
                        id="verifyForm">

                        @csrf
                        @method('PUT')

                        <div class="pd-field">
                            <label for="status">Status Pembayaran</label>

                            <select name="status" id="status" required>


                                <option value="lunas"
                                    @selected(old('status', $payment->status) === 'lunas')>
                                    Lunas / Terverifikasi
                                </option>

                                <option value="buram"
                                    @selected(old('status', $payment->status) === 'buram')>
                                    Bukti Tidak Jelas / Buram
                                </option>

                                <option value="gagal"
                                    @selected(old('status', $payment->status) === 'gagal')>
                                    Tolak Pembayaran
                                </option>

                            </select>

                            @error('status')
                            <small class="pd-error">{{ $message }}</small>
                            @enderror
                        </div>

                        <button type="submit" class="pd-btn pd-btn-primary">
                            <i class="fa-solid fa-check"></i>
                            Simpan Status Pembayaran
                        </button>

                    </form>

                    @else

                    <div class="pd-info-box pd-info-cod">
                        <div>
                            <h3>Pesanan menggunakan COD</h3>
                            <p>
                                Halaman ini tidak menampilkan formulir verifikasi
                                transfer karena pelanggan membayar di tempat.
                            </p>
                        </div>
                    </div>

                    @endif

                </div>
            </section>

        </div>
    </main>
</div>
@endsection