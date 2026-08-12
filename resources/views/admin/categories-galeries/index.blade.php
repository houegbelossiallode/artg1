@extends('layouts.dashboard')

@section('title', 'Catégories Galeries | AssoCulture')

@section('content')
<div class="space-y-6" x-data="{ showModal: false, editMode: false, category: null, form: { libelle: '', description: '' } }">
  
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
      <h1 class="admin-title">Catégories Galeries</h1>
      <p class="admin-subtitle">Gérez les catégories de la médiathèque (Photos, Vidéos, Artisanat, etc.).</p>
    </div>
    <div class="flex flex-wrap items-center gap-2">
      <button @click="showModal = true; editMode = false; form = { libelle: '', description: '' }" class="btn-primary">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
        CATÉGORIE
      </button>
    </div>
  </div>

  <!-- Table des Catégories -->
  <div class="bg-white border border-slate-200 shadow-sm rounded-none">
    <div class="overflow-x-auto min-h-[300px]">
      <table class="w-full text-left text-sm text-slate-600">
        <thead class="border-b border-slate-200 text-[10px] uppercase tracking-widest text-slate-400 font-bold bg-slate-50">
          <tr>
            <th class="p-4">Libellé</th>
            <th class="p-4">Slug</th>
            <th class="p-4">Description</th>
            
            <th class="p-4 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          @forelse ($categories as $category)
            <tr class="hover:bg-slate-50 transition-colors">
              <td class="p-4">
                <div class="font-sans font-bold text-slate-900 text-sm">{{ $category->libelle }}</div>
              </td>
              <td class="p-4 text-xs font-mono text-slate-500">
                {{ $category->slug }}
              </td>
              <td class="p-4 text-xs text-slate-500">
                {{ $category->description ? Str::limit($category->description, 50) : '-' }}
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
                      <button @click="editMode = true; category = { id: {{ $category->id }}, libelle: '{{ $category->libelle }}', description: '{{ $category->description }}' }; form = { libelle: '{{ $category->libelle }}', description: '{{ $category->description }}' }; showModal = true; open = false" class="w-full text-left group flex items-center px-4 py-2 text-xs text-slate-700 hover:bg-slate-900 hover:text-white font-bold uppercase tracking-wider">
                        <svg class="mr-2 h-4 w-4 text-slate-400 group-hover:text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Modifier
                      </button>
                    </div>
                    <div class="py-1">
                      <form action="{{ route('dashboard.admin.categories-galeries.destroy', $category) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette catégorie ?');">
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
              <td colspan="5" class="p-8 text-center text-xs text-slate-400">Aucune catégorie pour le moment.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- MODAL DE CRÉATION/ÉDITION -->
  <div x-show="showModal" 
       x-transition:enter="transition ease-out duration-200" 
       x-transition:enter-start="opacity-0" 
       x-transition:enter-end="opacity-100" 
       x-transition:leave="transition ease-in duration-150" 
       x-transition:leave-start="opacity-100" 
       x-transition:leave-end="opacity-0"
       dusk="modal"
       class="fixed inset-0 z-50 overflow-y-auto" 
       x-cloak>
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
      <div x-show="showModal" 
           x-transition:enter="transition ease-out duration-300" 
           x-transition:enter-start="opacity-0" 
           x-transition:enter-end="opacity-100" 
           x-transition:leave="transition ease-in duration-200" 
           x-transition:leave-start="opacity-100" 
           x-transition:leave-end="opacity-0"
           class="fixed inset-0 bg-slate-900/30 transition-opacity" 
           @click="showModal = false"></div>
      
      <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
      
      <div x-show="showModal" 
           x-transition:enter="transition ease-out duration-300" 
           x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
           x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
           x-transition:leave="transition ease-in duration-200" 
           x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
           x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
           class="relative inline-block align-bottom bg-white rounded-none text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full z-10">
        
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
          <div class="sm:flex sm:items-start">
            <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
              <h3 class="text-lg leading-6 font-medium text-slate-900 font-sans" x-text="editMode ? 'Modifier la catégorie' : 'Nouvelle catégorie'"></h3>
              
              <form :action="editMode ? '{{ route('dashboard.admin.categories-galeries.update', '__ID__') }}'.replace('__ID__', category.id) : '{{ route('dashboard.admin.categories-galeries.store') }}'" method="POST" class="mt-4 space-y-4">
                @csrf
                <input type="hidden" name="_method" :value="editMode ? 'PUT' : 'POST'">
                
                <div>
                  <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Libellé <span class="text-red-500">*</span></label>
                  <input type="text" name="libelle" x-model="form.libelle" required class="w-full px-4 py-2.5 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none">
                </div>

                <div>
                  <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Description</label>
                  <textarea name="description" x-model="form.description" rows="3" class="w-full px-4 py-2.5 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none" placeholder="Description de la catégorie..."></textarea>
                </div>

                <div class="flex justify-end gap-3 pt-4">
                  <button type="button" @click="showModal = false" class="px-4 py-2 text-xs uppercase font-bold tracking-wider text-slate-600 hover:bg-slate-100 transition-colors rounded-none">Annuler</button>
                  <button type="submit" class="btn-primary" x-text="editMode ? 'Mettre à jour' : 'Enregistrer'"></button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
