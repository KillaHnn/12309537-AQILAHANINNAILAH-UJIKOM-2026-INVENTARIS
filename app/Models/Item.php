<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    // Kolom-kolom yang boleh diisi secara massal (mass assignment)
        protected $fillable = [
            'category_id',
            'name',
            'total',
            'repair',
            'lending',
        ];

    /**
     * Relasi: Item milik satu Category.
     * Setiap barang hanya memiliki satu kategori induk.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
