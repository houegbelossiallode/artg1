@extends('layouts.app')
@section('title', 'Écho & Culture — Événements & Agenda')

@section('content')
<section class="pt-32 pb-24 bg-[#F4EFE6] relative overflow-hidden" id="events" x-data="{ activeGallery: null, currentImageIndex: 0, showTitle: '' }">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
    <div class="text-center max-w-3xl mx-auto space-y-4">
      <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-none bg-[#FAF7F2] border border-[#D4A373]/40 text-[#C85A32] text-xs font-bold uppercase tracking-widest shadow-sm">
        <svg aria-hidden="true" class="lucide lucide-calendar w-3.5 h-3.5" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
          <path d="M8 2v4"></path><path d="M16 2v4"></path><rect height="18" rx="2" width="18" x="3" y="4"></rect><path d="M3 10h18"></path>
        </svg>
        <span>Agenda &amp; Rencontres Culturelles</span>
      </div>
      <h2 class="font-serif-title text-3xl sm:text-4xl md:text-5xl font-bold text-[#2C221E] tracking-tight">
        Événements, Festivités &amp; Ateliers
      </h2>
      <p class="text-sm sm:text-base text-[#6B574F] font-sans leading-relaxed">
        Consultez le calendrier de nos représentations musicales, galas du raphia, expositions d'artisanat et scènes ouvertes.
      </p>
    </div>

    @php
        $featuredEvent = $evenements->first();
        $upcomingEvents = $evenements->skip(1);
    @endphp

    @if($featuredEvent)
      @php
          $mainImg = $featuredEvent->images->where('is_principal', true)->first() ?? $featuredEvent->images->first();
          $imgPath = $mainImg ? asset('storage/' . $mainImg->image_path) : '/assets/hero_cultural_bg_1785764970571-BS2uarbi.jpg';
          
          $galleryData = $featuredEvent->images->map(function($img) {
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
      <!-- Événement Phare -->
      <div class="bg-[#1E1613] text-[#FAF7F2] rounded-none overflow-hidden shadow-2xl border border-[#D4A373]/40 grid grid-cols-1 lg:grid-cols-12">
        <div class="lg:col-span-7 p-8 sm:p-12 space-y-6 flex flex-col justify-between">
          <div class="space-y-4">
            <div class="flex items-center gap-2">
              <span class="bg-[#C85A32] text-white text-[11px] font-bold uppercase px-3 py-1 rounded-none">
                À la une
              </span>
              <span class="text-xs text-[#D4A373] font-semibold">
                {{ $featuredEvent->categorie->libelle ?? 'Événement' }}
              </span>
            </div>
            <h3 class="font-serif-title text-3xl sm:text-4xl font-bold text-white leading-tight">
              {{ $featuredEvent->titre }}
            </h3>
            <p class="text-xs sm:text-sm text-[#D1C5B8] leading-relaxed font-sans line-clamp-3">
              {{ strip_tags($featuredEvent->description) }}
            </p>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs text-[#E6DCD3] pt-2">
              <div class="flex items-center gap-2">
                <svg aria-hidden="true" class="lucide lucide-calendar w-4 h-4 text-[#D4A373]" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M8 2v4"></path><path d="M16 2v4"></path><rect height="18" rx="2" width="18" x="3" y="4"></rect><path d="M3 10h18"></path></svg>
                <span>{{ \Carbon\Carbon::parse($featuredEvent->date_debut)->format('d/m/Y') }}</span>
              </div>
              <div class="flex items-center gap-2">
                <svg aria-hidden="true" class="lucide lucide-clock w-4 h-4 text-[#D4A373]" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M12 6v6l4 2"></path><circle cx="12" cy="12" r="10"></circle></svg>
                <span>{{ \Carbon\Carbon::parse($featuredEvent->heure)->format('H:i') }}</span>
              </div>
              <div class="flex items-center gap-2">
                <svg aria-hidden="true" class="lucide lucide-map-pin w-4 h-4 text-[#D4A373]" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path><circle cx="12" cy="10" r="3"></circle></svg>
                <span>{{ $featuredEvent->lieu }}</span>
              </div>
            </div>
          </div>
          <div class="pt-6 border-t border-white/10 flex items-center justify-between">
            <button class="px-6 py-3 rounded-none bg-[#C85A32] hover:bg-[#A84223] text-white font-bold text-xs shadow-lg transition-transform hover:scale-105 flex items-center gap-2">
              <svg aria-hidden="true" class="lucide lucide-ticket w-4 h-4" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"></path><path d="M13 5v2"></path><path d="M13 17v2"></path><path d="M13 11v2"></path></svg>
              <span>Plus de détails</span>
            </button>
            <button type="button" 
                    @click="activeGallery = {{ json_encode($galleryData) }}; currentImageIndex = 0; showTitle = '{{ addslashes($featuredEvent->titre) }}'"
                    class="text-xs font-bold text-[#D4A373] hover:text-white flex items-center gap-1 transition-colors">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
              Voir la galerie ({{ count($galleryData) }})
            </button>
          </div>
        </div>
        
        <div class="lg:col-span-5 relative min-h-[300px] cursor-pointer group overflow-hidden bg-black"
             @click="activeGallery = {{ json_encode($galleryData) }}; currentImageIndex = 0; showTitle = '{{ addslashes($featuredEvent->titre) }}'">
          <img alt="{{ $featuredEvent->titre }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 opacity-90 group-hover:opacity-100" src="{{ $imgPath }}"/>
          <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
            <span class="bg-[#1E1613]/80 backdrop-blur-sm text-[#FAF7F2] border border-[#D4A373]/40 px-4 py-2 text-xs uppercase tracking-widest font-bold">
              Ouvrir la galerie
            </span>
          </div>
        </div>
      </div>
    @endif

    @if($upcomingEvents->count() > 0)
      <div class="space-y-6">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 border-b border-[#D4A373]/30 pb-4">
          <h3 class="font-serif-title text-2xl font-bold text-[#2C221E]">
            Prochains Événements à venir
          </h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          @foreach($upcomingEvents as $evt)
            @php
                $evtMainImg = $evt->images->where('is_principal', true)->first() ?? $evt->images->first();
                $evtImgPath = $evtMainImg ? asset('storage/' . $evtMainImg->image_path) : '/assets/hero_cultural_bg_1785764970571-BS2uarbi.jpg';
                
                $evtGallery = $evt->images->map(function($img) {
                    return [
                        'url' => asset('storage/' . $img->image_path),
                        'is_principal' => (bool) $img->is_principal
                    ];
                })->values()->all();
                if(empty($evtGallery)) {
                    $evtGallery = [
                        ['url' => $evtImgPath, 'is_principal' => true]
                    ];
                }
            @endphp
            <div class="bg-[#FAF7F2] rounded-none overflow-hidden border border-[#D4A373]/30 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
              <div>
                <div class="relative h-48 overflow-hidden bg-black cursor-pointer"
                     @click="activeGallery = {{ json_encode($evtGallery) }}; currentImageIndex = 0; showTitle = '{{ addslashes($evt->titre) }}'">
                  <img alt="{{ $evt->titre }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 opacity-90 group-hover:opacity-100" src="{{ $evtImgPath }}"/>
                  <span class="absolute top-3 left-3 bg-[#1E1613]/80 text-[#D4A373] text-[10px] font-bold px-2.5 py-0.5 rounded-none backdrop-blur-sm">
                    {{ $evt->categorie->libelle ?? 'Événement' }}
                  </span>
                  
                  <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <svg class="w-8 h-8 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                  </div>
                </div>
                
                <div class="p-5 space-y-3">
                  <div class="flex items-center gap-2 text-xs text-[#C85A32] font-semibold">
                    <svg aria-hidden="true" class="lucide lucide-calendar w-3.5 h-3.5" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M8 2v4"></path><path d="M16 2v4"></path><rect height="18" rx="2" width="18" x="3" y="4"></rect><path d="M3 10h18"></path></svg>
                    <span>{{ \Carbon\Carbon::parse($evt->date_debut)->format('d/m/Y') }}</span>
                  </div>
                  <h4 class="font-serif-title font-bold text-lg text-[#2C221E] line-clamp-2">
                    {{ $evt->titre }}
                  </h4>
                  <p class="text-xs text-[#6B574F] line-clamp-2">
                    {{ strip_tags($evt->description) }}
                  </p>
                  <div class="space-y-1 text-xs text-[#8C766B] pt-2 border-t border-[#D4A373]/20">
                    <p class="flex items-center gap-1.5">
                      <svg aria-hidden="true" class="lucide lucide-map-pin w-3.5 h-3.5 text-[#D4A373]" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path><circle cx="12" cy="10" r="3"></circle></svg>
                      <span class="line-clamp-1">{{ $evt->lieu }}</span>
                    </p>
                    <p class="flex items-center gap-1.5">
                      <svg aria-hidden="true" class="lucide lucide-clock w-3.5 h-3.5 text-[#D4A373]" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M12 6v6l4 2"></path><circle cx="12" cy="12" r="10"></circle></svg>
                      <span>{{ \Carbon\Carbon::parse($evt->heure)->format('H:i') }}</span>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @endif

    <!-- Lightbox Modal -->
    <div x-show="activeGallery" 
        class="fixed inset-0 z-[100] bg-slate-950/95 backdrop-blur-md flex items-center justify-center p-4 sm:p-6"
        x-cloak
        @keydown.escape.window="activeGallery = null">
        
        <div class="relative w-full max-w-5xl bg-[#1E1613] border border-[#D4A373]/30 shadow-2xl flex flex-col max-h-[90vh] overflow-hidden rounded-none"
            @click.away="activeGallery = null">
        
        <div class="px-6 py-4 border-b border-[#D4A373]/20 flex items-center justify-between bg-[#1E1613]">
            <div>
            <h3 class="text-sm font-serif-title font-bold text-[#FAF7F2] uppercase tracking-wider" x-text="showTitle"></h3>
            <p class="text-[10px] text-[#D4A373] uppercase tracking-widest mt-0.5">
                Image <span x-text="currentImageIndex + 1"></span> sur <span x-text="activeGallery ? activeGallery.length : 0"></span>
                <template x-if="activeGallery && activeGallery[currentImageIndex] && activeGallery[currentImageIndex].is_principal">
                <span class="ml-2 text-[#C85A32] font-bold">• Image Principale</span>
                </template>
            </p>
            </div>
            <button @click="activeGallery = null" class="text-[#D4A373] hover:text-[#C85A32] p-1 transition-colors" title="Fermer (Echap)">
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
                        class="absolute left-4 top-1/2 -translate-y-1/2 bg-[#1E1613]/80 hover:bg-[#C85A32] text-[#FAF7F2] p-3 transition-colors border border-[#D4A373]/30 shadow-xl rounded-none group">
                <svg class="w-5 h-5 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button @click="currentImageIndex = (currentImageIndex === activeGallery.length - 1) ? 0 : currentImageIndex + 1" 
                        class="absolute right-4 top-1/2 -translate-y-1/2 bg-[#1E1613]/80 hover:bg-[#C85A32] text-[#FAF7F2] p-3 transition-colors border border-[#D4A373]/30 shadow-xl rounded-none group">
                <svg class="w-5 h-5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
            </template>
        </div>

        <template x-if="activeGallery && activeGallery.length > 1">
            <div class="px-6 py-4 bg-[#1E1613] border-t border-[#D4A373]/20 flex items-center justify-center gap-3 overflow-x-auto">
            <template x-for="(img, idx) in activeGallery" :key="idx">
                <button @click="currentImageIndex = idx" 
                        class="w-14 h-14 border-2 overflow-hidden transition-all shrink-0 rounded-none relative group"
                        :class="currentImageIndex === idx ? 'border-[#C85A32] scale-105 opacity-100 z-10' : 'border-[#D4A373]/30 opacity-50 hover:opacity-100'">
                <img :src="img.url" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition-colors" x-show="currentImageIndex !== idx"></div>
                </button>
            </template>
            </div>
        </template>
        </div>
    </div>

  </div>
</section>
@endsection
