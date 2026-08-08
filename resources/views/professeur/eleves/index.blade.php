@extends('layouts.dashboard')

@section('title', 'Liste des Élèves')

@section('content')
<div class="w-full flex flex-col gap-5">
  {{-- Page Header --}}
  <x-dashboard.page-header title="Liste des Élèves" description="Gestion des élèves du professeur." />
  <div class="bg-white border border-slate-200 shadow-sm p-6">
    <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
      <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wide">Élèves</h2>
      <div class="relative">
        <select class="appearance-none border border-slate-300 text-xs text-slate-700 font-semibold px-4 py-1.5 pr-8 bg-white focus:outline-none focus:border-slate-500 cursor-pointer">
          <option>Tous les élèves</option>
        </select>
        <svg class="absolute right-2 top-1/2 -translate-y-1/2 w-3 h-3 text-slate-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
      </div>
    </div>
    <div class="border-b border-slate-200 bg-white">
      <table class="w-full text-left">
        <thead>
          <tr class="border-b border-slate-200">
            <th class="px-6 py-3 text-[9px] font-bold text-slate-400 uppercase tracking-widest">ÉLÈVE</th>
            <th class="px-4 py-3 text-[9px] font-bold text-slate-400 uppercase tracking-widest">EMAIL</th>
            <th class="px-4 py-3 text-[9px] font-bold text-slate-400 uppercase tracking-widest">INSCRIT LE</th>
            <th class="px-4 py-3 text-[9px] font-bold text-slate-400 uppercase tracking-widest text-right">ACTIONS</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          @forelse ($eleves as $eleve)
            <tr class="hover:bg-slate-50 transition-colors">
              <td class="px-6 py-3.5">
                <div class="flex items-center gap-3">
                  <div class="w-8 h-8 bg-[#5EF527] text-slate-900 font-bold flex items-center justify-center text-[10px] shrink-0">
                    {{ strtoupper(substr($eleve->prenom,0,1) . substr($eleve->nom,0,1)) }}
                  </div>
                  <span class="font-bold text-slate-900 text-xs">{{ $eleve->prenom }} {{ $eleve->nom }}</span>
                </div>
              </td>
              <td class="px-4 py-3.5 text-xs text-slate-500">{{ $eleve->email }}</td>
              <td class="px-4 py-3.5 text-xs text-slate-400">{{ $eleve->created_at ? $eleve->created_at->format('d/m/Y') : '-' }}</td>
              <td class="px-4 py-3.5 text-right">
                <div class="relative inline-block text-left" x-data="{ open: false }" @click.away="open = false">
                  <button @click="open = !open" type="button" class="w-7 h-7 border border-slate-300 bg-white hover:bg-slate-100 text-slate-500 inline-flex items-center justify-center focus:outline-none transition-colors">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
                  </button>
                  <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 mt-1 w-44 bg-white shadow-lg border border-slate-200 z-50 divide-y divide-slate-100" style="display:none;">
                    <a href="{{ route('dashboard.professeur.eleves.suivi', $eleve->id) }}" class="flex items-center gap-2 px-4 py-2.5 text-xs text-[#5EF527] hover:bg-[#5EF527]/5 font-semibold">
                      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                      Suivi
                    </a>
                    <a href="#" @click.prevent="open = false" class="flex items-center gap-2 px-4 py-2.5 text-xs text-slate-700 hover:bg-slate-50 font-semibold">Modifier</a>
                    <button type="button" onclick="confirm('Supprimer cet élève ?')" class="w-full flex items-center gap-2 px-4 py-2.5 text-xs text-red-600 hover:bg-red-50 font-semibold">Supprimer</button>
                  </div>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="px-6 py-12 text-center">
                <svg class="w-10 h-10 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                <p class="text-sm text-slate-400">Aucun élève enregistré pour le moment.</p>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
