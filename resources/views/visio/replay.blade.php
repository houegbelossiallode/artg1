@extends('layouts.app')
@section('title', 'Replay du cours — ' . $cours->titre)

@section('content')
<section class="pt-28 pb-16 bg-[#FAF7F2] text-[#1E1613] min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-[#0BA20B]/30 pb-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-[#0BA20B] text-white text-[10px] font-bold uppercase tracking-widest mb-2">
                    📼 Enregistrement & Replay
                </div>
                <h1 class="font-serif-title text-3xl font-bold text-[#1E1613]">
                    {{ $cours->titre }}
                </h1>
                <p class="text-xs text-[#6B574F] mt-1">
                    Cours dispensé le {{ \Carbon\Carbon::parse($reservation->date_reservation)->format('d/m/Y') }} par <span class="font-semibold text-[#1E1613]">{{ $cours->professeur ? $cours->professeur->name : 'Enseignant' }}</span>
                </p>
            </div>

            <a href="{{ route('dashboard.apprenant') }}" class="px-4 py-2 bg-[#1E1613] text-white hover:bg-[#0BA20B] text-xs font-bold uppercase tracking-wider transition-colors">
                &larr; Retour à l'espace apprenant
            </a>
        </div>

        <!-- Video Player Frame / Link -->
        <div class="bg-black border border-[#0BA20B]/30 shadow-2xl overflow-hidden relative rounded-none aspect-video flex items-center justify-center">
            @if(Str::contains($reservation->lien_replay, ['youtube.com', 'youtu.be']))
                @php
                    $youtubeId = '';
                    if(preg_match('/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))([\w-]{11})/', $reservation->lien_replay, $matches)) {
                        $youtubeId = $matches[1];
                    }
                @endphp
                @if($youtubeId)
                    <iframe class="w-full h-full" src="https://www.youtube.com/embed/{{ $youtubeId }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                @else
                    <div class="p-8 text-center space-y-4">
                        <p class="text-white text-sm">Visionnage externe disponible pour cet enregistrement.</p>
                        <a href="{{ $reservation->lien_replay }}" target="_blank" class="inline-block px-6 py-3 bg-[#0BA20B] text-white font-bold text-xs uppercase tracking-widest">Ouvrir le Replay dans un nouvel onglet &rarr;</a>
                    </div>
                @endif
            @elseif(Str::contains($reservation->lien_replay, ['vimeo.com']))
                <iframe class="w-full h-full" src="{{ $reservation->lien_replay }}" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
            @else
                <div class="p-8 text-center space-y-4">
                    <svg class="w-16 h-16 text-[#0BA20B] mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-white text-sm font-medium">L'enregistrement de ce cours est hébergé sur une plateforme partenaire.</p>
                    <a href="{{ $reservation->lien_replay }}" target="_blank" class="inline-block px-6 py-3 bg-[#0BA20B] hover:bg-[#087A08] text-white font-bold text-xs uppercase tracking-widest transition-colors">
                        Consulter la vidéo du Replay &rarr;
                    </a>
                </div>
            @endif
        </div>

        @if($reservation->description_replay)
        <div class="bg-white border border-[#0BA20B]/30 p-6 space-y-2">
            <h3 class="font-serif-title text-lg font-bold text-[#1E1613]">Notes & Consignes de l'enseignant</h3>
            <p class="text-sm text-[#6B574F] leading-relaxed whitespace-pre-line">{{ $reservation->description_replay }}</p>
        </div>
        @endif
    </div>
</section>
@endsection
