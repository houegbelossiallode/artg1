@extends('layouts.email')

@section('content')
<div style="color: #2C221E; line-height: 1.6; font-size: 16px;">
    <div style="margin-bottom: 32px;">
        <p>Bonjour <strong>{{ $user->name }}</strong>,</p>
        <p>Nous sommes ravis de vous informer que votre demande de réservation pour le cours <strong>{{ $cours->titre }}</strong> a été enregistrée avec succès !</p>
    </div>
    
    <div style="margin-bottom: 32px;">
        <h2 style="font-family: 'Georgia', serif; font-size: 20px; font-weight: 600; color: #1E1613; margin: 0 0 16px 0; border-bottom: 1px solid #E5DFD3; padding-bottom: 8px;">Détails de votre cours</h2>
        <div style="background-color: #FAF7F2; border: 1px solid #E5DFD3; padding: 20px; margin: 20px 0;">
            <div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px dashed #E5DFD3;">
                <span style="font-weight: bold; color: #1E1613; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Date</span>
                <span style="color: #4A3C31; font-size: 14px; font-weight: 500; text-align: right;">{{ \Carbon\Carbon::parse($reservation->date_reservation)->translatedFormat('l d F Y') }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px dashed #E5DFD3;">
                <span style="font-weight: bold; color: #1E1613; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Horaire</span>
                <span style="color: #4A3C31; font-size: 14px; font-weight: 500; text-align: right;">{{ \Carbon\Carbon::parse($reservation->heure_debut)->format('H\hi') }} - {{ \Carbon\Carbon::parse($reservation->heure_fin)->format('H\hi') }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px dashed #E5DFD3;">
                <span style="font-weight: bold; color: #1E1613; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Professeur</span>
                <span style="color: #4A3C31; font-size: 14px; font-weight: 500; text-align: right;">{{ $cours->professeur ? $cours->professeur->name : 'Enseignant de l\'association' }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px dashed #E5DFD3;">
                <span style="font-weight: bold; color: #1E1613; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Mode</span>
                <span style="color: #4A3C31; font-size: 14px; font-weight: 500; text-align: right;">{{ $cours->mode ? $cours->mode->libelle : 'Atelier' }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 10px 0; align-items: center;">
                <span style="font-weight: bold; color: #1E1613; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Statut</span>
                <span style="display: inline-block; padding: 6px 12px; background-color: #0BA20B; color: #ffffff; font-size: 11px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px;">Confirmé</span>
            </div>
        </div>
    </div>
    
    @if($meetingUrl)
    <div style="margin-bottom: 32px;">
        <h2 style="font-family: 'Georgia', serif; font-size: 20px; font-weight: 600; color: #1E1613; margin: 0 0 16px 0;">Classe Virtuelle Sécurisée</h2>
        <p>Ce cours se déroule à distance via notre plateforme de visioconférence Jitsi Meet. Pour des raisons de sécurité, votre lien d'accès personnel est actif uniquement pour vous et votre enseignant.</p>
        
        <div style="font-size: 13px; color: #1E1613; background-color: #F4EFE6; padding: 16px; border-left: 4px solid #0BA20B; margin-top: 16px;">
            <strong>Important :</strong> Le lien d'accès sera actif 5 minutes avant l'heure prévue du cours. Ce lien est personnel et ne doit pas être partagé.
        </div>
        
        <div style="text-align: center; margin-top: 16px;">
            <a href="{{ $meetingUrl }}" style="background-color: #0BA20B; color: #ffffff !important; text-decoration: none; padding: 14px 28px; border-radius: 4px; font-weight: bold; display: inline-block; text-transform: uppercase; font-size: 14px; letter-spacing: 1px;">Accéder à la visioconférence</a>
        </div>
    </div>
    @else
    <div style="margin-bottom: 32px;">
        <h2 style="font-family: 'Georgia', serif; font-size: 20px; font-weight: 600; color: #1E1613; margin: 0 0 16px 0;">Cours en Présentiel</h2>
        <p>Rendez-vous dans les locaux de notre association culturelle à la date et heure convenues. N'oubliez pas d'apporter votre matériel si nécessaire.</p>
        
        <div style="font-size: 13px; color: #1E1613; background-color: #F4EFE6; padding: 16px; border-left: 4px solid #0BA20B; margin-top: 16px;">
            <strong>Adresse :</strong> Les locaux de l'association Écho & Culture
        </div>
    </div>
    @endif
    
    <div style="margin-top: 40px; border-top: 1px solid #E5DFD3; padding-top: 30px;">
        <h2 style="font-family: 'Georgia', serif; font-size: 20px; font-weight: 600; color: #1E1613; margin: 0 0 16px 0; border: none;">Accès à votre espace</h2>
        <p>Vous pouvez retrouver toutes vos réservations, télécharger les supports de cours et accéder aux ressources pédagogiques directement depuis votre espace apprenant.</p>
        
       
    </div>
    
    <div style="margin-top: 40px;">
        <p>Merci de votre confiance et à très bientôt !</p>
        <p style="margin-bottom: 0;">L'équipe Écho & Culture</p>
    </div>
</div>
@endsection
