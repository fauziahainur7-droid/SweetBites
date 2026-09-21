<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'nama_kategori' => 'Cookies',
                'deskripsi' => 'Kue kering premium dengan berbagai varian rasa. Renyah, chewy, dan cocok untuk camilan atau hampers.',
            ],
            [
                'nama_kategori' => 'Brownies',
                'deskripsi' => 'Brownies fudgy dengan cokelat Belgia premium. Lembut, moist, dan bikin nagih.',
            ],
            [
                'nama_kategori' => 'Pastry',
                'deskripsi' => 'Pastry artisan dengan bahan berkualitas tinggi. Renyah, buttery, dan mewah.',
            ],
            [
                'nama_kategori' => 'Dessert Box',
                'deskripsi' => 'Dessert dalam kemasan box estetik dengan layer cantik. Cocok untuk hadiah atau acara spesial.',
            ],
            [
                'nama_kategori' => 'Cupcake',
                'deskripsi' => 'Kue mungil dengan berbagai topping kreatif. Perfect untuk hadiah dan pesta.',
            ],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}