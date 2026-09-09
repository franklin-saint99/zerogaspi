<?php

namespace App\Console\Commands;

use App\Mail\ProduitExpire;
use App\Models\Product;
use App\Models\Alerte;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ExpirerProduits extends Command
{
    protected $signature = 'produits:expirer';

    protected $description = 'Passe automatiquement en statut "expire" les produits dont la date de péremption est dépassée, et notifie le vendeur.';

    public function handle()
    {
        $produits = Product::whereNotNull('date_peremption')
            ->where('date_peremption', '<', now())
            ->where('statut', '!=', 'expire')
            ->with('vendeur')
            ->get();

        foreach ($produits as $produit) {
            $produit->update(['statut' => 'expire']);

            Alerte::create([
                'message' => "Votre produit \"{$produit->nom}\" a expiré et n'est plus visible par les acheteurs.",
                'date_alerte' => now(),
                'type' => 'expiration',
                'produit_id' => $produit->id,
                'user_id' => $produit->vendeur_id,
                'lu' => false,
            ]);

            if ($produit->vendeur && $produit->vendeur->email) {
                Mail::to($produit->vendeur->email)->send(new ProduitExpire($produit));
            }

            $this->info("Produit expiré : {$produit->nom} (vendeur #{$produit->vendeur_id})");
        }

        $this->info(count($produits) . ' produit(s) traité(s).');
    }
}