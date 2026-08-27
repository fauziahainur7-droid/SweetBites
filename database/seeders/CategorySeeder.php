<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'nama_kategori' => 'Kue Ulang Tahun',
            'deskripsi' => 'Kue spesial untuk merayakan moment istimewah.
            Tersedia berbagai rasa dan dekorasi modern yang cantik dan indah.'
        ]);
        Category::create([
            'nama_kategori' => 'Kue Kering',
            'deskripsi' => 'Camilan renyah dengan berbagai varian rasa. Cocok untuk teman teh atau kopi.'
        ]);
        Category::create([
            'nama_kategori' => 'Kue Basah',
            'deskripsi' => 'Kue lembut dan lezat, cocok untuk dinikmati saat cuaca dingin.'
        ]);
        Category::create([
            'nama_kategori' => 'Roti',
            'deskripsi' => 'Roti homemade dengan tekstur empuk dan rasa premium. Cocok untuk sarapan atau camilan.'
        ]);
        Category::create([
            'nama_kategori' => 'Dessert Box',
            'deskripsi' => 'Dessert dalam kemasan box yang estetik dengan layer cantik.Cocok untuk hadiah atau acara spesial.'
        ]);
        Category::create([
            'nama_kategori' => 'Pastry Premium',
            'deskripsi' => 'Pastry artisan dengan bahan berkualitas tinggi. Renyah dan Mewah.'
        ]);
        Category::create([
            'nama_kategori' => 'Cupcake',
            'deskripsi' => 'Kue mungil dengan berbagai topping kreatif.perfect untuk hadiah dan pesta.'
        ]);
        
    }

}
