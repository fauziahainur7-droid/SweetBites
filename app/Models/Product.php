<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategori_id',
        'nama_kue',
        'harga',
        'stok',
        'deskripsi',
        'gambar',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'kategori_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'produk_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'Produk_id');
    }
    public function carts()
    {
        return $this->hasMany(Cart::class, 'product_id');
    }
}
