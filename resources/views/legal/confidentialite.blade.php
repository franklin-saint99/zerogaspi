<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Politique de confidentialité - Zero Gaspi</title>
    <style>
        :root { --vf: #1a5c38; --vv: #15803d; --vc: #e8f5ee; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #f4f6f4; color: #1a1a1a; line-height: 1.6; }
        .header { background: linear-gradient(135deg, var(--vf), var(--vv)); padding: 3rem 2rem; text-align: center; color: white; }
        .header h1 { font-size: 2rem; font-weight: 800; }
        .header p { opacity: 0.9; margin-top: 0.5rem; }
        .content { max-width: 800px; margin: -2rem auto 3rem; padding: 2.5rem; background: white; border-radius: 16px; box-shadow: 0 8px 24px rgba(0,0,0,0.08); }
        .content h2 { color: var(--vf); font-size: 1.3rem; margin-top: 2rem; margin-bottom: 0.8rem; }
        .content h2:first-child { margin-top: 0; }
        .content p { margin-bottom: 1rem; color: #374151; }
        .content ul { margin: 0 0 1rem 1.2rem; color: #374151; }
        .content li { margin-bottom: 0.4rem; }
        .content table { width: 100%; border-collapse: collapse; margin: 1rem 0; }
        .content th, .content td { text-align: left; padding: 0.6rem; border: 1px solid #e5e7eb; font-size: 0.9rem; }
        .content th { background: var(--vc); color: var(--vf); }
        .back-link { display: inline-block; margin: 2rem 0 0; color: var(--vv); text-decoration: none; font-weight: 600; font-size: 0.9rem; }
        .maj { font-size: 0.85rem; color: #9ca3af; margin-bottom: 1.5rem; }
    </style>
</head>
<body>

    <div class="header">
        <h1>🔒 Politique de confidentialité</h1>
        <p>Comment Zero Gaspi collecte, utilise et protège vos données personnelles</p>
    </div>

    <div class="content">
        <p class="maj">Dernière mise à jour : [à compléter à la date de mise en ligne]</p>

        <h2>1. Qui sommes-nous ?</h2>
        <p>
            Zero Gaspi est une plateforme mettant en relation des commerces disposant de produits alimentaires proches de leur date de péremption avec des consommateurs souhaitant les acheter à prix réduit, avec retrait en magasin.
        </p>

        <h2>2. Quelles données collectons-nous ?</h2>
        <table>
            <thead>
                <tr><th>Type de compte</th><th>Données collectées</th></tr>
            </thead>
            <tbody>
                <tr><td>Tous les utilisateurs</td><td>Nom, adresse email, mot de passe (haché, jamais stocké en clair)</td></tr>
                <tr><td>Vendeurs (magasins)</td><td>Adresse du magasin, numéro SIRET</td></tr>
                <tr><td>Acheteurs</td><td>Historique des commandes passées</td></tr>
                <tr><td>Formulaire de contact</td><td>Nom, email, sujet et contenu du message</td></tr>
            </tbody>
        </table>

        <h2>3. Pourquoi collectons-nous ces données ?</h2>
        <ul>
            <li><strong>Nom et email</strong> : création et gestion de votre compte, connexion sécurisée</li>
            <li><strong>Adresse du magasin</strong> : permettre aux acheteurs de savoir où récupérer leur commande</li>
            <li><strong>Numéro SIRET</strong> : vérifier qu'il s'agit d'un commerce réellement enregistré</li>
            <li><strong>Historique des commandes</strong> : suivi de vos achats et de leur récupération</li>
            <li><strong>Formulaire de contact</strong> : répondre à vos questions ou signalements</li>
        </ul>

        <h2>4. Combien de temps conservons-nous vos données ?</h2>
        <table>
            <thead>
                <tr><th>Donnée</th><th>Durée de conservation</th></tr>
            </thead>
            <tbody>
                <tr><td>Compte utilisateur</td><td>Tant que le compte est actif, puis suppression sur demande</td></tr>
                <tr><td>Historique des commandes</td><td>3 ans après la dernière commande (obligations comptables)</td></tr>
                <tr><td>Messages du formulaire de contact</td><td>12 mois maximum après traitement de la demande</td></tr>
            </tbody>
        </table>

        <h2>5. Qui a accès à vos données ?</h2>
        <p>
            Vos données sont uniquement accessibles par vous-même et par les administrateurs de la plateforme, dans le cadre strict de la gestion du service. L'adresse d'un vendeur est visible par les acheteurs uniquement pour organiser le retrait des produits commandés. Vos données ne sont jamais vendues ni transmises à des tiers à des fins commerciales.
        </p>

        <h2>6. Comment vos données sont-elles protégées ?</h2>
        <ul>
            <li>Mots de passe chiffrés (hachage), jamais stockés en clair</li>
            <li>Sessions de connexion chiffrées</li>
            <li>Accès aux données protégé par un système de rôles et de permissions</li>
            <li>Connexion au site sécurisée</li>
        </ul>

        <h2>7. Quels sont vos droits ?</h2>
        <p>Conformément au Règlement Général sur la Protection des Données (RGPD), vous disposez des droits suivants :</p>
        <ul>
            <li><strong>Droit d'accès</strong> : consulter les données que nous détenons sur vous</li>
            <li><strong>Droit de rectification</strong> : corriger vos informations depuis votre page de profil</li>
            <li><strong>Droit à l'effacement</strong> : supprimer votre compte à tout moment depuis votre profil</li>
            <li><strong>Droit d'opposition</strong> : vous opposer à un traitement de vos données</li>
        </ul>
        <p>
            Pour exercer ces droits, vous pouvez nous contacter via le <a href="{{ route('contact') }}" style="color:var(--vv);">formulaire de contact</a>.
        </p>

        <h2>8. Cookies</h2>
        <p>
            Zero Gaspi utilise uniquement des cookies strictement nécessaires au fonctionnement du site (maintien de votre connexion, contenu de votre panier). Aucun cookie de suivi publicitaire n'est utilisé.
        </p>

        <a href="{{ url('/') }}" class="back-link">← Retour à l'accueil</a>
    </div>

</body>
</html>