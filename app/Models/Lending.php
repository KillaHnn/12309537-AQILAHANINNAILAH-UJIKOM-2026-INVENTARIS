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
        'user_id',
    ];

    /**
     * Relasi ke Item.
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * Relasi ke User (Staff/Operator).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
