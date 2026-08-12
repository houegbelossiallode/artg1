@extends('layouts.dashboard')

@section('title', 'Catégories de Talents | AssoCulture')

@section('content')
<div class="space-y-6" x-data="{ showModal: false, editMode: false, category: null, form: { nom: '' } }">
  
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
      <h1 class="admin-title">Catégories de Talents</h1>
      <p class="admin-subtitle">Gérez les catégories de talents (Musique, Danse, Théâtre, etc.).</p>
    </div>
    <div class="flex flex-wrap items-center gap-2">
      <button @click="showModal = true; editMode = false; form = { nom: '' }" class="btn-primary">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
        CATÉGORIE
      </button>
    </div>
  </div>

  <!-- Grille des Catégories (Premium Cards) -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse ($categories as $category)
      <div class="bg-white border border-slate-200 flex flex-col justify-between rounded-none shadow-sm hover:shadow-md transition-shadow duration-300 group">
        
        <!-- Haut : Titre et Menu Actions -->
        <div class="p-5 flex justify-between items-start gap-4">
          <h3 class="text-[16px] font-extrabold text-slate-900 leading-snug group-hover:text-[#0BA20B] transition-colors font-sans tracking-tight">{{ $category->libelle }}</h3>
          
          <!-- Menu Kebab (Modifier / Supprimer) -->
          <div class="relative shrink-0" x-data="{ open: false }" @click.away="open = false">
            <button @click="open = !open" type="button" class="w-8 h-8 border border-slate-200 bg-white hover:bg-slate-50 flex items-center justify-center text-slate-500 hover:text-[#0BA20B] hover:border-[#0BA20B] transition-colors rounded-none focus:outline-none shadow-sm">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
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
                <button @click="editMode = true; category = { id: {{ $category->id }}, libelle: '{{ addslashes($category->libelle) }}' }; form = { libelle: '{{ addslashes($category->libelle) }}' }; showModal = true; open = false;" 
                        class="w-full text-left group flex items-center px-4 py-2.5 text-[11px] text-slate-700 hover:bg-slate-50 hover:text-[#0BA20B] font-bold uppercase tracking-widest transition-colors">
                  <svg class="mr-2 h-4 w-4 text-slate-400 group-hover:text-[#0BA20B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                  MODIFIER
                </button>
              </div>
              <div class="py-1">
                <form action="{{ route('dashboard.admin.categories-talents.destroy', $category) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette catégorie ?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="w-full text-left group flex items-center px-4 py-2.5 text-[11px] text-red-600 hover:bg-red-50 hover:text-red-700 font-bold uppercase tracking-widest transition-colors">
                    <svg class="mr-2 h-4 w-4 text-red-500 group-hover:text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    SUPPRIMER
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Milieu : Informations -->
        <div class="p-5 border-t border-slate-100 space-y-3 bg-white mt-auto">
          <div class="flex items-center gap-2 text-[13px] text-slate-600">
            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>Création : <strong class="text-slate-800 font-semibold">{{ $category->created_at ? $category->created_at->format('d/m/Y') : 'Récente' }}</strong></span>
          </div>
          <div class="flex items-center gap-2 text-[13px] text-slate-600">
            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            <span>Type : <strong class="text-slate-800 font-semibold">Talent</strong></span>
          </div>
          <div class="mt-4 pt-1">
            <span class="inline-flex items-center gap-1.5 border border-slate-200 px-2 py-1 text-[9px] text-slate-500 font-bold uppercase tracking-widest bg-white">
              <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
              STANDARD
            </span>
          </div>
        </div>
      </div>
    @empty
      <div class="col-span-full p-16 bg-white border border-slate-200 text-center flex flex-col items-center justify-center shadow-sm">
        <div class="w-16 h-16 bg-slate-50 flex items-center justify-center rounded-none border border-slate-100 mb-4 mx-auto">
          <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
        </div>
        <p class="text-slate-500 font-medium mb-1">Aucune catégorie pour le moment</p>
        <p class="text-xs text-slate-400 mb-4">Créez votre première catégorie pour commencer</p>
      </div>
    @endforelse
  </div>

  <!-- MODAL DE CRÉATION/ÉDITION -->
  <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-cloak>
    <div @click.away="showModal = false" class="bg-white max-w-xl w-full rounded-none shadow-2xl border border-slate-200 overflow-hidden max-h-[90vh] flex flex-col">
      <div class="bg-white px-6 py-4 flex items-center justify-between border-b-2 border-[#0BA20B] shrink-0">
        <h3 class="text-sm font-sans font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
          <span class="w-2 h-2 bg-[#0BA20B] inline-block"></span>
          <span x-text="editMode ? 'Modifier la catégorie' : 'Nouvelle catégorie'"></span>
        </h3>
        <button type="button" @click="showModal = false" class="text-slate-400 hover:text-slate-900 text-lg font-bold">&times;</button>
      </div>
      
      <form :action="editMode ? '{{ route('dashboard.admin.categories-talents.update', '__ID__') }}'.replace('__ID__', category.id) : '{{ route('dashboard.admin.categories-talents.store') }}'" method="POST" class="p-6 space-y-4 overflow-y-auto">
        @csrf
        <input type="hidden" name="_method" :value="editMode ? 'PUT' : 'POST'">
        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Libellé *</label>
          <input type="text" name="nom" x-model="form.libelle" required class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none">
        </div>
        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
          <button type="button" @click="showModal = false" class="px-4 py-2 text-xs uppercase font-bold tracking-wider text-slate-600 hover:bg-slate-100 transition-colors rounded-none">Annuler</button>
          <button type="submit" class="btn-primary" x-text="editMode ? 'Mettre à jour' : 'Enregistrer'"></button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
