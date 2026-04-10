<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menjalankan migrasi (membuat tabel categories).
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            // Kolom ID otomatis (primary key)
            $table->id();

            // Nama kategori (misal: Elektronik, Alat Dapur)
            $table->string('name');

            // Divisi Penanggung Jawab (misal: Tefa, Sarpras)
            $table->string('division_pj');

            // Kolom created_at dan updated_at otomatis
            $table->timestamps();
        });
    }

    /**
     * Membalikkan migrasi (menghapus tabel categories).
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
