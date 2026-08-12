@extends('layouts.dashboard')

@section('title', 'Gestion des Disponibilités')

@section('content')
  {{-- ═══ Tout le contenu ET les modals sont dans le même x-data ═══ --}}
  <div class="w-full flex flex-col gap-5" x-data="{
      showAddModal: false,
      showEditModal: false,
      addType: 'ponctuel',
      addDateDispo: '{{ date('Y-m-d') }}',
      addJour: '',
      addDateDebutRecurrence: '{{ date('Y-m-d') }}',
      addDateFinRecurrence: '{{ date('Y-m-d', strtotime('+1 month')) }}',
      addDebut: '',
      addFin: '',
      addStatut: 'actif',
      editId: null,
      editDateDispo: '',
      editDebut: '',
      editFin: '',
      editStatut: '',
      openAdd(dateStr = '', debut = '', fin = '') {
          this.addType = 'ponctuel';
          this.addDateDispo = dateStr || '{{ date('Y-m-d') }}';
          
          let d = new Date(this.addDateDispo);
          const daysMap = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
          this.addJour = daysMap[d.getDay()];
          this.addDateDebutRecurrence = this.addDateDispo;
          
          this.addDebut = debut || '09:00';
          this.addFin = fin || '10:00';
          this.addStatut = 'actif';
          this.showAddModal = true;
      },
      openEdit(id, dateStr, debut, fin, statut) {
          this.editId = id;
          this.editDateDispo = dateStr;
          this.editDebut = debut;
          this.editFin = fin;
          this.editStatut = statut;
          this.showEditModal = true;
      },
      validateTime(debut, fin) {
          if (debut && fin) {
              let actualFin = fin === '00:00' ? '24:00' : fin;
              if (actualFin <= debut) {
                  alert('L\'heure de fin doit être strictement supérieure à l\'heure de début.');
                  return false;
              }
          }
          return true;
      }
  }" @open-add-modal.window="openAdd($event.detail.date, $event.detail.debut, $event.detail.fin)"
    @open-edit-modal.window="openEdit($event.detail.id, $event.detail.date, $event.detail.debut, $event.detail.fin, $event.detail.statut)">

    

    {{-- ═══════════════════════ PAGE HEADER ═══════════════════════ --}}
    <x-dashboard.page-header title="Mes Disponibilités" description="Définissez vos créneaux directement sur le calendrier interactif ou via la liste ci-dessous.">
      <button @click="openAdd()" type="button"
        class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#0BA20B] hover:bg-[#087A08] text-white font-bold text-[10px] uppercase tracking-widest transition shadow-sm cursor-pointer">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
        </svg>
        + DISPONIBILITÉ
      </button>
    </x-dashboard.page-header>

    @if ($errors->any())
      <div class="bg-red-50 border-l-4 border-red-500 p-4 shadow-sm">
        <div class="flex">
          <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
            </svg>
          </div>
          <div class="ml-3">
            <h3 class="text-sm font-medium text-red-800 uppercase tracking-widest font-bold">Erreur de validation</h3>
            <div class="mt-2 text-xs text-red-700">
              <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
      </div>
    @endif

    {{-- ═══════════════════════ CALENDRIER INTERACTIF ═══════════════════════ --}}
    <div class="bg-white border border-slate-200 shadow-sm p-6">
      <div class="flex items-center justify-between mb-4 border-b border-slate-100 pb-3">
        <div>
          <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wide flex items-center gap-2">
            <svg class="w-4 h-4 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            CALENDRIER INTERACTIF
          </h2>
          <p class="text-slate-400 text-xs mt-0.5">Cliquez sur n'importe quelle plage du calendrier pour créer un nouveau
            créneau disponible.</p>
        </div>
        <div class="flex items-center gap-3 text-[10px] uppercase font-bold tracking-widest">
          <span class="inline-flex items-center gap-1.5 text-slate-700"><span
              class="w-2.5 h-2.5 bg-[#0BA20B] inline-block border border-black/10"></span> Actif</span>
          <span class="inline-flex items-center gap-1.5 text-slate-400"><span
              class="w-2.5 h-2.5 bg-slate-300 inline-block border border-black/10"></span> Suspendu</span>
        </div>
      </div>

      <div id="calendar" class="w-full min-h-[500px]"></div>
    </div>

    {{-- ═══════════════════════ TABLEAU DISPONIBILITÉS ═══════════════════════ --}}
    <div class="bg-white border border-slate-200 shadow-sm">
      <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
        <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wide">LISTE DE MES DISPONIBILITÉS</h2>
        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $dispos->count() }}
          créneau(x)</span>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-left">
          <thead>
            <tr class="border-b border-slate-200 bg-slate-50">
              <th class="px-6 py-3 text-[9px] font-bold text-slate-400 uppercase tracking-widest">DATE</th>
              <th class="px-4 py-3 text-[9px] font-bold text-slate-400 uppercase tracking-widest">HEURE DÉBUT</th>
              <th class="px-4 py-3 text-[9px] font-bold text-slate-400 uppercase tracking-widest">HEURE FIN</th>
              {{-- <th class="px-4 py-3 text-[9px] font-bold text-slate-400 uppercase tracking-widest">STATUT</th> --}}
              <th class="px-4 py-3 text-[9px] font-bold text-slate-400 uppercase tracking-widest text-right">ACTIONS</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
            @forelse($dispos as $dispo)
              <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-6 py-3.5">
                  <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                      </svg>
                    </div>
                    <span class="font-bold text-slate-900 text-xs">{{ \Carbon\Carbon::parse($dispo->date_dispo)->locale('fr')->translatedFormat('l d F Y') }}</span>
                  </div>
                </td>
                <td class="px-4 py-3.5 text-xs font-mono text-slate-600">
                  {{ \Carbon\Carbon::parse($dispo->debut)->format('H:i') }}
                </td>
                <td class="px-4 py-3.5 text-xs font-mono text-slate-600">
                  {{ \Carbon\Carbon::parse($dispo->fin)->format('H:i') }}
                </td>
                {{-- <td class="px-4 py-3.5">
                  @if(strtolower($dispo->statut ?? 'actif') === 'actif')
                  <span
                    class="bg-emerald-100 text-emerald-700 text-[9px] font-bold px-2 py-0.5 uppercase tracking-widest border border-emerald-200">Actif</span>
                  @else
                  <span
                    class="bg-slate-100 text-slate-600 text-[9px] font-bold px-2 py-0.5 uppercase tracking-widest border border-slate-200">{{
                    ucfirst($dispo->statut ?? 'Actif') }}</span>
                  @endif
                </td> --}}
                <td class="px-4 py-3.5 text-right">
                  <div class="relative inline-block text-left" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open" type="button"
                      class="w-7 h-7 border border-slate-300 bg-white hover:bg-slate-100 text-slate-500 inline-flex items-center justify-center focus:outline-none transition-colors">
                      <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                          d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z" />
                      </svg>
                    </button>
                    <div x-show="open" x-transition:enter="transition ease-out duration-100"
                      x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                      x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
                      x-transition:leave-end="opacity-0 scale-95"
                      class="absolute right-0 mt-1 w-44 bg-white shadow-lg border border-slate-200 z-50 divide-y divide-slate-100"
                      style="display:none;">
                      <button type="button"
                        @click="openEdit({{ $dispo->id }}, '{{ $dispo->date_dispo }}', '{{ \Carbon\Carbon::parse($dispo->debut)->format('H:i') }}', '{{ \Carbon\Carbon::parse($dispo->fin)->format('H:i') }}', '{{ $dispo->statut ?? 'actif' }}'); open = false"
                        class="w-full flex items-center gap-2 px-4 py-2.5 text-xs text-slate-700 hover:bg-slate-50 font-semibold text-left">
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Modifier
                      </button>
                      <form method="POST" action="{{ route('dashboard.professeur.disponibilites.destroy', $dispo->id) }}"
                        class="w-full">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Confirmer la suppression de cette disponibilité ?')"
                          class="w-full flex items-center gap-2 px-4 py-2.5 text-xs text-red-600 hover:bg-red-50 font-semibold text-left">
                          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                          </svg>
                          Supprimer
                        </button>
                      </form>
                    </div>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="px-6 py-16 text-center">
                  <svg class="w-12 h-12 text-slate-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                  <p class="text-sm text-slate-400 mb-4 font-sans">Aucune disponibilité enregistrée pour le moment.</p>
                  <button @click="openAdd()" type="button"
                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#0BA20B] hover:bg-[#087A08] text-white font-bold text-[10px] uppercase tracking-widest transition shadow-sm cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Ajouter ma première disponibilité
                  </button>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    {{-- ══════════════════════ MODAL : Nouvelle Disponibilité ══════════════════════ --}}
    <div x-show="showAddModal"
      class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm" x-cloak
      style="display:none;">
      <div @click.away="showAddModal = false"
        class="bg-white w-full max-w-lg shadow-2xl border border-slate-200 max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center px-6 py-4 border-b border-slate-200 bg-slate-50">
          <div>
            <h3 class="font-bold text-slate-900 text-sm uppercase tracking-wide">Ajouter une Disponibilité</h3>
            <p class="text-[11px] text-slate-400 mt-0.5">Créez une nouvelle plage horaire hebdomadaire.</p>
          </div>
          <button @click="showAddModal = false"
            class="w-8 h-8 border border-slate-300 bg-white flex items-center justify-center text-slate-500 hover:text-slate-900 hover:bg-slate-100 transition-colors text-lg font-bold leading-none">&times;</button>
        </div>
        <form action="{{ route('dashboard.professeur.disponibilites.store') }}" method="POST"
          @submit="if(!validateTime(addDebut, addFin)) $event.preventDefault()" class="p-6 space-y-4">
          @csrf
          <div class="flex gap-4 mb-4">
            <label class="flex items-center gap-2 text-xs font-bold text-slate-700 cursor-pointer">
              <input type="radio" name="type_dispo" value="ponctuel" x-model="addType" class="text-[#0BA20B] focus:ring-[#0BA20B]"> Date Spécifique
            </label>
            <label class="flex items-center gap-2 text-xs font-bold text-slate-700 cursor-pointer">
              <input type="radio" name="type_dispo" value="recurrent" x-model="addType" class="text-[#0BA20B] focus:ring-[#0BA20B]"> Plage Récurrente
            </label>
          </div>

          <div x-show="addType === 'ponctuel'">
            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5 font-sans">Date <span class="text-red-500">*</span></label>
            <input type="date" name="date_dispo" x-model="addDateDispo" min="{{ date('Y-m-d') }}" :required="addType === 'ponctuel'"
              class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-[#0BA20B] transition" />
          </div>

          <div x-show="addType === 'recurrent'" class="space-y-4 bg-slate-50 p-4 border border-slate-200 mb-4">
            <div>
              <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5 font-sans">Jour de
                la semaine <span class="text-red-500">*</span></label>
              <select name="jour" x-model="addJour" :required="addType === 'recurrent'"
                class="w-full px-3 py-2 bg-white border border-slate-300 text-sm focus:outline-none focus:border-[#0BA20B] transition">
                <option value="">Sélectionner le jour</option>
                <option value="Lundi">Lundi</option>
                <option value="Mardi">Mardi</option>
                <option value="Mercredi">Mercredi</option>
                <option value="Jeudi">Jeudi</option>
                <option value="Vendredi">Vendredi</option>
                <option value="Samedi">Samedi</option>
                <option value="Dimanche">Dimanche</option>
              </select>
            </div>
            <div class="grid grid-cols-2 gap-3">
              <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5 font-sans">Du <span class="text-red-500">*</span></label>
                <input type="date" name="date_debut_recurrence" x-model="addDateDebutRecurrence" min="{{ date('Y-m-d') }}" :required="addType === 'recurrent'"
                  class="w-full px-3 py-2 bg-white border border-slate-300 text-sm focus:outline-none focus:border-[#0BA20B] transition" />
              </div>
              <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5 font-sans">Au <span class="text-red-500">*</span></label>
                <input type="date" name="date_fin_recurrence" x-model="addDateFinRecurrence" min="{{ date('Y-m-d') }}" :required="addType === 'recurrent'"
                  class="w-full px-3 py-2 bg-white border border-slate-300 text-sm focus:outline-none focus:border-[#0BA20B] transition" />
              </div>
            </div>
          </div>
          <div>
            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5 font-sans">Heure de
              début <span class="text-red-500">*</span></label>
            <input type="time" name="debut" required x-model="addDebut"
              class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-[#0BA20B] transition" />
          </div>
          <div>
            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5 font-sans">Heure de
              fin <span class="text-red-500">*</span></label>
            <input type="time" name="fin" required x-model="addFin"
              class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-[#0BA20B] transition" />
          </div>
          <div>
            <label
              class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5 font-sans">Statut</label>
            <select name="statut" x-model="addStatut"
              class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-[#0BA20B] transition">
              <option value="actif">Actif (Disponible pour réservations)</option>
              <option value="suspendu">Suspendu (Indisponible temporairement)</option>
            </select>
          </div>
          <div class="flex justify-end gap-3 pt-3 border-t border-slate-200">
            <button type="button" @click="showAddModal = false"
              class="px-4 py-2 text-xs font-bold uppercase tracking-wider text-slate-500 hover:text-slate-900 hover:bg-slate-100 border border-transparent hover:border-slate-200 transition">
              Annuler
            </button>
            <button type="submit"
              class="px-5 py-2 bg-[#0BA20B] hover:bg-[#087A08] text-white font-bold text-xs uppercase tracking-widest shadow-sm transition">
              Enregistrer
            </button>
          </div>
        </form>
      </div>
    </div>

    {{-- ══════════════════════ MODAL : Modifier Disponibilité ══════════════════════ --}}
    <div x-show="showEditModal"
      class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm" x-cloak
      style="display:none;">
      <div @click.away="showEditModal = false"
        class="bg-white w-full max-w-lg shadow-2xl border border-slate-200 max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center px-6 py-4 border-b border-slate-200 bg-slate-50">
          <div>
            <h3 class="font-bold text-slate-900 text-sm uppercase tracking-wide">Modifier la Disponibilité</h3>
            <p class="text-[11px] text-slate-400 mt-0.5">Mettez à jour les horaires de cette plage.</p>
          </div>
          <button @click="showEditModal = false"
            class="w-8 h-8 border border-slate-300 bg-white flex items-center justify-center text-slate-500 hover:text-slate-900 hover:bg-slate-100 transition-colors text-lg font-bold leading-none">&times;</button>
        </div>
        <form :action="'{{ url('dashboard/professeur/disponibilites') }}/' + editId" method="POST"
          @submit="if(!validateTime(editDebut, editFin)) $event.preventDefault()" class="p-6 space-y-4">
          @csrf
          @method('PUT')
          <div>
            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5 font-sans">Date <span class="text-red-500">*</span></label>
            <input type="date" name="date_dispo" required x-model="editDateDispo" min="{{ date('Y-m-d') }}"
              class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-[#0BA20B] transition" />
          </div>
          <div>
            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5 font-sans">Heure de
              début <span class="text-red-500">*</span></label>
            <input type="time" name="debut" required x-model="editDebut"
              class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-[#0BA20B] transition" />
          </div>
          <div>
            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5 font-sans">Heure de
              fin <span class="text-red-500">*</span></label>
            <input type="time" name="fin" required x-model="editFin"
              class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-[#0BA20B] transition" />
          </div>
          <div>
            <label
              class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5 font-sans">Statut</label>
            <select name="statut" x-model="editStatut"
              class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-[#0BA20B] transition">
              <option value="actif">Actif (Disponible pour réservations)</option>
              <option value="suspendu">Suspendu (Indisponible temporairement)</option>
            </select>
          </div>
          <div class="flex justify-end gap-3 pt-3 border-t border-slate-200">
            <button type="button" @click="showEditModal = false"
              class="px-4 py-2 text-xs font-bold uppercase tracking-wider text-slate-500 hover:text-slate-900 hover:bg-slate-100 border border-transparent hover:border-slate-200 transition">
              Annuler
            </button>
            <button type="submit"
              class="px-5 py-2 bg-[#0BA20B] hover:bg-[#087A08] text-white font-bold text-xs uppercase tracking-widest shadow-sm transition">
              Mettre à jour
            </button>
          </div>
        </form>
      </div>
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var calendarEl = document.getElementById('calendar');
      if (!calendarEl) return;

      var rawDispos = @json($dispos);
      var events = rawDispos.map(function (d) {
        if (!d.date_dispo) return null; // Skip legacy slots without dates just in case
        var isActif = (d.statut || 'actif').toLowerCase() === 'actif';
        return {
          id: d.id,
          title: d.debut.substring(0, 5) + ' - ' + d.fin.substring(0, 5),
          start: d.date_dispo + 'T' + d.debut,
          end: d.date_dispo + 'T' + d.fin,
          backgroundColor: isActif ? '#0BA20B' : '#E2E8F0',
          borderColor: isActif ? '#087A08' : '#CBD5E1',
          textColor: isActif ? '#FFFFFF' : '#64748B',
          extendedProps: {
            id: d.id,
            date_dispo: d.date_dispo,
            debut: d.debut.substring(0, 5),
            fin: d.fin.substring(0, 5),
            statut: d.statut || 'actif'
          }
        };
      }).filter(Boolean);

      var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'timeGridWeek',
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'timeGridWeek,timeGridDay'
        },
        locale: 'fr',
        firstDay: 1,
        slotMinTime: '07:00:00',
        slotMaxTime: '25:00:00',
        allDaySlot: false,
        events: events,
        selectable: true,
        select: function (info) {
          var now = new Date();
          if (info.start < now && info.startStr.split('T')[0] !== now.toISOString().split('T')[0]) {
              // Note: strictly speaking, we compare dates, but let's just do a simple check
          }
          if (info.start < now) {
            alert('Impossible de définir une disponibilité dans le passé.');
            calendar.unselect();
            return;
          }
          var dateStr = info.startStr.split('T')[0];
          var startHHMM = info.start.toTimeString().substring(0, 5);
          var endHHMM = info.end.toTimeString().substring(0, 5);
          if (endHHMM <= startHHMM) {
            var parts = startHHMM.split(':').map(Number);
            var h = (parts[0] + 1) % 24;
            endHHMM = (h < 10 ? '0' : '') + h + ':' + (parts[1] < 10 ? '0' : '') + parts[1];
          }
          window.dispatchEvent(new CustomEvent('open-add-modal', {
            detail: { date: dateStr, debut: startHHMM, fin: endHHMM }
          }));
        },
        eventClick: function (info) {
          var props = info.event.extendedProps;
          if (props && props.id) {
            window.dispatchEvent(new CustomEvent('open-edit-modal', {
              detail: { id: props.id, date: props.date_dispo, debut: props.debut, fin: props.fin, statut: props.statut }
            }));
          }
        }
      });

      calendar.render();
    });
  </script>
@endsection