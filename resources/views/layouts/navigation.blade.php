<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zero Gaspi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<nav style="background:white; border-bottom: 1px solid #e5e7eb; box-shadow: 0 1px 4px rgba(0,0,0,0.06);">
    <div style="max-width:1200px; margin:0 auto; padding:0 1.5rem; display:flex; justify-content:space-between; align-items:center; height:64px;">
        <a href="{{ route('home') }}" style="font-weight:700; font-size:1.2rem; color:#1a5c38; text-decoration:none;">
            🌿 Zero Gaspi
        </a>
        <div style="display:flex; align-items:center; gap:1.5rem;">
            <a href="{{ route('home') }}" style="color:#4b5563; text-decoration:none; font-size:0.9rem;">Accueil</a>
            <a href="{{ route('contact') }}" style="color:#4b5563; text-decoration:none; font-size:0.9rem;">Contact</a>
            @auth
                {{-- ADMIN --}}
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" style="color:#4b5563; text-decoration:none; font-size:0.9rem;">Dashboard</a>
                    <a href="{{ route('admin.vendeurs') }}" style="color:#4b5563; text-decoration:none; font-size:0.9rem;">Utilisateurs</a>
                    <a href="{{ route('admin.produits') }}" style="color:#4b5563; text-decoration:none; font-size:0.9rem;">Produits</a>
                    <a href="{{ route('categories.index') }}" style="color:#4b5563; text-decoration:none; font-size:0.9rem;">Catégories</a>
                @endif

                {{-- VENDEUR --}}
                @if(Auth::user()->role === 'vendeur')
                    <a href="{{ route('seller.dashboard') }}" style="color:#4b5563; text-decoration:none; font-size:0.9rem;">Dashboard</a>
                    <a href="{{ route('seller.commandes') }}" style="color:#4b5563; text-decoration:none; font-size:0.9rem;">Mes commandes</a>

                    @php
                        $alertesNonLues = \App\Models\Alerte::where('user_id', Auth::id())->where('lu', false)->latest()->get();
                    @endphp

                    <div style="position:relative;">
                        <button onclick="document.getElementById('menuAlertes').classList.toggle('active')" style="background:none; border:none; cursor:pointer; position:relative; font-size:1.2rem; padding:0.3rem;">
                            🔔
                            @if($alertesNonLues->count() > 0)
                                <span style="position:absolute; top:-2px; right:-2px; background:#dc2626; color:white; font-size:0.65rem; font-weight:700; border-radius:50%; width:16px; height:16px; display:flex; align-items:center; justify-content:center;">
                                    {{ $alertesNonLues->count() }}
                                </span>
                            @endif
                        </button>

                        <div id="menuAlertes" style="display:none; position:absolute; right:0; top:calc(100% + 8px); background:white; border-radius:10px; box-shadow:0 8px 24px rgba(0,0,0,0.15); width:320px; max-height:400px; overflow-y:auto; z-index:1000;">
                            <div style="padding:0.75rem 1rem; border-bottom:1px solid #f3f4f6; font-weight:600; font-size:0.85rem; color:#374151;">
                                Notifications
                            </div>
                            @forelse($alertesNonLues as $alerte)
                                <form method="POST" action="{{ route('seller.alertes.lue', $alerte->id) }}" style="margin:0;">
                                    @csrf @method('PUT')
                                    <button type="submit" style="display:block; width:100%; text-align:left; padding:0.75rem 1rem; border:none; background:white; border-bottom:1px solid #f3f4f6; cursor:pointer; font-size:0.8rem; color:#374151;">
                                        ⚠️ {{ $alerte->message }}
                                        <div style="color:#9ca3af; font-size:0.7rem; margin-top:0.25rem;">{{ $alerte->created_at->diffForHumans() }}</div>
                                    </button>
                                </form>
                            @empty
                                <div style="padding:1.5rem; text-align:center; color:#9ca3af; font-size:0.85rem;">
                                    Aucune notification
                                </div>
                            @endforelse
                        </div>
                    </div>
                @endif

                {{-- ACHETEUR --}}
                @if(Auth::user()->role === 'acheteur')
                    <a href="{{ route('dashboard') }}" style="color:#4b5563; text-decoration:none; font-size:0.9rem;">Mon espace</a>
                    <a href="{{ route('acheteur.achats') }}" style="color:#4b5563; text-decoration:none; font-size:0.9rem;">Mes achats</a>
                @endif

                <span style="color:#374151; font-weight:500; font-size:0.9rem;">{{ Auth::user()->name }}</span>

                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit" style="background:#dc2626; color:white; border:none; padding:0.4rem 1rem; border-radius:8px; font-size:0.85rem; cursor:pointer;">
                        Déconnexion
                    </button>
                </form>

            @else
                <a href="{{ route('login') }}" style="color:#4b5563; text-decoration:none; font-size:0.9rem;">Connexion</a>
                <a href="{{ route('register') }}" style="background:#27ae60; color:white; padding:0.4rem 1rem; border-radius:8px; font-size:0.85rem; text-decoration:none;">Inscription</a>
            @endauth
        </div>
    </div>
</nav>

<script>
    document.addEventListener('click', function(e) {
        const menu = document.getElementById('menuAlertes');
        if (!menu) return;
        const bouton = e.target.closest('button[onclick]');
        if (!bouton && !menu.contains(e.target)) {
            menu.style.display = 'none';
            menu.classList.remove('active');
        }
    });
    document.addEventListener('DOMContentLoaded', function() {
        const style = document.createElement('style');
        style.textContent = '#menuAlertes.active { display: block !important; }';
        document.head.appendChild(style);
    });
</script>

</body>
</html>  