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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();
            
            $table->string('kode_pesanan',20)->unique();
            $table->string('alamat_pengirim');
            $table->string('metode_pengiriman', 128);
            $table->string('metode_pembayaran', 128);
            $table->integer('total_harga');

            $table->string('status', 20)->default('menunggu');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
