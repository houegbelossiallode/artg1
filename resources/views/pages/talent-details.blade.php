@extends('layouts.app')
@section('title', 'Écho & Culture — Profil de ' . $talent->prenom . ' ' . $talent->nom)

@section('content')
    <section class="pt-32 pb-24 bg-[#FAF7F2] relative overflow-hidden" id="talent-details"
        x-data="{ 
            mediaModalOpen: false, 
            currentMediaTitle: '', 
            currentMediaUrl: '', 
            mediaType: '', 
            openMediaModal(title, url, type) { 
                this.currentMediaTitle = title; 
                this.currentMediaUrl = url; 
                this.mediaType = type; 
                this.mediaModalOpen = true; 
            }, 
            closeMediaModal() { 
                this.mediaModalOpen = false; 
                this.currentMediaUrl = ''; 
            } 
        }">
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

            <!-- En-tête du profil (Hauteur réduite) -->
            <div class="bg-[#1E1613] rounded-none overflow-hidden shadow-2xl border border-[#0BA20B]/40 flex flex-col md:flex-row text-[#FAF7F2]">
                <div class="md:w-1/3 relative min-h-[200px] max-h-[340px]">
                    @if($talent->photo)
                        <img alt="{{ trim($talent->prenom . ' ' . $talent->nom) }}" class="w-full h-full object-cover" referrerpolicy="no-referrer" src="{{ asset('storage/' . $talent->photo) }}" />
                    @else
                        <div class="w-full h-full bg-[#2C221E] flex items-center justify-center text-[#0BA20B] text-5xl font-bold">
                            {{ strtoupper(substr($talent->prenom, 0, 1)) }}{{ strtoupper(substr($talent->nom, 0, 1)) }}
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-[#1E1613] via-transparent to-transparent opacity-80"></div>
                </div>

                <div class="md:w-2/3 p-5 sm:p-6 flex flex-col justify-center space-y-3">
                    <div>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-none bg-[#0BA20B]/20 border border-[#0BA20B]/40 text-[#0BA20B] text-[10px] font-bold uppercase mb-2">
                            {{ $talent->categorie ? $talent->categorie->libelle : 'Talent Émergent' }}
                        </span>
                        <h1 class="font-serif-title text-2xl sm:text-3xl font-bold text-white leading-tight">
                            {{ $talent->prenom }} {{ $talent->nom }}
                        </h1>
                    </div>

                    <div class="space-y-1 pt-2 border-t border-white/10">
                        <h3 class="text-[10px] font-bold uppercase text-[#0BA20B] tracking-wider">Biographie</h3>
                        <p class="text-xs text-[#D1C5B8] font-sans leading-relaxed whitespace-pre-wrap">{{ $talent->biographie ?? 'Aucune biographie disponible pour ce talent.' }}</p>
                    </div>

                    <div class="pt-2 border-t border-white/10 space-y-2">
                        <div class="flex flex-wrap items-center gap-4 text-xs font-sans">
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

                        <div class="flex flex-wrap gap-2 pt-1">
                            @if($talent->instagram)
                                <a href="{{ $talent->instagram }}" target="_blank" class="px-3 py-1 bg-white/5 hover:bg-[#0BA20B]/20 text-white text-[10px] font-bold uppercase tracking-wide transition-colors border border-white/10 rounded-none">Instagram</a>
                            @endif
                            @if($talent->facebook)
                                <a href="{{ $talent->facebook }}" target="_blank" class="px-3 py-1 bg-white/5 hover:bg-[#0BA20B]/20 text-white text-[10px] font-bold uppercase tracking-wide transition-colors border border-white/10 rounded-none">Facebook</a>
                            @endif
                            @if($talent->youtube)
                                <a href="{{ $talent->youtube }}" target="_blank" class="px-3 py-1 bg-white/5 hover:bg-[#0BA20B]/20 text-white text-[10px] font-bold uppercase tracking-wide transition-colors border border-white/10 rounded-none">YouTube</a>
                            @endif
                            @if($talent->whatsapp)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $talent->whatsapp) }}" target="_blank" class="px-3 py-1 bg-white/5 hover:bg-[#0BA20B]/20 text-white text-[10px] font-bold uppercase tracking-wide transition-colors border border-white/10 rounded-none">WhatsApp</a>
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
                            $youtube_id = '';
                            if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $talent->youtube, $matches)) {
                                $youtube_id = $matches[1];
                            }
                        @endphp

                        @if($youtube_id)
                            <iframe class="w-full h-[500px]" src="https://www.youtube.com/embed/{{ $youtube_id }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        @else
                            <div class="w-full h-64 flex items-center justify-center text-white/50 text-sm">
                                <button type="button" @click="openMediaModal('{{ addslashes($talent->prenom . ' ' . $talent->nom) }}', '{{ $talent->youtube }}', 'youtube')" class="text-[#0BA20B] hover:underline flex items-center gap-2 cursor-pointer">
                                    Visionner l'extrait vidéo
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                </button>
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

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                        @foreach($talent->oeuvres->where('actif', 'OUI') as $oeuvre)
                            @php
                                $vid_link = $oeuvre->fichier;
                                $mediaUrl = '';
                                $mediaType = '';
                                if ($oeuvre->type === 'video') {
                                    $yt_id = '';
                                    if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $vid_link, $matches)) {
                                        $yt_id = $matches[1];
                                    }
                                    if ($yt_id) {
                                        $mediaUrl = 'https://www.youtube.com/embed/' . $yt_id . '?autoplay=1';
                                        $mediaType = 'youtube';
                                    } else {
                                        $mediaUrl = \Illuminate\Support\Str::startsWith($vid_link, ['http://', 'https://']) ? $vid_link : asset('storage/' . $vid_link);
                                        $mediaType = 'video';
                                    }
                                } elseif ($oeuvre->type === 'image') {
                                    $mediaUrl = \Illuminate\Support\Str::startsWith($vid_link, ['http://', 'https://']) ? $vid_link : asset('storage/' . $vid_link);
                                    $mediaType = 'image';
                                }
                            @endphp
                            <div class="bg-white border border-[#0BA20B]/20 group hover:shadow-2xl transition-all duration-300 rounded-none overflow-hidden flex flex-col relative">
                                <!-- En-tête de la carte (Image ou placeholder) -->
                                <div class="relative h-48 bg-[#1E1613] overflow-hidden flex-shrink-0 @if(in_array($oeuvre->type, ['video', 'image'])) cursor-pointer @endif"
                                     @if(in_array($oeuvre->type, ['video', 'image'])) @click="openMediaModal('{{ addslashes($oeuvre->nom) }}', '{{ $mediaUrl }}', '{{ $mediaType }}')" @endif>
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
                                    @if($oeuvre->type === 'video')
                                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center group-hover:bg-black/20 transition-colors">
                                            <div class="w-12 h-12 rounded-full bg-[#0BA20B] text-white flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                                <svg class="w-6 h-6 ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                            </div>
                                        </div>
                                    @elseif($oeuvre->type === 'image')
                                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                            <div class="w-12 h-12 rounded-full bg-[#0BA20B] text-white flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="absolute inset-0 bg-gradient-to-t from-[#1E1613] via-transparent to-transparent opacity-60 pointer-events-none"></div>
                                    <div class="absolute bottom-3 left-4 pointer-events-none">
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
                                            <button type="button" 
                                                    @click="openMediaModal('{{ addslashes($oeuvre->nom) }}', '{{ $mediaUrl }}', '{{ $mediaType }}')"
                                                    class="flex items-center justify-center gap-2 w-full py-2 bg-[#1E1613] hover:bg-[#0BA20B] text-white text-xs font-bold uppercase tracking-wider transition-colors cursor-pointer">
                                                <svg class="w-4 h-4 text-[#0BA20B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path></svg>
                                                Regarder la vidéo
                                            </button>
                                        @elseif($oeuvre->type === 'image')
                                            <button type="button" 
                                                    @click="openMediaModal('{{ addslashes($oeuvre->nom) }}', '{{ $mediaUrl }}', 'image')"
                                                    class="flex items-center justify-center gap-2 w-full py-2 bg-[#1E1613] hover:bg-[#0BA20B] text-white text-xs font-bold uppercase tracking-wider transition-colors cursor-pointer">
                                                <svg class="w-4 h-4 text-[#0BA20B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                                                Agrandir l'image
                                            </button>
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

        <!-- Modal Popup Lecteur Média (Vidéo / Image) -->
        <div x-show="mediaModalOpen"
            x-cloak
            @keydown.escape.window="closeMediaModal()"
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6 bg-[#1E1613]/85 backdrop-blur-md"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            style="display: none;">
            
            <div @click.away="closeMediaModal()"
                class="relative w-full max-w-5xl bg-[#1E1613] border-2 border-[#0BA20B] shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
                
                <!-- En-tête du modal -->
                <div class="px-6 py-4 bg-[#2C221E] border-b border-[#0BA20B]/30 flex items-center justify-between shrink-0">
                    <div class="flex items-center gap-3">
                        <span class="w-3 h-3 bg-[#0BA20B] rounded-full inline-block animate-pulse"></span>
                        <h3 class="font-serif-title font-bold text-lg text-white truncate max-w-xl" x-text="currentMediaTitle"></h3>
                    </div>
                    <button type="button" @click="closeMediaModal()" class="text-white/70 hover:text-[#0BA20B] text-2xl font-bold leading-none transition-colors cursor-pointer focus:outline-none">&times;</button>
                </div>

                <!-- Zone d'affichage Média -->
                <div class="relative w-full flex-1 bg-black flex items-center justify-center p-2 min-h-[300px] overflow-hidden">
                    <!-- YouTube iFrame -->
                    <template x-if="mediaModalOpen && mediaType === 'youtube'">
                        <div class="w-full aspect-video">
                            <iframe :src="currentMediaUrl" class="w-full h-full border-0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    </template>

                    <!-- Video HTML5 -->
                    <template x-if="mediaModalOpen && mediaType === 'video'">
                        <div class="w-full aspect-video">
                            <video :src="currentMediaUrl" controls autoplay class="w-full h-full"></video>
                        </div>
                    </template>

                    <!-- Image Lightbox -->
                    <template x-if="mediaModalOpen && mediaType === 'image'">
                        <div class="w-full h-full flex items-center justify-center max-h-[75vh]">
                            <img :src="currentMediaUrl" :alt="currentMediaTitle" class="max-w-full max-h-[75vh] object-contain shadow-2xl border border-white/10" />
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </section>
@endsection

