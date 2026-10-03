@extends('layouts.app')

@section('title', 'Riwayat Pesanan')

@section('content')
<div class="orders-page">

    <div class="orders-container">

        {{-- HEADER --}}
        <section class="orders-overview">

            <div class="orders-heading">

                <div class="orders-label">
                    AKTIVITAS PEMBELIAN
                </div>

                <h1>Riwayat Pesanan Saya</h1>

                <p>
                    Kelola, tinjau faktur, dan lacak sajian pesanan lezat Anda secara berkala.
                </p>

            </div>


            {{-- STATISTIK --}}
            <div class="orders-stat-grid">

                {{-- TOTAL PESANAN --}}
                <div class="orders-stat-card">

                    <div>
                        <span class="stat-title">
                            TOTAL PESANAN
                        </span>

                        <strong class="stat-number">
                            {{ $orders->count() }}
                        </strong>

                        <span class="stat-description">
                            Seluruh transaksi terdaftar
                        </span>
                    </div>

                    <div class="stat-icon">
                        <i class="bi bi-bag"></i>
                    </div>

                </div>


                {{-- MENUNGGU --}}
                <div class="orders-stat-card">

                    <div>
                        <span class="stat-title">
                            MENUNGGU
                        </span>

                        <strong class="stat-number">
                            {{ $orders->where('status', 'menunggu')->count() }}
                        </strong>

                        <span class="stat-description">
                            Pesanan perlu diproses
                        </span>
                    </div>

                    <div class="stat-icon">
                        <i class="bi bi-clock"></i>
                    </div>

                </div>


                {{-- TOTAL BELANJA --}}
                <div class="orders-stat-card">

                    <div>
                        <span class="stat-title">
                            TOTAL BELANJA
                        </span>

                        <strong class="stat-number stat-price">
                            Rp {{ number_format($orders->sum('total_harga'), 0, ',', '.') }}
                        </strong>

                        <span class="stat-description">
                            Semua transaksi
                        </span>
                    </div>

                    <div class="stat-icon">
                        <i class="bi bi-wallet2"></i>
                    </div>

                </div>

            </div>

        </section>


        {{-- CARD DAFTAR PESANAN --}}
        <section class="orders-list-card">

            {{-- SEARCH + FILTER --}}
            <div class="orders-toolbar">

                <div class="orders-toolbar-title">

                    <div class="orders-list-icon">
                        <i class="bi bi-receipt"></i>
                    </div>

                    <div>
                        <h2>Daftar Pesanan</h2>

                        <p>
                            Lihat semua transaksi kamu
                        </p>
                    </div>

                </div>


                <div class="orders-controls">

                    {{-- SEARCH --}}
                    <div class="orders-search">

                        <i class="bi bi-search"></i>

                        <input
                            type="text"
                            id="orderSearch"
                            placeholder="Cari nomor pesanan..."
                        >

                    </div>


                    {{-- FILTER STATUS --}}
                    <div class="orders-filter">

                        <select id="orderStatusFilter">

                            <option value="semua">
                                Semua Status
                            </option>

                            <option value="menunggu">
                                Menunggu
                            </option>

                            <option value="diproses">
                                Diproses
                            </option>

                            <option value="siap">
                                Siap
                            </option>

                            <option value="selesai">
                                Selesai
                            </option>

                            <option value="batal">
                                Batal
                            </option>

                        </select>

                        <i class="bi bi-chevron-down"></i>

                    </div>

                </div>

            </div>


            {{-- TABLE --}}
            <div class="orders-table-wrapper">

                <table class="orders-table">

                    <thead>

                        <tr>
                            <th class="column-no">NO</th>
                            <th>NOMOR PESANAN</th>
                            <th>TANGGAL</th>
                            <th>TOTAL</th>
                            <th class="column-status">STATUS</th>
                            <th class="column-action">AKSI</th>
                        </tr>

                    </thead>


                    <tbody>

                        @forelse($orders as $index => $order)

                            <tr
                                class="order-row"
                                data-order="{{ $order->kode_pesanan ?? 'ORD-' . str_pad($order->id, 6, '0', STR_PAD_LEFT) }} {{ $order->id }}"
                                data-status="{{ $order->status }}"
                            >

                                {{-- NO --}}
                                <td class="order-no">
                                    {{ $index + 1 }}.
                                </td>


                                {{-- NOMOR PESANAN --}}
                                <td class="order-number-cell">

                                    <div class="order-number-row">

                                        <span class="order-number">
                                            {{ $order->kode_pesanan ?? 'ORD-' . str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                                        </span>

                                        <button
                                            type="button"
                                            class="copy-order"
                                            title="Salin nomor pesanan"
                                            onclick="copyOrderNumber(this)"
                                        >
                                            <i class="bi bi-copy"></i>
                                        </button>

                                    </div>

                                    <div class="order-information">

                                        {{ $order->jumlah_item ?? $order->orderDetails->sum('jumlah') ?? 1 }}
                                        Item

                                        @if(!empty($order->metode_pembayaran))

                                            • {{ $order->metode_pembayaran }}

                                        @else

                                            • Pembayaran SweetBites

                                        @endif

                                    </div>

                                </td>


                                {{-- TANGGAL --}}
                                <td class="order-date">

                                    {{ $order->created_at->format('d M Y') }}

                                    <small>
                                        {{ $order->created_at->format('H:i') }}
                                    </small>

                                </td>


                                {{-- TOTAL --}}
                                <td class="order-total">

                                    Rp {{ number_format($order->total_harga, 0, ',', '.') }}

                                </td>


                                {{-- STATUS --}}
                                <td class="order-status-cell">

                                    @if($order->status == 'menunggu')

                                        <span class="order-status status-waiting">
                                            Menunggu
                                        </span>


                                    @elseif($order->status == 'diproses')

                                        <span class="order-status status-process">
                                            Diproses
                                        </span>


                                    @elseif($order->status == 'siap')

                                        <span class="order-status status-ready">
                                            Siap
                                        </span>


                                    @elseif($order->status == 'selesai')

                                        <span class="order-status status-success">
                                            <i class="bi bi-check-lg"></i>
                                            Selesai
                                        </span>


                                    @elseif($order->status == 'batal')

                                        <span class="order-status status-cancel">
                                            <span></span>
                                            Batal
                                        </span>


                                    @else

                                        <span class="order-status status-cancel">
                                            <span></span>
                                            {{ ucfirst($order->status) }}
                                        </span>

                                    @endif

                                </td>


                                {{-- AKSI --}}
                                <td class="order-actions">

                                    <div class="order-buttons">

                                        {{-- DETAIL --}}
                                        <a
                                            href="{{ route('orders.show', $order->id) }}"
                                            class="btn-order btn-detail"
                                        >
                                            Detail
                                        </a>


                                        {{-- CETAK INVOICE --}}
                                        <a
                                            href="{{ route('orders.invoice', $order->id) }}"
                                            class="btn-order btn-invoice"
                                        >
                                            Cetak Invoice
                                        </a>


                                        {{-- BERI ULASAN --}}
                                        @if($order->status == 'selesai')

                                            <a
                                                href="{{ route('reviews.create', $order->id) }}"
                                                class="btn-order btn-review"
                                            >
                                                Beri Ulasan
                                            </a>

                                        @endif

                                    </div>

                                </td>

                            </tr>


                        @empty

                            <tr>

                                <td colspan="6">

                                    <div class="empty-orders">

                                        <div class="empty-orders-icon">
                                            <i class="bi bi-bag-x"></i>
                                        </div>

                                        <h3>
                                            Belum Ada Pesanan
                                        </h3>

                                        <p>
                                            Kamu belum memiliki riwayat pesanan.
                                        </p>

                                        <a
                                            href="{{ url('/catalog') }}"
                                            class="empty-orders-button"
                                        >
                                            Lihat Katalog
                                        </a>

                                    </div>

                                </td>

                            </tr>

                        @endforelse


                        {{-- PESAN JIKA HASIL FILTER KOSONG --}}
                        <tr id="noOrderResult" style="display: none;">

                            <td colspan="6">

                                <div class="empty-orders">

                                    <div class="empty-orders-icon">
                                        <i class="bi bi-search"></i>
                                    </div>

                                    <h3>
                                        Pesanan Tidak Ditemukan
                                    </h3>

                                    <p>
                                        Tidak ada pesanan yang sesuai dengan pencarian atau filter.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>


            {{-- FOOTER TABLE --}}
            <div class="orders-table-footer">

                <div class="orders-summary">

                    <div class="summary-box">

                        <span>
                            Total Pesanan:
                        </span>

                        <strong>
                            {{ $orders->count() }}
                        </strong>

                    </div>


                    <span class="summary-divider">
                        |
                    </span>


                    <div class="summary-box">

                        <span>
                            Total Belanja:
                        </span>

                        <strong class="summary-price">
                            Rp {{ number_format($orders->sum('total_harga'), 0, ',', '.') }}
                        </strong>

                    </div>

                </div>

            </div>

        </section>

    </div>

</div>


{{-- JAVASCRIPT SEARCH + FILTER --}}
<script>

document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('orderSearch');

    const statusFilter = document.getElementById('orderStatusFilter');

    const orderRows = document.querySelectorAll('.order-row');

    const noOrderResult = document.getElementById('noOrderResult');


    function filterOrders() {

        const searchValue =
            searchInput.value.toLowerCase().trim();

        const statusValue =
            statusFilter.value.toLowerCase();

        let visibleOrders = 0;


        orderRows.forEach(function (row) {

            const orderData =
                row.dataset.order.toLowerCase();

            const orderStatus =
                row.dataset.status.toLowerCase();


            const matchSearch =
                orderData.includes(searchValue);


            const matchStatus =
                statusValue === 'semua' ||
                orderStatus === statusValue;


            if (matchSearch && matchStatus) {

                row.style.display = '';

                visibleOrders++;

            } else {

                row.style.display = 'none';

            }

        });


        if (noOrderResult) {

            noOrderResult.style.display =
                visibleOrders === 0 ? '' : 'none';

        }

    }


    searchInput.addEventListener(
        'input',
        filterOrders
    );


    statusFilter.addEventListener(
        'change',
        filterOrders
    );

});


/* COPY NOMOR PESANAN */
function copyOrderNumber(button) {

    const orderNumber =
        button
            .closest('.order-number-row')
            .querySelector('.order-number')
            .innerText
            .trim();


    navigator.clipboard.writeText(orderNumber)
        .then(function () {

            const originalIcon =
                button.innerHTML;


            button.innerHTML =
                '<i class="bi bi-check-lg"></i>';


            setTimeout(function () {

                button.innerHTML =
                    originalIcon;

            }, 1500);

        })
        .catch(function () {

            alert('Nomor pesanan: ' + orderNumber);

        });

}

</script>
@endsection