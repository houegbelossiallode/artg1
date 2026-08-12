<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', $association->nom ?? 'Écho & Culture — Association Artistique & Patrimoine')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Cinzel:wght@500;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="/css/reference_style.css">
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        .whitespace-nowrap { white-space: nowrap !important; }
        .flex-nowrap { flex-wrap: nowrap !important; }
    </style>
</head>
<body class="bg-[#FAF7F2] text-[#2C221E] antialiased selection:bg-[#0BA20B] selection:text-white">
    <header id="main-header" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 bg-gradient-to-b from-[#1E1613]/80 via-[#1E1613]/40 to-transparent py-5 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between flex-nowrap gap-4">

            {{-- Logo --}}
            <a class="flex items-center gap-3 group shrink-0" href="{{ url('/#hero') }}">
                @if($association && $association->logo)
                    <img src="{{ asset('storage/' . $association->logo) }}" alt="{{ $association->nom }}" class="w-10 h-10 object-cover rounded-none shadow-lg group-hover:scale-105 transition-transform shrink-0" />
                @else
                    <div class="w-10 h-10 rounded-none bg-gradient-to-br from-[#0BA20B] to-[#0BA20B] p-0.5 flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform shrink-0">
                        <div class="w-full h-full rounded-none bg-[#1E1613] flex items-center justify-center text-[#0BA20B]">
                            <svg aria-hidden="true" class="lucide lucide-sparkles w-5 h-5 text-[#0BA20B] animate-pulse" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z"></path>
                                <path d="M20 2v4"></path>
                                <path d="M22 4h-4"></path>
                                <circle cx="4" cy="20" r="2"></circle>
                            </svg>
                        </div>
                    </div>
                @endif
                <div class="whitespace-nowrap">
                    <span id="logo-title" class="block font-display text-xl sm:text-2xl font-bold tracking-tight text-white transition-colors">
                        {{ $association->nom ?? 'ÉCHO & CULTURE' }}
                    </span>
                    <span id="logo-subtitle" class="block text-[10px] uppercase tracking-widest font-sans font-semibold text-[#0BA20B] transition-colors">
                        Arts • Musique • Raphia
                    </span>
                </div>
            </a>

            {{-- Nav Links --}}
            <nav class="hidden lg:flex items-center gap-1 xl:gap-2 flex-nowrap shrink-0">
                <div class="relative group">
                    <a class="nav-link-item px-3 py-2 text-sm font-medium transition-colors rounded-none flex items-center gap-1 text-white/90 hover:text-white hover:bg-white/10 whitespace-nowrap" href="{{ url('/#hero') }}">
                        Accueil
                    </a>
                </div>
                <div class="relative group">
                    <a class="nav-link-item px-3 py-2 text-sm font-medium transition-colors rounded-none flex items-center gap-1 text-white/90 hover:text-white hover:bg-white/10 whitespace-nowrap" href="{{ url('/#about') }}">
                        À propos
                    </a>
                </div>

                {{-- Menu Activités avec sous-menus --}}
                <div class="relative group">
                    <button type="button" class="nav-link-item px-3 py-2 text-sm font-medium transition-colors rounded-none flex items-center gap-1 text-white/90 hover:text-white hover:bg-white/10 whitespace-nowrap">
                        Activités
                        <svg aria-hidden="true" class="lucide lucide-chevron-down w-3.5 h-3.5 opacity-70 group-hover:rotate-180 transition-transform" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="m6 9 6 6 6-6"></path></svg>
                    </button>
                    <!-- Sous-menus Activités -->
                    <div class="absolute left-0 top-full hidden group-hover:block w-64 bg-[#1E1613] border border-[#0BA20B]/30 shadow-2xl py-2 z-50">
                        <a href="{{ url('/#events') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-xs font-semibold text-white/90 hover:text-[#0BA20B] hover:bg-white/5 transition-colors uppercase tracking-wider">
                            <span class="w-1.5 h-1.5 bg-[#0BA20B]"></span>
                            Événements
                        </a>
                        <a href="{{ url('/#courses') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-xs font-semibold text-white/90 hover:text-[#0BA20B] hover:bg-white/5 transition-colors uppercase tracking-wider">
                            <span class="w-1.5 h-1.5 bg-[#0BA20B]"></span>
                            Formations (Cours &amp; Formations)
                        </a>
                        <a href="{{ url('/#gallery') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-xs font-semibold text-white/90 hover:text-[#0BA20B] hover:bg-white/5 transition-colors uppercase tracking-wider">
                            <span class="w-1.5 h-1.5 bg-[#0BA20B]"></span>
                            Galerie
                        </a>
                        <a href="{{ url('/#news') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-xs font-semibold text-white/90 hover:text-[#0BA20B] hover:bg-white/5 transition-colors uppercase tracking-wider">
                            <span class="w-1.5 h-1.5 bg-[#0BA20B]"></span>
                            Actualités
                        </a>
                    </div>
                </div>

                <div class="relative group">
                    <a class="nav-link-item px-3 py-2 text-sm font-medium transition-colors rounded-none flex items-center gap-1 text-white/90 hover:text-white hover:bg-white/10 whitespace-nowrap" href="{{ url('/#talents') }}">
                        Jeunes Talents
                    </a>
                </div>
                <div class="relative group">
                    <a class="nav-link-item px-3 py-2 text-sm font-medium transition-colors rounded-none flex items-center gap-1 text-white/90 hover:text-white hover:bg-white/10 whitespace-nowrap" href="{{ url('/#contact') }}">
                        Contact
                    </a>
                </div>
                <div class="relative group">
                    <a id="member-btn" href="{{ route('login') }}" class="nav-link-item px-3 py-2 text-sm font-medium transition-colors rounded-none flex items-center gap-1.5 text-white/90 hover:text-white hover:bg-white/10 whitespace-nowrap" title="Espace Apprenant / Professeur">
                        <svg aria-hidden="true" class="lucide lucide-user w-4 h-4 text-[#0BA20B]" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        <span class="whitespace-nowrap">Espace Membre</span>
                    </a>
                </div>
            </nav>
        </div>
    </header>

    @yield('content')

    {{-- Footer --}}
    <footer class="bg-[#1E1613] text-[#FAF7F2] pt-16 pb-12 border-t border-[#0BA20B]/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        @if($association && $association->logo)
                            <img src="{{ asset('storage/' . $association->logo) }}" alt="{{ $association->nom }}" class="w-8 h-8 object-cover rounded-none" />
                        @else
                            <div class="w-8 h-8 rounded-none bg-gradient-to-br from-[#0BA20B] to-[#0BA20B] p-0.5 flex items-center justify-center">
                                <div class="w-full h-full bg-[#1E1613] flex items-center justify-center text-[#0BA20B]">
                                    <svg aria-hidden="true" class="lucide lucide-sparkles w-4 h-4 text-[#0BA20B]" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z"></path><path d="M20 2v4"></path><path d="M22 4h-4"></path><circle cx="4" cy="20" r="2"></circle></svg>
                                </div>
                            </div>
                        @endif
                        <span class="font-display font-bold text-lg text-white">{{ $association->nom ?? 'ÉCHO & CULTURE' }}</span>
                    </div>
                    <p class="text-xs text-[#D1C5B8] leading-relaxed">Maison associative dédiée à la promotion des arts musicaux traditionnels, à la valorisation de la filière raphia et à l'épanouissement des jeunes talents.</p>
                </div>
                <div>
                    <h4 class="font-serif-title font-bold text-sm text-[#0BA20B] uppercase tracking-wider mb-4">Navigation</h4>
                    <ul class="space-y-2 text-xs text-[#D1C5B8]">
                        <li><a class="hover:text-white transition-colors" href="{{ url('/#hero') }}">Accueil</a></li>
                        <li><a class="hover:text-white transition-colors" href="{{ url('/#about') }}">À Propos &amp; Historique</a></li>
                        <li><a class="hover:text-white transition-colors" href="{{ url('/#actions') }}">Filière Raphia</a></li>
                        <li><a class="hover:text-white transition-colors" href="{{ url('/#talents') }}">Jeunes Talents</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-serif-title font-bold text-sm text-[#0BA20B] uppercase tracking-wider mb-4">Activités</h4>
                    <ul class="space-y-2 text-xs text-[#D1C5B8]">
                        <li><a class="hover:text-white transition-colors" href="{{ url('/#courses') }}">Cours de Musique</a></li>
                        <li><a class="hover:text-white transition-colors" href="{{ url('/#courses') }}">Ateliers Tissage Raphia</a></li>
                        <li><a class="hover:text-white transition-colors" href="{{ url('/#events') }}">Agenda des Événements</a></li>
                        <li><a class="hover:text-white transition-colors" href="{{ url('/#gallery') }}">Médiathèque</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-serif-title font-bold text-sm text-[#0BA20B] uppercase tracking-wider mb-4">Newsletter</h4>
                    <p class="text-xs text-[#D1C5B8] mb-4">Recevez nos actualités et événements directement dans votre boîte mail.</p>
                    <form id="newsletterForm" action="{{ route('newsletter.store') }}" method="POST" class="space-y-3">
                        @csrf
                        <input type="email" name="email" required placeholder="Votre email" class="w-full px-4 py-2.5 bg-white/5 border border-white/20 rounded-none text-white placeholder-white/50 text-xs focus:outline-none focus:border-[#0BA20B] focus:ring-1 focus:ring-[#0BA20B] transition-colors">
                        <button type="submit" class="w-full px-4 py-2.5 bg-[#0BA20B] hover:bg-[#087A08] text-white font-bold text-xs rounded-none transition-colors shadow-lg">
                            S'inscrire
                        </button>
                    </form>
                </div>
            </div>
            <div class="pt-8 border-t border-white/10 flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="text-center md:text-left text-xs text-[#8C766B]">
                    © {{ date('Y') }} {{ $association->nom ?? 'Association Écho & Culture' }}. Tous droits réservés.
                </div>
                <div>
                    <h4 class="font-serif-title font-bold text-sm text-[#0BA20B] uppercase tracking-wider mb-2">Contact &amp; Mécénat</h4>
                    <ul class="space-y-1 text-xs text-[#D1C5B8]">
                        <li><span>📍{{ $association->adresse }}</span></li>
                        <li><span>✉️ {{ $association->email }}</span></li>
                        <li><a class="text-[#0BA20B] hover:underline font-semibold" href="{{ url('/#donation') }}">Faire un Don / Adhérer →</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Newsletter form
        const newsletterForm = document.getElementById('newsletterForm');
        if (newsletterForm) {
            newsletterForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(newsletterForm);
                
                fetch('{{ route('newsletter.store') }}', {
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
                            title: 'Inscription réussie !',
                            text: data.message,
                            confirmButtonColor: '#0BA20B',
                            confirmButtonText: 'OK'
                        });
                        newsletterForm.reset();
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const header = document.getElementById('main-header');
            const logoTitle = document.getElementById('logo-title');
            const logoSubtitle = document.getElementById('logo-subtitle');
            const navLinks = document.querySelectorAll('.nav-link-item');
            const memberBtn = document.getElementById('member-btn');
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');

            function checkScroll() {
                if (window.scrollY > 30) {
                    header.classList.remove('bg-gradient-to-b', 'from-[#1E1613]/80', 'via-[#1E1613]/40', 'to-transparent', 'py-5', 'text-white');
                    header.classList.add('bg-[#FAF7F2]/95', 'backdrop-blur-md', 'shadow-md', 'py-3', 'border-b', 'border-[#0BA20B]/30');

                    if(logoTitle) {
                        logoTitle.classList.remove('text-white');
                        logoTitle.classList.add('text-[#2C221E]');
                    }
                    if(logoSubtitle) {
                        logoSubtitle.classList.remove('text-[#0BA20B]');
                        logoSubtitle.classList.add('text-[#0BA20B]');
                    }
                    navLinks.forEach(link => {
                        link.classList.remove('text-white/90', 'hover:text-white', 'hover:bg-white/10');
                        link.classList.add('text-[#2C221E]', 'hover:text-[#0BA20B]', 'hover:bg-[#F4EFE6]');
                    });
                    if(memberBtn) {
                        memberBtn.classList.remove('text-white/90', 'bg-white/10', 'hover:bg-white/20', 'backdrop-blur-sm');
                        memberBtn.classList.add('text-[#2C221E]', 'hover:bg-[#F4EFE6]', 'border', 'border-[#0BA20B]/40');
                    }
                    if(mobileMenuBtn) {
                        mobileMenuBtn.classList.remove('text-white', 'hover:bg-white/10');
                        mobileMenuBtn.classList.add('text-[#2C221E]', 'hover:bg-[#F4EFE6]');
                    }
                } else {
                    header.classList.add('bg-gradient-to-b', 'from-[#1E1613]/80', 'via-[#1E1613]/40', 'to-transparent', 'py-5', 'text-white');
                    header.classList.remove('bg-[#FAF7F2]/95', 'backdrop-blur-md', 'shadow-md', 'py-3', 'border-b', 'border-[#0BA20B]/30');

                    if(logoTitle) {
                        logoTitle.classList.add('text-white');
                        logoTitle.classList.remove('text-[#2C221E]');
                    }
                    if(logoSubtitle) {
                        logoSubtitle.classList.add('text-[#0BA20B]');
                        logoSubtitle.classList.remove('text-[#0BA20B]');
                    }
                    navLinks.forEach(link => {
                        link.classList.add('text-white/90', 'hover:text-white', 'hover:bg-white/10');
                        link.classList.remove('text-[#2C221E]', 'hover:text-[#0BA20B]', 'hover:bg-[#F4EFE6]');
                    });
                    if(memberBtn) {
                        memberBtn.classList.add('text-white/90', 'bg-white/10', 'hover:bg-white/20', 'backdrop-blur-sm');
                        memberBtn.classList.remove('text-[#2C221E]', 'hover:bg-[#F4EFE6]', 'border', 'border-[#0BA20B]/40');
                    }
                    if(mobileMenuBtn) {
                        mobileMenuBtn.classList.add('text-white', 'hover:bg-white/10');
                        mobileMenuBtn.classList.remove('text-[#2C221E]', 'hover:bg-[#F4EFE6]');
                    }
                }
            }

            window.addEventListener('scroll', checkScroll);
            checkScroll();
        });
    </script>

    @php
       $disciplines = \App\Models\Discipline::where('actif', 'OUI')->orderBy('libelle')->get();
    @endphp

    <!-- Global Candidature Modal -->
<div id="candidature-modal" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm px-4">
    <div class="relative w-full max-w-2xl bg-[#FAF7F2] rounded-none p-8 sm:p-10 shadow-2xl overflow-y-auto max-h-[90vh] animate-in fade-in zoom-in-95 duration-200">
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

       @if(session('success'))
           <div class="mb-6 rounded-none border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
               {{ session('success') }}
           </div>
       @endif

       <form action="{{ route('talent-candidatures.store') }}" method="POST" class="space-y-6">
           @csrf
           <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
               <div class="space-y-2">
                   <label class="block text-xs font-bold text-[#2C221E] uppercase tracking-wider">Nom <span class="text-[#0BA20B]">*</span></label>
                   <input required name="nom" type="text" placeholder="e.g. Samuel Nguema" class="w-full bg-white border border-[#0BA20B]/40 p-3 text-sm text-[#2C221E] focus:outline-none focus:border-[#0BA20B] focus:ring-1 focus:ring-[#0BA20B] rounded-none transition-colors placeholder-[#8C766B]/50" />
               </div>
               <div class="space-y-2">
                   <label class="block text-xs font-bold text-[#2C221E] uppercase tracking-wider">Prénom</label>
                   <input name="prenom" type="text" placeholder="e.g. Samuel" class="w-full bg-white border border-[#0BA20B]/40 p-3 text-sm text-[#2C221E] focus:outline-none focus:border-[#0BA20B] focus:ring-1 focus:ring-[#0BA20B] rounded-none transition-colors placeholder-[#8C766B]/50" />
               </div>
               <div class="space-y-2">
                   <label class="block text-xs font-bold text-[#2C221E] uppercase tracking-wider">Nom de Scène / Pseudo</label>
                   <input name="pseudo" type="text" placeholder="e.g. Sam Kora" class="w-full bg-white border border-[#0BA20B]/40 p-3 text-sm text-[#2C221E] focus:outline-none focus:border-[#0BA20B] focus:ring-1 focus:ring-[#0BA20B] rounded-none transition-colors placeholder-[#8C766B]/50" />
               </div>
               <div class="space-y-2">
                   <label class="block text-xs font-bold text-[#2C221E] uppercase tracking-wider">Âge (15 – 25 ans) <span class="text-[#0BA20B]">*</span></label>
                   <input required name="age" type="number" min="15" max="25" placeholder="21" class="w-full bg-white border border-[#0BA20B]/40 p-3 text-sm text-[#2C221E] focus:outline-none focus:border-[#0BA20B] focus:ring-1 focus:ring-[#0BA20B] rounded-none transition-colors placeholder-[#8C766B]/50" />
               </div>
               <div class="space-y-2">
                   <label class="block text-xs font-bold text-[#2C221E] uppercase tracking-wider">Discipline <span class="text-[#0BA20B]">*</span></label>
                   <div class="relative">
                       <select required name="discipline_id" class="w-full appearance-none bg-white border border-[#0BA20B]/40 p-3 pr-10 text-sm text-[#2C221E] focus:outline-none focus:border-[#0BA20B] focus:ring-1 focus:ring-[#0BA20B] rounded-none transition-colors">
                           <option value="">Sélectionnez une discipline...</option>
                           @foreach($disciplines as $discipline)
                               <option value="{{ $discipline->id }}">{{ $discipline->libelle }}</option>
                           @endforeach
                       </select>
                       <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-[#0BA20B]">
                           <svg aria-hidden="true" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                               <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                           </svg>
                       </div>
                   </div>
               </div>
               <div class="space-y-2">
                   <label class="block text-xs font-bold text-[#2C221E] uppercase tracking-wider">Email <span class="text-[#0BA20B]">*</span></label>
                   <input required name="email" type="email" placeholder="e.g. samuel@exemple.com" class="w-full bg-white border border-[#0BA20B]/40 p-3 text-sm text-[#2C221E] focus:outline-none focus:border-[#0BA20B] focus:ring-1 focus:ring-[#0BA20B] rounded-none transition-colors placeholder-[#8C766B]/50" />
               </div>
               <div class="space-y-2">
                   <label class="block text-xs font-bold text-[#2C221E] uppercase tracking-wider">Téléphone</label>
                   <input name="telephone" type="text" placeholder="e.g. +241 06 12 34 56" class="w-full bg-white border border-[#0BA20B]/40 p-3 text-sm text-[#2C221E] focus:outline-none focus:border-[#0BA20B] focus:ring-1 focus:ring-[#0BA20B] rounded-none transition-colors placeholder-[#8C766B]/50" />
               </div>
               <div class="space-y-2">
                   <label class="block text-xs font-bold text-[#2C221E] uppercase tracking-wider">Numéro WhatsApp</label>
                   <input name="whatsapp" type="text" placeholder="e.g. +241 06 12 34 56" class="w-full bg-white border border-[#0BA20B]/40 p-3 text-sm text-[#2C221E] focus:outline-none focus:border-[#0BA20B] focus:ring-1 focus:ring-[#0BA20B] rounded-none transition-colors placeholder-[#8C766B]/50" />
               </div>
           </div>

           <div class="space-y-2">
               <label class="block text-xs font-bold text-[#2C221E] uppercase tracking-wider">Lien Audio / Vidéo Démo (Youtube, Soundcloud, Drive) <span class="text-[#0BA20B]">*</span></label>
               <input required name="demo_link" type="url" placeholder="https://youtube.com/watch?v=..." class="w-full bg-white border border-[#0BA20B]/40 p-3 text-sm text-[#2C221E] focus:outline-none focus:border-[#0BA20B] focus:ring-1 focus:ring-[#0BA20B] rounded-none transition-colors placeholder-[#8C766B]/50" />
           </div>

           <div class="space-y-2">
               <label class="block text-xs font-bold text-[#2C221E] uppercase tracking-wider">Présentation de votre projet artistique <span class="text-[#0BA20B]">*</span></label>
               <textarea required name="presentation" rows="4" placeholder="Racontez-nous votre parcours, vos influences et ce que vous attendez de l'association..." class="w-full bg-white border border-[#0BA20B]/40 p-3 text-sm text-[#2C221E] focus:outline-none focus:border-[#0BA20B] focus:ring-1 focus:ring-[#0BA20B] rounded-none transition-colors placeholder-[#8C766B]/50 resize-y"></textarea>
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

</body>
</html>
