@extends('layouts.dashboard')

@section('title', 'Œuvres de ' . $talent->prenom . ' ' . $talent->nom . ' | AssoCulture')

@section('content')
<div class="space-y-6" x-data="{ activeMedia: null, activeType: null, activeTitle: '' }">

  <!-- En-tête -->
  <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 pb-4 border-b border-slate-200">
    <div>
      <h1 class="admin-title">Gestion des Œuvres</h1>
      <p class="admin-subtitle">Portfolio de <span class="font-bold text-slate-700">{{ $talent->prenom }} {{ $talent->nom }}</span></p>
    </div>
    <div class="flex flex-wrap items-center gap-3">
      <a href="{{ route('dashboard.admin.talents.index') }}" class="px-4 py-2 bg-slate-100 text-slate-600 font-bold text-[10px] uppercase tracking-widest hover:bg-slate-200 transition shadow-sm inline-flex items-center gap-1.5">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Retour
      </a>
      <a href="{{ route('dashboard.admin.talents.oeuvres.create', ['talent_id' => $talent->id]) }}" class="px-4 py-2 bg-[#0BA20B] text-white font-bold text-[10px] uppercase tracking-widest hover:bg-[#0BA20B]/90 transition shadow-sm inline-flex items-center gap-1.5">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
        NOUVELLE ŒUVRE
      </a>
    </div>
  </div>

  

  <!-- Grille des Œuvres -->
  @if ($oeuvres->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach ($oeuvres as $oeuvre)
        <div class="bg-white border border-slate-200 shadow-sm hover:border-slate-400 transition-all flex flex-col group relative">
          
          <!-- Type Badge (Absolute) -->
          <div class="absolute top-3 left-3 z-10">
            @if($oeuvre->type === 'video')
              <span class="px-2.5 py-1 bg-red-600 text-white text-[9px] font-bold uppercase tracking-widest shadow-md flex items-center gap-1.5"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg> Vidéo</span>
            @elseif($oeuvre->type === 'audio')
              <span class="px-2.5 py-1 bg-amber-500 text-white text-[9px] font-bold uppercase tracking-widest shadow-md flex items-center gap-1.5"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg> Audio</span>
            @elseif($oeuvre->type === 'image')
              <span class="px-2.5 py-1 bg-blue-600 text-white text-[9px] font-bold uppercase tracking-widest shadow-md flex items-center gap-1.5"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg> Image</span>
            @else
              <span class="px-2.5 py-1 bg-slate-800 text-white text-[9px] font-bold uppercase tracking-widest shadow-md flex items-center gap-1.5"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg> Lien</span>
            @endif
          </div>

          <!-- Image / Miniature -->
          <div class="h-48 bg-slate-100 overflow-hidden relative flex items-center justify-center">
            @if($oeuvre->image)
              <img src="{{ asset('storage/' . $oeuvre->image) }}" alt="{{ $oeuvre->nom }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
              <div class="absolute inset-0 bg-slate-900/10 group-hover:bg-transparent transition-colors"></div>
            @else
              <!-- Placeholder stylisé -->
              <div class="absolute inset-0 bg-gradient-to-br from-slate-800 to-slate-900"></div>
              <svg class="w-16 h-16 text-slate-700 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                @if($oeuvre->type === 'video')
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                @elseif($oeuvre->type === 'audio')
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                @elseif($oeuvre->type === 'image')
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                @else
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                @endif
              </svg>
            @endif
          </div>

          <!-- Contenu -->
          <div class="p-5 flex-1 flex flex-col">
            <div class="flex items-center justify-between mb-2">
              <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400 flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                {{ \Carbon\Carbon::parse($oeuvre->date_publication)->format('d/m/Y') }}
              </span>
              <span class="px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider rounded-none {{ strtolower($oeuvre->actif) === 'oui' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                {{ strtolower($oeuvre->actif) === 'oui' ? 'Publié' : 'Brouillon' }}
              </span>
            </div>
            
            <h3 class="text-sm font-bold text-slate-900 leading-tight mb-2 group-hover:text-[#0BA20B] transition-colors">{{ $oeuvre->nom }}</h3>
            
            @if($oeuvre->description)
              <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed flex-1">{{ $oeuvre->description }}</p>
            @else
              <p class="text-xs text-slate-400 italic flex-1">Aucune description.</p>
            @endif
          </div>

          <!-- Actions Footer -->
          <div class="px-5 py-3 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
            @php
              $mediaUrl = $oeuvre->fichier;
              if ($oeuvre->type === 'video') {
                  if (str_contains($mediaUrl, 'youtube.com/watch?v=')) {
                      $mediaUrl = str_replace('watch?v=', 'embed/', $mediaUrl);
                  } elseif (str_contains($mediaUrl, 'youtu.be/')) {
                      $mediaUrl = str_replace('youtu.be/', 'youtube.com/embed/', $mediaUrl);
                  }
              } elseif (in_array($oeuvre->type, ['audio', 'image'])) {
                  $mediaUrl = asset('storage/' . $oeuvre->fichier);
              }
            @endphp
            
            @if($oeuvre->type === 'lien')
              <a href="{{ $mediaUrl }}" target="_blank" class="text-[10px] font-bold text-slate-600 hover:text-[#0BA20B] uppercase tracking-widest flex items-center gap-1 transition-colors">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                Ouvrir
              </a>
            @else
              <button type="button" 
                 @click.prevent="activeMedia = '{{ $mediaUrl }}'; activeType = '{{ $oeuvre->type }}'; activeTitle = '{{ addslashes($oeuvre->nom) }}'"
                 class="text-[10px] font-bold text-slate-600 hover:text-[#0BA20B] uppercase tracking-widest flex items-center gap-1 transition-colors">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                Aperçu
              </button>
            @endif
            
            <div class="flex items-center gap-2">
              <a href="{{ route('dashboard.admin.talents.oeuvres.edit', $oeuvre->id) }}" class="p-1.5 text-slate-400 hover:text-[#0BA20B] hover:bg-green-50 transition-colors" title="Modifier">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
              </a>
              <form action="{{ route('dashboard.admin.talents.oeuvres.destroy', $oeuvre->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette œuvre ?');" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 transition-colors" title="Supprimer">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
              </form>
            </div>
          </div>

        </div>
      @endforeach
    </div>
  @else
    <!-- État Vide -->
    <div class="bg-white border border-slate-200 p-12 text-center max-w-lg mx-auto my-8 shadow-sm">
      <svg class="w-12 h-12 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
      </svg>
      <h3 class="text-sm font-bold text-slate-900 uppercase tracking-widest mb-1">Aucune œuvre enregistrée</h3>
      <p class="text-xs text-slate-500 mb-6">Ce talent n'a pas encore d'œuvres dans son portfolio. Commencez par ajouter une vidéo, un fichier audio ou une image.</p>
      <a href="{{ route('dashboard.admin.talents.oeuvres.create', ['talent_id' => $talent->id]) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#0BA20B] text-white font-bold text-[11px] uppercase tracking-widest hover:bg-[#0BA20B]/90 transition shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
        CRÉER LA PREMIÈRE ŒUVRE
      </a>
    </div>
  @endif

  <!-- MODAL LIGHTBOX POUR VISUALISATION DES MEDIAS -->
  <div x-show="activeMedia !== null" 
       x-transition:enter="transition ease-out duration-200"
       x-transition:enter-start="opacity-0"
       x-transition:enter-end="opacity-100"
       x-transition:leave="transition ease-in duration-150"
       x-transition:leave-start="opacity-100"
       x-transition:leave-end="opacity-0"
       class="fixed inset-0 z-50 bg-slate-950/90 backdrop-blur-md flex items-center justify-center p-4 sm:p-6"
       x-cloak
       @keydown.escape.window="activeMedia = null; activeType = null">
    
    <div class="relative w-full max-w-4xl bg-slate-900 border border-slate-800 shadow-2xl flex flex-col max-h-[90vh] overflow-hidden"
         @click.away="activeMedia = null; activeType = null">
      
      <!-- Modal Header -->
      <div class="px-6 py-4 border-b border-slate-800 flex items-center justify-between">
        <div>
          <h3 class="text-sm font-bold text-white uppercase tracking-wider font-sans" x-text="activeTitle"></h3>
          <p class="text-[10px] text-slate-400 uppercase tracking-widest mt-0.5" x-text="activeType"></p>
        </div>

        <button @click="activeMedia = null; activeType = null" class="text-slate-400 hover:text-white p-1 transition-colors" title="Fermer (Echap)">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
      </div>

      <!-- Main Preview Area -->
      <div class="relative flex-1 bg-black flex items-center justify-center min-h-[400px] p-4 overflow-hidden">
        
        <!-- Affichage Vidéo -->
        <template x-if="activeType === 'video' && activeMedia">
          <iframe :src="activeMedia" class="w-full h-[50vh] sm:h-[60vh] border-0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </template>
        
        <!-- Affichage Audio -->
        <template x-if="activeType === 'audio' && activeMedia">
          <div class="w-full max-w-lg bg-slate-800 p-8 rounded-none border border-slate-700 shadow-2xl text-center">
            <svg class="w-16 h-16 text-amber-500 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
            <audio controls class="w-full">
              <source :src="activeMedia" type="audio/mpeg">
              Votre navigateur ne supporte pas la balise audio.
            </audio>
          </div>
        </template>
        
        <!-- Affichage Image -->
        <template x-if="activeType === 'image' && activeMedia">
          <img :src="activeMedia" class="max-h-[70vh] max-w-full object-contain shadow-2xl transition-all duration-300">
        </template>

      </div>
    </div>
  </div>

</div>
@endsection
