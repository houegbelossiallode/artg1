<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compte Professeur | Écho & Culture</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #FAF7F2; color: #2C221E; margin: 0; padding: 40px 20px; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border: 1px solid #E5DFD3; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border-top: 4px solid #C85A32; }
        .header { background-color: #1E1613; padding: 40px 30px; text-align: center; position: relative; }
        .header h1 { margin: 0; font-size: 28px; font-weight: bold; letter-spacing: 2px; color: #ffffff; text-transform: uppercase; font-family: 'Georgia', serif; }
        .header p { color: #D4A373; margin-top: 8px; font-size: 12px; letter-spacing: 1px; text-transform: uppercase; }
        .content { padding: 40px 30px; line-height: 1.6; }
        .content h2 { font-family: 'Georgia', serif; color: #1E1613; font-size: 22px; margin-top: 0; }
        .credentials-box { background-color: #FAF7F2; border: 1px solid #E5DFD3; border-left: 4px solid #C85A32; padding: 20px; margin: 30px 0; }
        .credentials-box p { margin: 8px 0; font-size: 14px; color: #4A3C31; }
        .credentials-box strong { color: #1E1613; display: inline-block; width: 120px; }
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
            <h2>Bienvenue dans le corps enseignant !</h2>
            <p>Bonjour <strong>{{ $professeur->prenom }} {{ $professeur->nom }}</strong>,</p>
            <p>C'est avec un grand plaisir que nous vous accueillons parmi nos professeurs. Votre compte d'enseignant a été créé avec succès par notre administration.</p>
            <p>Vous pouvez dès à présent vous connecter pour gérer vos cours, consulter vos disponibilités et suivre vos élèves.</p>
            
            <div class="credentials-box">
                <p><strong>Email :</strong> {{ $professeur->email }}</p>
                <p><strong>Mot de passe :</strong> <span style="font-family: monospace; font-size: 16px; font-weight: bold;">{{ $password }}</span></p>
            </div>

            <p style="font-size: 13px; color: #6B574F;"><em>Pour des raisons de sécurité, nous vous recommandons fortement de modifier ce mot de passe temporaire dès votre première connexion.</em></p>

            <center>
                <a href="{{ route('login') }}" class="button">Accéder à mon espace</a>
            </center>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Écho & Culture. Transmettons notre passion.<br>
            <span style="opacity: 0.7; font-size: 10px; margin-top: 8px; display: block;">Ce message est généré automatiquement, merci de ne pas y répondre.</span>
        </div>
    </div>
</body>
</html>
