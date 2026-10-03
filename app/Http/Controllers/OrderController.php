<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cart;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // CUSTOMER: menampilkan daftar pesanan
    public function index()
    {
        $orders = Order::with('orderDetails.product')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view(
            'user.orders.index',
            compact('orders')
        );
    }


    // CUSTOMER: menampilkan detail pesanan
    public function show(int $id)
    {
        $order = Order::with([
            'orderDetails.product',
            'payment'
        ])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view(
            'user.orders.show',
            compact('order')
        );
    }


    // CUSTOMER: menampilkan invoice
    public function invoice(int $id)
    {
        $order = Order::with([
            'orderDetails.product',
            'user',
            'payment'
        ])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view(
            'user.orders.invoice',
            compact('order')
        );
    }


    // CUSTOMER: menampilkan halaman checkout
    public function checkout()
    {
        $carts = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($carts->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with(
                    'error',
                    'Keranjang masih kosong!'
                );
        }
        $subtotal = $carts->sum(function ($cart) {
            return $cart->product->harga * $cart->jumlah;
        });

        return view(
            'user.checkout.index',
            compact('carts', 'subtotal')
        );
    }


    // CUSTOMER: membuat pesanan
    public function store(Request $request)
    {
        // Validasi data dari halaman checkout
        $data = $request->validate([
            'alamat_pengirim' => 'required|string',

            'metode_pengiriman' => [
                'required',
                'in:Diantar,Ambil Sendiri'
            ],

            'metode_pembayaran' => [
                'required',
                'in:Bank Transfer,E-Wallet,COD'
            ],
        ]);


        // Mengambil keranjang milik pelanggan yang sedang login
        $carts = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();


        // Memastikan keranjang tidak kosong
        if ($carts->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with(
                    'error',
                    'Keranjang masih kosong!'
                );
        }


        DB::beginTransaction();


        try {

            $total = 0;


            // Mengecek stok dan menghitung total harga
            foreach ($carts as $cart) {

                if ($cart->product->stok < $cart->jumlah) {
                    throw new \Exception(
                        'Stok ' .
                            $cart->product->nama_kue .
                            ' tidak mencukupi.'
                    );
                }

                $total +=
                    $cart->product->harga *
                    $cart->jumlah;
            }


            // Membuat data pesanan
            $order = Order::create([
                'user_id' => Auth::id(),

                'kode_pesanan' =>
                'ORD-' .
                    date('YmdHis') .
                    '-' .
                    strtoupper(substr(uniqid(), -5)),

                'alamat_pengirim' =>
                $data['alamat_pengirim'],

                'metode_pengiriman' =>
                $data['metode_pengiriman'],

                'metode_pembayaran' =>
                $data['metode_pembayaran'],

                // COD langsung diproses.
                // Transfer dan E-Wallet menunggu pembayaran.
                'status' =>
                $data['metode_pembayaran'] === 'COD'
                    ? 'diproses'
                    : 'menunggu',

                'total_harga' => $total,
            ]);


            // Menyimpan detail setiap produk yang dibeli
            foreach ($carts as $cart) {

                OrderDetail::create([
                    'order_id' =>
                    $order->id,

                    'produk_id' =>
                    $cart->product_id,

                    'jumlah' =>
                    $cart->jumlah,

                    'harga' =>
                    $cart->product->harga,

                    'subtotal' =>
                    $cart->product->harga *
                        $cart->jumlah,
                ]);


                // Mengurangi stok sesuai jumlah yang dibeli
                $cart->product->decrement(
                    'stok',
                    $cart->jumlah
                );
            }

            // Menghapus semua isi keranjang setelah pesanan dibuat
            Cart::where(
                'user_id',
                Auth::id()
            )->delete();


            // Membuat data pembayaran untuk COD
            if ($data['metode_pembayaran'] === 'COD') {

                Payment::create([
                    'order_id' => $order->id,
                    'metode_pembayaran' => 'COD',
                    'total_bayar' => $total,
                    'bukti_pembayaran' => null,
                    'status' => 'menunggu',
                ]);
            }


            DB::commit();


            // COD tidak perlu upload bukti pembayaran
            if ($data['metode_pembayaran'] === 'COD') {

                return redirect()
                    ->route(
                        'orders.show',
                        $order->id
                    )
                    ->with(
                        'success',
                        'Pesanan berhasil dibuat!'
                    );
            }


            // Transfer dan E-Wallet masuk ke halaman pembayaran
            return redirect()
                ->route(
                    'payments.confirmation',
                    $order->id
                )
                ->with(
                    'success',
                    'Pesanan berhasil dibuat. Silakan upload bukti pembayaran.'
                );
        } catch (\Exception $e) {

            // Membatalkan transaksi jika terjadi kesalahan
            DB::rollBack();

            return back()
                ->with(
                    'error',
                    $e->getMessage()
                );
        }
    }


    // CUSTOMER: membatalkan pesanan
    public function cancel(int $id)
    {
        $order = Order::with('orderDetails')
            ->where('user_id', Auth::id())
            ->findOrFail($id);


        // Pesanan hanya dapat dibatalkan ketika masih menunggu
        if ($order->status !== 'menunggu') {
            return back()
                ->with(
                    'error',
                    'Pesanan tidak dapat dibatalkan karena sudah diproses.'
                );
        }


        DB::beginTransaction();


        try {

            // Mengembalikan stok produk yang dibatalkan
            foreach ($order->orderDetails as $detail) {

                $product = Product::find(
                    $detail->produk_id
                );

                if ($product) {
                    $product->increment(
                        'stok',
                        $detail->jumlah
                    );
                }
            }


            // Mengubah status pesanan menjadi batal
            $order->update([
                'status' => 'batal'
            ]);


            DB::commit();


            return redirect()
                ->route(
                    'orders.show',
                    $order->id
                )
                ->with(
                    'success',
                    'Pesanan berhasil dibatalkan.'
                );
        } catch (\Exception $e) {

            // Membatalkan transaksi jika terjadi kesalahan
            DB::rollBack();

            return back()
                ->with(
                    'error',
                    'Pesanan gagal dibatalkan.'
                );
        }
    }


    // ADMIN: menampilkan semua pesanan
    public function indexAdmin()
    {
        $orders = Order::latest()
            ->paginate(10);

        return view(
            'admin.orders.index',
            compact('orders')
        );
    }


    // ADMIN: menampilkan detail pesanan
    public function showAdmin(int $id)
    {
        $order = Order::with([
            'orderDetails.product',
            'user',
            'payment'
        ])
            ->findOrFail($id);

        return view(
            'admin.orders.show',
            compact('order')
        );
    }


    // ADMIN: memperbarui status pesanan
    public function update(
        Request $request,
        int $id
    ) {
        $data = $request->validate([
            'status' => [
                'required',
                'in:menunggu,diproses,siap,selesai,batal'
            ],
        ]);


        $order = Order::findOrFail($id);


        // Mengubah status pesanan sesuai pilihan admin
        $order->update([
            'status' => $data['status']
        ]);


        return redirect()
            ->route(
                'admin.orders.show',
                $order->id
            )
            ->with(
                'success',
                'Status pesanan berhasil diperbarui!'
            );
    }
}
