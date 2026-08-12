@extends('layouts.dashboard')

@section('title', 'Galeries | AssoCulture')

@section('content')
<div class="space-y-6" x-data="{ activeImage: null, showTitle: '' }">
  
  <!-- Flash Messages -->
  @if (session('success'))
    <div class="p-4 bg-emerald-50 border-l-4 border-emerald-600 text-emerald-800 text-xs shadow-sm flex items-center justify-between">
      <span>{{ session('success') }}</span>
      <button onclick="this.parentElement.remove()" class="text-emerald-600 font-bold ml-4">&times;</button>
    </div>
  @endif

  <!-- En-tête -->
  <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 pb-4 border-b border-slate-200">
    <div>
      <h1 class="admin-title">Galerie</h1>
      <p class="admin-subtitle">Gérez les photos, vidéos et créations de la médiathèque.</p>
    </div>
    <div class="flex flex-wrap items-center gap-2">
      <a href="{{ route('dashboard.admin.galeries.create') }}" class="btn-primary">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
        ÉLÉMENT
      </a>
    </div>
  </div>

  <!-- Grille de la Galerie -->
  @if($galeries->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      @foreach ($galeries as $galerie)
        <div class="bg-white border border-slate-200 shadow-sm flex flex-col group hover:border-[#0BA20B] transition-colors rounded-none relative overflow-hidden">
          
          <!-- Aperçu du Média -->
          <div class="h-40 bg-slate-100 relative overflow-hidden border-b border-slate-100">
            @if($galerie->fichier)
              @if($galerie->categorie && $galerie->categorie->slug == 'videos')
                <div x-data="{ playing: false }" class="w-full h-full relative">
                  <video x-ref="videoPlayer" src="{{ asset('storage/' . $galerie->fichier) }}" controls preload="metadata" class="w-full h-full object-cover bg-slate-900" @play="playing = true" @pause="playing = false" @ended="playing = false"></video>
                  
                  <!-- Overlay Play -->
                  <div x-show="!playing" @click="$refs.videoPlayer.play()" class="absolute inset-0 flex flex-col items-center justify-center bg-slate-900/60 cursor-pointer hover:bg-slate-900/40 transition-colors z-10">
                     <svg class="w-16 h-16 text-[#0BA20B] opacity-90 group-hover:scale-110 transition-transform drop-shadow-lg" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                     <span class="text-white text-[10px] uppercase tracking-widest mt-2 font-bold bg-black/50 px-2 py-1 rounded-none border border-white/20">Lire la vidéo</span>
                  </div>
                </div>
              @else
                <img src="{{ asset('storage/' . $galerie->fichier) }}" 
                     alt="{{ $galerie->titre }}" 
                     @click="activeImage = '{{ asset('storage/' . $galerie->fichier) }}'; showTitle = '{{ addslashes($galerie->titre) }}'"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 cursor-pointer">
              @endif
            @else
              <div class="w-full h-full flex items-center justify-center text-slate-300 bg-slate-50">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
              </div>
            @endif
            
            <!-- Badge Statut -->
            <div class="absolute top-3 right-3">
              <span class="px-2 py-1 text-[9px] font-bold uppercase tracking-widest border shadow-sm {{ $galerie->actif == 'OUI' ? 'bg-[#0BA20B] text-white border-transparent' : 'bg-slate-900/80 text-white border-transparent' }}">
                {{ $galerie->actif == 'OUI' ? 'Actif' : 'Inactif' }}
              </span>
            </div>
          </div>
          
          <!-- Informations -->
          <div class="p-4 flex flex-col flex-1">
            <h3 class="text-sm font-bold text-slate-900 truncate font-sans group-hover:text-[#0BA20B] transition-colors" title="{{ $galerie->titre }}">
              {{ $galerie->titre }}
            </h3>
            <p class="text-[10px] font-bold text-[#0BA20B] bg-[#0BA20B]/10 px-2 py-0.5 inline-block self-start border border-[#0BA20B]/20 uppercase tracking-widest mt-2 rounded-none">
              {{ $galerie->categorie ? $galerie->categorie->libelle : 'Non catégorisé' }}
            </p>
            
            @if($galerie->description)
              <p class="text-xs text-slate-500 mt-3 line-clamp-2 leading-relaxed" title="{{ $galerie->description }}">
                {{ Str::limit($galerie->description, 35) }}
              </p>
            @else
              <p class="text-xs text-slate-400 mt-3 italic">
                Aucune description
              </p>
            @endif
            
            <!-- Actions -->
            <div class="mt-auto pt-4 border-t border-slate-100 flex items-center justify-between gap-2">
              <a href="{{ route('dashboard.admin.galeries.edit', $galerie) }}" class="text-[10px] font-bold text-slate-500 hover:text-[#0BA20B] uppercase tracking-wider flex items-center gap-1.5 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Modifier
              </a>
              
              <form action="{{ route('dashboard.admin.galeries.destroy', $galerie) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cet élément ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-[10px] font-bold text-red-400 hover:text-red-600 uppercase tracking-wider transition-colors flex items-center gap-1" title="Supprimer">
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                  Supprimer
                </button>
              </form>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @else
    <!-- État Vide -->
    <div class="bg-white border border-slate-200 p-10 text-center space-y-3 max-w-md mx-auto my-8 rounded-none">
      <svg class="w-10 h-10 text-slate-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
      </svg>
      <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider font-sans">Aucun média</h3>
      <p class="text-xs text-slate-500">La galerie est vide. Ajoutez des photos ou des vidéos.</p>
      <div class="pt-2">
        <a href="{{ route('dashboard.admin.galeries.create') }}" class="btn-primary">
          + AJOUTER UN ÉLÉMENT
        </a>
      </div>
    </div>
  @endif

  <!-- MODAL LIGHTBOX POUR IMAGE EN PLEINE TAILLE -->
  <div x-show="activeImage !== null" 
       x-transition:enter="transition ease-out duration-200"
       x-transition:enter-start="opacity-0"
       x-transition:enter-end="opacity-100"
       x-transition:leave="transition ease-in duration-150"
       x-transition:leave-start="opacity-100"
       x-transition:leave-end="opacity-0"
       class="fixed inset-0 z-50 bg-slate-950/90 backdrop-blur-md flex items-center justify-center p-4 sm:p-6"
       x-cloak
       @keydown.escape.window="activeImage = null">
    
    <div class="relative w-full max-w-5xl bg-transparent flex flex-col items-center justify-center h-full"
         @click.away="activeImage = null">
         
       <button @click="activeImage = null" class="absolute top-4 right-4 text-white/50 hover:text-white p-2 transition-colors z-10 bg-black/20 hover:bg-black/50 rounded-none" title="Fermer (Echap)">
         <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
       </button>

       <img :src="activeImage" class="max-h-[85vh] max-w-full object-contain shadow-2xl transition-all duration-300 border border-white/10">
       
       <h3 class="text-lg font-bold text-white uppercase tracking-wider mt-4 font-sans" x-text="showTitle"></h3>
    </div>
  </div>

</div>
@endsection
