@extends('layouts.app')

@section('title', 'Konfirmasi Pesanan')

@section('content')

<div class="payment-page">


    {{-- Alert sesuai status pembayaran --}}
    @if (session('success'))
    <div class="payment-alert payment-alert-success">
        <div class="payment-alert-icon">
            <i class="bi bi-check-circle-fill"></i>
        </div>
        <div class="payment-alert-content">
            <div class="payment-alert-title">
                {{ session('success') }}
            </div>
        </div>
    </div>
    @elseif (session('error'))
    <div class="payment-alert payment-alert-error">
        <div class="payment-alert-icon">
            <i class="bi bi-exclamation-triangle-fill"></i>
        </div>
        <div class="payment-alert-content">
            <div class="payment-alert-title">
                {{ session('error') }}
            </div>
        </div>
    </div>
    @elseif ($order->payment && $order->payment->status === 'buram')
    <div class="payment-alert payment-alert-error">
        <div class="payment-alert-icon">
            <i class="bi bi-exclamation-triangle-fill"></i>
        </div>
        <div class="payment-alert-content">
            <div class="payment-alert-title">
                Bukti Pembayaran Kurang Jelas
            </div>
            <p class="payment-alert-desc">
                Bukti transfer kamu kurang jelas. Silakan unggah ulang
                foto bukti pembayaran yang lebih jelas.
            </p>
        </div>
    </div>
    @elseif ($order->payment && $order->payment->status === 'gagal')
    <div class="payment-alert payment-alert-error">
        <div class="payment-alert-icon">
            <i class="bi bi-x-circle-fill"></i>
        </div>
        <div class="payment-alert-content">
            <div class="payment-alert-title">
                Pembayaran Ditolak
            </div>
            <p class="payment-alert-desc">
                Pembayaran kamu ditolak oleh admin. Silakan periksa
                kembali bukti pembayaran dan unggah ulang.
            </p>
        </div>
    </div>
    @elseif ($order->payment && $order->payment->status === 'lunas')
    <div class="payment-alert payment-alert-success">
        <div class="payment-alert-icon">
            <i class="bi bi-check-circle-fill"></i>
        </div>
        <div class="payment-alert-content">
            <div class="payment-alert-title">
                Pembayaran Berhasil Diverifikasi
            </div>
            <p class="payment-alert-desc">
                Pembayaran kamu sudah dikonfirmasi. Pesanan sedang diproses.
            </p>
        </div>
    </div>
    @else
    <div class="payment-alert">
        <div class="payment-alert-icon">
            <i class="bi bi-bell-fill"></i>
        </div>
        <div class="payment-alert-content">
            <div class="payment-alert-title">
                Pesanan Berhasil Dicatat!
                <span class="payment-alert-badge">
                    <i class="bi bi-clock"></i> Menunggu Pembayaran
                </span>
            </div>
            <p class="payment-alert-desc">
                Silakan selesaikan pembayaran dan unggah bukti transfer
                agar pesanan kamu dapat diverifikasi.
            </p>
        </div>
    </div>
    @endif

    {{-- Layout 2 kolom --}}
    <div class="payment-layout">

        {{-- KIRI --}}
        <div class="payment-left">

            <div class="payment-card">
                {{-- Strip atas --}}
                <div class="payment-card-strip"></div>


                {{-- Icon centang --}}
                <div class="payment-check">
                    <i class="bi bi-check-lg"></i>
                </div>

                {{-- Judul --}}
                <h1 class="payment-title">Terima kasih telah berbelanja!</h1>
                <p class="payment-subtitle">
                    Pesanan Anda telah tercatat di dapur kami dan sedang menunggu konfirmasi pembayaran.
                </p>

                {{-- Detail pesanan --}}
                <div class="payment-details">

                    <div class="payment-row">
                        <span>Nomor Pesanan</span>
                        <div class="payment-order-wrapper">
                            <strong class="payment-order-code">{{ $order->kode_pesanan }}</strong>
                            <button type="button" class="payment-copy-mini" title="Salin">
                                <i class="bi bi-copy"></i>
                            </button>
                        </div>
                    </div>

                    <div class="payment-row">
                        <span>Metode Pengambilan</span>
                        <span class="payment-method">
                            <i class="bi bi-bag"></i>
                            {{ $order->metode_pengiriman }} (Pick-up Counter)
                        </span>
                    </div>

                    <div class="payment-row">
                        <span>Status Pesanan</span>
                        <span class="payment-status-badge">
                            <i class="bi bi-clock-fill"></i>
                            Menunggu Pembayaran
                        </span>
                    </div>

                    <div class="payment-divider"></div>

                    {{-- Total Tagihan --}}
                    <div class="payment-total-row">
                        <div>
                            <span class="payment-total-label">Total Tagihan</span>
                            <p class="payment-total-note">Termasuk pajak & pengemasan eco-box</p>
                        </div>
                        <strong class="payment-total-amount">
                            Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                        </strong>
                    </div>

                    <div class="payment-divider"></div>

                    {{-- Rincian Item --}}
                    <div class="payment-items">
                        <div class="payment-items-header">
                            <span>Rincian Item Kue ({{ $order->orderDetails->count() ?? 3 }} item)</span>
                            <i class="bi bi-chevron-down"></i>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Tombol bawah --}}
            <div class="payment-bottom">
                <a href="{{ route('orders.index') }}" class="btn-payment-riwayat">
                    Lihat Riwayat Pesanan
                </a>
                <a href="{{ route('home') }}" class="btn-payment-beranda">
                    Kembali ke Beranda
                </a>
            </div>

        </div>

        {{-- KANAN --}}
        <div class="payment-right">

            <div class="payment-card">

                {{-- Header --}}
                <div class="payment-instruction-header">
                    <div class="payment-instruction-title">
                        <i class="bi bi-bank2"></i>
                        Instruksi Transfer Bank
                    </div>
                    <div class="payment-deadline-badge">
                        <i class="bi bi-clock"></i>
                        24 Jam dari pemesanan
                    </div>
                </div>

                {{-- Bank card --}}
                <div class="payment-bank-card">
                    <div class="payment-bank-header">
                        <div class="payment-bank-logo">BCA</div>
                        <div class="payment-bank-info">
                            <strong>Bank Central Asia</strong>
                            <small>Transfer Antar Bank / Manual</small>
                        </div>
                    </div>

                    <div class="payment-account-section">
                        <span class="payment-account-label">NOMOR REKENING</span>
                        <div class="payment-account-row">
                            <strong class="payment-account-number">1234567890</strong>
                            <button type="button" class="payment-copy-btn">
                                <i class="bi bi-copy"></i>
                                Salin
                            </button>
                        </div>
                        <small class="payment-account-name">a/n SweetBites </small>
                    </div>

                    <div class="payment-transfer-total">
                        <span>Total Transfer Semua:</span>
                        <strong>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</strong>
                    </div>
                </div>

                {{-- Upload bukti --}}
                <h3 class="payment-upload-title">Unggah Bukti Transfer</h3>

                <form action="{{ route('payments.store') }}"
                    method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <input type="hidden" name="metode_pembayaran"
                        value="{{ $order->metode_pembayaran }}">
                    <input type="hidden" name="total_bayar"
                        value="{{ $order->total_harga }}">

                    <label class="payment-upload-box" for="bukti_pembayaran">
                        <div class="payment-upload-icon">
                            <i class="bi bi-cloud-arrow-up-fill"></i>
                        </div>

                        <strong>
                            @if ($order->payment &&
                            in_array($order->payment->status, ['buram', 'gagal']))
                            Pilih Bukti Pembayaran Baru
                            @else
                            Klik untuk pilih file bukti transfer
                            @endif
                        </strong>

                        <small>Format: JPG atau PNG, maksimal 2 MB</small>

                        <input type="file"
                            id="bukti_pembayaran"
                            name="bukti_pembayaran"
                            accept=".jpg,.jpeg,.png"
                            required
                            hidden>
                    </label>

                    <button type="submit" class="btn-submit-payment">
                        <i class="bi bi-send-fill"></i>
                        Kirim Bukti Pembayaran
                    </button>
                </form>

                {{-- Footer trust --}}
                <div class="payment-trust-footer">
                    <span>
                        <i class="bi bi-shield-check"></i>
                        Transaksi Aman
                    </span>
                    <span class="payment-dot">•</span>
                    <span>
                        Dijamin Fresh Bake
                    </span>
                </div>

            </div>

        </div>

    </div>

</div>

{{-- Script copy nomor rekening --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const copyBtn = document.querySelector('.payment-copy-btn');
        if (copyBtn) {
            copyBtn.addEventListener('click', function() {
                const num = document.querySelector('.payment-account-number').textContent.trim();
                navigator.clipboard.writeText(num).then(function() {
                    const originalHTML = copyBtn.innerHTML;
                    copyBtn.innerHTML = '<i class="bi bi-check-lg"></i> Tersalin!';
                    setTimeout(function() {
                        copyBtn.innerHTML = originalHTML;
                    }, 2000);
                });
            });
        }

        // Preview nama file
        const fileInput = document.getElementById('bukti_pembayaran');
        if (fileInput) {
            fileInput.addEventListener('change', function(e) {
                const fileName = e.target.files[0]?.name || '';
                const label = document.querySelector('.payment-upload-box strong');
                if (fileName) {
                    label.textContent = '📎 ' + fileName;
                }
            });
        }
    });
</script>

@endsection