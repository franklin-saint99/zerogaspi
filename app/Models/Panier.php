<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Panier extends Model
{
    protected $table = 'paniers';

    protected $fillable = ['user_id', 'statut'];

    // L'acheteur propriétaire du panier
    public function acheteur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Les lignes du panier (1..*)
    public function lignes(): HasMany
    {
        return $this->hasMany(LignePanier::class, 'panier_id');
    }

    // La commande issue de ce panier (0..1)
    public function commande(): HasOne
    {
        return $this->hasOne(Commande::class, 'panier_id');
    }

    public function total(): float
    {
        return (float) $this->lignes->sum(fn (LignePanier $ligne) => $ligne->sousTotal());
    }

    // Récupère le panier en cours d'un acheteur, ou le crée s'il n'existe pas
    public static function enCoursPour(int $userId): self
    {
        return self::firstOrCreate(['user_id' => $userId, 'statut' => 'en_cours']);
    }
}