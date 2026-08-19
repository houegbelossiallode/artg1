@extends('layouts.email')

@section('content')
<div style="color: #2C221E; line-height: 1.6; font-size: 16px;">
    <p>Bonjour <strong>{{ $professeur->prenom }} {{ $professeur->nom }}</strong>,</p>
    <p>Nous avons le plaisir de vous informer que votre compte Professeur sur la plateforme <strong>Écho & Culture</strong> a été créé avec succès par l'administration.</p>
    
    <p>Vous trouverez ci-dessous vos identifiants de connexion générés automatiquement :</p>
    
    <div style="background-color: #FAF7F2; border: 1px solid #E5DFD3; padding: 20px; margin: 24px 0;">
        <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px dashed #E5DFD3;">
            <span style="font-weight: 700; color: #1E1613; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Email de connexion</span>
            <span style="color: #4A3C31; font-size: 14px; font-weight: 500; text-align: right; font-family: monospace;">{{ $professeur->email }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; padding: 8px 0;">
            <span style="font-weight: 700; color: #1E1613; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Mot de passe temporaire</span>
            <span style="color: #4A3C31; font-size: 14px; font-weight: 500; text-align: right; font-family: monospace; font-size: 16px; font-weight: bold; color: #0BA20B;">{{ $password }}</span>
        </div>
    </div>
    
    <p style="font-size: 12px; color: #8C766B; font-style: italic;">Note : Nous vous invitons vivement à modifier ce mot de passe temporaire dès votre première connexion, en vous rendant dans les paramètres de votre compte.</p>

    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ route('login') }}" style="background-color: #0BA20B; color: #ffffff !important; text-decoration: none; padding: 14px 28px; border-radius: 4px; font-weight: bold; display: inline-block; text-transform: uppercase; font-size: 14px; letter-spacing: 1px;">Se connecter</a>
    </div>
</div>
@endsection
