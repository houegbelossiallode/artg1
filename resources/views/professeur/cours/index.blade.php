@extends('layouts.dashboard')

@section('title', 'Gestion des Cours | AssoCulture')

@section('content')
<div class="space-y-6" x-data="{ createModalOpen: false, editModalOpen: false, editCours: {} }">
  
  <!-- En-tête -->
  <div class="bg-white border border-slate-200 shadow-sm px-6 py-5 border-l-4 border-l-slate-900 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <h1 class="text-lg font-bold text-slate-900 uppercase tracking-wide">MES COURS</h1>
      <p class="text-slate-400 text-sm mt-0.5">Gérez les cours que vous dispensez à l'association.</p>
    </div>
    <div class="flex flex-wrap items-center gap-2">
      <button @click="createModalOpen = true" type="button" class="inline-flex items-center gap-1.5 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white font-bold text-[10px] uppercase tracking-widest transition shadow-sm cursor-pointer">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
        + COURS
      </button>
    </div>
  </div>

  <!-- Table des Cours -->
  <div class="bg-white border border-slate-200 shadow-sm rounded-none">
    <div class="overflow-x-auto overflow-y-visible min-h-[300px]">
      <table class="w-full text-left text-sm text-slate-600">
        <thead class="border-b border-slate-200 text-[10px] uppercase tracking-widest text-slate-400 font-bold bg-slate-50">
          <tr>
            <th class="p-4">Titre du Cours</th>
            <th class="p-4">Catégorie</th>
            <th class="p-4">Mode</th>
            <th class="p-4">Tarif</th>
            <th class="p-4">Supports</th>
            <!-- <th class="p-4">Statut</th> -->
            <th class="p-4 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          @forelse ($cours as $item)
            <tr class="hover:bg-slate-50 transition-colors">
              <td class="p-4">
                <div class="font-bold text-slate-900">{{ $item->titre }}</div>
                <div class="text-[11px] text-slate-400 truncate max-w-xs">{{ Str::limit($item->description, 40) }}</div>
              </td>
              <td class="p-4">
                <span class="bg-slate-100 text-slate-700 text-[9px] font-bold px-2 py-0.5 uppercase tracking-widest rounded-sm border border-slate-200">
                  {{ $item->categorie ? ($item->categorie->libelle ?? $item->categorie->nom) : '-' }}
                </span>
              </td>
              <td class="p-4">
                <span class="bg-amber-100 text-amber-800 text-[9px] font-bold px-2 py-0.5 uppercase tracking-widest rounded-sm">
                  {{ $item->mode ? ($item->mode->libelle ?? $item->mode->nom) : '-' }}
                </span>
              </td>
              <td class="p-4 font-bold text-slate-900 font-mono text-xs">
                {{ number_format($item->tarif, 0, ',', ' ') }} FCFA
              </td>
              <td class="p-4">
                @if($item->supports_count > 0)
                  <a href="{{ route('dashboard.professeur.cours.download-support', $item->id) }}" class="flex items-center gap-1.5 text-indigo-600 hover:text-indigo-800 transition-colors" title="Télécharger le support">
                    <div class="w-5 h-5 bg-indigo-50 flex items-center justify-center">
                      <svg class="w-3 h-3 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    </div>
                    <span class="text-xs font-bold">{{ $item->supports_count }}</span>
                  </a>
                @else
                  <div class="flex items-center gap-1.5">
                    <div class="w-5 h-5 bg-slate-100 flex items-center justify-center">
                      <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <span class="text-xs font-bold text-slate-400">0</span>
                  </div>
                @endif
              </td>
              <!-- <td class="p-4">
                @if($item->actif === 'OUI')
                  <span class="bg-emerald-100 text-emerald-700 text-[9px] font-bold px-2 py-0.5 uppercase tracking-widest border border-emerald-200">Actif</span>
                @else
                  <span class="bg-red-100 text-red-600 text-[9px] font-bold px-2 py-0.5 uppercase tracking-widest border border-red-200">Inactif</span>
                @endif
              </td> -->
              <td class="p-4 text-right">
                <!-- DROPDOWN CARRÉ D'ACTIONS -->
                <div class="relative inline-block text-left" x-data="{ open: false }" @click.away="open = false">
                  <button @click="open = !open" type="button" class="w-7 h-7 bg-slate-100 hover:bg-slate-900 hover:text-white text-slate-700 inline-flex items-center justify-center rounded-none border border-slate-300 transition-colors focus:outline-none cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
                  </button>

                  <div x-show="open" 
                       x-transition:enter="transition ease-out duration-100" 
                       x-transition:enter-start="transform opacity-0 scale-95" 
                       x-transition:enter-end="transform opacity-100 scale-100" 
                       x-transition:leave="transition ease-in duration-75" 
                       x-transition:leave-start="transform opacity-100 scale-100" 
                       x-transition:leave-end="transform opacity-0 scale-95" 
                       class="origin-top-right absolute right-0 mt-1 w-40 rounded-none bg-white shadow-xl border border-slate-200 z-50 divide-y divide-slate-100" 
                       x-cloak>
                    <div class="py-1">
                      <button type="button" @click="editCours = { id: {{ $item->id }}, titre: '{{ addslashes($item->titre) }}', categorie_cours_id: {{ $item->categorie_cours_id }}, mode_id: {{ $item->mode_id }}, tarif: {{ $item->tarif }}, description: '{{ addslashes($item->description ?? '') }}' }; editModalOpen = true; open = false;" class="w-full text-left group flex items-center px-4 py-2 text-xs text-slate-700 hover:bg-slate-900 hover:text-white font-bold uppercase tracking-wider">
                        <svg class="mr-2 h-4 w-4 text-slate-400 group-hover:text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Modifier
                      </button>
                    </div>
                    <div class="py-1">
                      <form action="{{ route('dashboard.professeur.cours.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer ce cours ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full text-left group flex items-center px-4 py-2 text-xs text-red-600 hover:bg-red-600 hover:text-white font-bold uppercase tracking-wider">
                          <svg class="mr-2 h-4 w-4 text-red-500 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                          Supprimer
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="p-8 text-center text-xs text-slate-400">Aucun cours enregistré.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- MODALE CRÉATION -->
  <div x-show="createModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-cloak>
    <div @click.away="createModalOpen = false" class="bg-white max-w-xl w-full rounded-none shadow-2xl border border-slate-200 overflow-hidden max-h-[90vh] flex flex-col">
      <div class="bg-white px-6 py-4 flex items-center justify-between border-b-2 border-brand-lime shrink-0">
        <h3 class="text-sm font-serif-heading font-bold text-white uppercase tracking-wider flex items-center gap-2">
          <span class="w-2 h-2 bg-amber-500 inline-block"></span>
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

        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Tarif (FCFA) *</label>
          <input type="number" name="tarif" required placeholder="15000" class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none">
        </div>

        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Description</label>
          <textarea name="description" rows="3" placeholder="Description synthétique du cours..." class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none"></textarea>
        </div>

        <div class="border-t border-slate-200 pt-4">
          <h4 class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-3 flex items-center gap-2">
            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
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
          <button type="submit" class="px-5 py-2 text-xs uppercase font-bold tracking-wider bg-slate-900 hover:bg-slate-800 text-amber-500 transition-colors rounded-none">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>

  <!-- MODALE ÉDITION -->
  <div x-show="editModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-cloak>
    <div @click.away="editModalOpen = false" class="bg-white max-w-xl w-full rounded-none shadow-2xl border border-slate-200 overflow-hidden max-h-[90vh] flex flex-col">
      <div class="bg-white px-6 py-4 flex items-center justify-between border-b-2 border-brand-lime shrink-0">
        <h3 class="text-sm font-serif-heading font-bold text-white uppercase tracking-wider flex items-center gap-2">
          <span class="w-2 h-2 bg-amber-500 inline-block"></span>
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

        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Tarif (FCFA) *</label>
          <input type="number" name="tarif" x-model="editCours.tarif" required class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none">
        </div>

        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Description</label>
          <textarea name="description" x-model="editCours.description" rows="3" class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none"></textarea>
        </div>

        <div class="border-t border-slate-200 pt-4">
          <h4 class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-3 flex items-center gap-2">
            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
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
          <button type="submit" class="px-5 py-2 text-xs uppercase font-bold tracking-wider bg-slate-900 hover:bg-slate-800 text-amber-500 transition-colors rounded-none">Mettre à Jour</button>
        </div>
      </form>
    </div>
  </div>

</div>
@endsection
