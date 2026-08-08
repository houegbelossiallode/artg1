@extends('layouts.dashboard')

@section('title', 'Espace Apprenant | Écho & Culture')

@section('content')
  <div class="w-full h-full flex flex-col space-y-6" x-data="{
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
        activeSlotDay: '',

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
            this.activeSlotDay = '';

            fetch('/api/cours/' + id + '/slots')
                .then(res => res.json())
                .then(data => {
                    this.disponibilites = data.disponibilites || [];
                    this.loading = false;
                    if (this.disponibilites.length > 0) {
                        this.activeSlotDay = this.disponibilites[0].jour;
                        this.selectSlot(this.disponibilites[0]);
                    }
                })
                .catch(err => {
                    console.error(err);
                    this.loading = false;
                });
        },

        getNextDateForDay(dayName) {
            if (!dayName) return '';
            const daysMap = ['dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];
            const targetDayIndex = daysMap.indexOf(dayName.toLowerCase().trim());
            if (targetDayIndex === -1) return '';

            const today = new Date();
            let daysUntil = (targetDayIndex - today.getDay() + 7) % 7;
            if (daysUntil === 0) daysUntil = 7;

            const nextDate = new Date(today);
            nextDate.setDate(today.getDate() + daysUntil);

            const yyyy = nextDate.getFullYear();
            const mm = String(nextDate.getMonth() + 1).padStart(2, '0');
            const dd = String(nextDate.getDate()).padStart(2, '0');
            return yyyy + '-' + mm + '-' + dd;
        },

        formatDateFr(dateStr) {
            if (!dateStr) return '';
            const parts = dateStr.split('-');
            if (parts.length !== 3) return dateStr;
            return parts[2] + '/' + parts[1] + '/' + parts[0];
        },

        getSlotNextDateFormatted(jourName) {
            const dateStr = this.getNextDateForDay(jourName);
            return dateStr ? this.formatDateFr(dateStr) : '';
        },

        getGroupedDisponibilites() {
            const groups = {};
            (this.disponibilites || []).forEach(slot => {
                const jour = slot.jour || 'Disponible';
                if (!groups[jour]) {
                    groups[jour] = [];
                }
                groups[jour].push(slot);
            });
            return groups;
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
            const daysMap = ['dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];
            const selectedDayName = daysMap[selectedDate.getDay()];

            const matchingSlot = (this.disponibilites || []).find(s => (s.jour || '').toLowerCase().trim() === selectedDayName);
            if (matchingSlot) {
                if (matchingSlot.debut) this.heureDebut = matchingSlot.debut.substring(0, 5);
                if (matchingSlot.fin) this.heureFin = matchingSlot.fin.substring(0, 5);
                this.errorMessage = '';
            } else if (this.disponibilites.length > 0) {
                const validDays = [...new Set(this.disponibilites.map(s => s.jour))].join(', ');
                this.errorMessage = 'Le professeur n\'est pas disponible le ' + selectedDayName + '. Jours disponibles : ' + validDays;
            }
        },

        validateForm(e) {
            if (this.disponibilites.length === 0) return;
            const selectedDate = new Date(this.dateReservation + 'T00:00:00');
            const daysMap = ['dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];
            const selectedDayName = daysMap[selectedDate.getDay()];

            const isValidDay = (this.disponibilites || []).some(s => (s.jour || '').toLowerCase().trim() === selectedDayName);
            if (!isValidDay) {
                e.preventDefault();
                const validDays = [...new Set(this.disponibilites.map(s => s.jour))].join(', ');
                this.errorMessage = 'Le professeur n\'est disponible que les jours suivants : ' + validDays;
            }
        }
    }">

    <!-- Page Header -->
    <div
      class="bg-white border border-slate-200 shadow-sm px-6 py-5 border-l-4 border-l-[#C85A32] flex flex-col sm:flex-row sm:items-center justify-between gap-4">
      <div>
        <h1 class="text-lg font-bold text-slate-900 uppercase tracking-wide">ESPACE APPRENANT</h1>
        <p class="text-slate-500 text-sm mt-0.5">Bienvenue {{ Auth::user()->prenom ?? Auth::user()->name }}. Retrouvez vos
          cours, vos visioconférences Jitsi et réservez de nouveaux ateliers.</p>
      </div>
      <div class="flex items-center gap-2">
        <a href="{{ route('dashboard.apprenant.cours') }}"
          class="bg-[#C85A32] text-white text-xs font-bold px-4 py-2 uppercase tracking-wider shadow hover:bg-[#A84223] transition">
          + Réserver un cours
        </a>
      </div>
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

    <!-- Bento Box Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

      <!-- 1. Prochain Cours (Dynamic) -->
      <div
        class="md:col-span-3 bg-[#1E1613] text-white relative overflow-hidden group min-h-[260px] flex flex-col justify-end p-6 md:p-8 border border-[#D4A373]/30 shadow-xl">
        <img src="/assets/hero_cultural_bg_1785764970571-BS2uarbi.jpg" alt="Musique"
          class="absolute inset-0 w-full h-full object-cover opacity-30 group-hover:opacity-40 group-hover:scale-105 transition-all duration-700" />
        <div class="absolute inset-0 bg-gradient-to-t from-[#1E1613] via-[#1E1613]/70 to-transparent"></div>

        <div class="relative z-10 flex flex-col sm:flex-row justify-between items-start sm:items-end w-full gap-4">
          <div>
            @if($prochainCours)
              <div
                class="inline-flex items-center gap-2 bg-[#C85A32] text-white text-[10px] font-bold uppercase tracking-widest px-3 py-1 mb-3">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                Prochain cours : {{ \Carbon\Carbon::parse($prochainCours->date_reservation)->translatedFormat('l d F Y') }}
                à {{ \Carbon\Carbon::parse($prochainCours->heure_debut)->format('H\hi') }}
              </div>
              <h2 class="text-2xl sm:text-4xl font-serif-title font-bold text-white mb-1">
                {{ $prochainCours->course ? $prochainCours->course->titre : 'Mon Cours' }}
              </h2>
              <p class="text-[#D1C5B8] text-xs sm:text-sm font-light flex items-center gap-2">
                <span>📍
                  {{ $prochainCours->course && $prochainCours->course->mode ? $prochainCours->course->mode->libelle : 'Atelier' }}</span>
                <span>• Prof.
                  {{ $prochainCours->course && $prochainCours->course->professeur ? $prochainCours->course->professeur->name : 'Écho & Culture' }}</span>
              </p>
            @else
              <span
                class="inline-block bg-white/10 text-[#D4A373] text-[10px] font-bold uppercase tracking-widest px-3 py-1 mb-3">Aucun
                cours imminent</span>
              <h2 class="text-2xl sm:text-3xl font-serif-title font-bold text-white mb-1">Explorez nos Formations & Ateliers
              </h2>
              <p class="text-[#D1C5B8] text-xs font-light">Inscrivez-vous à nos cours de musique traditionnelle, chant ou
                artisanat du Raphia.</p>
            @endif
          </div>

          <div>
            @if($prochainCours)
              @if($prochainCours->jitsi_room_id || ($prochainCours->course && $prochainCours->course->mode && Str::contains(strtolower($prochainCours->course->mode->libelle), ['distanciel', 'ligne', 'visio'])))
                <a href="{{ route('meeting.show', $prochainCours->id) }}"
                  class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase tracking-widest px-6 py-3.5 shadow-lg transition-all transform hover:-translate-y-0.5">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                  </svg>
                  Rejoindre la visio Jitsi
                </a>
              @else
                <span
                  class="inline-flex items-center gap-2 bg-[#D4A373] text-[#1E1613] font-bold text-xs uppercase tracking-widest px-6 py-3.5 shadow-md">
                  🏫 En Présentiel à l'Atelier
                </span>
              @endif
            @else
              <a href="{{ route('dashboard.apprenant.cours') }}"
                class="inline-block bg-[#C85A32] hover:bg-[#A84223] text-white font-bold text-xs uppercase tracking-widest px-6 py-3.5 transition-all">
                Voir le catalogue des cours
              </a>
            @endif
          </div>
        </div>
      </div>

      <!-- 2. Résumé Réservations -->
      <div class="md:col-span-1 bg-[#FAF7F2] border border-[#D4A373]/40 p-6 flex flex-col justify-between">
        <div>
          <span class="text-[10px] uppercase tracking-widest font-bold text-[#C85A32] block mb-1">Mon Compte</span>
          <h3 class="text-lg font-serif-title font-bold text-[#1E1613]">Mes Inscriptions</h3>
        </div>
        <div class="my-4">
          <span class="block text-[10px] uppercase tracking-widest text-[#6B574F] mb-1">Réservations actives</span>
          <span class="text-4xl font-bold font-serif-title text-[#C85A32]">{{ $reservations->count() }}</span>
        </div>
        <a href="{{ route('dashboard.apprenant.cours') }}"
          class="text-xs font-bold text-[#1E1613] hover:text-[#C85A32] uppercase tracking-wider flex items-center gap-1">
          Réserver un nouveau cours &rarr;
        </a>
      </div>

      <!-- 3. Liste de mes Réservations -->
      <div class="md:col-span-4 bg-white border border-slate-200 p-6">
        <div class="flex justify-between items-center mb-6 border-b border-slate-100 pb-4">
          <div>
            <h3 class="text-lg font-serif-title font-bold text-slate-900">Mes Cours & Créneaux Réservés</h3>
            <p class="text-xs text-slate-500">Accédez à vos salons visio Jitsi sécurisés ou aux replays vidéo des cours
              passés.</p>
          </div>
          <a href="{{ route('dashboard.apprenant.cours') }}"
            class="text-xs text-[#C85A32] font-bold uppercase tracking-widest hover:underline">+ Réserver un cours</a>
        </div>

        @if($reservations->isEmpty())
          <div class="text-center py-10 bg-[#FAF7F2] border border-dashed border-[#D4A373]/40">
            <p class="text-sm text-[#6B574F] font-medium">Vous n'avez aucune réservation de cours enregistrée.</p>
            <a href="{{ route('dashboard.apprenant.cours') }}"
              class="mt-3 inline-block px-5 py-2.5 bg-[#C85A32] text-white text-xs font-bold uppercase tracking-widest shadow">
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
                  <th class="p-3">Accès</th>
                  <th class="p-3">Support</th>
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
                      <span
                        class="px-2 py-0.5 text-[10px] font-bold uppercase bg-slate-100 border border-slate-300 text-slate-800">
                        {{ $res->course && $res->course->mode ? $res->course->mode->libelle : 'Présentiel' }}
                      </span>
                    </td>
                    <td class="p-3 text-slate-700">
                      {{ \Carbon\Carbon::parse($res->date_reservation)->format('d/m/Y') }} •
                      {{ \Carbon\Carbon::parse($res->heure_debut)->format('H\hi') }} -
                      {{ \Carbon\Carbon::parse($res->heure_fin)->format('H\hi') }}
                    </td>
                    <td class="p-3">
                      <span class="px-2.5 py-1 text-[10px] font-bold uppercase rounded-none bg-emerald-100 text-emerald-800">
                        Confirmé
                      </span>
                    </td>
                    <td class="p-3 space-x-2">
                      @if($res->jitsi_room_id)
                        <a href="{{ route('meeting.show', $res->id) }}"
                          class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-[10px] uppercase tracking-wider shadow">
                          🎥 Classe Jitsi
                        </a>
                      @endif

                      @if($res->lien_replay)
                        <a href="{{ route('visio.replay', $res->id) }}"
                          class="inline-flex items-center gap-1 px-3 py-1.5 bg-[#C85A32] hover:bg-[#A84223] text-white font-bold text-[10px] uppercase tracking-wider shadow">
                          📼 Replay
                        </a>
                      @endif
                    </td>
                    <td class="p-3">
                      @if($res->course && $res->course->supports && $res->course->supports->count() > 0)
                        <div class="inline-block relative" x-data="{ open: false }">
                          <button @click="open = !open" @click.away="open = false"
                            class="inline-flex items-center gap-1 px-3 py-1.5 bg-slate-800 hover:bg-slate-900 text-white font-bold text-[10px] uppercase tracking-wider shadow cursor-pointer">
                            📁 Supports ({{ $res->course->supports->count() }})
                          </button>
                          <div x-show="open" style="display: none;"
                            class="absolute right-0 mt-1 w-56 bg-white border border-slate-200 shadow-xl z-10 text-left overflow-hidden">
                            @foreach($res->course->supports as $support)
                              <a href="{{ route('dashboard.apprenant.supports.download', $support->id) }}"
                                class="block px-4 py-2 text-xs text-slate-700 hover:bg-slate-50 hover:text-[#C85A32] border-b border-slate-100 last:border-0 truncate"
                                title="{{ basename($support->fichier) }}">
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
        @endif
      </div>

      <!-- 4. Catalogue Rapide des Cours Disponibles -->
      <div class="md:col-span-4 bg-white border border-slate-200 p-6">
        <div class="flex justify-between items-center mb-6 border-b border-slate-100 pb-4">
          <div>
            <h3 class="text-lg font-serif-title font-bold text-slate-900">Catalogue des Cours & Ateliers</h3>
            <p class="text-xs text-slate-500">Réservez instantanément votre place pour les prochains ateliers et cours
              dispensés.</p>
          </div>
          <a href="{{ route('dashboard.apprenant.cours') }}"
            class="text-xs text-[#C85A32] font-bold uppercase tracking-widest hover:underline">Voir tout le catalogue
            &rarr;</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          @forelse($cours as $item)
            @php
              $catNom = $item->categorie ? $item->categorie->nom : 'Art & Culture';
              $catLower = strtolower($catNom);
              $modeName = $item->mode ? $item->mode->libelle : 'Présentiel';
              $profName = $item->professeur ? $item->professeur->name : 'Association';

              if ($item->image_path) {
                $imgUrl = asset('storage/' . $item->image_path);
              } elseif (\Illuminate\Support\Str::contains($catLower, ['raphia', 'artisanat', 'tissage', 'sculpture'])) {
                $imgUrl = '/assets/raphia_artisanal_crafts_1785764982514-DDF_8lz7.jpg';
              } elseif (\Illuminate\Support\Str::contains($catLower, ['moderne', 'guitare', 'piano', 'synthé'])) {
                $imgUrl = 'https://images.unsplash.com/photo-1510915361894-db8b60106cb1?auto=format&fit=crop&q=80&w=800';
              } elseif (\Illuminate\Support\Str::contains($catLower, ['tradition', 'instruments', 'balafon', 'kora', 'djembé', 'percussion'])) {
                $imgUrl = 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&q=80&w=800';
              } else {
                $catIdImages = [
                  1 => 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&q=80&w=800',
                  2 => 'https://images.unsplash.com/photo-1510915361894-db8b60106cb1?auto=format&fit=crop&q=80&w=800',
                  3 => '/assets/raphia_artisanal_crafts_1785764982514-DDF_8lz7.jpg',
                ];
                $imgUrl = $catIdImages[$item->categorie_cours_id ?? 0] ?? 'https://images.unsplash.com/photo-1519892300165-cb5542fb47c7?auto=format&fit=crop&q=80&w=800';
              }
            @endphp
            <div class="bg-white border border-slate-200 shadow-sm flex flex-col group hover:shadow-md transition">
              <div class="relative h-40 overflow-hidden bg-slate-100">
                <img src="{{ $imgUrl }}" alt="{{ $item->titre }}"
                  class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                <div class="absolute top-2.5 left-2.5 flex flex-wrap gap-1">
                  <span
                    class="px-2 py-0.5 bg-[#1E1613]/90 text-[#D4A373] text-[9px] font-bold uppercase tracking-widest border border-[#D4A373]/30">
                    {{ $item->categorie ? $item->categorie->nom : 'Général' }}
                  </span>
                  <span
                    class="px-2 py-0.5 bg-[#C85A32] text-white text-[9px] font-bold uppercase tracking-widest shadow-sm">
                    {{ $modeName }}
                  </span>
                </div>
              </div>
              <div class="p-4 flex-1 flex flex-col justify-between space-y-3">
                <div>
                  <h4
                    class="text-sm font-serif-title font-bold text-slate-900 group-hover:text-[#C85A32] transition-colors">
                    {{ $item->titre }}
                  </h4>
                  <p class="text-[11px] text-slate-500 mt-1 line-clamp-2">
                    {{ $item->description ?? 'Aucune description disponible.' }}
                  </p>
                  <div class="mt-2 flex items-center gap-1.5 text-[11px] font-semibold text-slate-700">
                    <i class="fa-solid fa-user-tie text-[#C85A32]"></i>
                    <span>Prof. {{ $profName }}</span>
                  </div>
                </div>
                <div class="pt-2.5 border-t border-slate-100 flex items-center justify-between">
                  <div>
                    <span class="text-[9px] text-slate-400 uppercase font-semibold block">Tarif</span>
                    <span class="text-sm font-bold text-[#C85A32]">
                      {{ number_format($item->tarif, 0, ',', ' ') }} € <span
                        class="text-[10px] text-slate-500 font-normal">/ séance</span>
                    </span>
                  </div>
                  
                      <button type="button"
                        @click="openBookingModal({{ $item->id }}, '{{ addslashes($item->titre) }}', '{{ addslashes($profName) }}', '{{ addslashes($modeName) }}', '{{ number_format($item->tarif, 0, ',', ' ') }}')"
                        class="px-3 py-1.5 bg-[#C85A32] hover:bg-[#A84223] text-white text-[11px] font-bold uppercase tracking-wider transition shadow cursor-pointer">
                        Réserver
                      </button>
                  
                </div>
              </div>
            </div>
          @empty
            <div class="col-span-3 text-center py-8 bg-slate-50 border border-dashed border-slate-200">
              <p class="text-xs text-slate-500">Aucun cours à afficher.</p>
            </div>
          @endforelse
        </div>

        @if(method_exists($cours, 'hasPages') && $cours->hasPages())
          <div class="mt-6 pt-4 border-t border-slate-100 flex justify-center">
            {{ $cours->links() }}
          </div>
        @endif
      </div>

    </div>

    {{-- MODAL DE RÉSERVATION INTEGREE DANS LE DASHBOARD --}}
    <div x-show="showModal"
      class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-[#1E1613]/70 backdrop-blur-sm" x-cloak
      style="display:none;">
      <div @click.away="showModal = false"
        class="bg-[#FAF7F2] w-full max-w-lg shadow-2xl border border-[#D4A373]/40 p-4 sm:p-5 relative max-h-[90vh] overflow-y-auto">

        <div class="flex justify-between items-start border-b border-[#D4A373]/20 pb-2.5 mb-3">
          <div>
            <div class="flex items-center gap-2 flex-wrap">
              <span class="text-[10px] font-bold uppercase tracking-widest text-[#C85A32]">Réservation de cours</span>
              <span x-show="coursMode" class="text-[9px] font-bold uppercase px-2 py-0.5 bg-[#1E1613] text-[#D4A373]"
                x-text="coursMode"></span>
              <span x-show="coursTarif" class="text-[9px] font-bold uppercase px-2 py-0.5 bg-[#C85A32] text-white"
                x-text="coursTarif + ' € / séance'"></span>
            </div>
            <h3 class="font-serif-title font-bold text-lg text-[#2C221E] mt-0.5" x-text="coursTitre"></h3>
            <p class="text-xs text-[#6B574F] mt-0.5" x-text="'Professeur : ' + profName"></p>
          </div>
          <button @click="showModal = false"
            class="text-[#2C221E] hover:text-[#C85A32] text-2xl font-bold leading-none cursor-pointer">&times;</button>
        </div>

        {{-- Loader --}}
        <div x-show="loading" class="py-6 text-center text-xs text-[#6B574F]">
          <svg class="animate-spin h-6 w-6 text-[#C85A32] mx-auto mb-2" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor"
              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
            </path>
          </svg>
          Chargement des disponibilités du professeur...
        </div>

        <div x-show="!loading">
          <div class="mb-3 bg-[#F4EFE6] border border-[#D4A373]/30 p-2.5">
            <div class="flex items-center justify-between mb-1.5">
              <h4 class="text-[10px] font-bold uppercase tracking-widest text-[#2C221E] flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-[#C85A32]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Disponibilités du professeur :
              </h4>
              <span x-show="disponibilites.length > 0"
                class="text-[9px] font-bold text-[#C85A32] bg-[#FAF7F2] border border-[#D4A373]/40 px-2 py-0.5"
                x-text="disponibilites.length + ' créneau(x)'"></span>
            </div>
            <template x-if="disponibilites.length === 0">
              <p class="text-xs text-[#8C766B] italic">Aucune disponibilité enregistrée pour le moment.</p>
            </template>

            <div x-show="disponibilites.length > 0" class="space-y-1.5 max-h-36 overflow-y-auto pr-1">
              <template x-for="(slots, jour) in getGroupedDisponibilites()" :key="jour">
                <div class="bg-white border border-[#D4A373]/30 p-2 shadow-sm">
                  <div
                    class="text-[10px] font-bold text-[#C85A32] uppercase mb-1 flex items-center justify-between border-b border-[#D4A373]/20 pb-1">
                    <div class="flex items-center gap-1.5">
                      <span class="w-2 h-2 bg-emerald-500 rounded-full inline-block"></span>
                      <span
                        x-text="jour + (getSlotNextDateFormatted(jour) ? ' (' + getSlotNextDateFormatted(jour) + ')' : '')"></span>
                    </div>
                    <span class="text-[9px] text-[#8C766B] font-semibold" x-text="slots.length + ' créneau(x)'"></span>
                  </div>
                  <div class="grid grid-cols-1 sm:grid-cols-2 gap-1.5">
                    <template x-for="slot in slots" :key="slot.id">
                      <button type="button" @click="selectSlot(slot)"
                        :class="dateReservation === getNextDateForDay(slot.jour) && heureDebut === slot.debut.substring(0,5) ? 'bg-[#C85A32] text-white border-[#C85A32]' : 'bg-[#FAF7F2] hover:bg-[#F4EFE6] text-[#2C221E] border-[#D4A373]/30'"
                        class="w-full flex items-center justify-between border px-2 py-1 text-[11px] font-bold transition cursor-pointer">
                        <span x-text="slot.debut.substring(0,5) + ' - ' + slot.fin.substring(0,5)"></span>
                        <span class="text-[9px] font-bold uppercase"
                          :class="dateReservation === getNextDateForDay(slot.jour) && heureDebut === slot.debut.substring(0,5) ? 'text-white' : 'text-[#C85A32]'">✓
                          Choisir</span>
                      </button>
                    </template>
                  </div>
                </div>
              </template>
            </div>
          </div>

          <form action="{{ route('reservations.store') }}" method="POST" @submit="validateForm($event)" class="space-y-3">
            @csrf
            <input type="hidden" name="cours_id" :value="coursId" />

            <div>
              <label class="block text-[10px] font-bold uppercase tracking-widest text-[#2C221E] mb-1">
                Date souhaitée <span class="text-[#C85A32]">*</span>
              </label>
              <input type="date" name="date_reservation" required min="{{ date('Y-m-d') }}" x-model="dateReservation"
                @change="onDateChange($event)"
                class="w-full px-3 py-1.5 bg-white border border-[#D4A373]/50 text-xs text-[#2C221E] focus:outline-none focus:border-[#C85A32]" />
            </div>

            <div class="grid grid-cols-2 gap-2.5">
              <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-[#2C221E] mb-1">
                  Heure de début <span class="text-[#C85A32]">*</span>
                </label>
                <input type="time" name="heure_debut" required x-model="heureDebut"
                  class="w-full px-3 py-1.5 bg-white border border-[#D4A373]/50 text-xs text-[#2C221E] focus:outline-none focus:border-[#C85A32]" />
              </div>
              <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-[#2C221E] mb-1">
                  Heure de fin <span class="text-[#C85A32]">*</span>
                </label>
                <input type="time" name="heure_fin" required x-model="heureFin"
                  class="w-full px-3 py-1.5 bg-white border border-[#D4A373]/50 text-xs text-[#2C221E] focus:outline-none focus:border-[#C85A32]" />
              </div>
            </div>

            <div x-show="errorMessage" class="p-2.5 bg-red-50 border border-red-200 text-red-700 text-xs font-semibold">
              <span x-text="errorMessage"></span>
            </div>

            <div class="flex justify-end gap-2.5 pt-2 border-t border-[#D4A373]/20">
              <button type="button" @click="showModal = false"
                class="px-3.5 py-1.5 text-xs font-bold uppercase tracking-wider text-[#6B574F] hover:text-[#2C221E] cursor-pointer">
                Annuler
              </button>
              <button type="submit" :disabled="disponibilites.length === 0"
                class="px-4 py-2 bg-[#C85A32] hover:bg-[#A84223] disabled:opacity-50 text-white font-bold text-xs uppercase tracking-widest transition shadow-md cursor-pointer">
                Confirmer la réservation
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection