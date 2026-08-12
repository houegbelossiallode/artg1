@extends('layouts.app')
@section('title', 'Classe Virtuelle Jitsi — ' . $cours->titre)

@section('content')
<section class="pt-28 pb-16 bg-[#1E1613] text-[#FAF7F2] min-h-screen flex flex-col justify-between">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full flex-1 flex flex-col space-y-6">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-[#0BA20B]/20 pb-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-[#0BA20B]/20 border border-[#0BA20B]/40 text-[#0BA20B] text-[10px] font-bold uppercase tracking-widest mb-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    En direct • Visioconférence Sécurisée
                </div>
                <h1 class="font-serif-title text-2xl sm:text-3xl font-bold text-white">
                    {{ $cours->titre }}
                </h1>
                <p class="text-xs text-[#D1C5B8] mt-1">
                    Professeur : <span class="font-semibold text-white">{{ $cours->professeur ? $cours->professeur->name : 'Écho & Culture' }}</span> |
                    Session du {{ \Carbon\Carbon::parse($reservation->date_reservation)->format('d/m/Y') }} à {{ \Carbon\Carbon::parse($reservation->heure_debut)->format('H\hi') }}
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard.apprenant') }}" class="px-4 py-2 bg-white/10 hover:bg-white/20 border border-white/20 text-xs font-bold uppercase tracking-wider transition-colors">
                    &larr; Quitter la classe
                </a>
            </div>
        </div>

        <!-- Jitsi Iframe Container -->
        <div class="w-full flex-1 min-h-[600px] bg-black border border-[#0BA20B]/30 shadow-2xl relative overflow-hidden" id="jitsi-container">
            <div id="jitsi-loading" class="absolute inset-0 flex flex-col items-center justify-center bg-[#1E1613] text-center space-y-4">
                <div class="w-12 h-12 border-4 border-[#0BA20B] border-t-transparent rounded-full animate-spin"></div>
                <p class="text-sm font-semibold text-[#0BA20B] uppercase tracking-wider">Connexion au salon sécurisé Jitsi Meet...</p>
            </div>
        </div>

        <!-- Security Banner -->
        <div class="bg-[#241A16] border border-[#0BA20B]/30 p-4 text-xs text-[#D1C5B8] flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                <span>Ce salon visio est **chiffré et sécurisé**. Seuls les apprenants et professeurs inscrits à ce cours y ont accès.</span>
            </div>
            @if($isTeacher)
            <span class="bg-[#0BA20B] text-white px-3 py-1 font-bold uppercase text-[9px] tracking-widest shrink-0">Vous êtes l'animateur</span>
            @endif
        </div>
    </div>
</section>

<!-- Include Jitsi API -->
<script src="https://meet.jit.si/external_api.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const domain = 'meet.jit.si';
        const options = {
            roomName: '{{ $jitsiRoomName }}',
            width: '100%',
            height: '100%',
            parentNode: document.querySelector('#jitsi-container'),
            userInfo: {
                displayName: '{{ $userName }}'
            },
            configOverwrite: {
                startWithAudioMuted: false,
                startWithVideoMuted: false,
                prejoinPageEnabled: false,
                disableDeepLinking: true
            },
            interfaceConfigOverwrite: {
                TOOLBAR_BUTTONS: [
                    'microphone', 'camera', 'closedcaptions', 'desktop', 'fullscreen',
                    'f画面', 'hangup', 'chat', 'raisehand', 'videoquality', 'filmstrip',
                    'tileview', 'download', 'help', 'mute-everyone', 'security'
                ],
                SHOW_JITSI_WATERMARK: false,
                SHOW_WATERMARK_FOR_GUESTS: false,
                DEFAULT_REMOTE_DISPLAY_NAME: 'Apprenant'
            }
        };

        const api = new JitsiMeetExternalAPI(domain, options);
        api.addEventListener('videoConferenceJoined', function() {
            document.getElementById('jitsi-loading').style.display = 'none';
        });
    });
</script>
@endsection
