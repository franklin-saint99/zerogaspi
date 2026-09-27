<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LignePanier extends Model
{
    protected $table = 'ligne_panier';

    protected $fillable = ['panier_id', 'product_id', 'quantite', 'prix_unitaire'];

    public function panier(): BelongsTo
    {
        return $this->belongsTo(Panier::class, 'panier_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function sousTotal(): float
    {
        return $this->quantite * (float) $this->prix_unitaire;
    }
}