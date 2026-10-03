<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // ADMIN - daftar produk
    public function index()
    {
        $products = Product::with('category')
            ->latest()
            ->get();

        $totalProducts = Product::count();

        $lowStockProducts = Product::where('stok', '<=', 5)->count();

        $categories = Category::withCount('products')->get();

        return view('admin.products.index', compact('products', 'totalProducts', 'lowStockProducts', 'categories'));
    }

    // ADMIN - form tambah
    public function create()
    {
        $categories = Category::all();

        return view('admin.products.create', compact('categories'));
    }

    // ADMIN - simpan produk
    public function store(Request $request)
    {
        $data = $request->validate([
            'kategori_id' => 'required|exists:categories,id',
            'nama_kue' => 'required|string|max:128',
            'harga' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('gambar')) {

            $file = $request->file('gambar');

            $filename = time() . '.' .
                $file->getClientOriginalExtension();

            $file->storeAs(
                'public/products',
                $filename
            );

            $data['gambar'] = $filename;
        }

        Product::create($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    // PUBLIC - detail produk
    public function show(int $id)
    {
        $product = \App\Models\Product::findOrFail($id);

        $reviews = \App\Models\Review::with('user')
            ->where('produk_id', $product->id)
            ->latest()
            ->get();

        return view('user.products.show', compact('product', 'reviews'));
    }

    // ADMIN - form edit
    public function edit(int $id)
    {
        $product = Product::findOrFail($id);

        $categories = Category::all();

        return view(
            'admin.products.edit',
            compact('product', 'categories')
        );
    }

    // ADMIN - update
    public function update(Request $request, int $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->validate([
            'kategori_id' => 'required|exists:categories,id',
            'nama_kue' => 'required|string|max:128',
            'harga' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('gambar')) {

            if ($product->gambar) {
                Storage::delete(
                    'public/products/' . $product->gambar
                );
            }

            $file = $request->file('gambar');

            $filename = time() . '.' .
                $file->getClientOriginalExtension();

            $file->storeAs(
                'public/products',
                $filename
            );

            $data['gambar'] = $filename;
        }

        $product->update($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    // ADMIN - hapus
    public function destroy(int $id)
    {
        $product = Product::findOrFail($id);

        if ($product->gambar) {
            Storage::delete(
                'public/products/' . $product->gambar
            );
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}
