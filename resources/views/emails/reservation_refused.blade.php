@extends('layouts.email')

@section('content')
<div style="color: #2C221E; line-height: 1.6; font-size: 16px;">
    <p>Bonjour <strong>{{ $reservation->user->name ?? 'Apprenant' }}</strong>,</p>
    <p>Nous sommes désolés, mais le professeur a dû décliner votre proposition d'horaire pour le cours <strong>{{ $reservation->course->titre }}</strong>.</p>
    
    <div style="background-color: #FAF7F2; border: 1px solid #E5DFD3; padding: 20px; margin: 24px 0;">
        <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px dashed #E5DFD3;">
            <span style="font-weight: 700; color: #1E1613; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Date demandée</span>
            <span style="color: #4A3C31; font-size: 14px; font-weight: 500; text-align: right;">{{ \Carbon\Carbon::parse($reservation->date_reservation)->translatedFormat('l d F Y') }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px dashed #E5DFD3;">
            <span style="font-weight: 700; color: #1E1613; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Horaire demandé</span>
            <span style="color: #4A3C31; font-size: 14px; font-weight: 500; text-align: right;">{{ \Carbon\Carbon::parse($reservation->heure_debut)->format('H\hi') }} - {{ \Carbon\Carbon::parse($reservation->heure_fin)->format('H\hi') }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; padding: 8px 0;">
            <span style="font-weight: 700; color: #1E1613; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Professeur</span>
            <span style="color: #4A3C31; font-size: 14px; font-weight: 500; text-align: right;">{{ $reservation->course->professeur->name ?? 'Enseignant' }}</span>
        </div>
    </div>

    <p>Nous vous invitons à consulter le catalogue de nos cours pour réserver un autre créneau ou choisir un autre cours qui correspond mieux aux disponibilités actuelles.</p>
    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ route('dashboard.apprenant.cours') }}" style="background-color: #0BA20B; color: #ffffff !important; text-decoration: none; padding: 14px 28px; border-radius: 4px; font-weight: bold; display: inline-block; text-transform: uppercase; font-size: 14px; letter-spacing: 1px;">Voir le catalogue</a>
    </div>
</div>
@endsection
