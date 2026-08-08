import re

header_html = """<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Écho & Culture — Association Artistique & Patrimoine')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Cinzel:wght@500;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="/css/reference_style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .whitespace-nowrap { white-space: nowrap !important; }
        .flex-nowrap { flex-wrap: nowrap !important; }
    </style>
</head>
<body class="bg-[#FAF7F2] text-[#2C221E] antialiased selection:bg-[#D4A373] selection:text-white">
    <header id="main-header" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 bg-gradient-to-b from-[#1E1613]/80 via-[#1E1613]/40 to-transparent py-5 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between flex-nowrap gap-4">
            
            {{-- Logo --}}
            <a class="flex items-center gap-3 group shrink-0" href="{{ url('/#hero') }}">
                <div class="w-10 h-10 rounded-none bg-gradient-to-br from-[#C85A32] to-[#D4A373] p-0.5 flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform shrink-0">
                    <div class="w-full h-full rounded-none bg-[#1E1613] flex items-center justify-center text-[#D4A373]">
                        <svg aria-hidden="true" class="lucide lucide-sparkles w-5 h-5 text-[#D4A373] animate-pulse" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z"></path>
                            <path d="M20 2v4"></path>
                            <path d="M22 4h-4"></path>
                            <circle cx="4" cy="20" r="2"></circle>
                        </svg>
                    </div>
                </div>
                <div class="whitespace-nowrap">
                    <span id="logo-title" class="block font-display text-xl sm:text-2xl font-bold tracking-tight text-white transition-colors">
                        ÉCHO &amp; CULTURE
                    </span>
                    <span id="logo-subtitle" class="block text-[10px] uppercase tracking-widest font-sans font-semibold text-[#D4A373] transition-colors">
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
                        <svg aria-hidden="true" class="lucide lucide-chevron-down w-3.5 h-3.5 opacity-70 group-hover:rotate-180 transition-transform" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="m6 9 6 6 6-6"></path></svg>
                    </a>
                </div>
                <div class="relative group">
                    <a class="nav-link-item px-3 py-2 text-sm font-medium transition-colors rounded-none flex items-center gap-1 text-white/90 hover:text-white hover:bg-white/10 whitespace-nowrap" href="{{ url('/#actions') }}">
                        Nos Actions
                        <svg aria-hidden="true" class="lucide lucide-chevron-down w-3.5 h-3.5 opacity-70 group-hover:rotate-180 transition-transform" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="m6 9 6 6 6-6"></path></svg>
                    </a>
                </div>
                <div class="relative group">
                    <a class="nav-link-item px-3 py-2 text-sm font-medium transition-colors rounded-none flex items-center gap-1 text-white/90 hover:text-white hover:bg-white/10 whitespace-nowrap" href="{{ url('/#talents') }}">
                        Jeunes Talents
                    </a>
                </div>
                <div class="relative group">
                    <a class="nav-link-item px-3 py-2 text-sm font-medium transition-colors rounded-none flex items-center gap-1 text-white/90 hover:text-white hover:bg-white/10 whitespace-nowrap" href="{{ url('/#events') }}">
                        Événements
                    </a>
                </div>
                <div class="relative group">
                    <a class="nav-link-item px-3 py-2 text-sm font-medium transition-colors rounded-none flex items-center gap-1 text-white/90 hover:text-white hover:bg-white/10 whitespace-nowrap" href="{{ url('/#courses') }}">
                        Cours &amp; Formations
                    </a>
                </div>
                <div class="relative group">
                    <a class="nav-link-item px-3 py-2 text-sm font-medium transition-colors rounded-none flex items-center gap-1 text-white/90 hover:text-white hover:bg-white/10 whitespace-nowrap" href="{{ url('/#gallery') }}">
                        Galerie
                    </a>
                </div>
                <div class="relative group">
                    <a class="nav-link-item px-3 py-2 text-sm font-medium transition-colors rounded-none flex items-center gap-1 text-white/90 hover:text-white hover:bg-white/10 whitespace-nowrap" href="{{ url('/#news') }}">
                        Actualités
                    </a>
                </div>
                <div class="relative group">
                    <a class="nav-link-item px-3 py-2 text-sm font-medium transition-colors rounded-none flex items-center gap-1 text-white/90 hover:text-white hover:bg-white/10 whitespace-nowrap" href="{{ url('/#contact') }}">
                        Contact
                    </a>
                </div>
            </nav>

            {{-- Action Buttons --}}
            <div class="hidden sm:flex items-center gap-3 flex-nowrap shrink-0">
                <button id="member-btn" onclick="window.location='{{ route('login') }}'" class="p-2 px-3 rounded-none text-xs font-medium transition-all flex items-center gap-1.5 text-white/90 bg-white/10 hover:bg-white/20 backdrop-blur-sm whitespace-nowrap" title="Espace Apprenant / Professeur">
                    <svg aria-hidden="true" class="lucide lucide-user w-4 h-4 text-[#D4A373]" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    <span class="hidden xl:inline whitespace-nowrap">Espace Membre</span>
                </button>

                <button onclick="window.location='{{ url('/#courses') }}'" class="px-4 py-2 text-xs font-semibold rounded-none bg-[#C85A32] hover:bg-[#A84223] text-white shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5 flex items-center gap-1.5 whitespace-nowrap shrink-0">
                    <svg aria-hidden="true" class="lucide lucide-graduation-cap w-4 h-4" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z"></path><path d="M22 10v6"></path><path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"></path></svg>
                    <span class="whitespace-nowrap">Réserver un Cours</span>
                </button>

                <button onclick="window.location='{{ url('/#donation') }}'" class="px-3.5 py-2 text-xs font-semibold rounded-none bg-gradient-to-r from-[#D4A373] to-[#B8860B] hover:from-[#B8860B] hover:to-[#D4A373] text-[#1E1613] shadow-sm hover:shadow-md transition-all flex items-center gap-1.5 whitespace-nowrap shrink-0">
                    <svg aria-hidden="true" class="lucide lucide-heart w-4 h-4 fill-current text-[#1E1613]" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M2 9.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5"></path></svg>
                    <span class="whitespace-nowrap">Faire un Don</span>
                </button>
            </div>

            <div class="flex items-center gap-2 lg:hidden">
                <button id="mobile-menu-btn" class="p-2 rounded-none transition-colors text-white hover:bg-white/10" aria-label="Menu Mobile">
                    <svg aria-hidden="true" class="lucide lucide-menu w-6 h-6" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M4 5h16"></path><path d="M4 12h16"></path><path d="M4 19h16"></path></svg>
                </button>
            </div>

        </div>
    </header>

    @yield('content')

    {{-- Footer --}}
    <footer class="bg-[#1E1613] text-[#FAF7F2] pt-16 pb-12 border-t border-[#D4A373]/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-none bg-gradient-to-br from-[#C85A32] to-[#D4A373] p-0.5 flex items-center justify-center">
                            <div class="w-full h-full bg-[#1E1613] flex items-center justify-center text-[#D4A373]">
                                <svg aria-hidden="true" class="lucide lucide-sparkles w-4 h-4 text-[#D4A373]" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z"></path><path d="M20 2v4"></path><path d="M22 4h-4"></path><circle cx="4" cy="20" r="2"></circle></svg>
                            </div>
                        </div>
                        <span class="font-display font-bold text-lg text-white">ÉCHO &amp; CULTURE</span>
                    </div>
                    <p class="text-xs text-[#D1C5B8] leading-relaxed">Maison associative dédiée à la promotion des arts musicaux traditionnels, à la valorisation de la filière raphia et à l’épanouissement des jeunes talents.</p>
                </div>
                <div>
                    <h4 class="font-serif-title font-bold text-sm text-[#D4A373] uppercase tracking-wider mb-4">Navigation</h4>
                    <ul class="space-y-2 text-xs text-[#D1C5B8]">
                        <li><a class="hover:text-white transition-colors" href="{{ url('/#hero') }}">Accueil</a></li>
                        <li><a class="hover:text-white transition-colors" href="{{ url('/#about') }}">À Propos &amp; Historique</a></li>
                        <li><a class="hover:text-white transition-colors" href="{{ url('/#actions') }}">Filière Raphia</a></li>
                        <li><a class="hover:text-white transition-colors" href="{{ url('/#talents') }}">Jeunes Talents</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-serif-title font-bold text-sm text-[#D4A373] uppercase tracking-wider mb-4">Activités</h4>
                    <ul class="space-y-2 text-xs text-[#D1C5B8]">
                        <li><a class="hover:text-white transition-colors" href="{{ url('/#courses') }}">Cours de Musique</a></li>
                        <li><a class="hover:text-white transition-colors" href="{{ url('/#courses') }}">Ateliers Tissage Raphia</a></li>
                        <li><a class="hover:text-white transition-colors" href="{{ url('/#events') }}">Agenda des Événements</a></li>
                        <li><a class="hover:text-white transition-colors" href="{{ url('/#gallery') }}">Médiathèque</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-serif-title font-bold text-sm text-[#D4A373] uppercase tracking-wider mb-4">Contact &amp; Mécénat</h4>
                    <ul class="space-y-2 text-xs text-[#D1C5B8]">
                        <li><span>📍 Palais de la Culture</span></li>
                        <li><span>✉️ contact@echo-culture.org</span></li>
                        <li><a class="text-[#D4A373] hover:underline font-semibold" href="{{ url('/#donation') }}">Faire un Don / Adhérer →</a></li>
                    </ul>
                </div>
            </div>
            <div class="pt-8 border-t border-white/10 text-center text-xs text-[#8C766B]">
                © {{ date('Y') }} Association Écho &amp; Culture. Tous droits réservés.
            </div>
        </div>
    </footer>

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
                    header.classList.add('bg-[#FAF7F2]/95', 'backdrop-blur-md', 'shadow-md', 'py-3', 'border-b', 'border-[#D4A373]/30');
                    
                    if(logoTitle) {
                        logoTitle.classList.remove('text-white');
                        logoTitle.classList.add('text-[#2C221E]');
                    }
                    if(logoSubtitle) {
                        logoSubtitle.classList.remove('text-[#D4A373]');
                        logoSubtitle.classList.add('text-[#C85A32]');
                    }
                    navLinks.forEach(link => {
                        link.classList.remove('text-white/90', 'hover:text-white', 'hover:bg-white/10');
                        link.classList.add('text-[#2C221E]', 'hover:text-[#C85A32]', 'hover:bg-[#F4EFE6]');
                    });
                    if(memberBtn) {
                        memberBtn.classList.remove('text-white/90', 'bg-white/10', 'hover:bg-white/20', 'backdrop-blur-sm');
                        memberBtn.classList.add('text-[#2C221E]', 'hover:bg-[#F4EFE6]', 'border', 'border-[#D4A373]/40');
                    }
                    if(mobileMenuBtn) {
                        mobileMenuBtn.classList.remove('text-white', 'hover:bg-white/10');
                        mobileMenuBtn.classList.add('text-[#2C221E]', 'hover:bg-[#F4EFE6]');
                    }
                } else {
                    header.classList.add('bg-gradient-to-b', 'from-[#1E1613]/80', 'via-[#1E1613]/40', 'to-transparent', 'py-5', 'text-white');
                    header.classList.remove('bg-[#FAF7F2]/95', 'backdrop-blur-md', 'shadow-md', 'py-3', 'border-b', 'border-[#D4A373]/30');
                    
                    if(logoTitle) {
                        logoTitle.classList.add('text-white');
                        logoTitle.classList.remove('text-[#2C221E]');
                    }
                    if(logoSubtitle) {
                        logoSubtitle.classList.add('text-[#D4A373]');
                        logoSubtitle.classList.remove('text-[#C85A32]');
                    }
                    navLinks.forEach(link => {
                        link.classList.add('text-white/90', 'hover:text-white', 'hover:bg-white/10');
                        link.classList.remove('text-[#2C221E]', 'hover:text-[#C85A32]', 'hover:bg-[#F4EFE6]');
                    });
                    if(memberBtn) {
                        memberBtn.classList.add('text-white/90', 'bg-white/10', 'hover:bg-white/20', 'backdrop-blur-sm');
                        memberBtn.classList.remove('text-[#2C221E]', 'hover:bg-[#F4EFE6]', 'border', 'border-[#D4A373]/40');
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
</body>
</html>
"""

with open('resources/views/layouts/app.blade.php', 'w', encoding='utf-8') as f:
    f.write(header_html)

print("Updated app.blade.php with perfect scroll behavior, whitespace-nowrap, and compact single-line buttons!")
