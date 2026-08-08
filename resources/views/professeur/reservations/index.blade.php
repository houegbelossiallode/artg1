@extends('layouts.dashboard')

@section('title', 'Réservations & Salles Visio Jitsi')

@section('content')
<div class="w-full flex flex-col gap-5" x-data="{ showReplayModal: false, activeReservationId: null, replayUrl: '', replayDesc: '' }">
  {{-- Page Header --}}
  <x-dashboard.page-header title="Réservations & Classes Virtuelles" description="Gérez les inscriptions de vos élèves, animez vos visioconférences Jitsi et partagez vos replays." />
  
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

  <div class="bg-white border border-slate-200 shadow-sm p-6">
    @if($reservations->isEmpty())
      <p class="text-gray-600">Aucune réservation reçue pour le moment.</p>
    @else
      <div class="overflow-x-auto">
        <table class="w-full text-left">
          <thead class="bg-gray-100">
            <tr class="border-b border-slate-200">
              <th class="px-4 py-3 text-[9px] font-bold text-slate-400 uppercase tracking-widest">COURS</th>
              <th class="px-4 py-3 text-[9px] font-bold text-slate-400 uppercase tracking-widest">APPRENANT</th>
              <th class="px-4 py-3 text-[9px] font-bold text-slate-400 uppercase tracking-widest">MODE</th>
              <th class="px-4 py-3 text-[9px] font-bold text-slate-400 uppercase tracking-widest">CRÉNEAU DEMANDÉ</th>
              <th class="px-4 py-3 text-[9px] font-bold text-slate-400 uppercase tracking-widest">STATUT</th>
              <th class="px-4 py-3 text-[9px] font-bold text-slate-400 uppercase tracking-widest text-right">VISIO & REPLAY</th>
              <th class="px-4 py-3 text-[9px] font-bold text-slate-400 uppercase tracking-widest text-right">ACTIONS</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
            @foreach($reservations as $res)
              <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-4 py-3.5 text-xs text-slate-800 font-bold">{{ $res->course->titre ?? '—' }}</td>
                <td class="px-4 py-3.5 text-xs text-slate-800">
                  <span class="font-semibold">{{ $res->user->name }}</span><br>
                  <span class="text-[10px] text-slate-500">{{ $res->user->email }}</span>
                </td>
                <td class="px-4 py-3.5 text-xs">
                  <span class="px-2 py-0.5 text-[10px] font-bold uppercase border border-slate-300 bg-slate-100 text-slate-800">
                    {{ $res->course && $res->course->mode ? $res->course->mode->libelle : 'Présentiel' }}
                  </span>
                </td>
                <td class="px-4 py-3.5 text-xs text-slate-800">
                  @if($res->date_reservation)
                    <span class="font-bold text-slate-900 block">{{ \Carbon\Carbon::parse($res->date_reservation)->format('d/m/Y') }}</span>
                    <span class="text-[10px] text-slate-500 font-mono">{{ substr($res->heure_debut, 0, 5) }} - {{ substr($res->heure_fin, 0, 5) }}</span>
                  @else
                    {{ $res->created_at->format('d/m/Y H:i') }}
                  @endif
                </td>
                <td class="px-4 py-3.5 text-xs">
                  <span class="px-2 py-0.5 text-[10px] font-bold uppercase rounded bg-emerald-100 text-emerald-800">
                    {{ ucfirst($res->status) }}
                  </span>
                </td>

                {{-- Visio & Replay Controls --}}
                <td class="px-4 py-3.5 text-right space-x-1">
                  @if($res->jitsi_room_id || ($res->course && $res->course->mode && Str::contains(strtolower($res->course->mode->libelle), ['distanciel', 'ligne', 'visio'])))
                    <a href="{{ route('visio.join', $res->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-[10px] uppercase tracking-wider shadow">
                      🎥 Lancer Visio Jitsi
                    </a>
                  @endif

                  <button @click="activeReservationId = {{ $res->id }}; replayUrl = '{{ $res->lien_replay ?? '' }}'; replayDesc = '{{ $res->description_replay ?? '' }}'; showReplayModal = true"
                          class="inline-flex items-center gap-1 px-3 py-1.5 bg-[#C85A32] hover:bg-[#A84223] text-white font-bold text-[10px] uppercase tracking-wider shadow cursor-pointer">
                    📼 {{ $res->lien_replay ? 'Éditer Replay' : '+ Ajouter Replay' }}
                  </button>
                </td>

                <td class="px-4 py-3.5 text-right">
                  <div class="relative inline-block text-left" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open" type="button" class="w-7 h-7 border border-slate-300 bg-white hover:bg-slate-100 text-slate-500 inline-flex items-center justify-center focus:outline-none transition-colors">
                      <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
                    </button>
                    <div x-show="open" class="absolute right-0 mt-1 w-48 bg-white shadow-lg border border-slate-200 z-50 divide-y divide-slate-100" style="display:none;">
                      <form method="POST" action="{{ route('dashboard.professeur.reservations.accept', $res->id) }}" class="w-full">
                        @csrf
                        <button type="submit" class="flex w-full items-center gap-2 px-4 py-2.5 text-xs text-green-600 hover:bg-green-50 font-semibold">Accepter</button>
                      </form>
                      <form method="POST" action="{{ route('dashboard.professeur.reservations.refuse', $res->id) }}" class="w-full">
                        @csrf
                        <button type="submit" class="flex w-full items-center gap-2 px-4 py-2.5 text-xs text-red-600 hover:bg-red-50 font-semibold" onclick="return confirm('Refuser cette réservation ?')">Refuser</button>
                      </form>
                    </div>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
  </div>

  {{-- Modal d'ajout / Édition du Replay --}}
  <div x-show="showReplayModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm" x-cloak style="display:none;">
    <div @click.away="showReplayModal = false" class="bg-white max-w-md w-full p-6 shadow-2xl border border-slate-200 space-y-4">
      <div class="flex justify-between items-center border-b pb-3">
        <h3 class="font-serif-title font-bold text-lg text-slate-900">Publier / Modifier l'enregistrement (Replay)</h3>
        <button @click="showReplayModal = false" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
      </div>

      <form :action="'/visio/' + activeReservationId + '/replay'" method="POST" class="space-y-4">
        @csrf
        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Lien de la vidéo (Replay) <span class="text-red-500">*</span></label>
          <input type="url" name="lien_replay" required x-model="replayUrl" placeholder="https://youtube.com/watch?v=... ou Vimeo / Drive"
                 class="w-full px-3 py-2 border border-slate-300 text-xs focus:outline-none focus:border-[#C85A32]" />
          <span class="text-[10px] text-slate-500 mt-1 block">Entrez un lien YouTube, Vimeo ou Google Drive valide.</span>
        </div>

        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Description / Consignes pour l'apprenant</label>
          <textarea name="description_replay" rows="3" x-model="replayDesc" placeholder="Remarques de l'enseignant, morceaux travaillés, devoirs..."
                    class="w-full px-3 py-2 border border-slate-300 text-xs focus:outline-none focus:border-[#C85A32]"></textarea>
        </div>

        <div class="flex justify-end gap-2 pt-2 border-t">
          <button type="button" @click="showReplayModal = false" class="px-4 py-2 text-xs font-bold text-slate-600">Annuler</button>
          <button type="submit" class="px-5 py-2 bg-[#C85A32] hover:bg-[#A84223] text-white text-xs font-bold uppercase tracking-wider shadow">Enregistrer le Replay</button>
        </div>
      </form>
    </div>
  </div>

</div>
@endsection
