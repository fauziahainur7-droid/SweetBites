@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')

@if(session('success'))
<div class="payment-notice payment-notice-success">
    <i class="bi bi-check-circle-fill"></i>
    <div>
        <strong>Informasi Pembayaran</strong>
        <p>{{ session('success') }}</p>
    </div>
</div>
@endif

@if($order->payment)
@if($order->payment->status === 'buram')
<div class="payment-notice payment-notice-warning">
    <i class="bi bi-exclamation-triangle-fill"></i>
    <div>
        <strong>Bukti Pembayaran Tidak Jelas</strong>
        <p>
            Bukti transfer kamu buram atau kurang jelas.
            Silakan unggah ulang bukti pembayaran yang bisa dibaca
            dengan jelas agar dapat diverifikasi oleh admin.
        </p>
        <a href="{{ route('payments.confirmation', $order->id) }}">
            Periksa Pembayaran
        </a>
    </div>
</div>

@elseif($order->payment->status === 'gagal')
<div class="payment-notice payment-notice-danger">
    <i class="bi bi-x-circle-fill"></i>
    <div>
        <strong>Pembayaran Ditolak</strong>
        <p>
            Bukti pembayaran kamu ditolak oleh admin.
            Silakan periksa kembali pembayaran dan unggah bukti
            yang benar, atau hubungi admin SweetBites.
        </p>
        <a href="{{ route('payments.confirmation', $order->id) }}">
            Periksa Pembayaran
        </a>
    </div>
</div>

@elseif($order->payment->status === 'lunas')
<div class="payment-notice payment-notice-success">
    <i class="bi bi-check-circle-fill"></i>
    <div>
        <strong>Pembayaran Terverifikasi</strong>
        <p>
            Pembayaran kamu berhasil diverifikasi.
            Pesanan sedang diproses oleh tim SweetBites.
        </p>
    </div>
</div>
@endif
@endif

