<x-app-layout>
<style>
    :root { --vf: #1a5c38; --vv: #27ae60; --vc: #e8f5ee; --vh: #219150; }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    .dash-bg { background: #f4f6f4; min-height: 100vh; padding: 2rem; }
    .grid-3 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 2rem; }
    .stat-card { background: white; border-radius: 14px; padding: 1.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border-left: 4px solid var(--vv); }
    .stat-number { font-size: 2rem; font-weight: 700; color: var(--vf); margin-top: 0.5rem; }
    .stat-label { font-size: 0.85rem; color: #6b7280; }
    .table-card { background: white; border-radius: 14px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); overflow: hidden; }
    .table-header { display: flex; justify-content: space-between; align-items: center; padding: 1.2rem 1.5rem; border-bottom: 1px solid #f3f4f6; }
    .table-header h2 { font-size: 1rem; font-weight: 600; color: var(--vf); }
    table { width: 100%; border-collapse: collapse; }
    thead th { padding: 0.75rem 1.5rem; text-align: left; font-size: 0.8rem; font-weight: 600; color: #6b7280; background: #f9fafb; text-transform: uppercase; }
    tbody td { padding: 1rem 1.5rem; font-size: 0.9rem; color: #374151; border-top: 1px solid #f3f4f6; }
    tbody tr:hover { background: #f9fafb; }
    .badge { padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.75rem; font-weight: 500; }
    .badge-dispo { background: #dcfce7; color: #166534; }
    .badge-epuise { background: #fef3c7; color: #92400e; }
    .badge-expire { background: #fee2e2; color: #991b1b; }
    .btn-vert { background: var(--vv); color: white; padding: 0.5rem 1.2rem; border-radius: 8px; font-size: 0.875rem; border: none; cursor: pointer; text-decoration: none; display: inline-block; }
    .btn-vert:hover { background: var(--vh); }
    .badge-role { background: var(--vc); color: var(--vf); padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 500; }
    .empty-state { text-align: center; padding: 3rem; color: #9ca3af; }
    .modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); z-index: 99999; }
    .modal-overlay.active { display: flex; align-items: center; justify-content: center; }
    .modal-box { background: white; border-radius: 16px; padding: 2rem; width: 95%; max-width: 580px; max-height: 85vh; overflow-y: auto; position: relative; }
    .modal-box h2 { color: var(--vf); font-size: 1.1rem; font-weight: 700; margin-bottom: 1.5rem; }
    .modal-close { position: absolute; top: 1rem; right: 1rem; background: #f3f4f6; border: none; border-radius: 50%; width: 32px; height: 32px; font-size: 1rem; cursor: pointer; color: #6b7280; }
    .f-group { margin-bottom: 1rem; }
    .f-group label { display: block; font-size: 0.85rem; font-weight: 500; color: #374151; margin-bottom: 0.4rem; }
    .f-group input, .f-group select, .f-group textarea { width: 100%; padding: 0.6rem 0.9rem; border: 1px solid #d1d5db; border-radius: 8px; font-size: 0.9rem; color: #374151; background: white; }
    .f-group input:focus, .f-group select:focus, .f-group textarea:focus { outline: none; border-color: var(--vv); box-shadow: 0 0 0 3px rgba(39,174,96,0.15); }
    .f-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .modal-footer { display: flex; justify-content: flex-end; gap: 1rem; margin-top: 1.5rem; }
    .btn-cancel { background: white; color: #6b7280; border: 1px solid #d1d5db; padding: 0.5rem 1.2rem; border-radius: 8px; cursor: pointer; font-size: 0.875rem; }
    @media(max-width: 900px) { .grid-3 { grid-template-columns: repeat(2, 1fr); } }
    @media(max-width: 768px) { .f-row { grid-template-columns: 1fr; } }
</style>

<div class="dash-bg">
    <div style="max-width:1100px;margin:0 auto;">

        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;">
            <div>
                <h1 style="font-size:1.6rem;font-weight:700;color:#1a1a1a;">Bonjour, {{ Auth::user()->name }} 👋</h1>
                <p style="color:#6b7280;font-size:0.9rem;margin-top:0.25rem;">Gérez vos produits et commandes</p>
            </div>
            <span class="badge-role">Vendeur</span>
        </div>

        <div class="grid-3">
            <div class="stat-card">
                <p class="stat-label">Mes produits</p>
                <p class="stat-number">{{ $totalProduits ?? 0 }}</p>
            </div>
            <div class="stat-card" style="border-left-color:#f59e0b;">
                <p class="stat-label">Produits vendus</p>
                <p class="stat-number" style="color:#b45309;">{{ $produitsVendus ?? 0 }}</p>
            </div>
            <div class="stat-card" style="border-left-color:#ef4444;">
                <p class="stat-label">Produits expirés</p>
                <p class="stat-number" style="color:#991b1b;">{{ $produitsExpires ?? 0 }}</p>
            </div>
            <div class="stat-card" style="border-left-color:#219150;">
                <p class="stat-label">🌍 Produits sauvés du gaspillage</p>
                <p class="stat-number" style="color:#1a5c38;">{{ $produitsSauves ?? 0 }}</p>
            </div>
        </div>

        <div class="table-card">
            <div class="table-header">
                <h2>🛒 Mes produits</h2>
                <button class="btn-vert" id="btnOuvrir">+ Ajouter un produit</button>
            </div>

            @if(isset($produits) && $produits->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Catégorie</th>
                        <th>Prix</th>
                        <th>Stock</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produits as $produit)
                    <tr>
                        <td><strong>{{ $produit->nom }}</strong></td>
                        <td>{{ $produit->category->nom ?? '-' }}</td>
                        <td>
                            @if($produit->prix_initial && $produit->prix_initial > $produit->prix)
                                <span style="text-decoration:line-through;color:#9ca3af;font-size:0.8rem;margin-right:0.3rem;">{{ number_format($produit->prix_initial, 2) }} €</span>
                            @endif
                            {{ number_format($produit->prix, 2) }} €
                        </td>
                        <td>{{ $produit->stock }}</td>
                        <td>
                            <span class="badge badge-{{ $produit->statut === 'disponible' ? 'dispo' : ($produit->statut === 'epuise' ? 'epuise' : 'expire') }}">
                                {{ ucfirst($produit->statut) }}
                            </span>
                        </td>
                        <td style="white-space:nowrap;">
                            <a href="{{ route('seller.products.edit', $produit->id) }}" style="background:#e0e7ff;color:#3730a3;border:none;padding:0.3rem 0.8rem;border-radius:6px;font-size:0.8rem;cursor:pointer;text-decoration:none;display:inline-block;margin-right:0.4rem;">✏️</a>
                            <form method="POST" action="{{ route('seller.products.destroy', $produit->id) }}" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" style="background:#fee2e2;color:#991b1b;border:none;padding:0.3rem 0.8rem;border-radius:6px;font-size:0.8rem;cursor:pointer;" onclick="return confirm('Supprimer ?')">🗑️</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state">
                <div style="font-size:3rem;">📦</div>
                <p style="margin-top:0.5rem;">Aucun produit pour l'instant.</p>
                <button class="btn-vert" style="margin-top:1rem;" id="btnOuvrir2">+ Ajouter votre premier produit</button>
            </div>
            @endif
        </div>

    </div>
</div>

<div class="modal-overlay" id="modal">
    <div class="modal-box">
        <button class="modal-close" id="btnFermer">✕</button>
        <h2>➕ Ajouter un produit</h2>

        @if ($errors->any())
            <div style="background:#fee2e2;color:#991b1b;padding:0.75rem 1rem;border-radius:8px;margin-bottom:1rem;font-size:0.85rem;">
                <ul style="margin:0;padding-left:1.2rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('seller.products.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="f-group">
                <label>Nom du produit *</label>
                <input type="text" name="nom" placeholder="Ex: Tomates cerises" required>
            </div>

            <div class="f-group">
                <label>Description</label>
                <textarea name="description" rows="2" placeholder="Décrivez votre produit..."></textarea>
            </div>

            <div class="f-row">
                <div class="f-group">
                    <label>Prix initial (€)</label>
                    <input type="number" name="prix_initial" step="0.01" min="0" placeholder="Ex: 5.00">
                </div>
                <div class="f-group">
                    <label>Prix (€) *</label>
                    <input type="number" name="prix" step="0.01" min="0" placeholder="0.00" required>
                </div>
            </div>

            <div class="f-row">
                <div class="f-group">
                    <label>Stock *</label>
                    <input type="number" name="stock" min="0" placeholder="10" required>
                </div>
                <div class="f-group">
                    <label>Catégorie *</label>
                    <select name="category_id" required>
                        <option value="">-- Choisir --</option>
                        @foreach(\App\Models\Category::all() as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->nom }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="f-group">
                <label>Date de péremption *</label>
                <input type="date" name="date_peremption" required>
            </div>

            <div class="f-group">
                <label>Image</label>
                <input type="file" name="image" accept="image/*">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-cancel" id="btnAnnuler">Annuler</button>
                <button type="submit" class="btn-vert">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

<script>
    const modal = document.getElementById('modal');
    function ouvrirModal() { modal.classList.add('active'); }
    function fermerModal() { modal.classList.remove('active'); }
    document.getElementById('btnOuvrir').addEventListener('click', ouvrirModal);
    document.getElementById('btnFermer').addEventListener('click', fermerModal);
    document.getElementById('btnAnnuler').addEventListener('click', fermerModal);
    const btn2 = document.getElementById('btnOuvrir2');
    if (btn2) btn2.addEventListener('click', ouvrirModal);
    modal.addEventListener('click', e => { if (e.target === modal) fermerModal(); });
</script>

</x-app-layout>