@extends('layouts.dashboard')

@section('title', 'Gestion des Actualités | AssoCulture')

@section('content')
<div class="space-y-6" x-data="{ activeGallery: null, currentImageIndex: 0, showTitle: '' }">

  <!-- Flash Messages -->
  <!-- @if (session('success'))
    <div class="p-4 bg-emerald-50 border-l-4 border-emerald-600 text-emerald-800 text-xs shadow-sm flex items-center justify-between">
      <span>{{ session('success') }}</span>
      <button @click="$el.parentElement.remove()" class="text-emerald-600 font-bold ml-4">&times;</button>
    </div>
  @endif -->

  <!-- En-tête -->
  <div class="bg-white border border-slate-200 shadow-sm px-6 py-5 border-l-4 border-l-slate-900 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <h1 class="text-lg font-bold text-slate-900 uppercase tracking-wide">ACTUALITÉS & PRESSE</h1>
      <p class="text-slate-400 text-sm mt-0.5">Gérez la publication des articles, communiqués et annonces de l'association.</p>
    </div>
    <div class="flex flex-wrap items-center gap-2">
      <a href="{{ route('dashboard.admin.actualites.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-900 text-amber-500 font-bold text-[10px] uppercase tracking-widest hover:bg-slate-800 transition shadow-sm cursor-pointer">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
        + ACTUALITÉ
      </a>
    </div>
  </div>

  <!-- Grille d'Actualités Épurée & Claire pour Dashboard -->
  @if ($actualites->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
      @foreach ($actualites as $actu)
        @php
          $mainImage = $actu->images->where('is_principal', true)->first();
          $allImages = $actu->images;
          $totalPhotos = $allImages->count();
          $imagesJson = json_encode($allImages->map(function($img) {
              return [
                  'url' => asset('storage/' . $img->image_path),
                  'is_principal' => (bool)$img->is_principal
              ];
          })->values());
        @endphp

        <div class="bg-white border border-slate-200 shadow-sm hover:border-slate-400 transition-all flex flex-col justify-between overflow-hidden group">
          
          <!-- Image claire sans surcharge -->
          @if($mainImage)
            <div class="w-full h-44 bg-slate-100 overflow-hidden relative cursor-pointer"
                 @click="activeGallery = {{ $imagesJson }}; currentImageIndex = 0; showTitle = '{{ addslashes($actu->titre) }}'">
              <img src="{{ asset('storage/' . $mainImage->image_path) }}" 
                   alt="{{ $actu->titre }}" 
                   class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
              
              <!-- Badge nombre de photos -->
              @if($totalPhotos > 0)
                <span class="absolute bottom-2 right-2 px-2 py-1 bg-slate-900/80 text-white text-[10px] font-bold rounded-none shadow-sm flex items-center gap-1">
                  <svg class="w-3 h-3 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                  {{ $totalPhotos }}
                </span>
              @endif
            </div>
          @endif

          <!-- Contenu structuré & lisible -->
          <div class="p-4 space-y-2.5 flex-1 flex flex-col justify-between">
            <div>
              <!-- Date & Statut -->
              <div class="flex items-center justify-between text-xs text-slate-400 mb-1.5">
                <span class="font-medium flex items-center gap-1 text-slate-500">
                  <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                  {{ \Carbon\Carbon::parse($actu->date_publication)->format('d/m/Y') }}
                </span>

                <span class="px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider rounded-none {{ strtolower($actu->actif) === 'oui' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                  {{ strtolower($actu->actif) === 'oui' ? 'Publié' : 'Brouillon' }}
                </span>
              </div>

              <!-- Titre -->
              <h2 class="text-sm font-bold text-slate-900 group-hover:text-slate-700 transition-colors line-clamp-2 leading-snug">
                {{ $actu->titre }}
              </h2>

              <!-- Extrait -->
              <p class="text-xs text-slate-500 line-clamp-2 mt-1.5 leading-relaxed">
                {{ strip_tags($actu->contenu) }}
              </p>
            </div>
          </div>

          <!-- Actions nettes et simples -->
          <div class="px-4 py-3 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
            <div>
              @if($totalPhotos > 0)
                <button type="button" 
                        @click="activeGallery = {{ $imagesJson }}; currentImageIndex = 0; showTitle = '{{ addslashes($actu->titre) }}'"
                        class="text-xs font-bold text-slate-600 hover:text-slate-900 flex items-center gap-1">
                  <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                  Voir galerie
                </button>
              @endif
            </div>

            <div class="flex items-center gap-2">
              <a href="{{ route('dashboard.admin.actualites.edit', $actu->id) }}" 
                 class="px-2.5 py-1.5 bg-slate-100 hover:bg-slate-900 hover:text-white text-slate-700 text-xs font-bold uppercase tracking-wider transition-colors flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Modifier
              </a>

              <form action="{{ route('dashboard.admin.actualites.destroy', $actu->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette actualité ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="p-1.5 text-red-500 hover:bg-red-50 transition-colors" title="Supprimer">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
              </form>
            </div>
          </div>

        </div>
      @endforeach
    </div>
  @else
    <!-- État Vide Épuré -->
    <div class="bg-white border border-slate-200 p-10 text-center space-y-3 max-w-md mx-auto my-8">
      <svg class="w-10 h-10 text-slate-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
      </svg>
      <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Aucune actualité</h3>
      <p class="text-xs text-slate-500">Commencez par ajouter votre premier article.</p>
      <div class="pt-2">
        <a href="{{ route('dashboard.admin.actualites.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-900 text-amber-500 font-bold text-xs uppercase tracking-wider hover:bg-slate-800 transition">
          + PUBLIER UNE ACTUALITÉ
        </a>
      </div>
    </div>
  @endif

  <!-- MODAL LIGHTBOX POUR VISUALISATION DES IMAGES -->
  <div x-show="activeGallery !== null" 
       x-transition:enter="transition ease-out duration-200"
       x-transition:enter-start="opacity-0"
       x-transition:enter-end="opacity-100"
       x-transition:leave="transition ease-in duration-150"
       x-transition:leave-start="opacity-100"
       x-transition:leave-end="opacity-0"
       class="fixed inset-0 z-50 bg-slate-950/90 backdrop-blur-md flex items-center justify-center p-4 sm:p-6"
       x-cloak
       @keydown.escape.window="activeGallery = null">
    
    <div class="relative w-full max-w-4xl bg-slate-900 border border-slate-800 shadow-2xl flex flex-col max-h-[90vh] overflow-hidden"
         @click.away="activeGallery = null">
      
      <!-- Modal Header -->
      <div class="px-6 py-4 border-b border-slate-800 flex items-center justify-between">
        <div>
          <h3 class="text-sm font-bold text-white uppercase tracking-wider" x-text="showTitle"></h3>
          <p class="text-[10px] text-slate-400 uppercase tracking-widest mt-0.5">
            Image <span x-text="currentImageIndex + 1"></span> sur <span x-text="activeGallery ? activeGallery.length : 0"></span>
            <template x-if="activeGallery && activeGallery[currentImageIndex] && activeGallery[currentImageIndex].is_principal">
              <span class="ml-2 text-amber-400 font-bold">• Image Principale</span>
            </template>
          </p>
        </div>

        <button @click="activeGallery = null" class="text-slate-400 hover:text-white p-1 transition-colors" title="Fermer (Echap)">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
      </div>

      <!-- Main Preview Area -->
      <div class="relative flex-1 bg-black flex items-center justify-center min-h-[350px] p-4 overflow-hidden">
        <template x-if="activeGallery && activeGallery[currentImageIndex]">
          <img :src="activeGallery[currentImageIndex].url" 
               class="max-h-[60vh] max-w-full object-contain shadow-2xl transition-all duration-300">
        </template>

        <!-- Navigation Buttons -->
        <template x-if="activeGallery && activeGallery.length > 1">
          <div>
            <button @click="currentImageIndex = (currentImageIndex === 0) ? activeGallery.length - 1 : currentImageIndex - 1" 
                    class="absolute left-4 top-1/2 -translate-y-1/2 bg-slate-900/80 hover:bg-amber-500 text-white hover:text-slate-950 p-3 transition-colors border border-slate-700 shadow-xl">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </button>

            <button @click="currentImageIndex = (currentImageIndex === activeGallery.length - 1) ? 0 : currentImageIndex + 1" 
                    class="absolute right-4 top-1/2 -translate-y-1/2 bg-slate-900/80 hover:bg-amber-500 text-white hover:text-slate-950 p-3 transition-colors border border-slate-700 shadow-xl">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            </button>
          </div>
        </template>
      </div>

      <!-- Thumbnails Footer -->
      <template x-if="activeGallery && activeGallery.length > 1">
        <div class="px-6 py-4 bg-slate-950 border-t border-slate-800 flex items-center justify-center gap-3 overflow-x-auto">
          <template x-for="(img, idx) in activeGallery" :key="idx">
            <button @click="currentImageIndex = idx" 
                    class="w-14 h-14 border-2 overflow-hidden transition-all shrink-0"
                    :class="currentImageIndex === idx ? 'border-amber-400 scale-105 opacity-100' : 'border-slate-800 opacity-50 hover:opacity-100'">
              <img :src="img.url" class="w-full h-full object-cover">
            </button>
          </template>
        </div>
      </template>

    </div>
  </div>

</div>
@endsection