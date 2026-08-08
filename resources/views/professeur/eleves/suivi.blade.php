@extends('layouts.dashboard')

@section('title', 'Suivi de ' . $eleve->prenom . ' ' . $eleve->nom)

@section('content')
<div class="w-full flex flex-col gap-5">

  {{-- ═══════════════════════ PAGE HEADER ═══════════════════════ --}}
  <x-dashboard.page-header title="Suivi de l'apprenant" description="Fiche détaillée et historique des réservations.">
    <a href="{{ route('dashboard.professeur.eleves') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-[10px] uppercase tracking-widest transition shadow-sm">
      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
      Retour
    </a>
  </x-dashboard.page-header>

  {{-- ═══════════════════════ FICHE ÉLÈVE ═══════════════════════ --}}
  <div class="bg-white border border-slate-200 shadow-sm p-6">
    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5">
      {{-- Avatar --}}
      <div class="w-16 h-16 bg-[#5EF527] text-slate-900 font-bold flex items-center justify-center text-lg shrink-0 shadow-[0_0_20px_rgba(94,245,39,0.25)]">
        {{ strtoupper(substr($eleve->prenom, 0, 1) . substr($eleve->nom, 0, 1)) }}
      </div>
      {{-- Info --}}
      <div class="flex-1">
        <h2 class="text-lg font-bold text-slate-900 uppercase tracking-wide">{{ $eleve->prenom }} {{ $eleve->nom }}</h2>
        <div class="flex flex-wrap items-center gap-4 mt-1.5">
          <span class="inline-flex items-center gap-1.5 text-xs text-slate-500">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            {{ $eleve->email }}
          </span>
          @if($eleve->telephone)
          <span class="inline-flex items-center gap-1.5 text-xs text-slate-500">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
            {{ $eleve->telephone }}
          </span>
          @endif
          <span class="inline-flex items-center gap-1.5 text-xs text-slate-400">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Inscrit le {{ $eleve->created_at ? $eleve->created_at->format('d/m/Y') : '-' }}
          </span>
        </div>
      </div>
    </div>
  </div>

  {{-- ═══════════════════════ CARTES STATISTIQUES ═══════════════════════ --}}
  <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">

    {{-- Total --}}
    <div class="bg-white border border-slate-200 shadow-sm p-3.5 border-l-4 border-l-[#5EF527] flex flex-col gap-2">
      <div class="flex items-center justify-between">
        <div class="w-7 h-7 bg-[#5EF527]/10 flex items-center justify-center">
          <svg class="w-3.5 h-3.5 text-[#5EF527]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
        </div>
        <span class="text-[8px] font-bold text-[#5EF527] border border-[#5EF527]/40 px-1.5 py-0.5 uppercase tracking-widest">TOTAL</span>
      </div>
      <p class="text-[8px] font-bold text-slate-400 uppercase tracking-widest">COURS RÉSERVÉS</p>
      <span class="text-2xl font-normal text-slate-900">{{ $stats['total'] }}</span>
    </div>

    {{-- Acceptés --}}
    <div class="bg-white border border-slate-200 shadow-sm p-3.5 border-l-4 border-l-emerald-500 flex flex-col gap-2">
      <div class="flex items-center justify-between">
        <div class="w-7 h-7 bg-emerald-100/50 flex items-center justify-center">
          <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        </div>
        <span class="text-[8px] font-bold text-emerald-500 border border-emerald-300 px-1.5 py-0.5 uppercase tracking-widest">VALIDÉ</span>
      </div>
      <p class="text-[8px] font-bold text-slate-400 uppercase tracking-widest">ACCEPTÉS</p>
      <span class="text-2xl font-normal text-slate-900">{{ $stats['accepted'] }}</span>
    </div>

    {{-- En attente --}}
    <div class="bg-white border border-slate-200 shadow-sm p-3.5 border-l-4 border-l-amber-500 flex flex-col gap-2">
      <div class="flex items-center justify-between">
        <div class="w-7 h-7 bg-amber-100/50 flex items-center justify-center">
          <svg class="w-3.5 h-3.5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <span class="text-[8px] font-bold text-amber-500 border border-amber-300 px-1.5 py-0.5 uppercase tracking-widest">ATTENTE</span>
      </div>
      <p class="text-[8px] font-bold text-slate-400 uppercase tracking-widest">EN ATTENTE</p>
      <span class="text-2xl font-normal text-slate-900">{{ $stats['pending'] }}</span>
    </div>

    {{-- Refusés --}}
    <div class="bg-white border border-slate-200 shadow-sm p-3.5 border-l-4 border-l-red-500 flex flex-col gap-2">
      <div class="flex items-center justify-between">
        <div class="w-7 h-7 bg-red-100/50 flex items-center justify-center">
          <svg class="w-3.5 h-3.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </div>
        <span class="text-[8px] font-bold text-red-500 border border-red-300 px-1.5 py-0.5 uppercase tracking-widest">REFUSÉ</span>
      </div>
      <p class="text-[8px] font-bold text-slate-400 uppercase tracking-widest">REFUSÉS</p>
      <span class="text-2xl font-normal text-slate-900">{{ $stats['refused'] }}</span>
    </div>

  </div>

  {{-- ═══════════════════════ TABLEAU DES RÉSERVATIONS ═══════════════════════ --}}
  <div class="bg-white border border-slate-200 shadow-sm">
    <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
      <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wide">Historique des Réservations</h2>
      <span class="text-[8px] font-bold text-slate-400 border border-slate-200 px-2 py-0.5 uppercase tracking-widest">{{ $reservations->count() }} résultat(s)</span>
    </div>
    <div class="border-b border-slate-200 bg-white overflow-x-auto">
      <table class="w-full text-left">
        <thead>
          <tr class="border-b border-slate-200">
            <th class="px-6 py-3 text-[9px] font-bold text-slate-400 uppercase tracking-widest">COURS</th>
            <th class="px-4 py-3 text-[9px] font-bold text-slate-400 uppercase tracking-widest">DATE DU COURS</th>
            <th class="px-4 py-3 text-[9px] font-bold text-slate-400 uppercase tracking-widest">HORAIRE</th>
            <th class="px-4 py-3 text-[9px] font-bold text-slate-400 uppercase tracking-widest">STATUT</th>
            <th class="px-4 py-3 text-[9px] font-bold text-slate-400 uppercase tracking-widest">RÉSERVÉ LE</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          @forelse ($reservations as $reservation)
            <tr class="hover:bg-slate-50 transition-colors">
              <td class="px-6 py-3.5">
                <div class="flex items-center gap-3">
                  <div class="w-8 h-8 bg-[#5EF527]/10 text-[#5EF527] font-bold flex items-center justify-center text-[10px] shrink-0">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                  </div>
                  <span class="font-bold text-slate-900 text-xs">{{ $reservation->course->titre ?? '-' }}</span>
                </div>
              </td>
              <td class="px-4 py-3.5 text-xs text-slate-500">
                {{ $reservation->course && $reservation->course->date_cours ? \Carbon\Carbon::parse($reservation->course->date_cours)->format('d/m/Y') : '-' }}
              </td>
              <td class="px-4 py-3.5 text-xs text-slate-500">
                @if($reservation->course && $reservation->course->heure_debut)
                  {{ \Carbon\Carbon::parse($reservation->course->heure_debut)->format('H:i') }} - {{ \Carbon\Carbon::parse($reservation->course->heure_fin)->format('H:i') }}
                @else
                  -
                @endif
              </td>
              <td class="px-4 py-3.5">
                @php
                  $statusConfig = match($reservation->status) {
                    'accepted' => ['label' => 'Accepté', 'bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'border' => 'border-emerald-200'],
                    'pending'  => ['label' => 'En attente', 'bg' => 'bg-amber-50', 'text' => 'text-amber-600', 'border' => 'border-amber-200'],
                    'refused'  => ['label' => 'Refusé', 'bg' => 'bg-red-50', 'text' => 'text-red-600', 'border' => 'border-red-200'],
                    'proposed' => ['label' => 'Report proposé', 'bg' => 'bg-blue-50', 'text' => 'text-blue-600', 'border' => 'border-blue-200'],
                    default    => ['label' => ucfirst($reservation->status), 'bg' => 'bg-slate-50', 'text' => 'text-slate-600', 'border' => 'border-slate-200'],
                  };
                @endphp
                <span class="inline-flex items-center px-2 py-0.5 text-[10px] font-bold uppercase tracking-widest {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} border {{ $statusConfig['border'] }}">
                  {{ $statusConfig['label'] }}
                </span>
              </td>
              <td class="px-4 py-3.5 text-xs text-slate-400">
                {{ $reservation->created_at ? $reservation->created_at->format('d/m/Y H:i') : '-' }}
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="px-6 py-12 text-center">
                <svg class="w-10 h-10 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                <p class="text-sm text-slate-400">Aucune réservation trouvée pour cet élève.</p>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>
@endsection
