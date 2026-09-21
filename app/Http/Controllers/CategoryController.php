<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')
            ->latest()
            ->get();

        return view(
            'admin.categories.index',
            compact('categories')
        );
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_kategori' => 'required|string|max:128|unique:categories,nama_kategori',
            'deskripsi' => 'nullable|string',
        ]);

        Category::create($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function show(int $id)
    {
        $category = Category::with('products')
            ->findOrFail($id);

        return view(
            'admin.categories.show',
            compact('category')
        );
    }

    public function edit(int $id)
    {
        $category = Category::findOrFail($id);

        return view(
            'admin.categories.edit',
            compact('category')
        );
    }

    public function update(Request $request,int $id)
    {
        $category = Category::findOrFail($id);

        $data = $request->validate([
            'nama_kategori' =>
                'required|string|max:128|unique:categories,nama_kategori,' . $id,

            'deskripsi' => 'nullable|string',
        ]);

        $category->update($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(int $id)
    {
        $category = Category::findOrFail($id);

        if ($category->products()->exists()) {

            return back()->with(
                'error',
                'Kategori tidak bisa dihapus karena masih memiliki produk!'
            );
        }

        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus!');
    }
}