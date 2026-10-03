@extends('layouts.admin')

@section('title', 'Manajemen Pesanan')

@section('content')
<div class="orders-page">

    <!-- Header -->
    <div class="orders-header">
        <div class="orders-header-text">
            <h1>Manajemen Pesanan</h1>
            <p>Kelola, verifikasi, dan pantau status transaksi pemesanan bakery pelanggan secara real-time.</p>
        </div>

        <div class="orders-header-actions">
            <button type="button" class="btn-rekap" onclick="window.print()">
                <i class="bi bi-printer"></i>
                Cetak Rekap
            </button>

            <button type="button" class="btn-export" onclick="exportOrders()">
                <i class="bi bi-download"></i>
                Ekspor Data
            </button>
        </div>
    </div>


    <!-- Daftar Pesanan -->
    <div class="orders-card">

        <!-- Filter -->
        <div class="orders-filter-bar">

            <div class="orders-search">
                <i class="bi bi-search"></i>
                <input
                    type="text"
                    id="searchOrder"
                    placeholder="Cari No. Pesanan atau Pelanggan..."
                >
            </div>

            <div class="orders-select">
                <select id="statusFilter">
                    <option value="semua">Semua Status</option>
                    <option value="menunggu">Menunggu</option>
                    <option value="diproses">Diproses</option>
                    <option value="siap">Siap</option>
                    <option value="selesai">Selesai</option>
                    <option value="batal">Batal</option>
                </select>
                <i class="bi bi-chevron-down"></i>
            </div>

            <div class="orders-select date-select">
                <select id="dateFilter">
                    <option value="semua">Semua Tanggal</option>
                    <option value="hari">Hari Ini</option>
                    <option value="minggu">7 Hari Terakhir</option>
                    <option value="bulan">30 Hari Terakhir</option>
                </select>
                <i class="bi bi-calendar3"></i>
            </div>

            <div class="orders-count">
                Menampilkan
                <strong id="visibleCount">{{ $orders->count() }}</strong>
                dari
                <strong>{{ $orders->count() }}</strong>
                data
            </div>

            <button
                type="button"
                class="btn-refresh"
                onclick="resetOrderFilter()"
                title="Refresh"
            >
                <i class="bi bi-arrow-clockwise"></i>
            </button>

        </div>


        <!-- Table -->
        <div class="orders-table-wrapper">

            <table class="orders-table">

                <thead>
                    <tr>
                        <th class="col-no">NO</th>
                        <th>NO. PESANAN</th>
                        <th>TANGGAL &amp; WAKTU</th>
                        <th>PELANGGAN</th>
                        <th>TOTAL</th>
                        <th>STATUS</th>
                        <th class="col-action">AKSI</th>
                    </tr>
                </thead>

                <tbody id="ordersTableBody">

                    @forelse($orders as $order)

                        <tr
                            class="order-row"
                            data-order="{{ strtolower($order->kode_pesanan ?? '') }}"
                            data-customer="{{ strtolower($order->user->name ?? '') }}"
                            data-status="{{ strtolower($order->status) }}"
                            data-date="{{ optional($order->created_at)->format('Y-m-d') }}"
                        >

                            <!-- No -->
                            <td class="order-number">
                                {{ $loop->iteration }}
                            </td>


                            <!-- Kode Pesanan -->
                            <td>
                                <span class="order-code">
                                    {{ $order->kode_pesanan }}
                                </span>
                            </td>


                            <!-- Tanggal -->
                            <td>
                                <div class="order-date">
                                    <strong>
                                        {{ $order->created_at ? $order->created_at->format('d M Y') : '-' }}
                                    </strong>

                                    <span>
                                        {{ $order->created_at ? $order->created_at->format('H:i') : '-' }} WIB
                                    </span>
                                </div>
                            </td>


                            <!-- Pelanggan -->
                            <td>
                                <div class="customer-info">

                                    <div class="customer-avatar">
                                        {{ strtoupper(substr($order->user->name ?? 'P', 0, 1)) }}
                                    </div>

                                    <div class="customer-text">
                                        <strong>
                                            {{ $order->user->name ?? '-' }}
                                        </strong>

                                        @if(isset($order->user->email))
                                            <span>
                                                {{ $order->user->email }}
                                            </span>
                                        @endif
                                    </div>

                                </div>
                            </td>


                            <!-- Total -->
                            <td>
                                <strong class="order-total">
                                    Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                </strong>
                            </td>


                            <!-- Status -->
                            <td>

                                @if($order->status == 'menunggu')

                                    <span class="order-status status-waiting">
                                        <span class="status-dot"></span>
                                        Menunggu
                                    </span>

                                @elseif($order->status == 'diproses')

                                    <span class="order-status status-process">
                                        <span class="status-dot"></span>
                                        Diproses
                                    </span>

                                @elseif($order->status == 'siap')

                                    <span class="order-status status-ready">
                                        <span class="status-dot"></span>
                                        Siap
                                    </span>

                                @elseif($order->status == 'selesai')

                                    <span class="order-status status-success">
                                        <span class="status-dot"></span>
                                        Selesai
                                    </span>

                                @elseif($order->status == 'batal')

                                    <span class="order-status status-cancel">
                                        <span class="status-dot"></span>
                                        Batal
                                    </span>

                                @else

                                    <span class="order-status status-process">
                                        <span class="status-dot"></span>
                                        {{ ucfirst($order->status) }}
                                    </span>

                                @endif

                            </td>


                            <!-- Aksi -->
                            <td class="action-cell">

                                <a
                                    href="{{ route('admin.orders.show', $order->id) }}"
                                    class="btn-detail"
                                >
                                    Detail
                                    <i class="bi bi-chevron-right"></i>
                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="empty-orders">
                                <div class="empty-icon">
                                    <i class="bi bi-bag-x"></i>
                                </div>

                                <strong>Belum ada pesanan</strong>

                                <span>
                                    Pesanan pelanggan akan muncul di sini.
                                </span>
                            </td>
                        </tr>

                    @endforelse

                    <!-- Hasil pencarian kosong -->
                    <tr id="noSearchResult" style="display: none;">
                        <td colspan="7" class="empty-orders">
                            <div class="empty-icon">
                                <i class="bi bi-search"></i>
                            </div>

                            <strong>Pesanan tidak ditemukan</strong>

                            <span>
                                Coba ubah kata pencarian atau filter status.
                            </span>
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>


        <!-- Footer Table -->
        <div class="orders-footer">

            <div class="orders-footer-text">
                Menampilkan data pesanan
                <strong>{{ $orders->count() }}</strong>
                entri
            </div>

            @if(method_exists($orders, 'links'))

                <div class="orders-pagination">
                    {{ $orders->links() }}
                </div>

            @endif

        </div>

    </div>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('searchOrder');
    const statusFilter = document.getElementById('statusFilter');
    const dateFilter = document.getElementById('dateFilter');
    const rows = document.querySelectorAll('.order-row');
    const noSearchResult = document.getElementById('noSearchResult');
    const visibleCount = document.getElementById('visibleCount');

    function filterOrders() {

        const searchValue = searchInput.value.toLowerCase().trim();
        const statusValue = statusFilter.value;
        const dateValue = dateFilter.value;

        let totalVisible = 0;

        const today = new Date();
        today.setHours(0, 0, 0, 0);

        rows.forEach(function (row) {

            const orderCode = row.dataset.order || '';
            const customer = row.dataset.customer || '';
            const orderStatus = row.dataset.status || '';
            const orderDate = row.dataset.date || '';

            const matchSearch =
                orderCode.includes(searchValue) ||
                customer.includes(searchValue);

            const matchStatus =
                statusValue === 'semua' ||
                orderStatus === statusValue;

            let matchDate = true;

            if (dateValue !== 'semua' && orderDate) {

                const dateParts = orderDate.split('-');

                const itemDate = new Date(
                    parseInt(dateParts[0]),
                    parseInt(dateParts[1]) - 1,
                    parseInt(dateParts[2])
                );

                itemDate.setHours(0, 0, 0, 0);

                const difference =
                    (today - itemDate) / (1000 * 60 * 60 * 24);

                if (dateValue === 'hari') {
                    matchDate = difference === 0;
                }

                if (dateValue === 'minggu') {
                    matchDate = difference >= 0 && difference <= 7;
                }

                if (dateValue === 'bulan') {
                    matchDate = difference >= 0 && difference <= 30;
                }
            }

            if (matchSearch && matchStatus && matchDate) {

                row.style.display = '';
                totalVisible++;

            } else {

                row.style.display = 'none';

            }

        });

        visibleCount.textContent = totalVisible;

        if (noSearchResult) {

            noSearchResult.style.display =
                totalVisible === 0 ? 'table-row' : 'none';

        }

    }

    searchInput.addEventListener('input', filterOrders);
    statusFilter.addEventListener('change', filterOrders);
    dateFilter.addEventListener('change', filterOrders);

});


