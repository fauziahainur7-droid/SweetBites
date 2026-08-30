<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil produk populer (rating tertinggi atau terbaru)
        $popularProducts = Product::with('category')
            ->where('stok', '>', 0)
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        // Ambil semua kategori dengan jumlah produk
        $categories = Category::withCount('products')->get();

        return view('home', compact('popularProducts', 'categories'));
    }

    public function catalog(Request $request)
    {
        $query = Product::with('category')->where('stok', '>', 0);

        if ($request->has('search') && $request->search) {
            $query->where('nama_kue', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category') && $request->category) {
            $query->where('kategori_id', $request->category);
        }

        $products = $query->paginate(8);
        $categories = Category::all();

        return view('catalog', compact('products', 'categories'));
    }
}