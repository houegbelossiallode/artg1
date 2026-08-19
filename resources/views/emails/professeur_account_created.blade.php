@extends('layouts.email')

@section('content')
<div style="color: #2C221E; line-height: 1.6; font-size: 16px;">
    <h2 style="font-family: 'Georgia', serif; color: #1E1613; font-size: 22px; margin-top: 0;">Bienvenue dans le corps enseignant !</h2>
    <p>Bonjour <strong>{{ $professeur->prenom }} {{ $professeur->nom }}</strong>,</p>
    <p>C'est avec un grand plaisir que nous vous accueillons parmi nos professeurs. Votre compte d'enseignant a été créé avec succès par notre administration.</p>
    <p>Vous pouvez dès à présent vous connecter pour gérer vos cours, consulter vos disponibilités et suivre vos élèves.</p>
    
    <div style="background-color: #FAF7F2; border: 1px solid #E5DFD3; border-left: 4px solid #0BA20B; padding: 20px; margin: 30px 0;">
        <p style="margin: 8px 0; font-size: 14px; color: #4A3C31;"><strong>Email :</strong> {{ $professeur->email }}</p>
        <p style="margin: 8px 0; font-size: 14px; color: #4A3C31;"><strong>Mot de passe :</strong> <span style="font-family: monospace; font-size: 16px; font-weight: bold;">{{ $password }}</span></p>
    </div>

    <p style="font-size: 13px; color: #6B574F;"><em>Pour des raisons de sécurité, nous vous recommandons fortement de modifier ce mot de passe temporaire dès votre première connexion.</em></p>

    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ route('login') }}" style="background-color: #0BA20B; color: #ffffff !important; text-decoration: none; padding: 14px 28px; border-radius: 4px; font-weight: bold; display: inline-block; text-transform: uppercase; font-size: 14px; letter-spacing: 1px;">Accéder à mon espace</a>
    </div>
</div>
@endsection
