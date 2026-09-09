<?php

namespace App\Http\Controllers;

use App\Mail\CommandeConfirmee;
use App\Mail\NouvelleCommandeVendeur;
use App\Models\Commande;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CommandeController extends Controller
{
    public function store(Request $request)
    {
        $produit = Product::findOrFail($request->product_id);

        $commande = Commande::create([
            'user_id' => Auth::id(),
            'statut' => 'en_attente',
            'total' => $produit->prix,
        ]);

        $commande->produits()->attach($produit->id, [
            'quantite' => 1,
            'prix' => $produit->prix,
        ]);

        return redirect()->route('commandes.paiement', $commande->id);
    }

    public function paiement(Commande $commande)
    {
        if ($commande->user_id !== Auth::id()) {
            abort(403, 'Cette commande ne vous appartient pas.');
        }

        return view('buyer.paiement', compact('commande'));
    }

    public function confirmer(Commande $commande)
    {
        if ($commande->user_id !== Auth::id()) {
            abort(403, 'Cette commande ne vous appartient pas.');
        }

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
        $commandes = Commande::where('user_id', Auth::id())->latest()->get();
        return view('buyer.achats', compact('commandes'));
    }
}