<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->get();

        return view('Products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'kategori_id' => 'required|exists:categories,id',
            'nama_kue' => 'required|string|max:128',
            'harga' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|mas:5000',
        ]);

        // upload gambar
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/products', $filename);
            $data['gambar'] = $filename;
        }

        // Simpan ke database
        Product::create($data);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with('category', 'reviews.user')->findOrFail($id);

        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();

        return view('product.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::find($id);

        $data = $request->validate([
            'kategori_id' => 'required|exists:categories,id',
            'nama_kue' => 'required|string|max:128',
            'harga' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|mas:5000',
        ]);

        //upload gambar baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama 
            if ($product->gambar) {
                Storage::delete('public/products/' . $product->gambar);
            }

            // Upload gambar baru
            $file = $request->file('gambar');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/products', $filename);
            $data['gambar'] = $filename;
        }


        $product->update($data);

        return redirect()->route('products.index')
            ->with('success', 'produk berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        //hapus gambar storage
        if ($product->gambar) {
            Storage::delete('public/products/' . $product->gambar);
        }

        // Hapus data produk
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }

    public function catalog(Request $request)
    {
        // buat produk yang stoknya > 0
        $query = Product::with('category')->where('stok', '>', 0);

        // Filter pencarian berdasarkan nama
        if ($request->has('search') && $request->search) {
            $query->where('nama_kue', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan kategori
        if ($request->has('category') && $request->category) {
            $query->where('kategori_id', $request->category);
        }

        // Ambil data dengan pagination (12 per halaman)
        $products = $query->paginate(12);

        // Ambil semua kategori untuk filter
        $categories = Category::all();

        return view('user.products.catalog', compact('products', 'categories'));
    }
}
