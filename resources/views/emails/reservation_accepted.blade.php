@extends('layouts.email')

@section('content')
<div style="color: #2C221E; line-height: 1.6; font-size: 16px;">
    <p>Bonjour <strong>{{ $reservation->user->name ?? 'Apprenant' }}</strong>,</p>
    <p>Excellente nouvelle ! Le professeur a accepté votre proposition d'horaire pour le cours <strong>{{ $reservation->course->titre }}</strong>.</p>
    
    <div style="background-color: #FAF7F2; border: 1px solid #E5DFD3; padding: 20px; margin: 24px 0;">
        <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px dashed #E5DFD3;">
            <span style="font-weight: 700; color: #1E1613; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Date</span>
            <span style="color: #4A3C31; font-size: 14px; font-weight: 500; text-align: right;">{{ \Carbon\Carbon::parse($reservation->date_reservation)->translatedFormat('l d F Y') }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px dashed #E5DFD3;">
            <span style="font-weight: 700; color: #1E1613; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Horaire</span>
            <span style="color: #4A3C31; font-size: 14px; font-weight: 500; text-align: right;">{{ \Carbon\Carbon::parse($reservation->heure_debut)->format('H\hi') }} - {{ \Carbon\Carbon::parse($reservation->heure_fin)->format('H\hi') }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; padding: 8px 0;">
            <span style="font-weight: 700; color: #1E1613; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Professeur</span>
            <span style="color: #4A3C31; font-size: 14px; font-weight: 500; text-align: right;">{{ $reservation->course->professeur->name ?? 'Enseignant' }}</span>
        </div>
    </div>
    
    @if($reservation->jitsi_room_id)
    <div style="background-color: #F4EFE6; padding: 20px; border-left: 4px solid #0BA20B; margin: 24px 0;">
        <h3 style="margin: 0 0 8px 0; font-size: 14px; color: #1E1613; text-transform: uppercase;">Lien de Visioconférence Jitsi</h3>
        <p style="margin: 0; font-size: 13px;">Votre cours aura lieu en ligne. Voici le lien d'accès à votre classe virtuelle sécurisée :</p>
        <div style="text-align: center; margin-top: 16px;">
            <a href="{{ route('meeting.show', $reservation->id) }}" style="background-color: #0BA20B; color: #ffffff !important; text-decoration: none; padding: 14px 28px; border-radius: 4px; font-weight: bold; display: inline-block; text-transform: uppercase; font-size: 14px; letter-spacing: 1px;">Rejoindre la classe</a>
        </div>
    </div>
    @endif

    {{-- <p>Vous pouvez consulter les détails et les supports de cours depuis votre espace personnel.</p>
    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ route('dashboard.apprenant') }}" style="background-color: #1E1613; color: #ffffff !important; text-decoration: none; padding: 14px 28px; border-radius: 4px; font-weight: bold; display: inline-block; text-transform: uppercase; font-size: 14px; letter-spacing: 1px;">Accéder à mon espace</a>
    </div> --}}
</div>
@endsection
