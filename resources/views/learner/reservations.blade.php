@extends('layouts.dashboard')

@section('title', 'Toutes mes réservations | Espace Apprenant')

@section('content')
<div class="w-full h-full flex flex-col space-y-6">
    <!-- Page Header -->
    <div class="bg-white border border-slate-200 shadow-sm px-6 py-5 border-l-4 border-l-[#C85A32] flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-lg font-bold text-slate-900 uppercase tracking-wide">MES RÉSERVATIONS</h1>
            <p class="text-slate-500 text-sm mt-0.5">Retrouvez l'historique complet de vos cours, accédez aux visioconférences, replays et supports.</p>
        </div>
        <a href="{{ route('dashboard.apprenant') }}" class="text-xs font-bold text-[#C85A32] uppercase tracking-wider hover:underline">
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

    <!-- Liste de toutes les Réservations -->
    <div class="bg-white border border-slate-200 p-6">
        <div class="flex justify-between items-center mb-6 border-b border-slate-100 pb-4">
            <div>
                <h3 class="text-lg font-serif-title font-bold text-slate-900">Toutes mes inscriptions</h3>
                <p class="text-xs text-slate-500">Un récapitulatif complet de tous vos cours passés et futurs.</p>
            </div>
            <a href="{{ route('dashboard.apprenant.cours') }}" class="text-xs text-[#C85A32] font-bold uppercase tracking-widest hover:underline">+ Réserver un nouveau cours</a>
        </div>
        
        @if($reservations->isEmpty())
            <div class="text-center py-10 bg-[#FAF7F2] border border-dashed border-[#D4A373]/40">
                <p class="text-sm text-[#6B574F] font-medium">Vous n'avez aucune réservation de cours enregistrée.</p>
                <a href="{{ route('dashboard.apprenant.cours') }}" class="mt-3 inline-block px-5 py-2.5 bg-[#C85A32] text-white text-xs font-bold uppercase tracking-widest shadow hover:bg-[#A84223] transition">
                    Découvrir les cours & réserver
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-[#FAF7F2] text-[#1E1613] font-bold uppercase tracking-wider border-b border-[#D4A373]/30">
                        <tr>
                            <th class="p-3">Cours</th>
                            <th class="p-3">Professeur</th>
                            <th class="p-3">Mode</th>
                            <th class="p-3">Date & Horaire</th>
                            <th class="p-3">Statut</th>
                            <th class="p-3">Accès/Replay</th>
                            <th class="p-3">Support cours</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($reservations as $res)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="p-3 font-bold text-slate-900">
                                    {{ $res->course ? $res->course->titre : 'Cours' }}
                                </td>
                                <td class="p-3 text-slate-600">
                                    {{ $res->course && $res->course->professeur ? $res->course->professeur->name : 'Enseignant' }}
                                </td>
                                <td class="p-3">
                                    <span class="px-2 py-0.5 text-[10px] font-bold uppercase bg-slate-100 border border-slate-300 text-slate-800">
                                        {{ $res->course && $res->course->mode ? $res->course->mode->libelle : 'Présentiel' }}
                                    </span>
                                </td>
                                <td class="p-3 text-slate-700">
                                    {{ \Carbon\Carbon::parse($res->date_reservation)->format('d/m/Y') }} • 
                                    {{ \Carbon\Carbon::parse($res->heure_debut)->format('H\hi') }} - {{ \Carbon\Carbon::parse($res->heure_fin)->format('H\hi') }}
                                </td>
                                <td class="p-3">
                                    <span class="px-2.5 py-1 text-[10px] font-bold uppercase rounded-none bg-emerald-100 text-emerald-800">
                                        Confirmé
                                    </span>
                                </td>
                                <td class="p-3 space-x-2">
                                    @if($res->jitsi_room_id)
                                        <a href="{{ route('meeting.show', $res->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-[10px] uppercase tracking-wider shadow">
                                            🎥 Classe Jitsi
                                        </a>
                                    @endif

                                    @if($res->lien_replay)
                                        <a href="{{ route('visio.replay', $res->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-[#C85A32] hover:bg-[#A84223] text-white font-bold text-[10px] uppercase tracking-wider shadow">
                                            📼 Replay
                                        </a>
                                    @endif
                                </td>
                                <td class="p-3">
                                    @if($res->course && $res->course->supports && $res->course->supports->count() > 0)
                                        <div class="inline-block relative" x-data="{ open: false }">
                                            <button @click="open = !open" @click.away="open = false" class="inline-flex items-center gap-1 px-3 py-1.5 bg-slate-800 hover:bg-slate-900 text-white font-bold text-[10px] uppercase tracking-wider shadow cursor-pointer">
                                                📁 Supports ({{ $res->course->supports->count() }})
                                            </button>
                                            <div x-show="open" style="display: none;" class="absolute right-0 mt-1 w-56 bg-white border border-slate-200 shadow-xl z-10 text-left overflow-hidden">
                                                @foreach($res->course->supports as $support)
                                                    <a href="{{ route('dashboard.apprenant.supports.download', $support->id) }}" class="block px-4 py-2 text-xs text-slate-700 hover:bg-slate-50 hover:text-[#C85A32] border-b border-slate-100 last:border-0 truncate" title="{{ basename($support->fichier) }}">
                                                        ⬇️ {{ basename($support->fichier) }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if(method_exists($reservations, 'hasPages') && $reservations->hasPages())
                <div class="mt-6 pt-4 border-t border-slate-100 flex justify-center">
                    {{ $reservations->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
