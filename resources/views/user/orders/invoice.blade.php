@extends('layouts.app')

@section('title', 'Invoice Pesanan')

@section('content')

<div class="receipt-page">

    <div class="receipt-toolbar">
        <a href="{{ url()->previous() }}" class="receipt-back">
            &larr; Daftar Pesanan
        </a>

        <h1>Detail Struk</h1>

        <div class="receipt-toolbar-actions">

            <button type="button" class="receipt-action receipt-print"
                onclick="window.print()">
                Cetak Struk Sekarang
            </button>
        </div>
    </div>

    <div class="receipt-paper" id="receipt">

        {{-- HEADER TOKO --}}
        <header class="receipt-header">
            <div class="receipt-logo">
                <img src="{{ asset('images/logotoko1.png') }}"
                    alt="Logo SweetBites">
            </div>

            <h2>S W E E T B I T E S</h2>
            <p class="receipt-tagline">
                ARTISAN BAKERY &amp; SPECIALTY COOKIES
            </p>

            <div class="receipt-store-info">
                <p>SweetBites — Toko Kue dan Bakery</p>
                <p>Indonesia</p>
                <p>Terima kasih telah berbelanja di SweetBites.</p>
            </div>
        </header>

        <div class="receipt-divider"></div>

        {{-- INFORMASI TRANSAKSI --}}
        <section class="receipt-information">
            <div class="receipt-info-row">
                <span>No. Invoice</span>
                <strong>{{ $order->kode_pesanan }}</strong>
            </div>

            <div class="receipt-info-row">
                <span>Waktu Transaksi</span>
                <strong>
                    {{ optional($order->created_at)->format('d/m/Y H:i') ?? '-' }}
                </strong>
            </div>

            <div class="receipt-info-row">
                <span>Pelanggan</span>
                <strong>{{ $order->user->name ?? '-' }}</strong>
            </div>

            <div class="receipt-info-row">
                <span>No. Telepon</span>
                <strong>{{ $order->user->no_hp ?? '-' }}</strong>
            </div>

            <div class="receipt-info-row">
                <span>Alamat Pengiriman</span>
                <strong>{{ $order->alamat_pengirim ?? '-' }}</strong>
            </div>

            <div class="receipt-info-row">
                <span>Metode Pembayaran</span>
                <strong>
                    {{ $order->metode_pembayaran ?? '-' }}
                </strong>
            </div>

            <div class="receipt-info-row">
                <span>Status Pesanan</span>
                <strong class="receipt-status">
                    {{ ucfirst($order->status ?? '-') }}
                </strong>
            </div>
        </section>

        <div class="receipt-divider"></div>

        {{-- DAFTAR PRODUK --}}
        <section class="receipt-items">
            <h3>RINCIAN PESANAN</h3>

            <div class="receipt-table-wrap">
                <table class="receipt-table">
                    <thead>
                        <tr>
                            <th>Deskripsi Item</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($order->orderDetails as $detail)
                        <tr>
                            <td class="receipt-product-name">
                                {{ $detail->product->nama_kue ?? 'Produk' }}
                            </td>

                            <td>
                                {{ $detail->jumlah ?? 0 }}
                            </td>

                            <td>
                                Rp {{ number_format($detail->harga ?? 0, 0, ',', '.') }}
                            </td>

                            <td>
                                Rp {{ number_format(
                                        $detail->subtotal
                                            ?? (($detail->jumlah ?? 0) * ($detail->harga ?? 0)),
                                        0, ',', '.'
                                    ) }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="receipt-empty">
                                Belum ada rincian produk.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <div class="receipt-divider"></div>

        {{-- TOTAL --}}
        <section class="receipt-totals">
            <div class="receipt-total-row">
                <span>Total Produk</span>
                <strong>
                    Rp {{ number_format(
                        $order->orderDetails->sum(function ($detail) {
                            return $detail->subtotal
                                ?? (($detail->jumlah ?? 0) * ($detail->harga ?? 0));
                        }),
                        0, ',', '.'
                    ) }}
                </strong>
            </div>

            <div class="receipt-total-row receipt-grand-total">
                <span>TOTAL AKHIR</span>
                <strong>
                    Rp {{ number_format($order->total_harga ?? 0, 0, ',', '.') }}
                </strong>
            </div>
        </section>

        <div class="receipt-divider"></div>

        {{-- INFORMASI PEMBAYARAN --}}
        <section class="receipt-payment">
            <h3>INFORMASI PEMBAYARAN</h3>

            <div class="receipt-info-row">
                <span>Metode Bayar</span>
                <strong>{{ $order->metode_pembayaran ?? '-' }}</strong>
            </div>

            <div class="receipt-info-row">
                <span>Status Pembayaran</span>
                <strong>
                    {{ ucfirst($order->payment->status ?? $order->status ?? '-') }}
                </strong>
            </div>

            <div class="receipt-info-row">
                <span>Total Transaksi</span>
                <strong>
                    Rp {{ number_format($order->total_harga ?? 0, 0, ',', '.') }}
                </strong>
            </div>
        </section>

        <div class="receipt-divider"></div>

        {{-- BARCODE DEKORATIF --}}
        <div class="receipt-barcode-area">
            <div class="receipt-barcode" aria-label="Kode batang dekoratif"></div>

            <p class="receipt-invoice-code">
                {{ $order->kode_pesanan }}
            </p>
            <small>Nomor referensi pesanan</small>
        </div>

        {{-- FOOTER STRUK --}}
        <footer class="receipt-footer">
            <h3>Terima Kasih atas Pesanan Anda!</h3>

            <p>
                Setiap gigitan dibuat dengan sepenuh hati.
                Semoga hari Anda semakin manis bersama SweetBites.
            </p>

            <div class="receipt-footer-brand">
                SWEETBITES
            </div>

            <small>Dokumen transaksi SweetBites</small>
        </footer>

    </div>
</div>

@endsection