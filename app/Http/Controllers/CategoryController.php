<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_kategori' => 'required|unique:categories,nama_kategori',
            'deskripsi' => 'nullable',
        ]);

        Category::create($data);

        return redirect()->route('categories.index')
            ->with('success','Kategori berhasil ditambahkan!');
    }

    public function edit(int $id)
    {
        $category = Category::findOrFail($id);

        return view('categories.edit', compact('category'));

    }

    public function update(Request $request,int $id)
    {
        $category = Category::findOrFail($id);

         $data = $request->validate([
            'nama_kategori' => 'required|unique:categories,nama_kategori,'. $id,
            'deskripsi' => 'nullable',
        ]);

        $category->update($data);

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil diperbarui!');
        
    }

    public function destroy(int $id)
    {
        $category = Category::find($id);

        //cek klo masih ada yang pake kategori 
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Kategori tidak bisa dihapus karena masih memiliki produk!');
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil dihapus!');
    }
}
