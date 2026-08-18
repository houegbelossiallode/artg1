<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proposition de report | Écho & Culture</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #FAF7F2; color: #2C221E; margin: 0; padding: 40px 20px; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border: 1px solid #E5DFD3; box-shadow: 0 10px 30px rgba(0,0,0,0.05); overflow: hidden; }
        .header { background-color: #1E1613; padding: 40px 30px; text-align: center; border-top: 4px solid #F59E0B; }
        .header h1 { margin: 0; font-size: 24px; font-weight: bold; letter-spacing: 2px; color: #ffffff; text-transform: uppercase; font-family: 'Georgia', serif; }
        .header p { color: #F59E0B; margin-top: 8px; font-size: 11px; letter-spacing: 2px; text-transform: uppercase; }
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
            <p>Nouvelle Proposition d'Horaire</p>
        </div>
        <div class="content">
            <p>Bonjour,</p>
            <p>Suite à une demande concernant le cours <strong>{{ $reservation->course->titre }}</strong>, une nouvelle proposition d'horaire vient de vous être envoyée.</p>
            
            <div class="info-box">
                <div class="info-item">
                    <span class="info-label">Nouvelle Date</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($reservation->date_reservation)->translatedFormat('l d F Y') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Nouvel Horaire</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($reservation->heure_debut)->format('H\hi') }} - {{ \Carbon\Carbon::parse($reservation->heure_fin)->format('H\hi') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Professeur</span>
                    <span class="info-value">{{ $reservation->course->professeur->name ?? 'Enseignant' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Apprenant</span>
                    <span class="info-value">{{ $reservation->user->name ?? 'Apprenant' }}</span>
                </div>
            </div>
            
            @if(isset($data) && !empty($data['message']))
            <div style="background-color: #Fef3c7; border-left: 4px solid #F59E0B; padding: 16px; margin: 24px 0;">
                <p style="margin: 0; font-size: 13px; font-style: italic; color: #92400E;"><strong>Motif / Message :</strong> "{{ $data['message'] }}"</p>
            </div>
            @endif

            <p>Vous avez la possibilité d'accepter ce nouvel horaire ou de proposer un autre créneau à votre tour (négociation).</p>
            <center>
                @if($reservation->status === 'pending_teacher')
                    <a href="{{ route('dashboard.professeur') }}" class="button" style="background-color: #1E1613;">Gérer mes cours</a>
                @else
                    <a href="{{ route('dashboard.apprenant') }}" class="button" style="background-color: #1E1613;">Accéder à mon espace</a>
                @endif
            </center>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} {{ $association->nom }}. Transmettons notre passion.</p>
        </div>
    </div>
</body>
</html>
