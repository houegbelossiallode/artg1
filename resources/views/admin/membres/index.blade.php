@extends('layouts.dashboard')

@section('title', 'Membres & Inscriptions | AssoCulture')

@section('content')
<div class="space-y-6">

  {{-- Header --}}
  <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 pb-4 border-b border-slate-200">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
        <a href="{{ route('dashboard.admin') }}" class="hover:text-slate-900 transition-colors">Tableau de bord</a>
        <span>/</span>
        <span class="text-slate-700 font-bold">Membres</span>
      </div>
      <h1 class="admin-title">Membres Enregistrés</h1>
      <p class="admin-subtitle">Liste exhaustive de tous les utilisateurs</p>
    </div>
  </div>

  {{-- Table Container --}}
  <div class="bg-white border border-slate-200 shadow-sm">
    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex justify-between items-center">
      <div class="flex items-center gap-3">
        <div class="w-7 h-7 bg-[#0BA20B] flex items-center justify-center shrink-0">
          <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
          </svg>
        </div>
        <div>
          <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wide font-sans">Tous les Membres</h2>
        </div>
      </div>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="border-b border-slate-200">
            <th class="py-3 px-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest bg-slate-50 border-y border-slate-200">Membre & Infos</th>
            <th class="py-3 px-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest bg-slate-50 border-y border-slate-200">Contact</th>
            <th class="py-3 px-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest bg-slate-50 border-y border-slate-200">Rôle</th>
            <th class="py-3 px-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest bg-slate-50 border-y border-slate-200">Date d'inscription</th>
            <th class="py-3 px-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-right bg-slate-50 border-y border-slate-200">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          @forelse ($users as $userItem)
            <tr class="hover:bg-slate-50 transition-colors">
              <td class="py-4 px-6">
                <p class="text-sm font-bold text-slate-900">{{ $userItem->prenom }} {{ $userItem->nom }}</p>
                <p class="text-xs text-slate-500 font-medium">{{ $userItem->sexe === 'M' ? 'Masculin' : ($userItem->sexe === 'F' ? 'Féminin' : '-') }}</p>
              </td>
              <td class="py-4 px-6">
                <p class="text-sm text-slate-700 font-medium">{{ $userItem->email }}</p>
                <p class="text-xs text-slate-500">{{ $userItem->telephone ?? 'Non renseigné' }}</p>
              </td>
              <td class="py-4 px-6">
                <div class="flex items-center gap-2">
                  @if($userItem->profil)
                    @if($userItem->profil->nom === 'administrateur')
                      <span class="bg-slate-900 text-white text-[9px] font-bold px-2 py-0.5 uppercase tracking-widest border border-slate-900">Admin</span>
                    @elseif($userItem->profil->nom === 'professeur')
                      <span class="bg-blue-50 text-blue-700 border border-blue-200 text-[9px] font-bold px-2 py-0.5 uppercase tracking-widest">Professeur</span>
                    @else
                      <span class="bg-slate-100 text-slate-600 border border-slate-200 text-[9px] font-bold px-2 py-0.5 uppercase tracking-widest">Apprenant</span>
                    @endif
                  @endif
                </div>
              </td>
              <td class="py-4 px-6">
                <p class="text-sm text-slate-700 font-medium">{{ $userItem->created_at->format('d/m/Y') }}</p>
              </td>
              <td class="py-4 px-6 text-right" x-data="{ open: false }">
                <div class="relative inline-block text-left">
                  <button @click="open = !open" @click.away="open = false"
                    class="text-slate-400 hover:text-[#0BA20B] transition-colors p-1.5 border border-transparent hover:border-slate-200 bg-white shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                    </svg>
                  </button>
                  <div x-show="open" x-transition style="display: none;"
                    class="absolute right-0 mt-2 w-32 bg-white border border-slate-200 shadow-lg z-10 text-left">
                    <a href="#" class="block px-4 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50 hover:text-[#0BA20B] transition-colors border-b border-slate-100">Modifier</a>
                    <a href="#" class="block px-4 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50 hover:text-red-500 transition-colors">Supprimer</a>
                  </div>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="py-12 text-center text-sm text-slate-500 font-medium bg-slate-50">Aucun membre enregistré dans la base de données.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Pagination --}}
    @if($users->hasPages())
    <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
      {{ $users->links() }}
    </div>
    @endif
  </div>

</div>
@endsection
