<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\ContactController;

Route::get('/politique-confidentialite', function () {
    return view('legal.confidentialite');
})->name('confidentialite');

Route::get('/mentions-legales', function () {
    return view('legal.mentions-legales');
})->name('mentions-legales');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'envoyer'])->middleware('throttle:5,1')->name('contact.envoyer');
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        if (auth()->user()->role === 'vendeur') {
            return redirect()->route('seller.dashboard');
        }

        $categories = \App\Models\Category::all();
        $produits = \App\Models\Product::with(['category', 'vendeur'])
            ->where('statut', 'disponible')
            ->whereHas('vendeur', function ($q) {
                $q->where('actif', true);
            })
            ->when(request('categorie'), fn($q, $cat) => $q->where('category_id', $cat))
            ->when(request('recherche'), fn($q, $recherche) => $q->where('nom', 'like', '%'.$recherche.'%'))
            ->latest()
            ->get();

        return view('buyer.dashboard', compact('produits', 'categories'));
    })->name('dashboard');

  Route::middleware('role:admin')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/vendeurs', [AdminController::class, 'vendeurs'])->name('admin.vendeurs');
    Route::get('/admin/acheteurs', [AdminController::class, 'acheteurs'])->name('admin.acheteurs');
    Route::put('/admin/utilisateurs/{id}/toggle', [AdminController::class, 'toggleUser'])->name('admin.utilisateurs.toggle');
    Route::get('/admin/produits', [AdminController::class, 'produits'])->name('admin.produits');
    Route::resource('/admin/categories', CategoryController::class)->except(['destroy']);
    Route::get('/admin/commandes', [AdminController::class, 'commandes'])->name('admin.commandes');
    });

    Route::middleware('role:vendeur')->group(function () {
        Route::get('/seller/dashboard', [SellerController::class, 'dashboard'])->name('seller.dashboard');
        Route::get('/seller/commandes', [SellerController::class, 'commandes'])->name('seller.commandes');
        Route::get('/seller/products', [ProductController::class, 'sellerProducts'])->name('seller.products');
        Route::get('/seller/products/create', [ProductController::class, 'create'])->name('seller.products.create');
        Route::post('/seller/products', [ProductController::class, 'store'])->name('seller.products.store');
        Route::get('/seller/products/{product}/edit', [ProductController::class, 'edit'])->name('seller.products.edit');
        Route::put('/seller/products/{product}', [ProductController::class, 'update'])->name('seller.products.update');
        Route::delete('/seller/products/{product}', [ProductController::class, 'destroy'])->name('seller.products.destroy');
        Route::put('/seller/commandes/{commande}', [SellerController::class, 'updateCommande'])->name('seller.commandes.update');
        Route::put('/seller/alertes/{id}/lue', [SellerController::class, 'marquerAlerteLue'])->name('seller.alertes.lue');
        });

    Route::middleware('role:acheteur')->group(function () {
        Route::post('/commandes', [CommandeController::class, 'store'])->name('commandes.store');
        Route::get('/commandes/paiement/{commande}', [CommandeController::class, 'paiement'])->name('commandes.paiement');
        Route::post('/commandes/confirmer/{commande}', [CommandeController::class, 'confirmer'])->name('commandes.confirmer');
        Route::get('/mes-achats', [CommandeController::class, 'mesAchats'])->name('acheteur.achats');
        Route::get('/panier', [PanierController::class, 'index'])->name('panier.index');
        Route::post('/panier/ajouter', [PanierController::class, 'ajouter'])->name('panier.ajouter');
        Route::delete('/panier/{id}', [PanierController::class, 'supprimer'])->name('panier.supprimer');
        Route::post('/panier/commander', [PanierController::class, 'commander'])->name('panier.commander');
    });
    

});

require __DIR__.'/auth.php';