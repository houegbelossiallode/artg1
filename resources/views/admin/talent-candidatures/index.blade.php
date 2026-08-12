@extends('layouts.dashboard')

@section('title', 'Candidatures Talents | AssoCulture')

@section('content')
<div class="space-y-6" x-data="{ approveModalOpen: false, selectedCandidature: null, form: { photo: null } }">

  <!-- Flash Messages -->
  @if (session('success'))
    <div class="p-4 bg-emerald-50 border-l-4 border-emerald-600 text-emerald-800 text-xs shadow-sm flex items-center justify-between">
      <span>{{ session('success') }}</span>
      <button onclick="this.parentElement.remove()" class="text-emerald-600 font-bold ml-4">&times;</button>
    </div>
  @endif

  <!-- En-tête -->
  <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 pb-4 border-b border-slate-200">
    <div>
      <h1 class="admin-title">Candidatures Talents</h1>
      <p class="admin-subtitle">Gérez les candidatures des jeunes talents.</p>
    </div>
  </div>

  <!-- Table des Candidatures -->
  <div class="bg-white border border-slate-200 shadow-sm rounded-none">
    <div class="overflow-x-auto overflow-y-visible min-h-[300px]">
      <table class="w-full text-left text-sm text-slate-600">
        <thead class="border-b border-slate-200 text-[10px] uppercase tracking-widest text-slate-400 font-bold bg-slate-50">
          <tr>
            <th class="p-4">Candidat</th>
            <th class="p-4">Discipline</th>
            <th class="p-4">Contact</th>
            <th class="p-4">Statut</th>
            <th class="p-4">Date</th>
            <th class="p-4 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          @forelse ($candidatures as $candidature)
            <tr class="hover:bg-slate-50 transition-colors">
              <td class="p-4">
                <div class="flex items-center gap-3">
                  <!-- <div class="w-10 h-10 bg-slate-900 text-amber-500 font-bold flex items-center justify-center text-xs border border-slate-200 shrink-0">
                    {{ strtoupper(substr($candidature->prenom, 0, 1) . substr($candidature->nom, 0, 1)) }}
                  </div> -->
                  <div>
                    <div class="font-sans font-bold text-slate-900 text-sm">{{ $candidature->prenom }} {{ $candidature->nom }}</div>
                    @if($candidature->presentation)
                      <div class="text-[11px] text-slate-400 truncate max-w-xs">{{ Str::limit($candidature->presentation, 50) }}</div>
                    @endif
                  </div>
                </div>
              </td>
              <td class="p-4 text-xs font-semibold text-slate-700">
                {{ $candidature->discipline ? $candidature->discipline->libelle : 'Non spécifié' }}
              </td>
              <td class="p-4 text-xs text-slate-500">
                <div>{{ $candidature->email ?? '-' }}</div>
                <div class="text-[11px] text-slate-400">{{ $candidature->telephone ?? '-' }}</div>
              </td>
              <td class="p-4">
                @if($candidature->statut == 'acceptee')
                  <span class="bg-emerald-100 text-emerald-700 text-[9px] font-bold px-2 py-0.5 uppercase tracking-widest rounded-none">
                    Acceptée
                  </span>
                @elseif($candidature->statut == 'rejetee')
                  <span class="bg-red-100 text-red-700 text-[9px] font-bold px-2 py-0.5 uppercase tracking-widest rounded-none">
                    Rejetée
                  </span>
                @else
                  <span class="bg-amber-100 text-amber-700 text-[9px] font-bold px-2 py-0.5 uppercase tracking-widest rounded-none">
                    En attente
                  </span>
                @endif
              </td>
              <td class="p-4 text-xs text-slate-500">
                {{ $candidature->created_at ? $candidature->created_at->format('d/m/Y') : '-' }}
              </td>
              <td class="p-4 text-right pr-6">
                <!-- DROPDOWN CARRÉ D'ACTIONS -->
                <div class="relative inline-block text-left" x-data="{ open: false }" @click.away="open = false">
                  <button @click="open = !open" type="button" class="w-7 h-7 bg-slate-100 hover:bg-slate-900 hover:text-white text-slate-700 inline-flex items-center justify-center rounded-none border border-slate-300 transition-colors focus:outline-none cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
                  </button>

                  <div x-show="open"
                       x-transition:enter="transition ease-out duration-100"
                       x-transition:enter-start="transform opacity-0 scale-95"
                       x-transition:enter-end="transform opacity-100 scale-100"
                       x-transition:leave="transition ease-in duration-75"
                       x-transition:leave-start="transform opacity-100 scale-100"
                       x-transition:leave-end="transform opacity-0 scale-95"
                       class="origin-top-right absolute right-0 mt-2 w-40 rounded-none bg-white shadow-xl border border-slate-200 z-50 divide-y divide-slate-100"
                       x-cloak>
                    @if($candidature->statut == 'en_attente')
                      <div class="py-1">
                        <button type="button" @click="selectedCandidature = { id: {{ $candidature->id }}, nom: '{{ addslashes($candidature->nom) }}', prenom: '{{ addslashes($candidature->prenom) }}', email: '{{ addslashes($candidature->email ?? '') }}', telephone: '{{ addslashes($candidature->telephone ?? '') }}', presentation: '{{ addslashes($candidature->presentation ?? '') }}', discipline: '{{ addslashes($candidature->discipline ? $candidature->discipline->libelle : '') }}' }; form = { photo: null }; approveModalOpen = true; open = false" class="w-full text-left group flex items-center px-4 py-2 text-xs text-emerald-600 hover:bg-emerald-600 hover:text-white font-bold uppercase tracking-wider">
                          <svg class="mr-2 h-4 w-4 text-emerald-500 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                          Accepter
                        </button>
                      </div>
                      <div class="py-1">
                        <form action="{{ route('dashboard.admin.talent-candidatures.reject', $candidature) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment rejeter cette candidature ?');">
                          @csrf
                          <button type="submit" class="w-full text-left group flex items-center px-4 py-2 text-xs text-red-600 hover:bg-red-600 hover:text-white font-bold uppercase tracking-wider">
                            <svg class="mr-2 h-4 w-4 text-red-500 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            Rejeter
                          </button>
                        </form>
                      </div>
                    @else
                      <div class="py-1">
                        <span class="w-full text-left group flex items-center px-4 py-2 text-xs text-slate-400 font-bold uppercase tracking-wider cursor-not-allowed">
                          Candidature traitée
                        </span>
                      </div>
                    @endif
                  </div>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="p-8 text-center text-xs text-slate-400">Aucune candidature pour le moment.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- MODAL D'ACCEPTATION -->
  <div x-show="approveModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-cloak>
    <div @click.away="approveModalOpen = false" class="bg-white max-w-2xl w-full rounded-none shadow-2xl border border-slate-200 overflow-hidden max-h-[90vh] flex flex-col">
      <div class="bg-slate-900 px-6 py-4 flex items-center justify-between border-b-2 border-[#0BA20B] shrink-0">
        <h3 class="text-sm font-sans font-bold text-white uppercase tracking-wider flex items-center gap-2 font-sans">
          <span class="w-2 h-2 bg-emerald-500 inline-block"></span>
          Accepter la Candidature
        </h3>
        <button type="button" @click="approveModalOpen = false" class="text-slate-400 hover:text-white text-lg font-bold">&times;</button>
      </div>

      <div class="p-6 space-y-4 overflow-y-auto">
        <!-- Informations du candidat -->
        <div class="bg-slate-50 p-4 border border-slate-200">
          <h4 class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-3 font-sans">Informations du candidat</h4>
          <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
              <span class="text-slate-400 text-xs">Nom complet</span>
              <div class="font-semibold text-slate-900" x-text="selectedCandidature ? selectedCandidature.prenom + ' ' + selectedCandidature.nom : ''"></div>
            </div>
            <div>
              <span class="text-slate-400 text-xs">Discipline</span>
              <div class="font-semibold text-slate-900" x-text="selectedCandidature ? selectedCandidature.discipline : ''"></div>
            </div>
            <div>
              <span class="text-slate-400 text-xs">Email</span>
              <div class="font-semibold text-slate-900" x-text="selectedCandidature ? selectedCandidature.email : ''"></div>
            </div>
            <div>
              <span class="text-slate-400 text-xs">Téléphone</span>
              <div class="font-semibold text-slate-900" x-text="selectedCandidature ? selectedCandidature.telephone : ''"></div>
            </div>
            <div class="col-span-2">
              <span class="text-slate-400 text-xs">Présentation</span>
              <div class="font-semibold text-slate-900 text-xs" x-text="selectedCandidature ? selectedCandidature.presentation : ''"></div>
            </div>
          </div>
        </div>

        <!-- Formulaire d'acceptation -->
        <form :action="'/dashboard/admin/talent-candidatures/' + (selectedCandidature ? selectedCandidature.id : '') + '/approve'" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="candidature_id" :value="selectedCandidature ? selectedCandidature.id : ''">

          <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Photo du talent <span class="text-red-500">*</span></label>
            <input type="file" name="photo" required accept="image/*" class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none bg-slate-50">
            <p class="text-[10px] text-slate-400 mt-1">Veuillez joindre une photo pour le profil du talent.</p>
          </div>

          <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
            <button type="button" @click="approveModalOpen = false" class="px-4 py-2 text-xs uppercase font-bold tracking-wider text-slate-600 hover:bg-slate-100 transition-colors rounded-none">Annuler</button>
            <button type="submit" class="px-5 py-2 text-xs uppercase font-bold tracking-wider bg-emerald-600 hover:bg-emerald-700 text-white transition-colors rounded-none">Accepter et créer le talent</button>
          </div>
        </form>
      </div>
    </div>
  </div>

</div>
@endsection
