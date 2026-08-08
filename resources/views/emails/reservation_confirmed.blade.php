<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Confirmation de réservation | Écho & Culture</title>
    <style>
        /* Reset */
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
        table { border-collapse: collapse !important; }
        
        /* Base */
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #FAF7F2; color: #2C221E; margin: 0; padding: 40px 20px; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border: 1px solid #E5DFD3; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border-top: 4px solid #C85A32; overflow: hidden; }
        
        /* Header */
        .header { background-color: #1E1613; padding: 40px 30px; text-align: center; }
        .header h1 { margin: 0; font-size: 28px; font-weight: bold; letter-spacing: 2px; color: #ffffff; text-transform: uppercase; font-family: 'Georgia', serif; }
        .header p { color: #D4A373; margin-top: 8px; font-size: 12px; letter-spacing: 1px; text-transform: uppercase; }
        
        /* Typography */
        .content { padding: 40px 30px; line-height: 1.6; }
        h2 { font-family: 'Georgia', serif; font-size: 20px; font-weight: 600; color: #1E1613; margin: 0 0 16px 0; border-bottom: 1px solid #E5DFD3; padding-bottom: 8px; }
        p { font-size: 14px; color: #4A3C31; margin: 0 0 16px 0; }
        
        /* Sections */
        .email-section { margin-bottom: 32px; }
        .email-section:last-child { margin-bottom: 0; }
        
        /* Info Box */
        .info-box { background-color: #FAF7F2; border: 1px solid #E5DFD3; padding: 20px; margin: 20px 0; }
        .info-box-item { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px dashed #E5DFD3; }
        .info-box-item:last-child { border-bottom: none; }
        .info-box-label { font-weight: bold; color: #1E1613; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; }
        .info-box-value { color: #4A3C31; font-size: 14px; font-weight: 500; text-align: right; }
        
        /* Button */
        .button { display: inline-block; padding: 14px 28px; background-color: #C85A32; color: #ffffff !important; text-decoration: none; font-weight: bold; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; text-align: center; margin: 20px 0; transition: background-color 0.3s; }
        .button:hover { background-color: #A84223; }
        .button-secondary { background-color: #1E1613; }
        .button-secondary:hover { background-color: #2C221E; }
        
        /* Status Badge */
        .status-badge { display: inline-block; padding: 6px 12px; background-color: #C85A32; color: #ffffff; font-size: 11px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; }
        
        /* Alert/Warning */
        .alert-box { font-size: 13px; color: #1E1613; background-color: #F4EFE6; padding: 16px; border-left: 4px solid #D4A373; margin-top: 16px; }
        
        /* Footer */
        .footer { background-color: #1E1613; padding: 24px; text-align: center; font-size: 11px; color: #D4A373; letter-spacing: 0.5px; }
        .footer p { color: #D4A373; margin: 4px 0; font-size: 11px; }
        
        /* Responsive */
        @media only screen and (max-width: 600px) {
            .info-box-item { flex-direction: column; text-align: left; }
            .info-box-value { text-align: left; margin-top: 4px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Écho & Culture</h1>
            <p>Réservation Confirmée</p>
        </div>
        
        <!-- Content -->
        <div class="content">
            <!-- Greeting -->
            <div class="email-section">
                <p>Bonjour <strong>{{ $user->name }}</strong>,</p>
                <p>Nous sommes ravis de vous informer que votre demande de réservation pour le cours <strong>{{ $cours->titre }}</strong> a été enregistrée avec succès !</p>
            </div>
            
            <!-- Course Details -->
            <div class="email-section">
                <h2>Détails de votre cours</h2>
                <div class="info-box">
                    <div class="info-box-item">
                        <span class="info-box-label">Date</span>
                        <span class="info-box-value">{{ \Carbon\Carbon::parse($reservation->date_reservation)->translatedFormat('l d F Y') }}</span>
                    </div>
                    <div class="info-box-item">
                        <span class="info-box-label">Horaire</span>
                        <span class="info-box-value">{{ \Carbon\Carbon::parse($reservation->heure_debut)->format('H\hi') }} - {{ \Carbon\Carbon::parse($reservation->heure_fin)->format('H\hi') }}</span>
                    </div>
                    <div class="info-box-item">
                        <span class="info-box-label">Professeur</span>
                        <span class="info-box-value">{{ $cours->professeur ? $cours->professeur->name : 'Enseignant de l\'association' }}</span>
                    </div>
                    <div class="info-box-item">
                        <span class="info-box-label">Mode</span>
                        <span class="info-box-value">{{ $cours->mode ? $cours->mode->libelle : 'Atelier' }}</span>
                    </div>
                    <div class="info-box-item" style="align-items: center;">
                        <span class="info-box-label">Statut</span>
                        <span class="status-badge">Confirmé</span>
                    </div>
                </div>
            </div>
            
            @if($meetingUrl)
            <!-- Online Course Section -->
            <div class="email-section">
                <h2>Classe Virtuelle Sécurisée</h2>
                <p>Ce cours se déroule à distance via notre plateforme de visioconférence Jitsi Meet. Pour des raisons de sécurité, votre lien d'accès personnel est actif uniquement pour vous et votre enseignant.</p>
                
                <div class="alert-box">
                    <strong>Important :</strong> Le lien d'accès sera actif 5 minutes avant l'heure prévue du cours. Ce lien est personnel et ne doit pas être partagé.
                </div>
                
                <center>
                    <a href="{{ $meetingUrl }}" class="button">Accéder à la visioconférence</a>
                </center>
            </div>
            @else
            <!-- In-Person Course Section -->
            <div class="email-section">
                <h2>Cours en Présentiel</h2>
                <p>Rendez-vous dans les locaux de notre association culturelle à la date et heure convenues. N'oubliez pas d'apporter votre matériel si nécessaire.</p>
                
                <div class="alert-box" style="border-left-color: #C85A32;">
                    <strong>Adresse :</strong> Les locaux de l'association Écho & Culture
                </div>
            </div>
            @endif
            
            <!-- Additional Info -->
            <div class="email-section" style="margin-top: 40px; border-top: 1px solid #E5DFD3; padding-top: 30px;">
                <h2 style="border: none;">Accès à votre espace</h2>
                <p>Vous pouvez retrouver toutes vos réservations, télécharger les supports de cours et accéder aux ressources pédagogiques directement depuis votre espace apprenant.</p>
                
                <center>
                    <a href="{{ route('dashboard.apprenant') }}" class="button button-secondary">Mon espace apprenant</a>
                </center>
            </div>
            
            <!-- Closing -->
            <div class="email-section" style="margin-top: 40px;">
                <p>Merci de votre confiance et à très bientôt !</p>
                <p style="margin-bottom: 0;">L'équipe Écho & Culture</p>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p>© {{ date('Y') }} Écho & Culture. Transmettons notre passion.</p>
            <p style="opacity: 0.7; font-size: 10px;">Cet email a été envoyé automatiquement, merci de ne pas y répondre.</p>
        </div>
    </div>
</body>
</html>
