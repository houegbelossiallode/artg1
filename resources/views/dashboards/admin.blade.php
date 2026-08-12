@extends('layouts.dashboard')

@section('title', 'Administration | AssoCulture')

@section('content')
  <div class="w-full flex flex-col gap-6" x-data="{ showProfModal: false, showTalentModal: false, showCatModal: false }">

    {{-- HEADER & NOTIFICATIONS --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 pb-4 border-b border-slate-200">
      <div>
        <h1 class="admin-title">Tableau de Bord Administratif</h1>
        <p class="admin-subtitle">Association Culturelle & Artistique • Musique & Artisanat du Raphia</p>
      </div>
      <div class="flex flex-wrap items-center gap-3">
        <div
          class="text-xs text-slate-500 font-medium bg-white px-3 py-1.5 border border-slate-200 flex items-center gap-2">
          <span class="w-1.5 h-1.5 bg-emerald-500 block"></span> Dernière synchro: Aujourd'hui, 13:24
        </div>
        <button
          class="relative p-2 bg-white border border-slate-200 text-slate-500 hover:text-slate-900 transition-colors">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
          </svg>
          <span
            class="absolute top-0 right-0 w-4 h-4 bg-[#0BA20B] text-white text-[9px] font-bold flex items-center justify-center -mt-1 -mr-1">2</span>
        </button>
        <button @click="showProfModal = true"
          class="bg-[#0BA20B] text-white px-4 py-2 text-sm font-bold hover:bg-[#087A08] transition-colors flex items-center gap-2 border border-[#0BA20B]">
          <span>+</span> Créer un compte
        </button>
      </div>
    </div>

    {{-- METRIC CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
      {{-- Card 1 --}}
      <div class="bg-white border border-slate-200 p-4">
        <div class="flex justify-between items-start mb-2">
          <div>
            <p class="text-[11px] font-bold text-slate-500 uppercase tracking-widest font-sans mb-1">Membres Inscrits</p>
            <h3 class="text-3xl font-normal text-slate-900 font-sans tracking-tighter">{{ $totalUsers ?? 0 }}</h3>
          </div>
          <div class="p-1.5 bg-orange-50 text-[#0BA20B] border border-orange-100">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0" />
            </svg>
          </div>
        </div>
        <div class="flex items-center gap-2 mt-[18px]">
          <span
            class="text-[10px] font-bold text-emerald-600 bg-emerald-50 border border-emerald-100 px-1.5 py-0.5">+14.2%</span>
          <span class="text-[10px] text-slate-400 font-medium">vs mois dernier</span>
        </div>
      </div>

      {{-- Card 2 --}}
      <div class="bg-white border border-slate-200 p-4">
        <div class="flex justify-between items-start mb-2">
          <div>
            <p class="text-[11px] font-bold text-slate-500 uppercase tracking-widest font-sans mb-1">Professeurs Actifs
            </p>
            <h3 class="text-3xl font-normal text-slate-900 font-sans tracking-tighter">{{ $totalProfesseurs ?? 0 }}</h3>
          </div>
          <div class="p-1.5 bg-amber-50 text-amber-600 border border-amber-100">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
          </div>
        </div>
        <div class="flex items-center gap-2 mt-[18px]">
          <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 border border-emerald-100 px-1.5 py-0.5">+8
            nouv.</span>
          <span class="text-[10px] text-slate-400 font-medium">cette semaine</span>
        </div>
      </div>

      {{-- Card 3 --}}
      <div class="bg-white border border-slate-200 p-4">
        <div class="flex justify-between items-start mb-2">
          <div>
            <p class="text-[11px] font-bold text-slate-500 uppercase tracking-widest font-sans mb-1">Jeunes Talents</p>
            <h3 class="text-3xl font-normal text-slate-900 font-sans tracking-tighter">{{ $totalTalents ?? 0 }}</h3>
          </div>
          <div class="p-1.5 bg-purple-50 text-purple-600 border border-purple-100">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
            </svg>
          </div>
        </div>
        <div class="flex items-center gap-2 mt-[18px]">
          <span
            class="text-[10px] font-bold text-emerald-600 bg-emerald-50 border border-emerald-100 px-1.5 py-0.5">+22.5%</span>
          <span class="text-[10px] text-slate-400 font-medium">saison 2026</span>
        </div>
      </div>

      {{-- Card 4 --}}
      <div class="bg-white border border-slate-200 p-4">
        <div class="flex justify-between items-start mb-2">
          <div>
            <p class="text-[11px] font-bold text-slate-500 uppercase tracking-widest font-sans mb-1">Catégories Val.</p>
            <h3 class="text-3xl font-normal text-slate-900 font-sans tracking-tighter">
              {{ isset($categorieTalents) ? $categorieTalents->count() : 0 }}</h3>
          </div>
          <div class="p-1.5 bg-emerald-50 text-emerald-600 border border-emerald-100">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
            </svg>
          </div>
        </div>
        <div class="flex items-center gap-2 mt-[18px]">
          <span
            class="text-[10px] font-bold text-emerald-600 bg-emerald-50 border border-emerald-100 px-1.5 py-0.5">Objectif
            atteint</span>
        </div>
      </div>
    </div>

    {{-- MAIN GRID: 2 COLUMNS --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-2">

      {{-- Left Side: Table --}}
      <div class="lg:col-span-2 flex flex-col gap-4">
        <div class="bg-white border border-slate-200 p-6 shadow-sm">
          <div class="flex justify-between items-start mb-6">
            <div class="flex items-center gap-2">
              <span class="w-2 h-2 bg-[#0BA20B] block"></span>
              <div>
                <h2 class="text-lg font-bold text-slate-900 font-sans tracking-tight">Membres & Inscriptions</h2>
                <p class="text-xs text-slate-500 font-medium mt-0.5">Registre des membres récents et statuts</p>
              </div>
            </div>
            <div class="flex gap-2">
              <button @click="showCatModal = true"
                class="text-xs font-bold text-slate-600 bg-white border border-slate-200 px-3 py-1.5 hover:bg-slate-50 transition-colors flex items-center gap-1">
                <span>+</span> Catégorie
              </button>
              <button @click="showTalentModal = true"
                class="text-xs font-bold text-[#0BA20B] bg-orange-50 border border-orange-100 px-3 py-1.5 hover:bg-orange-100 transition-colors flex items-center gap-1">
                <span>+</span> Talent
              </button>
            </div>
          </div>

          

          {{-- Table --}}
          <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
              <thead>
                <tr class="border-b border-slate-200">
                  <th
                    class="py-3 px-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest bg-slate-50 border-y border-slate-200">
                    MEMBRE & INFOS</th>
                  <th
                    class="py-3 px-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest bg-slate-50 border-y border-slate-200">
                    RÔLE</th>
                  <th
                    class="py-3 px-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-right bg-slate-50 border-y border-slate-200">
                    ACTIONS</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100">
                @forelse ($recentUsers as $userItem)
                  <tr class="hover:bg-slate-50 transition-colors">
                    <td class="py-4 px-4">
                      <p class="text-sm font-bold text-slate-900">{{ $userItem->prenom }} {{ $userItem->nom }}</p>
                      <p class="text-xs text-slate-500 font-medium">{{ $userItem->email }}</p>
                    </td>
                    <td class="py-4 px-4">
                      <div class="flex items-center gap-2">
                        @if($userItem->profil)
                          @if($userItem->profil->nom === 'administrateur')
                            <span
                              class="bg-slate-900 text-white text-[9px] font-bold px-2 py-0.5 uppercase tracking-widest border border-slate-900">Admin</span>
                          @elseif($userItem->profil->nom === 'professeur')
                            <span
                              class="bg-blue-50 text-blue-700 border border-blue-200 text-[9px] font-bold px-2 py-0.5 uppercase tracking-widest">Professeur</span>
                          @else
                            <span
                              class="bg-slate-100 text-slate-600 border border-slate-200 text-[9px] font-bold px-2 py-0.5 uppercase tracking-widest">Apprenant</span>
                          @endif
                        @endif

                      </div>
                    </td>
                    <td class="py-4 px-4 text-right">
                      <button
                        class="text-slate-400 hover:text-[#0BA20B] transition-colors p-1.5 border border-transparent hover:border-slate-200 bg-white shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                      </button>
                      <button
                        class="text-slate-400 hover:text-red-500 transition-colors p-1.5 border border-transparent hover:border-slate-200 bg-white shadow-sm ml-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                      </button>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="3" class="py-8 text-center text-sm text-slate-500 font-medium">Aucun membre récent.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>

      {{-- Right Side: Alertes & Moderation --}}
      <div class="lg:col-span-1 flex flex-col gap-4">
        <div class="bg-white border border-slate-200 p-6 shadow-sm">
          <div class="flex justify-between items-center mb-6">
            <div class="flex items-center gap-2">
              <svg class="w-4 h-4 text-[#0BA20B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
              </svg>
              <h2 class="text-base font-bold text-slate-900">Alertes & Modération</h2>
            </div>
            <span class="text-[10px] font-bold text-[#0BA20B] bg-orange-50 border border-orange-100 px-2 py-0.5">3
              Action(s)</span>
          </div>

          {{-- Tabs --}}
          <div class="flex w-full mb-6 border border-slate-200 p-1 bg-slate-50">
            <button class="flex-1 bg-white border border-slate-200 text-slate-900 text-xs font-bold py-2 shadow-sm">Jeunes
              Talents</button>
            <button
              class="flex-1 text-slate-500 text-xs font-medium py-2 hover:bg-slate-100 transition-colors">Professeurs</button>
          </div>

          {{-- Content List --}}
          <div class="flex flex-col gap-4">
            <div
              class="border border-slate-200 p-4 relative group hover:border-[#0BA20B] transition-colors cursor-pointer bg-white">
              <div class="absolute right-4 top-4">
                <span class="w-2 h-2 bg-[#0BA20B] block"></span>
              </div>
              <div class="flex items-center gap-3 mb-3">
                <div
                  class="w-8 h-8 bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-700 font-bold text-xs">
                  JT
                </div>
                <div>
                  <p class="text-sm font-bold text-slate-900">Demande d'inscription</p>
                  <p class="text-[11px] text-slate-500 font-medium">Nouveau Jeune Talent</p>
                </div>
              </div>
              <p class="text-xs text-slate-600 font-medium leading-relaxed">
                Un nouveau dossier de candidature a été soumis par un jeune artiste. En attente de validation par la
                direction artistique.
              </p>
              <div
                class="mt-4 flex justify-between items-center text-[10px] text-slate-400 font-bold uppercase tracking-widest">
                <span>Aujourd'hui, 10:15</span>
                <span class="text-[#0BA20B] group-hover:translate-x-1 transition-transform">Examiner &rarr;</span>
              </div>
            </div>

            <div
              class="border border-slate-200 p-4 relative group hover:border-slate-400 transition-colors cursor-pointer bg-slate-50 opacity-75">
              <div class="flex items-center gap-3 mb-3">
                <div
                  class="w-8 h-8 bg-white border border-slate-200 flex items-center justify-center text-slate-400 font-bold text-xs">
                  RP
                </div>
                <div>
                  <p class="text-sm font-bold text-slate-900">Mise à jour profil</p>
                  <p class="text-[11px] text-slate-500 font-medium">Professeur de Raphia</p>
                </div>
              </div>
              <div
                class="mt-2 flex justify-between items-center text-[10px] text-slate-400 font-bold uppercase tracking-widest">
                <span>Hier, 14:20</span>
                <span class="text-slate-500">Traité</span>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

    {{-- ══════════════════════ MODALS ══════════════════════ --}}

    {{-- MODAL : Nouveau Professeur --}}
    <div x-show="showProfModal"
      class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm" x-cloak
      style="display:none;">
      <div @click.away="showProfModal = false"
        class="bg-white w-full max-w-lg shadow-2xl border border-slate-200 max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center px-6 py-4 border-b border-slate-200 bg-slate-50">
          <div>
            <h3 class="font-bold text-slate-900 text-sm uppercase tracking-wide">Enregistrer un Professeur</h3>
            <p class="text-[11px] text-slate-400 mt-0.5">Corps enseignant · Arts & Culture</p>
          </div>
          <button @click="showProfModal = false"
            class="w-8 h-8 border border-slate-300 bg-white flex items-center justify-center text-slate-500 hover:text-slate-900 hover:bg-slate-100 transition-colors text-lg font-bold leading-none">&times;</button>
        </div>
        <form action="{{ route('dashboard.admin.professeurs.store') }}" method="POST" class="p-6 space-y-4">
          @csrf
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Nom</label>
              <input type="text" name="nom" required
                class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm font-medium focus:outline-none focus:border-slate-900 transition"
                placeholder="Nom de famille">
            </div>
            <div>
              <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Prénom</label>
              <input type="text" name="prenom" required
                class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm font-medium focus:outline-none focus:border-slate-900 transition"
                placeholder="Prénom">
            </div>
          </div>
          <div>
            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Email</label>
            <input type="email" name="email" required
              class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm font-medium focus:outline-none focus:border-slate-900 transition"
              placeholder="professeur@assoculture.com">
          </div>
          <div>
            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Mot de
              passe</label>
            <input type="password" name="password" required
              class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm font-medium focus:outline-none focus:border-slate-900 transition"
              placeholder="Minimum 8 caractères">
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Genre</label>
              <select name="sexe" required
                class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm font-medium focus:outline-none focus:border-slate-900 transition">
                <option value="M">Masculin</option>
                <option value="F">Féminin</option>
              </select>
            </div>
            <div>
              <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Date de
                Naissance</label>
              <input type="date" name="date_naissance" required
                class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm font-medium focus:outline-none focus:border-slate-900 transition">
            </div>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Téléphone</label>
              <input type="tel" name="telephone" required
                class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm font-medium focus:outline-none focus:border-slate-900 transition"
                placeholder="+229 00 00 00 00">
            </div>
            <div>
              <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Adresse</label>
              <input type="text" name="adresse" required
                class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm font-medium focus:outline-none focus:border-slate-900 transition"
                placeholder="Ville / Commune">
            </div>
          </div>
          <div class="flex justify-end gap-3 pt-3 border-t border-slate-200 mt-4">
            <button type="button" @click="showProfModal = false"
              class="px-4 py-2 text-xs font-bold uppercase tracking-wider text-slate-500 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 transition border border-transparent">Annuler</button>
            <button type="submit"
              class="px-5 py-2 bg-[#0BA20B] hover:bg-[#087A08] text-white font-bold text-xs uppercase tracking-widest transition border border-[#0BA20B]">Créer
              Professeur</button>
          </div>
        </form>
      </div>
    </div>

    {{-- MODAL : Nouveau Talent --}}
    <div x-show="showTalentModal"
      class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm" x-cloak
      style="display:none;">
      <div @click.away="showTalentModal = false"
        class="bg-white w-full max-w-lg shadow-2xl border border-slate-200 max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center px-6 py-4 border-b border-slate-200 bg-slate-50">
          <div>
            <h3 class="font-bold text-slate-900 text-sm uppercase tracking-wide">Enregistrer un Jeune Talent</h3>
            <p class="text-[11px] text-slate-400 mt-0.5">Vitrine artistique de l'association</p>
          </div>
          <button @click="showTalentModal = false"
            class="w-8 h-8 border border-slate-300 bg-white flex items-center justify-center text-slate-500 hover:text-slate-900 hover:bg-slate-100 transition-colors text-lg font-bold leading-none">&times;</button>
        </div>
        <form action="{{ route('dashboard.admin.talents.store') }}" method="POST" enctype="multipart/form-data"
          class="p-6 space-y-4">
          @csrf
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Nom</label>
              <input type="text" name="nom" required
                class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm font-medium focus:outline-none focus:border-slate-900 transition">
            </div>
            <div>
              <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Prénom</label>
              <input type="text" name="prenom" required
                class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm font-medium focus:outline-none focus:border-slate-900 transition">
            </div>
          </div>
          <div>
            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Catégorie de
              Talent</label>
            <select name="categorie_talent_id" required
              class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm font-medium focus:outline-none focus:border-slate-900 transition">
              <option value="">Sélectionner une catégorie</option>
              @foreach($categorieTalents as $catT)
                <option value="{{ $catT->id }}">{{ $catT->libelle }}</option>
              @endforeach
            </select>
          </div>
          <div>
            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Biographie /
              Œuvre</label>
            <textarea name="biographie" rows="3"
              class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm font-medium focus:outline-none focus:border-slate-900 transition"
              placeholder="Parcours artistique, œuvres..."></textarea>
          </div>
          <div class="flex justify-end gap-3 pt-3 border-t border-slate-200 mt-4">
            <button type="button" @click="showTalentModal = false"
              class="px-4 py-2 text-xs font-bold uppercase tracking-wider text-slate-500 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 transition border border-transparent">Annuler</button>
            <button type="submit"
              class="px-5 py-2 bg-[#0BA20B] hover:bg-[#087A08] text-white font-bold text-xs uppercase tracking-widest transition border border-[#0BA20B]">Créer
              Talent</button>
          </div>
        </form>
      </div>
    </div>

    {{-- MODAL : Nouvelle Catégorie --}}
    <div x-show="showCatModal" x-data="{ catType: 'cours' }"
      class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm" x-cloak
      style="display:none;">
      <div @click.away="showCatModal = false" class="bg-white w-full max-w-md shadow-2xl border border-slate-200">
        <div class="flex justify-between items-center px-6 py-4 border-b border-slate-200 bg-slate-50">
          <div>
            <h3 class="font-bold text-slate-900 text-sm uppercase tracking-wide">Ajouter une Catégorie</h3>
            <p class="text-[11px] text-slate-400 mt-0.5">Cours, événements ou talents artistiques</p>
          </div>
          <button @click="showCatModal = false"
            class="w-8 h-8 border border-slate-300 bg-white flex items-center justify-center text-slate-500 hover:text-slate-900 hover:bg-slate-100 transition-colors text-lg font-bold leading-none">&times;</button>
        </div>
        <form
          :action="catType === 'cours' ? '{{ route('dashboard.admin.categories-cours.store') }}' : (catType === 'evenement' ? '{{ route('dashboard.admin.categories-evenements.store') }}' : '{{ route('dashboard.admin.categories-talents.store') }}')"
          method="POST" class="p-6 space-y-4">
          @csrf
          <div>
            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Type de
              Catégorie</label>
            <select x-model="catType" name="type" required
              class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm font-medium focus:outline-none focus:border-slate-900 transition">
              <option value="cours">Catégorie de Cours</option>
              <option value="evenement">Catégorie d'Événements</option>
              <option value="talent">Catégorie de Talents</option>
            </select>
          </div>
          <div>
            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Intitulé /
              Nom</label>
            <input type="text" name="nom" required
              class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm font-medium focus:outline-none focus:border-slate-900 transition"
              placeholder="Ex: Musique Traditionnelle...">
          </div>
          <div x-show="catType === 'cours'">
            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Description
              (optionnelle)</label>
            <textarea name="description" rows="2"
              class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm font-medium focus:outline-none focus:border-slate-900 transition"
              placeholder="Description brève de cette catégorie..."></textarea>
          </div>
          <div class="flex justify-end gap-3 pt-3 border-t border-slate-200 mt-4">
            <button type="button" @click="showCatModal = false"
              class="px-4 py-2 text-xs font-bold uppercase tracking-wider text-slate-500 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 transition border border-transparent">Annuler</button>
            <button type="submit"
              class="px-5 py-2 bg-[#0BA20B] hover:bg-[#087A08] text-white font-bold text-xs uppercase tracking-widest transition border border-[#0BA20B]">Enregistrer</button>
          </div>
        </form>
      </div>
    </div>

  </div>
@endsection