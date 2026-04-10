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
        Schema::create('lendings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade');
            $table->string('name'); // Nama peminjam
            $table->integer('total'); // Jumlah dipinjam
            $table->text('notes')->nullable(); // Keterangan
            $table->dateTime('lending_date'); // Tanggal pinjam
            $table->boolean('is_returned')->default(false); // Status kembali
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Diisi oleh siapa
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lendings');
    }
};
