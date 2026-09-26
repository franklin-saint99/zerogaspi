<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentions légales - Zero Gaspi</title>
    <style>
        :root { --vf: #1a5c38; --vv: #15803d; --vc: #e8f5ee; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #f4f6f4; color: #1a1a1a; line-height: 1.6; }
        .header { background: linear-gradient(135deg, var(--vf), var(--vv)); padding: 3rem 2rem; text-align: center; color: white; }
        .header h1 { font-size: 2rem; font-weight: 800; }
        .content { max-width: 800px; margin: -2rem auto 3rem; padding: 2.5rem; background: white; border-radius: 16px; box-shadow: 0 8px 24px rgba(0,0,0,0.08); }
        .content h2 { color: var(--vf); font-size: 1.3rem; margin-top: 2rem; margin-bottom: 0.8rem; }
        .content h2:first-child { margin-top: 0; }
        .content p { margin-bottom: 1rem; color: #374151; }
        .content ul { margin: 0 0 1rem 1.2rem; color: #374151; }
        .back-link { display: inline-block; margin: 2rem 0 0; color: var(--vv); text-decoration: none; font-weight: 600; font-size: 0.9rem; }
        .note { font-size: 0.85rem; color: #9ca3af; margin-bottom: 1.5rem; font-style: italic; }
    </style>
</head>
<body>

    <div class="header">
        <h1>📋 Mentions légales</h1>
    </div>

    <div class="content">
        <h2>1. Éditeur du site</h2>
        <p>
            Le site Zero Gaspi est édité dans le cadre d'un projet de fin d'études.<br>
            Contact : via le <a href="{{ route('contact') }}" style="color:var(--vv);">formulaire de contact</a>.
        </p>

        <h2>2. Propriété intellectuelle</h2>
        <p>
            L'ensemble du contenu de ce site (textes, code, mise en page) est la propriété de l'éditeur, sauf mention contraire. Toute reproduction sans autorisation est interdite.
        </p>

        <h2>3. Responsabilité</h2>
        <p>
            Zero Gaspi met en relation des vendeurs et des acheteurs, mais n'est pas partie aux transactions effectuées. L'éditeur ne peut être tenu responsable de la qualité, de la disponibilité ou de la conformité des produits proposés par les vendeurs.
        </p>

        <h2>4. Données personnelles</h2>
        <p>
            Le traitement des données personnelles est détaillé dans notre <a href="{{ route('confidentialite') }}" style="color:var(--vv);">politique de confidentialité</a>.
        </p>

        <a href="{{ url('/') }}" class="back-link">← Retour à l'accueil</a>
    </div>

</body>
</html>