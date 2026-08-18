@extends('layouts.app')
@section('title', 'Écho & Culture — Jeunes Talents')

@section('content')
<section class="pt-32 pb-24 bg-[#FAF7F2] relative overflow-hidden" id="talents">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
<div class="text-center max-w-3xl mx-auto space-y-4">
<div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-none bg-[#F4EFE6] border border-[#0BA20B]/40 text-[#0BA20B] text-xs font-bold uppercase tracking-widest">
<svg aria-hidden="true" class="lucide lucide-radio w-3.5 h-3.5 animate-pulse" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="M16.247 7.761a6 6 0 0 1 0 8.478">
</path>
<path d="M19.075 4.933a10 10 0 0 1 0 14.134">
</path>
<path d="M4.925 19.067a10 10 0 0 1 0-14.134">
</path>
<path d="M7.753 16.239a6 6 0 0 1 0-8.478">
</path>
<circle cx="12" cy="12" r="2">
</circle>
</svg>
<span>
      Promotion &amp; Tremplin Artistique
     </span>
</div>
<h2 class="font-serif-title text-3xl sm:text-4xl md:text-5xl font-bold text-[#2C221E] tracking-tight">
     Accompagner la Jeunesse &amp; Révéler les Talents
    </h2>
<p class="text-sm sm:text-base text-[#6B574F] font-sans leading-relaxed">
     Notre association offre aux jeunes musiciens, chanteurs et artisans un studio d'enregistrement, un accompagnement personnalisé et des scènes publiques pour propulser leurs créations.
    </p>
</div>
@php $talentDuMois = $talents->first(); @endphp
@if($talentDuMois)
<div class="bg-[#1E1613] rounded-none overflow-hidden shadow-2xl border border-[#0BA20B]/40 grid grid-cols-1 lg:grid-cols-12 text-[#FAF7F2]">
<div class="lg:col-span-5 relative min-h-[350px]">
@if($talentDuMois->photo)
    <img alt="{{ trim($talentDuMois->prenom . ' ' . $talentDuMois->nom) }}" class="absolute inset-0 w-full h-full object-cover" referrerpolicy="no-referrer" src="{{ asset('storage/' . $talentDuMois->photo) }}"/>
@else
    <div class="absolute inset-0 w-full h-full bg-[#2C221E] flex items-center justify-center text-[#0BA20B] text-6xl font-bold">
        {{ strtoupper(substr($talentDuMois->prenom, 0, 1)) }}{{ strtoupper(substr($talentDuMois->nom, 0, 1)) }}
    </div>
@endif
<div class="absolute inset-0 bg-gradient-to-t from-[#1E1613] via-[#1E1613]/40 to-transparent">
</div>
<div class="absolute bottom-6 left-6 right-6 glass-dark p-4 rounded-none border border-white/20 space-y-3">
<div class="flex items-center justify-between">
<div class="flex items-center gap-2">
<svg aria-hidden="true" class="lucide lucide-disc w-5 h-5 text-[#0BA20B]" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<circle cx="12" cy="12" r="10">
</circle>
<circle cx="12" cy="12" r="2">
</circle>
</svg>
<div>
<span class="text-[10px] uppercase font-bold text-[#0BA20B]">
          Extrait Audio Enregistré
         </span>
<h5 class="text-xs font-bold text-white line-clamp-1">
          Écho du Fleuve (Extrait Live Session)
         </h5>
</div>
</div>
<button aria-label="Play sample" class="w-10 h-10 rounded-none bg-[#0BA20B] hover:bg-[#087A08] text-white flex items-center justify-center shadow-lg transition-transform hover:scale-105">
<svg aria-hidden="true" class="lucide lucide-play w-5 h-5 ml-0.5" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="M5 5a2 2 0 0 1 3.008-1.728l11.997 6.998a2 2 0 0 1 .003 3.458l-12 7A2 2 0 0 1 5 19z">
</path>
</svg>
</button>
</div>
<div class="flex items-center gap-1 h-6 pt-1">
<div class="flex-1 rounded-none transition-all duration-300 bg-white/30" style="height: 30%;">
</div>
<div class="flex-1 rounded-none transition-all duration-300 bg-white/30" style="height: 30%;">
</div>
<div class="flex-1 rounded-none transition-all duration-300 bg-white/30" style="height: 30%;">
</div>
<div class="flex-1 rounded-none transition-all duration-300 bg-white/30" style="height: 30%;">
</div>
<div class="flex-1 rounded-none transition-all duration-300 bg-white/30" style="height: 30%;">
</div>
<div class="flex-1 rounded-none transition-all duration-300 bg-white/30" style="height: 30%;">
</div>
<div class="flex-1 rounded-none transition-all duration-300 bg-white/30" style="height: 30%;">
</div>
<div class="flex-1 rounded-none transition-all duration-300 bg-white/30" style="height: 30%;">
</div>
<div class="flex-1 rounded-none transition-all duration-300 bg-white/30" style="height: 30%;">
</div>
<div class="flex-1 rounded-none transition-all duration-300 bg-white/30" style="height: 30%;">
</div>
<div class="flex-1 rounded-none transition-all duration-300 bg-white/30" style="height: 30%;">
</div>
<div class="flex-1 rounded-none transition-all duration-300 bg-white/30" style="height: 30%;">
</div>
<div class="flex-1 rounded-none transition-all duration-300 bg-white/30" style="height: 30%;">
</div>
<div class="flex-1 rounded-none transition-all duration-300 bg-white/30" style="height: 30%;">
</div>
<div class="flex-1 rounded-none transition-all duration-300 bg-white/30" style="height: 30%;">
</div>
<div class="flex-1 rounded-none transition-all duration-300 bg-white/30" style="height: 30%;">
</div>
<div class="flex-1 rounded-none transition-all duration-300 bg-white/30" style="height: 30%;">
</div>
<div class="flex-1 rounded-none transition-all duration-300 bg-white/30" style="height: 30%;">
</div>
<div class="flex-1 rounded-none transition-all duration-300 bg-white/30" style="height: 30%;">
</div>
<div class="flex-1 rounded-none transition-all duration-300 bg-white/30" style="height: 30%;">
</div>
</div>
</div>
</div>
<div class="lg:col-span-7 p-8 sm:p-12 space-y-6 flex flex-col justify-between">
<div class="space-y-4">
<div class="flex items-center justify-between">
<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-none bg-[#0BA20B]/20 border border-[#0BA20B]/40 text-[#0BA20B] text-xs font-bold uppercase">
<svg aria-hidden="true" class="lucide lucide-sparkles w-3.5 h-3.5" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z">
</path>
<path d="M20 2v4">
</path>
<path d="M22 4h-4">
</path>
<circle cx="4" cy="20" r="2">
</circle>
</svg>
<span>
         Talent du Mois
        </span>
</span>
<span class="text-xs text-white/60 font-sans">
        {{ $talentDuMois->categorie ? $talentDuMois->categorie->libelle : 'Artiste' }}
       </span>
</div>
<div>
<h3 class="font-serif-title text-3xl sm:text-4xl font-bold text-white">
        {{ $talentDuMois->prenom }} {{ $talentDuMois->nom }}
</h3>
<p class="text-xs sm:text-sm text-[#D1C5B8] mt-2 font-sans leading-relaxed">
        {{ $talentDuMois->biographie ?? 'Une nouvelle voix passionnante accompagnée par notre association.' }}
       </p>
</div>
<div class="space-y-2 pt-2">
<h4 class="text-xs font-bold uppercase text-[#0BA20B] tracking-wider">
        Réalisations &amp; Parcours :
       </h4>
<ul class="space-y-1.5 text-xs text-white/90 font-sans">
<li class="flex items-center gap-2">
<svg aria-hidden="true" class="lucide lucide-award w-3.5 h-3.5 text-[#0BA20B] shrink-0" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="m15.477 12.89 1.515 8.526a.5.5 0 0 1-.81.47l-3.58-2.687a1 1 0 0 0-1.197 0l-3.586 2.686a.5.5 0 0 1-.81-.469l1.514-8.526">
</path>
<circle cx="12" cy="8" r="6">
</circle>
</svg>
<span>
          Lauréat du Prix Révélation Culturelle 2025
         </span>
</li>
<li class="flex items-center gap-2">
<svg aria-hidden="true" class="lucide lucide-award w-3.5 h-3.5 text-[#0BA20B] shrink-0" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="m15.477 12.89 1.515 8.526a.5.5 0 0 1-.81.47l-3.58-2.687a1 1 0 0 0-1.197 0l-3.586 2.686a.5.5 0 0 1-.81-.469l1.514-8.526">
</path>
<circle cx="12" cy="8" r="6">
</circle>
</svg>
<span>
          Plus de 45 000 écoutes sur les plateformes
         </span>
</li>
<li class="flex items-center gap-2">
<svg aria-hidden="true" class="lucide lucide-award w-3.5 h-3.5 text-[#0BA20B] shrink-0" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="m15.477 12.89 1.515 8.526a.5.5 0 0 1-.81.47l-3.58-2.687a1 1 0 0 0-1.197 0l-3.586 2.686a.5.5 0 0 1-.81-.469l1.514-8.526">
</path>
<circle cx="12" cy="8" r="6">
</circle>
</svg>
<span>
          Membre actif des ateliers de transmission pour enfants
         </span>
</li>
</ul>
</div>
</div>
<div class="pt-6 border-t border-white/10 flex flex-wrap items-center justify-between gap-4">
<div class="text-xs text-white/70">
       Suivre :
       <span class="text-[#0BA20B] font-semibold">
        {{ '@' . strtolower($talentDuMois->prenom) }}_{{ strtolower($talentDuMois->nom) }}
       </span>
</div>
<button onclick="document.getElementById('candidature-modal').classList.remove('hidden')" class="px-5 py-2.5 rounded-none bg-[#0BA20B] hover:bg-[#087A08] text-white font-bold text-xs shadow-lg transition-transform hover:scale-105 flex items-center gap-2">
<svg aria-hidden="true" class="lucide lucide-user-plus w-4 h-4" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2">
</path>
<circle cx="9" cy="7" r="4">
</circle>
<line x1="19" x2="19" y1="8" y2="14">
</line>
<line x1="22" x2="16" y1="11" y2="11">
</line>
</svg>
<span>
        Rejoindre le Programme Jeunes Talents
       </span>
</button>
</div>
</div>
</div>
@endif
<div class="space-y-6 pt-6">
<h3 class="font-serif-title text-2xl font-bold text-[#2C221E]">
     Galerie des Artistes Émergents
    </h3>
<div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
    @forelse($talents as $talent)
    <a href="{{ route('talents.show', $talent->id) }}" class="block bg-white rounded-none p-5 border transition-all duration-300 space-y-4 hover:shadow-xl {{ $loop->first ? 'border-[#0BA20B] ring-2 ring-[#0BA20B]/20 shadow-md' : 'border-[#0BA20B]/30 hover:border-[#0BA20B]' }}">
        <div class="flex items-center gap-4">
            @if($talent->photo)
                <img alt="{{ trim($talent->prenom . ' ' . $talent->nom) }}" class="w-16 h-16 rounded-none object-cover ring-2 ring-[#0BA20B]/40" referrerpolicy="no-referrer" src="{{ asset('storage/' . $talent->photo) }}"/>
            @else
                <div class="w-16 h-16 rounded-none bg-[#F4EFE6] flex items-center justify-center text-[#0BA20B] font-bold text-lg ring-2 ring-[#0BA20B]/40">
                    {{ strtoupper(substr($talent->prenom, 0, 1)) }}{{ strtoupper(substr($talent->nom, 0, 1)) }}
                </div>
            @endif
            <div>
                <h4 class="font-bold text-base text-[#2C221E]">
                    {{ $talent->prenom }} {{ $talent->nom }}
                </h4>
                <p class="text-xs text-[#0BA20B] font-semibold">
                    {{ $talent->categorie ? $talent->categorie->libelle : 'Talent émergent' }}
                </p>
                <span class="text-[10px] text-[#8C766B]">
                    Jeune artiste
                </span>
            </div>
        </div>
        <p class="text-xs text-[#6B574F] line-clamp-2">
            {{ \Illuminate\Support\Str::limit($talent->biographie ?? 'Talent en pleine évolution, porté par l’association pour révéler son potentiel artistique.', 140) }}
        </p>
        <div class="pt-2 border-t border-[#0BA20B]/20 flex items-center justify-between text-xs text-[#0BA20B] font-bold">
            <span class="flex items-center gap-1">
                <svg aria-hidden="true" class="lucide lucide-music w-3.5 h-3.5" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 18V5l12-2v13"></path>
                    <circle cx="6" cy="18" r="3"></circle>
                    <circle cx="18" cy="16" r="3"></circle>
                </svg>
                Découvrir le profil
            </span>
            <span>&rarr;</span>
        </div>
    </a>
    @empty
        <div class="sm:col-span-3 rounded-none border border-dashed border-[#0BA20B]/40 bg-[#FAF7F2] p-8 text-center text-sm text-[#6B574F]">
            Aucun talent n’est encore publié.
        </div>
    @endforelse
    </div>
</div>
<div class="p-8 rounded-none bg-gradient-to-r from-[#F4EFE6] to-[#FAF7F2] border border-[#0BA20B]/40 flex flex-col sm:flex-row items-center justify-between gap-6">
<div class="space-y-2 text-center sm:text-left">
<h4 class="font-serif-title text-xl font-bold text-[#2C221E]">
      Vous êtes un jeune artiste ou créateur de 15 à 25 ans ?
     </h4>
<p class="text-xs sm:text-sm text-[#6B574F]">
      Bénéficiez gratuitement d'un studio de répétition, de conseils artistiques et de scènes de concert.
     </p>
</div>
<button onclick="document.getElementById('candidature-modal').classList.remove('hidden')" class="px-6 py-3 rounded-none bg-[#2C221E] hover:bg-[#0BA20B] text-white font-bold text-xs whitespace-nowrap transition-colors flex items-center gap-2 shadow">
<svg aria-hidden="true" class="lucide lucide-send w-4 h-4" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z">
</path>
<path d="m21.854 2.147-10.94 10.939">
</path>
</svg>
<span>
      Déposer ma Candidature
     </span>
</button>
</div>
</div>
</section>
<div id="candidature-modal" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm px-4">
    <div class="relative w-full max-w-2xl bg-[#FAF7F2] rounded-none p-8 sm:p-10 shadow-2xl overflow-y-auto max-h-[90vh] animate-in fade-in zoom-in-95 duration-200">
        <!-- Close Button -->
        <button onclick="document.getElementById('candidature-modal').classList.add('hidden')" class="absolute top-4 right-4 p-2 bg-[#F4EFE6] hover:bg-[#0BA20B] text-[#2C221E] hover:text-white transition-colors rounded-none" aria-label="Fermer">
            <svg aria-hidden="true" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center gap-1.5 px-3 py-1 bg-[#F4EFE6] border border-[#0BA20B]/20 text-[#0BA20B] text-[10px] sm:text-xs font-bold uppercase tracking-wider rounded-none mb-4">
                <svg aria-hidden="true" class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z"></path>
                </svg>
                <span>Tremplin Jeunes Talents</span>
            </div>
            <h2 class="font-serif-title text-3xl sm:text-4xl font-bold text-[#2C221E]">Postuler au Programme de Promotion</h2>
            <p class="text-sm text-[#6B574F] mt-2 font-sans">Réservé aux jeunes créateurs de 15 à 25 ans (Studio &amp; Scènes offerts).</p>
        </div>

        <form id="candidatureForm" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-[#2C221E] uppercase tracking-wider">Nom <span class="text-[#0BA20B]">*</span></label>
                    <input name="nom" required type="text" placeholder="e.g. Nguema" class="w-full bg-white border border-[#0BA20B]/40 p-3 text-sm text-[#2C221E] focus:outline-none focus:border-[#0BA20B] focus:ring-1 focus:ring-[#0BA20B] rounded-none transition-colors placeholder-[#8C766B]/50" />
                </div>
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-[#2C221E] uppercase tracking-wider">Prénom <span class="text-[#0BA20B]">*</span></label>
                    <input name="prenom" required type="text" placeholder="e.g. Samuel" class="w-full bg-white border border-[#0BA20B]/40 p-3 text-sm text-[#2C221E] focus:outline-none focus:border-[#0BA20B] focus:ring-1 focus:ring-[#0BA20B] rounded-none transition-colors placeholder-[#8C766B]/50" />
                </div>
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-[#2C221E] uppercase tracking-wider">Nom de Scène / Pseudo</label>
                    <input name="pseudo" type="text" placeholder="e.g. Sam Kora" class="w-full bg-white border border-[#0BA20B]/40 p-3 text-sm text-[#2C221E] focus:outline-none focus:border-[#0BA20B] focus:ring-1 focus:ring-[#0BA20B] rounded-none transition-colors placeholder-[#8C766B]/50" />
                </div>
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-[#2C221E] uppercase tracking-wider">Age <span class="text-[#0BA20B]">*</span></label>
                    <input name="age" required type="number"  placeholder="21" class="w-full bg-white border border-[#0BA20B]/40 p-3 text-sm text-[#2C221E] focus:outline-none focus:border-[#0BA20B] focus:ring-1 focus:ring-[#0BA20B] rounded-none transition-colors placeholder-[#8C766B]/50" />
                </div>
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-[#2C221E] uppercase tracking-wider">Email <span class="text-[#0BA20B]">*</span></label>
                    <input name="email" required type="email" placeholder="e.g. samuel@example.com" class="w-full bg-white border border-[#0BA20B]/40 p-3 text-sm text-[#2C221E] focus:outline-none focus:border-[#0BA20B] focus:ring-1 focus:ring-[#0BA20B] rounded-none transition-colors placeholder-[#8C766B]/50" />
                </div>
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-[#2C221E] uppercase tracking-wider">Téléphone <span class="text-[#0BA20B]">*</span></label>
                    <input name="telephone" required type="tel" placeholder="e.g. +241 07 45 12 89" class="w-full bg-white border border-[#0BA20B]/40 p-3 text-sm text-[#2C221E] focus:outline-none focus:border-[#0BA20B] focus:ring-1 focus:ring-[#0BA20B] rounded-none transition-colors placeholder-[#8C766B]/50" />
                </div>
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-[#2C221E] uppercase tracking-wider">WhatsApp <span class="text-[#0BA20B]">*</span></label>
                    <input name="whatsapp" required type="tel" placeholder="e.g. +241 07 45 12 89" class="w-full bg-white border border-[#0BA20B]/40 p-3 text-sm text-[#2C221E] focus:outline-none focus:border-[#0BA20B] focus:ring-1 focus:ring-[#0BA20B] rounded-none transition-colors placeholder-[#8C766B]/50" />
                </div>
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-[#2C221E] uppercase tracking-wider">Discipline <span class="text-[#0BA20B]">*</span></label>
                    <div class="relative">
                        <select name="discipline_id" required class="w-full appearance-none bg-white border border-[#0BA20B]/40 p-3 pr-10 text-sm text-[#2C221E] focus:outline-none focus:border-[#0BA20B] focus:ring-1 focus:ring-[#0BA20B] rounded-none transition-colors">
                            <option value="">Sélectionnez une discipline...</option>
                            <option value="1">Chant & Polyphonie</option>
                            <option value="2">Percussions & Balafon</option>
                            <option value="3">Instruments à Cordes (Kora, etc.)</option>
                            <option value="4">Création Numérique Audio</option>
                            <option value="5">Autre</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-[#0BA20B]">
                            <svg aria-hidden="true" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-bold text-[#2C221E] uppercase tracking-wider">Lien Audio / Vidéo Démo (Youtube, Soundcloud, Drive) <span class="text-[#0BA20B]">*</span></label>
                <input name="demo_link" required type="url" placeholder="https://youtube.com/watch?v=..." class="w-full bg-white border border-[#0BA20B]/40 p-3 text-sm text-[#2C221E] focus:outline-none focus:border-[#0BA20B] focus:ring-1 focus:ring-[#0BA20B] rounded-none transition-colors placeholder-[#8C766B]/50" />
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-bold text-[#2C221E] uppercase tracking-wider">Présentation de votre projet artistique <span class="text-[#0BA20B]">*</span></label>
                <textarea name="presentation" required rows="4" placeholder="Racontez-nous votre parcours, vos influences et ce que vous attendez de l'association..." class="w-full bg-white border border-[#0BA20B]/40 p-3 text-sm text-[#2C221E] focus:outline-none focus:border-[#0BA20B] focus:ring-1 focus:ring-[#0BA20B] rounded-none transition-colors placeholder-[#8C766B]/50 resize-y"></textarea>
            </div>

            <button type="submit" class="w-full px-6 py-3.5 bg-[#0BA20B] hover:bg-[#087A08] text-white font-bold text-sm tracking-wide uppercase shadow-lg transition-transform hover:-translate-y-0.5 rounded-none flex items-center justify-center gap-2">
                <svg aria-hidden="true" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                </svg>
                <span>Soumettre ma Candidature</span>
            </button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('candidatureForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(form);
            
            fetch('{{ route('talent-candidatures.store') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Candidature envoyée !',
                        text: data.message,
                        confirmButtonColor: '#0BA20B',
                        confirmButtonText: 'OK'
                    });
                    form.reset();
                    document.getElementById('candidature-modal').classList.add('hidden');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: 'Une erreur est survenue. Veuillez réessayer.',
                        confirmButtonColor: '#0BA20B',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: 'Une erreur est survenue. Veuillez réessayer.',
                    confirmButtonColor: '#0BA20B',
                    confirmButtonText: 'OK'
                });
            });
        });
    }
});
</script>

@endsection
