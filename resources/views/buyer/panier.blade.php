<x-app-layout>
<style>
    :root { --vf: #1a5c38; --vv: #27ae60; --vc: #e8f5ee; --vh: #219150; }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    .dash-bg { background: #f4f6f4; min-height: 100vh; padding: 2rem; }
    .badge-role { background: var(--vc); color: var(--vf); padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 500; }
    .panier-card { background: white; border-radius: 14px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); overflow: hidden; margin-bottom: 1.5rem; }
    .panier-header { padding: 1.2rem 1.5rem; border-bottom: 1px solid #f3f4f6; }
    .panier-header h2 { font-size: 1rem; font-weight: 600; color: var(--vf); }
    table { width: 100%; border-collapse: collapse; }
    thead th { padding: 0.75rem 1.5rem; text-align: left; font-size: 0.8rem; font-weight: 600; color: #6b7280; background: #f9fafb; text-transform: uppercase; }
    tbody td { padding: 1rem 1.5rem; font-size: 0.9rem; color: #374151; border-top: 1px solid #f3f4f6; }
    tbody tr:hover { background: #f9fafb; }
    .total-card { background: white; border-radius: 14px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); padding: 1.5rem; }
    .total-card h2 { font-size: 1rem; font-weight: 600; color: var(--vf); margin-bottom: 1rem; }
    .total-ligne { display: flex; justify-content: space-between; margin-bottom: 0.75rem; font-size: 0.9rem; color: #374151; }
    .total-final { display: flex; justify-content: space-between; font-size: 1.1rem; font-weight: 700; color: var(--vf); border-top: 1px solid #f3f4f6; padding-top: 0.75rem; margin-top: 0.75rem; }
    .btn-vert { width: 100%; background: var(--vv); color: white; border: none; padding: 0.8rem; border-radius: 10px; font-size: 1rem; font-weight: 600; cursor: pointer; margin-top: 1rem; }
    .btn-vert:hover { background: var(--vh); }
    .btn-danger { background: #fee2e2; color: #991b1b; border: none; padding: 0.3rem 0.8rem; border-radius: 6px; font-size: 0.8rem; cursor: pointer; }
    .empty-state { text-align: center; padding: 4rem; color: #9ca3af; background: white; border-radius: 14px; }
</style>

<div class="dash-bg">
    <div style="max-width:1100px;margin:0 auto;">

        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;">
            <div>
                <h1 style="font-size:1.6rem;font-weight:700;color:#1a1a1a;">Mon panier 🛒</h1>
                <p style="color:#6b7280;font-size:0.9rem;margin-top:0.25rem;">{{ $lignes->count() }} produit(s) dans votre panier</p>
            </div>
            <span class="badge-role">Acheteur</span>
        </div>

        @if(session('success'))
            <div style="background:#dcfce7;color:#166534;padding:0.75rem 1rem;border-radius:8px;margin-bottom:1rem;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="background:#fee2e2;color:#991b1b;padding:0.75rem 1rem;border-radius:8px;margin-bottom:1rem;">
                {{ session('error') }}
            </div>
        @endif

        @if($lignes->count() > 0)
        <div style="display:grid;grid-template-columns:2fr 1fr;gap:1.5rem;align-items:start;">

            <div class="panier-card">
                <div class="panier-header">
                    <h2>🛍️ Produits</h2>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Prix</th>
                            <th>Quantité</th>
                            <th>Sous-total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lignes as $ligne)
                        <tr>
                            <td><strong>{{ $ligne->product->nom }}</strong></td>
                            <td>{{ number_format($ligne->product->prix, 2) }} €</td>
                            <td>{{ $ligne->quantite }}</td>
                            <td>{{ number_format($ligne->product->prix * $ligne->quantite, 2) }} €</td>
                            <td>
                                <form method="POST" action="{{ route('panier.supprimer', $ligne->id) }}">
                                    @csrf @method('DELETE')
                                    <button class="btn-danger" onclick="return confirm('Supprimer ?')">🗑️</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="total-card">
                <h2>💰 Récapitulatif</h2>
                @foreach($lignes as $ligne)
                <div class="total-ligne">
                    <span>{{ $ligne->product->nom }}</span>
                    <span>{{ number_format($ligne->product->prix * $ligne->quantite, 2) }} €</span>
                </div>
                @endforeach
                <div class="total-final">
                    <span>Total</span>
                    <span>{{ number_format($total, 2) }} €</span>
                </div>
                <form method="POST" action="{{ route('panier.commander') }}">
                    @csrf
                    <button type="submit" class="btn-vert">✅ Passer la commande</button>
                </form>
                <a href="{{ route('dashboard') }}" style="display:block;text-align:center;margin-top:0.75rem;color:#6b7280;font-size:0.85rem;text-decoration:none;">
                    ← Continuer mes achats
     F           </a>
            </div>

        </div>
        @else
        <div class="empty-state">
            <div style="font-size:3rem;">🛒</div>
            <p style="margin-top:0.5rem;">Votre panier est vide.</p>
            <a href="{{ route('dashboard') }}" style="display:inline-block;margin-top:1rem;background:#27ae60;color:white;padding:0.5rem 1.2rem;border-radius:8px;text-decoration:none;font-size:0.875rem;">
                Voir les produits
            </a>
        </div>
        @endif

    </div>
</div>
</x-app-layout>