function resetOrderFilter() {

    document.getElementById('searchOrder').value = '';
    document.getElementById('statusFilter').value = 'semua';
    document.getElementById('dateFilter').value = 'semua';

    document.getElementById('searchOrder').dispatchEvent(
        new Event('input')
    );

}


function exportOrders() {

    const rows = document.querySelectorAll('.order-row');

    let csv = 'No,No Pesanan,Tanggal,Pelanggan,Total,Status\n';

    rows.forEach(function (row) {

        if (row.style.display === 'none') {
            return;
        }

        const cells = row.querySelectorAll('td');

        if (cells.length < 7) {
            return;
        }

        const no = cells[0].innerText.trim();
        const kode = cells[1].innerText.trim();
        const tanggal = cells[2].innerText
            .replace(/\n/g, ' ')
            .trim();
        const pelanggan = cells[3].innerText
            .replace(/\n/g, ' ')
            .trim();
        const total = cells[4].innerText.trim();
        const status = cells[5].innerText.trim();

        csv += `"${no}","${kode}","${tanggal}","${pelanggan}","${total}","${status}"\n`;
    });

    const blob = new Blob([csv], {
        type: 'text/csv;charset=utf-8;'
    });

    const url = URL.createObjectURL(blob);

    const link = document.createElement('a');

    link.href = url;
    link.download = 'data-pesanan-sweetbites.csv';

    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);

    URL.revokeObjectURL(url);
}
</script>

@endsection