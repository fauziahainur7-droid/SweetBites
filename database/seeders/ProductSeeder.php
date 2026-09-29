<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // KATEGORI 1: COOKIES (5 produk)
        Product::create([
            'kategori_id' => 1,
            'nama_kue' => 'Choco Chip Sea Salt Cookies',
            'harga' => 65000,
            'stok' => 30,
            'deskripsi' => 'Cookies tebal dengan dark chocolate chip dan sea salt. Tekstur renyah di luar, chewy di dalam. Pakai cokelat Belgia import dan mentega asli!',
            'gambar' => null,
        ]);

        Product::create([
            'kategori_id' => 1,
            'nama_kue' => 'Matcha Almond Cookies',
            'harga' => 70000,
            'stok' => 25,
            'deskripsi' => 'Cookies dengan rasa matcha authentic dan taburan almond slice. Kaya antioksidan dan rasa unik. Cocok untuk pecinta green tea.',
            'gambar' => null,
        ]);

        Product::create([
            'kategori_id' => 1,
            'nama_kue' => 'Red Velvet Cream Cheese Cookies',
            'harga' => 68000,
            'stok' => 28,
            'deskripsi' => 'Cookies red velvet dengan isian cream cheese lembut. Warna merah cantik dan rasa creamy. Camilan mewah untuk segala suasana.',
            'gambar' => null,
        ]);

        Product::create([
            'kategori_id' => 1,
            'nama_kue' => 'Nutella Stuffed Cookies',
            'harga' => 75000,
            'stok' => 20,
            'deskripsi' => 'Cookies dengan isian Nutella lumer di tengahnya. Sensasi cokelat hazelnut yang mewah. Wajib coba untuk pecinta cokelat!',
            'gambar' => null,
        ]);

        Product::create([
            'kategori_id' => 1,
            'nama_kue' => 'Biscoff Lotus Cookies',
            'harga' => 72000,
            'stok' => 22,
            'deskripsi' => 'Cookies dengan topping Lotus Biscoff caramelized. Perpaduan manis, gurih, dan renyah yang sempurna.',
            'gambar' => null,
        ]);

        //  KATEGORI 2: BROWNIES (5 produk)
        Product::create([
            'kategori_id' => 2,
            'nama_kue' => 'Fudgy Brownies Premium',
            'harga' => 55000,
            'stok' => 30,
            'deskripsi' => 'Brownies fudgy dengan dark chocolate Belgia premium. Tekstur moist dan lembut. Topping cokelat melimpah!',
            'gambar' => null,
        ]);

        Product::create([
            'kategori_id' => 2,
            'nama_kue' => 'Brownies Almond Crunch',
            'harga' => 60000,
            'stok' => 25,
            'deskripsi' => 'Brownies dengan taburan almond slice renyah. Perpaduan cokelat lembut dan kacang renyah yang sempurna.',
            'gambar' => null,
        ]);

        Product::create([
            'kategori_id' => 2,
            'nama_kue' => 'Blondies White Chocolate',
            'harga' => 58000,
            'stok' => 28,
            'deskripsi' => 'Blondies dengan white chocolate dan macadamia. Manis, buttery, dan lembut. Varian baru yang wajib dicoba!',
            'gambar' => null,
        ]);

        Product::create([
            'kategori_id' => 2,
            'nama_kue' => 'Caramel Brownies',
            'harga' => 62000,
            'stok' => 22,
            'deskripsi' => 'Brownies dengan lelehan karamel asin di tengahnya. Perpaduan cokelat, karamel, dan sea salt yang mewah.',
            'gambar' => null,
        ]);

        Product::create([
            'kategori_id' => 2,
            'nama_kue' => 'Matcha Brownies',
            'harga' => 65000,
            'stok' => 20,
            'deskripsi' => 'Brownies matcha Jepang dengan white chocolate. Rasa earthy matcha berpadu manis white chocolate.',
            'gambar' => null,
        ]);

        //  KATEGORI 3: PASTRY (5 produk)
        Product::create([
            'kategori_id' => 3,
            'nama_kue' => 'Pain Au Chocolat',
            'harga' => 30000,
            'stok' => 20,
            'deskripsi' => 'Pastry klasik Perancis dengan isian dark chocolate Belgia. Lapisan pastry renyah dan buttery.',
            'gambar' => null,
        ]);

        Product::create([
            'kategori_id' => 3,
            'nama_kue' => 'Almond Croissant',
            'harga' => 32000,
            'stok' => 18,
            'deskripsi' => 'Croissant dengan isian almond cream dan taburan almond slice. Renyah, buttery, dan beraroma wangi.',
            'gambar' => null,
        ]);

        Product::create([
            'kategori_id' => 3,
            'nama_kue' => 'Caramel Croissant',
            'harga' => 35000,
            'stok' => 15,
            'deskripsi' => 'Croissant dengan saus karamel asin homemade. Manis, gurih, dan mewah dalam satu gigitan.',
            'gambar' => null,
        ]);

        Product::create([
            'kategori_id' => 3,
            'nama_kue' => 'Cinnamon Roll Premium',
            'harga' => 28000,
            'stok' => 22,
            'deskripsi' => 'Roll pastry dengan filling kayu manis dan cream cheese glaze. Wangi, manis, dan lembut.',
            'gambar' => null,
        ]);

        Product::create([
            'kategori_id' => 3,
            'nama_kue' => 'Pistachio Croissant',
            'harga' => 35000,
            'stok' => 15,
            'deskripsi' => 'Croissant dengan pistachio cream premium. Viral di media sosial! Renyah, buttery, dan mewah.',
            'gambar' => null,
        ]);

        // KATEGORI 4: DESSERT BOX (5 produk)
        Product::create([
            'kategori_id' => 4,
            'nama_kue' => 'Oreo Cheesecake Box',
            'harga' => 45000,
            'stok' => 25,
            'deskripsi' => 'Dessert box dengan layer cheesecake creamy dan oreo crunchy. Disajikan dalam kemasan cantik estetik.',
            'gambar' => null,
        ]);

        Product::create([
            'kategori_id' => 4,
            'nama_kue' => 'Tiramisu Luxury Box',
            'harga' => 52000,
            'stok' => 18,
            'deskripsi' => 'Tiramisu klasik dengan lapisan sponge coffee, mascarpone, dan bubuk cokelat. Dessert mewah dalam box elegan.',
            'gambar' => null,
        ]);

        Product::create([
            'kategori_id' => 4,
            'nama_kue' => 'Chocolate Lava Box',
            'harga' => 50000,
            'stok' => 20,
            'deskripsi' => 'Chocolate cake dengan lava cokelat meleleh. Disajikan dengan topping es krim vanilla.',
            'gambar' => null,
        ]);

        Product::create([
            'kategori_id' => 4,
            'nama_kue' => 'Caramel Latte Box',
            'harga' => 50000,
            'stok' => 20,
            'deskripsi' => 'Dessert box dengan layer caramel, coffee, dan cream. Perpaduan manis dan pahit yang elegan.',
            'gambar' => null,
        ]);

        Product::create([
            'kategori_id' => 4,
            'nama_kue' => 'Matcha Red Bean Box',
            'harga' => 50000,
            'stok' => 20,
            'deskripsi' => 'Dessert box dengan layer matcha, red bean, dan cream. Perpaduan rasa Jepang yang elegan.',
            'gambar' => null,
        ]);

        //KATEGORI 5: CUPCAKE (5 produk)
        Product::create([
            'kategori_id' => 5,
            'nama_kue' => 'Caramel Latte Cupcake',
            'harga' => 30000,
            'stok' => 25,
            'deskripsi' => 'Cupcake dengan rasa caramel latte dan buttercream kopi. Manis, pahit, dan creamy. Perfect untuk pecinta kopi.',
            'gambar' => null,
        ]);

        Product::create([
            'kategori_id' => 5,
            'nama_kue' => 'Red Velvet Cupcake',
            'harga' => 29000,
            'stok' => 28,
            'deskripsi' => 'Cupcake red velvet dengan cream cheese frosting. Lembut, manis, dan elegan. Cocok untuk hadiah spesial.',
            'gambar' => null,
        ]);

        Product::create([
            'kategori_id' => 5,
            'nama_kue' => 'Choco Mint Cupcake',
            'harga' => 27000,
            'stok' => 28,
            'deskripsi' => 'Cupcake cokelat dengan buttercream mint segar. Perpaduan cokelat dan mint yang menyegarkan.',
            'gambar' => null,
        ]);

        Product::create([
            'kategori_id' => 5,
            'nama_kue' => 'Coffee Mocha Cupcake',
            'harga' => 30000,
            'stok' => 25,
            'deskripsi' => 'Cupcake dengan rasa mocha coffee dan buttercream premium. Cocok untuk pecinta kopi.',
            'gambar' => null,
        ]);

        Product::create([
            'kategori_id' => 5,
            'nama_kue' => 'Mini Cheesecake Strawberry',
            'harga' => 32000,
            'stok' => 22,
            'deskripsi' => 'Mini cheesecake dengan topping strawberry segar dan glaze. Creamy, manis, dan segar.',
            'gambar' => null,
        ]);
    }
}