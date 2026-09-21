<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // ADMIN: daftar review
    public function index()
    {
        $reviews = Review::with('user', 'product')
            ->latest()
            ->get();

        return view(
            'admin.reviews.index',
            compact('reviews')
        );
    }


    // ADMIN: detail review
    public function show(int $id)
    {
        $review = Review::with('user', 'product')
            ->findOrFail($id);

        return view(
            'admin.reviews.show',
            compact('review')
        );
    }


    // USER: halaman beri ulasan
    public function create(int $order_id)
    {
        // Ambil pesanan milik user yang sedang login
        // dan ambil semua produk di dalam pesanan
        $order = Order::with('orderDetails.product')
            ->where('user_id', Auth::id())
            ->findOrFail($order_id);


        // Hanya pesanan selesai yang boleh diberi ulasan
        if ($order->status !== 'selesai') {

            return redirect()
                ->route('orders.index')
                ->with(
                    'error',
                    'Ulasan hanya dapat diberikan setelah pesanan selesai.'
                );
        }


        // Pastikan pesanan mempunyai produk
        if ($order->orderDetails->isEmpty()) {

            return redirect()
                ->route('orders.index')
                ->with(
                    'error',
                    'Tidak ada produk pada pesanan ini.'
                );
        }


        // Ambil ID produk yang sudah pernah diulas
        $reviewedProducts = Review::where(
            'user_id',
            Auth::id()
        )
            ->whereIn(
                'produk_id',
                $order->orderDetails->pluck('produk_id')
            )
            ->pluck('produk_id')
            ->toArray();


        return view(
            'user.reviews.create',
            compact(
                'order',
                'reviewedProducts'
            )
        );
    }


    // USER: menyimpan ulasan
    public function store(Request $request)
    {
        $data = $request->validate([

            'order_id' => 'required|exists:orders,id',

            'produk_id' => 'required|exists:products,id',

            'rating' => 'required|integer|min:1|max:5',

            'komentar' => 'nullable|string|max:1000',

        ]);


        // Pastikan pesanan memang milik user
        // dan statusnya sudah selesai
        $order = Order::with('orderDetails')
            ->where('id', $data['order_id'])
            ->where('user_id', Auth::id())
            ->where('status', 'selesai')
            ->firstOrFail();


        // Pastikan produk memang ada di dalam pesanan
        $produkAda = $order->orderDetails->contains(
            'produk_id',
            $data['produk_id']
        );


        if (!$produkAda) {

            return back()
                ->with(
                    'error',
                    'Produk tidak termasuk dalam pesanan ini.'
                );
        }


        // Cek apakah produk sudah pernah diulas
        $existing = Review::where(
            'user_id',
            Auth::id()
        )
            ->where(
                'produk_id',
                $data['produk_id']
            )
            ->exists();


        if ($existing) {

            return back()
                ->with(
                    'error',
                    'Anda sudah memberikan ulasan untuk produk ini.'
                );
        }


        // Masukkan user yang sedang login
        $data['user_id'] = Auth::id();


        // Simpan review
        Review::create($data);


        return redirect()
            ->route(
                'orders.show',
                $order->id
            )
            ->with(
                'success',
                'Ulasan berhasil dikirim!'
            );
    }


    // ADMIN: hapus review
    public function destroy(int $id)
    {
        $review = Review::findOrFail($id);

        $review->delete();

        return back()
            ->with(
                'success',
                'Ulasan berhasil dihapus!'
            );
    }
}