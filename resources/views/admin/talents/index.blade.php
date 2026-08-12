@extends('layouts.dashboard')

@section('title', 'Gestion des Talents | AssoCulture')

@section('content')
<div class="space-y-6">

  <!-- En-tête -->
  <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 pb-4 border-b border-slate-200">
    <div>
      <h1 class="admin-title">Jeunes Talents</h1>
      <p class="admin-subtitle">Vitrine et supervision des artistes et talents découverts par l'association.</p>
    </div>
    <div class="flex flex-wrap items-center gap-2">
      <a href="{{ route('dashboard.admin.talents.create') }}" class="btn-primary">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
        TALENT
      </a>
    </div>
  </div>

  <!-- Table des Talents -->
  <div class="bg-white border border-slate-200 shadow-sm rounded-none">
    <div class="overflow-x-auto overflow-y-visible min-h-[300px]">
      <table class="w-full text-left text-sm text-slate-600">
        <thead class="border-b border-slate-200 text-[10px] uppercase tracking-widest text-slate-400 font-bold bg-slate-50">
          <tr>
            <th class="p-4">Talent</th>
            <th class="p-4">Catégorie</th>
            <th class="p-4">Contact</th>
            <th class="p-4">Statut</th>
            <th class="p-4 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          @forelse ($talents as $talent)
            <tr class="hover:bg-slate-50 transition-colors">
              <td class="p-4">
                <div class="flex items-center gap-3">
                  @if($talent->photo)
                    <div class="w-10 h-10 bg-slate-900 text-amber-500 font-bold flex items-center justify-center text-xs overflow-hidden border border-slate-200 shrink-0">
                      <img src="{{ asset('storage/' . $talent->photo) }}" alt="{{ $talent->prenom }}" class="w-full h-full object-cover">
                    </div>
                  @else
                    <div class="w-10 h-10 bg-slate-900 text-amber-500 font-bold flex items-center justify-center text-xs border border-slate-200 shrink-0">
                      {{ strtoupper(substr($talent->prenom, 0, 1) . substr($talent->nom, 0, 1)) }}
                    </div>
                  @endif
                  <div>
                    <div class="font-bold text-slate-900">{{ $talent->prenom }} {{ $talent->nom }}</div>
                    @if($talent->biographie)
                      <div class="text-[11px] text-slate-400 truncate max-w-xs">{{ Str::limit($talent->biographie, 50) }}</div>
                    @endif
                  </div>
                </div>
              </td>
              <td class="p-4 text-xs font-semibold text-slate-700">
                {{ $talent->category ? $talent->category->libelle : 'Non catégorisé' }}
              </td>
              <td class="p-4 text-xs text-slate-500">
                <div>{{ $talent->email ?? '-' }}</div>
                <div class="text-[11px] text-slate-400">{{ $talent->telephone ?? '-' }}</div>
              </td>
              <td class="p-4">
                <span class="bg-emerald-100 text-emerald-700 text-[9px] font-bold px-2 py-0.5 uppercase tracking-widest rounded-none">
                  {{ strtoupper($talent->actif) }}
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
                      <a href="{{ route('dashboard.admin.talents.edit', $talent->id) }}" class="w-full text-left group flex items-center px-4 py-2 text-xs text-slate-700 hover:bg-slate-900 hover:text-white font-bold uppercase tracking-wider">
                        <svg class="mr-2 h-4 w-4 text-slate-400 group-hover:text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Modifier
                      </a>
                    </div>
                    <div class="py-1">
                      <form action="{{ route('dashboard.admin.talents.destroy', $talent->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer ce talent ?');">
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
              <td colspan="5" class="p-8 text-center text-xs text-slate-400">Aucun talent répertorié pour le moment.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>


</div>
@endsection
