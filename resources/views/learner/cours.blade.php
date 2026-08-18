@extends('layouts.dashboard')

@section('title', 'Catalogue des Cours & Atelier | Espace Apprenant')

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
    activeCategory: 'Tous',
    activeMode: 'Tous',

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
                    this.selectSlot(this.disponibilites[0]);
                }
            })
            .catch(err => {
                console.error(err);
                this.loading = false;
            });
        */
    },



    formatDateFr(dateStr) {
        if (!dateStr) return '';
        const parts = dateStr.split('-');
        if (parts.length !== 3) return dateStr;
        return parts[2] + '/' + parts[1] + '/' + parts[0];
    },



    getGroupedDisponibilites() {
        const groups = {};
        (this.disponibilites || []).forEach(slot => {
            const dateStr = slot.date_dispo;
            if (!groups[dateStr]) {
                groups[dateStr] = [];
            }
            groups[dateStr].push(slot);
        });
        return groups;
    },

    selectSlot(slot) {
        this.dateReservation = slot.date_dispo;
        if (slot.debut) this.heureDebut = slot.debut.substring(0, 5);
        if (slot.fin) this.heureFin = slot.fin.substring(0, 5);
        this.errorMessage = '';
    },

    onDateChange(e) {
        this.errorMessage = '';
    },

    validateForm(e) {
        // Libre choix de date
    }
}">

    <!-- Page Header -->
    <div class="bg-white border border-slate-200 shadow-sm px-6 py-5 border-l-4 border-l-[#0BA20B] flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-lg font-bold text-slate-900 uppercase tracking-wide">CATALOGUE DES COURS & RÉSERVATION</h1>
            <p class="text-slate-500 text-sm mt-0.5">Sélectionnez un cours et réservez votre créneau directement depuis votre espace.</p>
        </div>
        <a href="{{ route('dashboard.apprenant') }}" class="text-xs font-bold text-[#0BA20B] uppercase tracking-wider hover:underline">
            &larr; Retour au tableau de bord
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white border border-slate-200 p-4 flex flex-wrap gap-2 items-center justify-between">
        <div class="flex flex-wrap gap-2">
            <button type="button" @click="activeCategory = 'Tous'"
                :class="activeCategory === 'Tous' ? 'bg-[#0BA20B] text-white border-[#0BA20B]' : 'bg-[#FAF7F2] text-[#2C221E] border-[#0BA20B]/40 hover:bg-[#F4EFE6]'"
                class="px-3 py-1.5 text-xs font-bold uppercase tracking-wider border transition">
                Tous les cours
            </button>
            @foreach($categoriesCours as $cat)
                <button type="button" @click="activeCategory = '{{ addslashes($cat->nom) }}'"
                    :class="activeCategory === '{{ addslashes($cat->nom) }}' ? 'bg-[#0BA20B] text-white border-[#0BA20B]' : 'bg-[#FAF7F2] text-[#2C221E] border-[#0BA20B]/40 hover:bg-[#F4EFE6]'"
                    class="px-3 py-1.5 text-xs font-bold uppercase tracking-wider border transition">
                    {{ $cat->nom }}
                </button>
            @endforeach
        </div>
        <span class="text-xs font-semibold text-slate-500">{{ $cours->count() }} cours disponible(s)</span>
    </div>

    <!-- Grid of Courses -->
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
            <div x-show="(activeCategory === 'Tous' || activeCategory === '{{ addslashes($item->categorie ? $item->categorie->nom : '') }}') && (activeMode === 'Tous' || activeMode === '{{ addslashes($modeName) }}')"
                class="bg-white border border-slate-200 shadow-sm flex flex-col group hover:shadow-md transition">
                <div class="relative h-44 overflow-hidden bg-slate-100">
                    <img src="{{ $imgUrl }}" alt="{{ $item->titre }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                    <div class="absolute top-3 left-3 flex flex-wrap gap-1.5">
                        <span class="px-2.5 py-1 bg-[#1E1613]/90 backdrop-blur-sm text-[#0BA20B] text-[9px] font-bold uppercase tracking-widest border border-[#0BA20B]/30">
                            {{ $item->categorie ? $item->categorie->nom : 'Général' }}
                        </span>
                        <span class="px-2.5 py-1 bg-[#0BA20B] text-white text-[9px] font-bold uppercase tracking-widest shadow-sm">
                            {{ $modeName }}
                        </span>
                    </div>
                </div>
                <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                    <div>
                        <h3 class="text-base font-serif-title font-bold text-slate-900 group-hover:text-[#0BA20B] transition-colors">
                            {{ $item->titre }}
                        </h3>
                        <p class="text-xs text-slate-500 mt-1 line-clamp-2">
                            {{ $item->description ?? 'Aucune description disponible pour ce cours.' }}
                        </p>
                        <div class="mt-3 flex items-center gap-2 text-xs font-semibold text-slate-700">
                            <i class="fa-solid fa-user-tie text-[#0BA20B]"></i>
                            <span>Prof. {{ $profName }}</span>
                        </div>
                    </div>
                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                        <div>
                            <span class="text-[10px] text-slate-400 uppercase font-semibold block">Tarif</span>
                            <span class="text-base font-bold text-[#0BA20B]">
                                {{ number_format($item->tarif, 0, ',', ' ') }} € <span class="text-xs text-slate-500 font-normal">/ séance</span>
                            </span>
                        </div>
                        <!-- @if(in_array($item->id, $reservedCoursIds ?? []))
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-1 bg-emerald-100 text-emerald-800 text-[10px] font-bold uppercase tracking-wider">
                                    Déjà inscrit
                                </span>
                                @if($item->supports && $item->supports->count() > 0)
                                    <div class="inline-block relative" x-data="{ open: false }">
                                        <button @click="open = !open" @click.away="open = false" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-900 text-white text-[11px] font-bold uppercase tracking-wider transition shadow cursor-pointer">
                                            📁 Supports ({{ $item->supports->count() }})
                                        </button>
                                        <div x-show="open" style="display: none;" class="absolute bottom-full right-0 mb-1 w-48 bg-white border border-slate-200 shadow-xl z-10 text-left overflow-hidden">
                                            @foreach($item->supports as $support)
                                                <a href="{{ route('dashboard.apprenant.supports.download', $support->id) }}" class="block px-4 py-2 text-xs text-slate-700 hover:bg-slate-50 hover:text-[#0BA20B] border-b border-slate-100 last:border-0 truncate" title="{{ basename($support->fichier) }}">
                                                    ⬇️ {{ basename($support->fichier) }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @else -->
                            <button type="button"
                                @click="openBookingModal({{ $item->id }}, '{{ addslashes($item->titre) }}', '{{ addslashes($profName) }}', '{{ addslashes($modeName) }}', '{{ number_format($item->tarif, 0, ',', ' ') }}')"
                                class="px-4 py-2 bg-[#0BA20B] hover:bg-[#087A08] text-white text-xs font-bold uppercase tracking-wider transition shadow cursor-pointer">
                                Réserver
                            </button>
                        <!-- @endif -->
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-12 bg-white border border-dashed border-slate-200">
                <p class="text-sm text-slate-500">Aucun cours disponible pour le moment.</p>
            </div>
        @endforelse
    </div>

    @if(method_exists($cours, 'hasPages') && $cours->hasPages())
        <div class="mt-6 pt-4 border-t border-slate-200 flex justify-center">
            {{ $cours->links() }}
        </div>
    @endif

    {{-- MODAL DE RÉSERVATION EN DOCK DANS LE DASHBOARD --}}
    <div x-show="showModal"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-[#1E1613]/70 backdrop-blur-sm" x-cloak
        style="display:none;">
        <div @click.away="showModal = false"
            class="bg-[#FAF7F2] w-full max-w-lg shadow-2xl border border-[#0BA20B]/40 p-4 sm:p-5 relative max-h-[90vh] overflow-y-auto">

            <div class="flex justify-between items-start border-b border-[#0BA20B]/20 pb-2.5 mb-3">
                <div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="text-[10px] font-bold uppercase tracking-widest text-[#0BA20B]">Réservation de cours</span>
                        <span x-show="coursMode" class="text-[9px] font-bold uppercase px-2 py-0.5 bg-[#1E1613] text-[#0BA20B]" x-text="coursMode"></span>
                        <span x-show="coursTarif" class="text-[9px] font-bold uppercase px-2 py-0.5 bg-[#0BA20B] text-white" x-text="coursTarif + ' € / séance'"></span>
                    </div>
                    <h3 class="font-serif-title font-bold text-lg text-[#2C221E] mt-0.5" x-text="coursTitre"></h3>
                    <p class="text-xs text-[#6B574F] mt-0.5" x-text="'Professeur : ' + profName"></p>
                </div>
                <button @click="showModal = false" class="text-[#2C221E] hover:text-[#0BA20B] text-2xl font-bold leading-none cursor-pointer">&times;</button>
            </div>

            {{-- Loader --}}
            <div x-show="loading" class="py-6 text-center text-xs text-[#6B574F]">
                <svg class="animate-spin h-6 w-6 text-[#0BA20B] mx-auto mb-2" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Chargement des disponibilités du professeur...
            </div>

            <div x-show="!loading">
                <!-- ANCIEN CODE : Disponibilités du professeur (Désactivé)
                <div class="mb-3 bg-[#F4EFE6] border border-[#0BA20B]/30 p-2.5">
                    <div class="flex items-center justify-between mb-1.5">
                        <h4 class="text-[10px] font-bold uppercase tracking-widest text-[#2C221E] flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-[#0BA20B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Disponibilités du professeur :
                        </h4>
                        <span x-show="disponibilites.length > 0" class="text-[9px] font-bold text-[#0BA20B] bg-[#FAF7F2] border border-[#0BA20B]/40 px-2 py-0.5" x-text="disponibilites.length + ' créneau(x)'"></span>
                    </div>
                    <template x-if="disponibilites.length === 0">
                        <p class="text-xs text-[#8C766B] italic">Aucune disponibilité enregistrée pour le moment.</p>
                    </template>
                    
                    <div x-show="disponibilites.length > 0" class="space-y-1.5 max-h-36 overflow-y-auto pr-1">
                        <template x-for="(slots, dateStr) in getGroupedDisponibilites()" :key="dateStr">
                            <div class="bg-white border border-[#0BA20B]/30 p-2 shadow-sm">
                                <div class="text-[10px] font-bold text-[#0BA20B] uppercase mb-1 flex items-center justify-between border-b border-[#0BA20B]/20 pb-1">
                                    <div class="flex items-center gap-1.5">
                                        <span class="w-2 h-2 bg-emerald-500 rounded-full inline-block"></span>
                                        <span x-text="(slots[0] ? slots[0].jour : '') + ' ' + formatDateFr(dateStr)"></span>
                                    </div>
                                    <span class="text-[9px] text-[#8C766B] font-semibold" x-text="slots.length + ' créneau(x)'"></span>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-1.5">
                                    <template x-for="slot in slots" :key="slot.id">
                                        <button type="button" @click="selectSlot(slot)"
                                                :class="dateReservation === slot.date_dispo && heureDebut === slot.debut.substring(0,5) ? 'bg-[#0BA20B] text-white border-[#0BA20B]' : 'bg-[#FAF7F2] hover:bg-[#F4EFE6] text-[#2C221E] border-[#0BA20B]/30'"
                                                class="w-full flex items-center justify-between border px-2 py-1 text-[11px] font-bold transition cursor-pointer">
                                            <span x-text="slot.debut.substring(0,5) + ' - ' + slot.fin.substring(0,5)"></span>
                                            <span class="text-[9px] font-bold uppercase" :class="dateReservation === slot.date_dispo && heureDebut === slot.debut.substring(0,5) ? 'text-white' : 'text-[#0BA20B]'">✓ Choisir</span>
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
                        <input type="date" name="date_reservation" required min="{{ date('Y-m-d') }}"
                            x-model="dateReservation" @change="onDateChange($event)"
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
                        <button type="button" @click="showModal = false" class="px-3.5 py-1.5 text-xs font-bold uppercase tracking-wider text-[#6B574F] hover:text-[#2C221E] cursor-pointer">
                            Annuler
                        </button>
                        <button type="submit" class="px-4 py-2 bg-[#0BA20B] hover:bg-[#087A08] text-white font-bold text-xs uppercase tracking-widest transition shadow-md cursor-pointer">
                            Confirmer la réservation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
