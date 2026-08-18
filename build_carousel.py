import sys

blade_content = """<section class="relative min-h-screen overflow-hidden bg-[#1E1613]" id="hero"
    x-data="{ 
        activeGallery: null, 
        currentImageIndex: 0, 
        showTitle: '',
        heroSlide: 0,
        slidesCount: 3,
        init() {
            this.startInterval();
        },
        startInterval() {
            this.interval = setInterval(() => {
                this.next();
            }, 7000);
        },
        resetInterval() {
            clearInterval(this.interval);
            this.startInterval();
        },
        next() {
            this.heroSlide = (this.heroSlide + 1) % this.slidesCount;
            this.resetInterval();
        },
        prev() {
            this.heroSlide = (this.heroSlide - 1 + this.slidesCount) % this.slidesCount;
            this.resetInterval();
        }
    }">

    <!-- Slider Track -->
    <div class="flex h-screen transition-transform duration-1000 ease-in-out"
         :style="`transform: translateX(-${heroSlide * 100}vw); width: ${slidesCount * 100}vw;`">
        
        <!-- SLIDE 1: Culture & Raphia -->
        <div class="w-screen h-screen relative flex items-center pt-24 pb-16 shrink-0 overflow-hidden">
            <div class="absolute inset-0 z-0">
                <img alt="Patrimoine Culturel et Arts Musicaux"
                    class="w-full h-full object-cover object-center scale-105 filter brightness-75 contrast-110"
                    referrerpolicy="no-referrer" src="/assets/hero_cultural_bg_1785764970571-BS2uarbi.jpg" />
                <div class="absolute inset-0 bg-gradient-to-r from-[#1E1613] via-[#1E1613]/85 to-[#1E1613]/50 z-20"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-[#1E1613] via-transparent to-[#1E1613]/70 z-20"></div>
                <div class="absolute inset-0 opacity-10 bg-pattern-raphia pointer-events-none z-20"></div>
            </div>
            
            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full transition-all duration-1000 delay-300"
                 :class="heroSlide === 0 ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    <div class="lg:col-span-7 space-y-6 text-left">
                        <h1 class="font-serif-title text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold text-[#FAF7F2] leading-[1.08] tracking-tight">
                            Célébrer la <span class="italic text-[#0BA20B] font-normal">Culture</span>, <br />
                            Façonner le <span class="text-[#0BA20B]">Raphia</span> &amp; <br />
                            Transmettre l'Art.
                        </h1>
                        <p class="text-base sm:text-lg text-[#E6DCD3] font-sans font-light max-w-2xl leading-relaxed">
                            Vitrine officielle de notre association culturelle : découvrez la richesse des arts musicaux
                            traditionnels et modernes, explorez la valeur agro-artisanale du raphia, réservez vos cours
                            d'instruments et soutenez l'émergence des jeunes talents.
                        </p>
                        <div class="pt-2 flex flex-wrap gap-3 items-center">
                            <a href="#courses" class="px-6 py-3.5 rounded-none bg-[#0BA20B] hover:bg-[#087A08] text-white font-semibold text-sm shadow-xl shadow-[#0BA20B]/25 hover:shadow-2xl transition-all transform hover:-translate-y-1 flex items-center gap-2 group">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                <span>Réserver un Cours</span>
                            </a>
                            <a class="px-5 py-3.5 rounded-none bg-white/10 hover:bg-white/20 text-white font-semibold text-sm border border-white/20 backdrop-blur-md transition-all flex items-center gap-2" href="#events">
                                <svg class="w-4 h-4 text-[#0BA20B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span>Voir les Événements</span>
                            </a>
                        </div>
                    </div>
                    
                    <div class="lg:col-span-5 relative hidden lg:block">
                        <!-- Event Card / Feature for Slide 1 -->
                        <div class="glass-dark rounded-none p-6 shadow-2xl border border-[#0BA20B]/30 space-y-5">
                            <div class="flex items-center justify-between pb-3 border-b border-white/10">
                                <div class="flex items-center gap-2">
                                    <span class="flex h-3 w-3 relative">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-none bg-[#0BA20B] opacity-75"></span>
                                        <span class="relative inline-flex rounded-none h-3 w-3 bg-[#0BA20B]"></span>
                                    </span>
                                    <span class="text-xs font-bold uppercase tracking-wider text-[#0BA20B]">À la Une ce Mois-ci</span>
                                </div>
                                <span class="text-[11px] text-white/60 bg-white/10 px-2 py-0.5 rounded-none">Prochain Rendez-vous</span>
                            </div>
                            
                            @if(isset($evenementPhare) && $evenementPhare)
                                @php
                                    $mainImg = $evenementPhare->images->where('is_principal', true)->first() ?? $evenementPhare->images->first();
                                    $imgPath = $mainImg ? asset('storage/' . $mainImg->image_path) : '/assets/hero_cultural_bg_1785764970571-BS2uarbi.jpg';
                                    $galleryData = $evenementPhare->images->map(function ($img) {
                                        return ['url' => asset('storage/' . $img->image_path), 'is_principal' => (bool) $img->is_principal];
                                    })->values()->all();
                                    if(empty($galleryData)) $galleryData = [['url' => $imgPath, 'is_principal' => true]];
                                @endphp
                                <div class="space-y-3">
                                    <div class="relative rounded-none overflow-hidden h-44 group cursor-pointer"
                                        data-gallery="{{ json_encode($galleryData) }}" data-title="{{ $evenementPhare->titre }}"
                                        @click="activeGallery = JSON.parse($el.dataset.gallery); currentImageIndex = 0; showTitle = $el.dataset.title;">
                                        <img alt="{{ $evenementPhare->titre }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="{{ $imgPath }}" />
                                        <div class="absolute inset-0 bg-gradient-to-t from-[#1E1613] via-transparent to-transparent"></div>
                                        <div class="absolute bottom-3 left-3 right-3 flex items-end justify-between">
                                            <div>
                                                <span class="text-[10px] uppercase font-bold text-[#0BA20B] bg-[#1E1613]/80 px-2 py-0.5 rounded-none">{{ $evenementPhare->categorie ? $evenementPhare->categorie->libelle : 'Événement' }}</span>
                                                <h4 class="text-sm font-bold text-white font-serif-title mt-1 line-clamp-2">{{ $evenementPhare->titre }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-2 flex gap-2">
                                    <a class="w-full py-2.5 rounded-none bg-[#0BA20B] hover:bg-[#087A08] text-[#1E1613] font-bold text-xs text-center transition-colors shadow" href="{{ route('evenements.show', $evenementPhare->id) }}">
                                        Voir les détails
                                    </a>
                                </div>
                            @else
                                <div class="space-y-3">
                                    <div class="relative rounded-none overflow-hidden h-44">
                                        <img alt="Aucun événement" class="w-full h-full object-cover" src="/assets/hero_cultural_bg_1785764970571-BS2uarbi.jpg" />
                                        <div class="absolute inset-0 bg-gradient-to-t from-[#1E1613] via-transparent to-transparent"></div>
                                        <div class="absolute bottom-3 left-3 right-3">
                                            <span class="text-[10px] uppercase font-bold text-[#0BA20B] bg-[#1E1613]/80 px-2 py-0.5 rounded-none">À venir</span>
                                            <h4 class="text-sm font-bold text-white font-serif-title mt-1">Aucun événement à la une</h4>
                                        </div>
                                    </div>
                                    <div class="text-xs text-[#D1C5B8] text-center py-4">Revenez bientôt pour découvrir nos prochains événements.</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- SLIDE 2: Musique & Talents -->
        <div class="w-screen h-screen relative flex items-center pt-24 pb-16 shrink-0 overflow-hidden">
            <div class="absolute inset-0 z-0">
                <img alt="Arts Musicaux et Talents"
                    class="w-full h-full object-cover object-center scale-105 filter brightness-75 contrast-110"
                    referrerpolicy="no-referrer" src="/assets/hero_music_art.png" />
                <div class="absolute inset-0 bg-gradient-to-r from-[#1E1613] via-[#1E1613]/85 to-[#1E1613]/50 z-20"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-[#1E1613] via-transparent to-[#1E1613]/70 z-20"></div>
                <div class="absolute inset-0 opacity-10 bg-pattern-raphia pointer-events-none z-20"></div>
            </div>
            
            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full transition-all duration-1000 delay-300"
                 :class="heroSlide === 1 ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    <div class="lg:col-span-7 space-y-6 text-left">
                        <h2 class="font-serif-title text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold text-[#FAF7F2] leading-[1.08] tracking-tight">
                            L'Excellence <span class="italic text-[#0BA20B] font-normal">Musicale</span> &amp; <br />
                            Les Voix de <span class="text-[#0BA20B]">Demain</span>.
                        </h2>
                        <p class="text-base sm:text-lg text-[#E6DCD3] font-sans font-light max-w-2xl leading-relaxed">
                            Plongez dans l'univers de notre chorale et de nos classes de musique. Que vous soyez débutant ou artiste confirmé, nos professeurs vous accompagnent pour perfectionner votre art dans un cadre exceptionnel.
                        </p>
                        <div class="pt-2 flex flex-wrap gap-3 items-center">
                            <a href="#talents" class="px-6 py-3.5 rounded-none bg-[#0BA20B] hover:bg-[#087A08] text-white font-semibold text-sm shadow-xl shadow-[#0BA20B]/25 hover:shadow-2xl transition-all transform hover:-translate-y-1 flex items-center gap-2 group">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.017 2.814a1 1 0 011.966 0l1.051 5.558a2 2 0 001.594 1.594l5.558 1.051a1 1 0 010 1.966l-5.558 1.051a2 2 0 00-1.594 1.594l-1.051 5.558a1 1 0 01-1.966 0l-1.051-5.558a2 2 0 00-1.594-1.594l-5.558-1.051a1 1 0 010-1.966l5.558-1.051a2 2 0 001.594-1.594l1.051-5.558z"/></svg>
                                <span>Découvrir les Talents</span>
                            </a>
                        </div>
                    </div>
                    <div class="lg:col-span-5 relative hidden lg:block">
                        <div class="glass-dark rounded-none p-10 shadow-2xl border border-white/10 relative overflow-hidden group">
                            <div class="absolute inset-0 bg-[#0BA20B]/5 transform -skew-x-12 translate-x-full group-hover:translate-x-0 transition-transform duration-1000 ease-out"></div>
                            <svg class="w-12 h-12 text-[#0BA20B]/40 mb-6 relative z-10" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21L16.4 14.602H11.6V3H21.6V14.602L19.217 21H14.017ZM3.617 21L6 14.602H1.2V3H11.2V14.602L8.817 21H3.617Z"/></svg>
                            <p class="text-xl font-serif-title font-light leading-relaxed text-[#FAF7F2] relative z-10">
                                "La musique est la langue des émotions, et le talent notre plus belle voix. Rejoignez une communauté où chaque note compte."
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SLIDE 3: Agriculture & Raphia -->
        <div class="w-screen h-screen relative flex items-center pt-24 pb-16 shrink-0 overflow-hidden">
            <div class="absolute inset-0 z-0">
                <img alt="Filière Raphia"
                    class="w-full h-full object-cover object-center scale-105 filter brightness-75 contrast-110"
                    referrerpolicy="no-referrer" src="/assets/hero_agriculture.png" />
                <div class="absolute inset-0 bg-gradient-to-r from-[#1E1613] via-[#1E1613]/85 to-[#1E1613]/50 z-20"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-[#1E1613] via-transparent to-[#1E1613]/70 z-20"></div>
                <div class="absolute inset-0 opacity-10 bg-pattern-raphia pointer-events-none z-20"></div>
            </div>
            
            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full transition-all duration-1000 delay-300"
                 :class="heroSlide === 2 ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    <div class="lg:col-span-7 space-y-6 text-left">
                        <h2 class="font-serif-title text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold text-[#FAF7F2] leading-[1.08] tracking-tight">
                            L'Héritage du <span class="italic text-[#0BA20B] font-normal">Raphia</span>, <br />
                            Une Filière <span class="text-[#0BA20B]">d'Avenir</span>.
                        </h2>
                        <p class="text-base sm:text-lg text-[#E6DCD3] font-sans font-light max-w-2xl leading-relaxed">
                            De la culture de la plante jusqu'au tissage artisanal, nous valorisons la filière raphia. Découvrez un savoir-faire ancestral qui allie respect de la nature et développement socio-économique.
                        </p>
                        <div class="pt-2 flex flex-wrap gap-3 items-center">
                            <a href="#about" class="px-6 py-3.5 rounded-none bg-[#0BA20B] hover:bg-[#087A08] text-white font-semibold text-sm shadow-xl shadow-[#0BA20B]/25 hover:shadow-2xl transition-all transform hover:-translate-y-1 flex items-center gap-2 group">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                <span>Explorer la Filière Raphia</span>
                            </a>
                            <a class="px-5 py-3.5 rounded-none bg-white/10 hover:bg-white/20 text-white font-semibold text-sm border border-white/20 backdrop-blur-md transition-all flex items-center gap-2" href="#donation">
                                <svg class="w-4 h-4 text-[#0BA20B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                <span>Soutenir les Artisans</span>
                            </a>
                        </div>
                    </div>
                    <div class="lg:col-span-5 relative hidden lg:block">
                        <div class="glass-dark rounded-none p-10 shadow-2xl border border-white/10 relative overflow-hidden group border-t-4 border-t-[#0BA20B]">
                            <h4 class="text-[#0BA20B] text-xs font-bold uppercase tracking-wider mb-2">Impact Écologique</h4>
                            <p class="text-3xl font-serif-title font-bold text-white mb-4">100% Naturel</p>
                            <p class="text-sm text-white/70 leading-relaxed mb-6">
                                Le raphia est une fibre entièrement biodégradable et respectueuse de l'environnement, contribuant à la préservation de nos écosystèmes.
                            </p>
                            <div class="w-full h-1 bg-white/10 rounded-full overflow-hidden">
                                <div class="h-full bg-[#0BA20B] w-[100%]"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Navigation Arrows -->
    <button type="button" @click.stop.prevent="prev()" class="absolute left-4 top-1/2 -translate-y-1/2 z-30 w-12 h-12 flex items-center justify-center rounded-none bg-[#1E1613]/40 border border-white/10 hover:border-[#0BA20B] hover:bg-[#0BA20B]/80 text-white transition-all backdrop-blur-sm group">
        <svg class="w-6 h-6 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </button>
    <button type="button" @click.stop.prevent="next()" class="absolute right-4 top-1/2 -translate-y-1/2 z-30 w-12 h-12 flex items-center justify-center rounded-none bg-[#1E1613]/40 border border-white/10 hover:border-[#0BA20B] hover:bg-[#0BA20B]/80 text-white transition-all backdrop-blur-sm group">
        <svg class="w-6 h-6 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    </button>

    <!-- Navigation Dots -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-30 flex items-center gap-3">
        <template x-for="i in slidesCount" :key="i">
            <button type="button" @click.stop.prevent="heroSlide = i - 1; resetInterval();"
                class="h-2 transition-all rounded-none"
                :class="heroSlide === i - 1 ? 'w-8 bg-[#0BA20B]' : 'w-2 bg-white/30 hover:bg-white/60'">
            </button>
        </template>
    </div>

    <!-- Lightbox Modal (For Event Card in Slide 1) -->
    <div x-show="activeGallery" class="fixed inset-0 z-[100] bg-slate-950/90 backdrop-blur-md flex items-center justify-center p-4 sm:p-6" x-cloak @keydown.escape.window="activeGallery = null">
        <div class="relative w-full max-w-4xl bg-[#1E1613] border border-[#0BA20B]/30 shadow-2xl flex flex-col max-h-[90vh] overflow-hidden rounded-none" @click.away="activeGallery = null">
            <div class="px-6 py-4 border-b border-[#0BA20B]/20 flex items-center justify-between bg-[#1E1613]">
                <div>
                    <h3 class="text-sm font-serif-title font-bold text-[#FAF7F2] uppercase tracking-wider" x-text="showTitle"></h3>
                    <p class="text-[10px] text-[#0BA20B] uppercase tracking-widest mt-0.5">
                        Image <span x-text="currentImageIndex + 1"></span> sur <span x-text="activeGallery ? activeGallery.length : 0"></span>
                        <template x-if="activeGallery && activeGallery[currentImageIndex] && activeGallery[currentImageIndex].is_principal">
                            <span class="ml-2 text-[#0BA20B] font-bold">• Image Principale</span>
                        </template>
                    </p>
                </div>
                <button type="button" @click="activeGallery = null" class="text-[#0BA20B] hover:text-[#0BA20B] p-1 transition-colors" title="Fermer (Echap)">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            <div class="relative flex-1 bg-black flex items-center justify-center min-h-[350px] p-4 overflow-hidden">
                <template x-if="activeGallery && activeGallery[currentImageIndex]">
                    <img :src="activeGallery[currentImageIndex].url" class="max-h-[60vh] max-w-full object-contain shadow-2xl transition-all duration-300">
                </template>
                <template x-if="activeGallery && activeGallery.length > 1">
                    <div>
                        <button type="button" @click.stop.prevent="currentImageIndex = (currentImageIndex === 0) ? activeGallery.length - 1 : currentImageIndex - 1" class="absolute left-4 top-1/2 -translate-y-1/2 bg-[#1E1613]/80 hover:bg-[#0BA20B] text-[#FAF7F2] p-3 transition-colors border border-[#0BA20B]/30 shadow-xl rounded-none">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" /></svg>
                        </button>
                        <button type="button" @click.stop.prevent="currentImageIndex = (currentImageIndex === activeGallery.length - 1) ? 0 : currentImageIndex + 1" class="absolute right-4 top-1/2 -translate-y-1/2 bg-[#1E1613]/80 hover:bg-[#0BA20B] text-[#FAF7F2] p-3 transition-colors border border-[#0BA20B]/30 shadow-xl rounded-none">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" /></svg>
                        </button>
                    </div>
                </template>
            </div>
            <template x-if="activeGallery && activeGallery.length > 1">
                <div class="px-6 py-4 bg-[#1E1613] border-t border-[#0BA20B]/20 flex items-center justify-center gap-3 overflow-x-auto">
                    <template x-for="(img, idx) in activeGallery" :key="idx">
                        <button type="button" @click.stop.prevent="currentImageIndex = idx" class="w-14 h-14 border-2 overflow-hidden transition-all shrink-0 rounded-none" :class="currentImageIndex === idx ? 'border-[#0BA20B] scale-105 opacity-100' : 'border-[#0BA20B]/30 opacity-50 hover:opacity-100'">
                            <img :src="img.url" class="w-full h-full object-cover">
                        </button>
                    </template>
                </div>
            </template>
        </div>
    </div>
</section>
"""

import os
import re

with open('resources/views/welcome.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Replace everything from <section class="relative min-h-screen ... id="hero" ... to </section>
# Be careful with regex since </section> can appear multiple times.
# We'll use a regex that captures everything until the first <section class="py-24 bg-[#FAF7F2]" id="about">
pattern = re.compile(r'<section[^>]*?id="hero"[\s\S]*?</section>\s*(?=<section[^>]*?id="about")', re.IGNORECASE)

new_content = pattern.sub(blade_content + "\n        ", content)

with open('resources/views/welcome.blade.php', 'w', encoding='utf-8') as f:
    f.write(new_content)

print("Done")
