<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalVendeurs = User::where('role', 'vendeur')->count();
        $totalAcheteurs = User::where('role', 'acheteur')->count();
        $vendeursDesactives = User::where('role', 'vendeur')->where('actif', false)->count();

        return view('admin.dashboard', compact('totalVendeurs', 'totalAcheteurs', 'vendeursDesactives'));
    }

    public function vendeurs()
    {
        $vendeurs = User::where('role', 'vendeur')
            ->withCount('produits')
            ->latest()
            ->get();

        return view('admin.vendeurs', compact('vendeurs'));
    }

    public function acheteurs()
    {
        $acheteurs = User::where('role', 'acheteur')
            ->latest()
            ->get();

        return view('admin.acheteurs', compact('acheteurs'));
    }

    public function toggleUser($id)
    {
        $user = User::whereIn('role', ['vendeur', 'acheteur'])->findOrFail($id);

        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'Action impossible sur votre propre compte.');
        }

        $user->update(['actif' => !$user->actif]);

        $message = $user->actif
            ? "Le compte \"{$user->name}\" a été réactivé."
            : "Le compte \"{$user->name}\" a été désactivé.";

        return redirect()->back()->with('success', $message);
    }

    public function produits()
    {
        $produits = Product::with(['category', 'vendeur'])
            ->latest()
            ->get();

        return view('admin.produits', compact('produits'));
    }

    public function commandes()
    {
        $commandes = \App\Models\Commande::with(['user', 'produits'])
            ->latest()
            ->get();

        return view('admin.commandes', compact('commandes'));
    }
}