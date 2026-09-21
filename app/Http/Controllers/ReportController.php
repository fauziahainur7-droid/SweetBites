<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Menampilkan laporan dan statistik
     */
    public function index(Request $request)
    {
        // Ambil bulan yang dipilih
        // Kalau belum memilih, gunakan bulan sekarang
        $bulan = $request->bulan ?? date('Y-m');

        $tanggalMulai = Carbon::createFromFormat(
            'Y-m',
            $bulan
        )->startOfMonth();

        $tanggalSelesai = Carbon::createFromFormat(
            'Y-m',
            $bulan
        )->endOfMonth();

        // Ambil semua pesanan pada bulan yang dipilih
        $orders = Order::with('user')
            ->whereBetween('created_at', [
                $tanggalMulai,
                $tanggalSelesai
            ])
            ->latest()
            ->get();

        // Total pesanan
        $totalOrders = $orders->count();

        // Total pendapatan
        // Hanya pesanan yang sudah selesai
        $totalRevenue = $orders
            ->where('status', 'selesai')
            ->sum('total_harga');

        // Jumlah pelanggan yang melakukan pesanan
        $totalCustomers = $orders
            ->pluck('user_id')
            ->unique()
            ->count();

        // Kue terlaris pada bulan yang dipilih
        $bestSeller = OrderDetail::with('product')
            ->whereHas('order', function ($query) use (
                $tanggalMulai,
                $tanggalSelesai
            ) {
                $query->whereBetween('created_at', [
                    $tanggalMulai,
                    $tanggalSelesai
                ]);
            })
            ->selectRaw('produk_id, SUM(jumlah) as total_terjual')
            ->groupBy('produk_id')
            ->orderByDesc('total_terjual')
            ->first();

        // Data report yang sudah digenerate
        $reports = Report::orderBy(
            'created_at',
            'desc'
        )->get();

        return view(
            'admin.reports.index',
            compact(
                'reports',
                'orders',
                'totalOrders',
                'totalRevenue',
                'totalCustomers',
                'bestSeller',
                'bulan'
            )
        );
    }

    /**
     * Generate laporan
     */
    public function generate(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:128',
            'periode_mulai' => 'required|date',
            'periode_selesai' => 'required|date|after_or_equal:periode_mulai',
        ]);

        // Hitung total penjualan pada periode
        $totalPenjualan = Order::whereBetween('created_at', [
            $data['periode_mulai'],
            Carbon::parse($data['periode_selesai'])->endOfDay()
        ])
        ->where('status', 'selesai')
        ->sum('total_harga');

        $data['total_penjualan'] = $totalPenjualan;

        Report::create($data);

        return redirect()
            ->route('admin.reports.index')
            ->with(
                'success',
                'Laporan berhasil digenerate!'
            );
    }

    /**
     * Store
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Detail laporan
     */
    public function show(string $id)
    {
        $report = Report::findOrFail($id);

        return view(
            'admin.reports.show',
            compact('report')
        );
    }

    /**
     * Edit
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update
     */
    public function update(
        Request $request,
        string $id
    ) {
        //
    }

    /**
     * Hapus laporan
     */
    public function destroy(string $id)
    {
        $report = Report::findOrFail($id);

        $report->delete();

        return redirect()
            ->route('admin.reports.index')
            ->with(
                'success',
                'Laporan berhasil dihapus!'
            );
    }
}