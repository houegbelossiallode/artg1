{{-- Dashboard Sidebar – Design professionnel : fond blanc + accents vert citron --}}
<aside class="w-64 bg-white text-slate-700 h-screen max-h-screen fixed top-0 left-0 flex flex-col z-40 border-r border-slate-200 hidden md:flex shadow-[4px_0_24px_rgba(0,0,0,0.08)]">

  {{-- ═══════════════════════ BRANDING ═══════════════════════ --}}
  <div class="h-24 flex items-center px-6 border-b border-slate-200 shrink-0 bg-slate-50">
    <a href="{{ url('/') }}" class="flex items-center gap-3 group w-full">
      <div class="w-9 h-9 border-2 border-brand-lime flex items-center justify-center font-serif-heading font-bold text-brand-lime text-sm tracking-wider overflow-hidden group-hover:bg-brand-lime group-hover:text-slate-900 transition-all duration-300 shrink-0">
        @if(isset($association->logo) && $association->logo)
          <img src="{{ asset('storage/' . $association->logo) }}" alt="Logo" class="w-full h-full object-cover">
        @else
          AC
        @endif
      </div>
      <span class="font-serif-heading font-bold text-sm tracking-widest uppercase text-slate-800 truncate group-hover:text-brand-lime transition-colors duration-300">{{ $association->nom ?? 'Culture' }}</span>
    </a>
  </div>

  {{-- ═══════════════════════ NAVIGATION ═══════════════════════ --}}
  <div class="flex-1 overflow-y-auto py-4 scrollbar-thin scrollbar-track-slate-100 scrollbar-thumb-slate-300">
    <nav class="px-3 space-y-0.5">

      {{-- ─── Navigation Apprenant ─── --}}
      {{-- @if(Auth::user() && (Auth::user()->profil_id == 3 || (Auth::user()->profil && strtolower(Auth::user()->profil->nom) === 'apprenant')))
        <div class="text-[9px] text-slate-400 font-bold uppercase tracking-[0.15em] px-4 mb-2 mt-3">
          Espace Apprenant
        </div>
        <a href="{{ route('dashboard.apprenant') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-md text-xs font-bold transition-all {{ request()->routeIs('dashboard.apprenant') ? 'bg-[#C85A32]/10 text-slate-900 border-l-4 border-[#C85A32]' : 'text-slate-600 hover:bg-slate-50' }}">
          <i class="fa-solid fa-house text-[#C85A32]"></i>
          Mon Tableau de Bord
        </a>
        <a href="{{ route('dashboard.apprenant.cours') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-md text-xs font-bold transition-all {{ request()->routeIs('dashboard.apprenant.cours') ? 'bg-[#C85A32]/10 text-slate-900 border-l-4 border-[#C85A32]' : 'text-slate-600 hover:bg-slate-50' }}">
          <i class="fa-solid fa-graduation-cap text-[#C85A32]"></i>
          Catalogue & Réservation
        </a>
        <a href="{{ route('dashboard.apprenant.reservations') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-md text-xs font-bold transition-all {{ request()->routeIs('dashboard.apprenant.reservations') ? 'bg-[#C85A32]/10 text-slate-900 border-l-4 border-[#C85A32]' : 'text-slate-600 hover:bg-slate-50' }}">
          <i class="fa-solid fa-calendar-check text-[#C85A32]"></i>
          Mes Inscriptions
        </a>
      @endif --}}

      {{-- ─── Menu Dynamique (depuis la BDD) ─── --}}
      @if(isset($mainmenus) && $mainmenus->isNotEmpty())
        @php
          $activeMenu = '';
          foreach ($mainmenus as $menu) {
              foreach ($menu->submenus as $sm) {
                  if (Route::has($sm->url) && request()->routeIs($sm->url)) {
                      $activeMenu = 'menu-' . $menu->id;
                      break 2;
                  }
              }
          }
        @endphp

        <div class="text-[9px] text-slate-400 font-bold uppercase tracking-[0.15em] px-4 mb-2 mt-3">
          Administration
        </div>

        <div x-data="{ activeMenu: '{{ $activeMenu }}' }">
          
          {{-- Vue Globale Fixe (Optionnel si vous l'avez en BDD, sinon on la garde) --}}
          @if(Route::has('dashboard.admin'))
          <a href="{{ route('dashboard.admin') }}"
             class="sidebar-link {{ request()->routeIs('dashboard.admin') ? 'sidebar-link--active' : '' }} mb-1">
            <span class="sidebar-icon sidebar-icon--lime {{ request()->routeIs('dashboard.admin') ? 'sidebar-icon--active' : '' }}">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            </span>
            Vue Globale
          </a>
          @endif

          @foreach($mainmenus as $menu)
            <div class="rounded-sm overflow-hidden mb-0.5">
              <button @click="activeMenu = activeMenu === 'menu-{{ $menu->id }}' ? '' : 'menu-{{ $menu->id }}'"
                      type="button"
                      class="sidebar-accordion-btn"
                      :class="{ 'sidebar-accordion-btn--active': activeMenu === 'menu-{{ $menu->id }}' }">
                <div class="flex items-center gap-3">
                  <span class="sidebar-icon sidebar-icon--lime">
                    @if($menu->icon)
                      @if(str_contains(trim($menu->icon), ' ') || str_starts_with(trim($menu->icon), 'fa'))
                        <i class="{{ trim($menu->icon) }} text-[16px]"></i>
                      @else
                        <i class="material-icons text-[16px]">{{ trim($menu->icon) }}</i>
                      @endif
                    @else
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    @endif
                  </span>
                  <span>{{ $menu->libelle }}</span>
                </div>
                <svg class="w-3.5 h-3.5 text-slate-400 transform transition-transform duration-300 shrink-0"
                     :class="{ 'rotate-180 !text-slate-900': activeMenu === 'menu-{{ $menu->id }}' }"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
              </button>

              <div x-show="activeMenu === 'menu-{{ $menu->id }}'"
                   x-transition:enter="transition ease-out duration-200"
                   x-transition:enter-start="opacity-0 -translate-y-1"
                   x-transition:enter-end="opacity-100 translate-y-0"
                   x-transition:leave="transition ease-in duration-150"
                   x-transition:leave-start="opacity-100 translate-y-0"
                   x-transition:leave-end="opacity-0 -translate-y-1"
                   class="my-1 ml-5 pl-3 border-l border-[#C85A32]/30 space-y-0.5" x-cloak>
                @foreach($menu->submenus as $submenu)
                  <a href="{{ Route::has($submenu->url) ? route($submenu->url) : '#' }}"
                     class="sidebar-sublink {{ Route::has($submenu->url) && request()->routeIs($submenu->url) ? 'sidebar-sublink--active' : '' }}">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    {{ $submenu->libelle }}
                  </a>
                @endforeach
              </div>
            </div>
          @endforeach

        </div>
      @endif

    </nav>
  </div>

  {{-- ═══════════════════════ ACTIONS RAPIDES (Fixé) ═══════════════════════ --}}
  <div class="shrink-0 border-t border-slate-200 bg-slate-50 px-3 py-3 space-y-1">

    <a href="{{ url('/') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium text-slate-500 hover:text-slate-900 hover:bg-slate-100 transition-all duration-200 group">
      <span class="w-8 h-8 flex items-center justify-center rounded-md bg-slate-100 group-hover:bg-slate-200 transition-colors duration-200 shrink-0">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
      </span>
      <span class="truncate">Retour au Site Public</span>
    </a>

    <form method="POST" action="{{ route('logout') }}" id="sidebar-logout-form" class="hidden">
      @csrf
    </form>
    <a href="#"
       onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();"
       class="flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium text-red-600 hover:text-red-700 hover:bg-red-50 transition-all duration-200 group">
      <span class="w-8 h-8 flex items-center justify-center rounded-md bg-red-500/10 group-hover:bg-red-500/20 transition-colors duration-200 shrink-0">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
        </svg>
      </span>
      <span class="truncate">Déconnexion</span>
    </a>

  </div>

  

</aside>
