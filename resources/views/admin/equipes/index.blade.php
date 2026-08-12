@extends('layouts.dashboard')

@section('title', 'Gestion des Équipes | AssoCulture')

@section('content')
<div class="space-y-6" x-data="{ showModal: false, editModalOpen: false, editMembre: {}, updateUrl: '' }">

  <!-- Flash Messages -->
  @if (session('success'))
    <div class="p-4 bg-emerald-50 border-l-4 border-emerald-600 text-emerald-800 text-xs shadow-sm flex items-center justify-between">
      <span>{{ session('success') }}</span>
      <button @click="$el.parentElement.remove()" class="text-emerald-600 font-bold ml-4">&times;</button>
    </div>
  @endif

  <!-- En-tête -->
  <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 pb-4 border-b border-slate-200">
    <div>
      <h1 class="admin-title">Équipe Dirigeante</h1>
      <p class="admin-subtitle">Gérez les membres du bureau et de l'équipe de direction de l'association.</p>
    </div>
    <div class="flex flex-wrap items-center gap-2">
      <button @click="showModal = true" type="button" class="btn-primary">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
        MEMBRE
      </button>
    </div>
  </div>

  <!-- Table de l'Équipe -->
  <div class="bg-white border border-slate-200 shadow-sm rounded-none">
    <div class="overflow-x-auto overflow-y-visible min-h-[300px]">
      <table class="w-full text-left text-sm text-slate-600">
        <thead class="border-b border-slate-200 text-[10px] uppercase tracking-widest text-slate-400 font-bold bg-slate-50">
          <tr>
            <th class="p-4">Membre</th>
            <th class="p-4">Fonction</th>
            <th class="p-4">Statut</th>
            <th class="p-4 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          @forelse ($equipes as $membre)
            <tr class="hover:bg-slate-50 transition-colors">
              <td class="p-4">
                <div class="flex items-center gap-3">
                  @if($membre->photo)
                    <div class="w-12 h-12 bg-slate-100 overflow-hidden border border-slate-200 shrink-0">
                      <img src="{{ asset('storage/' . $membre->photo) }}" class="w-full h-full object-cover">
                    </div>
                  @endif
                  <div>
                    <div class="font-sans font-bold text-slate-900 text-sm">{{ $membre->prenom }} {{ $membre->nom }}</div>
                    @if($membre->biographie)
                      <div class="text-[11px] text-slate-400 truncate max-w-xs">{{ Str::limit($membre->biographie, 50) }}</div>
                    @endif
                  </div>
                </div>
              </td>
              <td class="p-4 text-xs font-semibold text-slate-700">
                {{ $membre->fonction ?? 'Membre' }}
              </td>
              <td class="p-4">
                <span class="bg-emerald-100 text-emerald-700 text-[9px] font-bold px-2 py-0.5 uppercase tracking-widest rounded-none">
                  {{ strtoupper($membre->actif) }}
                </span>
              </td>
              <td class="p-4 text-right pr-6">
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
                       class="origin-top-right absolute right-0 mt-2 w-40 rounded-none bg-white shadow-xl border border-slate-200 z-50 divide-y divide-slate-100" 
                       x-cloak>
                    <div class="py-1">
                      <button type="button" @click="editMembre = { id: {{ $membre->id }}, nom: '{{ addslashes($membre->nom) }}', prenom: '{{ addslashes($membre->prenom) }}', fonction: '{{ addslashes($membre->fonction ?? '') }}', biographie: '{{ addslashes($membre->biographie ?? '') }}', actif: '{{ $membre->actif }}' }; updateUrl = '/dashboard/admin/equipes/' + {{ $membre->id }}; editModalOpen = true; open = false;" class="w-full text-left group flex items-center px-4 py-2 text-xs text-slate-700 hover:bg-slate-900 hover:text-white font-bold uppercase tracking-wider">
                        <svg class="mr-2 h-4 w-4 text-slate-400 group-hover:text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Modifier
                      </button>
                    </div>
                    <div class="py-1">
                      <form action="{{ route('dashboard.admin.equipes.destroy', $membre->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer ce membre ?');">
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
              <td colspan="4" class="p-8 text-center text-xs text-slate-400">Aucun membre ajouté pour le moment.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- MODALE Nouveau Membre -->
  <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-cloak>
    <div @click.away="showModal = false" class="bg-white max-w-lg w-full rounded-none shadow-2xl border border-slate-200 overflow-hidden max-h-[90vh] flex flex-col">
      <div class="bg-slate-900 px-6 py-4 flex items-center justify-between border-b-2 border-[#0BA20B] shrink-0">
        <h3 class="text-sm font-sans font-bold text-white uppercase tracking-wider flex items-center gap-2 font-sans">
          <span class="w-2 h-2 bg-amber-500 inline-block"></span>
          Ajouter un Membre de l'Équipe
        </h3>
        <button type="button" @click="showModal = false" class="text-slate-400 hover:text-white text-lg font-bold">&times;</button>
      </div>

      <form action="{{ route('dashboard.admin.equipes.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4 overflow-y-auto">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Nom</label>
            <input type="text" name="nom" required class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none">
          </div>
            <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Prénom</label>
            <input type="text" name="prenom" required class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none">
          </div>
        </div>

          <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Fonction / Rôle dans l'association</label>
          <input type="text" name="fonction" required class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none" placeholder="Président, Trésorier, Directeur Artistique...">
        </div>

          <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Biographie / Parcours</label>
          <textarea name="biographie" rows="3" class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none" placeholder="Brève présentation..."></textarea>
        </div>

          <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Photo (optionnelle)</label>
          <input type="file" name="photo" accept="image/*" class="w-full px-3 py-1.5 text-xs border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none bg-slate-50">
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
          <button type="button" @click="showModal = false" class="px-4 py-2 text-xs uppercase font-bold tracking-wider text-slate-600 hover:bg-slate-100 transition-colors rounded-none">Annuler</button>
          <button type="submit" class="btn-primary">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>

  <!-- MODALE ÉDITION -->
  <div x-show="editModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-cloak>
    <div @click.away="editModalOpen = false" class="bg-white max-w-lg w-full rounded-none shadow-2xl border border-slate-200 overflow-hidden max-h-[90vh] flex flex-col">
      <div class="bg-slate-900 px-6 py-4 flex items-center justify-between border-b-2 border-[#0BA20B] shrink-0">
        <h3 class="text-sm font-sans font-bold text-white uppercase tracking-wider flex items-center gap-2 font-sans">
          <span class="w-2 h-2 bg-amber-500 inline-block"></span>
          Modifier le Membre de l'Équipe
        </h3>
        <button type="button" @click="editModalOpen = false" class="text-slate-400 hover:text-white text-lg font-bold">&times;</button>
      </div>

      <form :action="updateUrl" method="POST" enctype="multipart/form-data" class="p-6 space-y-4 overflow-y-auto">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Nom</label>
            <input type="text" name="nom" x-model="editMembre.nom" required class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none">
          </div>
            <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Prénom</label>
            <input type="text" name="prenom" x-model="editMembre.prenom" required class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none">
          </div>
        </div>

          <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Fonction / Rôle dans l'association</label>
          <input type="text" name="fonction" x-model="editMembre.fonction" required class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none" placeholder="Président, Trésorier, Directeur Artistique...">
        </div>

          <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Biographie / Parcours</label>
          <textarea name="biographie" x-model="editMembre.biographie" rows="3" class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none" placeholder="Brève présentation..."></textarea>
        </div>

          <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Photo (optionnelle)</label>
          <input type="file" name="photo" accept="image/*" class="w-full px-3 py-1.5 text-xs border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none bg-slate-50">
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
