<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SellerController extends Controller
{
    public function dashboard()
    {
        $produits = Product::where('vendeur_id', Auth::id())->latest()->get();
        $totalProduits = $produits->count();
        $produitsVendus = $produits->where('statut', 'epuise')->count();
        $produitsExpires = $produits->where('statut', 'expire')->count();

        $produitsSauves = DB::table('commande_produit')
            ->join('commandes', 'commandes.id', '=', 'commande_produit.commande_id')
            ->join('products', 'products.id', '=', 'commande_produit.product_id')
            ->where('products.vendeur_id', Auth::id())
            ->where('commandes.statut', 'recuperee')
            ->sum('commande_produit.quantite');

        return view('seller.dashboard', compact('produits', 'totalProduits', 'produitsVendus', 'produitsExpires', 'produitsSauves'));
    }

    public function commandes()
    {
        $commandes = Commande::whereHas('produits', function ($q) {
            $q->where('vendeur_id', Auth::id());
        })->latest()->get();

        return view('seller.commandes', compact('commandes'));
    }

    public function updateCommande(Request $request, $id)
    {
        $commande = Commande::whereHas('produits', function ($q) {
            $q->where('vendeur_id', Auth::id());
        })->findOrFail($id);

        $commande->update(['statut' => $request->statut]);

        return redirect()->route('seller.commandes')->with('success', 'Statut mis à jour !');
    }
    public function marquerAlerteLue($id)
{
    $alerte = \App\Models\Alerte::where('user_id', Auth::id())->findOrFail($id);
    $alerte->update(['lu' => true]);

    return redirect()->back();
}
}