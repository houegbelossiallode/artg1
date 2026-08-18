<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #FAF7F2; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 0 auto; padding: 40px 20px;">
        <div style="background-color: #ffffff; padding: 40px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border-top: 4px solid #0BA20B;">
            <div style="text-align: center; margin-bottom: 30px; font-size: 24px; font-weight: bold; color: #1E1613;">
                <span style="color: #0BA20B;">{{ $association->nom }}</span>
            </div>
            
            <div style="color: #2C221E; line-height: 1.6; font-size: 16px;">
                <p>Bonjour <strong>{{ $user->prenom }}</strong>,</p>
                <p>Bienvenue sur la plateforme AssoCulture !</p>
                <p>Pour finaliser la création de votre compte et accéder à votre espace membre, veuillez valider votre adresse email en cliquant sur le bouton ci-dessous :</p>
                
                <div style="text-align: center; margin: 30px 0;">
                    <a href="{{ $url }}" style="background-color: #0BA20B; color: #ffffff !important; padding: 14px 28px; text-decoration: none; border-radius: 4px; font-weight: bold; display: inline-block; text-transform: uppercase; font-size: 14px; letter-spacing: 1px;">Valider mon compte</a>
                </div>
                
                <p>Si le bouton ne fonctionne pas, copiez et collez le lien suivant dans votre navigateur :<br>
                <a href="{{ $url }}" style="color: #0BA20B; word-break: break-all; font-size: 13px;">{{ $url }}</a></p>
                
                <p>À très bientôt,<br>L'équipe {{ $association->nom }}</p>
            </div>
        </div>
        
        <div style="margin-top: 30px; text-align: center; color: #8C766B; font-size: 12px;">
            &copy; {{ date('Y') }} Association Écho & Culture. Tous droits réservés.<br>
            Si vous n'avez pas créé de compte, aucune action supplémentaire n'est requise.
        </div>
    </div>
</body>
</html>
