<?php

namespace App\Http\Controllers;

use App\Models\Panier;
use App\Models\Product;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PanierController extends Controller
{
    public function index()
    {
        $paniers = Panier::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $total = $paniers->sum(fn($p) => $p->product->prix * $p->quantite);

        return view('buyer.panier', compact('paniers', 'total'));
    }

    public function ajouter(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantite' => 'required|integer|min:1',
        ]);

        $produit = Product::findOrFail($request->product_id);

        $existant = Panier::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
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
            $existant->increment('quantite', $request->quantite);
        } else {
            Panier::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantite' => $request->quantite,
            ]);
        }

        return redirect()->back()->with('success', 'Produit ajouté au panier !');
    }

    public function supprimer($id)
    {
        Panier::where('id', $id)->where('user_id', Auth::id())->delete();
        return redirect()->back()->with('success', 'Produit supprimé du panier !');
    }

    public function commander()
    {
        $paniers = Panier::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($paniers->isEmpty()) {
            return redirect()->route('panier.index')->with('error', 'Votre panier est vide !');
        }

        // Vérification finale du stock avant de valider (au cas où il aurait changé entre-temps)
        foreach ($paniers as $panier) {
            $stockActuel = Product::find($panier->product_id)->stock;
            if ($panier->quantite > $stockActuel) {
                return redirect()->route('panier.index')->with(
                    'error',
                    "Stock insuffisant pour \"{$panier->product->nom}\". Il ne reste que {$stockActuel} unité(s). Merci d'ajuster votre panier."
                );
            }
        }

        $total = $paniers->sum(fn($p) => $p->product->prix * $p->quantite);

        $commande = DB::transaction(function () use ($paniers, $total) {
            $commande = Commande::create([
                'user_id' => Auth::id(),
                'statut' => 'en_attente',
                'total' => $total,
            ]);

            foreach ($paniers as $panier) {
                $commande->produits()->attach($panier->product_id, [
                    'quantite' => $panier->quantite,
                    'prix' => $panier->product->prix,
                ]);

                $produit = Product::lockForUpdate()->find($panier->product_id);
                $produit->decrement('stock', $panier->quantite);

                if ($produit->stock <= 0) {
                    $produit->update(['statut' => 'epuise']);
                }
            }

            return $commande;
        });

        Panier::where('user_id', Auth::id())->delete();

        return redirect()->route('commandes.paiement', $commande->id);
    }
}