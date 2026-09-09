<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'image' => $request->file('image') ? $request->file('image')->store('produits', 'public') : null,
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
            $data['image'] = $request->file('image')->store('produits', 'public');
        }

        $product->update($data);

        return redirect()->route('seller.dashboard')->with('success', 'Produit modifié !');
    }

    public function destroy(Product $product)
    {
        if ($product->vendeur_id !== Auth::id()) {
            abort(403, 'Ce produit ne vous appartient pas.');
        }

        $product->delete();
        return redirect()->route('seller.dashboard')->with('success', 'Produit supprimé !');
    }
}