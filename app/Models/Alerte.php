<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alerte extends Model
{
    protected $fillable = [
        'message',
        'date_alerte',
        'type',
        'produit_id',
        'user_id',
        'lu',
    ];

    protected $casts = [
        'date_alerte' => 'datetime',
        'lu' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function produit()
    {
        return $this->belongsTo(Product::class, 'produit_id');
    }
}