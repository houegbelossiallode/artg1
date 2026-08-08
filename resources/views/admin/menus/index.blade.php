@extends('layouts.dashboard')

@section('title', 'Gestion des Menus | AssoCulture')

@section('content')
<div class="space-y-6" x-data="{ createModalOpen: false, editModalOpen: false, editMenu: {}, updateUrl: '' }">
  
  <!-- En-tête -->
  <div class="bg-white border border-slate-200 shadow-sm px-6 py-5 border-l-4 border-l-slate-900 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <h1 class="text-lg font-bold text-slate-900 uppercase tracking-wide">MENUS PRINCIPAUX</h1>
      <p class="text-slate-400 text-sm mt-0.5">Gérez l'arborescence des menus rattachés aux modules système.</p>
    </div>
    <div class="flex flex-wrap items-center gap-2">
      <button @click="createModalOpen = true" type="button" class="inline-flex items-center gap-1.5 px-4 py-2 bg-brand-lime text-slate-900 font-bold text-[10px] uppercase tracking-widest hover:brightness-105 transition shadow-sm cursor-pointer">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
        + MENU
      </button>
    </div>
  </div>

  <!-- Table des Menus -->
  <div class="bg-white border border-slate-200 shadow-sm rounded-none">
    <div class="overflow-x-auto overflow-y-visible min-h-[300px]">
      <table class="w-full text-left text-sm text-slate-600">
        <thead class="border-b border-slate-200 text-[10px] uppercase tracking-widest text-slate-400 font-bold bg-slate-50">
          <tr>
            <th class="p-4">Menu</th>
            <th class="p-4">Module Associé</th>
            <th class="p-4">Icône</th>
            <th class="p-4">Statut</th>
            <th class="p-4 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          @forelse ($menus as $menuItem)
            <tr class="hover:bg-slate-50 transition-colors">
              <td class="p-4 font-bold text-slate-900 flex items-center gap-2">
                <span class="w-6 h-6 bg-slate-100 border border-slate-200 inline-flex items-center justify-center text-[10px] font-mono text-slate-600">M</span>
                {{ $menuItem->libelle ?? $menuItem->nom }}
              </td>
              <td class="p-4">
                @if($menuItem->module)
                  <span class="bg-blue-100 text-blue-700 text-[9px] font-bold px-2 py-0.5 uppercase tracking-widest rounded-sm">
                    {{ $menuItem->module->libelle ?? $menuItem->module->nom }}
                  </span>
                @else
                  <span class="text-xs text-slate-400">-</span>
                @endif
              <td class="p-4 text-xs">
                @if($menuItem->icon)
                  <div class="flex items-center justify-center w-8 h-8 rounded bg-slate-100 text-slate-600 border border-slate-200 shadow-sm">
                    @if(str_contains(trim($menuItem->icon), ' ') || str_starts_with(trim($menuItem->icon), 'fa'))
                      <i class="{{ trim($menuItem->icon) }} text-[18px]"></i>
                    @else
                      <i class="material-icons text-[18px] !bg-transparent !text-inherit !m-0 !p-0 !w-auto !h-auto !leading-none shadow-none">{{ trim($menuItem->icon) }}</i>
                    @endif
                  </div>
                @else
                  <span class="text-slate-400">-</span>
                @endif
              </td>
              <td class="p-4">
                <span class="bg-emerald-100 text-emerald-700 text-[9px] font-bold px-2 py-0.5 uppercase tracking-widest rounded-sm">
                  {{ strtoupper($menuItem->actif ?? 'OUI') }}
                </span>
              </td>
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
                      <button type="button" @click="editMenu = { id: {{ $menuItem->id }}, libelle: '{{ addslashes($menuItem->libelle ?? $menuItem->nom) }}', module_id: {{ $menuItem->module_id }}, icon: '{{ addslashes($menuItem->icon ?? '') }}' }; updateUrl = '/dashboard/admin/menus/' + {{ $menuItem->id }}; editModalOpen = true; open = false;" class="w-full text-left group flex items-center px-4 py-2 text-xs text-slate-700 hover:bg-slate-900 hover:text-white font-bold uppercase tracking-wider">
                        <svg class="mr-2 h-4 w-4 text-slate-400 group-hover:text-brand-lime" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Modifier
                      </button>
                    </div>
                    <div class="py-1">
                      <form action="{{ route('dashboard.admin.menus.destroy', $menuItem->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer ce menu ?');">
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
              <td colspan="5" class="p-8 text-center text-xs text-slate-400">Aucun menu enregistré.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- MODALE CRÉATION -->
  <div x-show="createModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-cloak>
    <div @click.away="createModalOpen = false" class="bg-white max-w-lg w-full rounded-none shadow-2xl border border-slate-200 overflow-hidden">
      <div class="bg-white px-6 py-4 flex items-center justify-between border-b-2 border-brand-lime">
        <h3 class="text-sm font-serif-heading font-bold text-white uppercase tracking-wider flex items-center gap-2">
          <span class="w-2 h-2 bg-brand-lime inline-block"></span>
          Nouveau Menu
        </h3>
        <button type="button" @click="createModalOpen = false" class="text-slate-400 hover:text-white text-lg font-bold">&times;</button>
      </div>
      
      <form action="{{ route('dashboard.admin.menus.store') }}" method="POST" class="p-6 space-y-4">
        @csrf
        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Module Référent *</label>
          <select name="module_id" required class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none bg-white">
            <option value="">-- Sélectionner un module --</option>
            @foreach($modules as $mod)
              <option value="{{ $mod->id }}">{{ $mod->libelle ?? $mod->nom }}</option>
            @endforeach
          </select>
        </div>

        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Libellé du Menu *</label>
          <input type="text" name="libelle" required placeholder="ex: Gestion des Événements" class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none">
        </div>

        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Icône (Material Icons)</label>
          <input type="text" name="icon" placeholder="ex: dashboard" class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none">
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
          <button type="button" @click="createModalOpen = false" class="px-4 py-2 text-xs uppercase font-bold tracking-wider text-slate-600 hover:bg-slate-100 transition-colors rounded-none">Annuler</button>
          <button type="submit" class="px-5 py-2 text-xs uppercase font-bold tracking-wider bg-brand-lime hover:bg-brand-lime-light text-slate-900 transition-colors rounded-none shadow-[0_0_16px_rgba(94,245,39,0.25)]">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>

  <!-- MODALE ÉDITION -->
  <div x-show="editModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-cloak>
    <div @click.away="editModalOpen = false" class="bg-white max-w-lg w-full rounded-none shadow-2xl border border-slate-200 overflow-hidden">
      <div class="bg-white px-6 py-4 flex items-center justify-between border-b-2 border-brand-lime">
        <h3 class="text-sm font-serif-heading font-bold text-white uppercase tracking-wider flex items-center gap-2">
          <span class="w-2 h-2 bg-brand-lime inline-block"></span>
          Modifier le Menu
        </h3>
        <button type="button" @click="editModalOpen = false" class="text-slate-400 hover:text-white text-lg font-bold">&times;</button>
      </div>
      
      <form :action="updateUrl" method="POST" class="p-6 space-y-4">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" x-model="editMenu.id">
        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Module Référent *</label>
          <select name="module_id" x-model="editMenu.module_id" required class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none bg-white">
            @foreach($modules as $mod)
              <option value="{{ $mod->id }}">{{ $mod->libelle ?? $mod->nom }}</option>
            @endforeach
          </select>
        </div>

        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Libellé du Menu *</label>
          <input type="text" name="libelle" x-model="editMenu.libelle" required class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none">
        </div>

        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Icône (Material Icons)</label>
          <input type="text" name="icon" x-model="editMenu.icon" placeholder="ex: dashboard" class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none">
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
          <button type="button" @click="editModalOpen = false" class="px-4 py-2 text-xs uppercase font-bold tracking-wider text-slate-600 hover:bg-slate-100 transition-colors rounded-none">Annuler</button>
          <button type="submit" class="px-5 py-2 text-xs uppercase font-bold tracking-wider bg-brand-lime hover:bg-brand-lime-light text-slate-900 transition-colors rounded-none shadow-[0_0_16px_rgba(94,245,39,0.25)]">Mettre à Jour</button>
        </div>
      </form>
    </div>
  </div>

</div>
@endsection
