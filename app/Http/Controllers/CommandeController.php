<?php

namespace App\Http\Controllers;

use App\Mail\CommandeConfirmee;
use App\Mail\NouvelleCommandeVendeur;
use App\Models\Commande;
use App\Models\LignePanier;
use App\Models\Panier;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CommandeController extends Controller
{
    // Achat direct d'un produit (sans passer par le panier en cours)
    public function store(Request $request)
    {
        $produit = Product::findOrFail($request->product_id);

        $commande = DB::transaction(function () use ($produit) {
            // Un panier validé contenant uniquement ce produit
            $panier = Panier::create([
                'user_id' => Auth::id(),
                'statut' => 'valide',
            ]);

            LignePanier::create([
                'panier_id' => $panier->id,
                'product_id' => $produit->id,
                'quantite' => 1,
                'prix_unitaire' => $produit->prix,
            ]);

            return Commande::create([
                'panier_id' => $panier->id,
                'statut' => 'en_attente',
                'total' => $produit->prix,
            ]);
        });

        return redirect()->route('commandes.paiement', $commande->id);
    }

    public function paiement(Commande $commande)
    {
        $this->verifierProprietaire($commande);

        return view('buyer.paiement', compact('commande'));
    }

    public function confirmer(Commande $commande)
    {
        $this->verifierProprietaire($commande);

        $commande->update(['statut' => 'en_attente']);

        // Email de confirmation envoyé à l'acheteur
        Mail::to($commande->user->email)->send(new CommandeConfirmee($commande));

        // Email de notification envoyé à chaque vendeur concerné par cette commande
        $produitsParVendeur = $commande->produits()
            ->with('vendeur')
            ->get()
            ->groupBy('vendeur_id');

        foreach ($produitsParVendeur as $vendeurId => $produitsVendeur) {
            $vendeur = $produitsVendeur->first()->vendeur;

            if ($vendeur && $vendeur->email) {
                Mail::to($vendeur->email)->send(new NouvelleCommandeVendeur($commande, $produitsVendeur));
            }
        }

        return redirect()->route('dashboard')->with('success', 'Commande confirmée ! Vous pouvez la récupérer en magasin. Un email de confirmation vous a été envoyé.');
    }

    public function mesAchats()
    {
        // Les commandes dont le panier appartient à l'acheteur connecté
        $commandes = Commande::whereHas('panier', function ($q) {
            $q->where('user_id', Auth::id());
        })->latest()->get();

        return view('buyer.achats', compact('commandes'));
    }

    // L'acheteur d'une commande se retrouve maintenant via son panier
    private function verifierProprietaire(Commande $commande): void
    {
        if ((int) $commande->panier->user_id !== (int) Auth::id()) {
            abort(403, 'Cette commande ne vous appartient pas.');
        }
    }
}