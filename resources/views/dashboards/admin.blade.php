@extends('layouts.dashboard')

@section('title', 'Administration | AssoCulture')

@section('content')
<div class="w-full flex flex-col gap-5" x-data="{ showProfModal: false, showTalentModal: false, showCatModal: false }">

  {{-- ═══════════════════════ FLASH MESSAGES ═══════════════════════ --}}
  @if (session('success'))
    <div class="p-4 bg-emerald-50 border border-l-4 border-l-emerald-600 border-emerald-200 text-emerald-800 text-xs flex items-center justify-between shadow-sm">
      <div class="flex items-center gap-2">
        <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span>{{ session('success') }}</span>
      </div>
      <button @click="$el.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800 font-bold text-xl leading-none">&times;</button>
    </div>
  @endif

  @if ($errors->any())
    <div class="p-4 bg-red-50 border border-l-4 border-l-red-600 border-red-200 text-red-800 text-xs shadow-sm">
      <p class="font-bold mb-1">Veuillez corriger les erreurs suivantes :</p>
      <ul class="list-disc pl-4 space-y-0.5">
        @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
      </ul>
    </div>
  @endif

  {{-- ═══════════════════════ PAGE HEADER ═══════════════════════ --}}
  <div class="bg-white border border-slate-200 shadow-sm px-6 py-5 border-l-4 border-l-slate-900 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <h1 class="text-lg font-bold text-slate-900 uppercase tracking-wide">GESTION ARTISTIQUE & CULTURELLE</h1>
      <p class="text-slate-400 text-sm mt-0.5">Supervision des membres, professeurs, talents et catégories de l'association.</p>
    </div>
    <div class="flex flex-wrap items-center gap-2">
      <button @click="showCatModal = true"
        class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#C85A32] text-white font-bold text-[10px] uppercase tracking-widest hover:bg-[#A84223] transition shadow-sm cursor-pointer">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
        + CATÉGORIE
      </button>
      <button @click="showProfModal = true"
        class="inline-flex items-center gap-1.5 px-4 py-2 bg-amber-500 text-white font-bold text-[10px] uppercase tracking-widest hover:bg-amber-600 transition shadow-sm cursor-pointer">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
        + PROFESSEUR
      </button>
      <button @click="showTalentModal = true"
        class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-500 text-white font-bold text-[10px] uppercase tracking-widest hover:bg-blue-600 transition shadow-sm cursor-pointer">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
        + TALENT
      </button>
    </div>
  </div>

  {{-- ═══════════════════════ CARTES MÉTRIQUES ═══════════════════════ --}}
  <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

    {{-- Carte 1 : Total Membres --}}
    <div class="bg-white border border-slate-200 shadow-sm p-3.5 border-l-4 border-l-slate-800 flex flex-col gap-2.5">
      <div class="flex items-center justify-between">
        <div class="w-7 h-7 bg-slate-100 flex items-center justify-center">
          <svg class="w-3.5 h-3.5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/>
          </svg>
        </div>
        <span class="text-[8px] font-bold text-slate-600 bg-slate-100 border border-slate-300 px-1.5 py-0.5 uppercase tracking-widest">GLOBAL</span>
      </div>
      <div class="flex items-end justify-between">
        <div>
          <p class="text-[8px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">TOTAL MEMBRES</p>
          <span class="text-2xl font-normal text-slate-900">{{ $totalUsers ?? 0 }}</span>
        </div>
        {{-- Mini bar chart --}}
        <svg class="w-8 h-6 text-slate-300" viewBox="0 0 40 30" fill="currentColor">
          <rect x="0" y="20" width="6" height="10"/>
          <rect x="9" y="14" width="6" height="16"/>
          <rect x="18" y="8" width="6" height="22"/>
          <rect x="27" y="4" width="6" height="26"/>
          <rect x="34" y="10" width="6" height="20"/>
        </svg>
      </div>
    </div>

    {{-- Carte 2 : Professeurs --}}
    <div class="bg-white border border-slate-200 shadow-sm p-3.5 border-l-4 border-l-blue-500 flex flex-col gap-2.5">
      <div class="flex items-center justify-between">
        <div class="w-7 h-7 bg-blue-50 flex items-center justify-center">
          <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
          </svg>
        </div>
        <span class="text-[8px] font-bold text-blue-600 bg-blue-50 border border-blue-300 px-1.5 py-0.5 uppercase tracking-widest">NOUVEAU</span>
      </div>
      <div class="flex items-end justify-between">
        <div>
          <p class="text-[8px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">NOUVELLES DEMANDES</p>
          <span class="text-2xl font-normal text-slate-900">{{ $totalProfesseurs ?? 0 }}</span>
        </div>
        <svg class="w-8 h-6 text-blue-200" viewBox="0 0 40 30" fill="currentColor">
          <rect x="0" y="24" width="6" height="6"/>
          <rect x="9" y="18" width="6" height="12"/>
          <rect x="18" y="12" width="6" height="18"/>
          <rect x="27" y="6" width="6" height="24"/>
          <rect x="34" y="15" width="6" height="15"/>
        </svg>
      </div>
    </div>

    {{-- Carte 3 : Talents --}}
    <div class="bg-white border border-slate-200 shadow-sm p-3.5 border-l-4 border-l-amber-500 flex flex-col gap-2.5">
      <div class="flex items-center justify-between">
        <div class="w-7 h-7 bg-amber-50 flex items-center justify-center">
          <svg class="w-3.5 h-3.5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
          </svg>
        </div>
        <span class="text-[8px] font-bold text-amber-600 bg-amber-50 border border-amber-300 px-1.5 py-0.5 uppercase tracking-widest">EN COURS</span>
      </div>
      <div class="flex items-end justify-between">
        <div>
          <p class="text-[8px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">EN INSTRUCTION</p>
          <span class="text-2xl font-normal text-slate-900">{{ $totalTalents ?? 0 }}</span>
        </div>
        <svg class="w-8 h-6 text-amber-200" viewBox="0 0 40 30" fill="currentColor">
          <rect x="0" y="20" width="6" height="10"/>
          <rect x="9" y="10" width="6" height="20"/>
          <rect x="18" y="16" width="6" height="14"/>
          <rect x="27" y="5" width="6" height="25"/>
          <rect x="34" y="12" width="6" height="18"/>
        </svg>
      </div>
    </div>

    {{-- Carte 4 : Catégories --}}
    <div class="bg-white border border-slate-200 shadow-sm p-3.5 border-l-4 border-l-[#C85A32] flex flex-col gap-2.5">
      <div class="flex items-center justify-between">
        <div class="w-7 h-7 bg-[#C85A32]/10 flex items-center justify-center">
          <svg class="w-3.5 h-3.5 text-[#C85A32]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
          </svg>
        </div>
        <span class="text-[8px] font-bold text-[#C85A32] bg-[#C85A32]/10 border border-[#C85A32]/30 px-1.5 py-0.5 uppercase tracking-widest">VALIDÉ</span>
      </div>
      <div class="flex items-end justify-between">
        <div>
          <p class="text-[8px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">APPROUVÉS</p>
          <span class="text-2xl font-normal text-slate-900">{{ isset($categorieTalents) ? $categorieTalents->count() : 0 }}</span>
        </div>
        <svg class="w-8 h-6 text-green-200" viewBox="0 0 40 30" fill="currentColor">
          <rect x="0" y="22" width="6" height="8"/>
          <rect x="9" y="16" width="6" height="14"/>
          <rect x="18" y="10" width="6" height="20"/>
          <rect x="27" y="4" width="6" height="26"/>
          <rect x="34" y="8" width="6" height="22"/>
        </svg>
      </div>
    </div>

  </div>

  {{-- ═══════════════════════ GRILLE PRINCIPALE ═══════════════════════ --}}
  <div class="grid grid-cols-1 xl:grid-cols-4 gap-4">

    {{-- TABLE MEMBRES (span 3) --}}
    <div class="xl:col-span-3 bg-white border border-slate-200 shadow-sm">

      {{-- Header table --}}
      <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
        <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wide">LISTE DES MEMBRES</h2>
        <div class="relative">
          <select class="appearance-none border border-slate-300 text-xs text-slate-700 font-semibold px-4 py-1.5 pr-8 bg-white focus:outline-none focus:border-slate-500 cursor-pointer">
            <option>Tous les profils</option>
            <option>Administrateurs</option>
            <option>Professeurs</option>
            <option>Apprenants</option>
          </select>
          <svg class="absolute right-2 top-1/2 -translate-y-1/2 w-3 h-3 text-slate-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </div>
      </div>

      {{-- En-têtes colonnes --}}
      <div class="border-b border-slate-200 bg-white">
        <table class="w-full text-left">
          <thead>
            <tr class="border-b border-slate-200">
              <th class="px-6 py-3 text-[9px] font-bold text-slate-400 uppercase tracking-widest">MEMBRE</th>
              <th class="px-4 py-3 text-[9px] font-bold text-slate-400 uppercase tracking-widest">EMAIL</th>
              <th class="px-4 py-3 text-[9px] font-bold text-slate-400 uppercase tracking-widest">RÔLE</th>
              <th class="px-4 py-3 text-[9px] font-bold text-slate-400 uppercase tracking-widest">STATUT</th>
              <th class="px-4 py-3 text-[9px] font-bold text-slate-400 uppercase tracking-widest">INSCRIT LE</th>
              <th class="px-4 py-3 text-[9px] font-bold text-slate-400 uppercase tracking-widest text-right">ACTIONS</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
            @forelse ($recentUsers as $userItem)
              <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-6 py-3.5">
                  <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-slate-800 text-white font-bold flex items-center justify-center text-[10px] shrink-0">
                      {{ strtoupper(substr($userItem->prenom, 0, 1) . substr($userItem->nom, 0, 1)) }}
                    </div>
                    <span class="font-bold text-slate-900 text-xs">{{ $userItem->prenom }} {{ $userItem->nom }}</span>
                  </div>
                </td>
                <td class="px-4 py-3.5 text-xs text-slate-500">{{ $userItem->email }}</td>
                <td class="px-4 py-3.5 text-xs">
                  @if($userItem->profil)
                    @if($userItem->profil->nom === 'administrateur')
                      <span class="bg-purple-100 text-purple-700 text-[9px] font-bold px-2 py-0.5 uppercase tracking-widest border border-purple-200">Admin</span>
                    @elseif($userItem->profil->nom === 'professeur')
                      <span class="bg-blue-100 text-blue-700 text-[9px] font-bold px-2 py-0.5 uppercase tracking-widest border border-blue-200">Professeur</span>
                    @else
                      <span class="bg-slate-100 text-slate-600 text-[9px] font-bold px-2 py-0.5 uppercase tracking-widest border border-slate-200">Apprenant</span>
                    @endif
                  @endif
                </td>
                <td class="px-4 py-3.5">
                  <span class="bg-emerald-100 text-emerald-700 text-[9px] font-bold px-2 py-0.5 uppercase tracking-widest border border-emerald-200">
                    {{ strtoupper($userItem->actif) }}
                  </span>
                </td>
                <td class="px-4 py-3.5 text-xs text-slate-400">
                  {{ $userItem->created_at ? $userItem->created_at->format('d/m/Y') : '-' }}
                </td>
                <td class="px-4 py-3.5 text-right">
                  <div class="relative inline-block text-left" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open" type="button"
                      class="w-7 h-7 border border-slate-300 bg-white hover:bg-slate-100 text-slate-500 inline-flex items-center justify-center focus:outline-none transition-colors">
                      <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/>
                      </svg>
                    </button>
                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-1 w-40 bg-white shadow-lg border border-slate-200 z-50 divide-y divide-slate-100"
                         style="display:none;">
                      <a href="#" @click.prevent="open = false"
                        class="flex items-center gap-2 px-4 py-2.5 text-xs text-slate-700 hover:bg-slate-50 font-semibold">
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Modifier
                      </a>
                      <button type="button" onclick="confirm('Supprimer ce membre ?')"
                        class="w-full flex items-center gap-2 px-4 py-2.5 text-xs text-red-600 hover:bg-red-50 font-semibold">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Supprimer
                      </button>
                    </div>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="px-6 py-12 text-center">
                  <svg class="w-10 h-10 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                  <p class="text-sm text-slate-400">Aucun membre enregistré pour le moment.</p>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    {{-- PANNEAU LATÉRAL ─ GESTION RAPIDE --}}
    <div class="xl:col-span-1 flex flex-col gap-4">

      {{-- Gestion Rapide --}}
      <div class="bg-white border border-slate-200 shadow-sm">
        <div class="px-5 py-3.5 border-b border-slate-200">
          <h2 class="text-xs font-bold text-slate-900 uppercase tracking-widest">Gestion Rapide</h2>
        </div>
        <div class="divide-y divide-slate-100">
          <button @click="showProfModal = true"
            class="w-full flex items-center justify-between px-5 py-3.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors group text-left">
            <span>+ Enregistrer Professeur</span>
            <svg class="w-4 h-4 text-slate-400 group-hover:text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
          </button>
          <button @click="showTalentModal = true"
            class="w-full flex items-center justify-between px-5 py-3.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors group text-left">
            <span>+ Enregistrer Talent</span>
            <svg class="w-4 h-4 text-slate-400 group-hover:text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
          </button>
          <button @click="showCatModal = true"
            class="w-full flex items-center justify-between px-5 py-3.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors group text-left">
            <span>+ Nouvelle Catégorie</span>
            <svg class="w-4 h-4 text-slate-400 group-hover:text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
          </button>
        </div>
      </div>

      {{-- Résumé Catégories --}}
      <div class="bg-white border border-slate-200 shadow-sm">
        <div class="px-5 py-3.5 border-b border-slate-200">
          <h2 class="text-xs font-bold text-slate-900 uppercase tracking-widest">Catégories Définies</h2>
        </div>
        <div class="divide-y divide-slate-100">
          <div class="flex items-center justify-between px-5 py-3">
            <div class="flex items-center gap-2">
              <div class="w-2 h-4 bg-blue-500"></div>
              <span class="text-xs text-slate-600 font-medium">Cours</span>
            </div>
            <span class="text-sm font-bold text-slate-900">{{ $categorieCours->count() }}</span>
          </div>
          <div class="flex items-center justify-between px-5 py-3">
            <div class="flex items-center gap-2">
              <div class="w-2 h-4 bg-amber-500"></div>
              <span class="text-xs text-slate-600 font-medium">Événements</span>
            </div>
            <span class="text-sm font-bold text-slate-900">{{ $categorieEvenements->count() }}</span>
          </div>
          <div class="flex items-center justify-between px-5 py-3">
            <div class="flex items-center gap-2">
              <div class="w-2 h-4 bg-[#C85A32]"></div>
              <span class="text-xs text-slate-600 font-medium">Talents</span>
            </div>
            <span class="text-sm font-bold text-slate-900">{{ $categorieTalents->count() }}</span>
          </div>
        </div>
      </div>

    </div>
  </div>

