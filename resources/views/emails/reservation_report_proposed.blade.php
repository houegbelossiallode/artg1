@extends('layouts.email')

@section('content')
<div style="color: #2C221E; line-height: 1.6; font-size: 16px;">
    <p>Bonjour,</p>
    <p>Suite à une demande concernant le cours <strong>{{ $reservation->course->titre }}</strong>, une nouvelle proposition d'horaire vient de vous être envoyée.</p>
    
    <div style="background-color: #FAF7F2; border: 1px solid #E5DFD3; padding: 20px; margin: 24px 0;">
        <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px dashed #E5DFD3;">
            <span style="font-weight: 700; color: #1E1613; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Nouvelle Date</span>
            <span style="color: #4A3C31; font-size: 14px; font-weight: 500; text-align: right;">{{ \Carbon\Carbon::parse($reservation->date_reservation)->translatedFormat('l d F Y') }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px dashed #E5DFD3;">
            <span style="font-weight: 700; color: #1E1613; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Nouvel Horaire</span>
            <span style="color: #4A3C31; font-size: 14px; font-weight: 500; text-align: right;">{{ \Carbon\Carbon::parse($reservation->heure_debut)->format('H\hi') }} - {{ \Carbon\Carbon::parse($reservation->heure_fin)->format('H\hi') }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px dashed #E5DFD3;">
            <span style="font-weight: 700; color: #1E1613; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Professeur</span>
            <span style="color: #4A3C31; font-size: 14px; font-weight: 500; text-align: right;">{{ $reservation->course->professeur->name ?? 'Enseignant' }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; padding: 8px 0;">
            <span style="font-weight: 700; color: #1E1613; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Apprenant</span>
            <span style="color: #4A3C31; font-size: 14px; font-weight: 500; text-align: right;">{{ $reservation->user->name ?? 'Apprenant' }}</span>
        </div>
    </div>
    
    @if(isset($data) && !empty($data['message']))
    <div style="background-color: #Fef3c7; border-left: 4px solid #F59E0B; padding: 16px; margin: 24px 0;">
        <p style="margin: 0; font-size: 13px; font-style: italic; color: #92400E;"><strong>Motif / Message :</strong> "{{ $data['message'] }}"</p>
    </div>
    @endif

    <p>Vous avez la possibilité d'accepter ce nouvel horaire ou de proposer un autre créneau à votre tour (négociation).</p>
    <div style="text-align: center; margin: 30px 0;">
        @if($reservation->status === 'pending_teacher')
            <a href="{{ route('dashboard.professeur') }}" style="background-color: #1E1613; color: #ffffff !important; text-decoration: none; padding: 14px 28px; border-radius: 4px; font-weight: bold; display: inline-block; text-transform: uppercase; font-size: 14px; letter-spacing: 1px;">Gérer mes cours</a>
        @else
            <a href="{{ route('dashboard.apprenant') }}" style="background-color: #1E1613; color: #ffffff !important; text-decoration: none; padding: 14px 28px; border-radius: 4px; font-weight: bold; display: inline-block; text-transform: uppercase; font-size: 14px; letter-spacing: 1px;">Accéder à mon espace</a>
        @endif
    </div>
</div>
@endsection
