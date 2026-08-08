@extends('layouts.dashboard')

@section('title', 'Tableau de bord Professeur')

@section('content')
<div class="w-full flex flex-col gap-5">

  {{-- ═══════════════════════ PAGE HEADER ═══════════════════════ --}}
  <x-dashboard.page-header title="Bienvenue, {{ Auth::user()->name }}" description="Vue d'ensemble de votre activité pédagogique et suivi de vos élèves." />
  <div class="flex items-center gap-2">
    <a href="{{ route('dashboard.professeur.disponibilites.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-[10px] uppercase tracking-widest transition shadow-sm">
      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
      Disponibilités
    </a>
  </div> {{-- ═══════════════════════ CARTES MÉTRIQUES ═══════════════════════ --}}
  <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

    {{-- Carte 1 : Élèves --}}
    <div class="bg-white border border-slate-200 shadow-sm p-3.5 border-l-4 border-l-[#C85A32] flex flex-col gap-2.5">
      <div class="flex items-center justify-between">
        <div class="w-7 h-7 bg-[#C85A32]/10 flex items-center justify-center">
          <svg class="w-3.5 h-3.5 text-[#C85A32]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
        </div>
        <span class="text-[8px] font-bold text-[#C85A32] border border-[#C85A32]/40 px-1.5 py-0.5 uppercase tracking-widest">GLOBAL</span>
      </div>
      <div class="flex items-end justify-between">
        <div>
          <p class="text-[8px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">TOTAL ÉLÈVES</p>
          <span class="text-2xl font-normal text-slate-900">{{ $eleveCount ?? 0 }}</span>
        </div>
        <svg class="w-8 h-6 text-slate-300" viewBox="0 0 40 30" fill="currentColor">
          <rect x="0" y="20" width="6" height="10"/>
          <rect x="9" y="14" width="6" height="16"/>
          <rect x="18" y="8" width="6" height="22"/>
          <rect x="27" y="4" width="6" height="26"/>
          <rect x="34" y="10" width="6" height="20"/>
        </svg>
      </div>
    </div>

    {{-- Carte 2 : Cours --}}
    <div class="bg-white border border-slate-200 shadow-sm p-3.5 border-l-4 border-l-blue-500 flex flex-col gap-2.5">
      <div class="flex items-center justify-between">
        <div class="w-7 h-7 bg-blue-100/50 flex items-center justify-center">
          <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <span class="text-[8px] font-bold text-blue-500 border border-blue-300 px-1.5 py-0.5 uppercase tracking-widest">SEMAINE</span>
      </div>
      <div class="flex items-end justify-between">
        <div>
          <p class="text-[8px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">COURS DISPENSÉS</p>
          <span class="text-2xl font-normal text-slate-900">{{ $coursCount ?? 0 }}</span>
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

    {{-- Carte 3 : Réservations --}}
    <div class="bg-white border border-slate-200 shadow-sm p-3.5 border-l-4 border-l-amber-500 flex flex-col gap-2.5">
      <div class="flex items-center justify-between">
        <div class="w-7 h-7 bg-amber-100/50 flex items-center justify-center">
          <svg class="w-3.5 h-3.5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
        </div>
        <span class="text-[8px] font-bold text-amber-500 border border-amber-300 px-1.5 py-0.5 uppercase tracking-widest">EN COURS</span>
      </div>
      <div class="flex items-end justify-between">
        <div>
          <p class="text-[8px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">RÉSERVATIONS</p>
          <span class="text-2xl font-normal text-slate-900">{{ $reservationCount ?? 0 }}</span>
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

    {{-- Carte 4 : Nouveautés --}}
    <div class="bg-white border border-slate-200 shadow-sm p-3.5 border-l-4 border-l-green-500 flex flex-col gap-2.5">
      <div class="flex items-center justify-between">
        <div class="w-7 h-7 bg-green-100/50 flex items-center justify-center">
          <svg class="w-3.5 h-3.5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
        </div>
        <span class="text-[8px] font-bold text-green-500 border border-green-300 px-1.5 py-0.5 uppercase tracking-widest">NOUVEAU</span>
      </div>
      <div class="flex items-end justify-between">
        <div>
          <p class="text-[8px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">NOTIFICATIONS</p>
          <span class="text-2xl font-normal text-slate-900">0</span>
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

  {{-- ═══════════════════════ NAVIGATION RAPIDE ═══════════════════════ --}}
  <div class="grid grid-cols-1 xl:grid-cols-4 gap-4">

    {{-- ACTIONS (span 3) --}}
    <div class="xl:col-span-3 bg-white border border-slate-200 shadow-sm">
      <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
        <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wide">ACTIONS RAPIDES</h2>
      </div>
      
      <div class="divide-y divide-slate-100 p-6 grid grid-cols-1 md:grid-cols-4 gap-6">
        <a href="{{ route('dashboard.professeur.cours.index') }}" class="block bg-white border border-slate-200 rounded-sm shadow-sm hover:shadow-md transition p-6 text-center group">
          <div class="w-12 h-12 bg-indigo-50 border border-indigo-200 rounded-full flex items-center justify-center mx-auto mb-3 group-hover:bg-indigo-600 transition-colors">
            <svg class="w-5 h-5 text-indigo-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
          </div>
          <h3 class="text-sm font-bold text-slate-800 uppercase tracking-widest group-hover:text-slate-900">Mes Cours</h3>
        </a>
        <a href="{{ route('dashboard.professeur.eleves') }}" class="block bg-white border border-slate-200 rounded-sm shadow-sm hover:shadow-md transition p-6 text-center group">
          <div class="w-12 h-12 bg-[#C85A32]/10 border border-[#C85A32]/30 rounded-full flex items-center justify-center mx-auto mb-3 group-hover:bg-[#C85A32] transition-colors">
            <svg class="w-5 h-5 text-[#C85A32] group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
          </div>
          <h3 class="text-sm font-bold text-slate-800 uppercase tracking-widest group-hover:text-slate-900">Liste des Élèves</h3>
        </a>
        <a href="{{ route('dashboard.professeur.supports.index') }}" class="block bg-white border border-slate-200 rounded-sm shadow-sm hover:shadow-md transition p-6 text-center group">
          <div class="w-12 h-12 bg-blue-50 border border-blue-200 rounded-full flex items-center justify-center mx-auto mb-3 group-hover:bg-blue-500 transition-colors">
            <svg class="w-5 h-5 text-blue-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
          </div>
          <h3 class="text-sm font-bold text-slate-800 uppercase tracking-widest group-hover:text-slate-900">Supports de Cours</h3>
        </a>
        <a href="{{ route('dashboard.professeur.reservations') }}" class="block bg-white border border-slate-200 rounded-sm shadow-sm hover:shadow-md transition p-6 text-center group">
          <div class="w-12 h-12 bg-amber-50 border border-amber-200 rounded-full flex items-center justify-center mx-auto mb-3 group-hover:bg-amber-500 transition-colors">
            <svg class="w-5 h-5 text-amber-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
          </div>
          <h3 class="text-sm font-bold text-slate-800 uppercase tracking-widest group-hover:text-slate-900">Réservations</h3>
        </a>
      </div>
    </div>