</div>

{{-- ══════════════════════ MODALS ══════════════════════ --}}

{{-- MODAL : Nouveau Professeur --}}
<div x-show="showProfModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm" x-cloak style="display:none;">
  <div @click.away="showProfModal = false" class="bg-white w-full max-w-lg shadow-2xl border border-slate-200 max-h-[90vh] overflow-y-auto">
    <div class="flex justify-between items-center px-6 py-4 border-b border-slate-200 bg-slate-50">
      <div>
        <h3 class="font-bold text-slate-900 text-sm uppercase tracking-wide">Enregistrer un Professeur</h3>
        <p class="text-[11px] text-slate-400 mt-0.5">Corps enseignant · Arts & Culture</p>
      </div>
      <button @click="showProfModal = false" class="w-8 h-8 border border-slate-300 bg-white flex items-center justify-center text-slate-500 hover:text-slate-900 hover:bg-slate-100 transition-colors text-lg font-bold leading-none">&times;</button>
    </div>
    <form action="{{ route('dashboard.admin.professeurs.store') }}" method="POST" class="p-6 space-y-4">
      @csrf
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Nom</label>
          <input type="text" name="nom" required class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-[#C85A32] transition" placeholder="Nom de famille">
        </div>
        <div>
          <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Prénom</label>
          <input type="text" name="prenom" required class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-[#C85A32] transition" placeholder="Prénom">
        </div>
      </div>
      <div>
        <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Email</label>
        <input type="email" name="email" required class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-[#C85A32] transition" placeholder="professeur@assoculture.com">
      </div>
      <div>
        <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Mot de passe</label>
        <input type="password" name="password" required class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-[#C85A32] transition" placeholder="Minimum 8 caractères">
      </div>
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Genre</label>
          <select name="sexe" required class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-[#C85A32] transition">
            <option value="M">Masculin</option>
            <option value="F">Féminin</option>
          </select>
        </div>
        <div>
          <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Date de Naissance</label>
          <input type="date" name="date_naissance" required class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-[#C85A32] transition">
        </div>
      </div>
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Téléphone</label>
          <input type="tel" name="telephone" required class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-[#C85A32] transition" placeholder="+229 00 00 00 00">
        </div>
        <div>
          <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Adresse</label>
          <input type="text" name="adresse" required class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-[#C85A32] transition" placeholder="Ville / Commune">
        </div>
      </div>
      <div>
        <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Biographie / Spécialité Artistique</label>
        <textarea name="biographie" rows="3" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-[#C85A32] transition" placeholder="Présentation du professeur, domaine artistique..."></textarea>
      </div>
      <div class="flex justify-end gap-3 pt-3 border-t border-slate-200">
        <button type="button" @click="showProfModal = false" class="px-4 py-2 text-xs font-bold uppercase tracking-wider text-slate-500 hover:text-slate-900 hover:bg-slate-100 border border-transparent hover:border-slate-200 transition">Annuler</button>
        <button type="submit" class="px-5 py-2 bg-[#C85A32] hover:bg-[#A84223] text-white font-bold text-xs uppercase tracking-widest shadow-sm transition">Créer le Professeur</button>
      </div>
    </form>
  </div>
</div>

{{-- MODAL : Nouveau Talent --}}
<div x-show="showTalentModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm" x-cloak style="display:none;">
  <div @click.away="showTalentModal = false" class="bg-white w-full max-w-lg shadow-2xl border border-slate-200 max-h-[90vh] overflow-y-auto">
    <div class="flex justify-between items-center px-6 py-4 border-b border-slate-200 bg-slate-50">
      <div>
        <h3 class="font-bold text-slate-900 text-sm uppercase tracking-wide">Enregistrer un Jeune Talent</h3>
        <p class="text-[11px] text-slate-400 mt-0.5">Vitrine artistique de l'association</p>
      </div>
      <button @click="showTalentModal = false" class="w-8 h-8 border border-slate-300 bg-white flex items-center justify-center text-slate-500 hover:text-slate-900 hover:bg-slate-100 transition-colors text-lg font-bold leading-none">&times;</button>
    </div>
    <form action="{{ route('dashboard.admin.talents.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
      @csrf
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Nom</label>
          <input type="text" name="nom" required class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-brand-lime transition">
        </div>
        <div>
          <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Prénom</label>
          <input type="text" name="prenom" required class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-brand-lime transition">
        </div>
      </div>
      <div>
        <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Catégorie de Talent</label>
        <select name="categorie_talent_id" required class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-brand-lime transition">
          <option value="">Sélectionner une catégorie</option>
          @foreach($categorieTalents as $catT)
            <option value="{{ $catT->id }}">{{ $catT->libelle }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Biographie / Œuvre</label>
        <textarea name="biographie" rows="3" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-brand-lime transition" placeholder="Parcours artistique, œuvres, réalisations..."></textarea>
      </div>
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Téléphone</label>
          <input type="tel" name="telephone" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-brand-lime transition">
        </div>
        <div>
          <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Email</label>
          <input type="email" name="email" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-brand-lime transition">
        </div>
      </div>
      <div>
        <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Photo de profil</label>
        <input type="file" name="photo" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-xs file:font-bold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
      </div>
      <div class="flex justify-end gap-3 pt-3 border-t border-slate-200">
        <button type="button" @click="showTalentModal = false" class="px-4 py-2 text-xs font-bold uppercase tracking-wider text-slate-500 hover:text-slate-900 hover:bg-slate-100 border border-transparent hover:border-slate-200 transition">Annuler</button>
        <button type="submit" class="px-5 py-2 bg-brand-lime text-slate-900 font-bold text-xs uppercase tracking-widest hover:brightness-105 shadow-sm transition">Créer le Talent</button>
      </div>
    </form>
  </div>
</div>

{{-- MODAL : Nouvelle Catégorie --}}
<div x-show="showCatModal" x-data="{ catType: 'cours' }" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm" x-cloak style="display:none;">
  <div @click.away="showCatModal = false" class="bg-white w-full max-w-md shadow-2xl border border-slate-200">
    <div class="flex justify-between items-center px-6 py-4 border-b border-slate-200 bg-slate-50">
      <div>
        <h3 class="font-bold text-slate-900 text-sm uppercase tracking-wide">Ajouter une Catégorie</h3>
        <p class="text-[11px] text-slate-400 mt-0.5">Cours, événements ou talents artistiques</p>
      </div>
      <button @click="showCatModal = false" class="w-8 h-8 border border-slate-300 bg-white flex items-center justify-center text-slate-500 hover:text-slate-900 hover:bg-slate-100 transition-colors text-lg font-bold leading-none">&times;</button>
    </div>
    <form :action="catType === 'cours' ? '{{ route('dashboard.admin.categories-cours.store') }}' : (catType === 'evenement' ? '{{ route('dashboard.admin.categories-evenements.store') }}' : '{{ route('dashboard.admin.categories-talents.store') }}')" method="POST" class="p-6 space-y-4">
      @csrf
      <div>
        <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Type de Catégorie</label>
        <select x-model="catType" name="type" required class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-brand-lime transition">
          <option value="cours">Catégorie de Cours</option>
          <option value="evenement">Catégorie d'Événements</option>
          <option value="talent">Catégorie de Talents</option>
        </select>
      </div>
      <div>
        <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Intitulé / Nom</label>
        <input type="text" name="nom" required class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-brand-lime transition" placeholder="Ex: Musique Traditionnelle, Artisanat Raphia...">
      </div>
      <div x-show="catType === 'cours'">
        <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Description (optionnelle)</label>
        <textarea name="description" rows="2" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-brand-lime transition" placeholder="Description brève de cette catégorie..."></textarea>
      </div>
      <div class="flex justify-end gap-3 pt-3 border-t border-slate-200">
        <button type="button" @click="showCatModal = false" class="px-4 py-2 text-xs font-bold uppercase tracking-wider text-slate-500 hover:text-slate-900 hover:bg-slate-100 border border-transparent hover:border-slate-200 transition">Annuler</button>
        <button type="submit" class="px-5 py-2 bg-brand-lime text-slate-900 font-bold text-xs uppercase tracking-widest hover:brightness-105 shadow-sm transition">Enregistrer</button>
      </div>
    </form>
  </div>
</div>

@endsection
