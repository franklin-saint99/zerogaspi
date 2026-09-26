<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zero Gaspi - Moins de gaspi, plus d'impact</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root { --vf: #1a5c38; --vv: #15803d; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #f4f6f4; color: #1a1a1a; min-height: 100vh; display: flex; flex-direction: column; }

        .hero { flex: 1; background: linear-gradient(135deg, var(--vf), var(--vv)); padding: 4rem 2rem; text-align: center; color: white; display: flex; flex-direction: column; align-items: center; justify-content: center; }
        .hero-logo { font-size: 1.4rem; font-weight: 700; margin-bottom: 2rem; display: flex; align-items: center; justify-content: center; gap: 0.5rem; }
        .hero h1 { font-size: 2.5rem; font-weight: 800; margin-bottom: 1rem; line-height: 1.2; }
        .hero h1 em { font-style: normal; color: #d1fae5; }
        .hero p { font-size: 1.1rem; opacity: 0.95; max-width: 500px; margin: 0 auto 2.5rem; }
        .hero-btns { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }
        .btn-white { background: white; color: var(--vf); padding: 0.8rem 1.8rem; border-radius: 10px; font-weight: 600; text-decoration: none; font-size: 0.95rem; }
        .btn-outline { background: transparent; color: white; padding: 0.8rem 1.8rem; border-radius: 10px; font-weight: 600; text-decoration: none; font-size: 0.95rem; border: 2px solid white; }

        footer { background: #f4f6f4; padding: 1.5rem; text-align: center; }
        .footer-links { display: flex; justify-content: center; gap: 1.5rem; flex-wrap: wrap; margin-bottom: 0.75rem; }
        .footer-links a { color: #4b5563; text-decoration: none; font-size: 0.85rem; }
        .footer-links a:hover { text-decoration: underline; }
        .footer-copy { color: #9ca3af; font-size: 0.8rem; }

        @media(max-width: 768px) {
            .hero h1 { font-size: 1.8rem; }
        }
    </style>
</head>
<body>

    <div class="hero">
        <div class="hero-logo">🌿 Zero Gaspi</div>
        <h1>Moins de gaspi,<br><em>plus d'impact.</em></h1>
        <p>La plateforme qui connecte magasins et consommateurs pour donner une seconde vie aux produits invendus, avant qu'ils ne soient jetés. Retrait en magasin le jour même.</p>
        <div class="hero-btns">
            @auth
                <a href="{{ route('dashboard') }}" class="btn-white">Accéder à mon espace</a>
            @else
                <a href="{{ route('register') }}" class="btn-white">Commencer maintenant</a>
                <a href="{{ route('login') }}" class="btn-outline">Se connecter</a>
            @endauth
        </div>
    </div>

    <footer>
        <div class="footer-links">
            <a href="{{ route('home') }}">Accueil</a>
            <a href="{{ route('contact') }}">Contact</a>
            <a href="{{ route('mentions-legales') }}">Mentions légales</a>
            <a href="{{ route('confidentialite') }}">Politique de confidentialité</a>
        </div>
        <div class="footer-copy">© 2026 Zero Gaspi — Ensemble, réduisons le gaspillage alimentaire.</div>
    </footer>

</body>
</html>