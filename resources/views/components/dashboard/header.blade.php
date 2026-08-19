<!-- Dashboard Header -->
<header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-6 md:px-10 z-30 sticky top-0 shadow-sm">

  <!-- Mobile Menu Button & Search -->
  <div class="flex items-center gap-6">
    <button class="md:hidden text-slate-500 hover:text-slate-900 transition-colors">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
    </button>

    <div class="hidden sm:flex items-center gap-3 bg-slate-50 px-4 py-2 border border-slate-200 rounded-full w-64 md:w-80 focus-within:border-slate-900 transition-colors">
      <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
      <input type="text" placeholder="Rechercher..." class="bg-transparent text-sm w-full focus:outline-none text-slate-900 placeholder-slate-400" />
    </div>
  </div>

  <!-- Actions & Profile -->
  <div class="flex items-center gap-6">

    <!-- Notifications -->
    @php
        $user = auth()->user();
        $unreadCount = \App\Models\Notification::forUser($user->id)->unread()->count();
        $recentNotifications = \App\Models\Notification::forUser($user->id)->orderBy('created_at', 'desc')->limit(5)->get();
    @endphp
    <div class="relative">
      <button onclick="document.getElementById('notifications-dropdown').classList.toggle('hidden')" class="relative text-slate-400 hover:text-slate-900 transition-colors focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
        <span id="notification-badge" @if($unreadCount > 0) class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center" @else class="hidden" @endif>
            {{ $unreadCount }}
        </span>
      </button>

      <!-- Dropdown -->
      <div id="notifications-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-white border border-slate-200 shadow-xl z-50 overflow-hidden">
        <div class="bg-slate-50 border-b border-slate-200 px-4 py-3 flex justify-between items-center">
          <span class="text-xs font-bold uppercase tracking-widest text-slate-900">Notifications</span>
          @if($unreadCount > 0)
              <form method="POST" action="{{ route('notifications.mark-all-read') }}" style="display: inline;">
                  @csrf
                  <button type="submit" class="text-[10px] text-brand-lime font-bold hover:text-amber-700">Marquer tout lu</button>
              </form>
          @endif
        </div>
        @if($recentNotifications->isEmpty())
            <div class="p-8 text-center text-slate-500 text-sm">
                Aucune notification
            </div>
        @else
            <div class="divide-y divide-slate-100 max-h-64 overflow-y-auto">
                @foreach($recentNotifications as $notification)
                    <form method="POST" action="{{ route('notifications.mark-read', $notification->id) }}" style="display: none;" id="mark-read-form-{{ $notification->id }}">
                        @csrf
                    </form>
                    <div onclick="document.getElementById('mark-read-form-{{ $notification->id }}').submit()" class="block px-4 py-3 hover:bg-slate-50 transition-colors cursor-pointer {{ !$notification->read ? 'bg-slate-50' : '' }}">
                        <p class="text-sm font-bold text-slate-900">{{ $notification->title }}</p>
                        <p class="text-xs text-slate-500 mt-1 line-clamp-1">{{ $notification->message }}</p>
                        <span class="text-[10px] text-slate-400 mt-2 block">{{ $notification->created_at->diffForHumans() }}</span>
                    </div>
                @endforeach
            </div>
        @endif
      </div>
    </div>

    <!-- Support / Help -->
    <button class="hidden sm:block text-slate-400 hover:text-slate-900 transition-colors">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
    </button>

    <div class="w-px h-8 bg-slate-200 hidden sm:block"></div>

    <!-- Quick Action Button -->
    <!-- @if(request()->is('dashboard/admin*'))
      <button class="btn-primary !py-2 !px-4 !text-[10px] hidden lg:block">+ Nouvel Événement</button>
    @elseif(request()->is('dashboard/professeur*'))
      <button class="btn-primary !py-2 !px-4 !text-[10px] hidden lg:block">+ Ajouter un Support</button>
    @elseif(request()->is('dashboard/apprenant*'))
      <button class="btn-primary !py-2 !px-4 !text-[10px] hidden lg:block">Réserver un cours</button>
    @endif -->

    <!-- Profile Dropdown Trigger (Mockup) -->
    <div class="relative" x-data="{ open: false }" @click.away="open = false">
      <button @click="open = !open" class="flex items-center gap-3 text-slate-500 hover:text-slate-900 transition-colors focus:outline-none">
        <div class="w-10 h-10 rounded-full bg-slate-900 text-brand-lime font-bold flex items-center justify-center text-xs tracking-wider border border-brand-lime/30 shadow-sm overflow-hidden">
          @if(Auth::user() && Auth::user()->photo)
            <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Avatar" class="w-full h-full object-cover">
          @else
            {{ Auth::user() ? strtoupper(substr(Auth::user()->prenom, 0, 1) . substr(Auth::user()->nom, 0, 1)) : 'AC' }}
          @endif
        </div>
        <div class="hidden md:flex flex-col text-left">
          <!-- <span class="text-xs font-bold text-slate-900 leading-tight">
            {{ Auth::user() ? Auth::user()->prenom . ' ' . Auth::user()->nom : 'Utilisateur' }}
          </span> -->
          <span class="text-[10px] text-slate-400 font-medium uppercase tracking-wider">
            {{ Auth::user() && Auth::user()->profil ? Auth::user()->profil->nom : 'Profil' }}
          </span>
        </div>
        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
      </button>

      <div x-show="open"
           x-transition:enter="transition ease-out duration-200"
           x-transition:enter-start="opacity-0 scale-95"
           x-transition:enter-end="opacity-100 scale-100"
           x-transition:leave="transition ease-in duration-75"
           x-transition:leave-start="opacity-100 scale-100"
           x-transition:leave-end="opacity-0 scale-95"
           class="absolute right-0 mt-2 w-52 bg-white border border-slate-200 shadow-xl z-50 overflow-hidden rounded-sm"
           style="display: none;">
         <div class="divide-y divide-slate-100">
           <div class="px-4 py-3 bg-slate-50">
             <p class="text-xs font-bold text-slate-900 truncate">{{ Auth::user() ? Auth::user()->prenom . ' ' . Auth::user()->nom : '' }}</p>
             <p class="text-[10px] text-slate-500 truncate">{{ Auth::user() ? Auth::user()->email : '' }}</p>
           </div>
           @php
               $profileRoute = '#';
               if (Auth::user() && Auth::user()->profil) {
                   if (Auth::user()->profil->nom === 'administrateur') {
                       $profileRoute = route('dashboard.admin.profile');
                   } elseif (Auth::user()->profil->nom === 'apprenant') {
                       $profileRoute = route('dashboard.apprenant.profile');
                   } elseif (Auth::user()->profil->nom === 'professeur') {
                       $profileRoute = route('dashboard.professeur.profile');
                   }
               }
           @endphp
           <a href="{{ $profileRoute }}" class="block px-4 py-3 text-xs text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-bold uppercase tracking-widest">Mon Profil</a>
           <form method="POST" action="{{ route('logout') }}" id="logout-form" class="hidden">
             @csrf
           </form>
           <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block px-4 py-3 text-xs text-red-600 hover:text-red-700 hover:bg-red-50 font-bold uppercase tracking-widest">Déconnexion</a>
         </div>
      </div>
    </div>
  </div>
</header>