{{-- Tableau des Élèves déplacé vers sa propre page --}}

    {{-- PANNEAU LATÉRAL --}}
    <div class="xl:col-span-1 flex flex-col gap-4">
      <div class="bg-white border border-slate-200 shadow-sm flex-1">
        <div class="px-5 py-3.5 border-b border-slate-200">
          <h2 class="text-xs font-bold text-slate-900 uppercase tracking-widest">Aujourd'hui</h2>
        </div>
        
        <div class="p-5">
          <div class="relative border-l border-slate-200 ml-2 space-y-6">
            
            <div class="relative pl-5 group cursor-default">
              <div class="absolute -left-[5px] top-1.5 w-2.5 h-2.5 rounded-full bg-emerald-500 border-2 border-white shadow-[0_0_6px_rgba(16,185,129,0.6)] group-hover:bg-emerald-400 transition-colors"></div>
              <span class="text-[9px] font-bold uppercase tracking-widest text-slate-400 block mb-0.5">10:00 - 12:00</span>
              <h4 class="font-bold text-sm text-slate-900">Harmonie</h4>
              <p class="text-[10px] text-slate-500 mt-0.5">Salle Ravel</p>
            </div>
            
            <div class="relative pl-5 group cursor-default">
              <div class="absolute -left-[5px] top-1.5 w-2.5 h-2.5 rounded-full bg-slate-300 border-2 border-white"></div>
              <span class="text-[9px] font-bold uppercase tracking-widest text-slate-400 block mb-0.5">14:00 - 15:00</span>
              <h4 class="font-bold text-sm text-slate-400">Pause Déjeuner</h4>
            </div>

            <div class="relative pl-5 group cursor-default">
              <div class="absolute -left-[5px] top-1.5 w-2.5 h-2.5 rounded-full bg-emerald-500 border-2 border-white"></div>
              <span class="text-[9px] font-bold uppercase tracking-widest text-emerald-500 block mb-0.5">16:00 - 18:00</span>
              <h4 class="font-bold text-sm text-slate-900">Piano Avancé</h4>
              <p class="text-[10px] text-slate-500 mt-0.5">Masterclass (12p)</p>
            </div>

          </div>
        </div>
      </div>

    </div>
  </div>

</div>
@endsection
