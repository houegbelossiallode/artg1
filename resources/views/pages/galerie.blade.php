@extends('layouts.app')
@section('title', 'Écho & Culture — Galerie')

@section('content')
<section class="pt-32 pb-24 bg-[#F4EFE6] relative overflow-hidden" id="gallery">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
<div class="text-center max-w-3xl mx-auto space-y-4">
<div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-none bg-[#FAF7F2] border border-[#0BA20B]/40 text-[#0BA20B] text-xs font-bold uppercase tracking-widest shadow-sm">
<svg aria-hidden="true" class="lucide lucide-image w-3.5 h-3.5" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<rect height="18" rx="2" ry="2" width="18" x="3" y="3">
</rect>
<circle cx="9" cy="9" r="2">
</circle>
<path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21">
</path>
</svg>
<span>
      Médiathèque &amp; Mémoire Visuelle
     </span>
</div>
<h2 class="font-serif-title text-3xl sm:text-4xl md:text-5xl font-bold text-[#2C221E] tracking-tight">
     Galerie de la Vie Associative &amp; Créations
    </h2>
<p class="text-sm sm:text-base text-[#6B574F] font-sans leading-relaxed">
     Revivez les temps forts de nos concerts, ateliers de tressage du raphia, résidences artistiques et expositions.
    </p>
</div>
<div x-data="{ selectedCategory: 'all' }">
  <div class="flex justify-center gap-2">
    <button @click="selectedCategory = 'all'" :class="selectedCategory === 'all' ? 'bg-[#0BA20B] text-white' : 'bg-[#FAF7F2] text-[#2C221E] hover:bg-white border border-[#0BA20B]/30'" class="px-4 py-2 rounded-none text-xs font-semibold transition-all">
      Tous
    </button>
    @foreach($categories as $category)
      <button @click="selectedCategory = '{{ $category->slug }}'" :class="selectedCategory === '{{ $category->slug }}' ? 'bg-[#0BA20B] text-white' : 'bg-[#FAF7F2] text-[#2C221E] hover:bg-white border border-[#0BA20B]/30'" class="px-4 py-2 rounded-none text-xs font-semibold transition-all">
        {{ $category->libelle }}
      </button>
    @endforeach
  </div>
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
  @foreach($galeries as $galerie)
    @php
      $isVideo = $galerie->fichier && in_array(strtolower(pathinfo($galerie->fichier, PATHINFO_EXTENSION)), ['mp4', 'webm', 'mov', 'avi', 'mkv']);
      $fichierUrl = $galerie->fichier ? asset('storage/' . $galerie->fichier) : null;
    @endphp
    <div x-show="selectedCategory === 'all' || selectedCategory === '{{ $galerie->categorie->slug }}'" class="group relative rounded-none overflow-hidden cursor-pointer shadow-sm hover:shadow-2xl transition-all duration-300 h-64 bg-[#1E1613]">
      @if($fichierUrl)
        @if($isVideo)
          <video src="{{ $fichierUrl }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 opacity-90 group-hover:opacity-100" muted loop playsinline poster=""></video>
          <div class="absolute inset-0 flex items-center justify-center z-10">
            <div class="w-12 h-12 rounded-none bg-[#0BA20B] text-white flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
              <svg class="w-6 h-6 ml-1 fill-current" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                <path d="M5 5a2 2 0 0 1 3.008-1.728l11.997 6.998a2 2 0 0 1 .003 3.458l-12 7A2 2 0 0 1 5 19z"></path>
              </svg>
            </div>
          </div>
        @else
          <img alt="{{ $galerie->titre }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 opacity-90 group-hover:opacity-100" src="{{ $fichierUrl }}"/>
        @endif
      @else
        @if($isVideo)
          <div class="absolute inset-0 flex items-center justify-center z-10">
            <div class="w-12 h-12 rounded-none bg-[#0BA20B] text-white flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
              <svg class="w-6 h-6 ml-1 fill-current" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                <path d="M5 5a2 2 0 0 1 3.008-1.728l11.997 6.998a2 2 0 0 1 .003 3.458l-12 7A2 2 0 0 1 5 19z"></path>
              </svg>
            </div>
          </div>
        @else
          <div class="w-full h-full flex items-center justify-center bg-[#2C221E]">
            <svg class="w-12 h-12 text-[#0BA20B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
          </div>
        @endif
      @endif
      <div class="absolute inset-0 bg-gradient-to-t from-[#1E1613]/90 via-[#1E1613]/20 to-transparent opacity-80 group-hover:opacity-95 transition-opacity"></div>
      <div class="absolute top-4 left-4">
        <span class="bg-[#1E1613]/80 text-[#0BA20B] text-[10px] font-bold px-2.5 py-1 rounded-none backdrop-blur-sm border border-white/10 uppercase">
          {{ $galerie->categorie->libelle }}
        </span>
      </div>
      <div class="absolute bottom-4 left-4 right-4 text-white space-y-1">
        <h4 class="font-serif-title text-sm font-bold leading-snug">
          {{ $galerie->titre }}
        </h4>
        <span class="text-[10px] text-[#0BA20B] flex items-center gap-1 font-sans">
          <svg class="lucide lucide-zoom-in w-3 h-3" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
            <circle cx="11" cy="11" r="8"></circle>
            <line x1="21" x2="16.65" y1="21" y2="16.65"></line>
            <line x1="11" x2="11" y1="8" y2="14"></line>
            <line x1="8" x2="14" y1="11" y2="11"></line>
          </svg>
          Agrandir
        </span>
      </div>
    </div>
  @endforeach
  @if($galeries->isEmpty())
    <div class="col-span-full text-center py-12 text-[#6B574F]">
      <p class="text-sm">Aucun élément dans la galerie pour le moment.</p>
    </div>
  @endif
</div>
</div>
</section>
@endsection
