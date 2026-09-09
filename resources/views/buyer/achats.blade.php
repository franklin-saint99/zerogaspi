<x-app-layout>
<style>
    :root { --vf: #1a5c38; --vv: #27ae60; --vc: #e8f5ee; }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    .dash-bg { background: #f4f6f4; min-height: 100vh; padding: 2rem; }
    .badge-role { background: var(--vc); color: var(--vf); padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 500; }
    .commande-card { background: white; border-radius: 14px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); margin-bottom: 1.5rem; overflow: hidden; }
    .commande-header { display: flex; justify-content: space-between; align-items: center; padding: 1rem 1.5rem; background: #f9fafb; border-bottom: 1px solid #f3f4f6; }
    .commande-header span { font-size: 0.85rem; color: #6b7280; }
    .commande-header strong { color: #1a1a1a; }
    table { width: 100%; border-collapse: collapse; }
    thead th { padding: 0.75rem 1.5rem; text-align: left; font-size: 0.8rem; font-weight: 600; color: #6b7280; text-transform: uppercase; }
    tbody td { padding: 1rem 1.5rem; font-size: 0.9rem; color: #374151; border-top: 1px solid #f3f4f6; }
    tbody tr:hover { background: #f9fafb; }
    .commande-footer { display: flex; justify-content: flex-end; align-items: center; padding: 1rem 1.5rem; border-top: 1px solid #f3f4f6; gap: 1rem; }
    .badge { padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.75rem; font-weight: 500; }
    .badge-attente { background: #fef3c7; color: #92400e; }
    .badge-prete { background: #dcfce7; color: #166534; }
    .badge-recuperee { background: #e0e7ff; color: #3730a3; }
    .empty-state { text-align: center; padding: 4rem; color: #9ca3af; background: white; border-radius: 14px; }
</style>

<div class="dash-bg">
    <div style="max-width:1100px;margin:0 auto;">

        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;">
            <div>
                <h1 style="font-size:1.6rem;font-weight:700;color:#1a1a1a;">Mes achats 🛍️</h1>
                <p style="color:#6b7280;font-size:0.9rem;margin-top:0.25rem;">Historique de vos commandes</p>
            </div>
            <span class="badge-role">Acheteur</span>
        </div>

        @if($commandes->count() > 0)
            @foreach($commandes as $commande)
            <div class="commande-card">

                <div class="commande-header">
                    <div>
                        <strong>Commande #{{ $commande->id }}</strong>
                        <span style="margin-left:1rem;">{{ $commande->created_at->format('d/m/Y à H:i') }}</span>
                    </div>
                    <div style="display:flex;align-items:center;gap:1rem;">
                        @if($commande->statut === 'en_attente')
                            <span class="badge badge-attente">⏳ En attente</span>
                        @elseif($commande->statut === 'prete')
                            <span class="badge badge-prete">✅ Prête à récupérer</span>
                        @else
                            <span class="badge badge-recuperee">📦 Récupérée</span>
                        @endif
                    </div>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Quantité</th>
                            <th>Prix unitaire</th>
                            <th>Sous-total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($commande->produits as $produit)
                        <tr>
                            <td><strong>{{ $produit->nom }}</strong></td>
                            <td>{{ $produit->pivot->quantite }}</td>
                            <td>{{ number_format($produit->pivot->prix, 2) }} €</td>
                            <td>{{ number_format($produit->pivot->prix * $produit->pivot->quantite, 2) }} €</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="commande-footer">
                    <span style="font-size:0.9rem;color:#6b7280;">Total :</span>
                    <strong style="font-size:1.1rem;color:#1a5c38;">{{ number_format($commande->total, 2) }} €</strong>
                </div>

            </div>
            @endforeach
        @else
        <div class="empty-state">
            <div style="font-size:3rem;">📭</div>
            <p style="margin-top:0.5rem;">Aucune commande pour l'instant.</p>
            <a href="{{ route('dashboard') }}" style="display:inline-block;margin-top:1rem;background:#27ae60;color:white;padding:0.5rem 1.2rem;border-radius:8px;text-decoration:none;font-size:0.875rem;">
                Voir les produits
            </a>
        </div>
        @endif

    </div>
</div>
</x-app-layout>