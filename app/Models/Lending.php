<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lending extends Model
{
    protected $fillable = [
        'item_id',
        'name',
        'total',
        'notes',
        'lending_date',
        'return_date',
        'is_returned',
        'user_id',        // Operator 1
        'user_id_return', // Operator 2
    ];

    // Relasi ke Operator yang meminjamkan (Operator 1)
    public function operatorOut()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Operator yang menerima kembali (Operator 2)
    public function operatorIn()
    {
        return $this->belongsTo(User::class, 'user_id_return');
    }

    /**
     * Relasi ke Item.
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
