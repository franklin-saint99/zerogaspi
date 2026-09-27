<x-app-layout>
<style>
    :root { --vf: #1a5c38; --vv: #27ae60; --vc: #e8f5ee; --vh: #219150; }
    * { box-sizing: border-box; }
    .dash-bg { background: #f4f6f4; min-height: 100vh; padding: 2rem; }
    .badge-role { background: var(--vc); color: var(--vf); padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 500; }
    .filtres { display: flex; gap: 0.75rem; flex-wrap: wrap; margin-bottom: 2rem; }
    .filtre-btn { padding: 0.4rem 1rem; border-radius: 20px; border: 1px solid #d1d5db; background: white; color: #374151; font-size: 0.85rem; cursor: pointer; transition: all 0.2s; text-decoration: none; }
    .filtre-btn:hover, .filtre-btn.active { background: var(--vv); color: white; border-color: var(--vv); }
    .grid-produits { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; }
    @media(max-width: 1100px) { .grid-produits { grid-template-columns: repeat(3, 1fr); } }
    @media(max-width: 768px) { .grid-produits { grid-template-columns: repeat(2, 1fr); } }
    @media(max-width: 480px) { .grid-produits { grid-template-columns: 1fr; } }
    .produit-card { background: white; border-radius: 14px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.06); transition: transform 0.2s, box-shadow 0.2s; }
    .produit-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(0,0,0,0.1); }
    .produit-img { width: 100%; height: 160px; background: #f3f4f6; display: flex; align-items: center; justify-content: center; font-size: 3rem; overflow: hidden; }
    .produit-img img { width: 100%; height: 100%; object-fit: cover; }
    .produit-body { padding: 1rem; }
    .produit-categorie { font-size: 0.75rem; color: var(--vv); font-weight: 500; text-transform: uppercase; margin-bottom: 0.3rem; }
    .produit-nom { font-size: 0.95rem; font-weight: 600; color: #1a1a1a; margin-bottom: 0.5rem; }
    .produit-desc { font-size: 0.8rem; color: #6b7280; margin-bottom: 0.75rem; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .produit-vendeur { display: flex; align-items: center; gap: 0.35rem; font-size: 0.8rem; color: #374151; margin-bottom: 0.6rem; background: #f9fafb; padding: 0.4rem 0.6rem; border-radius: 8px; flex-wrap: wrap; }
    .produit-vendeur strong { color: var(--vf); }
    .produit-footer { display: flex; justify-content: space-between; align-items: center; }
    .prix-seul { font-size: 1.1rem; font-weight: 700; color: var(--vf); }
    .badge-dispo { background: #dcfce7; color: #166534; padding: 0.2rem 0.6rem; border-radius: 20px; font-size: 0.7rem; font-weight: 500; }
    .badge-epuise { background: #fef3c7; color: #92400e; padding: 0.2rem 0.6rem; border-radius: 20px; font-size: 0.7rem; }
    .produit-peremption { font-size: 0.75rem; color: #9ca3af; margin-top: 0.5rem; margin-bottom: 0.5rem; }
    .produit-stock { font-size: 0.75rem; color: #9ca3af; margin-top: 0.3rem; }
    .panier-form { display: flex; gap: 0.5rem; align-items: center; margin-top: 0.5rem; }
    .input-quantite { width: 60px; padding: 0.4rem; border-radius: 8px; border: 1px solid #d1d5db; text-align: center; }
    .btn-panier { flex: 1; background: var(--vv); color: white; border: none; padding: 0.5rem; border-radius: 8px; font-size: 0.85rem; cursor: pointer; transition: background 0.2s; }
    .btn-panier:hover { background: var(--vh); }
    .btn-panier:disabled { background: #d1d5db; cursor: not-allowed; }
    .empty-state { text-align: center; padding: 4rem; color: #9ca3af; grid-column: 1/-1; }
    .panier-count { background: var(--vv); color: white; border-radius: 20px; padding: 0.25rem 0.75rem; font-size: 0.8rem; font-weight: 600; }
</style>

<div class="dash-bg">
    <div style="max-width:1200px;margin:0 auto;">

        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;">
            <div>
                <h1 style="font-size:1.6rem;font-weight:700;color:#1a1a1a;">🛍️ Produits disponibles</h1>
                <p style="color:#6b7280;font-size:0.9rem;margin-top:0.25rem;">Découvrez les produits anti-gaspillage près de chez vous</p>
            </div>
            <div style="display:flex;align-items:center;gap:1rem;">
                <a href="{{ route('panier.index') }}" style="display:flex;align-items:center;gap:0.5rem;text-decoration:none;background:white;padding:0.5rem 1rem;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.06);">
                    🛒 <span style="color:#374151;font-size:0.9rem;">Mon panier</span>
                    <span class="panier-count">{{ \App\Models\LignePanier::whereHas('panier', fn($q) => $q->where('user_id', Auth::id())->where('statut', 'en_cours'))->count() }}</span>                </a>
                <span class="badge-role">Acheteur</span>
            </div>
        </div>

        <form method="GET" action="{{ route('dashboard') }}" style="margin-bottom:1.5rem;">
            @if(request('categorie'))
                <input type="hidden" name="categorie" value="{{ request('categorie') }}">
            @endif
            <div style="position:relative; max-width:420px;">
                <span style="position:absolute; left:1rem; top:50%; transform:translateY(-50%); color:#9ca3af;">🔍</span>
                <input
                    type="text"
                    name="recherche"
                    value="{{ request('recherche') }}"
                    placeholder="Rechercher un produit..."
                    style="width:100%; padding:0.7rem 1rem 0.7rem 2.5rem; border-radius:10px; border:1px solid #d1d5db; font-size:0.9rem; background:white;"
                >
            </div>
        </form>

        <div class="filtres">
            <a href="{{ route('dashboard', ['recherche' => request('recherche')]) }}" class="filtre-btn {{ !request('categorie') ? 'active' : '' }}">Tous</a>
            @foreach($categories as $cat)
            <a href="{{ route('dashboard', ['categorie' => $cat->id, 'recherche' => request('recherche')]) }}" class="filtre-btn {{ request('categorie') == $cat->id ? 'active' : '' }}">
                {{ $cat->nom }}
            </a>
            @endforeach
        </div>

        @if(session('success'))
        <div style="background:#dcfce7;color:#166534;padding:0.75rem 1rem;border-radius:8px;margin-bottom:1rem;">
            ✅ {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div style="background:#fee2e2;color:#991b1b;padding:0.75rem 1rem;border-radius:8px;margin-bottom:1rem;">
            ⚠️ {{ session('error') }}
        </div>
        @endif

        <div class="grid-produits">
            @forelse($produits as $produit)
            <div class="produit-card">

                <div class="produit-img">
                    @if($produit->image)
                        <img src="{{ asset('storage/'.$produit->image) }}" alt="{{ $produit->nom }}">
                    @else
                        🥦
                    @endif
                </div>

                <div class="produit-body">
                    <p class="produit-categorie">{{ $produit->category->nom ?? 'Sans catégorie' }}</p>
                    <p class="produit-nom">{{ $produit->nom }}</p>
                    @if($produit->description)
                        <p class="produit-desc">{{ $produit->description }}</p>
                    @endif

                    @if($produit->vendeur)
                        <div class="produit-vendeur">
                            🏪 <strong>{{ $produit->vendeur->name }}</strong>
                            @if($produit->vendeur->address)
                                <span style="color:#9ca3af;">·</span> 📍 {{ $produit->vendeur->address }}
                            @endif
                        </div>
                    @endif

                    <div class="produit-footer">
                        <p class="prix-seul">
                            @if($produit->prix_initial && $produit->prix_initial > $produit->prix)
                                <span style="text-decoration:line-through;color:#9ca3af;font-weight:400;font-size:0.85rem;margin-right:0.4rem;">{{ number_format($produit->prix_initial, 2) }} €</span>
                            @endif
                            {{ number_format($produit->prix, 2) }} €
                        </p>
                        @if($produit->statut === 'disponible')
                            <span class="badge-dispo">Disponible</span>
                        @else
                            <span class="badge-epuise">Épuisé</span>
                        @endif
                    </div>

                    @if($produit->date_peremption)
                        <p class="produit-peremption">📅 Expire le : {{ \Carbon\Carbon::parse($produit->date_peremption)->format('d/m/Y') }}</p>
                    @endif

                    @php $dispo = $produit->statut === 'disponible' && $produit->stock > 0; @endphp

                    <form method="POST" action="{{ route('panier.ajouter') }}" class="panier-form">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $produit->id }}">
                        <input
                            type="number"
                            name="quantite"
                            value="1"
                            min="1"
                            max="{{ $produit->stock }}"
                            class="input-quantite"
                            {{ !$dispo ? 'disabled' : '' }}
                        >
                        <button type="submit" class="btn-panier" {{ !$dispo ? 'disabled' : '' }}>
                            🛒 Ajouter
                        </button>
                    </form>

                    @if($produit->stock > 0)
                        <p class="produit-stock">Stock disponible : {{ $produit->stock }}</p>
                    @endif
                </div>
            </div>
            @empty
            <div class="empty-state">
                <div style="font-size:3rem;">📦</div>
                @if(request('recherche'))
                    <p style="margin-top:0.5rem;">Aucun produit ne correspond à "{{ request('recherche') }}".</p>
                @else
                    <p style="margin-top:0.5rem;">Aucun produit disponible pour l'instant.</p>
                @endif
            </div>
            @endforelse
        </div>

    </div>
</div>
</x-app-layout>