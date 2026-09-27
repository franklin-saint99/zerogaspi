<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Commande extends Model
{
    protected $table = 'commandes';

    protected $fillable = ['panier_id', 'statut', 'total'];

    // Le panier d'où vient la commande (1 panier -> 0..1 commande)
    public function panier(): BelongsTo
    {
        return $this->belongsTo(Panier::class, 'panier_id');
    }

    // L'acheteur, retrouvé via le panier : $commande->user fonctionne toujours
    public function user(): HasOneThrough
    {
        return $this->hasOneThrough(User::class, Panier::class, 'id', 'id', 'panier_id', 'user_id');
    }

    // Les lignes de la commande = les lignes de son panier
    public function lignes(): HasMany
    {
        return $this->hasMany(LignePanier::class, 'panier_id', 'panier_id');
    }

    // Les produits de la commande, avec quantité et prix au moment de l'achat
    // Utilisation : $produit->pivot->quantite et $produit->pivot->prix_unitaire
    public function produits(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'ligne_panier', 'panier_id', 'product_id', 'panier_id', 'id')
            ->withPivot('quantite', 'prix_unitaire')
            ->withTimestamps();
    }
}