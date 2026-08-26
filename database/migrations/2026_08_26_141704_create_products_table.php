<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->foreignId('kategori_id')
                ->constrained('categories')
                ->cascadeOnDelete();
            $table->string('nama_kue', 128);
            $table->integer('harga');
            $table->integer('strok');
            $table->text('deskripsi')->nullable();
            $table->string('gambar',255)->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
