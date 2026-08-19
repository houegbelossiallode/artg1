@extends('layouts.app')
@section('title', 'Écho & Culture — ' . $item->titre)

@section('content')
@php
    $mainImg = $item->images->where('is_principal', true)->first() ?? $item->images->first();
    $heroImgPath = $mainImg ? asset('storage/' . $mainImg->image_path) : '/assets/hero_cultural_bg_1785764970571-BS2uarbi.jpg';
    
    $galleryData = $item->images->map(function($img) {
        return [
            'url' => asset('storage/' . $img->image_path),
            'is_principal' => (bool) $img->is_principal
        ];
    })->values()->all();
    if(empty($galleryData)) {
        $galleryData = [
            ['url' => $heroImgPath, 'is_principal' => true]
        ];
    }
@endphp

<!-- Main Container -->
<section class="pt-32 pb-24 bg-[#FAF7F2]" x-data="{ activeGallery: null, currentImageIndex: 0, showTitle: '' }">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
        
        <!-- Header / Title -->
        <div class="text-center max-w-4xl mx-auto space-y-6 pt-8">
            <div class="inline-flex items-center gap-3 text-[10px] font-bold uppercase tracking-[0.2em] text-[#0BA20B]">
                <a href="{{ url('/') }}" class="hover:text-[#087A08] transition-colors">Accueil</a>
                <span class="text-[#0BA20B]">-</span>
                @if($type === 'evenement')
                    <a href="{{ route('evenements') }}" class="hover:text-[#087A08] transition-colors">Événements</a>
                @else
                    <a href="{{ route('actualites') }}" class="hover:text-[#087A08] transition-colors">Actualités</a>
                @endif
                <span class="text-[#0BA20B]">-</span>
                <span class="text-[#8C766B] truncate max-w-[200px]">{{ $item->titre }}</span>
            </div>
            
            <h1 class="font-serif-title text-4xl sm:text-5xl md:text-6xl font-bold text-[#1E1613] leading-[1.1] tracking-tight">
                {{ $item->titre }}
            </h1>

            @if($type === 'evenement')
                <div class="flex items-center justify-center gap-2 pt-4">
                    <span class="bg-[#1E1613] text-[#0BA20B] px-4 py-1.5 text-xs font-bold uppercase tracking-widest">
                        {{ $item->categorie ? $item->categorie->libelle : 'Événement' }}
                    </span>
                </div>
            @endif
        </div>

        <!-- Featured Image -->
        <div class="w-full h-[400px] sm:h-[500px] overflow-hidden border border-[#0BA20B]/30 shadow-sm relative group">
            <img src="{{ $heroImgPath }}" alt="{{ $item->titre }}" class="w-full h-full object-cover transition-transform duration-[2000ms] group-hover:scale-105">
            <div class="absolute inset-0 bg-[#1E1613]/5 group-hover:bg-transparent transition-colors duration-500"></div>
        </div>

        <!-- Content Layout -->
        <div class="flex flex-col lg:flex-row gap-12 lg:gap-16 items-start">
            
            <!-- Main Content -->
            <div class="w-full lg:w-2/3 space-y-12">
                <div class="prose prose-lg prose-[#6B574F] max-w-none font-sans leading-loose prose-headings:font-serif-title prose-headings:text-[#1E1613] prose-a:text-[#0BA20B] hover:prose-a:text-[#087A08]">
                    @if($type === 'evenement')
                        {!! $item->description !!}
                    @else
                        {!! $item->contenu !!}
                    @endif
                </div>

                @if(count($galleryData) > 1)
                <!-- Gallery -->
                <div class="pt-12 border-t border-[#0BA20B]/20">
                    <h3 class="font-serif-title text-2xl font-bold text-[#1E1613] mb-8">Galerie Associée</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($item->images as $img)
                            <div class="relative h-32 sm:h-48 overflow-hidden bg-[#1E1613] cursor-pointer group border border-[#0BA20B]/20"
                                data-gallery="{{ json_encode($galleryData) }}"
                                data-title="{{ $item->titre }}"
                                @click="
                                    activeGallery = JSON.parse($el.dataset.gallery);
                                    currentImageIndex = {{ $loop->index }};
                                    showTitle = $el.dataset.title;
                                ">
                                <img src="{{ asset('storage/' . $img->image_path) }}" alt="Image" class="w-full h-full object-cover opacity-80 group-hover:scale-110 transition-transform duration-700 group-hover:opacity-100">
                                @if($img->is_principal)
                                <span class="absolute top-2 left-2 bg-[#0BA20B] text-white text-[9px] font-bold px-2 py-0.5 uppercase tracking-wider">À la une</span>
                                @endif
                                <div class="absolute inset-0 bg-[#0BA20B]/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="w-full lg:w-1/3 sticky top-32">
                <div class="bg-white border border-[#0BA20B]/20 p-8 shadow-sm relative">
                    <!-- Deco corners -->
                    <div class="absolute top-0 left-0 w-2 h-2 border-t border-l border-[#0BA20B]"></div>
                    <div class="absolute top-0 right-0 w-2 h-2 border-t border-r border-[#0BA20B]"></div>
                    <div class="absolute bottom-0 left-0 w-2 h-2 border-b border-l border-[#0BA20B]"></div>
                    <div class="absolute bottom-0 right-0 w-2 h-2 border-b border-r border-[#0BA20B]"></div>

                    <h3 class="font-serif-title text-xl font-bold text-[#1E1613] mb-6 pb-4 border-b border-[#0BA20B]/20 uppercase tracking-widest text-center">
                        @if($type === 'evenement')
                        L'Événement
                        @else
                        L'Article
                        @endif
                    </h3>
                    
                    <ul class="space-y-6">
                        @if($type === 'evenement')
                            <li class="flex items-start gap-4">
                                <div class="mt-1">
                                    <svg class="w-4 h-4 text-[#0BA20B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[9px] uppercase font-bold text-[#0BA20B] tracking-widest mb-0.5">Date</p>
                                    <p class="text-[#2C221E] font-medium text-sm">{{ \Carbon\Carbon::parse($item->date_debut)->translatedFormat('l d F Y') }}</p>
                                </div>
                            </li>
                            
                            <li class="flex items-start gap-4">
                                <div class="mt-1">
                                    <svg class="w-4 h-4 text-[#0BA20B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[9px] uppercase font-bold text-[#0BA20B] tracking-widest mb-0.5">Heure</p>
                                    <p class="text-[#2C221E] font-medium text-sm">{{ \Carbon\Carbon::parse($item->heure)->format('H\hi') }}</p>
                                </div>
                            </li>

                            <li class="flex items-start gap-4">
                                <div class="mt-1">
                                    <svg class="w-4 h-4 text-[#0BA20B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[9px] uppercase font-bold text-[#0BA20B] tracking-widest mb-0.5">Lieu</p>
                                    <p class="text-[#2C221E] font-medium text-sm">{{ $item->lieu }}</p>
                                </div>
                            </li>
                        @else
                            <li class="flex items-start gap-4">
                                <div class="mt-1">
                                    <svg class="w-4 h-4 text-[#0BA20B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[9px] uppercase font-bold text-[#0BA20B] tracking-widest mb-0.5">Publié le</p>
                                    <p class="text-[#2C221E] font-medium text-sm">{{ \Carbon\Carbon::parse($item->date_publication)->translatedFormat('l d F Y') }}</p>
                                </div>
                            </li>
                            
                            <li class="flex items-start gap-4">
                                <div class="mt-1">
                                    <svg class="w-4 h-4 text-[#0BA20B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[9px] uppercase font-bold text-[#0BA20B] tracking-widest mb-0.5">Par</p>
                                    <p class="text-[#2C221E] font-medium text-sm">Comité de Rédaction</p>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Lightbox Modal -->
    <div x-show="activeGallery" 
        class="fixed inset-0 z-[100] bg-slate-950/95 backdrop-blur-sm flex items-center justify-center p-4 sm:p-6"
        x-cloak
        @keydown.escape.window="activeGallery = null">
        
        <div class="relative w-full max-w-5xl bg-[#1E1613] border border-[#0BA20B]/30 shadow-2xl flex flex-col max-h-[95vh] overflow-hidden rounded-none"
            @click.away="activeGallery = null">
        
        <div class="px-6 py-4 border-b border-[#0BA20B]/20 flex items-center justify-between bg-[#1E1613]">
            <div>
            <h3 class="text-sm font-serif-title font-bold text-[#FAF7F2] uppercase tracking-wider" x-text="showTitle"></h3>
            <p class="text-[10px] text-[#0BA20B] uppercase tracking-widest mt-0.5">
                Image <span x-text="currentImageIndex + 1"></span> sur <span x-text="activeGallery ? activeGallery.length : 0"></span>
                <template x-if="activeGallery && activeGallery[currentImageIndex] && activeGallery[currentImageIndex].is_principal">
                <span class="ml-2 text-[#0BA20B] font-bold">• Image Principale</span>
                </template>
            </p>
            </div>
            <button @click="activeGallery = null" class="text-[#0BA20B] hover:text-[#0BA20B] p-1 transition-colors" title="Fermer (Echap)">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div class="relative flex-1 bg-black flex items-center justify-center min-h-[400px] p-4 overflow-hidden">
            <template x-if="activeGallery && activeGallery[currentImageIndex]">
            <img :src="activeGallery[currentImageIndex].url" 
                class="max-h-[70vh] max-w-full object-contain shadow-2xl transition-all duration-300">
            </template>
            <template x-if="activeGallery && activeGallery.length > 1">
            <div>
                <button @click="currentImageIndex = (currentImageIndex === 0) ? activeGallery.length - 1 : currentImageIndex - 1" 
                        class="absolute left-6 top-1/2 -translate-y-1/2 bg-[#1E1613]/90 hover:bg-[#0BA20B] text-[#FAF7F2] p-4 transition-colors border border-[#0BA20B]/30 shadow-xl rounded-none group">
                <svg class="w-6 h-6 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button @click="currentImageIndex = (currentImageIndex === activeGallery.length - 1) ? 0 : currentImageIndex + 1" 
                        class="absolute right-6 top-1/2 -translate-y-1/2 bg-[#1E1613]/90 hover:bg-[#0BA20B] text-[#FAF7F2] p-4 transition-colors border border-[#0BA20B]/30 shadow-xl rounded-none group">
                <svg class="w-6 h-6 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
            </template>
        </div>

        <template x-if="activeGallery && activeGallery.length > 1">
            <div class="px-6 py-4 bg-[#1E1613] border-t border-[#0BA20B]/20 flex items-center justify-center gap-4 overflow-x-auto">
            <template x-for="(img, idx) in activeGallery" :key="idx">
                <button @click="currentImageIndex = idx" 
                        class="w-16 h-16 border-2 overflow-hidden transition-all shrink-0 rounded-none relative group"
                        :class="currentImageIndex === idx ? 'border-[#0BA20B] scale-110 opacity-100 shadow-lg' : 'border-[#0BA20B]/30 opacity-60 hover:opacity-100'">
                <img :src="img.url" class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                <div class="absolute inset-0 bg-black/20" x-show="currentImageIndex !== idx"></div>
                </button>
            </template>
            </div>
        </template>

        </div>
    </div>
</section>
@endsection
