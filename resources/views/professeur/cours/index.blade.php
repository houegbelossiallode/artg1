@extends('layouts.dashboard')

@section('title', 'Gestion des Cours | AssoCulture')

@section('content')
<div class="space-y-6" x-data="{ createModalOpen: false, editModalOpen: false, editCours: {} }">
  
  <!-- En-tête -->
  <x-dashboard.page-header title="Mes Cours" description="Gérez les cours que vous dispensez à l'association.">
    <button @click="createModalOpen = true" type="button" class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#0BA20B] hover:bg-[#087A08] text-white font-bold text-[10px] uppercase tracking-widest transition shadow-sm cursor-pointer">
      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
      + COURS
    </button>
  </x-dashboard.page-header>

  <!-- Grille des Cours -->
  <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
    @forelse ($cours as $item)
      <div class="bg-white border border-slate-200 shadow-sm flex flex-col relative group transition-all duration-300 hover:shadow-md hover:border-[#0BA20B]/30">
        <!-- Conteneur décoratif -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none z-0">
          <!-- Décoration Bento -->
          <div class="absolute -right-16 -top-16 w-32 h-32 bg-slate-50 rotate-12 group-hover:bg-[#0BA20B]/5 transition-colors duration-500"></div>
          <div class="absolute top-0 left-0 w-1 h-full bg-slate-200 group-hover:bg-[#0BA20B] transition-colors duration-300"></div>
        </div>
        
        <!-- En-tête de la carte -->
        <div class="p-6 border-b border-slate-100 flex justify-between items-start z-20 bg-slate-50/50 h-[160px]">
          <div class="pr-4">
             <div class="flex flex-wrap items-center gap-2 mb-3">
               <span class="bg-slate-100 text-slate-600 text-[9px] font-bold px-2 py-1 uppercase tracking-widest border border-slate-200">
                  {{ $item->categorie ? ($item->categorie->libelle ?? $item->categorie->nom) : 'Général' }}
               </span>
               <span class="bg-[#0BA20B]/10 text-[#0BA20B] text-[9px] font-bold px-2 py-1 uppercase tracking-widest border border-[#0BA20B]/20">
                  {{ $item->mode ? ($item->mode->libelle ?? $item->mode->nom) : 'Présentiel' }}
               </span>
             </div>
             <h3 class="font-bold text-slate-900 text-base leading-tight font-sans tracking-tight group-hover:text-[#0BA20B] transition-colors line-clamp-2" title="{{ $item->titre }}">{{ $item->titre }}</h3>
          </div>
          
          <!-- DROPDOWN D'ACTIONS -->
          <div class="relative inline-block text-left shrink-0" x-data="{ open: false }" @click.away="open = false">
            <button @click="open = !open" type="button" class="w-8 h-8 bg-white hover:bg-slate-900 hover:text-white text-slate-400 inline-flex items-center justify-center rounded-none border border-slate-200 shadow-sm transition-colors focus:outline-none cursor-pointer">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
            </button>

            <div x-show="open" 
                 x-transition:enter="transition ease-out duration-100" 
                 x-transition:enter-start="transform opacity-0 scale-95" 
                 x-transition:enter-end="transform opacity-100 scale-100" 
                 x-transition:leave="transition ease-in duration-75" 
                 x-transition:leave-start="transform opacity-100 scale-100" 
                 x-transition:leave-end="transform opacity-0 scale-95" 
                 class="origin-top-right absolute right-0 mt-2 w-48 rounded-none bg-white shadow-xl border border-slate-200 z-50 divide-y divide-slate-100" 
                 x-cloak>
              <div class="py-1">
                <button type="button" @click="editCours = { id: {{ $item->id }}, titre: '{{ addslashes($item->titre) }}', categorie_cours_id: {{ $item->categorie_cours_id }}, mode_id: {{ $item->mode_id }}, tarif: {{ $item->tarif }}, lieu: '{{ addslashes($item->lieu ?? '') }}', description: '{{ addslashes($item->description ?? '') }}' }; editModalOpen = true; open = false;" class="w-full text-left group flex items-center px-4 py-2.5 text-xs text-slate-700 hover:bg-[#0BA20B] hover:text-white font-bold uppercase tracking-wider transition-colors">
                  <svg class="mr-3 h-4 w-4 text-slate-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                  Modifier
                </button>
              </div>
              <div class="py-1">
                <form action="{{ route('dashboard.professeur.cours.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer ce cours ?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="w-full text-left group flex items-center px-4 py-2.5 text-xs text-red-600 hover:bg-red-600 hover:text-white font-bold uppercase tracking-wider transition-colors">
                    <svg class="mr-3 h-4 w-4 text-red-500 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Supprimer
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>

        <!-- Corps de la carte -->
        <div class="p-6 flex flex-col flex-1 z-10 bg-white">
          <p class="text-xs text-slate-500 leading-relaxed mb-4 flex-1 break-words">
            {{ $item->description ? Str::limit($item->description, 115) : 'Aucune description disponible pour ce cours.' }}
          </p>

          @if($item->lieu)
            <div class="flex items-center gap-1.5 text-xs font-medium text-slate-700 mb-4 bg-slate-50 p-2 border border-slate-100">
              <i class="fa-solid fa-location-dot text-red-500"></i>
              <span class="truncate">{{ $item->lieu }}</span>
            </div>
          @endif
          
          <div class="flex items-center justify-between pt-4 border-t border-slate-100 mt-auto">
            <!-- Tarif -->
            <div>
              <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Tarif</p>
              <div class="flex items-baseline gap-1">
                <span class="font-mono text-lg font-bold text-slate-900 tracking-tight">{{ number_format($item->tarif, 0, ',', ' ') }}</span>
                <span class="text-[10px] font-bold text-slate-500 uppercase">FCFA</span>
              </div>
            </div>
            
            <!-- Supports -->
            <div class="text-right">
               <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1 text-right">Supports</p>
               @if($item->supports_count > 0)
                 <a href="{{ route('dashboard.professeur.cours.download-support', $item->id) }}" class="inline-flex items-center gap-2 group/support" title="Télécharger le support">
                   <div class="w-7 h-7 bg-[#0BA20B]/10 flex items-center justify-center group-hover/support:bg-[#0BA20B] transition-colors duration-300">
                     <svg class="w-3.5 h-3.5 text-[#0BA20B] group-hover/support:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                   </div>
                   <span class="font-bold text-xs text-slate-700 group-hover/support:text-[#0BA20B] transition-colors">{{ $item->supports_count }} <span class="text-[10px] font-normal uppercase text-slate-400">fichier(s)</span></span>
                 </a>
               @else
                 <div class="inline-flex items-center gap-2 opacity-50 cursor-not-allowed">
                   <div class="w-7 h-7 bg-slate-100 flex items-center justify-center">
                     <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                   </div>
                   <span class="font-bold text-xs text-slate-400">Aucun support</span>
                 </div>
               @endif
            </div>
          </div>
        </div>
      </div>
    @empty
      <div class="col-span-full py-16 bg-white border border-slate-200 text-center flex flex-col items-center justify-center shadow-sm">
        <div class="w-20 h-20 bg-slate-50 flex items-center justify-center mb-4 rounded-none border border-slate-100">
          <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
        </div>
        <h3 class="text-sm font-bold text-slate-900 uppercase tracking-widest mb-1">Aucun cours enregistré</h3>
        <p class="text-xs text-slate-500 mb-6">Vous n'avez pas encore créé de cours. Cliquez sur le bouton pour commencer.</p>
        <button @click="createModalOpen = true" type="button" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#0BA20B] hover:bg-[#087A08] text-white font-bold text-[10px] uppercase tracking-widest transition shadow-sm cursor-pointer">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
          Créer mon premier cours
        </button>
      </div>
    @endforelse
  </div>

  <!-- Pagination -->
  @if($cours->hasPages())
    <div class="mt-8 border-t border-slate-200 pt-6">
      {{ $cours->links() }}
    </div>
  @endif

  <!-- MODALE CRÉATION -->
  <div x-show="createModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-cloak>
    <div @click.away="createModalOpen = false" class="bg-white max-w-xl w-full rounded-none shadow-2xl border border-slate-200 overflow-hidden max-h-[90vh] flex flex-col">
      <div class="bg-white px-6 py-4 flex items-center justify-between border-b-2 border-brand-lime shrink-0">
        <h3 class="text-sm font-serif-heading font-bold text-white uppercase tracking-wider flex items-center gap-2">
          <span class="w-2 h-2 bg-[#0BA20B] inline-block"></span>
          Nouveau Cours
        </h3>
        <button type="button" @click="createModalOpen = false" class="text-slate-400 hover:text-white text-lg font-bold">&times;</button>
      </div>
      
      <form action="{{ route('dashboard.professeur.cours.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4 overflow-y-auto">
        @csrf
        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Titre du Cours *</label>
          <input type="text" name="titre" required placeholder="ex: Atelier de Solfège & Piano" class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Catégorie *</label>
            <select name="categorie_cours_id" required class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none bg-white">
              <option value="">-- Choisir --</option>
              @foreach($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->libelle ?? $cat->nom }}</option>
              @endforeach
            </select>
          </div>
          <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Mode d'Enseignement *</label>
            <select name="mode_id" required class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none bg-white">
              <option value="">-- Choisir --</option>
              @foreach($modes as $m)
                <option value="{{ $m->id }}">{{ $m->libelle ?? $m->nom }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Tarif (FCFA) *</label>
            <input type="number" name="tarif" required placeholder="15000" class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none">
          </div>
          <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Lieu / Adresse (Présentiel / Hybride)</label>
            <input type="text" name="lieu" placeholder="ex: Salle B, Centre Culturel" class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none">
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Description</label>
          <textarea name="description" rows="3" placeholder="Description synthétique du cours..." class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none"></textarea>
        </div>

        <div class="border-t border-slate-200 pt-4">
          <h4 class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-3 flex items-center gap-2">
            <svg class="w-4 h-4 text-[#0BA20B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Support de cours (optionnel)
          </h4>
          <div>
            <label class="block text-xs font-medium text-slate-600 mb-1">Fichier (PDF, Word, Vidéo, Image...)</label>
            <input type="file" name="support_fichier" accept=".pdf,.doc,.docx,.ppt,.pptx,.mp4,.avi,.mov,.jpg,.jpeg,.png,.gif" class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none">
            <p class="text-[10px] text-slate-400 mt-1">Formats acceptés : PDF, Word, PowerPoint, Vidéo, Image</p>
          </div>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
          <button type="button" @click="createModalOpen = false" class="px-4 py-2 text-xs uppercase font-bold tracking-wider text-slate-600 hover:bg-slate-100 transition-colors rounded-none">Annuler</button>
          <button type="submit" class="px-5 py-2 text-xs uppercase font-bold tracking-wider bg-slate-900 hover:bg-[#0BA20B] text-white transition-colors rounded-none">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>

  <!-- MODALE ÉDITION -->
  <div x-show="editModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-cloak>
    <div @click.away="editModalOpen = false" class="bg-white max-w-xl w-full rounded-none shadow-2xl border border-slate-200 overflow-hidden max-h-[90vh] flex flex-col">
      <div class="bg-white px-6 py-4 flex items-center justify-between border-b-2 border-brand-lime shrink-0">
        <h3 class="text-sm font-serif-heading font-bold text-white uppercase tracking-wider flex items-center gap-2">
          <span class="w-2 h-2 bg-[#0BA20B] inline-block"></span>
          Modifier le Cours
        </h3>
        <button type="button" @click="editModalOpen = false" class="text-slate-400 hover:text-white text-lg font-bold">&times;</button>
      </div>
      
      <form :action="'/dashboard/professeur/cours/' + editCours.id" method="POST" enctype="multipart/form-data" class="p-6 space-y-4 overflow-y-auto">
        @csrf
        @method('PUT')
        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Titre du Cours *</label>
          <input type="text" name="titre" x-model="editCours.titre" required class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Catégorie *</label>
            <select name="categorie_cours_id" x-model="editCours.categorie_cours_id" required class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none bg-white">
              @foreach($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->libelle ?? $cat->nom }}</option>
              @endforeach
            </select>
          </div>
          <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Mode d'Enseignement *</label>
            <select name="mode_id" x-model="editCours.mode_id" required class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none bg-white">
              @foreach($modes as $m)
                <option value="{{ $m->id }}">{{ $m->libelle ?? $m->nom }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Tarif (FCFA) *</label>
            <input type="number" name="tarif" x-model="editCours.tarif" required class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none">
          </div>
          <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Lieu / Adresse (Présentiel / Hybride)</label>
            <input type="text" name="lieu" x-model="editCours.lieu" placeholder="ex: Salle B, Centre Culturel" class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none">
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Description</label>
          <textarea name="description" x-model="editCours.description" rows="3" class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none"></textarea>
        </div>

        <div class="border-t border-slate-200 pt-4">
          <h4 class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-3 flex items-center gap-2">
            <svg class="w-4 h-4 text-[#0BA20B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Support de cours (optionnel)
          </h4>
          <div>
            <label class="block text-xs font-medium text-slate-600 mb-1">Fichier (PDF, Word, Vidéo, Image...)</label>
            <input type="file" name="support_fichier" accept=".pdf,.doc,.docx,.ppt,.pptx,.mp4,.avi,.mov,.jpg,.jpeg,.png,.gif" class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none">
            <p class="text-[10px] text-slate-400 mt-1">Formats acceptés : PDF, Word, PowerPoint, Vidéo, Image</p>
          </div>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
          <button type="button" @click="editModalOpen = false" class="px-4 py-2 text-xs uppercase font-bold tracking-wider text-slate-600 hover:bg-slate-100 transition-colors rounded-none">Annuler</button>
          <button type="submit" class="px-5 py-2 text-xs uppercase font-bold tracking-wider bg-slate-900 hover:bg-[#0BA20B] text-white transition-colors rounded-none">Mettre à Jour</button>
        </div>
      </form>
    </div>
  </div>

</div>
@endsection
