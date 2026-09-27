<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body style="font-family: sans-serif; background: #f4f6f4; padding: 2rem;">
    <div style="max-width: 600px; margin: 0 auto; background: white; border-radius: 12px; overflow: hidden;">
        <div style="background: #1a5c38; color: white; padding: 1.5rem; text-align: center;">
            <h2 style="margin: 0;">🌿 Commande confirmée - Zero Gaspi</h2>
        </div>
        <div style="padding: 1.5rem; color: #374151;">
            <p>Bonjour {{ $commande->user->name }},</p>
            <p>Votre commande <strong>#{{ $commande->id }}</strong> a bien été confirmée. Voici le récapitulatif :</p>

            <table style="width:100%; border-collapse: collapse; margin: 1rem 0;">
                <thead>
                    <tr style="background:#e8f5ee; text-align:left;">
                        <th style="padding:0.5rem; font-size:0.85rem;">Produit</th>
                        <th style="padding:0.5rem; font-size:0.85rem;">Magasin</th>
                        <th style="padding:0.5rem; font-size:0.85rem;">Adresse</th>
                        <th style="padding:0.5rem; font-size:0.85rem;">Qté</th>
                        <th style="padding:0.5rem; font-size:0.85rem;">Prix</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($commande->produits as $produit)
                    <tr style="border-bottom:1px solid #e5e7eb;">
                        <td style="padding:0.5rem; font-size:0.85rem;">{{ $produit->nom }}</td>
                        <td style="padding:0.5rem; font-size:0.85rem;">{{ $produit->vendeur->name ?? '-' }}</td>
                        <td style="padding:0.5rem; font-size:0.85rem;">{{ $produit->vendeur->address ?? '-' }}</td>
                        <td style="padding:0.5rem; font-size:0.85rem;">{{ $produit->pivot->quantite }}</td>
                        <td style="padding:0.5rem; font-size:0.85rem;">{{ number_format($produit->pivot->prix_unitaire, 2) }} €</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <p style="text-align:right; font-weight:600;">Total : {{ number_format($commande->total, 2) }} €</p>

            <div style="background:#fee2e2; border-left:4px solid #991b1b; padding:1rem; border-radius:8px; margin:1.5rem 0;">
                <p style="margin:0; font-weight:700; color:#7f1d1d;">⏰ Retrait obligatoire le jour même</p>
                <p style="margin:0.4rem 0 0; font-size:0.9rem; color:#7f1d1d;">
                    Pour garantir la fraîcheur des produits et éviter le gaspillage, il est <strong>obligatoire</strong> de venir récupérer votre commande en magasin <strong>aujourd'hui</strong>, aux adresses indiquées ci-dessus. Passé ce délai, votre commande pourra être annulée.
                </p>
            </div>

            <p style="font-size:0.85rem; color:#6b7280;">Merci de contribuer à la lutte contre le gaspillage alimentaire avec Zero Gaspi !</p>
        </div>
    </div>
</body>
</html>