<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation de mot de passe | Écho & Culture</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #FAF7F2; color: #2C221E; margin: 0; padding: 40px 20px; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border: 1px solid #E5DFD3; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border-top: 4px solid #C85A32; }
        .header { background-color: #1E1613; padding: 40px 30px; text-align: center; position: relative; }
        .header h1 { margin: 0; font-size: 28px; font-weight: bold; letter-spacing: 2px; color: #ffffff; text-transform: uppercase; font-family: 'Georgia', serif; }
        .header p { color: #D4A373; margin-top: 8px; font-size: 12px; letter-spacing: 1px; text-transform: uppercase; }
        .content { padding: 40px 30px; line-height: 1.6; }
        .content h2 { font-family: 'Georgia', serif; color: #1E1613; font-size: 22px; margin-top: 0; }
        .info-box { background-color: #FAF7F2; border: 1px solid #E5DFD3; border-left: 4px solid #C85A32; padding: 20px; margin: 30px 0; }
        .info-box p { margin: 0; font-size: 14px; color: #4A3C31; }
        .button { display: inline-block; background-color: #C85A32; color: #ffffff !important; text-decoration: none; padding: 14px 28px; font-weight: bold; text-transform: uppercase; font-size: 12px; letter-spacing: 1px; margin-top: 20px; transition: background-color 0.3s; }
        .button:hover { background-color: #A84223; }
        .footer { background-color: #1E1613; padding: 24px; text-align: center; font-size: 11px; color: #D4A373; letter-spacing: 0.5px; }
        .footer a { color: #C85A32; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Écho & Culture</h1>
            <p>Association Culturelle & Artistique</p>
        </div>
        <div class="content">
            <h2>Réinitialisation de mot de passe</h2>
            <p>Bonjour,</p>
            <p>Vous recevez cet e-mail car nous avons reçu une demande de réinitialisation de mot de passe pour votre compte.</p>
            
            <center>
                <a href="{{ $url }}" class="button">Réinitialiser le mot de passe</a>
            </center>

            <div class="info-box">
                <p>Ce lien expirera dans 60 minutes. Si vous n'avez pas demandé de réinitialisation de mot de passe, aucune autre action n'est requise.</p>
            </div>
            
            <p style="font-size: 12px; color: #6B574F; word-break: break-all; margin-top: 30px; border-top: 1px solid #E5DFD3; padding-top: 20px;">
                Si vous ne parvenez pas à cliquer sur le bouton "Réinitialiser le mot de passe", copiez et collez l'URL ci-dessous dans votre navigateur Web :<br>
                <a href="{{ $url }}" style="color: #C85A32;">{{ $url }}</a>
            </p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Écho & Culture. Transmettons notre passion.<br>
            <span style="opacity: 0.7; font-size: 10px; margin-top: 8px; display: block;">Ce message est généré automatiquement, merci de ne pas y répondre.</span>
        </div>
    </div>
</body>
</html>
