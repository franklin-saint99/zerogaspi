<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zero Gaspi - Moins de gaspi, plus d'impact</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root { --vf: #1a5c38; --vv: #27ae60; --vc: #e8f5ee; --vh: #219150; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #f4f6f4; color: #1a1a1a; }

        .hero { background: linear-gradient(135deg, var(--vf), var(--vv)); padding: 5rem 2rem; text-align: center; color: white; }
        .hero-logo { font-size: 1.4rem; font-weight: 700; margin-bottom: 2rem; display: flex; align-items: center; justify-content: center; gap: 0.5rem; }
        .hero h1 { font-size: 2.5rem; font-weight: 800; margin-bottom: 1rem; line-height: 1.2; }
        .hero h1 em { font-style: normal; color: #d1fae5; }
        .hero p { font-size: 1.1rem; opacity: 0.95; max-width: 600px; margin: 0 auto 2rem; }
        .hero-btns { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }
        .btn-white { background: white; color: var(--vf); padding: 0.8rem 1.8rem; border-radius: 10px; font-weight: 600; text-decoration: none; font-size: 0.95rem; transition: transform 0.2s; }
        .btn-white:hover { transform: translateY(-2px); }
        .btn-outline { background: transparent; color: white; padding: 0.8rem 1.8rem; border-radius: 10px; font-weight: 600; text-decoration: none; font-size: 0.95rem; border: 2px solid white; transition: transform 0.2s; }
        .btn-outline:hover { transform: translateY(-2px); background: rgba(255,255,255,0.1); }

        .stats { max-width: 900px; margin: -3rem auto 3rem; padding: 0 2rem; position: relative; z-index: 10; }
        .stats-grid { background: white; border-radius: 16px; box-shadow: 0 8px 24px rgba(0,0,0,0.1); display: grid; grid-template-columns: repeat(3, 1fr); }
        .stat-item { text-align: center; padding: 2rem 1rem; }
        .stat-item:not(:last-child) { border-right: 1px solid #f3f4f6; }
        .stat-num { font-size: 2rem; font-weight: 800; color: var(--vf); }
        .stat-lbl { font-size: 0.85rem; color: #6b7280; margin-top: 0.3rem; }

        .section { max-width: 1100px; margin: 0 auto; padding: 3rem 2rem; }
        .section h2 { font-size: 1.8rem; font-weight: 700; text-align: center; margin-bottom: 0.5rem; color: #1a1a1a; }
        .section-sub { text-align: center; color: #6b7280; font-size: 1rem; margin-bottom: 2.5rem; }

        .cards-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
        .card { background: white; border-radius: 14px; padding: 1.8rem; box-shadow: 0 2px 8px rgba(0,0,0,0.06); text-align: center; }
        .card-icon { font-size: 2.5rem; margin-bottom: 1rem; }
        .card h3 { font-size: 1.1rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--vf); }
        .card p { font-size: 0.9rem; color: #6b7280; line-height: 1.5; }

        .cta { background: var(--vc); text-align: center; padding: 3rem 2rem; margin-top: 2rem; }
        .cta h2 { font-size: 1.6rem; font-weight: 700; color: var(--vf); margin-bottom: 0.8rem; }
        .cta p { color: #374151; margin-bottom: 1.5rem; }
        .btn-vert { background: var(--vv); color: white; padding: 0.8rem 2rem; border-radius: 10px; font-weight: 600; text-decoration: none; font-size: 0.95rem; display: inline-block; transition: background 0.2s; }
        .btn-vert:hover { background: var(--vh); }

        footer { text-align: center; padding: 2rem; color: #9ca3af; font-size: 0.85rem; }

        @media(max-width: 768px) {
            .hero h1 { font-size: 1.8rem; }
            .cards-grid { grid-template-columns: 1fr; }
            .stats-grid { grid-template-columns: 1fr; }
            .stat-item:not(:last-child) { border-right: none; border-bottom: 1px solid #f3f4f6; }
        }
    </style>
</head>
<body>

    <div class="hero">
        <div class="hero-logo">🌿 Zero Gaspi</div>
        <h1>Moins de gaspi,<br><em>plus d'impact.</em></h1>
        <p>La plateforme qui connecte magasins et consommateurs pour donner une seconde vie aux produits invendus, avant qu'ils ne soient jetés.</p>
        <div class="hero-btns">
            @auth
                <a href="{{ route('dashboard') }}" class="btn-white">Accéder à mon espace</a>
            @else
                <a href="{{ route('register') }}" class="btn-white">Commencer maintenant</a>
                <a href="{{ route('login') }}" class="btn-outline">Se connecter</a>
            @endauth
        </div>
    </div>

    <div class="stats">
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-num">2 400+</div>
                <div class="stat-lbl">Magasins partenaires</div>
            </div>
            <div class="stat-item">
                <div class="stat-num">18 t</div>
                <div class="stat-lbl">Nourriture économisée</div>
            </div>
            <div class="stat-item">
                <div class="stat-num">96%</div>
                <div class="stat-lbl">Clients satisfaits</div>
            </div>
        </div>
    </div>

    <div class="section">
        <h2>Comment ça marche ?</h2>
        <p class="section-sub">Trois étapes simples pour lutter contre le gaspillage alimentaire</p>
        <div class="cards-grid">
            <div class="card">
                <div class="card-icon">🏪</div>
                <h3>Les vendeurs publient</h3>
                <p>Les magasins mettent en ligne leurs produits proches de la date de péremption, à prix réduit.</p>
            </div>
            <div class="card">
                <div class="card-icon">🛒</div>
                <h3>Les acheteurs commandent</h3>
                <p>Parcourez le catalogue, ajoutez au panier et réservez vos produits en quelques clics.</p>
            </div>
            <div class="card">
                <div class="card-icon">📦</div>
                <h3>Récupération en magasin</h3>
                <p>Passez récupérer votre commande directement en magasin, au moment qui vous convient.</p>
            </div>
        </div>
    </div>

    <div class="cta">
        <h2>Prêt à agir contre le gaspillage ?</h2>
        <p>Rejoignez la communauté Zero Gaspi dès aujourd'hui.</p>
        @auth
            <a href="{{ route('dashboard') }}" class="btn-vert">Accéder à mon espace</a>
        @else
            <a href="{{ route('register') }}" class="btn-vert">Créer un compte gratuitement</a>
        @endauth
    </div>

    <footer>
        © 2026 Zero Gaspi — Ensemble, réduisons le gaspillage alimentaire.
    </footer>

</body>
</html>