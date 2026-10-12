<?php

namespace App\Http\Controllers;

use App\Models\Alerte;
use App\Models\Category;
use App\Models\LignePanier;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function sellerProducts()
    {
        $products = Product::where('vendeur_id', Auth::id())->latest()->get();
        return view('seller.dashboard', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('seller.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'prix' => 'required|numeric',
            'prix_initial' => 'nullable|numeric|gt:prix',
            'stock' => 'required|integer',
            'category_id' => 'required',
            'date_peremption' => 'required|date',
            'image' => 'nullable|image|max:4096',
        ]);

        Product::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'prix' => $request->prix,
            'prix_initial' => $request->prix_initial,
            'stock' => $request->stock,
            'statut' => 'disponible',
            'date_peremption' => $request->date_peremption,
            // La photo va sur le disque par défaut : le disque "public" en local, le bucket en ligne
            'image' => $request->file('image') ? $request->file('image')->store('produits') : null,
            'category_id' => $request->category_id,
            'vendeur_id' => Auth::id(),
        ]);

        return redirect()->route('seller.dashboard')->with('success', 'Produit ajouté !');
    }

    public function edit(Product $product)
    {
        if ($product->vendeur_id !== Auth::id()) {
            abort(403, 'Ce produit ne vous appartient pas.');
        }

        $categories = Category::all();
        return view('seller.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        if ($product->vendeur_id !== Auth::id()) {
            abort(403, 'Ce produit ne vous appartient pas.');
        }

        $request->validate([
            'nom' => 'required',
            'prix' => 'required|numeric',
            'prix_initial' => 'nullable|numeric|gt:prix',
            'stock' => 'required|integer',
            'category_id' => 'required',
            'date_peremption' => 'required|date',
            'image' => 'nullable|image|max:4096',
        ]);

        $data = [
            'nom' => $request->nom,
            'description' => $request->description,
            'prix' => $request->prix,
            'prix_initial' => $request->prix_initial,
            'stock' => $request->stock,
            // Le statut n'est plus modifiable manuellement : il reste "disponible"
            // jusqu'à ce que la commande automatique produits:expirer le passe à "expire".
            'date_peremption' => $request->date_peremption,
            'category_id' => $request->category_id,
        ];

        if ($request->file('image')) {
            $data['image'] = $request->file('image')->store('produits');
        }

        $product->update($data);

        return redirect()->route('seller.dashboard')->with('success', 'Produit modifié !');
    }

    public function destroy(Product $product)
    {
        if ($product->vendeur_id !== Auth::id()) {
            abort(403, 'Ce produit ne vous appartient pas.');
        }

        // Un produit déjà commandé est conservé, pour garder l'historique des commandes
        $dejaCommande = LignePanier::where('product_id', $product->id)
            ->whereHas('panier', fn ($q) => $q->where('statut', 'valide'))
            ->exists();

        if ($dejaCommande) {
            return redirect()->route('seller.dashboard')
                ->with('error', 'Ce produit fait partie de commandes : il ne peut pas être supprimé. Mettez son stock à 0 pour le retirer de la vente.');
        }

        // Sinon : on le retire des paniers en cours et des alertes, puis on le supprime
        DB::transaction(function () use ($product) {
            LignePanier::where('product_id', $product->id)->delete();
            Alerte::where('produit_id', $product->id)->delete();
            $product->delete();
        });

        return redirect()->route('seller.dashboard')->with('success', 'Produit supprimé !');
    }
}