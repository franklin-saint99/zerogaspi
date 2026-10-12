<div id="cookie-consent" role="region" aria-label="Information sur les cookies" style="display:none; position:fixed; left:0; right:0; bottom:0; background:#111827; color:white; padding:1rem 1.5rem; z-index:9999; align-items:center; justify-content:space-between; gap:1rem; flex-wrap:wrap; font-size:0.85rem;">
    <span style="color:#e5e7eb;">
        Ce site utilise uniquement des cookies strictement nécessaires à son fonctionnement (maintien de votre connexion, contenu de votre panier). Aucun cookie de suivi publicitaire n'est utilisé.
        <a href="{{ route('confidentialite') }}" style="color:#9ca3af; text-decoration:underline;">En savoir plus</a>
    </span>
    <button id="cookie-refuse-btn" style="background:transparent; color:#e5e7eb; border:1px solid #4b5563; padding:0.55rem 1.2rem; border-radius:6px; font-size:0.85rem; cursor:pointer; white-space:nowrap;">
        Refuser
    </button>
    <button id="cookie-accept-btn" style="background:#15803d; color:white; border:none; padding:0.55rem 1.4rem; border-radius:6px; font-size:0.85rem; font-weight:600; cursor:pointer; white-space:nowrap;">
        Accepter
    </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var banner = document.getElementById('cookie-consent');
        var acceptBtn = document.getElementById('cookie-accept-btn');
        var refuseBtn = document.getElementById('cookie-refuse-btn');
        var CLE = 'zerogaspi_cookies_choix';

        if (!banner || !acceptBtn || !refuseBtn) return;

        // Lire le choix déjà enregistré ("accepte" ou "refuse")
        var choix = null;
        try { choix = localStorage.getItem(CLE); } catch (e) {}

        // N'afficher le bandeau que si l'utilisateur n'a encore rien choisi
        if (choix !== 'accepte' && choix !== 'refuse') {
            banner.style.display = 'flex';
        }

        // Enregistrer le choix, puis cacher le bandeau
        function enregistrer(valeur) {
            try { localStorage.setItem(CLE, valeur); } catch (e) {}
            banner.style.display = 'none';
        }

        acceptBtn.addEventListener('click', function () { enregistrer('accepte'); });
        refuseBtn.addEventListener('click', function () { enregistrer('refuse'); });
    });
</script>