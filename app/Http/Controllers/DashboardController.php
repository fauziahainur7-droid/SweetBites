<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard admin dengan statistik
     */
    public function index()
    {
        // Statistik utama
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', 'selesai')->sum('total_harga');
        $totalUsers = User::where('email', '!=', 'admin@sweetbites.com')->count();

        // Statistik tambahan
        $ordersToday = Order::whereDate('created_at', today())->count();
        $pendingOrders = Order::where('status', 'menunggu')->count();
        $pendingPayments = Payment::where('status', 'menunggu')->count();

        // Produk terlaris (5 teratas)
        $bestSellers = Product::withCount('orderDetails')
            ->orderBy('order_details_count', 'desc')
            ->limit(5)
            ->get();

        // Pesanan terbaru (5 teratas)
        $recentOrders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Pendapatan per bulan (tahun ini)
        $monthlyRevenue = Order::where('status', 'selesai')
            ->whereYear('created_at', date('Y'))
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total_harga) as total')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalOrders',
            'totalRevenue',
            'totalUsers',
            'ordersToday',
            'pendingOrders',
            'pendingPayments',
            'bestSellers',
            'recentOrders',
            'monthlyRevenue'
        ));
    }
}