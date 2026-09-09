<div id="cookieBanner" style="display:none; position:fixed; bottom:0; left:0; width:100%; background:#1a5c38; color:white; padding:1.2rem 1.5rem; z-index:999999; box-shadow:0 -4px 16px rgba(0,0,0,0.15);">
    <div style="max-width:1100px; margin:0 auto; display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:1rem;">
        <p style="margin:0; font-size:0.9rem; line-height:1.5; flex:1; min-width:260px;">
            🍪 Nous utilisons uniquement des cookies strictement nécessaires au fonctionnement du site (connexion, panier, sécurité). Aucun cookie de suivi ou publicitaire n'est utilisé.
            <a href="#" style="color:#d1fae5; text-decoration:underline;">En savoir plus</a>
        </p>
        <div style="display:flex; gap:0.75rem; flex-shrink:0;">
            <button id="cookieRefuse" style="background:transparent; color:white; border:1px solid white; padding:0.5rem 1.2rem; border-radius:8px; font-size:0.85rem; cursor:pointer;">
                Refuser
            </button>
            <button id="cookieAccept" style="background:white; color:#1a5c38; border:none; padding:0.5rem 1.2rem; border-radius:8px; font-size:0.85rem; font-weight:600; cursor:pointer;">
                Accepter
            </button>
        </div>
    </div>
</div>

<script>
    (function () {
        const banner = document.getElementById('cookieBanner');
        const consent = localStorage.getItem('zerogaspi_cookie_consent');

        if (!consent) {
            banner.style.display = 'block';
        }

        document.getElementById('cookieAccept').addEventListener('click', function () {
            localStorage.setItem('zerogaspi_cookie_consent', 'accepted');
            banner.style.display = 'none';
        });

        document.getElementById('cookieRefuse').addEventListener('click', function () {
            localStorage.setItem('zerogaspi_cookie_consent', 'refused');
            banner.style.display = 'none';
        });
    })();
</script>