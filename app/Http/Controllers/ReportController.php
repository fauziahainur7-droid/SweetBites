<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = Report::orderBy('created_at', 'desc')->get();

        // Statistik ringkasan
        $totalOrders = Order::count(); // Total semua pesanan
        $totalRevenue = Order::where('status', 'selesai')->sum('total_harga'); // Total pendapatan

        return view('reports.index', compact('reports', 'totalOrders', 'totalRevenue'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function generate(Request $request)
    {
         $data = $request->validate([
            'judul' => 'required|string|max:128',
            'periode_mulai' => 'required|date',
            'periode_selesai' => 'required|date|after_or_equal:perioe_mulai',
        ]);

        // Hitung total penjualan di periode yang dipilih
        $totalPenjualan = Order::whereBetween('created_at', [
            $data['periode_mulai'],
            Carbon::parse($data['periode_selesai'])->endOfDay()
        ])->where('status', 'selesai')
        ->sum('total_harga');

        $data['total_penjualan'] = $totalPenjualan;

        Report::create($data);

        return redirect()->route('reports.index')
            ->with('success','Laporan berhasil digenerate!');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $report = Report::findOrFail($id);

        $report->delete();

        return redirect()->route('reports.index')
            ->with('success','Laporan berhasil dihapus!');
    }
}
