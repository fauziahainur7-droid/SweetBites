<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carts = Cart::where('user_id', Auth::id())->get();

        return view('cart.index',compact('carts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' =>'required|exists:products,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        // Cek stok
        $product = Product::find($data['product_id']);
        if ($product->stok < $data['jumlah']) {
            return back()->with('error', 'Stok tidak mencukupi!');
        }

        $data['user_id'] = Auth::id();

        // Cek apakah sudah ada di keranjang
        $existing = Cart::where('user_id', Auth::id())
            ->where('product_id', $data['product_id'])
            ->first();

        if ($existing) {
            $existing->increment('jumlah', $data['jumlah']);
        } else {
            Cart::create($data);
        }

        return redirect()->route('cart.index')
            ->with('success', 'Produk ditambahkan ke keranjang!');
    }

    public function update(Request $request, string $id)
    {
        $cart = Cart::where('user_id', Auth::id())->findOrFail($id);

        $data = $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        // Cek stok
        $product = Product::find($cart->product_id);
        if ($product->stok < $data['jumlah']) {
            return back()->with('error', 'Stok tidak mencukupi!');
        }

        $cart->update($data);

        return redirect()->route('cart.index')
            ->with('success', 'Keranjang diperbarui!');
    }

    public function destroy(string $id)
    {
        $cart = Cart::where('user_id', Auth::id())->findOrFail($id);
        $cart->delete();

        return redirect()->route('cart.index')
            ->with('success', 'Item dihapus dari keranjang!');
    }
}