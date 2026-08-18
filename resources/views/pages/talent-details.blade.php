@extends('layouts.app')
@section('title', 'Écho & Culture — Profil de ' . $talent->prenom . ' ' . $talent->nom)

@section('content')
    <section class="pt-32 pb-24 bg-[#FAF7F2] relative overflow-hidden" id="talent-details">
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-12 xl:px-24 space-y-12">
            <!-- Retour -->
            <div>
                <a href="{{ route('talents') }}" class="inline-flex items-center gap-2 text-[#6B574F] hover:text-[#0BA20B] font-bold text-xs uppercase tracking-wider transition-colors">
                    <svg aria-hidden="true" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Retour à la galerie
                </a>
            </div>

            <!-- En-tête du profil -->
            <div class="bg-[#1E1613] rounded-none overflow-hidden shadow-2xl border border-[#0BA20B]/40 flex flex-col md:flex-row text-[#FAF7F2]">
                <div class="md:w-2/5 relative min-h-[350px]">
                    @if($talent->photo)
                        <img alt="{{ trim($talent->prenom . ' ' . $talent->nom) }}" class="w-full h-full object-cover" referrerpolicy="no-referrer" src="{{ asset('storage/' . $talent->photo) }}" />
                    @else
                        <div class="w-full h-full bg-[#2C221E] flex items-center justify-center text-[#0BA20B] text-8xl font-bold">
                            {{ strtoupper(substr($talent->prenom, 0, 1)) }}{{ strtoupper(substr($talent->nom, 0, 1)) }}
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-[#1E1613] via-transparent to-transparent opacity-80"></div>
                </div>

                <div class="md:w-3/5 p-8 sm:p-12 flex flex-col justify-center space-y-6">
                    <div>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-none bg-[#0BA20B]/20 border border-[#0BA20B]/40 text-[#0BA20B] text-xs font-bold uppercase mb-4">
                            {{ $talent->categorie ? $talent->categorie->libelle : 'Talent Émergent' }}
                        </span>
                        <h1 class="font-serif-title text-4xl sm:text-5xl font-bold text-white leading-tight">
                            {{ $talent->prenom }} {{ $talent->nom }}
                        </h1>
                    </div>

                    <div class="space-y-4 pt-4 border-t border-white/10">
                        <h3 class="text-xs font-bold uppercase text-[#0BA20B] tracking-wider">Biographie</h3>
                        <p class="text-sm text-[#D1C5B8] font-sans leading-relaxed whitespace-pre-wrap">{{ $talent->biographie ?? 'Aucune biographie disponible pour ce talent.' }}</p>
                    </div>

                    <div class="pt-6 border-t border-white/10 space-y-4">
                        <h3 class="text-xs font-bold uppercase text-[#0BA20B] tracking-wider">Contact & Réseaux</h3>
                        <div class="flex flex-wrap items-center gap-4 text-sm font-sans">
                            @if($talent->email)
                                <a href="mailto:{{ $talent->email }}" class="flex items-center gap-2 text-white/90 hover:text-[#0BA20B] transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    <span>Email</span>
                                </a>
                            @endif
                            @if($talent->telephone)
                                <span class="flex items-center gap-2 text-white/90">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    <span>{{ $talent->telephone }}</span>
                                </span>
                            @endif
                        </div>

                        <div class="flex flex-wrap gap-3 pt-2">
                            @if($talent->instagram)
                                <a href="{{ $talent->instagram }}" target="_blank" class="px-4 py-2 bg-white/5 hover:bg-[#0BA20B]/20 text-white text-xs font-bold uppercase tracking-wide transition-colors border border-white/10 rounded-none">Instagram</a>
                            @endif
                            @if($talent->facebook)
                                <a href="{{ $talent->facebook }}" target="_blank" class="px-4 py-2 bg-white/5 hover:bg-[#0BA20B]/20 text-white text-xs font-bold uppercase tracking-wide transition-colors border border-white/10 rounded-none">Facebook</a>
                            @endif
                            @if($talent->youtube)
                                <a href="{{ $talent->youtube }}" target="_blank" class="px-4 py-2 bg-white/5 hover:bg-[#0BA20B]/20 text-white text-xs font-bold uppercase tracking-wide transition-colors border border-white/10 rounded-none">YouTube</a>
                            @endif
                            @if($talent->whatsapp)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $talent->whatsapp) }}" target="_blank" class="px-4 py-2 bg-white/5 hover:bg-[#0BA20B]/20 text-white text-xs font-bold uppercase tracking-wide transition-colors border border-white/10 rounded-none">WhatsApp</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Démo (YouTube) -->
            @if($talent->youtube)
                <div class="bg-white p-8 border border-[#0BA20B]/30 shadow-md">
                    <h3 class="font-serif-title text-2xl font-bold text-[#2C221E] mb-6 flex items-center gap-2">
                        <svg class="w-6 h-6 text-[#0BA20B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Extrait Vidéo
                    </h3>
                    <div class="aspect-w-16 aspect-h-9 w-full bg-[#1E1613]">
                        @php
                            // Extraire l'ID de la vidéo Youtube pour un iframe
                            $youtube_id = '';
                            if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $talent->youtube, $matches)) {
                                $youtube_id = $matches[1];
                            }
                        @endphp

                        @if($youtube_id)
                            <iframe class="w-full h-[500px]" src="https://www.youtube.com/embed/{{ $youtube_id }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        @else
                            <div class="w-full h-64 flex items-center justify-center text-white/50 text-sm">
                                <a href="{{ $talent->youtube }}" target="_blank" class="text-[#0BA20B] hover:underline flex items-center gap-2">
                                    Visionner sur YouTube
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Portfolio & Œuvres -->
            @if($talent->oeuvres && $talent->oeuvres->where('actif', 'OUI')->count() > 0)
                <div class="space-y-8 pt-8">
                    <div class="flex items-center gap-4">
                        <h3 class="font-serif-title text-3xl font-bold text-[#2C221E]">Portfolio & Réalisations</h3>
                        <div class="h-px bg-[#0BA20B]/30 flex-1"></div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($talent->oeuvres->where('actif', 'OUI') as $oeuvre)
                            <div class="bg-white border border-[#0BA20B]/20 group hover:shadow-2xl transition-all duration-300 rounded-none overflow-hidden flex flex-col relative">
                                <!-- En-tête de la carte (Image ou placeholder) -->
                                <div class="relative h-48 bg-[#1E1613] overflow-hidden flex-shrink-0">
                                    @if($oeuvre->image)
                                        <img src="{{ asset('storage/' . $oeuvre->image) }}" alt="{{ $oeuvre->nom }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center opacity-30 group-hover:scale-110 transition-transform duration-700">
                                            @if($oeuvre->type === 'video')
                                                <svg class="w-16 h-16 text-[#FAF7F2]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            @elseif($oeuvre->type === 'audio')
                                                <svg class="w-16 h-16 text-[#FAF7F2]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path></svg>
                                            @elseif($oeuvre->type === 'image')
                                                <svg class="w-16 h-16 text-[#FAF7F2]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            @else
                                                <svg class="w-16 h-16 text-[#FAF7F2]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                            @endif
                                        </div>
                                    @endif
                                    <div class="absolute inset-0 bg-gradient-to-t from-[#1E1613] via-transparent to-transparent opacity-60"></div>
                                    <div class="absolute bottom-3 left-4">
                                        <span class="inline-block px-2.5 py-0.5 bg-[#0BA20B] text-white text-[10px] font-bold uppercase tracking-widest shadow-sm">
                                            {{ $oeuvre->type }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Corps de la carte -->
                                <div class="p-6 flex flex-col flex-grow bg-[#FAF7F2]">
                                    <div class="flex justify-between items-start mb-2">
                                        <h4 class="font-bold text-lg text-[#2C221E] leading-tight">{{ $oeuvre->nom }}</h4>
                                        <span class="text-[10px] text-[#0BA20B] font-bold whitespace-nowrap ml-2">
                                            {{ \Carbon\Carbon::parse($oeuvre->date_publication)->format('Y') }}
                                        </span>
                                    </div>

                                    @if($oeuvre->description)
                                        <p class="text-xs text-[#6B574F] mb-4 flex-grow">{{ $oeuvre->description }}</p>
                                    @endif

                                    <!-- Player ou Bouton d'action selon le type -->
                                    <div class="mt-auto pt-4 border-t border-[#0BA20B]/10">
                                        @if($oeuvre->type === 'audio')
                                            <audio controls class="w-full h-8" preload="none">
                                                <source src="{{ asset('storage/' . $oeuvre->fichier) }}" type="audio/mpeg">
                                                Votre navigateur ne supporte pas l'élément audio.
                                            </audio>
                                        @elseif($oeuvre->type === 'video')
                                            @php
                                                $vid_link = $oeuvre->fichier;
                                                if (strpos($vid_link, 'youtube.com') !== false || strpos($vid_link, 'youtu.be') !== false) {
                                                    $is_yt = true;
                                                } else {
                                                    $is_yt = false;
                                                }
                                            @endphp
                                            <a href="{{ $vid_link }}" target="_blank" class="flex items-center justify-center gap-2 w-full py-2 bg-[#1E1613] hover:bg-[#0BA20B] text-white text-xs font-bold uppercase tracking-wider transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path></svg>
                                                Regarder la vidéo
                                            </a>
                                        @elseif($oeuvre->type === 'image')
                                            <a href="{{ asset('storage/' . $oeuvre->fichier) }}" target="_blank" class="flex items-center justify-center gap-2 w-full py-2 bg-[#1E1613] hover:bg-[#0BA20B] text-white text-xs font-bold uppercase tracking-wider transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                                                Agrandir l'image
                                            </a>
                                        @elseif($oeuvre->type === 'lien')
                                            <a href="{{ $oeuvre->fichier }}" target="_blank" class="flex items-center justify-center gap-2 w-full py-2 bg-[#1E1613] hover:bg-[#0BA20B] text-white text-xs font-bold uppercase tracking-wider transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                                Visiter le lien
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </section>
@endsection
