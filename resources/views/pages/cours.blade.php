@extends('layouts.app')
@section('title', 'Écho & Culture — Cours')

@section('content')
<section class="pt-32 pb-24 bg-[#F4EFE6] relative overflow-hidden" id="courses"
    x-data="{
        showModal: false,
        coursId: null,
        coursTitre: '',
        profName: '',
        coursMode: '',
        coursTarif: '',
        disponibilites: [],
        loading: false,
        dateReservation: '',
        heureDebut: '',
        heureFin: '',
        errorMessage: '',
        activeCategory: 'Tous',
        activeMode: 'Tous',

        openBookingModal(id, titre, prof, mode = '', tarif = '') {
            this.coursId = id;
            this.coursTitre = titre;
            this.profName = prof;
            this.coursMode = mode;
            this.coursTarif = tarif;
            this.showModal = true;
            this.loading = true;
            this.disponibilites = [];
            this.errorMessage = '';
            this.dateReservation = '';
            this.heureDebut = '';
            this.heureFin = '';

            fetch('/api/cours/' + id + '/slots')
                .then(res => res.json())
                .then(data => {
                    this.disponibilites = data;
                    this.loading = false;
                })
                .catch(err => {
                    console.error('Erreur:', err);
                    this.loading = false;
                    this.errorMessage = 'Erreur lors du chargement des disponibilités.';
                });
        },

        get groupedSlots() {
            const groups = {};
            this.disponibilites.forEach(slot => {
                const jour = slot.jour;
                if (!groups[jour]) {
                    groups[jour] = [];
                }
                groups[jour].push(slot);
            });
            return groups;
        },

        getNextDateForDay(dayName) {
            const daysMap = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
            const targetDay = daysMap.findIndex(day => day.toLowerCase() === dayName.toLowerCase());
            if (targetDay === -1) return null;

            const today = new Date();
            const currentDay = today.getDay();
            let daysUntil = targetDay - currentDay;
            if (daysUntil <= 0) {
                daysUntil += 7;
            }

            const nextDate = new Date(today);
            nextDate.setDate(today.getDate() + daysUntil);
            return nextDate.toISOString().split('T')[0];
        },

        selectSlot(slot) {
            const nextDate = this.getNextDateForDay(slot.jour);
            if (nextDate) {
                this.dateReservation = nextDate;
            }
            if (slot.debut) this.heureDebut = slot.debut.substring(0, 5);
            if (slot.fin) this.heureFin = slot.fin.substring(0, 5);
            this.errorMessage = '';
        },

        onDateChange(e) {
            const selectedDateStr = e.target.value;
            if (!selectedDateStr) return;
            const selectedDate = new Date(selectedDateStr + 'T00:00:00');
            const daysMap = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
            const dayName = daysMap[selectedDate.getDay()];

            const availableForDay = this.disponibilites.filter(slot => slot.jour.toLowerCase() === dayName.toLowerCase());
            if (availableForDay.length > 0) {
                this.heureDebut = availableForDay[0].debut.substring(0, 5);
                this.heureFin = availableForDay[0].fin.substring(0, 5);
                this.errorMessage = '';
            } else {
                this.errorMessage = 'Le professeur n\'a pas de créneau disponible le ' + dayName + '.';
            }
        },

        validateForm(e) {
            if (!this.dateReservation) return;
            const selectedDate = new Date(this.dateReservation + 'T00:00:00');
            const daysMap = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
            const dayName = daysMap[selectedDate.getDay()];

            const isAvailableDay = this.disponibilites.some(slot => slot.jour.toLowerCase() === dayName.toLowerCase());
            if (!isAvailableDay) {
                e.preventDefault();
                this.errorMessage = 'Erreur : Le professeur n\'est pas disponible le ' + dayName + '.';
            }
        }
    }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
        {{-- Flash Notifications --}}
        @if (session('success'))
            <div class="p-4 bg-emerald-100 border-l-4 border-emerald-500 text-emerald-800 text-sm font-semibold flex items-center justify-between shadow-sm">
                <span>{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="text-emerald-800 text-lg leading-none">&times;</button>
            </div>
        @endif

        @if (session('error'))
            <div class="p-4 bg-red-100 border-l-4 border-red-500 text-red-800 text-sm font-semibold flex items-center justify-between shadow-sm">
                <span>{{ session('error') }}</span>
                <button onclick="this.parentElement.remove()" class="text-red-800 text-lg leading-none">&times;</button>
            </div>
        @endif

        @if ($errors->any())
            <div class="p-4 bg-red-100 border-l-4 border-red-500 text-red-800 text-sm font-semibold shadow-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
<div class="text-center max-w-3xl mx-auto space-y-4">
<div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-none bg-[#F4EFE6] border border-[#0BA20B]/40 text-[#0BA20B] text-xs font-bold uppercase tracking-widest">
<svg aria-hidden="true" class="lucide lucide-graduation-cap w-3.5 h-3.5" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z">
</path>
<path d="M22 10v6">
</path>
<path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5">
</path>
</svg>
<span>
      Formations, Ateliers &amp; Transmission des Savoirs
     </span>
</div>
<h2 class="font-serif-title text-3xl sm:text-4xl md:text-5xl font-bold text-[#2C221E] tracking-tight">
     Catalogue des Cours &amp; Ateliers de Pratique
    </h2>
<p class="text-sm sm:text-base text-[#6B574F] font-sans leading-relaxed">
     Formez-vous aux instruments traditionnels et modernes, à la polyphonie vocale ou au tressage éco-artisanat du Raphia. Cours dispensés en présentiel ou à distance.
    </p>
</div>
<div class="bg-[#F4EFE6] p-4 rounded-none border border-[#0BA20B]/30 flex flex-col md:flex-row items-center justify-between gap-4">
    <div class="flex items-center gap-2 overflow-x-auto w-full md:w-auto pb-2 md:pb-0">
        <span class="text-xs font-bold text-[#2C221E] uppercase flex items-center gap-1 shrink-0">
            <svg aria-hidden="true" class="lucide lucide-funnel w-3.5 h-3.5 text-[#0BA20B]" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                <path d="M10 20a1 1 0 0 0 .553.895l2 1A1 1 0 0 0 14 21v-7a2 2 0 0 1 .517-1.341L21.74 4.67A1 1 0 0 0 21 3H3a1 1 0 0 0-.742 1.67l7.225 7.989A2 2 0 0 1 10 14z"></path>
            </svg>
            Catégories :
        </span>
        <button @click="activeCategory = 'Tous'"
            :class="activeCategory === 'Tous' ? 'bg-[#0BA20B] text-white' : 'bg-[#FAF7F2] text-[#2C221E] hover:bg-white border border-[#0BA20B]/30'"
            class="px-3 py-1.5 rounded-none text-xs font-semibold capitalize whitespace-nowrap transition-all shadow-sm">
            Tous
        </button>
        @foreach($categoriesCours ?? [] as $cat)
            <button @click="activeCategory = '{{ addslashes($cat->nom) }}'"
                :class="activeCategory === '{{ addslashes($cat->nom) }}' ? 'bg-[#0BA20B] text-white' : 'bg-[#FAF7F2] text-[#2C221E] hover:bg-white border border-[#0BA20B]/30'"
                class="px-3 py-1.5 rounded-none text-xs font-semibold capitalize whitespace-nowrap transition-all shadow-sm">
                {{ $cat->nom }}
            </button>
        @endforeach
    </div>
    
</div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @forelse($cours as $item)
        @php
            $catName = $item->categorie ? $item->categorie->nom : 'Art & Culture';
            $catLower = strtolower($catName);
            $modeName = $item->mode ? $item->mode->libelle : 'Présentiel';
            $profName = $item->professeur ? $item->professeur->name : 'Association';

            // Image par défaut générée selon la catégorie du cours
            if (\Illuminate\Support\Str::contains($catLower, ['raphia', 'artisanat', 'tissage', 'sculpture'])) {
                $cardImg = '/assets/raphia_artisanal_crafts_1785764982514-DDF_8lz7.jpg';
            } elseif (\Illuminate\Support\Str::contains($catLower, ['moderne', 'guitare', 'piano', 'synthé'])) {
                $cardImg = 'https://images.unsplash.com/photo-1510915361894-db8b60106cb1?auto=format&fit=crop&q=80&w=800';
            } elseif (\Illuminate\Support\Str::contains($catLower, ['tradition', 'instruments', 'balafon', 'kora', 'djembé', 'percussion'])) {
                $cardImg = 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&q=80&w=800';
            } else {
                $catIdImages = [
                    1 => 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&q=80&w=800',
                    2 => 'https://images.unsplash.com/photo-1510915361894-db8b60106cb1?auto=format&fit=crop&q=80&w=800',
                    3 => '/assets/raphia_artisanal_crafts_1785764982514-DDF_8lz7.jpg',
                ];
                $cardImg = $catIdImages[$item->categorie_cours_id ?? 0] ?? 'https://images.unsplash.com/photo-1519892300165-cb5542fb47c7?auto=format&fit=crop&q=80&w=800';
            }
        @endphp
        <div x-show="(activeCategory === 'Tous' || activeCategory === '{{ addslashes($catName) }}') && (activeMode === 'Tous' || activeMode === '{{ addslashes($modeName) }}')"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100"
            class="bg-white rounded-none overflow-hidden border border-[#0BA20B]/30 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
            <div>
                <div class="relative h-52 overflow-hidden bg-slate-900">
                    <img alt="{{ $item->titre }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                        referrerpolicy="no-referrer" src="{{ $cardImg }}" />
                    <div class="absolute top-3 left-3 right-3 flex items-center justify-between">
                        <span
                            class="bg-[#1E1613]/85 text-[#0BA20B] text-[10px] font-bold px-2.5 py-1 rounded-none backdrop-blur-sm uppercase">
                            {{ $catName }}
                        </span>
                        <span
                            class="text-[10px] font-bold px-2.5 py-1 rounded-none text-white backdrop-blur-sm {{ \Illuminate\Support\Str::contains(strtolower($modeName), ['distanciel', 'ligne', 'visio']) ? 'bg-emerald-600' : 'bg-[#0BA20B]' }}">
                            {{ $modeName }}
                        </span>
                    </div>
                    <div
                        class="absolute bottom-3 left-3 bg-[#1E1613]/80 text-white text-[10px] font-semibold px-2 py-0.5 rounded-none backdrop-blur-sm flex items-center gap-1.5">
                        <span
                            class="w-2 h-2 rounded-full {{ $item->actif === 'OUI' ? 'bg-emerald-400 animate-pulse' : 'bg-rose-400' }}"></span>
                        <span>Statut:
                            {{ $item->actif === 'OUI' ? 'Inscriptions ouvertes' : 'Session fermée' }}</span>
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center gap-3 pb-3 border-b border-[#0BA20B]/20">
                        <div
                            class="w-10 h-10 bg-[#1E1613] text-[#0BA20B] font-bold flex items-center justify-center text-xs uppercase border border-[#0BA20B]/40 shrink-0">
                            {{ strtoupper(substr($profName, 0, 2)) }}
                        </div>
                        <div>
                            <h5 class="font-bold text-xs text-[#2C221E]">
                                {{ $profName }}
                            </h5>
                            <span class="text-[10px] text-[#0BA20B] font-semibold block">
                                Professeur / Formatrice
                            </span>
                        </div>
                    </div>
                    <h4 class="font-serif-title font-bold text-lg text-[#2C221E] leading-snug line-clamp-2">
                        {{ $item->titre }}
                    </h4>
                    <p class="text-xs text-[#6B574F] line-clamp-3 leading-relaxed">
                        {{ $item->description ?? 'Cours pratique avec encadrement pédagogique personnalisé et transmission des savoirs.' }}
                    </p>
                    <div class="space-y-2 text-xs text-[#8C766B] pt-2 border-t border-[#0BA20B]/20">
                        <p class="flex items-center gap-2">
                            <svg aria-hidden="true" class="lucide lucide-tag w-3.5 h-3.5 text-[#0BA20B]"
                                fill="none" height="24" stroke="currentColor" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2H2v10l10 10 10-10L12 2z"></path>
                                <circle cx="7" cy="7" r="1.5"></circle>
                            </svg>
                            <span>Catégorie : <strong class="text-[#2C221E]">{{ $catName }}</strong></span>
                        </p>
                        <p class="flex items-center gap-2">
                            <svg aria-hidden="true" class="lucide lucide-monitor w-3.5 h-3.5 text-[#0BA20B]"
                                fill="none" height="24" stroke="currentColor" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                                <line x1="8" y1="21" x2="16" y2="21"></line>
                                <line x1="12" y1="17" x2="12" y2="21"></line>
                            </svg>
                            <span>Mode : <strong class="text-[#2C221E]">{{ $modeName }}</strong></span>
                        </p>
                        <p class="flex items-center gap-2">
                            <svg aria-hidden="true" class="lucide lucide-user-check w-3.5 h-3.5 text-[#0BA20B]"
                                fill="none" height="24" stroke="currentColor" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="8.5" cy="7" r="4"></circle>
                                <polyline points="17 11 19 13 23 9"></polyline>
                            </svg>
                            <span>Professeur : <strong class="text-[#2C221E]">{{ $profName }}</strong></span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="p-6 pt-0 flex items-center justify-between border-t border-[#0BA20B]/10 mt-2">
                <div>
                    <span class="text-[10px] uppercase text-[#8C766B] block font-semibold">Tarif</span>
                    <span class="font-bold font-serif-title text-lg text-[#0BA20B]">
                        {{ number_format($item->tarif, 0, ',', ' ') }} € <span
                            class="text-[11px] font-sans font-normal text-[#6B574F]">/ séance</span>
                    </span>
                </div>
                <button
                    @click="openBookingModal({{ $item->id }}, '{{ addslashes($item->titre) }}', '{{ addslashes($profName) }}', '{{ addslashes($modeName) }}', '{{ number_format($item->tarif, 0, ',', ' ') }}')"
                    class="px-4 py-2 rounded-none bg-[#0BA20B] hover:bg-[#087A08] text-white text-xs font-bold transition-all shadow-md hover:shadow-lg flex items-center gap-1.5 cursor-pointer">
                    <svg aria-hidden="true" class="lucide lucide-graduation-cap w-4 h-4" fill="none" height="24"
                        stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z">
                        </path>
                        <path d="M22 10v6"></path>
                        <path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"></path>
                    </svg>
                    <span>
                        S'inscrire
                    </span>
                </button>
            </div>
        </div>
    @empty
        <div class="col-span-3 text-center py-12 text-[#8C766B]">
            <p class="text-sm">Aucun cours n'est actuellement disponible dans le catalogue.</p>
        </div>
    @endforelse
</div>

  {{-- MODAL DE RÉSERVATION DE COURS SELON LES DISPONIBILITÉS DU PROFESSEUR --}}
  <div x-show="showModal"
       class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-[#1E1613]/70 backdrop-blur-sm"
       x-cloak
       style="display:none;">
    <div @click.away="showModal = false"
         class="bg-[#FAF7F2] w-full max-w-lg shadow-2xl border border-[#0BA20B]/40 p-6 sm:p-8 relative">
      
      <div class="flex justify-between items-start border-b border-[#0BA20B]/20 pb-4 mb-5">
        <div>
          <div class="flex items-center gap-2">
            <span class="text-[10px] font-bold uppercase tracking-widest text-[#0BA20B]">Réservation de cours</span>
            <span x-show="coursMode" class="text-[9px] font-bold uppercase px-2 py-0.5 bg-[#1E1613] text-[#0BA20B]" x-text="coursMode"></span>
          </div>
          <h3 class="font-serif-title font-bold text-xl text-[#2C221E] mt-0.5" x-text="coursTitre"></h3>
          <p class="text-xs text-[#6B574F] mt-1" x-text="'Professeur : ' + profName"></p>
        </div>
        <button @click="showModal = false" class="text-[#2C221E] hover:text-[#0BA20B] text-2xl font-bold leading-none cursor-pointer">&times;</button>
      </div>

      {{-- Loader --}}
      <div x-show="loading" class="py-8 text-center text-xs text-[#6B574F]">
        <svg class="animate-spin h-6 w-6 text-[#0BA20B] mx-auto mb-2" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Chargement des disponibilités du professeur...
      </div>

      <div x-show="!loading">
        {{-- Section Disponibilités du professeur --}}
        <div class="mb-5 bg-[#F4EFE6] border border-[#0BA20B]/30 p-3.5">
          <h4 class="text-[10px] font-bold uppercase tracking-widest text-[#2C221E] mb-2 flex items-center gap-1.5">
            <svg class="w-3.5 h-3.5 text-[#0BA20B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Disponibilités hebdomadaires du professeur :
          </h4>
          <template x-if="disponibilites.length === 0">
            <p class="text-xs text-[#8C766B] italic">Aucune disponibilité enregistrée pour le moment.</p>
          </template>
          <div class="flex flex-wrap gap-2 mt-1">
            <template x-for="slot in disponibilites" :key="slot.id">
              <span class="inline-flex items-center gap-1 bg-white border border-[#0BA20B]/40 px-2.5 py-1 text-[11px] font-bold text-[#2C221E]">
                <span class="w-1.5 h-1.5 bg-[#5EF527] rounded-full inline-block"></span>
                <span x-text="slot.jour + ' : ' + slot.debut.substring(0,5) + ' - ' + slot.fin.substring(0,5)"></span>
              </span>
            </template>
          </div>
        </div>

        {{-- Formulaire de réservation --}}
        <form action="{{ route('reservations.store') }}" method="POST" @submit="validateForm($event)" class="space-y-4">
          @csrf
          <input type="hidden" name="cours_id" :value="coursId" />

          <div>
            <label class="block text-[10px] font-bold uppercase tracking-widest text-[#2C221E] mb-1">
              Date souhaitée <span class="text-[#0BA20B]">*</span>
            </label>
            <input type="date" name="date_reservation" required min="{{ date('Y-m-d') }}"
                   x-model="dateReservation" @change="onDateChange($event)"
                   class="w-full px-3 py-2 bg-white border border-[#0BA20B]/50 text-xs text-[#2C221E] focus:outline-none focus:border-[#0BA20B]" />
          </div>

          <div class="grid grid-cols-2 gap-3">
            <div>
              <label class="block text-[10px] font-bold uppercase tracking-widest text-[#2C221E] mb-1">
                Heure de début <span class="text-[#0BA20B]">*</span>
              </label>
              <input type="time" name="heure_debut" required x-model="heureDebut"
                     class="w-full px-3 py-2 bg-white border border-[#0BA20B]/50 text-xs text-[#2C221E] focus:outline-none focus:border-[#0BA20B]" />
            </div>
            <div>
              <label class="block text-[10px] font-bold uppercase tracking-widest text-[#2C221E] mb-1">
                Heure de fin <span class="text-[#0BA20B]">*</span>
              </label>
              <input type="time" name="heure_fin" required x-model="heureFin"
                     class="w-full px-3 py-2 bg-white border border-[#0BA20B]/50 text-xs text-[#2C221E] focus:outline-none focus:border-[#0BA20B]" />
            </div>
          </div>

          <div x-show="errorMessage" class="p-3 bg-red-50 border border-red-200 text-red-700 text-xs font-semibold">
            <span x-text="errorMessage"></span>
          </div>

          <div class="flex justify-end gap-3 pt-3 border-t border-[#0BA20B]/20">
            <button type="button" @click="showModal = false"
                    class="px-4 py-2 text-xs font-bold uppercase tracking-wider text-[#6B574F] hover:text-[#2C221E] cursor-pointer">
              Annuler
            </button>
            <button type="submit" :disabled="disponibilites.length === 0"
                    class="px-5 py-2.5 bg-[#0BA20B] hover:bg-[#087A08] disabled:opacity-50 text-white font-bold text-xs uppercase tracking-widest transition shadow-md cursor-pointer">
              Confirmer la réservation
            </button>
          </div>
        </form>
      </div>

    </div>
  </div>

</section>
@endsection
