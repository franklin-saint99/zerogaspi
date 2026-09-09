<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body style="font-family: sans-serif; background: #f4f6f4; padding: 2rem;">
    <div style="max-width: 600px; margin: 0 auto; background: white; border-radius: 12px; overflow: hidden;">
        <div style="background: #1a5c38; color: white; padding: 1.5rem; text-align: center;">
            <h2 style="margin: 0;">🌿 Nouvelle commande - Zero Gaspi</h2>
        </div>
        <div style="padding: 1.5rem; color: #374151;">
            <p>Bonjour,</p>
            <p>Vous avez reçu une nouvelle commande (<strong>#{{ $commande->id }}</strong>) de la part de <strong>{{ $commande->user->name }}</strong> sur les produits suivants :</p>

            <table style="width:100%; border-collapse: collapse; margin: 1rem 0;">
                <thead>
                    <tr style="background:#e8f5ee; text-align:left;">
                        <th style="padding:0.5rem; font-size:0.85rem;">Produit</th>
                        <th style="padding:0.5rem; font-size:0.85rem;">Qté</th>
                        <th style="padding:0.5rem; font-size:0.85rem;">Prix</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produitsVendeur as $produit)
                    <tr style="border-bottom:1px solid #e5e7eb;">
                        <td style="padding:0.5rem; font-size:0.85rem;">{{ $produit->nom }}</td>
                        <td style="padding:0.5rem; font-size:0.85rem;">{{ $produit->pivot->quantite }}</td>
                        <td style="padding:0.5rem; font-size:0.85rem;">{{ number_format($produit->pivot->prix, 2) }} €</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="background:#fee2e2; border-left:4px solid #991b1b; padding:1rem; border-radius:8px; margin:1.5rem 0;">
                <p style="margin:0; font-weight:700; color:#7f1d1d;">⏰ Retrait obligatoire le jour même</p>
                <p style="margin:0.4rem 0 0; font-size:0.9rem; color:#7f1d1d;">
                    Le client a été informé qu'il est <strong>obligatoire</strong> de venir récupérer sa commande en magasin <strong>aujourd'hui</strong>. Merci de préparer les produits pour son passage.
                </p>
            </div>

            <p style="font-size:0.85rem; color:#6b7280;">Vous pouvez suivre le statut de cette commande depuis votre espace vendeur, rubrique "Mes commandes".</p>
        </div>
    </div>
</body>
</html>