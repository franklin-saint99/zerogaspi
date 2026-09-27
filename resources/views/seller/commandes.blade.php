<x-app-layout>
<style>
    :root { --vf: #1a5c38; --vv: #27ae60; --vc: #e8f5ee; --vh: #219150; }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    .dash-bg { background: #f4f6f4; min-height: 100vh; padding: 2rem; }
    .badge-role { background: var(--vc); color: var(--vf); padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 500; }
    .commande-card { background: white; border-radius: 14px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); margin-bottom: 1.5rem; overflow: hidden; }
    .commande-header { display: flex; justify-content: space-between; align-items: center; padding: 1rem 1.5rem; background: #f9fafb; border-bottom: 1px solid #f3f4f6; }
    .commande-info { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; padding: 1rem 1.5rem; border-bottom: 1px solid #f3f4f6; background: #fafafa; }
    .commande-info-item { font-size: 0.85rem; }
    .commande-info-item span { color: #6b7280; display: block; font-size: 0.75rem; margin-bottom: 0.2rem; }
    .commande-info-item strong { color: #1a1a1a; }
    table { width: 100%; border-collapse: collapse; }
    thead th { padding: 0.75rem 1.5rem; text-align: left; font-size: 0.8rem; font-weight: 600; color: #6b7280; text-transform: uppercase; background: #f9fafb; }
    tbody td { padding: 1rem 1.5rem; font-size: 0.9rem; color: #374151; border-top: 1px solid #f3f4f6; }
    tbody tr:hover { background: #f9fafb; }
    .commande-footer { display: flex; justify-content: flex-end; align-items: center; padding: 1rem 1.5rem; border-top: 1px solid #f3f4f6; background: #f9fafb; }
    .badge { padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.75rem; font-weight: 500; }
    .badge-attente { background: #fef3c7; color: #92400e; }
    .badge-prete { background: #dcfce7; color: #166534; }
    .badge-recuperee { background: #e0e7ff; color: #3730a3; }
    .empty-state { text-align: center; padding: 4rem; color: #9ca3af; background: white; border-radius: 14px; }
    .btn-recuperee { background: var(--vv); color: white; border: none; padding: 0.5rem 1.1rem; border-radius: 8px; font-size: 0.85rem; cursor: pointer; }
    .btn-recuperee:hover { background: var(--vh); }
</style>

<div class="dash-bg">
    <div style="max-width:1100px;margin:0 auto;">

        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;">
            <div>
                <h1 style="font-size:1.6rem;font-weight:700;color:#1a1a1a;">Mes commandes 📦</h1>
                <p style="color:#6b7280;font-size:0.9rem;margin-top:0.25rem;">Liste des commandes reçues</p>
            </div>
            <span class="badge-role">Vendeur</span>
        </div>

        @if(session('success'))
        <div style="background:#dcfce7;color:#166534;padding:0.75rem 1rem;border-radius:8px;margin-bottom:1rem;">
            ✅ {{ session('success') }}
        </div>
        @endif

        @if($commandes->count() > 0)
            @foreach($commandes as $commande)
            <div class="commande-card">

                {{-- Header commande --}}
                <div class="commande-header">
                    <div>
                        <strong style="color:#1a1a1a;">Commande #{{ $commande->id }}</strong>
                        <span style="color:#6b7280;font-size:0.85rem;margin-left:1rem;">{{ $commande->created_at->format('d/m/Y à H:i') }}</span>
                    </div>
                    @if($commande->statut === 'en_attente')
                        <span class="badge badge-attente">⏳ En attente</span>
                    @elseif($commande->statut === 'prete')
                        <span class="badge badge-prete">✅ Prête</span>
                    @else
                        <span class="badge badge-recuperee">📦 Récupérée</span>
                    @endif
                </div>

                {{-- Infos acheteur --}}
                <div class="commande-info">
                    <div class="commande-info-item">
                        <span>👤 Acheteur</span>
                        <strong>{{ $commande->user->name ?? '-' }}</strong>
                    </div>
                    <div class="commande-info-item">
                        <span>📧 Email</span>
                        <strong>{{ $commande->user->email ?? '-' }}</strong>
                    </div>
                    <div class="commande-info-item">
                        <span>💰 Total</span>
                        <strong style="color:#1a5c38;">{{ number_format($commande->total, 2) }} €</strong>
                    </div>
                </div>

                {{-- Produits --}}
                <table>
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Prix unitaire</th>
                            <th>Quantité</th>
                            <th>Sous-total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($commande->produits as $produit)
                        <tr>
                            <td><strong>{{ $produit->nom }}</strong></td>
                            <td>{{ number_format($produit->pivot->prix_unitaire, 2) }} €</td>
                            <td>{{ $produit->pivot->quantite }}</td>
                            <td>{{ number_format($produit->pivot->prix_unitaire * $produit->pivot->quantite, 2) }} €</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Footer : marquer comme récupérée --}}
                @if($commande->statut !== 'recuperee')
                <div class="commande-footer">
                    <form method="POST" action="{{ route('seller.commandes.update', $commande->id) }}">
                        @csrf @method('PUT')
                        <input type="hidden" name="statut" value="recuperee">
                        <button type="submit" class="btn-recuperee">📦 Marquer comme récupérée</button>
                    </form>
                </div>
                @endif

            </div>
            @endforeach
        @else
        <div class="empty-state">
            <div style="font-size:3rem;">📭</div>
            <p style="margin-top:0.5rem;">Aucune commande reçue pour l'instant.</p>
        </div>
        @endif

    </div>
</div>
</x-app-layout>