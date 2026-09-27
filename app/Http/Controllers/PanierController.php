<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\LignePanier;
use App\Models\Panier;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PanierController extends Controller
{
    // Panier "en_cours" de l'acheteur connecté, avec ses lignes et leurs produits (null s'il n'en a pas)
    private function panierEnCours(): ?Panier
    {
        return Panier::with('lignes.product')
            ->where('user_id', Auth::id())
            ->where('statut', 'en_cours')
            ->first();
    }

    public function index()
    {
        $panier = $this->panierEnCours();
        $lignes = $panier ? $panier->lignes : collect();

        $total = $lignes->sum(fn ($ligne) => $ligne->product->prix * $ligne->quantite);

        return view('buyer.panier', compact('lignes', 'total'));
    }

    public function ajouter(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantite' => 'required|integer|min:1',
        ]);

        $produit = Product::findOrFail($request->product_id);

        // Récupère le panier en cours de l'acheteur, ou le crée
        $panier = Panier::enCoursPour(Auth::id());

        $existant = $panier->lignes()
            ->where('product_id', $produit->id)
            ->first();

        $quantiteDejaPanier = $existant ? $existant->quantite : 0;
        $quantiteTotaleDemandee = $quantiteDejaPanier + $request->quantite;

        if ($quantiteTotaleDemandee > $produit->stock) {
            $disponibleEnPlus = max($produit->stock - $quantiteDejaPanier, 0);
            return redirect()->back()->with(
                'error',
                "Stock insuffisant. Il ne reste que {$produit->stock} unité(s) en stock" .
                ($quantiteDejaPanier > 0 ? " (vous en avez déjà {$quantiteDejaPanier} dans votre panier, vous pouvez encore en ajouter {$disponibleEnPlus})." : '.')
            );
        }

        if ($existant) {
            // Le produit est déjà dans le panier : on augmente la quantité
            $existant->increment('quantite', $request->quantite, ['prix_unitaire' => $produit->prix]);
        } else {
            // Nouvelle ligne dans le panier
            LignePanier::create([
                'panier_id' => $panier->id,
                'product_id' => $produit->id,
                'quantite' => $request->quantite,
                'prix_unitaire' => $produit->prix,
            ]);
        }

        return redirect()->back()->with('success', 'Produit ajouté au panier !');
    }

    // $id = id de la ligne de panier à supprimer
    public function supprimer($id)
    {
        LignePanier::where('id', $id)
            ->whereHas('panier', function ($q) {
                $q->where('user_id', Auth::id())->where('statut', 'en_cours');
            })
            ->delete();

        return redirect()->back()->with('success', 'Produit supprimé du panier !');
    }

    public function commander()
    {
        $panier = $this->panierEnCours();

        if (! $panier || $panier->lignes->isEmpty()) {
            return redirect()->route('panier.index')->with('error', 'Votre panier est vide !');
        }

        // Vérification finale du stock avant de valider (au cas où il aurait changé entre-temps)
        foreach ($panier->lignes as $ligne) {
            $stockActuel = Product::find($ligne->product_id)->stock;
            if ($ligne->quantite > $stockActuel) {
                return redirect()->route('panier.index')->with(
                    'error',
                    "Stock insuffisant pour \"{$ligne->product->nom}\". Il ne reste que {$stockActuel} unité(s). Merci d'ajuster votre panier."
                );
            }
        }

        $total = $panier->lignes->sum(fn ($ligne) => $ligne->product->prix * $ligne->quantite);

        $commande = DB::transaction(function () use ($panier, $total) {
            foreach ($panier->lignes as $ligne) {
                // On fige le prix au moment de la commande
                $ligne->update(['prix_unitaire' => $ligne->product->prix]);

                $produit = Product::lockForUpdate()->find($ligne->product_id);
                $produit->decrement('stock', $ligne->quantite);

                if ($produit->stock <= 0) {
                    $produit->update(['statut' => 'epuise']);
                }
            }

            // Le panier est validé : il devient la commande (au prochain ajout, un nouveau panier sera créé)
            $panier->update(['statut' => 'valide']);

            return Commande::create([
                'panier_id' => $panier->id,
                'statut' => 'en_attente',
                'total' => $total,
            ]);
        });

        return redirect()->route('commandes.paiement', $commande->id);
    }
}