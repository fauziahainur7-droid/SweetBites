<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cart;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('orderDetails.product')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'alamat_pengirim' => 'required',
            'metode_pengiriman' => 'required',
            'metode_pembayaran' => 'required',
        ]);

        $carts = Cart::with('produk')->where('user_id', Auth::id())->get();

        if ($carts->isEmpty()) {
            return back()->with('error', 'Keranjang kosong!');
        }

        // cek stok sbelum mulai transaksi
        foreach ($carts as $item) {
            if ($item->jumlah > $item->produk->stok) {
                return back()->with('error', "Stok {$item->produk->nama_kue} tidak cukup.");
            }
        }

        DB::beginTransaction();

        try {
            $totalHarga = $carts->sum(fn ($item) => $item->produk->harga * $item->jumlah);

            $order = Order::create([
                ...$data,
                'user_id' => Auth::id(),
                'kode_pesanan' => 'ORD-' . date('Ymd') . '-' . strtoupper(uniqid()),
                'status' => 'menunggu',
                'total_harga' => $totalHarga,
            ]);

            foreach ($carts as $item) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'produk_id' => $item->produk_id,
                    'jumlah' => $item->jumlah,
                    'harga' => $item->produk->harga,
                    'subtotal' => $item->produk->harga * $item->jumlah,
                ]);

                $item->produk->decrement('stok', $item->jumlah);
            }

            Cart::where('user_id', Auth::id())->delete();

            DB::commit();

            return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(int $id)
    {
        $order = Order::with('orderDetails.product', 'payment')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('orders.show', compact('order'));
    }

    // update status pesanan dri halaman admin
    public function update(Request $request,int $id)
    {
        $data = $request->validate([
            'status' => 'required|in:menunggu,diproses,siap,selesai,batal',
        ]);

        Order::findOrFail($id)->update($data);

        return redirect()->route('orders.index')->with('success', 'Status pesanan diperbarui!');
    }
}