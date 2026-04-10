<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Kolom-kolom yang boleh diisi secara massal (mass assignment)
    protected $fillable = [
        'name',
        'division_pj',
    ];

    /**
     * Relasi: Category memiliki banyak Item.
     * Satu kategori bisa memiliki banyak barang di dalamnya.
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
