@extends('layouts.app')
@section('title', 'Écho & Culture — Actualités')

@section('content')
<section class="pt-32 pb-24 bg-[#F4EFE6] relative overflow-hidden" id="news" x-data="{ activeGallery: null, currentImageIndex: 0, showTitle: '' }">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
<div class="text-center max-w-3xl mx-auto space-y-4">
<div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-none bg-[#FAF7F2] border border-[#0BA20B]/40 text-[#0BA20B] text-xs font-bold uppercase tracking-widest shadow-sm">
<svg aria-hidden="true" class="lucide lucide-newspaper w-3.5 h-3.5" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="M15 18h-5">
</path>
<path d="M18 14h-8">
</path>
<path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-4 0v-9a2 2 0 0 1 2-2h2">
</path>
<rect height="4" rx="1" width="8" x="10" y="6">
</rect>
</svg>
<span>
      Actualités &amp; Chroniques Associatives
     </span>
</div>
<h2 class="font-serif-title text-3xl sm:text-4xl md:text-5xl font-bold text-[#2C221E] tracking-tight">
     Les Dernières Nouvelles de la Maison Culturelle
    </h2>
<p class="text-sm sm:text-base text-[#6B574F] font-sans leading-relaxed">
     Suivez les avancées des projets agricoles autour du raphia, les événements scolaires et les distinctions de nos jeunes artistes.
    </p>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
    @forelse ($actualites as $actu)
        @php
            $mainImg = $actu->images->where('is_principal', true)->first() ?? $actu->images->first();
            $imgPath = $mainImg ? asset('storage/' . $mainImg->image_path) : '/assets/hero_cultural_bg_1785764970571-BS2uarbi.jpg';
            
            $galleryData = $actu->images->map(function($img) {
                return [
                    'url' => asset('storage/' . $img->image_path),
                    'is_principal' => (bool) $img->is_principal
                ];
            })->values()->all();
            if(empty($galleryData)) {
                $galleryData = [
                    ['url' => $imgPath, 'is_principal' => true]
                ];
            }
        @endphp
        <article class="bg-[#FAF7F2] rounded-none overflow-hidden border border-[#0BA20B]/30 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
            <div>
                <div class="relative h-48 overflow-hidden bg-slate-900 cursor-pointer"
                    data-gallery="{{ json_encode($galleryData) }}"
                    data-title="{{ $actu->titre }}"
                    @click="
                        activeGallery = JSON.parse($el.dataset.gallery);
                        currentImageIndex = 0;
                        showTitle = $el.dataset.title;
                    ">
                    <img alt="{{ $actu->titre }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                        referrerpolicy="no-referrer"
                        src="{{ $imgPath }}" />
                    <span class="absolute top-3 left-3 bg-[#1E1613]/80 text-[#0BA20B] text-[10px] font-bold px-2.5 py-0.5 rounded-none backdrop-blur-sm uppercase">
                        Actualité
                    </span>
                </div>
                <div class="p-6 space-y-3">
                    <div class="flex items-center gap-3 text-xs text-[#8C766B]">
                        <span class="flex items-center gap-1">
                            <svg aria-hidden="true" class="lucide lucide-calendar w-3.5 h-3.5 text-[#0BA20B]" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M8 2v4"></path><path d="M16 2v4"></path><rect height="18" rx="2" width="18" x="3" y="4"></rect><path d="M3 10h18"></path></svg>
                            {{ \Carbon\Carbon::parse($actu->date_publication)->format('d/m/Y') }}
                        </span>
                    </div>
                    <h3 class="font-serif-title font-bold text-lg text-[#2C221E] leading-snug group-hover:text-[#0BA20B] transition-colors line-clamp-2">
                        {{ $actu->titre }}
                    </h3>
                    <p class="text-xs text-[#6B574F] line-clamp-3 leading-relaxed">
                        {{ strip_tags($actu->contenu) }}
                    </p>
                </div>
            </div>
            <div class="p-6 pt-0 border-t border-[#0BA20B]/10 mt-2 flex items-center justify-between text-xs text-[#0BA20B] font-bold">
                <span class="flex items-center gap-1 text-[#8C766B] font-normal">
                    <svg aria-hidden="true" class="lucide lucide-user w-3.5 h-3.5" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    Comité de Rédaction
                </span>
                <a href="{{ route('actualites.show', $actu->id) }}"
                    class="px-3.5 py-1.5 rounded-none bg-[#0BA20B] hover:bg-[#087A08] text-white text-xs font-bold transition-colors flex items-center gap-1">
                    <span>Lire la suite</span>
                    <svg aria-hidden="true" class="lucide lucide-chevron-right w-3.5 h-3.5" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="m9 18 6-6-6-6"></path></svg>
                </a>
            </div>
        </article>
    @empty
        <div class="col-span-3 text-center py-12 text-[#8C766B]">
            <p class="text-sm">Aucune actualité publiée pour le moment.</p>
        </div>
    @endforelse
</div>

<!-- Lightbox Modal -->
<div x-show="activeGallery" 
    class="fixed inset-0 z-[100] bg-slate-950/90 backdrop-blur-md flex items-center justify-center p-4 sm:p-6"
    x-cloak
    @keydown.escape.window="activeGallery = null">
    
    <div class="relative w-full max-w-4xl bg-[#1E1613] border border-[#0BA20B]/30 shadow-2xl flex flex-col max-h-[90vh] overflow-hidden rounded-none"
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
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    <div class="relative flex-1 bg-black flex items-center justify-center min-h-[350px] p-4 overflow-hidden">
        <template x-if="activeGallery && activeGallery[currentImageIndex]">
        <img :src="activeGallery[currentImageIndex].url" 
            class="max-h-[60vh] max-w-full object-contain shadow-2xl transition-all duration-300">
        </template>
        <template x-if="activeGallery && activeGallery.length > 1">
        <div>
            <button @click="currentImageIndex = (currentImageIndex === 0) ? activeGallery.length - 1 : currentImageIndex - 1" 
                    class="absolute left-4 top-1/2 -translate-y-1/2 bg-[#1E1613]/80 hover:bg-[#0BA20B] text-[#FAF7F2] p-3 transition-colors border border-[#0BA20B]/30 shadow-xl rounded-none">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <button @click="currentImageIndex = (currentImageIndex === activeGallery.length - 1) ? 0 : currentImageIndex + 1" 
                    class="absolute right-4 top-1/2 -translate-y-1/2 bg-[#1E1613]/80 hover:bg-[#0BA20B] text-[#FAF7F2] p-3 transition-colors border border-[#0BA20B]/30 shadow-xl rounded-none">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>
        </template>
    </div>

    <template x-if="activeGallery && activeGallery.length > 1">
        <div class="px-6 py-4 bg-[#1E1613] border-t border-[#0BA20B]/20 flex items-center justify-center gap-3 overflow-x-auto">
        <template x-for="(img, idx) in activeGallery" :key="idx">
            <button @click="currentImageIndex = idx" 
                    class="w-14 h-14 border-2 overflow-hidden transition-all shrink-0 rounded-none"
                    :class="currentImageIndex === idx ? 'border-[#0BA20B] scale-105 opacity-100' : 'border-[#0BA20B]/30 opacity-50 hover:opacity-100'">
            <img :src="img.url" class="w-full h-full object-cover">
            </button>
        </template>
        </div>
    </template>

    </div>
</div>
</div>
</section>
@endsection
