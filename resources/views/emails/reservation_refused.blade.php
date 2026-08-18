<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande refusée | Écho & Culture</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #FAF7F2; color: #2C221E; margin: 0; padding: 40px 20px; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border: 1px solid #E5DFD3; box-shadow: 0 10px 30px rgba(0,0,0,0.05); overflow: hidden; }
        .header { background-color: #1E1613; padding: 40px 30px; text-align: center; border-top: 4px solid #0BA20B; }
        .header h1 { margin: 0; font-size: 24px; font-weight: bold; letter-spacing: 2px; color: #ffffff; text-transform: uppercase; font-family: 'Georgia', serif; }
        .header p { color: #0BA20B; margin-top: 8px; font-size: 11px; letter-spacing: 2px; text-transform: uppercase; }
        .content { padding: 40px 30px; line-height: 1.6; }
        h2 { font-family: 'Georgia', serif; font-size: 20px; font-weight: 600; color: #1E1613; margin: 0 0 16px 0; }
        p { font-size: 14px; color: #4A3C31; margin: 0 0 16px 0; }
        .info-box { background-color: #FAF7F2; border: 1px solid #E5DFD3; padding: 20px; margin: 24px 0; }
        .info-item { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px dashed #E5DFD3; }
        .info-item:last-child { border-bottom: none; }
        .info-label { font-weight: 700; color: #1E1613; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; }
        .info-value { color: #4A3C31; font-size: 14px; font-weight: 500; text-align: right; }
        .button { display: inline-block; padding: 14px 32px; background-color: #0BA20B; color: #ffffff !important; text-decoration: none; font-weight: bold; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; text-align: center; margin: 20px 0; transition: 0.3s; }
        .button:hover { background-color: #087A08; }
        .footer { background-color: #1E1613; padding: 24px; text-align: center; font-size: 11px; color: #8C766B; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ $association->nom }}</h1>
            <p>Réservation Refusée</p>
        </div>
        <div class="content">
            <p>Bonjour <strong>{{ $reservation->user->name ?? 'Apprenant' }}</strong>,</p>
            <p>Nous sommes désolés, mais le professeur a dû décliner votre proposition d'horaire pour le cours <strong>{{ $reservation->course->titre }}</strong>.</p>
            
            <div class="info-box">
                <div class="info-item">
                    <span class="info-label">Date demandée</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($reservation->date_reservation)->translatedFormat('l d F Y') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Horaire demandé</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($reservation->heure_debut)->format('H\hi') }} - {{ \Carbon\Carbon::parse($reservation->heure_fin)->format('H\hi') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Professeur</span>
                    <span class="info-value">{{ $reservation->course->professeur->name ?? 'Enseignant' }}</span>
                </div>
            </div>

            <p>Nous vous invitons à consulter le catalogue de nos cours pour réserver un autre créneau ou choisir un autre cours qui correspond mieux aux disponibilités actuelles.</p>
            <center>
                <a href="{{ route('dashboard.apprenant.cours') }}" class="button">Voir le catalogue</a>
            </center>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} {{ $association->nom }}. Transmettons notre passion.</p>
        </div>
    </div>
</body>
</html>
