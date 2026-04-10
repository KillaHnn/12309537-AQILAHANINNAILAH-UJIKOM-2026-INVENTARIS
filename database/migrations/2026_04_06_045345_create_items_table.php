<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menjalankan migrasi (membuat tabel items).
     */
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            // Kolom ID otomatis (primary key)
            $table->id();

            // Foreign key ke tabel categories
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');

            // Nama barang (misal: Piring, Komputer, Laptop)
            $table->string('name');

            // Jumlah total barang
            $table->integer('total')->default(0);

            // Jumlah barang yang sedang diperbaiki (repair)
            $table->integer('repair')->default(0);

            // Jumlah barang yang sedang dipinjamkan (lending)
            $table->integer('lending')->default(0);

            // Kolom created_at dan updated_at otomatis
            $table->timestamps();
        });
    }

    /**
     * Membalikkan migrasi (menghapus tabel items).
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
