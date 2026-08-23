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
              this.loading = false;
              this.disponibilites = [];
              this.errorMessage = '';
              this.dateReservation = '';
              this.heureDebut = '';
              this.heureFin = '';
              this.activeSlotDay = '';

              /*
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
              */
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
              this.errorMessage = '';
          },

          validateForm(e) {
              // Libre choix
          }
      }">

    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 pb-4 border-b border-slate-200">
      <div>
        <h1 class="admin-title text-2xl font-bold uppercase tracking-tight text-[#1E1613]">Espace Apprenant</h1>
        <p class="admin-subtitle text-slate-500 text-sm mt-1">Bienvenue {{ Auth::user()->prenom ?? Auth::user()->name }}.
          Retrouvez vos cours, vos visioconférences Jitsi et réservez de nouveaux ateliers.</p>
      </div>
      <div class="flex flex-wrap items-center gap-2">
        <a href="{{ route('dashboard.apprenant.cours') }}"
          class="btn-primary bg-[#0BA20B] text-white px-6 py-2.5 font-bold text-xs uppercase tracking-widest hover:bg-[#087A08] transition flex items-center gap-2">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
          </svg>
          CATALOGUE COMPLET
        </a>
      </div>
    </div>

    <!-- Flash Notifications -->
    {{-- @if(session('success'))
    <div class="p-4 bg-emerald-50 border-l-4 border-l-emerald-600 text-emerald-800 text-xs font-semibold">
      {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="p-4 bg-red-50 border-l-4 border-l-red-600 text-red-800 text-xs font-semibold">
      {{ session('error') }}
    </div>
    @endif --}}

    <!-- Metric Cards (Style Admin) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
      {{-- Card 1 : Inscriptions --}}
      <div
        class="bg-gradient-to-br from-white to-[#0BA20B]/[0.02] border border-slate-200 border-l-4 border-l-transparent min-h-[124px] p-5 flex flex-col justify-center relative overflow-hidden group hover:border-l-[#0BA20B] hover:border-slate-300 hover:shadow-xl transition-all duration-300">
        <div
          class="absolute -right-6 -top-6 w-24 h-24 bg-[#0BA20B]/5 rotate-12 group-hover:bg-[#0BA20B]/10 group-hover:-rotate-12 transition-all duration-500 pointer-events-none">
        </div>
        <div class="flex justify-between items-center w-full relative z-10">
          <div>
            <p
              class="text-[11px] font-bold text-slate-500 uppercase tracking-widest font-sans mb-1 group-hover:text-[#0BA20B] transition-colors">
              Mes Inscriptions</p>
            <h3 class="text-3xl font-normal text-slate-900 font-sans tracking-tighter">{{ $reservations->count() }}</h3>
          </div>
          <div
            class="w-12 h-12 bg-[#0BA20B]/10 rounded-full flex items-center justify-center text-[#0BA20B] group-hover:scale-110 group-hover:bg-[#0BA20B] group-hover:text-white transition-all duration-300 shadow-sm">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
        </div>
      </div>

      {{-- Card 2 : Cours Dispo --}}
      <div
        class="bg-gradient-to-br from-white to-[#0BA20B]/[0.02] border border-slate-200 border-l-4 border-l-transparent min-h-[124px] p-5 flex flex-col justify-center relative overflow-hidden group hover:border-l-[#0BA20B] hover:border-slate-300 hover:shadow-xl transition-all duration-300">
        <div
          class="absolute -right-6 -top-6 w-24 h-24 bg-[#0BA20B]/5 rotate-12 group-hover:bg-[#0BA20B]/10 group-hover:-rotate-12 transition-all duration-500 pointer-events-none">
        </div>
        <div class="flex justify-between items-center w-full relative z-10">
          <div>
            <p
              class="text-[11px] font-bold text-slate-500 uppercase tracking-widest font-sans mb-1 group-hover:text-[#0BA20B] transition-colors">
              Cours Dispo</p>
            <h3 class="text-3xl font-normal text-slate-900 font-sans tracking-tighter">
              {{ method_exists($cours, 'total') ? $cours->total() : $cours->count() }}</h3>
          </div>
          <div
            class="w-12 h-12 bg-[#0BA20B]/10 rounded-full flex items-center justify-center text-[#0BA20B] group-hover:scale-110 group-hover:bg-[#0BA20B] group-hover:text-white transition-all duration-300 shadow-sm">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
              </path>
            </svg>
          </div>
        </div>
      </div>

      {{-- Card 3 : Catégories --}}
      <div
        class="bg-gradient-to-br from-white to-[#0BA20B]/[0.02] border border-slate-200 border-l-4 border-l-transparent min-h-[124px] p-5 flex flex-col justify-center relative overflow-hidden group hover:border-l-[#0BA20B] hover:border-slate-300 hover:shadow-xl transition-all duration-300">
        <div
          class="absolute -right-6 -top-6 w-24 h-24 bg-[#0BA20B]/5 rotate-12 group-hover:bg-[#0BA20B]/10 group-hover:-rotate-12 transition-all duration-500 pointer-events-none">
        </div>
        <div class="flex justify-between items-center w-full relative z-10">
          <div>
            <p
              class="text-[11px] font-bold text-slate-500 uppercase tracking-widest font-sans mb-1 group-hover:text-[#0BA20B] transition-colors">
              Catégories</p>
            <h3 class="text-3xl font-normal text-slate-900 font-sans tracking-tighter">
              {{ method_exists($categoriesCours, 'count') ? $categoriesCours->count() : 0 }}</h3>
          </div>
          <div
            class="w-12 h-12 bg-[#0BA20B]/10 rounded-full flex items-center justify-center text-[#0BA20B] group-hover:scale-110 group-hover:bg-[#0BA20B] group-hover:text-white transition-all duration-300 shadow-sm">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
              </path>
            </svg>
          </div>
        </div>
      </div>

      {{-- Card 4 : Prochain --}}
      <div
        class="bg-gradient-to-br from-white to-[#0BA20B]/[0.02] border border-slate-200 border-l-4 border-l-transparent min-h-[124px] p-5 flex flex-col justify-center relative overflow-hidden group hover:border-l-[#0BA20B] hover:border-slate-300 hover:shadow-xl transition-all duration-300">
        <div
          class="absolute -right-6 -top-6 w-24 h-24 bg-[#0BA20B]/5 rotate-12 group-hover:bg-[#0BA20B]/10 group-hover:-rotate-12 transition-all duration-500 pointer-events-none">
        </div>
        <div class="flex justify-between items-center w-full relative z-10">
          <div>
            <p
              class="text-[11px] font-bold text-slate-500 uppercase tracking-widest font-sans mb-1 group-hover:text-[#0BA20B] transition-colors">
              Date Suivante</p>
            <h3 class="text-3xl font-normal text-slate-900 font-sans tracking-tighter">
              {{ $prochainCours ? \Carbon\Carbon::parse($prochainCours->date_reservation)->format('d/m') : '-' }}</h3>
          </div>
          <div
            class="w-12 h-12 bg-[#0BA20B]/10 rounded-full flex items-center justify-center text-[#0BA20B] group-hover:scale-110 group-hover:bg-[#0BA20B] group-hover:text-white transition-all duration-300 shadow-sm">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
          </div>
        </div>
      </div>
    </div>
    <!-- Bento Box Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

      <!-- 1. Prochain Cours (Dynamic) -->
      <div
        class="md:col-span-3 bg-[#1E1613] text-white relative overflow-hidden group min-h-[260px] flex flex-col justify-end p-6 md:p-8 border border-[#0BA20B]/30 shadow-xl rounded-none">
        <img src="/assets/hero_cultural_bg_1785764970571-BS2uarbi.jpg" alt="Musique"
          class="absolute inset-0 w-full h-full object-cover opacity-30 group-hover:opacity-40 group-hover:scale-105 transition-all duration-700" />
        <div class="absolute inset-0 bg-gradient-to-t from-[#1E1613] via-[#1E1613]/70 to-transparent"></div>

        <div class="relative z-10 flex flex-col sm:flex-row justify-between items-start sm:items-end w-full gap-4">
          <div>
            @if($prochainCours)
              <div
                class="inline-flex items-center gap-2 bg-[#0BA20B] text-white text-[10px] font-bold uppercase tracking-widest px-3 py-1 mb-3">
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
                class="inline-block bg-white/10 text-[#0BA20B] text-[10px] font-bold uppercase tracking-widest px-3 py-1 mb-3">Aucun
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
                  class="inline-flex items-center gap-2 bg-[#0BA20B] hover:bg-[#087A08] text-white font-bold text-xs uppercase tracking-widest px-6 py-3.5 shadow-lg transition-all transform hover:-translate-y-0.5">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                  </svg>
                  Rejoindre la visio Jitsi
                </a>
              @else
                <span
                  class="inline-flex items-center gap-2 bg-[#0BA20B] text-[#1E1613] font-bold text-xs uppercase tracking-widest px-6 py-3.5 shadow-md">
                  🏫 En Présentiel à l'Atelier
                </span>
              @endif
            @else
              <a href="{{ route('dashboard.apprenant.cours') }}"
                class="inline-block bg-[#0BA20B] hover:bg-[#087A08] text-white font-bold text-xs uppercase tracking-widest px-6 py-3.5 transition-all">
                Voir le catalogue des cours
              </a>
            @endif
          </div>
        </div>
      </div>

      <!-- 2. Résumé Réservations -->
      <div
        class="md:col-span-1 bg-gradient-to-br from-white to-[#0BA20B]/[0.02] border border-slate-200 p-6 flex flex-col justify-between rounded-none relative overflow-hidden group hover:border-[#0BA20B]/50 transition-colors">
        <!-- Décoration Bento -->
        <div
          class="absolute -right-6 -top-6 w-20 h-20 bg-[#0BA20B]/5 rotate-12 group-hover:bg-[#0BA20B]/10 group-hover:-rotate-12 transition-all duration-500 pointer-events-none">
        </div>
        <div class="relative z-10">
          <span class="text-[10px] uppercase tracking-widest font-bold text-[#0BA20B] block mb-1">Mon Compte</span>
          <h3 class="text-lg font-serif-title font-bold text-slate-900">Mes Inscriptions</h3>
        </div>
        <div class="my-4 relative z-10">
          <span class="block text-[10px] uppercase tracking-widest text-slate-500 mb-1">Réservations actives</span>
          <span class="text-4xl font-bold font-sans tracking-tighter text-[#0BA20B]">{{ $reservations->count() }}</span>
        </div>
        <a href="{{ route('dashboard.apprenant.cours') }}"
          class="text-[11px] font-bold text-slate-700 hover:text-[#0BA20B] uppercase tracking-wider flex items-center gap-1 transition-colors relative z-10">
          Réserver un nouveau cours &rarr;
        </a>
      </div>

      <!-- 3. Liste de mes Réservations -->
      <div
        class="md:col-span-4 bg-gradient-to-br from-white to-[#0BA20B]/[0.02] border border-slate-200 p-6 rounded-none relative overflow-hidden group">
        <div
          class="absolute -right-8 -bottom-8 w-32 h-32 bg-[#0BA20B]/5 rotate-45 group-hover:bg-[#0BA20B]/10 group-hover:rotate-90 transition-all duration-700 pointer-events-none">
        </div>
        <div class="relative z-10 flex justify-between items-center mb-6 border-b border-slate-100 pb-4">
          <div class="flex items-center gap-2">
            <span class="w-2 h-2 bg-[#0BA20B] block"></span>
            <div>
              <h2 class="text-lg font-bold text-slate-900 font-sans tracking-tight">Mes Cours & Créneaux Réservés</h2>
              <p class="text-xs text-slate-500 font-medium mt-0.5">Accédez à vos salons visio Jitsi sécurisés ou aux
                replays vidéo des cours passés.</p>
            </div>
          </div>
          <a href="{{ route('dashboard.apprenant.cours') }}"
            class="text-xs text-[#0BA20B] font-bold uppercase tracking-widest hover:underline">+ Réserver un cours</a>
        </div>

        @if($reservations->isEmpty())
          <div class="text-center py-10 bg-[#FAF7F2] border border-dashed border-[#0BA20B]/40">
            <p class="text-sm text-[#6B574F] font-medium">Vous n'avez aucune réservation de cours enregistrée.</p>
            <a href="{{ route('dashboard.apprenant.cours') }}"
              class="mt-3 inline-block px-5 py-2.5 bg-[#0BA20B] text-white text-xs font-bold uppercase tracking-widest shadow">
              Découvrir les cours & réserver
            </a>
          </div>
        @else
          <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
              <thead class="bg-[#0BA20B]/5 text-slate-700 font-bold uppercase tracking-wider border-b border-[#0BA20B]/20">
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
                    <td class="p-3 font-medium text-slate-900">
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
                      <span
                        class="px-2.5 py-1 text-[10px] font-bold uppercase rounded-none bg-[#0BA20B] text-white text-emerald-800">
                        Confirmé
                      </span>
                    </td>
                    <td class="p-3 space-x-2">
                      @if($res->jitsi_room_id)
                        <a href="{{ route('meeting.show', $res->id) }}"
                          class="inline-flex items-center gap-1 px-3 py-1.5 bg-[#0BA20B] hover:bg-[#087A08] text-white font-bold text-[10px] uppercase tracking-wider shadow">
                          Jitsi
                        </a>
                      @endif

                      @if($res->lien_replay)
                        <a href="{{ route('visio.replay', $res->id) }}"
                          class="inline-flex items-center gap-1 px-3 py-1.5 bg-[#0BA20B] hover:bg-[#087A08] text-white font-bold text-[10px] uppercase tracking-wider shadow">
                          📼 Replay
                        </a>
                      @endif
                    </td>
                    <td class="p-3">
                      @if($res->course && $res->course->supports && $res->course->supports->count() > 0)
                        <div class="inline-block relative" x-data="{ open: false }">
                          <button @click="open = !open" @click.away="open = false"
                            class="inline-flex items-center gap-1 px-3 py-1.5 bg-slate-800 hover:bg-slate-900 text-white font-bold text-[10px] uppercase tracking-wider shadow cursor-pointer">
                            📁 ({{ $res->course->supports->count() }})
                          </button>
                          <div x-show="open" style="display: none;"
                            class="absolute right-0 mt-1 w-56 bg-white border border-slate-200 shadow-xl z-10 text-left overflow-hidden">
                            @foreach($res->course->supports as $support)
                              <a href="{{ route('dashboard.apprenant.supports.download', $support->id) }}"
                                class="block px-4 py-2 text-xs text-slate-700 hover:bg-slate-50 hover:text-[#0BA20B] border-b border-slate-100 last:border-0 truncate"
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
      <!-- <div class="md:col-span-4 bg-gradient-to-br from-white to-[#0BA20B]/[0.02] border border-slate-200 p-6 rounded-none relative overflow-hidden group">
          <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-[#0BA20B]/5 rotate-12 group-hover:bg-[#0BA20B]/10 group-hover:rotate-45 transition-all duration-700 pointer-events-none"></div>
          <div class="relative z-10 flex justify-between items-center mb-6 border-b border-slate-100 pb-4">
            <div class="flex items-center gap-2">
              <span class="w-2 h-2 bg-[#0BA20B] block"></span>
              <div>
                <h2 class="text-lg font-bold text-slate-900 font-sans tracking-tight">Catalogue des Cours & Ateliers</h2>
                <p class="text-xs text-slate-500 font-medium mt-0.5">Réservez instantanément votre place pour les prochains ateliers et cours dispensés.</p>
              </div>
            </div>
            <a href="{{ route('dashboard.apprenant.cours') }}"
              class="text-xs text-[#0BA20B] font-bold uppercase tracking-widest hover:underline">Voir tout le catalogue
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
              <div class="bg-white border border-slate-200 shadow-sm flex flex-col group hover:shadow-md hover:border-[#0BA20B]/50 transition-all duration-300 rounded-none relative">
                <div class="relative h-40 overflow-hidden bg-slate-100">
                  <img src="{{ $imgUrl }}" alt="{{ $item->titre }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                  <div class="absolute top-2.5 left-2.5 flex flex-wrap gap-1">
                    <span
                      class="px-2 py-0.5 bg-[#1E1613]/90 text-[#0BA20B] text-[9px] font-bold uppercase tracking-widest border border-[#0BA20B]/30">
                      {{ $item->categorie ? $item->categorie->nom : 'Général' }}
                    </span>
                    <span
                      class="px-2 py-0.5 bg-[#0BA20B] text-white text-[9px] font-bold uppercase tracking-widest shadow-sm">
                      {{ $modeName }}
                    </span>
                  </div>
                </div>
                <div class="p-4 flex-1 flex flex-col justify-between space-y-3">
                  <div>
                    <h4
                      class="text-sm font-serif-title font-medium text-slate-900 group-hover:text-[#0BA20B] transition-colors">
                      {{ $item->titre }}
                    </h4>
                    <p class="text-[11px] text-slate-500 mt-1 line-clamp-2">
                      {{ $item->description ?? 'Aucune description disponible.' }}
                    </p>
                    <div class="mt-2 flex items-center gap-1.5 text-[11px] font-semibold text-slate-700">
                      <i class="fa-solid fa-user-tie text-[#0BA20B]"></i>
                      <span>Prof. {{ $profName }}</span>
                    </div>
                  </div>
                  <div class="pt-2.5 border-t border-slate-100 flex items-center justify-between">
                    <div>
                      <span class="text-[9px] text-slate-400 uppercase font-semibold block">Tarif</span>
                      <span class="text-sm font-bold text-[#0BA20B]">
                        {{ number_format($item->tarif, 0, ',', ' ') }} € <span
                          class="text-[10px] text-slate-500 font-normal">/ séance</span>
                      </span>
                    </div>

                        <button type="button"
                          @click="openBookingModal({{ $item->id }}, '{{ addslashes($item->titre) }}', '{{ addslashes($profName) }}', '{{ addslashes($modeName) }}', '{{ number_format($item->tarif, 0, ',', ' ') }}')"
                          class="px-3 py-1.5 bg-[#0BA20B] hover:bg-[#087A08] text-white text-[11px] font-bold uppercase tracking-wider transition shadow cursor-pointer">
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
        </div> -->

    </div>

    {{-- MODAL DE RÉSERVATION INTEGREE DANS LE DASHBOARD --}}
    <div x-show="showModal"
      class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-[#1E1613]/70 backdrop-blur-sm" x-cloak
      style="display:none;">
      <div @click.away="showModal = false"
        class="bg-[#FAF7F2] w-full max-w-lg shadow-2xl border border-[#0BA20B]/40 p-4 sm:p-5 relative max-h-[90vh] overflow-y-auto">

        <div class="flex justify-between items-start border-b border-[#0BA20B]/20 pb-2.5 mb-3">
          <div>
            <div class="flex items-center gap-2 flex-wrap">
              <span class="text-[10px] font-bold uppercase tracking-widest text-[#0BA20B]">Réservation de cours</span>
              <span x-show="coursMode" class="text-[9px] font-bold uppercase px-2 py-0.5 bg-[#1E1613] text-[#0BA20B]"
                x-text="coursMode"></span>
              <span x-show="coursTarif" class="text-[9px] font-bold uppercase px-2 py-0.5 bg-[#0BA20B] text-white"
                x-text="coursTarif + ' € / séance'"></span>
            </div>
            <h3 class="font-serif-title font-bold text-lg text-[#2C221E] mt-0.5" x-text="coursTitre"></h3>
            <p class="text-xs text-[#6B574F] mt-0.5" x-text="'Professeur : ' + profName"></p>
          </div>
          <button @click="showModal = false"
            class="text-[#2C221E] hover:text-[#0BA20B] text-2xl font-bold leading-none cursor-pointer">&times;</button>
        </div>

        {{-- Loader --}}
        <div x-show="loading" class="py-6 text-center text-xs text-[#6B574F]">
          <svg class="animate-spin h-6 w-6 text-[#0BA20B] mx-auto mb-2" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor"
              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
            </path>
          </svg>
        </div>

        <div x-show="!loading">
          <!-- ANCIEN CODE : Disponibilités du professeur (Désactivé)
            <div class="mb-3 bg-[#F4EFE6] border border-[#0BA20B]/30 p-2.5">
              <div class="flex items-center justify-between mb-1.5">
                <h4 class="text-[10px] font-bold uppercase tracking-widest text-[#2C221E] flex items-center gap-1.5">
                  <svg class="w-3.5 h-3.5 text-[#0BA20B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                  Disponibilités du professeur :
                </h4>
                <span x-show="disponibilites.length > 0"
                  class="text-[9px] font-bold text-[#0BA20B] bg-[#FAF7F2] border border-[#0BA20B]/40 px-2 py-0.5"
                  x-text="disponibilites.length + ' créneau(x)'"></span>
              </div>
              <template x-if="disponibilites.length === 0">
                <p class="text-xs text-[#8C766B] italic">Aucune disponibilité enregistrée pour le moment.</p>
              </template>

              <div x-show="disponibilites.length > 0" class="space-y-1.5 max-h-36 overflow-y-auto pr-1">
                <template x-for="(slots, jour) in getGroupedDisponibilites()" :key="jour">
                  <div class="bg-white border border-[#0BA20B]/30 p-2 shadow-sm">
                    <div
                      class="text-[10px] font-bold text-[#0BA20B] uppercase mb-1 flex items-center justify-between border-b border-[#0BA20B]/20 pb-1">
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
                          :class="dateReservation === getNextDateForDay(slot.jour) && heureDebut === slot.debut.substring(0,5) ? 'bg-[#0BA20B] text-white border-[#0BA20B]' : 'bg-[#FAF7F2] hover:bg-[#F4EFE6] text-[#2C221E] border-[#0BA20B]/30'"
                          class="w-full flex items-center justify-between border px-2 py-1 text-[11px] font-bold transition cursor-pointer">
                          <span x-text="slot.debut.substring(0,5) + ' - ' + slot.fin.substring(0,5)"></span>
                          <span class="text-[9px] font-bold uppercase"
                            :class="dateReservation === getNextDateForDay(slot.jour) && heureDebut === slot.debut.substring(0,5) ? 'text-white' : 'text-[#0BA20B]'">✓
                            Choisir</span>
                        </button>
                      </template>
                    </div>
                  </div>
                </template>
              </div>
            </div>
            -->

          <form action="{{ route('reservations.store') }}" method="POST" @submit="validateForm($event)" class="space-y-3">
            @csrf
            <input type="hidden" name="cours_id" :value="coursId" />

            <div>
              <label class="block text-[10px] font-bold uppercase tracking-widest text-[#2C221E] mb-1">
                Date souhaitée <span class="text-[#0BA20B]">*</span>
              </label>
              <input type="date" name="date_reservation" required min="{{ date('Y-m-d') }}" x-model="dateReservation"
                @change="onDateChange($event)"
                class="w-full px-3 py-1.5 bg-white border border-[#0BA20B]/50 text-xs text-[#2C221E] focus:outline-none focus:border-[#0BA20B]" />
            </div>

            <div class="grid grid-cols-2 gap-2.5">
              <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-[#2C221E] mb-1">
                  Heure de début <span class="text-[#0BA20B]">*</span>
                </label>
                <input type="time" name="heure_debut" required x-model="heureDebut"
                  class="w-full px-3 py-1.5 bg-white border border-[#0BA20B]/50 text-xs text-[#2C221E] focus:outline-none focus:border-[#0BA20B]" />
              </div>
              <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-[#2C221E] mb-1">
                  Heure de fin <span class="text-[#0BA20B]">*</span>
                </label>
                <input type="time" name="heure_fin" required x-model="heureFin"
                  class="w-full px-3 py-1.5 bg-white border border-[#0BA20B]/50 text-xs text-[#2C221E] focus:outline-none focus:border-[#0BA20B]" />
              </div>
            </div>

            <div x-show="errorMessage" class="p-2.5 bg-red-50 border border-red-200 text-red-700 text-xs font-semibold">
              <span x-text="errorMessage"></span>
            </div>

            <div class="flex justify-end gap-2.5 pt-2 border-t border-[#0BA20B]/20">
              <button type="button" @click="showModal = false"
                class="px-3.5 py-1.5 text-xs font-bold uppercase tracking-wider text-[#6B574F] hover:text-[#2C221E] cursor-pointer">
                Annuler
              </button>
              <button type="submit"
                class="px-4 py-2 bg-[#0BA20B] hover:bg-[#087A08] text-white font-bold text-xs uppercase tracking-widest transition shadow-md cursor-pointer">
                Confirmer la réservation
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection