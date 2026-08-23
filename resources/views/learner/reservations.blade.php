@extends('layouts.dashboard')

@section('title', 'Toutes mes réservations | Espace Apprenant')

@section('content')
<div class="w-full h-full flex flex-col space-y-6" x-data="{ showReportModal: false, activeReservationId: null, reportDate: '', reportTime: '', reportTimeEnd: '', reportMessage: '' }">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 pb-4 border-b border-slate-200">
        <div>
            <h1 class="admin-title">Mes Réservations</h1>
            <p class="admin-subtitle">Retrouvez l'historique de vos cours, négociez les horaires et accédez aux visioconférences.</p>
        </div>
        <a href="{{ route('dashboard.apprenant') }}" class="text-xs font-bold text-slate-600 hover:text-[#0BA20B] uppercase tracking-wider flex items-center gap-1 transition-colors">
            &larr; Retour au tableau de bord
        </a>
    </div>

    <!-- Flash Notifications -->
    @if(session('success'))
      <div class="p-4 bg-emerald-50 border-l-4 border-l-emerald-600 text-emerald-800 text-xs font-semibold">
        {{ session('success') }}
      </div>
    @endif
    @if(session('error'))
      <div class="p-4 bg-red-50 border-l-4 border-l-red-600 text-red-800 text-xs font-semibold">
        {{ session('error') }}
      </div>
    @endif

    <!-- Liste de toutes les Réservations (Cartes Premium) -->
    <div class="bg-gradient-to-br from-white to-[#0BA20B]/[0.02] border border-slate-200 p-6 rounded-none relative overflow-hidden group">
        <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-[#0BA20B]/5 rotate-45 group-hover:bg-[#0BA20B]/10 group-hover:rotate-90 transition-all duration-700 pointer-events-none"></div>
        <div class="relative z-10 flex justify-between items-center mb-6 border-b border-slate-100 pb-4">
            <div class="flex items-center gap-2">
              <span class="w-2 h-2 bg-[#0BA20B] block"></span>
              <div>
                <h2 class="text-lg font-bold text-slate-900 font-sans tracking-tight">Toutes mes inscriptions</h2>
                <p class="text-xs text-slate-500 font-medium mt-0.5">Suivez vos cours, acceptez les reports et participez aux classes.</p>
              </div>
            </div>
            <a href="{{ route('dashboard.apprenant.cours') }}" class="text-xs text-[#0BA20B] font-bold uppercase tracking-widest hover:underline">+ Réserver un nouveau cours</a>
        </div>
        
        @if($reservations->isEmpty())
            <div class="text-center py-10 bg-[#FAF7F2] border border-dashed border-[#0BA20B]/40">
                <p class="text-sm text-[#6B574F] font-medium">Vous n'avez aucune réservation de cours enregistrée.</p>
                <a href="{{ route('dashboard.apprenant.cours') }}" class="mt-3 inline-block px-5 py-2.5 bg-[#0BA20B] text-white text-xs font-bold uppercase tracking-widest shadow hover:bg-[#087A08] transition">
                    Découvrir les cours & réserver
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 relative z-10">
                @foreach($reservations as $res)
                    <div class="bg-white border border-slate-200 shadow-sm overflow-hidden flex flex-col relative transition hover:shadow-md" x-data="{ showMenu: false }">
                        {{-- Top Badge --}}
                        <div class="absolute top-0 right-0 px-3 py-1 text-[9px] font-bold uppercase tracking-widest text-white z-10
                            @if($res->status === 'accepted') bg-emerald-500
                            @elseif($res->status === 'pending_student') bg-amber-500
                            @elseif($res->status === 'pending_teacher') bg-blue-500
                            @elseif($res->status === 'refused') bg-red-500
                            @else bg-slate-500 @endif
                        ">
                            @if($res->status === 'accepted') Confirmé
                            @elseif($res->status === 'pending_student') Action requise (Report)
                            @elseif($res->status === 'pending_teacher') En attente du professeur
                            @elseif($res->status === 'refused') Refusé
                            @else {{ $res->status }} @endif
                        </div>

                        {{-- Header --}}
                        <div class="p-5 border-b border-slate-100 bg-[#FAF7F2] relative">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-[9px] font-bold uppercase tracking-widest text-[#0BA20B] block mb-1">Cours & Professeur</span>
                                    <h4 class="font-bold text-slate-900 text-sm leading-tight mb-1">{{ $res->course->titre ?? '—' }}</h4>
                                    <p class="text-[11px] text-slate-500 font-medium">
                                        Par {{ $res->course && $res->course->professeur ? $res->course->professeur->name : 'Enseignant' }}
                                    </p>
                                </div>
                                
                                @if($res->discussions && $res->discussions->count() > 0)
                                <div class="relative">
                                    <button @click="showMenu = !showMenu" @click.away="showMenu = false" class="text-slate-400 hover:text-slate-600 focus:outline-none p-1">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
                                    </button>
                                    <div x-show="showMenu" style="display: none;" class="absolute right-0 mt-1 w-48 bg-white border border-slate-200 shadow-lg z-20 overflow-hidden">
                                        <a href="{{ route('dashboard.apprenant.reservations.discussions', $res->id) }}" class="block w-full text-left px-4 py-3 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-[#0BA20B] transition-colors flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                            Voir la discussion ({{ $res->discussions->count() }})
                                        </a>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        {{-- Body --}}
                        <div class="p-5 flex-1 flex flex-col gap-4">
                            <div class="bg-[#F4EFE6] p-3 border-l-2 border-[#0BA20B]">
                                <span class="text-[9px] font-bold uppercase tracking-widest text-[#6B574F] block mb-1">Horaire prévu / proposé</span>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-[#0BA20B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span class="text-sm font-bold text-slate-800">{{ \Carbon\Carbon::parse($res->date_reservation)->format('d/m/Y') }}</span>
                                    <span class="text-xs font-mono font-semibold text-slate-700 ml-1 bg-white px-1 py-0.5 shadow-sm">{{ substr($res->heure_debut, 0, 5) }} - {{ substr($res->heure_fin, 0, 5) }}</span>
                                </div>
                                @if($res->report_proposed_at)
                                    <div class="mt-2 text-[10px] font-medium text-amber-600 italic bg-amber-50 px-1 py-0.5 inline-block border border-amber-200">
                                        Modifié le {{ \Carbon\Carbon::parse($res->report_proposed_at)->format('d/m à H:i') }}
                                    </div>
                                @endif
                            </div>

                            <div class="flex flex-wrap justify-between items-center gap-2">
                                <span class="px-2 py-0.5 text-[10px] font-bold uppercase bg-slate-100 border border-slate-200 text-slate-600 rounded-sm">
                                    {{ $res->course && $res->course->mode ? $res->course->mode->libelle : 'Présentiel' }}
                                </span>
                                @if($res->course && $res->course->lieu)
                                    <span class="text-[11px] font-medium text-slate-700 flex items-center gap-1 bg-slate-50 px-2 py-0.5 border border-slate-200">
                                        <svg class="w-3 h-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        {{ $res->course->lieu }}
                                    </span>
                                @endif
                                @if($res->course && $res->course->supports && $res->course->supports->count() > 0)
                                    <div class="relative" x-data="{ open: false }">
                                        <button @click="open = !open" @click.away="open = false" class="inline-flex items-center gap-1 text-[10px] font-bold uppercase tracking-wider text-slate-600 hover:text-slate-900 transition cursor-pointer">
                                            📁 Supports ({{ $res->course->supports->count() }})
                                        </button>
                                        <div x-show="open" style="display: none;" class="absolute right-0 bottom-full mb-2 w-48 bg-white border border-slate-200 shadow-xl z-50 text-left overflow-hidden">
                                            @foreach($res->course->supports as $support)
                                                <a href="{{ route('dashboard.apprenant.supports.download', $support->id) }}" class="block px-3 py-2 text-xs text-slate-700 hover:bg-slate-50 hover:text-[#0BA20B] border-b border-slate-100 last:border-0 truncate" title="{{ basename($support->fichier) }}">
                                                    ⬇️ {{ basename($support->fichier) }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Actions / Footer --}}
                        <div class="p-4 border-t border-slate-100 bg-white">
                            @if($res->status === 'pending_student')
                                <div class="flex flex-col gap-2">
                                    <div class="flex items-center gap-2">
                                        <form method="POST" action="{{ route('dashboard.apprenant.reservations.accept', $res->id) }}" class="flex-1">
                                            @csrf
                                            <button type="submit" class="w-full px-3 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-[10px] uppercase tracking-wider transition text-center shadow-sm flex items-center justify-center gap-1.5">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                Accepter
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('dashboard.apprenant.reservations.refuse', $res->id) }}">
                                            @csrf
                                            <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir annuler/refuser cette réservation ?')" class="px-3 py-2 bg-white border border-red-200 hover:bg-red-50 text-red-600 font-bold text-[10px] uppercase tracking-wider transition text-center shadow-sm" title="Refuser">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                    <button type="button" @click="activeReservationId = {{ $res->id }}; reportDate = '{{ $res->date_reservation }}'; reportTime = '{{ substr($res->heure_debut, 0, 5) }}'; reportTimeEnd = '{{ substr($res->heure_fin, 0, 5) }}'; reportMessage = ''; showReportModal = true" class="w-full px-3 py-2 bg-white border border-amber-300 hover:bg-amber-50 text-amber-700 font-bold text-[10px] uppercase tracking-wider transition text-center shadow-sm flex items-center justify-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                        Proposer un autre horaire
                                    </button>
                                </div>
                            @elseif($res->status === 'pending_teacher')
                                <div class="text-center p-3 bg-blue-50 border border-blue-100 shadow-inner">
                                    <span class="text-[11px] font-semibold text-blue-800">En attente de la réponse du professeur.</span>
                                </div>
                            @elseif($res->status === 'accepted')
                                <div class="flex flex-col gap-2">
                                    @if($res->jitsi_room_id || ($res->course && $res->course->mode && Str::contains(strtolower($res->course->mode->libelle), ['distanciel', 'ligne', 'visio'])))
                                        <a href="{{ route('meeting.show', $res->id) }}" class="w-full flex items-center justify-center gap-2 px-3 py-2 bg-[#0BA20B] hover:bg-[#087A08] text-white font-bold text-[10px] uppercase tracking-wider transition shadow-sm">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                            Rejoindre la Visio
                                        </a>
                                    @endif
                                    @if($res->lien_replay)
                                        <a href="{{ route('visio.replay', $res->id) }}" class="w-full flex items-center justify-center gap-2 px-3 py-2 bg-white border border-[#0BA20B] hover:bg-emerald-50 text-[#0BA20B] font-bold text-[10px] uppercase tracking-wider transition shadow-sm">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Voir le Replay
                                        </a>
                                    @endif
                                </div>
                            @elseif($res->status === 'refused')
                                <div class="text-center p-3 bg-red-50 border border-red-100 shadow-inner">
                                    <span class="text-[11px] font-semibold text-red-800">Réservation annulée/refusée.</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            
            @if(method_exists($reservations, 'hasPages') && $reservations->hasPages())
                <div class="mt-8 pt-4 border-t border-slate-100 flex justify-center relative z-10">
                    {{ $reservations->links() }}
                </div>
            @endif
        @endif
    </div>

    {{-- Modal Proposer un Report --}}
    <div x-show="showReportModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-[#1E1613]/70 backdrop-blur-sm" x-cloak style="display:none;">
      <div @click.away="showReportModal = false" class="bg-white max-w-sm w-full p-6 shadow-2xl border-t-4 border-amber-500 relative">
        <div class="flex justify-between items-center border-b border-slate-100 pb-3 mb-4">
          <h3 class="font-serif-title font-bold text-lg text-slate-900">Proposer un report</h3>
          <button @click="showReportModal = false" class="text-slate-400 hover:text-slate-600 text-xl font-bold leading-none">&times;</button>
        </div>

        <form :action="'/dashboard/apprenant/reservations/' + activeReservationId + '/propose-report'" method="POST" class="space-y-4">
          @csrf
          <div>
            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1.5">Nouvelle date souhaitée <span class="text-red-500">*</span></label>
            <input type="date" name="new_date" required x-model="reportDate" class="w-full px-3 py-2 border border-slate-300 text-sm focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500" />
          </div>
          <div class="grid grid-cols-2 gap-3">
            <div>
              <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1.5">Heure de début <span class="text-red-500">*</span></label>
              <input type="time" name="new_time" required x-model="reportTime" class="w-full px-3 py-2 border border-slate-300 text-sm focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500" />
            </div>
            <div>
              <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1.5">Heure de fin</label>
              <input type="time" name="new_time_end" x-model="reportTimeEnd" class="w-full px-3 py-2 border border-slate-300 text-sm focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500" />
            </div>
          </div>
          <div>
            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1.5">Petit mot / Motif (optionnel)</label>
            <textarea name="message" x-model="reportMessage" rows="2" class="w-full px-3 py-2 border border-slate-300 text-sm focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500" placeholder="Raison de ce changement..."></textarea>
          </div>
          
          <div class="flex justify-end gap-2 pt-3 border-t border-slate-100 mt-5">
            <button type="button" @click="showReportModal = false" class="px-4 py-2 text-[11px] font-bold text-slate-500 hover:text-slate-800 uppercase tracking-widest transition">Annuler</button>
            <button type="submit" class="px-5 py-2 bg-amber-500 hover:bg-amber-600 text-white text-[11px] font-bold uppercase tracking-widest shadow transition">Envoyer au professeur</button>
          </div>
        </form>
      </div>
    </div>
</div>
@endsection
