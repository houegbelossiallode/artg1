        <section class="relative min-h-screen flex items-center pt-24 pb-16 overflow-hidden bg-[#1E1613]" id="hero"
            x-data="{ 
                activeGallery: null, 
                currentImageIndex: 0, 
                showTitle: '',
                heroSlide: 0,
                slides: [
                    '/assets/hero_cultural_bg_1785764970571-BS2uarbi.jpg',
                    '/assets/hero_music_art.png',
                    '/assets/hero_agriculture.png'
                ],
                init() {
                    this.startInterval();
                },
                startInterval() {
                    this.interval = setInterval(() => {
                        this.heroSlide = (this.heroSlide + 1) % this.slides.length;
                    }, 5000);
                },
                resetInterval() {
                    clearInterval(this.interval);
                    this.startInterval();
                },
                next() {
                    this.heroSlide = (this.heroSlide + 1) % this.slides.length;
                    this.resetInterval();
                },
                prev() {
                    this.heroSlide = (this.heroSlide - 1 + this.slides.length) % this.slides.length;
                    this.resetInterval();
                }
            }">
            <div class="absolute inset-0 z-0">
                <template x-for="(slide, index) in slides" :key="index">
                    <img alt="Patrimoine Culturel et Arts Musicaux"
                        class="absolute inset-0 w-full h-full object-cover object-center scale-105 filter brightness-75 contrast-110 transform transition-opacity duration-1000 ease-in-out"
                        :class="heroSlide === index ? 'opacity-100 z-10' : 'opacity-0 z-0'"
                        referrerpolicy="no-referrer" :src="slide" />
                </template>
                <div class="absolute inset-0 bg-gradient-to-r from-[#1E1613] via-[#1E1613]/85 to-[#1E1613]/50 z-20">
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-[#1E1613] via-transparent to-[#1E1613]/70 z-20">
                </div>
                <div class="absolute inset-0 opacity-10 bg-pattern-raphia pointer-events-none z-20">
                </div>
            </div>

            <!-- FlÃ¨ches de navigation -->
            <button type="button" @click.stop.prevent="prev()" class="absolute left-4 top-1/2 -translate-y-1/2 z-30 w-12 h-12 flex items-center justify-center rounded-none bg-[#1E1613]/40 border border-white/10 hover:border-[#0BA20B] hover:bg-[#0BA20B]/80 text-white transition-all backdrop-blur-sm group">
                <svg class="w-6 h-6 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <button type="button" @click.stop.prevent="next()" class="absolute right-4 top-1/2 -translate-y-1/2 z-30 w-12 h-12 flex items-center justify-center rounded-none bg-[#1E1613]/40 border border-white/10 hover:border-[#0BA20B] hover:bg-[#0BA20B]/80 text-white transition-all backdrop-blur-sm group">
                <svg class="w-6 h-6 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    <div class="lg:col-span-7 space-y-6 text-left">
                        <!-- <div
                                            class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-none bg-white/10 backdrop-blur-md border border-[#0BA20B]/40 text-[#0BA20B] text-xs font-semibold tracking-wider uppercase">
                                            <svg aria-hidden="true" class="lucide lucide-sparkles w-3.5 h-3.5 text-[#0BA20B]" fill="none"
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
                                            Maison de l'Art, de la Musique &amp; du Raphia
                                            </span>
                                        </div> -->
                        <h1
                            class="font-serif-title text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold text-[#FAF7F2] leading-[1.08] tracking-tight">
                            CÃ©lÃ©brer la
                            <span class="italic text-[#0BA20B] font-normal">
                                Culture
                            </span>
                            ,
                            <br />
                            FaÃ§onner le
                            <span class="text-[#0BA20B]">
                                Raphia
                            </span>
                            &amp;
                            <br />
                            Transmettre l'Art.
                        </h1>
                        <p class="text-base sm:text-lg text-[#E6DCD3] font-sans font-light max-w-2xl leading-relaxed">
                            Vitrine officielle de notre association culturelle : dÃ©couvrez la richesse des arts musicaux
                            traditionnels et modernes, explorez la valeur agro-artisanale du raphia, rÃ©servez vos cours
                            dâ€™instruments et soutenez lâ€™Ã©mergence des jeunes talents.
                        </p>
                        <div class="pt-2 flex flex-wrap gap-3 items-center">
                            <a href="#courses"
                                class="px-6 py-3.5 rounded-none bg-[#0BA20B] hover:bg-[#087A08] text-white font-semibold text-sm shadow-xl shadow-[#0BA20B]/25 hover:shadow-2xl transition-all transform hover:-translate-y-1 flex items-center gap-2 group">
                                <svg aria-hidden="true" class="lucide lucide-graduation-cap w-4 h-4 text-[#0BA20B]"
                                    fill="none" height="24" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z">
                                    </path>
                                    <path d="M22 10v6">
                                    </path>
                                    <path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5">
                                    </path>
                                </svg>
                                <span>
                                    RÃ©server un Cours
                                </span>
                                <svg aria-hidden="true"
                                    class="lucide lucide-arrow-right w-4 h-4 group-hover:translate-x-1 transition-transform"
                                    fill="none" height="24" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 12h14">
                                    </path>
                                    <path d="m12 5 7 7-7 7">
                                    </path>
                                </svg>
                            </a>
                            <a class="px-5 py-3.5 rounded-none bg-white/10 hover:bg-white/20 text-white font-semibold text-sm border border-white/20 backdrop-blur-md transition-all flex items-center gap-2"
                                href="#events">
                                <svg aria-hidden="true" class="lucide lucide-calendar w-4 h-4 text-[#0BA20B]" fill="none"
                                    height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
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
                                    Voir les Ã‰vÃ©nements
                                </span>
                            </a>
                            <a href="#donation"
                                class="px-5 py-3.5 rounded-none bg-gradient-to-r from-[#0BA20B] to-[#087A08] text-[#1E1613] font-bold text-sm shadow-lg hover:brightness-110 transition-all flex items-center gap-2">
                                <svg aria-hidden="true" class="lucide lucide-heart w-4 h-4 fill-current text-[#1E1613]"
                                    fill="none" height="24" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M2 9.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5">
                                    </path>
                                </svg>
                                <span>
                                    Faire un Don
                                </span>
                            </a>
                            <a class="px-4 py-3.5 text-xs text-[#0BA20B] hover:text-white underline underline-offset-4 font-semibold flex items-center gap-1.5 transition-colors"
                                href="#contact">
                                <svg aria-hidden="true" class="lucide lucide-handshake w-4 h-4" fill="none" height="24"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m11 17 2 2a1 1 0 1 0 3-3">
                                    </path>
                                    <path
                                        d="m14 14 2.5 2.5a1 1 0 1 0 3-3l-3.88-3.88a3 3 0 0 0-4.24 0l-.88.88a1 1 0 1 1-3-3l2.81-2.81a5.79 5.79 0 0 1 7.06-.87l.47.28a2 2 0 0 0 1.42.25L21 4">
                                    </path>
                                    <path d="m21 3 1 11h-2">
                                    </path>
                                    <path d="M3 3 2 14l6.5 6.5a1 1 0 1 0 3-3">
                                    </path>
                                    <path d="M3 4h8">
                                    </path>
                                </svg>
                                <span>
                                    Devenir Partenaire
                                </span>
                            </a>
                        </div>
                        <div class="pt-6 border-t border-white/10 grid grid-cols-3 gap-4 text-xs text-[#C5B8AD]">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-none bg-[#0BA20B]">
                                </div>
                                <span>
                                    <strong>
                                        Musique
                                    </strong>
                                    &amp; Chorale
                                </span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-none bg-[#0BA20B]">
                                </div>
                                <span>
                                    <strong>
                                        Artisanat
                                    </strong>
                                    Raphia
                                </span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-none bg-[#52B788]">
                                </div>
                                <span>
                                    <strong>
                                        Jeunes
                                    </strong>
                                    Talents
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="lg:col-span-5 relative">
                        <div class="glass-dark rounded-none p-6 shadow-2xl border border-[#0BA20B]/30 space-y-5">
                            <div class="flex items-center justify-between pb-3 border-b border-white/10">
                                <div class="flex items-center gap-2">
                                    <span class="flex h-3 w-3 relative">
                                        <span
                                            class="animate-ping absolute inline-flex h-full w-full rounded-none bg-[#0BA20B] opacity-75">
                                        </span>
                                        <span class="relative inline-flex rounded-none h-3 w-3 bg-[#0BA20B]">
                                        </span>
                                    </span>
                                    <span class="text-xs font-bold uppercase tracking-wider text-[#0BA20B]">
                                        Ã€ la Une ce Mois-ci
                                    </span>
                                </div>
                                <span class="text-[11px] text-white/60 bg-white/10 px-2 py-0.5 rounded-none">
                                    Prochain Rendez-vous
                                </span>
                            </div>
                            @if($evenementPhare)
                                @php
                                    $mainImg = $evenementPhare->images->where('is_principal', true)->first() ?? $evenementPhare->images->first();
                                    $imgPath = $mainImg ? asset('storage/' . $mainImg->image_path) : '/assets/hero_cultural_bg_1785764970571-BS2uarbi.jpg';

                                    $galleryData = $evenementPhare->images->map(function ($img) {
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
                                <div class="space-y-3">
                                    <div class="relative rounded-none overflow-hidden h-44 group cursor-pointer"
                                        data-gallery="{{ json_encode($galleryData) }}" data-title="{{ $evenementPhare->titre }}"
                                        @click="
                                                                activeGallery = JSON.parse($el.dataset.gallery);
                                                                currentImageIndex = 0;
                                                                showTitle = $el.dataset.title;
                                                            ">
                                        <img alt="{{ $evenementPhare->titre }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                            referrerpolicy="no-referrer" src="{{ $imgPath }}" />
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-[#1E1613] via-transparent to-transparent">
                                        </div>
                                        <div class="absolute bottom-3 left-3 right-3 flex items-end justify-between">
                                            <div>
                                                <span
                                                    class="text-[10px] uppercase font-bold text-[#0BA20B] bg-[#1E1613]/80 px-2 py-0.5 rounded-none">
                                                    {{ $evenementPhare->categorie ? $evenementPhare->categorie->libelle : 'Ã‰vÃ©nement' }}
                                                </span>
                                                <h4 class="text-sm font-bold text-white font-serif-title mt-1 line-clamp-2">
                                                    {{ $evenementPhare->titre }}
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- @if(count($galleryData) > 1)
                                        <div class="flex gap-2 overflow-x-auto pb-2">
                                            @foreach($evenementPhare->images as $index => $img)
                                                <div class="flex-shrink-0 w-16 h-16 rounded-none overflow-hidden border-2 {{ $img->is_principal ? 'border-[#0BA20B]' : 'border-[#0BA20B]/30' }} cursor-pointer hover:border-[#0BA20B] transition-colors"
                                                    @click="
                                                                                    activeGallery = JSON.parse($el.parentElement.parentElement.querySelector('[data-gallery]').dataset.gallery);
                                                                                    currentImageIndex = {{ $index }};
                                                                                    showTitle = $el.parentElement.parentElement.querySelector('[data-title]').dataset.title;
                                                                                ">
                                                    <img alt="{{ $evenementPhare->titre }} - vignette {{ $index + 1 }}"
                                                        class="w-full h-full object-cover" referrerpolicy="no-referrer"
                                                        src="{{ asset('storage/' . $img->image_path) }}" />
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif --}}
                                    <div class="text-xs text-[#D1C5B8] space-y-1.5">
                                        @if($evenementPhare->date_debut)
                                            <p class="flex items-center justify-between">
                                                <span class="text-white/70">
                                                    ðŸ“… Date:
                                                </span>
                                                <span class="font-semibold text-white">
                                                    {{ \Carbon\Carbon::parse($evenementPhare->date_debut)->translatedFormat('d F Y') }}
                                                    {{ $evenementPhare->heure ? 'â€¢ ' . $evenementPhare->heure : '' }}
                                                </span>
                                            </p>
                                        @endif
                                        @if($evenementPhare->lieu)
                                            <p class="flex items-center justify-between">
                                                <span class="text-white/70">
                                                    ðŸ“ Lieu:
                                                </span>
                                                <span class="font-semibold text-white">
                                                    {{ $evenementPhare->lieu }}
                                                </span>
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="pt-2 flex gap-2">
                                    <a class="w-full py-2.5 rounded-none bg-[#0BA20B] hover:bg-[#087A08] text-[#1E1613] font-bold text-xs text-center transition-colors shadow"
                                        href="{{ route('evenements.show', $evenementPhare->id) }}">
                                        Voir les dÃ©tails
                                    </a>
                                </div>
                            @else
                                <div class="space-y-3">
                                    <div class="relative rounded-none overflow-hidden h-44">
                                        <img alt="Aucun Ã©vÃ©nement" class="w-full h-full object-cover"
                                            referrerpolicy="no-referrer"
                                            src="/assets/hero_cultural_bg_1785764970571-BS2uarbi.jpg" />
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-[#1E1613] via-transparent to-transparent">
                                        </div>
                                        <div class="absolute bottom-3 left-3 right-3">
                                            <span
                                                class="text-[10px] uppercase font-bold text-[#0BA20B] bg-[#1E1613]/80 px-2 py-0.5 rounded-none">
                                                Ã€ venir
                                            </span>
                                            <h4 class="text-sm font-bold text-white font-serif-title mt-1">
                                                Aucun Ã©vÃ©nement Ã  la une
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="text-xs text-[#D1C5B8] text-center py-4">
                                        Revenez bientÃ´t pour dÃ©couvrir nos prochains Ã©vÃ©nements.
                                    </div>
                                </div>
                            @endif
                            <div
                                class="p-3 rounded-none bg-white/5 border border-white/10 flex items-center justify-between text-xs">
                                <div class="flex items-center gap-2 text-white/90">
                                    <svg aria-hidden="true" class="lucide lucide-sparkles w-4 h-4 text-[#0BA20B]"
                                        fill="none" height="24" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24"
                                        xmlns="http://www.w3.org/2000/svg">
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
                                        Vous Ãªtes un jeune talent ?
                                    </span>
                                </div>
                                <button onclick="document.getElementById('candidature-modal').classList.remove('hidden')" class="text-xs font-bold text-[#0BA20B] hover:underline cursor-pointer">
                                    Postuler â†’
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
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
                                    <span class="ml-2 text-[#0BA20B] font-bold">â€¢ Image Principale</span>
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
        </section>
