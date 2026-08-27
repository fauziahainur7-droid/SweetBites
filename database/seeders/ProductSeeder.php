<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'Kategori_id' => 1,
            'nama_kue' => 'Chocolate Lava Birthday Cake',
            'harga' => 240000,
            'stok' => 10,
            'deskripsi' => 'Kue ulang tahun dengan 3 lapis cokelat dan ganache yang meleleh. Dilengkapi dekorasi
            dekorasi cokelat premium dan topping potongan cokelat.Moist,rich,dan bikin nagih!',
            'gambar' => 'null',
        ]);
        Product::create([
            'Kategori_id' => 1,
            'nama_kue' => 'Strawberry Cream Cake',
            'harga' => 3000000,
            'stok' => 10,
            'deskripsi' => 'Kue ulang tahun dengan rasa strawberry asli dan creame cheese frosting.Dihiasi buah segar. Manis 
            segar dan elegant.',
            'gambar' => 'null',
        ]);
        Product::create([
            'Kategori_id' => 1,
            'nama_kue' => 'Rainbow Funfetti Cake',
            'harga' => 195000,
            'stok' => 8,
            'deskripsi' => 'Kue warna warni dengan buttercreame vanilla dan sprinkle yang ceria.
            Cocok untuk anak anak dan remaja.',
            'gambar' => 'null',
        ]);
        Product::create([
            'Kategori_id' => 2,
            'nama_kue' => 'Premium Chocolate Chip Cookies',
            'harga' => 65000,
            'stok' => 20,
            'deskripsi' => 'Cookies tebal dengan dark chocolate chip dan sea salt. 
            Tekstur renyah di luar, chewy di dalam. Pakai cokelat Belgium import dan mentega asli!',
            'gambar' => 'null',
        ]);
        Product::create([
            'Kategori_id' => 2,
            'nama_kue' => 'Matcha Almond Cookies',
            'harga' => 700000,
            'stok' => 15,
            'deskripsi' => 'Cookies dengan rasa matcha authentic dan taburan almond slice.
             Kaya akan antioksidan dan rasa yang unik. Cocok untuk pecinta green tea',
            'gambar' => 'null',
        ]);
        Product::create([
            'Kategori_id' => 2,
            'nama_kue' => 'Red Velvet Cream Cheese Cookies',
            'harga' => 68000,
            'stok' => 18,
            'deskripsi' => 'Cookies red velvet dengan isian cream cheese yang lembut.
             Warna merah cantik dan rasa creamy. Camilan mewah untuk segala suasana',
            'gambar' => 'null',
        ]);
        Product::create([
            'kategori_id' => 2,
            'nama_kue' => 'Nastar Premium',
            'harga' => 75000,
            'stok' => 15,
            'deskripsi' => 'Kue kering klasik nan elegan dengan isian selai nanas homemade. Tekstur lembut dan lumer di mulut. Cocok untuk hampers Lebaran atau hadiah spesial.',
            'gambar' => null,
        ]);

        Product::create([
            'kategori_id' => 2,
            'nama_kue' => 'Kastengel Keju',
            'harga' => 72000,
            'stok' => 15,
            'deskripsi' => 'Kue kering gurih dengan keju cheddar premium. Tekstur renyah dan rasa keju yang kuat. Camilan favorit untuk segala suasana.',
            'gambar' => null,
        ]);

        // ===== KUE BASAH (kategori_id: 3) =====
        Product::create([
            'kategori_id' => 3,
            'nama_kue' => 'Klepon Keju Lumer',
            'harga' => 38000,
            'stok' => 12,
            'deskripsi' => 'Klepon modern dengan isian gula merah cair yang lumer dan taburan keju cheddar premium. Tekstur lembut dengan perpaduan manis dan gurih yang sempurna. Cocok untuk camilan di cuaca dingin.',
            'gambar' => null,
        ]);

        Product::create([
            'kategori_id' => 3,
            'nama_kue' => 'Dadar Gulung Pandan Keju',
            'harga' => 35000,
            'stok' => 15,
            'deskripsi' => 'Dadar gulung dengan kulit pandan wangi dan isian kelapa parut plus keju. Manis gurih dan membangkitkan kenangan kampung halaman.',
            'gambar' => null,
        ]);

        Product::create([
            'kategori_id' => 3,
            'nama_kue' => 'Lumpia Pisang Cokelat Crispy',
            'harga' => 30000,
            'stok' => 20,
            'deskripsi' => 'Lumpia pisang dengan cokelat leleh dan taburan keju. Renyah di luar, lembut di dalam. Sempurna untuk teman ngopi di sore hari yang dingin.',
            'gambar' => null,
        ]);

        Product::create([
            'kategori_id' => 3,
            'nama_kue' => 'Bika Ambon Pandan',
            'harga' => 45000,
            'stok' => 10,
            'deskripsi' => 'Kue basah khas Medan dengan tekstur bersarang dan rasa pandan yang harum. Lembut, legit, dan selalu menggugah selera.',
            'gambar' => null,
        ]);

        Product::create([
            'kategori_id' => 3,
            'nama_kue' => 'Kue Lumpur Kentang',
            'harga' => 40000,
            'stok' => 12,
            'deskripsi' => 'Kue lumpur dengan kentang dan topping kismis. Tekstur lembut, gurih, dan manis. Camilan klasik yang selalu dinanti.',
            'gambar' => null,
        ]);

        // ===== ROTI (kategori_id: 4) =====
        Product::create([
            'kategori_id' => 4,
            'nama_kue' => 'Sourdough Artisan Honey',
            'harga' => 48000,
            'stok' => 10,
            'deskripsi' => 'Roti sourdough dengan madu dan biji-bijian. Tekstur chewy dengan rasa asam yang khas. Difermentasi 24 jam untuk hasil maksimal dan menyehatkan pencernaan.',
            'gambar' => null,
        ]);

        Product::create([
            'kategori_id' => 4,
            'nama_kue' => 'Croissant Almond Crunch',
            'harga' => 27000,
            'stok' => 12,
            'deskripsi' => 'Croissant dengan isian almond cream dan taburan almond slice. Renyah, buttery, dan beraroma wangi. Pastry klasik dengan sentuhan premium.',
            'gambar' => null,
        ]);

        Product::create([
            'kategori_id' => 4,
            'nama_kue' => 'Roti Tawar Susu Lembut',
            'harga' => 20000,
            'stok' => 25,
            'deskripsi' => 'Roti tawar super lembut dengan rasa susu yang gurih. Sangat empuk dan tahan lama. Cocok untuk sarapan, bekal, atau dibuat sandwich.',
            'gambar' => null,
        ]);

        Product::create([
            'kategori_id' => 4,
            'nama_kue' => 'Roti Sobek Cokelat Keju',
            'harga' => 25000,
            'stok' => 18,
            'deskripsi' => 'Roti sobek dengan isian cokelat dan keju. Tekstur lembut dan rasa manis gurih yang pas. Roti favorit untuk sarapan keluarga.',
            'gambar' => null,
        ]);

        Product::create([
            'kategori_id' => 4,
            'nama_kue' => 'Danish Sosis Keju',
            'harga' => 28000,
            'stok' => 15,
            'deskripsi' => 'Danish pastry dengan isian sosis dan keju. Renyah di luar, gurih di dalam. Camilan praktis untuk sarapan atau bekal sekolah.',
            'gambar' => null,
        ]);

        // ===== DESSERT BOX (kategori_id: 5) =====
        Product::create([
            'kategori_id' => 5,
            'nama_kue' => 'Oreo Cheesecake Dessert Box',
            'harga' => 45000,
            'stok' => 25,
            'deskripsi' => 'Dessert box dengan layer cheesecake creamy dan oreo crunchy. Disajikan dalam kemasan cantik yang estetik. Viral di media sosial dan cocok untuk hadiah atau acara spesial.',
            'gambar' => null,
        ]);

        Product::create([
            'kategori_id' => 5,
            'nama_kue' => 'Tiramisu Luxury Box',
            'harga' => 52000,
            'stok' => 18,
            'deskripsi' => 'Tiramisu klasik dengan lapisan sponge coffee, mascarpone, dan bubuk cokelat. Tekstur creamy dan rasa kopi yang pas. Dessert mewah dalam box elegan untuk hadiah istimewa.',
            'gambar' => null,
        ]);

        Product::create([
            'kategori_id' => 5,
            'nama_kue' => 'Chocolate Volcano Box',
            'harga' => 50000,
            'stok' => 20,
            'deskripsi' => 'Chocolate cake dengan lava cokelat yang meleleh saat dibelah. Disajikan dalam box praktis dengan topping es krim vanilla. Sensasi cokelat yang luar biasa!',
            'gambar' => null,
        ]);

        Product::create([
            'kategori_id' => 5,
            'nama_kue' => 'Strawberry Cream Box',
            'harga' => 48000,
            'stok' => 22,
            'deskripsi' => 'Dessert box dengan layer strawberry, cream, dan sponge cake. Segar, manis, dan cantik. Perfect untuk hadiah ulang tahun atau acara spesial.',
            'gambar' => null,
        ]);

        Product::create([
            'kategori_id' => 5,
            'nama_kue' => 'Matcha Red Bean Box',
            'harga' => 50000,
            'stok' => 20,
            'deskripsi' => 'Dessert box dengan layer matcha, red bean, dan cream. Perpaduan rasa Jepang yang elegan dan kekinian. Cocok untuk pecinta green tea.',
            'gambar' => null,
        ]);

        // ===== PASTRY PREMIUM (kategori_id: 6) =====
        Product::create([
            'kategori_id' => 6,
            'nama_kue' => 'Pain Au Chocolat Premium',
            'harga' => 30000,
            'stok' => 12,
            'deskripsi' => 'Pastry klasik Perancis dengan isian dark chocolate Belgium. Lapisan pastry yang renyah dan buttery. Sempurna untuk breakfast mewah atau afternoon tea.',
            'gambar' => null,
        ]);

        Product::create([
            'kategori_id' => 6,
            'nama_kue' => 'Danish Blueberry Cream Cheese',
            'harga' => 32000,
            'stok' => 10,
            'deskripsi' => 'Danish pastry dengan filling blueberry segar dan cream cheese. Manis, asam, dan creamy dalam satu gigitan. Pastry yang elegan dan mewah.',
            'gambar' => null,
        ]);

        Product::create([
            'kategori_id' => 6,
            'nama_kue' => 'Cinnamon Roll Premium',
            'harga' => 28000,
            'stok' => 15,
            'deskripsi' => 'Roll pastry dengan filling kayu manis dan cream cheese glaze. Wangi, manis, dan lembut. Pastry yang hangat dan comforting.',
            'gambar' => null,
        ]);

        Product::create([
            'kategori_id' => 6,
            'nama_kue' => 'Puff Pastry Sosis Keju',
            'harga' => 26000,
            'stok' => 18,
            'deskripsi' => 'Pastry renyah dengan isian sosis dan keju. Gurih, renyah, dan mewah. Camilan praktis untuk segala suasana.',
            'gambar' => null,
        ]);

        // ===== CUPCAKE (kategori_id: 7) =====
        Product::create([
            'kategori_id' => 7,
            'nama_kue' => 'Unicorn Dream Cupcake',
            'harga' => 28000,
            'stok' => 30,
            'deskripsi' => 'Cupcake dengan buttercream warna-warni dan topping unicorn. Super cantik dan lucu! Cocok untuk hadiah ulang tahun, baby shower, atau pesta.',
            'gambar' => null,
        ]);

        Product::create([
            'kategori_id' => 7,
            'nama_kue' => 'Mini Cheesecake Strawberry',
            'harga' => 32000,
            'stok' => 25,
            'deskripsi' => 'Mini cheesecake dengan topping strawberry segar dan glaze. Creamy, manis, dan segar. Satu gigitan langsung jatuh cinta! Perfect untuk hadiah.',
            'gambar' => null,
        ]);

        Product::create([
            'kategori_id' => 7,
            'nama_kue' => 'Choco Mint Cupcake',
            'harga' => 27000,
            'stok' => 28,
            'deskripsi' => 'Cupcake rasa cokelat dengan buttercream mint segar. Perpaduan cokelat dan mint yang menyegarkan. Super hits di kalangan anak muda.',
            'gambar' => null,
        ]);

        Product::create([
            'kategori_id' => 7,
            'nama_kue' => 'Red Velvet Cupcake',
            'harga' => 29000,
            'stok' => 25,
            'deskripsi' => 'Cupcake red velvet dengan cream cheese frosting. Lembut, manis, dan elegan. Cocok untuk pesta atau hadiah spesial.',
            'gambar' => null,
        ]);

        Product::create([
            'kategori_id' => 7,
            'nama_kue' => 'Caramel Latte Cupcake',
            'harga' => 30000,
            'stok' => 22,
            'deskripsi' => 'Cupcake dengan rasa caramel latte dan buttercream kopi. Manis, pahit, dan creamy. Perfect untuk pecinta kopi.',
            'gambar' => null,
        ]);
    }
}
