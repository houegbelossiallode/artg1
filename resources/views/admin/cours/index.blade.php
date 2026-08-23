@extends('layouts.dashboard')

@section('title', 'Gestion des Cours | AssoCulture')

@section('content')
<div class="space-y-6" x-data="{ createModalOpen: false, editModalOpen: false, editCours: {} }">
  
  <!-- En-tête -->
  <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 pb-4 border-b border-slate-200">
    <div>
      <h1 class="admin-title">Catalogue des Cours</h1>
      <p class="admin-subtitle">Gérez le programme des formations, horaires et professeurs assignés.</p>
    </div>
    <div class="flex flex-wrap items-center gap-2">
      <button @click="createModalOpen = true" type="button" class="btn-primary">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
        COURS
      </button>
    </div>
  </div>

  <!-- Grille des Cours -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse ($cours as $item)
      @php
        $catNom = $item->categorie ? ($item->categorie->libelle ?? $item->categorie->nom) : 'Général';
        $catLower = strtolower($catNom);
        $modeName = $item->mode ? ($item->mode->libelle ?? $item->mode->nom) : 'Présentiel';
        $profName = $item->professeur ? $item->professeur->name : '-';

        if (isset($item->image_path) && $item->image_path) {
          $imgUrl = asset('storage/' . $item->image_path);
        } elseif (\Illuminate\Support\Str::contains($catLower, ['raphia', 'artisanat', 'tissage', 'sculpture'])) {
          $imgUrl = '/assets/raphia_artisanal_crafts_1785764982514-DDF_8lz7.jpg';
        } elseif (\Illuminate\Support\Str::contains($catLower, ['moderne', 'guitare', 'piano', 'synthé'])) {
          $imgUrl = 'https://images.unsplash.com/photo-1510915361894-db8b60106cb1?auto=format&fit=crop&q=80&w=800';
        } elseif (\Illuminate\Support\Str::contains($catLower, ['tradition', 'instruments', 'balafon', 'kora', 'djembé', 'percussion'])) {
          $imgUrl = 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&q=80&w=800';
        } else {
          $catIdImages = [
            1 => 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&q=80&w=800',
            2 => 'https://images.unsplash.com/photo-1510915361894-db8b60106cb1?auto=format&fit=crop&q=80&w=800',
            3 => '/assets/raphia_artisanal_crafts_1785764982514-DDF_8lz7.jpg',
          ];
          $imgUrl = $catIdImages[$item->categorie_cours_id ?? 0] ?? 'https://images.unsplash.com/photo-1519892300165-cb5542fb47c7?auto=format&fit=crop&q=80&w=800';
        }
      @endphp
      <div class="bg-white border border-slate-200 shadow-sm flex flex-col group hover:border-[#0BA20B] transition-colors rounded-none relative">
        
        <!-- En-tête Image -->
        <div class="relative h-40 overflow-hidden bg-slate-100">
          <img src="{{ $imgUrl }}" alt="{{ $item->titre }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
          <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>
          
          <!-- Badges -->
          <div class="absolute top-3 left-3 right-12 flex flex-wrap gap-1">
            <span class="px-2 py-0.5 bg-[#1E1613]/90 text-[#0BA20B] text-[9px] font-bold uppercase tracking-widest border border-[#0BA20B]/30">
              {{ $catNom }}
            </span>
            <span class="px-2 py-0.5 bg-[#0BA20B] text-white text-[9px] font-bold uppercase tracking-widest shadow-sm">
              {{ $modeName }}
            </span>
          </div>

          <!-- Menu Kebab Admin -->
          <div class="absolute top-3 right-3" x-data="{ open: false }" @click.away="open = false">
            <button @click="open = !open" type="button" class="w-7 h-7 flex items-center justify-center text-white hover:text-[#0BA20B] bg-[#1E1613]/50 hover:bg-white backdrop-blur-sm transition-colors rounded-none focus:outline-none">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
            </button>
            
            <div x-show="open" 
                 x-transition:enter="transition ease-out duration-100" 
                 x-transition:enter-start="transform opacity-0 scale-95" 
                 x-transition:enter-end="transform opacity-100 scale-100" 
                 x-transition:leave="transition ease-in duration-75" 
                 x-transition:leave-start="transform opacity-100 scale-100" 
                 x-transition:leave-end="transform opacity-0 scale-95" 
                 class="absolute right-0 mt-1 w-40 bg-white shadow-xl border border-slate-200 z-50 rounded-none" 
                 x-cloak>
              <div class="py-1">
                <button type="button" @click="editCours = { id: {{ $item->id }}, titre: '{{ addslashes($item->titre) }}', categorie_cours_id: {{ $item->categorie_cours_id }}, user_id: {{ $item->user_id }}, mode_id: {{ $item->mode_id }}, tarif: {{ $item->tarif }}, lieu: '{{ addslashes($item->lieu ?? '') }}', description: '{{ addslashes($item->description ?? '') }}' }; editModalOpen = true; open = false;" class="w-full text-left px-4 py-2 text-xs font-bold uppercase tracking-wider text-slate-700 hover:bg-[#0BA20B] hover:text-white transition-colors">
                  Modifier
                </button>
                <form action="{{ route('dashboard.admin.cours.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer ce cours ?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="w-full text-left px-4 py-2 text-xs font-bold uppercase tracking-wider text-red-600 hover:bg-red-600 hover:text-white transition-colors">
                    Supprimer
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>

        <!-- Informations du Cours -->
        <div class="p-4 flex-1 flex flex-col justify-between space-y-3">
          <div>
            <h4 class="text-sm font-sans font-bold text-slate-900 uppercase tracking-wider group-hover:text-[#0BA20B] transition-colors">
              {{ $item->titre }}
            </h4>
            <p class="text-[11px] text-slate-500 mt-1 line-clamp-2">
              {{ $item->description ?: 'Aucune description disponible.' }}
            </p>
            <div class="mt-2 space-y-1">
              <div class="flex items-center gap-1.5 text-[11px] font-semibold text-slate-700">
                <i class="fa-solid fa-user-tie text-[#0BA20B]"></i>
                <span>Prof. {{ $profName }}</span>
              </div>
              @if($item->lieu)
                <div class="flex items-center gap-1.5 text-[11px] font-medium text-slate-600">
                  <i class="fa-solid fa-location-dot text-red-500"></i>
                  <span>{{ $item->lieu }}</span>
                </div>
              @endif
            </div>
          </div>
          <div class="pt-2.5 border-t border-slate-100 flex items-center justify-between">
            <div>
              <span class="text-[9px] text-slate-400 uppercase font-bold tracking-wider block">Tarif</span>
              <span class="text-sm font-bold text-slate-900">
                {{ number_format($item->tarif, 0, ',', ' ') }} FCFA <span class="text-[10px] text-slate-500 font-normal">/ pers</span>
              </span>
            </div>
          </div>
        </div>
      </div>
    @empty
      <div class="col-span-full p-12 bg-white border border-slate-200 text-center">
        <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
        <h3 class="mt-2 text-sm font-bold text-slate-900 uppercase tracking-wider">Aucun cours</h3>
        <p class="mt-1 text-xs text-slate-500">Commencez par ajouter un nouveau cours au catalogue.</p>
      </div>
    @endforelse
  </div>

  <!-- MODALE CRÉATION -->
  <div x-show="createModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-cloak>
    <div @click.away="createModalOpen = false" class="bg-white max-w-xl w-full rounded-none shadow-2xl border border-slate-200 overflow-hidden max-h-[90vh] flex flex-col">
      <div class="bg-white px-6 py-4 flex items-center justify-between border-b-2 border-[#0BA20B] shrink-0">
        <h3 class="text-sm font-sans font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
          <span class="w-2 h-2 bg-[#0BA20B] inline-block"></span>
          Nouveau Cours
        </h3>
        <button type="button" @click="createModalOpen = false" class="text-slate-400 hover:text-white text-lg font-bold">&times;</button>
      </div>
      
      <form action="{{ route('dashboard.admin.cours.store') }}" method="POST" class="p-6 space-y-4 overflow-y-auto">
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
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Professeur *</label>
            <select name="user_id" required class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none bg-white">
              <option value="">-- Choisir --</option>
              @foreach($professeurs as $prof)
                <option value="{{ $prof->id }}">{{ $prof->name }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Mode d'Enseignement *</label>
            <select name="mode_id" required class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none bg-white">
              <option value="">-- Choisir --</option>
              @foreach($modes as $m)
                <option value="{{ $m->id }}">{{ $m->libelle ?? $m->nom }}</option>
              @endforeach
            </select>
          </div>
          <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Tarif (FCFA) *</label>
            <input type="number" name="tarif" required placeholder="15000" class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none">
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Lieu / Adresse physique (Présentiel / Hybride)</label>
          <input type="text" name="lieu" placeholder="ex: Salle Culturelle A, Cotonou" class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none">
        </div>

        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Description</label>
          <textarea name="description" rows="3" placeholder="Description synthétique du cours..." class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none"></textarea>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
          <button type="button" @click="createModalOpen = false" class="px-4 py-2 text-xs uppercase font-bold tracking-wider text-slate-600 hover:bg-slate-100 transition-colors rounded-none">Annuler</button>
          <button type="submit" class="btn-primary">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>

  <!-- MODALE ÉDITION -->
  <div x-show="editModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-cloak>
    <div @click.away="editModalOpen = false" class="bg-white max-w-xl w-full rounded-none shadow-2xl border border-slate-200 overflow-hidden max-h-[90vh] flex flex-col">
      <div class="bg-white px-6 py-4 flex items-center justify-between border-b-2 border-[#0BA20B] shrink-0">
        <h3 class="text-sm font-sans font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
          <span class="w-2 h-2 bg-[#0BA20B] inline-block"></span>
          Modifier le Cours
        </h3>
        <button type="button" @click="editModalOpen = false" class="text-slate-400 hover:text-white text-lg font-bold">&times;</button>
      </div>
      
      <form :action="route('dashboard.admin.cours.update', editCours.id)" method="POST" class="p-6 space-y-4 overflow-y-auto">
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
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Professeur *</label>
            <select name="user_id" x-model="editCours.user_id" required class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none bg-white">
              @foreach($professeurs as $prof)
                <option value="{{ $prof->id }}">{{ $prof->name }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Mode d'Enseignement *</label>
            <select name="mode_id" x-model="editCours.mode_id" required class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none bg-white">
              @foreach($modes as $m)
                <option value="{{ $m->id }}">{{ $m->libelle ?? $m->nom }}</option>
              @endforeach
            </select>
          </div>
          <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Tarif (FCFA) *</label>
            <input type="number" name="tarif" x-model="editCours.tarif" required class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none">
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Lieu / Adresse physique (Présentiel / Hybride)</label>
          <input type="text" name="lieu" x-model="editCours.lieu" placeholder="ex: Salle Culturelle A, Cotonou" class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none">
        </div>


        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Description</label>
          <textarea name="description" x-model="editCours.description" rows="3" class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none"></textarea>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
          <button type="button" @click="editModalOpen = false" class="px-4 py-2 text-xs uppercase font-bold tracking-wider text-slate-600 hover:bg-slate-100 transition-colors rounded-none">Annuler</button>
          <button type="submit" class="btn-primary">Mettre à Jour</button>
        </div>
      </form>
    </div>
  </div>

</div>
@endsection
