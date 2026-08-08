@extends('layouts.app')

@section('title', 'Connexion - AssoCulture')

@section('content')
<div class="min-h-screen pt-36 pb-20 flex items-center justify-center px-4 sm:px-6 lg:px-8 bg-pattern-raphia">
    <div class="max-w-4xl w-full bg-[#FAF7F2] border border-[#D4A373]/30 shadow-2xl flex flex-col md:flex-row overflow-hidden relative z-10 rounded-none">
        
        <!-- Left Side: Cultural/Artistic Branding panel -->
        <div class="md:w-1/2 bg-[#1E1613] text-[#FAF7F2] p-12 flex flex-col justify-between relative overflow-hidden">
            <!-- Background pattern -->
            <div class="absolute inset-0 opacity-10 bg-pattern-raphia pointer-events-none"></div>
            
            <div class="relative z-10">
                <div class="w-12 h-12 border border-[#D4A373] flex items-center justify-center font-display font-bold text-[#D4A373] text-xl tracking-wider mb-8">
                    É&C
                </div>
                <span class="font-sans font-semibold text-xs tracking-widest uppercase text-[#D4A373]">Espace Membre</span>
                <h2 class="font-serif-title font-bold text-3xl md:text-4xl mt-2 tracking-tight leading-tight">
                    Rejoignez le réseau<br>artistique & culturel.
                </h2>
                <p class="text-xs font-light text-[#D1C5B8] leading-relaxed mt-4 max-w-sm">
                    Connectez-vous pour accéder à vos cours, suivre vos réservations, gérer vos événements et partager vos créations.
                </p>
            </div>
            
            <div class="mt-12 relative z-10">
                <p class="text-[10px] tracking-widest uppercase text-[#8C766B] font-bold mb-3">Nos Domaines</p>
                <div class="flex flex-wrap gap-2">
                    <span class="text-[10px] border border-[#D4A373]/40 bg-white/5 py-1 px-3 font-medium rounded-none uppercase tracking-wider text-[#D1C5B8]">Musique</span>
                    <span class="text-[10px] border border-[#D4A373]/40 bg-white/5 py-1 px-3 font-medium rounded-none uppercase tracking-wider text-[#D1C5B8]">Raphia</span>
                    <span class="text-[10px] border border-[#D4A373]/40 bg-white/5 py-1 px-3 font-medium rounded-none uppercase tracking-wider text-[#D1C5B8]">Artisanat</span>
                </div>
            </div>
        </div>

        <!-- Right Side: Form panel -->
        <div class="md:w-1/2 p-12 flex flex-col justify-center bg-[#FAF7F2]">
            <div>
                <h3 class="font-serif-title font-bold text-3xl text-[#2C221E] tracking-tight">Se connecter</h3>
                <p class="text-xs font-light text-[#6B574F] mt-1">Saisissez vos identifiants pour accéder à votre espace sécurisé.</p>
            </div>

            @if (session('success'))
                <div class="mt-6 p-4 bg-[#52B788]/10 border-l-2 border-[#52B788] text-[#2D6A4F] text-xs rounded-none">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="mt-8 space-y-5">
                @csrf
                
                <div class="space-y-4">
                    <!-- Email field -->
                    <div>
                        <label for="email" class="block text-[10px] font-bold tracking-widest uppercase text-[#5C4A42] mb-2">Adresse Email</label>
                        <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                            class="w-full px-4 py-3 bg-white border @error('email') border-red-500 @else border-[#D4A373]/40 @enderror text-[#2C221E] text-sm focus:outline-none focus:border-[#C85A32] focus:ring-1 focus:ring-[#C85A32] transition-all rounded-none placeholder-[#8C766B]/50"
                            placeholder="exemple@email.com">
                        @error('email')
                            <p class="text-[10px] text-red-600 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password field -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label for="password" class="block text-[10px] font-bold tracking-widest uppercase text-[#5C4A42]">Mot de Passe</label>
                            <a href="{{ route('password.request') }}" class="text-[10px] font-bold text-[#C85A32] hover:text-[#A84223] transition-colors uppercase tracking-wider">Mot de passe oublié ?</a>
                        </div>
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            class="w-full px-4 py-3 bg-white border @error('password') border-red-500 @else border-[#D4A373]/40 @enderror text-[#2C221E] text-sm focus:outline-none focus:border-[#C85A32] focus:ring-1 focus:ring-[#C85A32] transition-all rounded-none placeholder-[#8C766B]/50"
                            placeholder="••••••••">
                        @error('password')
                            <p class="text-[10px] text-red-600 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox"
                        class="h-4 w-4 bg-white border-[#D4A373]/40 text-[#C85A32] rounded-none focus:ring-[#C85A32]">
                    <label for="remember" class="ml-2 block text-xs font-medium text-[#6B574F] select-none">
                        Se souvenir de moi
                    </label>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full px-6 py-3.5 bg-[#C85A32] hover:bg-[#A84223] text-white font-bold text-sm tracking-wide uppercase shadow-lg transition-transform hover:-translate-y-0.5 rounded-none flex items-center justify-center gap-2">
                        <span>Connexion</span>
                        <svg aria-hidden="true" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"></path>
                        </svg>
                    </button>
                </div>
            </form>

            <div class="mt-8 pt-6 border-t border-[#D4A373]/20 text-center">
                <p class="text-xs text-[#6B574F] font-light">
                    Vous n'avez pas encore de compte ? 
                    <a href="{{ route('register') }}" class="font-bold text-[#C85A32] hover:text-[#A84223] transition-colors underline underline-offset-4">Créer un compte apprenant</a>
                </p>
            </div>
        </div>

    </div>
</div>
@endsection