<div class="order-detail-page">

    <main class="order-detail-container">

        {{-- Header halaman --}}
        <div class="order-page-top">

            <a href="{{ route('orders.index') }}" class="back-button">
                <i class="bi bi-arrow-left"></i>
                <span>Kembali</span>
            </a>

            <div class="verified-info">
                <i class="bi bi-patch-check-fill"></i>
                <span>Terverifikasi Otomatis oleh Sistem SweetBites</span>
            </div>

        </div>

        {{-- Judul --}}
        <div class="order-heading">

            <div>
                <h1>Detail Pesanan</h1>

                <p>
                    Pantau proses pembuatan roti artisan dan status
                    pengantaran bungkusan hangat Anda.
                </p>
            </div>

            <div class="order-time">
                Waktu Pemesanan:
                <strong>
                    {{ $order->created_at->format('d M Y, H:i') }} WIB
                </strong>
            </div>

        </div>


        <div class="order-layout">

            {{-- Kolom kiri --}}
            <div class="order-left">

                {{-- Informasi pesanan --}}
                <section class="order-card">

                    <div class="order-info-header">

                        <div>

                            <span class="reference-label">
                                NOMOR REFERENSI PESANAN
                            </span>

                            <div class="reference-code">

                                <strong>
                                    {{ $order->kode_pesanan }}
                                </strong>

                                <button
                                    type="button"
                                    class="copy-button"
                                    onclick="copyOrderCode()"
                                    title="Salin kode pesanan">
                                    <i class="bi bi-copy"></i>
                                </button>

                            </div>

                        </div>


                        <div class="order-status
                            @if($order->status == 'selesai')
                                status-selesai
                            @elseif($order->status == 'menunggu')
                                status-menunggu
                            @elseif($order->status == 'diproses')
                                status-diproses
                            @elseif($order->status == 'siap')
                                status-siap
                            @elseif($order->status == 'batal')
                                status-batal
                            @endif
                        ">

                            <span></span>

                            {{ ucfirst($order->status) }}

                        </div>

                    </div>


                    <div class="order-divider"></div>


                    <div class="order-meta">

                        {{-- Alamat --}}
                        <div class="meta-box">

                            <div class="meta-icon">
                                <i class="bi bi-geo-alt"></i>
                            </div>

                            <div class="meta-content">

                                <span>
                                    Alamat Pengiriman
                                </span>

                                <strong>
                                    {{ $order->alamat_pengirim }}
                                </strong>

                                <small>
                                    Alamat tujuan pesanan
                                </small>

                            </div>

                        </div>


                        {{-- Total --}}
                        <div class="meta-box">

                            <div class="meta-icon">
                                <i class="bi bi-wallet2"></i>
                            </div>

                            <div class="meta-content">

                                <span>
                                    Total Pembayaran
                                </span>

                                <strong class="payment-total">
                                    Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                </strong>

                                <small class="payment-note">
                                    Termasuk PPN & Kemasan Aman
                                </small>

                            </div>

                        </div>


                        {{-- Metode --}}
                        <div class="meta-box">

                            <div class="meta-icon">
                                <i class="bi bi-bank"></i>
                            </div>

                            <div class="meta-content">

                                <span>
                                    Metode Pembayaran
                                </span>

                                <strong>
                                    {{ $order->metode_pembayaran }}
                                </strong>

                                <small>
                                    Metode pembayaran pesanan
                                </small>

                            </div>

                        </div>

                    </div>

                </section>


                {{-- Pembayaran --}}
                @if($order->status == 'selesai')

                <div class="payment-alert">

                    <div class="payment-alert-icon">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>

                    <div>

                        <h3>
                            Pembayaran sudah lunas.
                        </h3>

                        <p>
                            Pembayaran kamu sudah diverifikasi oleh admin.
                            Pesanan sedang diproses oleh SweetBites.
                        </p>

                    </div>

                </div>

                @elseif($order->status == 'menunggu')

                <div class="payment-alert payment-waiting">

                    <div class="payment-alert-icon">
                        <i class="bi bi-clock-fill"></i>
                    </div>

                    <div>

                        <h3>
                            Pembayaran sedang diverifikasi.
                        </h3>

                        <p>
                            Pembayaran kamu sedang menunggu verifikasi
                            oleh admin SweetBites.
                        </p>

                    </div>

                </div>

                @endif


                {{-- Timeline --}}
                <section class="order-card timeline-card">

                    <div class="section-heading">

                        <div class="section-title">

                            <i class="bi bi-clock-history"></i>

                            <h2>
                                Status Perjalanan Kue & Roti
                            </h2>

                        </div>

                        <span class="arrival-badge">
                            Tiba Hari Ini
                        </span>

                    </div>


                    <div class="timeline">

                        {{-- Step 1 --}}
                        <div class="timeline-step completed">

                            <div class="timeline-circle">
                                <i class="bi bi-check"></i>
                            </div>

                            <div>
                                <strong>
                                    Pesanan Masuk
                                </strong>

                                <small>
                                    {{ $order->created_at->format('H:i') }} WIB
                                </small>
                            </div>

                        </div>


                        {{-- Step 2 --}}
                        <div class="timeline-step
                            {{ in_array($order->status, ['diproses', 'siap', 'selesai']) ? 'completed' : '' }}
                        ">

                            <div class="timeline-circle">

                                @if(in_array($order->status, ['diproses', 'siap', 'selesai']))
                                <i class="bi bi-check"></i>
                                @else
                                <i class="bi bi-circle"></i>
                                @endif

                            </div>

                            <div>

                                <strong>
                                    Terverifikasi
                                </strong>

                                <small>
                                    Pembayaran
                                </small>

                            </div>

                        </div>


                        {{-- Step 3 --}}
                        <div class="timeline-step
                            {{ in_array($order->status, ['siap', 'selesai']) ? 'completed' : '' }}
                        ">

                            <div class="timeline-circle">

                                @if(in_array($order->status, ['siap', 'selesai']))
                                <i class="bi bi-check"></i>
                                @else
                                <i class="bi bi-circle"></i>
                                @endif

                            </div>

                            <div>

                                <strong>
                                    Dipanggang Panas
                                </strong>

                                <small>
                                    Proses pembuatan
                                </small>

                            </div>

                        </div>


                        {{-- Step 4 --}}
                        <div class="timeline-step
                            {{ $order->status == 'selesai' ? 'active' : '' }}
                        ">

                            <div class="timeline-circle">

                                @if($order->status == 'selesai')
                                <i class="bi bi-check-all"></i>
                                @else
                                <i class="bi bi-circle"></i>
                                @endif

                            </div>

                            <div>

                                <strong>
                                    Selesai & Siap
                                </strong>

                                <small>
                                    Pesanan selesai
                                </small>

                            </div>

                        </div>

                    </div>

                </section>


                {{-- Item pesanan --}}
                <section class="order-card item-card">

                    <div class="item-header">

                        <div class="section-title">

                            <i class="bi bi-receipt"></i>

                            <h2>
                                Item Pesanan
                            </h2>

                        </div>

                        <span class="item-count">
                            {{ $order->orderDetails->count() }} Macam Hidangan
                        </span>

                    </div>


                    <div class="table-wrapper">

                        <table class="order-table">

                            <thead>

                                <tr>

                                    <th class="number-column">
                                        No
                                    </th>

                                    <th>
                                        Produk
                                    </th>

                                    <th class="quantity-column">
                                        Jumlah
                                    </th>

                                    <th class="price-column">
                                        Harga
                                    </th>

                                    <th class="price-column">
                                        Subtotal
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @foreach($order->orderDetails as $index => $detail)

                                <tr>

                                    <td class="number-column">
                                        {{ $index + 1 }}
                                    </td>


                                    <td>

                                        <div class="product-info">

                                            <div class="product-photo">

                                                @if($detail->product && $detail->product->gambar)

                                                <img
                                                    src="{{ asset('storage/products/' . $detail->product->gambar) }}"
                                                    alt="{{ $detail->product->nama_kue }}">

                                                @else

                                                <div class="no-product-photo">
                                                    <i class="bi bi-cake2"></i>
                                                </div>

                                                @endif

                                            </div>


                                            <div class="product-text">

                                                <strong>
                                                    {{ $detail->product->nama_kue }}
                                                </strong>

                                                <div class="product-tags">

                                                    <span>
                                                        SweetBites
                                                    </span>

                                                    <span>
                                                        Fresh Baked
                                                    </span>

                                                </div>

                                            </div>

                                        </div>

                                    </td>


                                    <td class="quantity-column">
                                        {{ $detail->jumlah }}
                                    </td>


                                    <td class="price-column">
                                        Rp {{ number_format($detail->harga, 0, ',', '.') }}
                                    </td>


                                    <td class="price-column subtotal">
                                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                    </td>

                                </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>


                    {{-- Total --}}
                    <div class="order-total">

                        <div class="total-box">

                            <div>
                                <span>
                                    Subtotal Produk
                                </span>

                                <strong>
                                    Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                </strong>
                            </div>


                            <div>
                                <span>
                                    Biaya Pengiriman
                                </span>

                                <strong class="free">
                                    Gratis Promo
                                </strong>
                            </div>


                            <div>
                                <span>
                                    Pajak & Wadah Kraft
                                </span>

                                <strong>
                                    Rp 0
                                </strong>
                            </div>


                            <div class="total-final">

                                <span>
                                    Total Pembayaran
                                </span>

                                <strong>
                                    Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                </strong>

                            </div>

                        </div>

                    </div>

                </section>

            </div>


            {{-- Kolom kanan --}}
            <aside class="order-right">

                {{-- Dokumen --}}
                <section class="sidebar-card document-card">

                    <div class="document-icon">
                        <i class="bi bi-printer"></i>
                    </div>

                    <h3>
                        Dokumen Pembelian
                    </h3>

                    <p>
                        Unduh bukti struk digital resmi SweetBites
                        untuk pembukuan atau klaim garansi produk.
                    </p>


                    <a
                        href="{{ route('orders.invoice', $order->id) }}"
                        class="invoice-button">
                        <i class="bi bi-printer"></i>
                        Cetak Invoice
                    </a>


                    <button
                        type="button"
                        class="contact-button">
                        <i class="bi bi-chat"></i>
                        Hubungi Dapur Bakery
                    </button>


                    <a href="#" class="help-link">
                        <i class="bi bi-question-circle"></i>
                        Butuh bantuan pengiriman khusus?
                    </a>

                </section>


                {{-- Kesegaran --}}
                <section class="sidebar-card freshness-card">

                    <div class="sidebar-heading">

                        <i class="bi bi-leaf"></i>

                        <h3>
                            Petunjuk Kesegaran Pastry
                        </h3>

                    </div>


                    <p>
                        Kue kering dan brownies SweetBites dipanggang
                        menggunakan mentega Prancis asli tanpa pengawet
                        sintetis. Simpan pada suhu ruang tertutup rapat
                        hingga 7 hari atau panaskan dalam oven 160°C
                        selama 3 menit untuk tekstur terbaik.
                    </p>


                    <div class="organic-info">

                        <span>
                            100%
                        </span>

                        <strong>
                            Bahan Baku Organik & Halal
                        </strong>

                    </div>

                </section>


                {{-- Kurir --}}
                <section class="sidebar-card courier-card">

                    <i class="bi bi-bicycle courier-icon"></i>

                    <div>

                        <span class="courier-label">
                            KURIR PENGANTAR
                        </span>

                        <strong>
                            Bambang S. (Kurir Khusus SweetBites Express)
                        </strong>

                        <p>
                            Paket ditempatkan dalam thermal insulated bag.
                        </p>

                    </div>

                </section>

            </aside>

        </div>

    </main>

</div>

<script>
    function copyOrderCode() {

        const codeElement = document.querySelector('.reference-code strong');

        if (!codeElement) {
            return;
        }

        const code = codeElement.textContent.trim();

        navigator.clipboard.writeText(code).then(function() {

            const button = document.querySelector('.copy-button');

            if (!button) {
                return;
            }

            const oldIcon = button.innerHTML;

            button.innerHTML = '<i class="bi bi-check-lg"></i>';

            setTimeout(function() {
                button.innerHTML = oldIcon;
            }, 1500);

        }).catch(function() {

            alert('Kode pesanan: ' + code);

        });

    }
</script>
@endsection