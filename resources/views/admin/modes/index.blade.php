@extends('layouts.dashboard')

@section('title', 'Gestion des Modes de Cours | AssoCulture')

@section('content')
<div class="space-y-6" x-data="{ createModalOpen: false, editModalOpen: false, editMode: {}, updateUrl: '' }">
  
  <!-- En-tête -->
  <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 pb-4 border-b border-slate-200">
    <div>
      <h1 class="admin-title">Modes de Cours</h1>
      <p class="admin-subtitle">Gérez les formats d'enseignement (Présentiel, En Ligne, Hybride, Atelier).</p>
    </div>
    <div class="flex flex-wrap items-center gap-2">
      <button @click="createModalOpen = true" type="button" class="btn-primary">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
        MODE
      </button>
    </div>
  </div>

  <!-- Grille des Modes -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse ($modes as $mode)
      <div class="bg-gradient-to-br from-white to-[#0BA20B]/[0.02] border border-slate-200 shadow-sm flex flex-col p-6 group hover:border-[#0BA20B]/50 hover:shadow-md transition-all duration-300 rounded-none relative overflow-hidden">
        
        <!-- Décoration angulaire (Corporate/Bento) -->
        <div class="absolute -right-8 -top-8 w-24 h-24 bg-[#0BA20B]/5 rotate-12 group-hover:bg-[#0BA20B]/10 group-hover:-rotate-12 transition-all duration-500 pointer-events-none"></div>

        <!-- Icône & Statut -->
        <div class="flex items-start justify-between mb-4 relative z-10">
          <div class="w-10 h-10 bg-[#0BA20B] flex items-center justify-center text-white group-hover:scale-110 transition-transform duration-300 shadow-sm rounded-none">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
          </div>
          <span class="px-2 py-0.5 text-[9px] font-bold uppercase tracking-widest border {{ strtolower($mode->actif ?? 'oui') === 'oui' ? 'bg-[#0BA20B]/10 text-[#0BA20B] border-[#0BA20B]/30' : 'bg-slate-100 text-slate-500 border-slate-200' }}">
            {{ strtolower($mode->actif ?? 'oui') === 'oui' ? 'Actif' : 'Inactif' }}
          </span>
        </div>

        <!-- Titre -->
        <div class="mb-6">
          <h3 class="text-lg font-bold text-slate-900 capitalize font-sans group-hover:text-[#0BA20B] transition-colors">
            {{ $mode->libelle ?? $mode->nom }}
          </h3>
          <p class="text-[10px] text-slate-400 mt-1 uppercase tracking-wider font-mono">ID: #{{ str_pad($mode->id, 3, '0', STR_PAD_LEFT) }}</p>
        </div>

        <!-- Actions -->
        <div class="mt-auto pt-4 border-t border-slate-100 flex items-center justify-between">
          <button type="button" 
                  @click="editMode = { id: {{ $mode->id }}, libelle: '{{ addslashes($mode->libelle ?? $mode->nom) }}' }; updateUrl = '/dashboard/admin/modes/' + {{ $mode->id }}; editModalOpen = true;" 
                  class="text-[11px] font-bold text-slate-500 hover:text-[#0BA20B] uppercase tracking-wider flex items-center gap-1.5 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            Modifier
          </button>
          
          <form action="{{ route('dashboard.admin.modes.destroy', $mode->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer ce mode ?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-[11px] font-bold text-slate-500 hover:text-red-500 uppercase tracking-wider flex items-center gap-1.5 transition-colors">
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
              Supprimer
            </button>
          </form>
        </div>
      </div>
    @empty
      <!-- État vide -->
      <div class="col-span-1 md:col-span-2 lg:col-span-3 bg-white border border-slate-200 p-10 text-center shadow-sm">
         <p class="text-xs text-slate-400 uppercase tracking-widest">Aucun mode de cours enregistré.</p>
      </div>
    @endforelse

    <!-- Ajouter Carte Bouton -->
    <button type="button" @click="createModalOpen = true" class="bg-slate-50 border-2 border-dashed border-slate-200 hover:border-[#0BA20B] hover:bg-[#0BA20B]/5 shadow-sm flex flex-col items-center justify-center p-8 group transition-colors rounded-none min-h-[200px]">
      <div class="w-12 h-12 rounded-none bg-white shadow-sm flex items-center justify-center mb-3 group-hover:bg-[#0BA20B] transition-colors border border-slate-100 group-hover:border-transparent text-slate-400 group-hover:text-white">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
      </div>
      <span class="text-[11px] font-bold uppercase tracking-widest text-slate-500 group-hover:text-[#0BA20B] transition-colors">Ajouter un mode</span>
    </button>
  </div>

  <!-- MODALE CRÉATION -->
  <div x-show="createModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-cloak>
    <div @click.away="createModalOpen = false" class="bg-white max-w-lg w-full rounded-none shadow-2xl border border-slate-200 overflow-hidden">
      <div class="bg-white px-6 py-4 flex items-center justify-between border-b-2 border-[#0BA20B]">
        <h3 class="text-sm font-sans font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2 font-sans">
          <span class="w-2 h-2 bg-[#0BA20B] inline-block"></span>
          Nouveau Mode de Cours
        </h3>
        <button type="button" @click="createModalOpen = false" class="text-slate-400 hover:text-slate-900 text-lg font-bold">&times;</button>
      </div>
      
      <form action="{{ route('dashboard.admin.modes.store') }}" method="POST" class="p-6 space-y-4">
        @csrf
        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Libellé du Mode *</label>
          <input type="text" name="libelle" required placeholder="ex: Présentiel, En Ligne, Hybride" class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none">
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
          <button type="button" @click="createModalOpen = false" class="px-4 py-2 text-xs uppercase font-bold tracking-wider text-slate-600 hover:bg-slate-100 transition-colors rounded-none">Annuler</button>
          <button type="submit" class="px-5 py-2 text-xs uppercase font-bold tracking-wider bg-[#0BA20B] hover:bg-[#0BA20B]-light text-white transition-colors rounded-none shadow-[0_0_16px_rgba(94,245,39,0.25)]">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>

  <!-- MODALE ÉDITION -->
  <div x-show="editModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-cloak>
    <div @click.away="editModalOpen = false" class="bg-white max-w-lg w-full rounded-none shadow-2xl border border-slate-200 overflow-hidden">
      <div class="bg-white px-6 py-4 flex items-center justify-between border-b-2 border-[#0BA20B]">
        <h3 class="text-sm font-sans font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2 font-sans">
          <span class="w-2 h-2 bg-[#0BA20B] inline-block"></span>
          Modifier le Mode
        </h3>
        <button type="button" @click="editModalOpen = false" class="text-slate-400 hover:text-slate-900 text-lg font-bold">&times;</button>
      </div>
      
      <form :action="updateUrl" method="POST" class="p-6 space-y-4">
        @csrf
        @method('PUT')
        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Libellé du Mode *</label>
          <input type="text" name="libelle" x-model="editMode.libelle" required class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none">
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
          <button type="button" @click="editModalOpen = false" class="px-4 py-2 text-xs uppercase font-bold tracking-wider text-slate-600 hover:bg-slate-100 transition-colors rounded-none">Annuler</button>
          <button type="submit" class="px-5 py-2 text-xs uppercase font-bold tracking-wider bg-[#0BA20B] hover:bg-[#0BA20B]-light text-white transition-colors rounded-none shadow-[0_0_16px_rgba(94,245,39,0.25)]">Mettre à Jour</button>
        </div>
      </form>
    </div>
  </div>

</div>
@endsection
