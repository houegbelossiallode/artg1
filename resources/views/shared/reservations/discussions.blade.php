@extends('layouts.dashboard')

@section('title', 'Historique de Négociation | Écho & Culture')

@section('content')
<div class="w-full h-full flex flex-col lg:flex-row gap-6 items-start">
    <!-- Left Column : Infos -->
    <div class="w-full lg:w-1/3 flex flex-col gap-6 lg:sticky lg:top-8 z-10">
        <!-- Page Header -->
        <div class="flex items-center gap-4 pb-4 border-b border-slate-200">
            @if($user->profil_id == 2)
                <a href="{{ route('dashboard.apprenant.reservations') }}" class="text-slate-400 hover:text-[#0BA20B] transition-colors p-2 bg-white rounded-full shadow-sm border border-slate-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
            @else
                <a href="{{ route('dashboard.professeur.reservations') }}" class="text-slate-400 hover:text-[#0BA20B] transition-colors p-2 bg-white rounded-full shadow-sm border border-slate-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
            @endif
            <div>
                <h1 class="font-serif-title text-2xl font-bold text-[#1E1613]">Négociation</h1>
                <p class="text-sm text-[#8C766B]">
                    Suivi de la réservation
                </p>
            </div>
        </div>

        <!-- Info Réservation -->
        <div class="bg-white border border-slate-200 shadow-sm flex flex-col overflow-hidden">
            <div class="p-4 border-b border-slate-100 bg-[#FAF7F2]">
                <h2 class="font-bold text-slate-800 text-sm">Détails du cours</h2>
            </div>
            
            <div class="p-5 space-y-5">
                <div>
                    <span class="text-[9px] font-bold uppercase tracking-widest text-[#0BA20B] block mb-1">Cours concerné</span>
                    <h3 class="font-bold text-slate-900 text-base leading-tight">{{ $reservation->course->titre ?? '—' }}</h3>
                    <span class="inline-block mt-2 px-2 py-0.5 text-[10px] font-bold uppercase bg-slate-100 border border-slate-200 text-slate-600 rounded-sm">
                        {{ $reservation->course && $reservation->course->mode ? $reservation->course->mode->libelle : 'Présentiel' }}
                    </span>
                </div>

                <!-- <div class="border-t border-slate-100 pt-5">
                    <span class="text-[9px] font-bold uppercase tracking-widest text-slate-500 block mb-2">Interlocuteur</span>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-[#0BA20B]/10 rounded-full flex items-center justify-center shrink-0 border border-[#0BA20B]/20">
                            <span class="text-[#0BA20B] font-bold text-lg">
                                @if($user->profil_id == 2)
                                    {{ substr($reservation->course->professeur->name ?? 'P', 0, 1) }}
                                @else
                                    {{ substr($reservation->user->name ?? 'A', 0, 1) }}
                                @endif
                            </span>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900 text-sm leading-tight">
                                @if($user->profil_id == 2)
                                    {{ $reservation->course->professeur->name ?? 'Enseignant' }}
                                @else
                                    {{ $reservation->user->name ?? 'Apprenant' }}
                                @endif
                            </h4>
                            <span class="text-[10px] text-slate-500 font-medium">
                                @if($user->profil_id == 2) Professeur @else Élève @endif
                            </span>
                        </div>
                    </div>
                </div> -->
                
                <div class="border-t border-slate-100 pt-5">
                    <div class="bg-[#F4EFE6] p-3 border-l-2 border-[#0BA20B]">
                        <span class="text-[9px] font-bold uppercase tracking-widest text-[#6B574F] block mb-1">Créneau Actuel retenu</span>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#0BA20B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span class="text-sm font-bold text-slate-800">{{ \Carbon\Carbon::parse($reservation->date_reservation)->format('d/m/Y') }}</span>
                            <span class="text-xs font-mono font-semibold text-slate-700 ml-1 bg-white px-1 py-0.5 shadow-sm">{{ substr($reservation->heure_debut, 0, 5) }} - {{ substr($reservation->heure_fin, 0, 5) }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="border-t border-slate-100 pt-5 flex justify-between items-center">
                    <span class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Statut de la réservation</span>
                    <span class="text-[11px] font-mono font-bold px-2 py-1 rounded-sm
                        @if($reservation->status === 'accepted') bg-emerald-100 text-emerald-800 border border-emerald-200
                        @elseif($reservation->status === 'refused') bg-red-100 text-red-800 border border-red-200
                        @else bg-amber-100 text-amber-800 border border-amber-200 @endif
                    ">
                        {{ $reservation->status === 'accepted' ? 'Confirmé' : ($reservation->status === 'refused' ? 'Refusé' : 'En négociation') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column : Chat History -->
    <div class="w-full lg:w-2/3 bg-white border border-slate-200 shadow-sm flex flex-col h-[calc(100vh-140px)] min-h-[500px]">
        <div class="bg-[#FAF7F2] p-4 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-[#0BA20B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                <h3 class="font-bold text-slate-800 text-sm">Fil de discussion</h3>
            </div>
            <span class="text-xs font-bold text-slate-400">{{ $reservation->discussions ? $reservation->discussions->count() : 0 }} message(s)</span>
        </div>
        
        <div class="flex-1 overflow-y-auto p-6 space-y-6 bg-slate-50/50 custom-scrollbar">
            @if($reservation->discussions && $reservation->discussions->count() > 0)
                @foreach($reservation->discussions->sortBy('created_at') as $discussion)
                    <div class="flex flex-col @if($discussion->sender_id === Auth::id()) items-end @else items-start @endif">
                        <div class="max-w-[85%] md:max-w-[70%] p-4 text-sm rounded-2xl @if($discussion->sender_id === Auth::id()) bg-[#0BA20B] text-white rounded-tr-none shadow-md shadow-[#0BA20B]/20 @else bg-white text-slate-800 rounded-tl-none shadow-md border border-slate-100 @endif relative">
                            <div class="flex justify-between items-center gap-4 mb-2 opacity-100 border-b @if($discussion->sender_id === Auth::id()) border-white/20 pb-1.5 @else border-slate-100 pb-1.5 @endif">
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-[11px] uppercase tracking-wider">{{ $discussion->sender->name ?? 'Utilisateur' }}</span>
                                    <span class="text-[9px] font-semibold tracking-wide px-2 py-0.5 rounded-full @if($discussion->sender_id === Auth::id()) bg-white/25 text-white @else bg-slate-200 text-slate-600 @endif">
                                        @if($discussion->sender_id === $reservation->user_id)
                                            Élève
                                        @elseif($discussion->sender_id === $reservation->course->user_id)
                                            Professeur
                                        @else
                                            Admin
                                        @endif
                                    </span>
                                </div>
                                <span class="text-[10px] font-mono">{{ $discussion->created_at->format('d/m Y à H:i') }}</span>
                            </div>
                            
                            @if($discussion->message)
                                <p class="mb-3 leading-relaxed">{{ $discussion->message }}</p>
                            @endif
                            
                            <div class="text-[11px] font-mono @if($discussion->sender_id === Auth::id()) bg-black/15 text-white @else bg-amber-50 text-amber-800 border border-amber-200 @endif inline-flex px-2.5 py-1.5 rounded flex items-center gap-2">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Proposition : <strong class="ml-1">{{ \Carbon\Carbon::parse($discussion->proposed_date)->format('d/m/Y') }}</strong>
                                <span class="opacity-40">|</span> 
                                <strong>{{ substr($discussion->proposed_start_time, 0, 5) }} - {{ substr($discussion->proposed_end_time, 0, 5) }}</strong>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="flex items-center justify-center h-full text-slate-400 flex-col gap-3">
                    <svg class="w-12 h-12 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    <p class="text-sm">Aucun historique de négociation pour le moment.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
