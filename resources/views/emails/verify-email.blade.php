@extends('layouts.email')

@section('content')
<div style="color: #2C221E; line-height: 1.6; font-size: 16px;">
    <p>Bonjour <strong>{{ $user->prenom }}</strong>,</p>
    <p>Bienvenue sur la plateforme {{$association->nom }} !</p>
    <p>Pour finaliser la création de votre compte et accéder à votre espace membre, veuillez valider votre adresse email en cliquant sur le bouton ci-dessous :</p>
    
    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ $url }}" style="background-color: #0BA20B; color: #ffffff !important; padding: 14px 28px; text-decoration: none; border-radius: 4px; font-weight: bold; display: inline-block; text-transform: uppercase; font-size: 14px; letter-spacing: 1px;">Valider mon compte</a>
    </div>
    
    <p>Si le bouton ne fonctionne pas, copiez et collez le lien suivant dans votre navigateur :<br>
    <a href="{{ $url }}" style="color: #0BA20B; word-break: break-all; font-size: 13px;">{{ $url }}</a></p>
    
    <p>À très bientôt,<br>L'équipe {{ $association->nom }}</p>
</div>
@endsection
