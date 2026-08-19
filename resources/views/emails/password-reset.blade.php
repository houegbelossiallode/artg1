@extends('layouts.email')

@section('content')
<div style="color: #2C221E; line-height: 1.6; font-size: 16px;">
    <h2 style="font-family: 'Georgia', serif; color: #1E1613; font-size: 22px; margin-top: 0;">Réinitialisation de mot de passe</h2>
    <p>Bonjour,</p>
    <p>Vous recevez cet e-mail car nous avons reçu une demande de réinitialisation de mot de passe pour votre compte.</p>
    
    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ $url }}" style="background-color: #0BA20B; color: #ffffff !important; text-decoration: none; padding: 14px 28px; border-radius: 4px; font-weight: bold; display: inline-block; text-transform: uppercase; font-size: 14px; letter-spacing: 1px;">Réinitialiser le mot de passe</a>
    </div>

    <div style="background-color: #FAF7F2; border: 1px solid #E5DFD3; border-left: 4px solid #0BA20B; padding: 20px; margin: 30px 0;">
        <p style="margin: 0; font-size: 14px; color: #4A3C31;">Ce lien expirera dans 60 minutes. Si vous n'avez pas demandé de réinitialisation de mot de passe, aucune autre action n'est requise.</p>
    </div>
    
    <p style="font-size: 12px; color: #6B574F; word-break: break-all; margin-top: 30px; border-top: 1px solid #E5DFD3; padding-top: 20px;">
        Si vous ne parvenez pas à cliquer sur le bouton "Réinitialiser le mot de passe", copiez et collez l'URL ci-dessous dans votre navigateur Web :<br>
        <a href="{{ $url }}" style="color: #0BA20B;">{{ $url }}</a>
    </p>
</div>
@endsection
