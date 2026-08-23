@extends('layouts.app')
@section('content')
    <main>
        <section class="relative min-h-screen overflow-hidden bg-[#1E1613]" id="hero"
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
                            Célébrer l' <span class="italic text-[#0BA20B] font-normal">Agriculture</span>, <br />
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

        <section class="py-24 bg-[#FAF7F2] relative overflow-hidden" id="about">
            <div class="absolute top-0 right-0 w-96 h-96 bg-[#0BA20B]/10 rounded-full blur-3xl -z-10">
            </div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-[#0BA20B]/10 rounded-full blur-3xl -z-10">
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-20">
                <div class="text-center max-w-3xl mx-auto space-y-4">
                    <div
                        class="inline-flex items-center gap-2 px-3.5 py-1 rounded-none bg-[#F4EFE6] border border-[#0BA20B]/30 text-[#0BA20B] text-xs font-bold uppercase tracking-widest">
                        <svg aria-hidden="true" class="lucide lucide-sparkles w-3.5 h-3.5" fill="none" height="24"
                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z">
                            </path>
                            <path d="M20 2v4">
                            </path>
                            <path d="M22 4h-4">
                            </path>
                            <circle cx="4" cy="20" r="2">
                            </circle>
                        </svg>
                        <span>
                            Notre Mission &amp; Notre Vision
                        </span>
                    </div>
                    <h2 class="font-serif-title text-3xl sm:text-4xl md:text-5xl font-bold text-[#2C221E] tracking-tight">
                        {{ $association?->mission ?? 'Mission à définir' }}
                    </h2>
                    <p class="text-sm sm:text-base text-[#6B574F] font-sans leading-relaxed">
                        {{ $association?->vision ?? 'Vision à définir' }}
                    </p>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div class="space-y-6">
                        <h3
                            class="font-serif-title text-justify text-2xl sm:text-3xl font-bold text-[#2C221E] border-l-4 border-[#0BA20B] pl-4">
                            Notre Histoire
                        </h3>
                        <p class="text-sm sm:text-base text-[#5C4A42] leading-relaxed text-justify">
                            {{ $association?->historique ?? 'Historique à définir' }}
                        </p>
                    </div>
                    <div class="relative">
                        <div class="relative rounded-none overflow-hidden shadow-2xl border-4 border-white">
                            <img alt="Enseignement musical et atelier culturel" class="w-full h-[400px] object-cover"
                                referrerpolicy="no-referrer"
                                src="https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&amp;fit=crop&amp;q=80&amp;w=900" />
                            <div class="absolute inset-0 bg-gradient-to-t from-[#1E1613]/80 via-transparent to-transparent">
                            </div>
                            <div class="absolute bottom-6 left-6 right-6 text-white">
                                <span
                                    class="text-xs uppercase font-bold text-[#0BA20B] bg-[#1E1613]/80 px-2.5 py-1 rounded-none">
                                    Atelier Vivant
                                </span>
                                <p class="text-sm font-serif-title italic mt-2 text-white/90">
                                    « La culture ne s'hérite pas seulement, elle se cultive chaque jour. »
                                </p>
                            </div>
                        </div>
                        <div
                            class="absolute -bottom-6 -left-6 bg-[#1E1613] text-[#FAF7F2] p-5 rounded-none shadow-xl border border-[#0BA20B]/40 max-w-xs hidden sm:block">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-none bg-[#0BA20B] flex items-center justify-center text-white shrink-0">
                                    <svg aria-hidden="true" class="lucide lucide-shield-check w-5 h-5" fill="none"
                                        height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z">
                                        </path>
                                        <path d="m9 12 2 2 4-4">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-xs font-bold text-[#0BA20B] uppercase tracking-wider block">
                                        Association Agréée
                                    </span>
                                    <span class="text-xs text-white/80">
                                        Reconnue d'Intérêt Culturel &amp; Social
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 pt-8">
                    <div
                        class="glass-panel rounded-none p-6 text-center space-y-2 hover:border-[#0BA20B]/40 transition-all transform hover:-translate-y-1 shadow-sm">
                        <div class="text-3xl sm:text-4xl font-bold font-serif-title text-[#0BA20B]">
                            {{ $stats['apprenants'] ?? '0+' }}
                        </div>
                        <div class="text-xs sm:text-sm font-semibold text-[#2C221E]">
                            Apprenants Accompagnés
                        </div>
                    </div>
                    <div
                        class="glass-panel rounded-none p-6 text-center space-y-2 hover:border-[#0BA20B]/40 transition-all transform hover:-translate-y-1 shadow-sm">
                        <div class="text-3xl sm:text-4xl font-bold font-serif-title text-[#0BA20B]">
                            {{ $stats['enseignants'] ?? '0' }}
                        </div>
                        <div class="text-xs sm:text-sm font-semibold text-[#2C221E]">
                            Maitres-Enseignants &amp; Artistes
                        </div>
                    </div>
                    <div
                        class="glass-panel rounded-none p-6 text-center space-y-2 hover:border-[#0BA20B]/40 transition-all transform hover:-translate-y-1 shadow-sm">
                        <div class="text-3xl sm:text-4xl font-bold font-serif-title text-[#0BA20B]">
                            {{ $stats['evenements'] ?? '0+' }}
                        </div>
                        <div class="text-xs sm:text-sm font-semibold text-[#2C221E]">
                            Événements &amp; Éco-Ateliers / an
                        </div>
                    </div>
                    <div
                        class="glass-panel rounded-none p-6 text-center space-y-2 hover:border-[#0BA20B]/40 transition-all transform hover:-translate-y-1 shadow-sm">
                        <div class="text-3xl sm:text-4xl font-bold font-serif-title text-[#0BA20B]">
                            {{ $stats['oeuvres'] ?? '0+' }}
                        </div>
                        <div class="text-xs sm:text-sm font-semibold text-[#2C221E]">
                            Œuvres en Raphia Façonnées
                        </div>
                    </div>
                </div>
                <div class="pt-12 border-t border-[#0BA20B]/20 space-y-8" id="team">
                    <div class="text-center space-y-2">
                        <h3 class="font-serif-title text-2xl font-bold text-[#2C221E]">
                            Équipe Dirigeante &amp; Maîtres-Artisans
                        </h3>
                        <p class="text-xs sm:text-sm text-[#6B574F]">
                            Des passionnés engagés pour la transmission des savoirs.
                        </p>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($equipes as $equipe)
                            <div
                                class="bg-white rounded-none p-6 border border-[#0BA20B]/20 text-center space-y-4 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group">
                                @if($equipe->photo)
                                    <img alt="{{ $equipe->nom }} {{ $equipe->prenom }}"
                                        class="w-24 h-24 rounded-none mx-auto object-cover ring-2 ring-[#0BA20B]/40 group-hover:ring-[#0BA20B] transition-all duration-300"
                                        referrerpolicy="no-referrer" src="{{ asset('storage/' . $equipe->photo) }}" />
                                @else
                                    <img alt="{{ $equipe->nom }} {{ $equipe->prenom }}"
                                        class="w-24 h-24 rounded-none mx-auto object-cover ring-2 ring-[#0BA20B]/40 group-hover:ring-[#0BA20B] transition-all duration-300"
                                        referrerpolicy="no-referrer"
                                        src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&amp;fit=crop&amp;q=80&amp;w=300" />
                                @endif
                                <div class="space-y-2">
                                    <h4 class="font-bold text-base text-[#2C221E] group-hover:text-[#0BA20B] transition-colors">
                                        {{ $equipe->nom }} {{ $equipe->prenom }}
                                    </h4>
                                    <p class="text-xs text-[#0BA20B] font-medium uppercase tracking-wide">
                                        {{ $equipe->fonction }}
                                    </p>
                                    @if($equipe->biographie)
                                        <p class="text-xs text-[#6B574F] leading-relaxed line-clamp-3">
                                            {{ \Illuminate\Support\Str::limit($equipe->biographie, 120) }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        {{-- <section class="py-24 bg-[#F4EFE6] relative overflow-hidden" id="raphia-showcase">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
                <div class="text-center max-w-3xl mx-auto space-y-4">
                    <div
                        class="inline-flex items-center gap-2 px-3.5 py-1 rounded-none bg-[#FAF7F2] border border-[#0BA20B]/40 text-[#0BA20B] text-xs font-bold uppercase tracking-widest shadow-sm">
                        <svg aria-hidden="true" class="lucide lucide-tree-pine w-3.5 h-3.5" fill="none" height="24"
                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="m17 14 3 3.3a1 1 0 0 1-.7 1.7H4.7a1 1 0 0 1-.7-1.7L7 14h-.3a1 1 0 0 1-.7-1.7L9 9h-.2A1 1 0 0 1 8 7.3L12 3l4 4.3a1 1 0 0 1-.8 1.7H15l3 3.3a1 1 0 0 1-.7 1.7H17Z">
                            </path>
                            <path d="M12 22v-3">
                            </path>
                        </svg>
                        <span>
                            Agriculture Culturelle &amp; Eco-Artisanat
                        </span>
                    </div>
                    <h2 class="font-serif-title text-3xl sm:text-4xl md:text-5xl font-bold text-[#2C221E] tracking-tight">
                        La Magie du Raphia : De la Palme Végétale à l’Objet Décoratif
                    </h2>
                    <p class="text-sm sm:text-base text-[#6B574F] font-sans leading-relaxed">
                        Valorisation de la plante de raphia, transmission des gestes de tressage ancestral et création de
                        pièces éco-responsables faites à la main par nos maîtres-artisans.
                    </p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div
                        class="bg-[#FAF7F2] rounded-none p-6 border border-[#0BA20B]/30 space-y-3 relative group hover:border-[#0BA20B] transition-colors shadow-sm">
                        <div
                            class="text-2xl font-bold font-serif-title text-[#0BA20B] bg-[#F4EFE6] w-10 h-10 rounded-none flex items-center justify-center">
                            01
                        </div>
                        <h4 class="font-bold text-base text-[#2C221E]">
                            Récolte Éco-Responsable
                        </h4>
                        <p class="text-xs text-[#6B574F] leading-relaxed">
                            Prélèvement sélectif des jeunes palmes de raphia sans endommager le palmier hôte dans nos
                            plantations associatives.
                        </p>
                    </div>
                    <div
                        class="bg-[#FAF7F2] rounded-none p-6 border border-[#0BA20B]/30 space-y-3 relative group hover:border-[#0BA20B] transition-colors shadow-sm">
                        <div
                            class="text-2xl font-bold font-serif-title text-[#0BA20B] bg-[#F4EFE6] w-10 h-10 rounded-none flex items-center justify-center">
                            02
                        </div>
                        <h4 class="font-bold text-base text-[#2C221E]">
                            Extraction &amp; Séchage
                        </h4>
                        <p class="text-xs text-[#6B574F] leading-relaxed">
                            Pelage délicat de l’épiderme végétal pour obtenir la fibre blonde, séchée au soleil tropical
                            pour assurer souplesse et résistance.
                        </p>
                    </div>
                    <div
                        class="bg-[#FAF7F2] rounded-none p-6 border border-[#0BA20B]/30 space-y-3 relative group hover:border-[#0BA20B] transition-colors shadow-sm">
                        <div
                            class="text-2xl font-bold font-serif-title text-[#0BA20B] bg-[#F4EFE6] w-10 h-10 rounded-none flex items-center justify-center">
                            03
                        </div>
                        <h4 class="font-bold text-base text-[#2C221E]">
                            Teinture Végétale
                        </h4>
                        <p class="text-xs text-[#6B574F] leading-relaxed">
                            Coloration naturelle à base d’écorces, de feuilles d’indigo, de racines et de curcuma sans aucun
                            produit chimique.
                        </p>
                    </div>
                    <div
                        class="bg-[#FAF7F2] rounded-none p-6 border border-[#0BA20B]/30 space-y-3 relative group hover:border-[#0BA20B] transition-colors shadow-sm">
                        <div
                            class="text-2xl font-bold font-serif-title text-[#0BA20B] bg-[#F4EFE6] w-10 h-10 rounded-none flex items-center justify-center">
                            04
                        </div>
                        <h4 class="font-bold text-base text-[#2C221E]">
                            Tissage &amp; Façonnage
                        </h4>
                        <p class="text-xs text-[#6B574F] leading-relaxed">
                            Tressage minutieux par nos artisanes pour fabriquer luminaires, paniers, sacoches et tentures
                            d’exception.
                        </p>
                    </div>
                </div>
                <div
                    class="bg-[#1E1613] text-[#FAF7F2] rounded-none overflow-hidden shadow-2xl border border-[#0BA20B]/30 grid grid-cols-1 lg:grid-cols-12">
                    <div class="lg:col-span-7 p-8 sm:p-12 space-y-6 flex flex-col justify-center">
                        <div
                            class="inline-flex items-center gap-2 px-3 py-1 rounded-none bg-[#0BA20B]/30 border border-[#0BA20B]/50 text-[#0BA20B] text-xs font-bold uppercase">
                            <svg aria-hidden="true" class="lucide lucide-sparkles w-3.5 h-3.5" fill="none" height="24"
                                stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z">
                                </path>
                                <path d="M20 2v4">
                                </path>
                                <path d="M22 4h-4">
                                </path>
                                <circle cx="4" cy="20" r="2">
                                </circle>
                            </svg>
                            <span>
                                Savoir-Faire Unique
                            </span>
                        </div>
                        <h3 class="font-serif-title text-3xl sm:text-4xl font-bold leading-tight text-[#FAF7F2]">
                            L'Artisanat du Raphia : Soutenez les Femmes Artisanes Locales
                        </h3>
                        <p class="text-sm sm:text-base text-[#D1C5B8] leading-relaxed font-sans">
                            Chaque objet façonné dans notre atelier participe à l'autonomisation financière des femmes et
                            des jeunes de la région. En faisant l'acquisition d'une création ou en vous inscrivant à nos
                            cours de tissage, vous préservez un patrimoine vivant.
                        </p>
                        <div class="grid grid-cols-2 gap-4 text-xs text-[#E6DCD3] pt-2">
                            <div class="flex items-center gap-2">
                                <svg aria-hidden="true" class="lucide lucide-check w-4 h-4 text-[#0BA20B]" fill="none"
                                    height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20 6 9 17l-5-5">
                                    </path>
                                </svg>
                                <span>
                                    100% Fibres Naturelles
                                </span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg aria-hidden="true" class="lucide lucide-check w-4 h-4 text-[#0BA20B]" fill="none"
                                    height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20 6 9 17l-5-5">
                                    </path>
                                </svg>
                                <span>
                                    Commerce Équitable
                                </span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg aria-hidden="true" class="lucide lucide-check w-4 h-4 text-[#0BA20B]" fill="none"
                                    height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20 6 9 17l-5-5">
                                    </path>
                                </svg>
                                <span>
                                    Ateliers de Tissage
                                </span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg aria-hidden="true" class="lucide lucide-check w-4 h-4 text-[#0BA20B]" fill="none"
                                    height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20 6 9 17l-5-5">
                                    </path>
                                </svg>
                                <span>
                                    Financement Projets Jeunes
                                </span>
                            </div>
                        </div>
                        <div class="pt-4 flex flex-wrap gap-4">
                            <a class="px-6 py-3 rounded-none bg-[#0BA20B] hover:bg-[#087A08] text-white font-bold text-xs shadow-lg transition-colors inline-flex items-center gap-2"
                                href="#courses">
                                <span>
                                    S'inscrire à l'Atelier de Tissage
                                </span>
                                <svg aria-hidden="true" class="lucide lucide-arrow-right w-4 h-4" fill="none" height="24"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 12h14">
                                    </path>
                                    <path d="m12 5 7 7-7 7">
                                    </path>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="lg:col-span-5 relative min-h-[320px]">
                        <img alt="Créations artisanales en raphia" class="w-full h-full object-cover"
                            referrerpolicy="no-referrer" src="/assets/raphia_artisanal_crafts_1785764982514-DDF_8lz7.jpg" />
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-[#1E1613] via-transparent to-transparent lg:block hidden">
                        </div>
                    </div>
                </div>
                <div class="space-y-8">
                    <div
                        class="flex flex-col sm:flex-row items-center justify-between gap-4 border-b border-[#0BA20B]/30 pb-4">
                        <div>
                            <h3 class="font-serif-title text-2xl font-bold text-[#2C221E]">
                                Galerie des Créations Artisanales
                            </h3>
                            <p class="text-xs text-[#6B574F]">
                                Commandez directement une création façonnée dans nos ateliers.
                            </p>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <button
                                class="px-3.5 py-1.5 rounded-none text-xs font-semibold transition-all bg-[#0BA20B] text-white shadow-sm">
                                Tous
                            </button>
                            <button
                                class="px-3.5 py-1.5 rounded-none text-xs font-semibold transition-all bg-[#FAF7F2] text-[#2C221E] hover:bg-white border border-[#0BA20B]/30">
                                Luminaires
                            </button>
                            <button
                                class="px-3.5 py-1.5 rounded-none text-xs font-semibold transition-all bg-[#FAF7F2] text-[#2C221E] hover:bg-white border border-[#0BA20B]/30">
                                Décoration
                            </button>
                            <button
                                class="px-3.5 py-1.5 rounded-none text-xs font-semibold transition-all bg-[#FAF7F2] text-[#2C221E] hover:bg-white border border-[#0BA20B]/30">
                                Sacs &amp; Accessoires
                            </button>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div
                            class="bg-[#FAF7F2] rounded-none overflow-hidden border border-[#0BA20B]/30 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
                            <div>
                                <div class="relative h-48 overflow-hidden">
                                    <img alt="Suspension Lumineuse en Raphia Tissé à la Main"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                        referrerpolicy="no-referrer"
                                        src="/assets/raphia_artisanal_crafts_1785764982514-DDF_8lz7.jpg" />
                                    <span
                                        class="absolute top-3 left-3 bg-[#1E1613]/80 text-[#0BA20B] text-[10px] font-bold px-2.5 py-0.5 rounded-none backdrop-blur-sm">
                                        Luminaires
                                    </span>
                                </div>
                                <div class="p-5 space-y-2">
                                    <h4 class="font-serif-title font-bold text-base text-[#2C221E] line-clamp-1">
                                        Suspension Lumineuse en Raphia Tissé à la Main
                                    </h4>
                                    <p class="text-xs text-[#6B574F] line-clamp-2">
                                        Une pièce maîtresse de décoration apportant une lumière douce, tamisée et
                                        chaleureuse. Tissage fin à motifs losanges traditionnels.
                                    </p>
                                    <div class="text-[11px] text-[#8C766B] space-y-1 pt-2 border-t border-[#0BA20B]/20">
                                        <p>
                                            <strong>
                                                Matière:
                                            </strong>
                                            Fibre de Raphia 100% Naturelle &amp; Structure Bambou
                                        </p>
                                        <p>
                                            <strong>
                                                Taille:
                                            </strong>
                                            Diamètre 45cm x Hauteur 50cm
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-5 pt-0 flex items-center justify-between border-t border-[#0BA20B]/10 mt-2">
                                <span class="font-bold font-serif-title text-lg text-[#0BA20B]">
                                    75 €
                                </span>
                                <button
                                    class="px-3 py-1.5 rounded-none bg-[#2C221E] hover:bg-[#0BA20B] text-white text-xs font-bold transition-colors flex items-center gap-1.5">
                                    <svg aria-hidden="true" class="lucide lucide-shopping-bag w-3.5 h-3.5" fill="none"
                                        height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16 10a4 4 0 0 1-8 0">
                                        </path>
                                        <path d="M3.103 6.034h17.794">
                                        </path>
                                        <path
                                            d="M3.4 5.467a2 2 0 0 0-.4 1.2V20a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6.667a2 2 0 0 0-.4-1.2l-2-2.667A2 2 0 0 0 17 2H7a2 2 0 0 0-1.6.8z">
                                        </path>
                                    </svg>
                                    <span>
                                        Commander / Détails
                                    </span>
                                </button>
                            </div>
                        </div>
                        <div
                            class="bg-[#FAF7F2] rounded-none overflow-hidden border border-[#0BA20B]/30 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
                            <div>
                                <div class="relative h-48 overflow-hidden">
                                    <img alt="Panier Cérémoniel &amp; Tenture Murale Organique"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                        referrerpolicy="no-referrer"
                                        src="https://images.unsplash.com/photo-1584100936595-c0654b55a2e2?auto=format&amp;fit=crop&amp;q=80&amp;w=800" />
                                    <span
                                        class="absolute top-3 left-3 bg-[#1E1613]/80 text-[#0BA20B] text-[10px] font-bold px-2.5 py-0.5 rounded-none backdrop-blur-sm">
                                        Décoration
                                    </span>
                                </div>
                                <div class="p-5 space-y-2">
                                    <h4 class="font-serif-title font-bold text-base text-[#2C221E] line-clamp-1">
                                        Panier Cérémoniel &amp; Tenture Murale Organique
                                    </h4>
                                    <p class="text-xs text-[#6B574F] line-clamp-2">
                                        Objet mural décoratif inspiré des motifs sacrés du village. Teinture naturelle
                                        écologique issue de plantes locales.
                                    </p>
                                    <div class="text-[11px] text-[#8C766B] space-y-1 pt-2 border-t border-[#0BA20B]/20">
                                        <p>
                                            <strong>
                                                Matière:
                                            </strong>
                                            Fibre de Raphia, Teintures Végétales Indigo &amp; Écorce
                                        </p>
                                        <p>
                                            <strong>
                                                Taille:
                                            </strong>
                                            Diamètre 60cm
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-5 pt-0 flex items-center justify-between border-t border-[#0BA20B]/10 mt-2">
                                <span class="font-bold font-serif-title text-lg text-[#0BA20B]">
                                    55 €
                                </span>
                                <button
                                    class="px-3 py-1.5 rounded-none bg-[#2C221E] hover:bg-[#0BA20B] text-white text-xs font-bold transition-colors flex items-center gap-1.5">
                                    <svg aria-hidden="true" class="lucide lucide-shopping-bag w-3.5 h-3.5" fill="none"
                                        height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16 10a4 4 0 0 1-8 0">
                                        </path>
                                        <path d="M3.103 6.034h17.794">
                                        </path>
                                        <path
                                            d="M3.4 5.467a2 2 0 0 0-.4 1.2V20a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6.667a2 2 0 0 0-.4-1.2l-2-2.667A2 2 0 0 0 17 2H7a2 2 0 0 0-1.6.8z">
                                        </path>
                                    </svg>
                                    <span>
                                        Commander / Détails
                                    </span>
                                </button>
                            </div>
                        </div>
                        <div
                            class="bg-[#FAF7F2] rounded-none overflow-hidden border border-[#0BA20B]/30 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
                            <div>
                                <div class="relative h-48 overflow-hidden">
                                    <img alt='Sac Cabas Artisanal "Elegance Raphia"'
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                        referrerpolicy="no-referrer"
                                        src="https://images.unsplash.com/photo-1590874103328-eac38a683ce7?auto=format&amp;fit=crop&amp;q=80&amp;w=800" />
                                    <span
                                        class="absolute top-3 left-3 bg-[#1E1613]/80 text-[#0BA20B] text-[10px] font-bold px-2.5 py-0.5 rounded-none backdrop-blur-sm">
                                        Sacs &amp; Accessoires
                                    </span>
                                </div>
                                <div class="p-5 space-y-2">
                                    <h4 class="font-serif-title font-bold text-base text-[#2C221E] line-clamp-1">
                                        Sac Cabas Artisanal "Elegance Raphia"
                                    </h4>
                                    <p class="text-xs text-[#6B574F] line-clamp-2">
                                        Cabas robuste, léger et élégant, idéal pour l’été ou la ville. Résistant à l’eau et
                                        ultra-durable.
                                    </p>
                                    <div class="text-[11px] text-[#8C766B] space-y-1 pt-2 border-t border-[#0BA20B]/20">
                                        <p>
                                            <strong>
                                                Matière:
                                            </strong>
                                            Raphia sélectionné &amp; Poignées en Cuir Souple
                                        </p>
                                        <p>
                                            <strong>
                                                Taille:
                                            </strong>
                                            40cm x 32cm x 15cm
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-5 pt-0 flex items-center justify-between border-t border-[#0BA20B]/10 mt-2">
                                <span class="font-bold font-serif-title text-lg text-[#0BA20B]">
                                    48 €
                                </span>
                                <button
                                    class="px-3 py-1.5 rounded-none bg-[#2C221E] hover:bg-[#0BA20B] text-white text-xs font-bold transition-colors flex items-center gap-1.5">
                                    <svg aria-hidden="true" class="lucide lucide-shopping-bag w-3.5 h-3.5" fill="none"
                                        height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16 10a4 4 0 0 1-8 0">
                                        </path>
                                        <path d="M3.103 6.034h17.794">
                                        </path>
                                        <path
                                            d="M3.4 5.467a2 2 0 0 0-.4 1.2V20a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6.667a2 2 0 0 0-.4-1.2l-2-2.667A2 2 0 0 0 17 2H7a2 2 0 0 0-1.6.8z">
                                        </path>
                                    </svg>
                                    <span>
                                        Commander / Détails
                                    </span>
                                </button>
                            </div>
                        </div>
                        <div
                            class="bg-[#FAF7F2] rounded-none overflow-hidden border border-[#0BA20B]/30 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
                            <div>
                                <div class="relative h-48 overflow-hidden">
                                    <img alt="Ensemble de Tapis de Table &amp; Dessous de Verres"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                        referrerpolicy="no-referrer"
                                        src="https://images.unsplash.com/photo-1615873968403-89e068629265?auto=format&amp;fit=crop&amp;q=80&amp;w=800" />
                                    <span
                                        class="absolute top-3 left-3 bg-[#1E1613]/80 text-[#0BA20B] text-[10px] font-bold px-2.5 py-0.5 rounded-none backdrop-blur-sm">
                                        Décoration
                                    </span>
                                </div>
                                <div class="p-5 space-y-2">
                                    <h4 class="font-serif-title font-bold text-base text-[#2C221E] line-clamp-1">
                                        Ensemble de Tapis de Table &amp; Dessous de Verres
                                    </h4>
                                    <p class="text-xs text-[#6B574F] line-clamp-2">
                                        Set de 6 sets de table élégants qui apportent la richesse des matières naturelles à
                                        votre table.
                                    </p>
                                    <div class="text-[11px] text-[#8C766B] space-y-1 pt-2 border-t border-[#0BA20B]/20">
                                        <p>
                                            <strong>
                                                Matière:
                                            </strong>
                                            Fibres de Raphia Tressées Serrées
                                        </p>
                                        <p>
                                            <strong>
                                                Taille:
                                            </strong>
                                            Sets de 35cm
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-5 pt-0 flex items-center justify-between border-t border-[#0BA20B]/10 mt-2">
                                <span class="font-bold font-serif-title text-lg text-[#0BA20B]">
                                    35 €
                                </span>
                                <button
                                    class="px-3 py-1.5 rounded-none bg-[#2C221E] hover:bg-[#0BA20B] text-white text-xs font-bold transition-colors flex items-center gap-1.5">
                                    <svg aria-hidden="true" class="lucide lucide-shopping-bag w-3.5 h-3.5" fill="none"
                                        height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16 10a4 4 0 0 1-8 0">
                                        </path>
                                        <path d="M3.103 6.034h17.794">
                                        </path>
                                        <path
                                            d="M3.4 5.467a2 2 0 0 0-.4 1.2V20a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6.667a2 2 0 0 0-.4-1.2l-2-2.667A2 2 0 0 0 17 2H7a2 2 0 0 0-1.6.8z">
                                        </path>
                                    </svg>
                                    <span>
                                        Commander / Détails
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> --}}
        <section class="py-24 bg-[#FAF7F2] relative overflow-hidden" id="talents"
            x-data="{ activeGallery: null, currentImageIndex: 0, showTitle: '' }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
                <div class="text-center max-w-3xl mx-auto space-y-4">
                    <div
                        class="inline-flex items-center gap-2 px-3.5 py-1 rounded-none bg-[#F4EFE6] border border-[#0BA20B]/40 text-[#0BA20B] text-xs font-bold uppercase tracking-widest">
                        <svg aria-hidden="true" class="lucide lucide-radio w-3.5 h-3.5 animate-pulse" fill="none"
                            height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16.247 7.761a6 6 0 0 1 0 8.478">
                            </path>
                            <path d="M19.075 4.933a10 10 0 0 1 0 14.134">
                            </path>
                            <path d="M4.925 19.067a10 10 0 0 1 0-14.134">
                            </path>
                            <path d="M7.753 16.239a6 6 0 0 1 0-8.478">
                            </path>
                            <circle cx="12" cy="12" r="2">
                            </circle>
                        </svg>
                        <span>
                            Promotion &amp; Tremplin Artistique
                        </span>
                    </div>
                    <h2 class="font-serif-title text-3xl sm:text-4xl md:text-5xl font-bold text-[#2C221E] tracking-tight">
                        Accompagner la Jeunesse &amp; Révéler les Talents
                    </h2>
                    <p class="text-sm sm:text-base text-[#6B574F] font-sans leading-relaxed">
                        Notre association offre aux jeunes musiciens, chanteurs et artisans un studio d'enregistrement, un
                        accompagnement personnalisé et des scènes publiques pour propulser leurs créations.
                    </p>
                </div>
                <!-- @php $talentDuMois = $talents->first(); @endphp
                @if($talentDuMois)
                <div class="bg-[#1E1613] rounded-none overflow-hidden shadow-2xl border border-[#0BA20B]/40 grid grid-cols-1 lg:grid-cols-12 text-[#FAF7F2]">
                    <div class="lg:col-span-5 relative min-h-[350px]">
                        @if($talentDuMois->photo)
                            <img alt="{{ trim($talentDuMois->prenom . ' ' . $talentDuMois->nom) }}" class="absolute inset-0 w-full h-full object-cover" referrerpolicy="no-referrer" src="{{ asset('storage/' . $talentDuMois->photo) }}"/>
                        @else
                            <div class="absolute inset-0 w-full h-full bg-[#2C221E] flex items-center justify-center text-[#0BA20B] text-6xl font-bold">
                                {{ strtoupper(substr($talentDuMois->prenom, 0, 1)) }}{{ strtoupper(substr($talentDuMois->nom, 0, 1)) }}
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-[#1E1613] via-[#1E1613]/40 to-transparent">
                        </div>
                        <div
                            class="absolute bottom-6 left-6 right-6 glass-dark p-4 rounded-none border border-white/20 space-y-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <svg aria-hidden="true" class="lucide lucide-disc w-5 h-5 text-[#0BA20B]" fill="none"
                                        height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12" r="10">
                                        </circle>
                                        <circle cx="12" cy="12" r="2">
                                        </circle>
                                    </svg>
                                    <div>
                                        <span class="text-[10px] uppercase font-bold text-[#0BA20B]">
                                            Extrait Audio Enregistré
                                        </span>
                                        <h5 class="text-xs font-bold text-white line-clamp-1">
                                            Écho du Fleuve (Extrait Live Session)
                                        </h5>
                                    </div>
                                </div>
                                <button aria-label="Play sample"
                                    class="w-10 h-10 rounded-none bg-[#0BA20B] hover:bg-[#087A08] text-white flex items-center justify-center shadow-lg transition-transform hover:scale-105">
                                    <svg aria-hidden="true" class="lucide lucide-play w-5 h-5 ml-0.5" fill="none"
                                        height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M5 5a2 2 0 0 1 3.008-1.728l11.997 6.998a2 2 0 0 1 .003 3.458l-12 7A2 2 0 0 1 5 19z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            <div class="flex items-center gap-1 h-6 pt-1">
                                <div class="flex-1 rounded-none transition-all duration-300 bg-white/30"
                                    style="height: 30%;">
                                </div>
                                <div class="flex-1 rounded-none transition-all duration-300 bg-white/30"
                                    style="height: 30%;">
                                </div>
                                <div class="flex-1 rounded-none transition-all duration-300 bg-white/30"
                                    style="height: 30%;">
                                </div>
                                <div class="flex-1 rounded-none transition-all duration-300 bg-white/30"
                                    style="height: 30%;">
                                </div>
                                <div class="flex-1 rounded-none transition-all duration-300 bg-white/30"
                                    style="height: 30%;">
                                </div>
                                <div class="flex-1 rounded-none transition-all duration-300 bg-white/30"
                                    style="height: 30%;">
                                </div>
                                <div class="flex-1 rounded-none transition-all duration-300 bg-white/30"
                                    style="height: 30%;">
                                </div>
                                <div class="flex-1 rounded-none transition-all duration-300 bg-white/30"
                                    style="height: 30%;">
                                </div>
                                <div class="flex-1 rounded-none transition-all duration-300 bg-white/30"
                                    style="height: 30%;">
                                </div>
                                <div class="flex-1 rounded-none transition-all duration-300 bg-white/30"
                                    style="height: 30%;">
                                </div>
                                <div class="flex-1 rounded-none transition-all duration-300 bg-white/30"
                                    style="height: 30%;">
                                </div>
                                <div class="flex-1 rounded-none transition-all duration-300 bg-white/30"
                                    style="height: 30%;">
                                </div>
                                <div class="flex-1 rounded-none transition-all duration-300 bg-white/30"
                                    style="height: 30%;">
                                </div>
                                <div class="flex-1 rounded-none transition-all duration-300 bg-white/30"
                                    style="height: 30%;">
                                </div>
                                <div class="flex-1 rounded-none transition-all duration-300 bg-white/30"
                                    style="height: 30%;">
                                </div>
                                <div class="flex-1 rounded-none transition-all duration-300 bg-white/30"
                                    style="height: 30%;">
                                </div>
                                <div class="flex-1 rounded-none transition-all duration-300 bg-white/30"
                                    style="height: 30%;">
                                </div>
                                <div class="flex-1 rounded-none transition-all duration-300 bg-white/30"
                                    style="height: 30%;">
                                </div>
                                <div class="flex-1 rounded-none transition-all duration-300 bg-white/30"
                                    style="height: 30%;">
                                </div>
                                <div class="flex-1 rounded-none transition-all duration-300 bg-white/30"
                                    style="height: 30%;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="lg:col-span-7 p-8 sm:p-12 space-y-6 flex flex-col justify-between">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-none bg-[#0BA20B]/20 border border-[#0BA20B]/40 text-[#0BA20B] text-xs font-bold uppercase">
                                    <svg aria-hidden="true" class="lucide lucide-sparkles w-3.5 h-3.5" fill="none"
                                        height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z">
                                        </path>
                                        <path d="M20 2v4">
                                        </path>
                                        <path d="M22 4h-4">
                                        </path>
                                        <circle cx="4" cy="20" r="2">
                                        </circle>
                                    </svg>
                                    <span>
                                        Talent du Mois
                                    </span>
                                </span>
                                <span class="text-xs text-white/60 font-sans">
                                    {{ $talentDuMois->categorie ? $talentDuMois->categorie->libelle : 'Artiste' }}
                                </span>
                            </div>
                            <div>
                                <h3 class="font-serif-title text-3xl sm:text-4xl font-bold text-white">
                                    {{ $talentDuMois->prenom }} {{ $talentDuMois->nom }}
                                </h3>
                                <p class="text-xs sm:text-sm text-[#D1C5B8] mt-2 font-sans leading-relaxed">
                                    {{ $talentDuMois->biographie ?? 'Une nouvelle voix passionnante accompagnée par notre association.' }}
                                </p>
                            </div>
                            <div class="space-y-2 pt-2">
                                <h4 class="text-xs font-bold uppercase text-[#0BA20B] tracking-wider">
                                    Réalisations &amp; Parcours :
                                </h4>
                                <ul class="space-y-1.5 text-xs text-white/90 font-sans">
                                    <li class="flex items-center gap-2">
                                        <svg aria-hidden="true"
                                            class="lucide lucide-award w-3.5 h-3.5 text-[#0BA20B] shrink-0" fill="none"
                                            height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" viewbox="0 0 24 24" width="24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="m15.477 12.89 1.515 8.526a.5.5 0 0 1-.81.47l-3.58-2.687a1 1 0 0 0-1.197 0l-3.586 2.686a.5.5 0 0 1-.81-.469l1.514-8.526">
                                            </path>
                                            <circle cx="12" cy="8" r="6">
                                            </circle>
                                        </svg>
                                        <span>
                                            Lauréat du Prix Révélation Culturelle 2025
                                        </span>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <svg aria-hidden="true"
                                            class="lucide lucide-award w-3.5 h-3.5 text-[#0BA20B] shrink-0" fill="none"
                                            height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" viewbox="0 0 24 24" width="24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="m15.477 12.89 1.515 8.526a.5.5 0 0 1-.81.47l-3.58-2.687a1 1 0 0 0-1.197 0l-3.586 2.686a.5.5 0 0 1-.81-.469l1.514-8.526">
                                            </path>
                                            <circle cx="12" cy="8" r="6">
                                            </circle>
                                        </svg>
                                        <span>
                                            Plus de 45 000 écoutes sur les plateformes
                                        </span>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <svg aria-hidden="true"
                                            class="lucide lucide-award w-3.5 h-3.5 text-[#0BA20B] shrink-0" fill="none"
                                            height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" viewbox="0 0 24 24" width="24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="m15.477 12.89 1.515 8.526a.5.5 0 0 1-.81.47l-3.58-2.687a1 1 0 0 0-1.197 0l-3.586 2.686a.5.5 0 0 1-.81-.469l1.514-8.526">
                                            </path>
                                            <circle cx="12" cy="8" r="6">
                                            </circle>
                                        </svg>
                                        <span>
                                            Membre actif des ateliers de transmission pour enfants
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="pt-6 border-t border-white/10 flex flex-wrap items-center justify-between gap-4">
                            <div class="text-xs text-white/70">
                                Suivre :
                                <span class="text-[#0BA20B] font-semibold">
                                    {{ '@' . strtolower($talentDuMois->prenom) }}_{{ strtolower($talentDuMois->nom) }}
                                </span>
                            </div>
                            <button onclick="document.getElementById('candidature-modal').classList.remove('hidden')"
                                class="px-5 py-2.5 rounded-none bg-[#0BA20B] hover:bg-[#087A08] text-white font-bold text-xs shadow-lg transition-transform hover:scale-105 flex items-center gap-2">
                                <svg aria-hidden="true" class="lucide lucide-user-plus w-4 h-4" fill="none" height="24"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2">
                                    </path>
                                    <circle cx="9" cy="7" r="4">
                                    </circle>
                                    <line x1="19" x2="19" y1="8" y2="14">
                                    </line>
                                    <line x1="22" x2="16" y1="11" y2="11">
                                    </line>
                                </svg>
                                <span>
                                    Rejoindre le Programme Jeunes Talents
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                @endif -->
                <div class="space-y-6 pt-6">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 border-b border-[#0BA20B]/30 pb-4">
                        <h3 class="font-serif-title text-2xl font-bold text-[#2C221E]">
                            Galerie des Artistes Émergents
                        </h3>
                        <a href="{{ route('talents') }}" class="text-xs text-[#0BA20B] font-bold uppercase tracking-widest hover:underline">
                            Voir tous les talents &rarr;
                        </a>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        @forelse($talents as $talent)
                        <a href="{{ route('talents.show', $talent->id) }}" class="block bg-white rounded-none p-5 border transition-all duration-300 space-y-4 hover:shadow-xl {{ $loop->first ? 'border-[#0BA20B] ring-2 ring-[#0BA20B]/20 shadow-md' : 'border-[#0BA20B]/30 hover:border-[#0BA20B]' }}">
                            <div class="flex items-center gap-4">
                                @if($talent->photo)
                                    <img alt="{{ trim($talent->prenom . ' ' . $talent->nom) }}" class="w-16 h-16 rounded-none object-cover ring-2 ring-[#0BA20B]/40" referrerpolicy="no-referrer" src="{{ asset('storage/' . $talent->photo) }}"/>
                                @else
                                    <div class="w-16 h-16 rounded-none bg-[#F4EFE6] flex items-center justify-center text-[#0BA20B] font-bold text-lg ring-2 ring-[#0BA20B]/40">
                                        {{ strtoupper(substr($talent->prenom, 0, 1)) }}{{ strtoupper(substr($talent->nom, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <h4 class="font-bold text-base text-[#2C221E]">
                                        {{ $talent->prenom }} {{ $talent->nom }}
                                    </h4>
                                    <p class="text-xs text-[#0BA20B] font-semibold">
                                        {{ $talent->categorie ? $talent->categorie->libelle : 'Talent émergent' }}
                                    </p>
                                    <span class="text-[10px] text-[#8C766B]">
                                        Jeune artiste
                                    </span>
                                </div>
                            </div>
                            <p class="text-xs text-[#6B574F] line-clamp-2">
                                {{ \Illuminate\Support\Str::limit($talent->biographie ?? 'Talent en pleine évolution, porté par l’association pour révéler son potentiel artistique.', 140) }}
                            </p>
                            <div class="pt-2 border-t border-[#0BA20B]/20 flex items-center justify-between text-xs text-[#0BA20B] font-bold">
                                <span class="flex items-center gap-1">
                                    <svg aria-hidden="true" class="lucide lucide-music w-3.5 h-3.5" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9 18V5l12-2v13"></path>
                                        <circle cx="6" cy="18" r="3"></circle>
                                        <circle cx="18" cy="16" r="3"></circle>
                                    </svg>
                                    Découvrir le profil
                                </span>
                                <span>&rarr;</span>
                            </div>
                        </a>
                        @empty
                            <div class="sm:col-span-3 rounded-none border border-dashed border-[#0BA20B]/40 bg-[#FAF7F2] p-8 text-center text-sm text-[#6B574F]">
                                Aucun talent n’est encore publié.
                            </div>
                        @endforelse
    </div>
                </div>
                <div
                    class="p-8 rounded-none bg-gradient-to-r from-[#F4EFE6] to-[#FAF7F2] border border-[#0BA20B]/40 flex flex-col sm:flex-row items-center justify-between gap-6">
                    <div class="space-y-2 text-center sm:text-left">
                        <h4 class="font-serif-title text-xl font-bold text-[#2C221E]">
                            Vous êtes un jeune artiste ou créateur de 15 à 25 ans ?
                        </h4>
                        <p class="text-xs sm:text-sm text-[#6B574F]">
                            Bénéficiez gratuitement d'un studio de répétition, de conseils artistiques et de scènes de
                            concert.
                        </p>
                    </div>
                    <button onclick="document.getElementById('candidature-modal').classList.remove('hidden')"
                        class="px-6 py-3 rounded-none bg-[#2C221E] hover:bg-[#0BA20B] text-white font-bold text-xs whitespace-nowrap transition-colors flex items-center gap-2 shadow">
                        <svg aria-hidden="true" class="lucide lucide-send w-4 h-4" fill="none" height="24"
                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z">
                            </path>
                            <path d="m21.854 2.147-10.94 10.939">
                            </path>
                        </svg>
                        <span>
                            Déposer ma Candidature
                        </span>
                    </button>
                </div>
            </div>
        </section>
        <section class="py-24 bg-[#F4EFE6] relative overflow-hidden" id="events"
            x-data="{ activeGallery: null, currentImageIndex: 0, showTitle: '', activeCategory: 'Tous' }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
                <div class="text-center max-w-3xl mx-auto space-y-4">
                    <div
                        class="inline-flex items-center gap-2 px-3.5 py-1 rounded-none bg-[#FAF7F2] border border-[#0BA20B]/40 text-[#0BA20B] text-xs font-bold uppercase tracking-widest shadow-sm">
                        <svg aria-hidden="true" class="lucide lucide-calendar w-3.5 h-3.5" fill="none" height="24"
                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 2v4">
                            </path>
                            <path d="M16 2v4">
                            </path>
                            <rect height="18" rx="2" width="18" x="3" y="4">
                            </rect>
                            <path d="M3 10h18">
                            </path>
                        </svg>
                        <span>
                            Agenda &amp; Rencontres Culturelles
                        </span>
                    </div>
                    <h2 class="font-serif-title text-3xl sm:text-4xl md:text-5xl font-bold text-[#2C221E] tracking-tight">
                        Événements, Festivités &amp; Ateliers
                    </h2>
                    <p class="text-sm sm:text-base text-[#6B574F] font-sans leading-relaxed">
                        Consultez le calendrier de nos représentations musicales, galas du raphia, expositions d'artisanat
                        et scènes ouvertes.
                    </p>
                </div>

                <div class="space-y-6">
                    <div
                        class="flex flex-col sm:flex-row items-center justify-between gap-4 border-b border-[#0BA20B]/30 pb-4">
                        <h3 class="font-serif-title text-2xl font-bold text-[#2C221E]">
                            Prochains Événements à venir
                        </h3>
                        <a href="{{ route('evenements') }}" class="text-xs text-[#0BA20B] font-bold uppercase tracking-widest hover:underline">
                            Voir tous les événements &rarr;
                        </a>
                    </div>
                    <div class="flex flex-wrap gap-2">
                            <button @click="activeCategory = 'Tous'"
                                :class="activeCategory === 'Tous' ? 'bg-[#0BA20B] text-white' : 'bg-[#FAF7F2] text-[#2C221E] hover:bg-white border border-[#0BA20B]/30'"
                                class="px-3.5 py-1.5 rounded-none text-xs font-semibold transition-all shadow-sm">
                                Tous
                            </button>
                            @foreach ($categoriesEvenements as $categorie)
                                <button @click="activeCategory = '{{ $categorie->libelle }}'"
                                    :class="activeCategory === '{{ $categorie->libelle }}' ? 'bg-[#0BA20B] text-white' : 'bg-[#FAF7F2] text-[#2C221E] hover:bg-white border border-[#0BA20B]/30'"
                                    class="px-3.5 py-1.5 rounded-none text-xs font-semibold transition-all shadow-sm">
                                    {{ $categorie->libelle }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @forelse ($evenements as $evenement)
                            @php
                                $mainImg = $evenement->images->where('is_principal', true)->first() ?? $evenement->images->first();
                                $imgPath = $mainImg ? asset('storage/' . $mainImg->image_path) : '/assets/hero_cultural_bg_1785764970571-BS2uarbi.jpg';

                                $galleryData = $evenement->images->map(function ($img) {
                                    return [
                                        'url' => asset('storage/' . $img->image_path),
                                        'is_principal' => (bool) $img->is_principal
                                    ];
                                })->values()->all();
                                if (empty($galleryData)) {
                                    $galleryData = [
                                        ['url' => $imgPath, 'is_principal' => true]
                                    ];
                                }
                            @endphp
                            <div x-show="activeCategory === 'Tous' || activeCategory === '{{ $evenement->categorie ? $evenement->categorie->libelle : 'Événement' }}'"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 transform scale-95"
                                x-transition:enter-end="opacity-100 transform scale-100"
                                class="bg-[#FAF7F2] rounded-none overflow-hidden border border-[#0BA20B]/30 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
                                <div>
                                    <div class="relative h-44 overflow-hidden bg-slate-900 cursor-pointer"
                                        data-gallery="{{ json_encode($galleryData) }}" data-title="{{ $evenement->titre }}"
                                        @click="
                                                                    activeGallery = JSON.parse($el.dataset.gallery);
                                                                    currentImageIndex = 0;
                                                                    showTitle = $el.dataset.title;
                                                                ">
                                        <img alt="{{ $evenement->titre }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                            referrerpolicy="no-referrer" src="{{ $imgPath }}" />
                                        <span
                                            class="absolute top-3 left-3 bg-[#1E1613]/80 text-[#0BA20B] text-[10px] font-bold px-2.5 py-0.5 rounded-none backdrop-blur-sm uppercase">
                                            {{ $evenement->categorie ? $evenement->categorie->libelle : 'Événement' }}
                                        </span>
                                    </div>
                                    <div class="p-5 space-y-3">
                                        <div class="flex items-center gap-2 text-xs text-[#0BA20B] font-semibold">
                                            <svg aria-hidden="true" class="lucide lucide-calendar w-3.5 h-3.5" fill="none"
                                                height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" viewbox="0 0 24 24" width="24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path d="M8 2v4">
                                                </path>
                                                <path d="M16 2v4">
                                                </path>
                                                <rect height="18" rx="2" width="18" x="3" y="4">
                                                </rect>
                                                <path d="M3 10h18">
                                                </path>
                                            </svg>
                                            <span>
                                                {{ \Carbon\Carbon::parse($evenement->date_debut)->translatedFormat('d F Y') }}
                                            </span>
                                        </div>
                                        <h4 class="font-serif-title font-bold text-lg text-[#2C221E] line-clamp-2">
                                            {{ $evenement->titre }}
                                        </h4>
                                        <p class="text-xs text-[#6B574F] line-clamp-2">
                                            {{ strip_tags($evenement->description) }}
                                        </p>
                                        <div class="space-y-1 text-xs text-[#8C766B] pt-2 border-t border-[#0BA20B]/20">
                                            <p class="flex items-center gap-1.5">
                                                <svg aria-hidden="true" class="lucide lucide-map-pin w-3.5 h-3.5 text-[#0BA20B]"
                                                    fill="none" height="24" stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                                    </path>
                                                    <circle cx="12" cy="10" r="3">
                                                    </circle>
                                                </svg>
                                                <span class="line-clamp-1">
                                                    {{ $evenement->lieu }}
                                                </span>
                                            </p>
                                            <p class="flex items-center gap-1.5">
                                                <svg aria-hidden="true" class="lucide lucide-clock w-3.5 h-3.5 text-[#0BA20B]"
                                                    fill="none" height="24" stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M12 6v6l4 2">
                                                    </path>
                                                    <circle cx="12" cy="12" r="10">
                                                    </circle>
                                                </svg>
                                                <span>
                                                    {{ \Carbon\Carbon::parse($evenement->heure)->format('H\hi') }}
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-5 pt-0 flex items-center justify-between border-t border-[#0BA20B]/10 mt-2">
                                    <span class="font-bold text-xs text-[#2C221E]">
                                        Plus de détails
                                    </span>
                                    <a href="{{ route('evenements.show', $evenement->id) }}"
                                        class="px-3.5 py-1.5 rounded-none bg-[#0BA20B] hover:bg-[#087A08] text-white text-xs font-bold transition-colors flex items-center gap-1">
                                        <span>
                                            Consulter
                                        </span>
                                        <svg aria-hidden="true" class="lucide lucide-chevron-right w-3.5 h-3.5" fill="none"
                                            height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                            <path d="m9 18 6-6-6-6">
                                            </path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-3 text-center py-12 text-[#8C766B]">
                                <p class="text-sm">Aucun événement prévu pour le moment.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Lightbox Modal -->
                    <div x-show="activeGallery"
                        class="fixed inset-0 z-[100] bg-slate-950/90 backdrop-blur-md flex items-center justify-center p-4 sm:p-6"
                        x-cloak @keydown.escape.window="activeGallery = null">

                        <div class="relative w-full max-w-4xl bg-[#1E1613] border border-[#0BA20B]/30 shadow-2xl flex flex-col max-h-[90vh] overflow-hidden rounded-none"
                            @click.away="activeGallery = null">

                            <div
                                class="px-6 py-4 border-b border-[#0BA20B]/20 flex items-center justify-between bg-[#1E1613]">
                                <div>
                                    <h3 class="text-sm font-serif-title font-bold text-[#FAF7F2] uppercase tracking-wider"
                                        x-text="showTitle"></h3>
                                    <p class="text-[10px] text-[#0BA20B] uppercase tracking-widest mt-0.5">
                                        Image <span x-text="currentImageIndex + 1"></span> sur <span
                                            x-text="activeGallery ? activeGallery.length : 0"></span>
                                        <template
                                            x-if="activeGallery && activeGallery[currentImageIndex] && activeGallery[currentImageIndex].is_principal">
                                            <span class="ml-2 text-[#0BA20B] font-bold">• Image Principale</span>
                                        </template>
                                    </p>
                                </div>
                                <button @click="activeGallery = null"
                                    class="text-[#0BA20B] hover:text-[#0BA20B] p-1 transition-colors"
                                    title="Fermer (Echap)">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <div
                                class="relative flex-1 bg-black flex items-center justify-center min-h-[350px] p-4 overflow-hidden">
                                <template x-if="activeGallery && activeGallery[currentImageIndex]">
                                    <img :src="activeGallery[currentImageIndex].url"
                                        class="max-h-[60vh] max-w-full object-contain shadow-2xl transition-all duration-300">
                                </template>
                                <template x-if="activeGallery && activeGallery.length > 1">
                                    <div>
                                        <button
                                            @click="currentImageIndex = (currentImageIndex === 0) ? activeGallery.length - 1 : currentImageIndex - 1"
                                            class="absolute left-4 top-1/2 -translate-y-1/2 bg-[#1E1613]/80 hover:bg-[#0BA20B] text-[#FAF7F2] p-3 transition-colors border border-[#0BA20B]/30 shadow-xl rounded-none">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M15 19l-7-7 7-7" />
                                            </svg>
                                        </button>
                                        <button
                                            @click="currentImageIndex = (currentImageIndex === activeGallery.length - 1) ? 0 : currentImageIndex + 1"
                                            class="absolute right-4 top-1/2 -translate-y-1/2 bg-[#1E1613]/80 hover:bg-[#0BA20B] text-[#FAF7F2] p-3 transition-colors border border-[#0BA20B]/30 shadow-xl rounded-none">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>
                                    </div>
                                </template>
                            </div>

                            <template x-if="activeGallery && activeGallery.length > 1">
                                <div
                                    class="px-6 py-4 bg-[#1E1613] border-t border-[#0BA20B]/20 flex items-center justify-center gap-3 overflow-x-auto">
                                    <template x-for="(img, idx) in activeGallery" :key="idx">
                                        <button @click="currentImageIndex = idx"
                                            class="w-14 h-14 border-2 overflow-hidden transition-all shrink-0 rounded-none"
                                            :class="currentImageIndex === idx ? 'border-[#0BA20B] scale-105 opacity-100' : 'border-[#0BA20B]/30 opacity-50 hover:opacity-100'">
                                            <img :src="img.url" class="w-full h-full object-cover">
                                        </button>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
        </section>
        <section class="py-24 bg-[#FAF7F2] relative overflow-hidden" id="courses" x-data="{
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

                        activeSlotDay: '',

                        openBookingModal(id, titre, prof, mode = '', tarif = '') {
                            this.coursId = id;
                            this.coursTitre = titre;
                            this.profName = prof;
                            this.coursMode = mode;
                            this.coursTarif = tarif;
                            this.showModal = true;
                            this.loading = false;
                            // this.disponibilites = [];
                            this.errorMessage = '';
                            this.dateReservation = '';
                            this.heureDebut = '';
                            this.heureFin = '';
                            this.activeSlotDay = '';

                            // Commenté : fetch des disponibilités du professeur
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

                        // Commenté : méthodes liées aux disponibilités du professeur
                        /*
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
                        */
                    }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
                {{-- Flash Notifications --}}
                @if (session('success'))
                    <div
                        class="p-4 bg-emerald-100 border-l-4 border-emerald-500 text-emerald-800 text-sm font-semibold flex items-center justify-between shadow-sm">
                        <span>{{ session('success') }}</span>
                        <button onclick="this.parentElement.remove()"
                            class="text-emerald-800 text-lg leading-none">&times;</button>
                    </div>
                @endif

                @if (session('error'))
                    <div
                        class="p-4 bg-red-100 border-l-4 border-red-500 text-red-800 text-sm font-semibold flex items-center justify-between shadow-sm">
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
                    <div
                        class="inline-flex items-center gap-2 px-3.5 py-1 rounded-none bg-[#F4EFE6] border border-[#0BA20B]/40 text-[#0BA20B] text-xs font-bold uppercase tracking-widest">
                        <svg aria-hidden="true" class="lucide lucide-graduation-cap w-3.5 h-3.5" fill="none" height="24"
                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z">
                            </path>
                            <path d="M22 10v6"></path>
                            <path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"></path>
                        </svg>
                        <span>Formations, Ateliers &amp; Transmission des Savoirs</span>
                    </div>
                    <h2 class="font-serif-title text-3xl sm:text-4xl md:text-5xl font-bold text-[#2C221E] tracking-tight">
                        Catalogue des Cours &amp; Ateliers de Pratique
                    </h2>
                    <p class="text-sm sm:text-base text-[#6B574F] font-sans leading-relaxed">
                        Formez-vous aux instruments traditionnels et modernes, à la polyphonie vocale ou au tressage
                        éco-artisanat du Raphia. Cours dispensés en présentiel ou à distance.
                    </p>
                </div>

                {{-- Filters --}}
                <div
                    class="bg-[#F4EFE6] p-4 rounded-none border border-[#0BA20B]/30 flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-2 overflow-x-auto w-full md:w-auto pb-2 md:pb-0">
                        <span class="text-xs font-bold text-[#2C221E] uppercase flex items-center gap-1 shrink-0">
                            <svg aria-hidden="true" class="lucide lucide-funnel w-3.5 h-3.5 text-[#0BA20B]" fill="none"
                                height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10 20a1 1 0 0 0 .553.895l2 1A1 1 0 0 0 14 21v-7a2 2 0 0 1 .517-1.341L21.74 4.67A1 1 0 0 0 21 3H3a1 1 0 0 0-.742 1.67l7.225 7.989A2 2 0 0 1 10 14z">
                                </path>
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
                    <a href="{{ route('cours') }}" class="text-xs text-[#0BA20B] font-bold uppercase tracking-widest hover:underline shrink-0">
                        Voir tous les cours &rarr;
                    </a>
                    {{-- <div class="flex items-center gap-2 shrink-0 overflow-x-auto">
                        <span class="text-xs font-bold text-[#2C221E] uppercase">Modes :</span>
                        <button @click="activeMode = 'Tous'"
                            :class="activeMode === 'Tous' ? 'bg-[#2C221E] text-white' : 'bg-[#FAF7F2] text-[#2C221E] hover:bg-white border border-[#0BA20B]/30'"
                            class="px-3 py-1.5 rounded-none text-xs font-semibold transition-all shadow-sm">
                            Tous
                        </button>
                        @foreach($modes ?? [] as $m)
                            <button @click="activeMode = '{{ addslashes($m->libelle) }}'"
                                :class="activeMode === '{{ addslashes($m->libelle) }}' ? 'bg-[#2C221E] text-white' : 'bg-[#FAF7F2] text-[#2C221E] hover:bg-white border border-[#0BA20B]/30'"
                                class="px-3 py-1.5 rounded-none text-xs font-semibold transition-all shadow-sm">
                                {{ $m->libelle }}
                            </button>
                        @endforeach
                    </div> --}}
                </div>

                {{-- Course Cards Grid --}}
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
                                            class="text-[10px] font-bold px-2.5 py-1 rounded-none text-white backdrop-blur-sm {{ Str::contains(strtolower($modeName), ['distanciel', 'ligne', 'visio']) ? 'bg-emerald-600' : 'bg-[#0BA20B]' }}">
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
                                    <span>Réserver</span>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div
                            class="col-span-3 text-center py-12 text-[#8C766B] bg-[#FAF7F2] border border-dashed border-[#0BA20B]/40">
                            <p class="text-sm font-semibold">Aucun cours n'est actuellement disponible dans le catalogue.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- MODAL DE RÉSERVATION DE COURS SELON LES DISPONIBILITÉS DU PROFESSEUR --}}
            <div x-show="showModal"
                class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-[#1E1613]/70 backdrop-blur-sm" x-cloak
                style="display:none;">
                <div @click.away="showModal = false"
                    class="bg-[#FAF7F2] w-full max-w-lg shadow-2xl border border-[#0BA20B]/40 p-6 sm:p-8 relative">

                    <div class="flex justify-between items-start border-b border-[#0BA20B]/20 pb-4 mb-5">
                        <div>
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="text-[10px] font-bold uppercase tracking-widest text-[#0BA20B]">Réservation de cours</span>
                                <span x-show="coursMode"
                                    class="text-[9px] font-bold uppercase px-2 py-0.5 bg-[#1E1613] text-[#0BA20B]"
                                    x-text="coursMode"></span>
                                <span x-show="coursTarif"
                                    class="text-[9px] font-bold uppercase px-2 py-0.5 bg-[#0BA20B] text-white"
                                    x-text="coursTarif + ' € / séance'"></span>
                            </div>
                            <h3 class="font-serif-title font-bold text-xl text-[#2C221E] mt-0.5" x-text="coursTitre"></h3>
                            <p class="text-xs text-[#6B574F] mt-1" x-text="'Professeur : ' + profName"></p>
                        </div>
                        <button @click="showModal = false"
                            class="text-[#2C221E] hover:text-[#0BA20B] text-2xl font-bold leading-none cursor-pointer">&times;</button>
                    </div>

                    {{-- Loader --}}
                    <div x-show="loading" class="py-8 text-center text-xs text-[#6B574F]">
                        <svg class="animate-spin h-6 w-6 text-[#0BA20B] mx-auto mb-2" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        Chargement...
                    </div>

                    <div x-show="!loading">
                        {{-- Section Disponibilités du professeur - COMMENTÉE --}}
                        {{--
                        <div class="mb-4 bg-[#F4EFE6] border border-[#0BA20B]/30 p-3">
                            <div class="flex items-center justify-between mb-2">
                                <h4
                                    class="text-[10px] font-bold uppercase tracking-widest text-[#2C221E] flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-[#0BA20B]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
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
                                <p class="text-xs text-[#8C766B] italic">Aucune disponibilité enregistrée pour le moment.
                                </p>
                            </template>

                            {{-- Zone défilante exclusive aux disponibilités --}}
                            {{-- <div x-show="disponibilites.length > 0" class="space-y-2 max-h-40 overflow-y-auto pr-1">
                                <template x-for="(slots, jour) in getGroupedDisponibilites()" :key="jour">
                                    <div class="bg-white border border-[#0BA20B]/30 p-2 shadow-sm">
                                        <div
                                            class="text-[10px] font-bold text-[#0BA20B] uppercase mb-1.5 flex items-center justify-between border-b border-[#0BA20B]/20 pb-1">
                                            <div class="flex items-center gap-1.5">
                                                <span class="w-2 h-2 bg-[#5EF527] rounded-full inline-block"></span>
                                                <span
                                                    x-text="jour + (getSlotNextDateFormatted(jour) ? ' (' + getSlotNextDateFormatted(jour) + ')' : '')"></span>
                                            </div>
                                            <span class="text-[9px] text-[#8C766B] font-semibold"
                                                x-text="slots.length + ' créneau(x)'"></span>
                                        </div>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-1.5">
                                            <template x-for="slot in slots" :key="slot.id">
                                                <button type="button" @click="selectSlot(slot)"
                                                    :class="dateReservation === getNextDateForDay(slot.jour) && heureDebut === slot.debut.substring(0,5) ? 'bg-[#0BA20B] text-white border-[#0BA20B]' : 'bg-[#FAF7F2] hover:bg-[#F4EFE6] text-[#2C221E] border-[#0BA20B]/30'"
                                                    class="w-full flex items-center justify-between border px-2.5 py-1 text-[11px] font-bold transition cursor-pointer">
                                                    <span
                                                        x-text="slot.debut.substring(0,5) + ' - ' + slot.fin.substring(0,5)"></span>
                                                    <span class="text-[9px] font-bold uppercase"
                                                        :class="dateReservation === getNextDateForDay(slot.jour) && heureDebut === slot.debut.substring(0,5) ? 'text-white' : 'text-[#0BA20B]'">✓
                                                        Choisir</span>
                                                </button>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div> --}}


                        {{-- Formulaire de réservation --}}
                        <form action="{{ route('reservations.store') }}" method="POST"
                            class="space-y-4">
                            @csrf
                            <input type="hidden" name="cours_id" :value="coursId" />

                            <div>
                                <label class="block text-[10px] font-bold uppercase tracking-widest text-[#2C221E] mb-1">
                                    Date souhaitée <span class="text-[#0BA20B]">*</span>
                                </label>
                                <input type="date" name="date_reservation" required min="{{ date('Y-m-d') }}"
                                    x-model="dateReservation"
                                    class="w-full px-3 py-2 bg-white border border-[#0BA20B]/50 text-xs text-[#2C221E] focus:outline-none focus:border-[#0BA20B]" />
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label
                                        class="block text-[10px] font-bold uppercase tracking-widest text-[#2C221E] mb-1">
                                        Heure de début <span class="text-[#0BA20B]">*</span>
                                    </label>
                                    <input type="time" name="heure_debut" required x-model="heureDebut"
                                        class="w-full px-3 py-2 bg-white border border-[#0BA20B]/50 text-xs text-[#2C221E] focus:outline-none focus:border-[#0BA20B]" />
                                </div>
                                <div>
                                    <label
                                        class="block text-[10px] font-bold uppercase tracking-widest text-[#2C221E] mb-1">
                                        Heure de fin <span class="text-[#0BA20B]">*</span>
                                    </label>
                                    <input type="time" name="heure_fin" required x-model="heureFin"
                                        class="w-full px-3 py-2 bg-white border border-[#0BA20B]/50 text-xs text-[#2C221E] focus:outline-none focus:border-[#0BA20B]" />
                                </div>
                            </div>

                            <div x-show="errorMessage"
                                class="p-3 bg-red-50 border border-red-200 text-red-700 text-xs font-semibold">
                                <span x-text="errorMessage"></span>
                            </div>

                            <div class="flex justify-end gap-3 pt-3 border-t border-[#0BA20B]/20">
                                <button type="button" @click="showModal = false"
                                    class="px-4 py-2 text-xs font-bold uppercase tracking-wider text-[#6B574F] hover:text-[#2C221E] cursor-pointer">
                                    Annuler
                                </button>
                                <button type="submit"
                                    class="px-5 py-2.5 bg-[#0BA20B] hover:bg-[#087A08] text-white font-bold text-xs uppercase tracking-widest transition shadow-md cursor-pointer">
                                    Confirmer la réservation
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </section>
        <section class="py-24 bg-[#F4EFE6] relative overflow-hidden" id="gallery"
            x-data="{ activeGallery: null, currentImageIndex: 0, showTitle: '', activeCategory: 'all' }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
                <div class="text-center max-w-3xl mx-auto space-y-4">
                    <div
                        class="inline-flex items-center gap-2 px-3.5 py-1 rounded-none bg-[#FAF7F2] border border-[#0BA20B]/40 text-[#0BA20B] text-xs font-bold uppercase tracking-widest shadow-sm">
                        <svg aria-hidden="true" class="lucide lucide-image w-3.5 h-3.5" fill="none" height="24"
                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                            <rect height="18" rx="2" ry="2" width="18" x="3" y="3">
                            </rect>
                            <circle cx="9" cy="9" r="2">
                            </circle>
                            <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21">
                            </path>
                        </svg>
                        <span>
                            Médiathèque &amp; Mémoire Visuelle
                        </span>
                    </div>
                    <h2 class="font-serif-title text-3xl sm:text-4xl md:text-5xl font-bold text-[#2C221E] tracking-tight">
                        Galerie de la Vie Associative &amp; Créations
                    </h2>
                    <p class="text-sm sm:text-base text-[#6B574F] font-sans leading-relaxed">
                        Revivez les temps forts de nos concerts, ateliers de tressage du raphia, résidences artistiques et
                        expositions.
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex justify-center gap-2 flex-wrap">
                        <button
                            @click="activeCategory = 'all'"
                            :class="activeCategory === 'all' ? 'bg-[#0BA20B] text-white shadow-md' : 'bg-[#FAF7F2] text-[#2C221E] hover:bg-white border border-[#0BA20B]/30'"
                            class="px-4 py-2 rounded-none text-xs font-semibold transition-all">
                            Tous
                        </button>
                        @foreach($categoriesGaleries as $cat)
                            <button
                                @click="activeCategory = '{{ $cat->slug }}'"
                                :class="activeCategory === '{{ $cat->slug }}' ? 'bg-[#0BA20B] text-white shadow-md' : 'bg-[#FAF7F2] text-[#2C221E] hover:bg-white border border-[#0BA20B]/30'"
                                class="px-4 py-2 rounded-none text-xs font-semibold transition-all">
                                {{ $cat->libelle }}
                            </button>
                        @endforeach
                    </div>
                    <a href="{{ route('galerie') }}" class="text-xs text-[#0BA20B] font-bold uppercase tracking-widest hover:underline shrink-0">
                        Voir toute la galerie &rarr;
                    </a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($galeries as $galerie)
                        @php
                            $isVideo = $galerie->fichier && in_array(strtolower(pathinfo($galerie->fichier, PATHINFO_EXTENSION)), ['mp4', 'webm', 'mov', 'avi', 'mkv']);
                            $fichierUrl = $galerie->fichier ? asset('storage/' . $galerie->fichier) : null;
                        @endphp
                        <div
                            x-show="activeCategory === 'all' || activeCategory === '{{ $galerie->categorie->slug ?? '' }}'"
                            class="group relative rounded-none overflow-hidden cursor-pointer shadow-sm hover:shadow-2xl transition-all duration-300 h-64 bg-[#1E1613]"
                            data-gallery='[{"url":"{{ $fichierUrl }}","type":"{{ $isVideo ? 'video' : 'image' }}"}]' data-title="{{ $galerie->titre }}"
                            @click="activeGallery = JSON.parse($el.dataset.gallery); currentImageIndex = 0; showTitle = $el.dataset.title">
                            @if($fichierUrl)
                                @if($isVideo)
                                    <video src="{{ $fichierUrl }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 opacity-90 group-hover:opacity-100" muted loop playsinline poster=""></video>
                                    <div class="absolute inset-0 flex items-center justify-center z-10">
                                        <div class="w-12 h-12 rounded-none bg-[#0BA20B] text-white flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                            <svg class="w-6 h-6 ml-1 fill-current" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M5 5a2 2 0 0 1 3.008-1.728l11.997 6.998a2 2 0 0 1 .003 3.458l-12 7A2 2 0 0 1 5 19z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                @else
                                    <img alt="{{ $galerie->titre }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 opacity-90 group-hover:opacity-100"
                                        src="{{ $fichierUrl }}" />
                                @endif
                            @else
                                @if($isVideo)
                                    <div class="absolute inset-0 flex items-center justify-center z-10">
                                        <div class="w-12 h-12 rounded-none bg-[#0BA20B] text-white flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                            <svg class="w-6 h-6 ml-1 fill-current" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M5 5a2 2 0 0 1 3.008-1.728l11.997 6.998a2 2 0 0 1 .003 3.458l-12 7A2 2 0 0 1 5 19z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-[#2C221E]">
                                        <svg class="w-12 h-12 text-[#0BA20B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-[#1E1613]/90 via-[#1E1613]/20 to-transparent opacity-80 group-hover:opacity-95 transition-opacity">
                            </div>
                            @if($galerie->categorie)
                                <div class="absolute top-4 left-4">
                                    <span class="bg-[#1E1613]/80 text-[#0BA20B] text-[10px] font-bold px-2.5 py-1 rounded-none backdrop-blur-sm border border-white/10 uppercase">
                                        {{ $galerie->categorie->libelle }}
                                    </span>
                                </div>
                            @endif
                            <div class="absolute bottom-4 left-4 right-4 text-white space-y-1">
                                <h4 class="font-serif-title text-sm font-bold leading-snug">
                                    {{ $galerie->titre }}
                                </h4>
                                <span class="text-[10px] text-[#0BA20B] flex items-center gap-1 font-sans">
                                    <svg aria-hidden="true" class="lucide lucide-zoom-in w-3 h-3" fill="none" height="24"
                                        stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="11" cy="11" r="8">
                                        </circle>
                                        <line x1="21" x2="16.65" y1="21" y2="16.65">
                                        </line>
                                        <line x1="11" x2="11" y1="8" y2="14">
                                        </line>
                                        <line x1="8" x2="14" y1="11" y2="11">
                                        </line>
                                    </svg>
                                    {{ $isVideo ? 'Lire' : 'Agrandir' }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 rounded-none border border-dashed border-[#0BA20B]/40 bg-[#FAF7F2] p-8 text-center text-sm text-[#6B574F]">
                            Aucun élément de galerie n'est encore publié.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Lightbox Modal pour la galerie -->
            <div x-show="activeGallery"
                class="fixed inset-0 z-[100] bg-slate-950/90 backdrop-blur-md flex items-center justify-center p-4 sm:p-6"
                x-cloak @keydown.escape.window="activeGallery = null">

                <div class="relative w-full max-w-4xl bg-[#1E1613] border border-[#0BA20B]/30 shadow-2xl flex flex-col max-h-[90vh] overflow-hidden rounded-none"
                    @click.away="activeGallery = null">

                    <div class="px-6 py-4 border-b border-[#0BA20B]/20 flex items-center justify-between bg-[#1E1613]">
                        <div>
                            <h3 class="text-sm font-serif-title font-bold text-[#FAF7F2] uppercase tracking-wider"
                                x-text="showTitle"></h3>
                        </div>
                        <button @click="activeGallery = null"
                            class="text-[#0BA20B] hover:text-[#0BA20B] p-1 transition-colors" title="Fermer (Echap)">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div
                        class="relative flex-1 bg-black flex items-center justify-center min-h-[350px] p-4 overflow-hidden">
                        <template x-if="activeGallery && activeGallery[currentImageIndex]">
                            <div x-data="{ isPlaying: false }" class="w-full h-full flex items-center justify-center">
                                <template x-if="activeGallery[currentImageIndex].type === 'video'">
                                    <div class="relative w-full h-full flex items-center justify-center">
                                        <video
                                            :src="activeGallery[currentImageIndex].url"
                                            controls
                                            class="max-h-[80vh] max-w-full object-contain shadow-2xl transition-all duration-300"
                                            x-ref="videoPlayer">
                                        </video>
                                    </div>
                                </template>
                                <template x-if="activeGallery[currentImageIndex].type !== 'video'">
                                    <img :src="activeGallery[currentImageIndex].url"
                                        class="max-h-[80vh] max-w-full object-contain shadow-2xl transition-all duration-300">
                                </template>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-24 bg-[#FAF7F2] relative overflow-hidden" id="donation">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
                <div class="text-center max-w-3xl mx-auto space-y-4">
                    <div
                        class="inline-flex items-center gap-2 px-3.5 py-1 rounded-none bg-[#F4EFE6] border border-[#0BA20B]/40 text-[#0BA20B] text-xs font-bold uppercase tracking-widest">
                        <svg aria-hidden="true" class="lucide lucide-heart w-3.5 h-3.5 fill-current text-[#0BA20B]"
                            fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M2 9.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5">
                            </path>
                        </svg>
                        <span>
                            Espace Générosité &amp; Engagement
                        </span>
                    </div>
                    <h2 class="font-serif-title text-3xl sm:text-4xl md:text-5xl font-bold text-[#2C221E] tracking-tight">
                        Faire un Don &amp; Adhérer à l’Association
                    </h2>
                    <p class="text-sm sm:text-base text-[#6B574F] font-sans leading-relaxed">
                        Vos contributions soutiennent directement l’achat d’instruments, le financement des bourses pour les
                        jeunes talents et la transmission de l’artisanat du Raphia.
                    </p>
                </div>

                @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-6 py-4 rounded-lg max-w-2xl mx-auto">
                    <div class="flex items-center gap-3">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
                @endif

                @if(session('success'))
                <div class="bg-[#0BA20B]/10 border border-[#0BA20B] text-white px-6 py-4 rounded-none max-w-2xl mx-auto mb-8 shadow-lg">
                    <div class="flex items-center gap-3">
                        <svg class="w-6 h-6 text-[#0BA20B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="font-bold text-sm">{{ session('success') }}</p>
                    </div>
                </div>
                @endif

                @if(session('error'))
                <div class="bg-red-500/10 border border-red-500 text-white px-6 py-4 rounded-none max-w-2xl mx-auto mb-8 shadow-lg">
                    <div class="flex items-center gap-3">
                        <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="font-bold text-sm">{{ session('error') }}</p>
                    </div>
                </div>
                @endif

                <form action="{{ route('don.store') }}" method="POST" x-data="{
                    selectedAmount: 50,
                    customAmount: '',
                    isAnonymous: false,
                    get displayAmount() {
                        return this.customAmount ? this.customAmount : this.selectedAmount;
                    }
                }">
                    @csrf
                    <div
                        class="bg-[#1E1613] text-[#FAF7F2] rounded-none p-8 sm:p-12 shadow-2xl border border-[#0BA20B]/30 max-w-4xl mx-auto space-y-8">
                    <div class="text-center space-y-2">
                        <h3 class="font-serif-title text-2xl sm:text-3xl font-bold text-white">
                            Tapez le montant de votre soutien
                        </h3>
                    </div>
                    <!-- <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        <button type="button" @click="selectedAmount = 20; customAmount = ''" :class="selectedAmount === 20 && !customAmount ? 'bg-[#0BA20B] text-white border-[#0BA20B] shadow-lg scale-105' : 'bg-white/5 text-white border-white/20 hover:bg-white/10'" class="py-4 rounded-none text-lg font-bold font-serif-title border transition-all">
                            20 €
                        </button>
                        <button type="button" @click="selectedAmount = 50; customAmount = ''" :class="selectedAmount === 50 && !customAmount ? 'bg-[#0BA20B] text-white border-[#0BA20B] shadow-lg scale-105' : 'bg-white/5 text-white border-white/20 hover:bg-white/10'" class="py-4 rounded-none text-lg font-bold font-serif-title border transition-all">
                            50 €
                        </button>
                        <button type="button" @click="selectedAmount = 100; customAmount = ''" :class="selectedAmount === 100 && !customAmount ? 'bg-[#0BA20B] text-white border-[#0BA20B] shadow-lg scale-105' : 'bg-white/5 text-white border-white/20 hover:bg-white/10'" class="py-4 rounded-none text-lg font-bold font-serif-title border transition-all">
                            100 €
                        </button>
                        <button type="button" @click="selectedAmount = 200; customAmount = ''" :class="selectedAmount === 200 && !customAmount ? 'bg-[#0BA20B] text-white border-[#0BA20B] shadow-lg scale-105' : 'bg-white/5 text-white border-white/20 hover:bg-white/10'" class="py-4 rounded-none text-lg font-bold font-serif-title border transition-all">
                            200 €
                        </button>
                    </div> -->
                    <div class="max-w-xs mx-auto">
                        <input x-model="customAmount" @input="selectedAmount = 0" class="w-full px-4 py-3 rounded-none bg-white/10 border border-white/20 text-white placeholder-white/50 text-sm text-center focus:outline-none focus:border-[#0BA20B]" placeholder="montant(€)" type="number" name="montant" required min="1" step="0.01"/>
                    </div>

                    <!-- Informations personnelles -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-3 mb-4">
                            <input type="checkbox" id="anonyme" x-model="isAnonymous" name="anonyme" class="w-4 h-4 rounded border-white/30 bg-white/10 text-[#0BA20B] focus:ring-[#0BA20B] focus:ring-offset-0">
                            <label for="anonyme" class="text-sm text-white/80">Je souhaite rester anonyme</label>
                        </div>

                        <div x-show="!isAnonymous" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-[#0BA20B] mb-2">Nom complet</label>
                                <input type="text" name="nom" class="w-full px-4 py-3 rounded-none bg-white/10 border border-white/20 text-white placeholder-white/50 text-sm focus:outline-none focus:border-[#0BA20B]" placeholder="Votre nom">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-[#0BA20B] mb-2">Email</label>
                                <input type="email" name="email" class="w-full px-4 py-3 rounded-none bg-white/10 border border-white/20 text-white placeholder-white/50 text-sm focus:outline-none focus:border-[#0BA20B]" placeholder="votre@email.com">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-[#0BA20B] mb-2">Téléphone</label>
                                <input type="tel" name="telephone" class="w-full px-4 py-3 rounded-none bg-white/10 border border-white/20 text-white placeholder-white/50 text-sm focus:outline-none focus:border-[#0BA20B]" placeholder="+229 XX XX XX XX">
                            </div>
                        </div>
                    </div>

                    <!-- Mode de paiement -->
                    <div>
                        <label class="block text-xs font-bold text-[#0BA20B] mb-3">Mode de paiement préféré</label>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            <label class="flex items-center gap-2 p-3 bg-white/5 border border-white/20 rounded-none cursor-pointer hover:bg-white/10 transition-all">
                                <input type="radio" name="mode_paiement" value="especes" checked class="w-4 h-4 rounded border-white/30 bg-white/10 text-[#0BA20B] focus:ring-[#0BA20B] focus:ring-offset-0">
                                <span class="text-sm text-white">Espèces</span>
                            </label>
                            <label class="flex items-center gap-2 p-3 bg-white/5 border border-white/20 rounded-none cursor-pointer hover:bg-white/10 transition-all">
                                <input type="radio" name="mode_paiement" value="cheque" class="w-4 h-4 rounded border-white/30 bg-white/10 text-[#0BA20B] focus:ring-[#0BA20B] focus:ring-offset-0">
                                <span class="text-sm text-white">Chèque</span>
                            </label>
                            <label class="flex items-center gap-2 p-3 bg-white/5 border border-white/20 rounded-none cursor-pointer hover:bg-white/10 transition-all">
                                <input type="radio" name="mode_paiement" value="virement" class="w-4 h-4 rounded border-white/30 bg-white/10 text-[#0BA20B] focus:ring-[#0BA20B] focus:ring-offset-0">
                                <span class="text-sm text-white">Virement</span>
                            </label>
                            <label class="flex items-center gap-2 p-3 bg-white/5 border border-white/20 rounded-none cursor-pointer hover:bg-white/10 transition-all">
                                <input type="radio" name="mode_paiement" value="mobile_money" class="w-4 h-4 rounded border-white/30 bg-white/10 text-[#0BA20B] focus:ring-[#0BA20B] focus:ring-offset-0">
                                <span class="text-sm text-white">Mobile Money</span>
                            </label>
                        </div>
                    </div>

                    <!-- Message -->
                    <div>
                        <label class="block text-xs font-bold text-[#0BA20B] mb-2">Message (optionnel)</label>
                        <textarea name="message" rows="3" class="w-full px-4 py-3 rounded-none bg-white/10 border border-white/20 text-white placeholder-white/50 text-sm focus:outline-none focus:border-[#0BA20B]" placeholder="Un message pour notre équipe..."></textarea>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="px-8 py-4 rounded-none bg-[#0BA20B] hover:bg-[#087A08] text-white font-bold text-sm uppercase tracking-widest shadow-xl transition-all transform hover:scale-105 inline-flex items-center gap-2">
                            <svg aria-hidden="true" class="lucide lucide-heart w-4 h-4 fill-current text-white" fill="none"
                                height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M2 9.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5">
                                </path>
                            </svg>
                            <span>Valider mon Don</span>
                        </button>
                    </div>
                </div>
                </form>
            </div>
        </section>
        <section class="py-24 bg-[#F4EFE6] relative overflow-hidden" id="news"
            x-data="{ activeGallery: null, currentImageIndex: 0, showTitle: '' }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
                <div class="text-center max-w-3xl mx-auto space-y-4">
                    <div
                        class="inline-flex items-center gap-2 px-3.5 py-1 rounded-none bg-[#FAF7F2] border border-[#0BA20B]/40 text-[#0BA20B] text-xs font-bold uppercase tracking-widest shadow-sm">
                        <svg aria-hidden="true" class="lucide lucide-newspaper w-3.5 h-3.5" fill="none" height="24"
                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 18h-5">
                            </path>
                            <path d="M18 14h-8">
                            </path>
                            <path
                                d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-4 0v-9a2 2 0 0 1 2-2h2">
                            </path>
                            <rect height="4" rx="1" width="8" x="10" y="6">
                            </rect>
                        </svg>
                        <span>
                            Actualités &amp; Chroniques Associatives
                        </span>
                    </div>
                    <h2 class="font-serif-title text-3xl sm:text-4xl md:text-5xl font-bold text-[#2C221E] tracking-tight">
                        Les Dernières Nouvelles de la Maison Culturelle
                    </h2>
                    <p class="text-sm sm:text-base text-[#6B574F] font-sans leading-relaxed">
                        Suivez les avancées des projets agricoles autour du raphia, les événements scolaires et les
                        distinctions de nos jeunes artistes.
                    </p>
                </div>
                <div class="flex justify-end">
                    <a href="{{ route('actualites') }}" class="text-xs text-[#0BA20B] font-bold uppercase tracking-widest hover:underline">
                        Voir toutes les actualités &rarr;
                    </a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @forelse ($actualites as $actu)
                        @php
                            $mainImg = $actu->images->where('is_principal', true)->first() ?? $actu->images->first();
                            $imgPath = $mainImg ? asset('storage/' . $mainImg->image_path) : '/assets/hero_cultural_bg_1785764970571-BS2uarbi.jpg';

                            $galleryData = $actu->images->map(function ($img) {
                                return [
                                    'url' => asset('storage/' . $img->image_path),
                                    'is_principal' => (bool) $img->is_principal
                                ];
                            })->values()->all();
                            if (empty($galleryData)) {
                                $galleryData = [
                                    ['url' => $imgPath, 'is_principal' => true]
                                ];
                            }
                        @endphp
                        <article
                            class="bg-[#FAF7F2] rounded-none overflow-hidden border border-[#0BA20B]/30 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
                            <div>
                                <div class="relative h-48 overflow-hidden bg-slate-900 cursor-pointer"
                                    data-gallery="{{ json_encode($galleryData) }}" data-title="{{ $actu->titre }}" @click="
                                                                activeGallery = JSON.parse($el.dataset.gallery);
                                                                currentImageIndex = 0;
                                                                showTitle = $el.dataset.title;
                                                            ">
                                    <img alt="{{ $actu->titre }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                        referrerpolicy="no-referrer" src="{{ $imgPath }}" />
                                    <span
                                        class="absolute top-3 left-3 bg-[#1E1613]/80 text-[#0BA20B] text-[10px] font-bold px-2.5 py-0.5 rounded-none backdrop-blur-sm uppercase">
                                        Actualité
                                    </span>
                                </div>
                                <div class="p-6 space-y-3">
                                    <div class="flex items-center gap-3 text-xs text-[#8C766B]">
                                        <span class="flex items-center gap-1">
                                            <svg aria-hidden="true" class="lucide lucide-calendar w-3.5 h-3.5 text-[#0BA20B]"
                                                fill="none" height="24" stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path d="M8 2v4"></path>
                                                <path d="M16 2v4"></path>
                                                <rect height="18" rx="2" width="18" x="3" y="4"></rect>
                                                <path d="M3 10h18"></path>
                                            </svg>
                                            {{ \Carbon\Carbon::parse($actu->date_publication)->format('d/m/Y') }}
                                        </span>
                                    </div>
                                    <h3
                                        class="font-serif-title font-bold text-lg text-[#2C221E] leading-snug group-hover:text-[#0BA20B] transition-colors line-clamp-2">
                                        {{ $actu->titre }}
                                    </h3>
                                    <p class="text-xs text-[#6B574F] line-clamp-3 leading-relaxed">
                                        {{ Str::limit(strip_tags($actu->contenu), 100) }}
                                    </p>
                                </div>
                            </div>
                            <div
                                class="p-6 pt-0 border-t border-[#0BA20B]/10 mt-2 flex items-center justify-between text-xs text-[#0BA20B] font-bold">
                                <span class="flex items-center gap-1 text-[#8C766B] font-normal">
                                    <svg aria-hidden="true" class="lucide lucide-user w-3.5 h-3.5" fill="none" height="24"
                                        stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    Comité de Rédaction
                                </span>
                                <a href="{{ route('actualites') }}"
                                    class="flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                                    Lire la suite
                                    <svg aria-hidden="true" class="lucide lucide-arrow-right w-3.5 h-3.5" fill="none"
                                        height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </article>
                    @empty
                        <div class="col-span-3 text-center py-12 text-[#8C766B]">
                            <p class="text-sm">Aucune actualité publiée pour le moment.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Lightbox Modal -->
                <div x-show="activeGallery"
                    class="fixed inset-0 z-[100] bg-slate-950/90 backdrop-blur-md flex items-center justify-center p-4 sm:p-6"
                    x-cloak @keydown.escape.window="activeGallery = null">

                    <div class="relative w-full max-w-4xl bg-[#1E1613] border border-[#0BA20B]/30 shadow-2xl flex flex-col max-h-[90vh] overflow-hidden rounded-none"
                        @click.away="activeGallery = null">

                        <div class="px-6 py-4 border-b border-[#0BA20B]/20 flex items-center justify-between bg-[#1E1613]">
                            <div>
                                <h3 class="text-sm font-serif-title font-bold text-[#FAF7F2] uppercase tracking-wider"
                                    x-text="showTitle"></h3>
                                <p class="text-[10px] text-[#0BA20B] uppercase tracking-widest mt-0.5">
                                    Image <span x-text="currentImageIndex + 1"></span> sur <span
                                        x-text="activeGallery ? activeGallery.length : 0"></span>
                                    <template
                                        x-if="activeGallery && activeGallery[currentImageIndex] && activeGallery[currentImageIndex].is_principal">
                                        <span class="ml-2 text-[#0BA20B] font-bold">• Image Principale</span>
                                    </template>
                                </p>
                            </div>
                            <button @click="activeGallery = null"
                                class="text-[#0BA20B] hover:text-[#0BA20B] p-1 transition-colors" title="Fermer (Echap)">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div
                            class="relative flex-1 bg-black flex items-center justify-center min-h-[350px] p-4 overflow-hidden">
                            <template x-if="activeGallery && activeGallery[currentImageIndex]">
                                <img :src="activeGallery[currentImageIndex].url"
                                    class="max-h-[60vh] max-w-full object-contain shadow-2xl transition-all duration-300">
                            </template>
                            <template x-if="activeGallery && activeGallery.length > 1">
                                <div>
                                    <button
                                        @click="currentImageIndex = (currentImageIndex === 0) ? activeGallery.length - 1 : currentImageIndex - 1"
                                        class="absolute left-4 top-1/2 -translate-y-1/2 bg-[#1E1613]/80 hover:bg-[#0BA20B] text-[#FAF7F2] p-3 transition-colors border border-[#0BA20B]/30 shadow-xl rounded-none">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M15 19l-7-7 7-7" />
                                        </svg>
                                    </button>
                                    <button
                                        @click="currentImageIndex = (currentImageIndex === activeGallery.length - 1) ? 0 : currentImageIndex + 1"
                                        class="absolute right-4 top-1/2 -translate-y-1/2 bg-[#1E1613]/80 hover:bg-[#0BA20B] text-[#FAF7F2] p-3 transition-colors border border-[#0BA20B]/30 shadow-xl rounded-none">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                </div>
                            </template>
                        </div>

                        <template x-if="activeGallery && activeGallery.length > 1">
                            <div
                                class="px-6 py-4 bg-[#1E1613] border-t border-[#0BA20B]/20 flex items-center justify-center gap-3 overflow-x-auto">
                                <template x-for="(img, idx) in activeGallery" :key="idx">
                                    <button @click="currentImageIndex = idx"
                                        class="w-14 h-14 border-2 overflow-hidden transition-all shrink-0 rounded-none"
                                        :class="currentImageIndex === idx ? 'border-[#0BA20B] scale-105 opacity-100' : 'border-[#0BA20B]/30 opacity-50 hover:opacity-100'">
                                        <img :src="img.url" class="w-full h-full object-cover">
                                    </button>
                                </template>
                            </div>
                        </template>

                    </div>
                </div>
            </div>
        </section>
        <section class="py-24 bg-[#FAF7F2] relative overflow-hidden" id="contact">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
                <div class="text-center max-w-3xl mx-auto space-y-4">
                    <div
                        class="inline-flex items-center gap-2 px-3.5 py-1 rounded-none bg-[#F4EFE6] border border-[#0BA20B]/40 text-[#0BA20B] text-xs font-bold uppercase tracking-widest">
                        <svg aria-hidden="true" class="lucide lucide-mail w-3.5 h-3.5" fill="none" height="24"
                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                            <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7">
                            </path>
                            <rect height="16" rx="2" width="20" x="2" y="4">
                            </rect>
                        </svg>
                        <span>
                            Écrivez-nous &amp; Rejoignez-nous
                        </span>
                    </div>
                    <h2 class="font-serif-title text-3xl sm:text-4xl md:text-5xl font-bold text-[#2C221E] tracking-tight">
                        Contact &amp; Foire Aux Questions
                    </h2>
                    <p class="text-sm sm:text-base text-[#6B574F] font-sans leading-relaxed">
                        Vous souhaitez réserver un cours, proposer un partenariat, faire un don ou en savoir plus sur nos
                        ateliers du Raphia ? Notre équipe est à votre écoute.
                    </p>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                    <div
                        class="lg:col-span-7 bg-white rounded-none p-8 sm:p-10 border border-[#0BA20B]/30 shadow-xl space-y-6">
                        <h3 class="font-serif-title text-2xl font-bold text-[#2C221E]">
                            Envoyer un message à l'association
                        </h3>
                        <form id="contactForm" class="space-y-4">
                            @csrf
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-[#2C221E] uppercase mb-1">
                                        Nom complet *
                                    </label>
                                    <input name="nom"
                                        class="w-full px-4 py-2.5 rounded-none bg-[#FAF7F2] border border-[#0BA20B]/30 text-xs focus:outline-none focus:border-[#0BA20B]"
                                        placeholder="e.g. Marie Nguema" required type="text" value="" />
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-[#2C221E] uppercase mb-1">
                                        Adresse e-mail *
                                    </label>
                                    <input name="email"
                                        class="w-full px-4 py-2.5 rounded-none bg-[#FAF7F2] border border-[#0BA20B]/30 text-xs focus:outline-none focus:border-[#0BA20B]"
                                        placeholder="e.g. marie@exemple.com" required type="email" value="" />
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-[#2C221E] uppercase mb-1">
                                    Objet de votre demande *
                                </label>
                                <input name="objet"
                                    class="w-full px-4 py-2.5 rounded-none bg-[#FAF7F2] border border-[#0BA20B]/30 text-xs focus:outline-none focus:border-[#0BA20B]"
                                    required type="text" value="" />
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-[#2C221E] uppercase mb-1">
                                    Votre Message *
                                </label>
                                <textarea name="message"
                                    class="w-full px-4 py-2.5 rounded-none bg-[#FAF7F2] border border-[#0BA20B]/30 text-xs focus:outline-none focus:border-[#0BA20B]"
                                    placeholder="Précisez votre demande, vos disponibilités ou vos questions..." required
                                    rows="4"></textarea>
                            </div>
                            <button type="submit"
                                class="w-full py-3.5 rounded-none bg-[#0BA20B] hover:bg-[#087A08] text-white font-bold text-xs shadow-md transition-all flex items-center justify-center gap-2">
                                <svg aria-hidden="true" class="lucide lucide-send w-4 h-4" fill="none" height="24"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z">
                                    </path>
                                    <path d="m21.854 2.147-10.94 10.939">
                                    </path>
                                </svg>
                                <span>
                                    Envoyer mon Message
                                </span>
                            </button>
                        </form>
                    </div>
                    <div class="lg:col-span-5 space-y-6">
                        <div
                            class="bg-[#1E1613] text-[#FAF7F2] rounded-none p-8 border border-[#0BA20B]/30 space-y-6 shadow-xl">
                            <h3 class="font-serif-title text-2xl font-bold text-white">
                                Maison de l’Association Culturelle
                            </h3>
                            <div class="space-y-4 text-xs font-sans">
                                <div class="flex items-start gap-3">
                                    <svg aria-hidden="true"
                                        class="lucide lucide-map-pin w-5 h-5 text-[#0BA20B] shrink-0 mt-0.5" fill="none"
                                        height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                        </path>
                                        <circle cx="12" cy="10" r="3">
                                        </circle>
                                    </svg>
                                    <div>
                                        <span class="font-bold text-white block">
                                            Adresse du Centre Cultural :
                                        </span>
                                        <p class="text-[#D1C5B8]">
                                            {{ $association->adresse }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <svg aria-hidden="true"
                                        class="lucide lucide-phone-call w-5 h-5 text-[#0BA20B] shrink-0 mt-0.5" fill="none"
                                        height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13 2a9 9 0 0 1 9 9">
                                        </path>
                                        <path d="M13 6a5 5 0 0 1 5 5">
                                        </path>
                                        <path
                                            d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384">
                                        </path>
                                    </svg>
                                    <div>
                                        <span class="font-bold text-white block">
                                            Téléphone / WhatsApp :
                                        </span>
                                        <p class="text-[#D1C5B8]">
                                            {{ $association->telephone }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <svg aria-hidden="true"
                                        class="lucide lucide-mail w-5 h-5 text-[#0BA20B] shrink-0 mt-0.5" fill="none"
                                        height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7">
                                        </path>
                                        <rect height="16" rx="2" width="20" x="2" y="4">
                                        </rect>
                                    </svg>
                                    <div>
                                        <span class="font-bold text-white block">
                                            E-mail Officiel :
                                        </span>
                                        <p class="text-[#D1C5B8]">
                                            {{ $association->email }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3 pt-2 border-t border-white/10">
                                    <svg aria-hidden="true"
                                        class="lucide lucide-clock w-5 h-5 text-[#0BA20B] shrink-0 mt-0.5" fill="none"
                                        height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 6v6l4 2">
                                        </path>
                                        <circle cx="12" cy="12" r="10">
                                        </circle>
                                    </svg>
                                    <div>
                                        <span class="font-bold text-white block">
                                            Horaires d'Ouverture :
                                        </span>
                                        <p class="text-[#D1C5B8]">
                                            Mardi au Samedi : 09h00 – 19h00
                                        </p>
                                        <p class="text-[#D1C5B8]">
                                            Dimanche : 10h00 – 17h00 (Ateliers Raphia)
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pt-12 border-t border-[#0BA20B]/20 space-y-8 max-w-4xl mx-auto">
                    <div class="text-center space-y-2">
                        <h3 class="font-serif-title text-2xl font-bold text-[#2C221E]">
                            Foire Aux Questions (FAQ)
                        </h3>
                        <p class="text-xs text-[#6B574F]">
                            Réponses aux questions les plus fréquemment posées.
                        </p>
                    </div>
                    <div class="space-y-3" x-data="{ activeFaq: 1 }">
                        <!-- FAQ Item 1 -->
                        <div class="bg-white rounded-none border border-[#0BA20B]/30 overflow-hidden shadow-sm">
                            <button @click="activeFaq = activeFaq === 1 ? null : 1"
                                class="w-full p-5 text-left flex items-center justify-between font-bold text-sm text-[#2C221E] hover:text-[#0BA20B] transition-colors">
                                <span class="flex items-center gap-2">
                                    <svg aria-hidden="true"
                                        class="lucide lucide-circle-question-mark w-4 h-4 text-[#0BA20B]" fill="none"
                                        height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                                        <path d="M12 17h.01"></path>
                                    </svg>
                                    Comment puis-je réserver un cours de musique ou un atelier ?
                                </span>
                                <svg aria-hidden="true"
                                    class="lucide lucide-chevron-down w-4 h-4 transition-transform duration-300"
                                    :class="activeFaq === 1 ? 'rotate-180' : ''" fill="none" height="24"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg>
                            </button>
                            <div x-show="activeFaq === 1" x-collapse x-cloak>
                                <div
                                    class="p-5 pt-0 text-xs text-[#6B574F] font-sans leading-relaxed border-t border-[#0BA20B]/10">
                                    Vous pouvez réserver directement en ligne via le bouton 'Réserver un cours' ou dans la
                                    section Formations. Choisissez votre discipline, l'enseignant, le créneau horaire
                                    souhaité et confirmez votre inscription.
                                </div>
                            </div>
                        </div>

                        <!-- FAQ Item 2 -->
                        <div class="bg-white rounded-none border border-[#0BA20B]/30 overflow-hidden shadow-sm">
                            <button @click="activeFaq = activeFaq === 2 ? null : 2"
                                class="w-full p-5 text-left flex items-center justify-between font-bold text-sm text-[#2C221E] hover:text-[#0BA20B] transition-colors">
                                <span class="flex items-center gap-2">
                                    <svg aria-hidden="true"
                                        class="lucide lucide-circle-question-mark w-4 h-4 text-[#0BA20B]" fill="none"
                                        height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                                        <path d="M12 17h.01"></path>
                                    </svg>
                                    Le matériel est-il fourni pour les ateliers d'artisanat du raphia ?
                                </span>
                                <svg aria-hidden="true"
                                    class="lucide lucide-chevron-down w-4 h-4 transition-transform duration-300"
                                    :class="activeFaq === 2 ? 'rotate-180' : ''" fill="none" height="24"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg>
                            </button>
                            <div x-show="activeFaq === 2" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" x-cloak>
                                <div
                                    class="p-5 pt-0 text-xs text-[#6B574F] font-sans leading-relaxed border-t border-[#0BA20B]/10">
                                    Oui, tout le matériel nécessaire (fibres de raphia, outils de tissage) est fourni sur
                                    place pour les débutants. Les artisans avancés peuvent apporter leurs propres outils
                                    s'ils le souhaitent.
                                </div>
                            </div>
                        </div>

                        <!-- FAQ Item 3 -->
                        <div class="bg-white rounded-none border border-[#0BA20B]/30 overflow-hidden shadow-sm">
                            <button @click="activeFaq = activeFaq === 3 ? null : 3"
                                class="w-full p-5 text-left flex items-center justify-between font-bold text-sm text-[#2C221E] hover:text-[#0BA20B] transition-colors">
                                <span class="flex items-center gap-2">
                                    <svg aria-hidden="true"
                                        class="lucide lucide-circle-question-mark w-4 h-4 text-[#0BA20B]" fill="none"
                                        height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                                        <path d="M12 17h.01"></path>
                                    </svg>
                                    Comment fonctionne le programme de promotion des jeunes talents ?
                                </span>
                                <svg aria-hidden="true"
                                    class="lucide lucide-chevron-down w-4 h-4 transition-transform duration-300"
                                    :class="activeFaq === 3 ? 'rotate-180' : ''" fill="none" height="24"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg>
                            </button>
                            <div x-show="activeFaq === 3" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" x-cloak>
                                <div
                                    class="p-5 pt-0 text-xs text-[#6B574F] font-sans leading-relaxed border-t border-[#0BA20B]/10">
                                    Le programme sélectionne de jeunes talents de 15 à 25 ans. Les sélectionnés bénéficient
                                    d'un accès gratuit à nos studios, d'un accompagnement personnalisé et de l'opportunité
                                    de se produire lors de nos événements.
                                </div>
                            </div>
                        </div>

                        <!-- FAQ Item 4 -->
                        <div class="bg-white rounded-none border border-[#0BA20B]/30 overflow-hidden shadow-sm">
                            <button @click="activeFaq = activeFaq === 4 ? null : 4"
                                class="w-full p-5 text-left flex items-center justify-between font-bold text-sm text-[#2C221E] hover:text-[#0BA20B] transition-colors">
                                <span class="flex items-center gap-2">
                                    <svg aria-hidden="true"
                                        class="lucide lucide-circle-question-mark w-4 h-4 text-[#0BA20B]" fill="none"
                                        height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                                        <path d="M12 17h.01"></path>
                                    </svg>
                                    Puis-je bénéficier d'une déduction fiscale pour un don à l'association ?
                                </span>
                                <svg aria-hidden="true"
                                    class="lucide lucide-chevron-down w-4 h-4 transition-transform duration-300"
                                    :class="activeFaq === 4 ? 'rotate-180' : ''" fill="none" height="24"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg>
                            </button>
                            <div x-show="activeFaq === 4" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" x-cloak>
                                <div
                                    class="p-5 pt-0 text-xs text-[#6B574F] font-sans leading-relaxed border-t border-[#0BA20B]/10">
                                    Oui, notre association étant reconnue d'intérêt général, vos dons ouvrent droit à une
                                    réduction d'impôt (66% du montant du don pour les particuliers). Un reçu fiscal vous
                                    sera envoyé automatiquement.
                                </div>
                            </div>
                        </div>

                        <!-- FAQ Item 5 -->
                        <div class="bg-white rounded-none border border-[#0BA20B]/30 overflow-hidden shadow-sm">
                            <button @click="activeFaq = activeFaq === 5 ? null : 5"
                                class="w-full p-5 text-left flex items-center justify-between font-bold text-sm text-[#2C221E] hover:text-[#0BA20B] transition-colors">
                                <span class="flex items-center gap-2">
                                    <svg aria-hidden="true"
                                        class="lucide lucide-circle-question-mark w-4 h-4 text-[#0BA20B]" fill="none"
                                        height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                                        <path d="M12 17h.01"></path>
                                    </svg>
                                    Les cours sont-ils adaptés aux débutants complets ?
                                </span>
                                <svg aria-hidden="true"
                                    class="lucide lucide-chevron-down w-4 h-4 transition-transform duration-300"
                                    :class="activeFaq === 5 ? 'rotate-180' : ''" fill="none" height="24"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg>
                            </button>
                            <div x-show="activeFaq === 5" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" x-cloak>
                                <div
                                    class="p-5 pt-0 text-xs text-[#6B574F] font-sans leading-relaxed border-t border-[#0BA20B]/10">
                                    Absolument ! Tous nos cours (musique, tissage, chant) proposent des niveaux débutants.
                                    Nos professeurs s'adaptent à votre rythme, même si vous n'avez aucune expérience
                                    préalable.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </main>

<!-- Candidature Modal -->
<div id="candidature-modal" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm px-4">
    <div class="relative w-full max-w-2xl bg-[#FAF7F2] rounded-none p-8 sm:p-10 shadow-2xl overflow-y-auto max-h-[90vh] animate-in fade-in zoom-in-95 duration-200">
        <!-- Close Button -->
        <button onclick="document.getElementById('candidature-modal').classList.add('hidden')" class="absolute top-4 right-4 p-2 bg-[#F4EFE6] hover:bg-[#0BA20B] text-[#2C221E] hover:text-white transition-colors rounded-none" aria-label="Fermer">
            <svg aria-hidden="true" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center gap-1.5 px-3 py-1 bg-[#F4EFE6] border border-[#0BA20B]/20 text-[#0BA20B] text-[10px] sm:text-xs font-bold uppercase tracking-wider rounded-none mb-4">
                <svg aria-hidden="true" class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z"></path>
                </svg>
                <span>Tremplin Jeunes Talents</span>
            </div>
            <h2 class="font-serif-title text-3xl sm:text-4xl font-bold text-[#2C221E]">Postuler au Programme de Promotion</h2>
            <p class="text-sm text-[#6B574F] mt-2 font-sans">Réservé aux jeunes créateurs de 15 à 25 ans (Studio &amp; Scènes offerts).</p>
        </div>

        <form id="candidatureForm" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-[#2C221E] uppercase tracking-wider">Nom <span class="text-[#0BA20B]">*</span></label>
                    <input name="nom" required type="text" placeholder="e.g. Nguema" class="w-full bg-white border border-[#0BA20B]/40 p-3 text-sm text-[#2C221E] focus:outline-none focus:border-[#0BA20B] focus:ring-1 focus:ring-[#0BA20B] rounded-none transition-colors placeholder-[#8C766B]/50" />
                </div>
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-[#2C221E] uppercase tracking-wider">Prénom <span class="text-[#0BA20B]">*</span></label>
                    <input name="prenom" required type="text" placeholder="e.g. Samuel" class="w-full bg-white border border-[#0BA20B]/40 p-3 text-sm text-[#2C221E] focus:outline-none focus:border-[#0BA20B] focus:ring-1 focus:ring-[#0BA20B] rounded-none transition-colors placeholder-[#8C766B]/50" />
                </div>
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-[#2C221E] uppercase tracking-wider">Nom de Scène / Pseudo</label>
                    <input name="pseudo" type="text" placeholder="e.g. Sam Kora" class="w-full bg-white border border-[#0BA20B]/40 p-3 text-sm text-[#2C221E] focus:outline-none focus:border-[#0BA20B] focus:ring-1 focus:ring-[#0BA20B] rounded-none transition-colors placeholder-[#8C766B]/50" />
                </div>
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-[#2C221E] uppercase tracking-wider">Age <span class="text-[#0BA20B]">*</span></label>
                    <input name="age" required type="number" placeholder="21" class="w-full bg-white border border-[#0BA20B]/40 p-3 text-sm text-[#2C221E] focus:outline-none focus:border-[#0BA20B] focus:ring-1 focus:ring-[#0BA20B] rounded-none transition-colors placeholder-[#8C766B]/50" />
                </div>
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-[#2C221E] uppercase tracking-wider">Email <span class="text-[#0BA20B]">*</span></label>
                    <input name="email" required type="email" placeholder="e.g. samuel@example.com" class="w-full bg-white border border-[#0BA20B]/40 p-3 text-sm text-[#2C221E] focus:outline-none focus:border-[#0BA20B] focus:ring-1 focus:ring-[#0BA20B] rounded-none transition-colors placeholder-[#8C766B]/50" />
                </div>
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-[#2C221E] uppercase tracking-wider">Téléphone <span class="text-[#0BA20B]">*</span></label>
                    <input name="telephone" required type="tel" placeholder="e.g. +241 07 45 12 89" class="w-full bg-white border border-[#0BA20B]/40 p-3 text-sm text-[#2C221E] focus:outline-none focus:border-[#0BA20B] focus:ring-1 focus:ring-[#0BA20B] rounded-none transition-colors placeholder-[#8C766B]/50" />
                </div>
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-[#2C221E] uppercase tracking-wider">WhatsApp <span class="text-[#0BA20B]">*</span></label>
                    <input name="whatsapp" required type="tel" placeholder="e.g. +241 07 45 12 89" class="w-full bg-white border border-[#0BA20B]/40 p-3 text-sm text-[#2C221E] focus:outline-none focus:border-[#0BA20B] focus:ring-1 focus:ring-[#0BA20B] rounded-none transition-colors placeholder-[#8C766B]/50" />
                </div>
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-[#2C221E] uppercase tracking-wider">Discipline <span class="text-[#0BA20B]">*</span></label>
                    <div class="relative">
                        <select name="discipline_id" required class="w-full appearance-none bg-white border border-[#0BA20B]/40 p-3 pr-10 text-sm text-[#2C221E] focus:outline-none focus:border-[#0BA20B] focus:ring-1 focus:ring-[#0BA20B] rounded-none transition-colors">
                            <option value="">Sélectionnez une discipline...</option>
                            <option value="1">Chant & Polyphonie</option>
                            <option value="2">Percussions & Balafon</option>
                            <option value="3">Instruments à Cordes (Kora, etc.)</option>
                            <option value="4">Création Numérique Audio</option>
                            <option value="5">Autre</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-[#0BA20B]">
                            <svg aria-hidden="true" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-bold text-[#2C221E] uppercase tracking-wider">Lien Audio / Vidéo Démo (Youtube, Soundcloud, Drive) <span class="text-[#0BA20B]">*</span></label>
                <input name="demo_link" required type="url" placeholder="https://youtube.com/watch?v=..." class="w-full bg-white border border-[#0BA20B]/40 p-3 text-sm text-[#2C221E] focus:outline-none focus:border-[#0BA20B] focus:ring-1 focus:ring-[#0BA20B] rounded-none transition-colors placeholder-[#8C766B]/50" />
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-bold text-[#2C221E] uppercase tracking-wider">Présentation de votre projet artistique <span class="text-[#0BA20B]">*</span></label>
                <textarea name="presentation" required rows="4" placeholder="Racontez-nous votre parcours, vos influences et ce que vous attendez de l'association..." class="w-full bg-white border border-[#0BA20B]/40 p-3 text-sm text-[#2C221E] focus:outline-none focus:border-[#0BA20B] focus:ring-1 focus:ring-[#0BA20B] rounded-none transition-colors placeholder-[#8C766B]/50 resize-y"></textarea>
            </div>

            <button type="submit" class="w-full px-6 py-3.5 bg-[#0BA20B] hover:bg-[#087A08] text-white font-bold text-sm tracking-wide uppercase shadow-lg transition-transform hover:-translate-y-0.5 rounded-none flex items-center justify-center gap-2">
                <svg aria-hidden="true" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                </svg>
                <span>Soumettre ma Candidature</span>
            </button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Contact form
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(contactForm);

            fetch('{{ route('contact.store') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Message envoyé !',
                        text: data.message,
                        confirmButtonColor: '#0BA20B',
                        confirmButtonText: 'OK'
                    });
                    contactForm.reset();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: 'Une erreur est survenue. Veuillez réessayer.',
                        confirmButtonColor: '#0BA20B',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: 'Une erreur est survenue. Veuillez réessayer.',
                    confirmButtonColor: '#0BA20B',
                    confirmButtonText: 'OK'
                });
            });
        });
    }

    // Candidature form
    const candidatureForm = document.getElementById('candidatureForm');
    if (candidatureForm) {
        candidatureForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(candidatureForm);

            fetch('{{ route('talent-candidatures.store') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Candidature envoyée !',
                        text: data.message,
                        confirmButtonColor: '#0BA20B',
                        confirmButtonText: 'OK'
                    });
                    candidatureForm.reset();
                    document.getElementById('candidature-modal').classList.add('hidden');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: 'Une erreur est survenue. Veuillez réessayer.',
                        confirmButtonColor: '#0BA20B',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: 'Une erreur est survenue. Veuillez réessayer.',
                    confirmButtonColor: '#0BA20B',
                    confirmButtonText: 'OK'
                });
            });
        });
    }
});
</script>

@endsection
