<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body style="font-family: sans-serif; background: #f4f6f4; padding: 2rem;">
    <div style="max-width: 600px; margin: 0 auto; background: white; border-radius: 12px; overflow: hidden;">
        <div style="background: #1a5c38; color: white; padding: 1.5rem; text-align: center;">
            <h2 style="margin: 0;">🌿 Nouveau message - Zero Gaspi</h2>
        </div>
        <div style="padding: 1.5rem; color: #374151;">
            <p><strong>De :</strong> {{ $nom }} ({{ $emailExpediteur }})</p>
            <p><strong>Sujet :</strong> {{ $sujet }}</p>
            <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 1rem 0;">
            <p style="white-space: pre-line;">{{ $messageContenu }}</p>
        </div>
    </div>
</body>
</html>