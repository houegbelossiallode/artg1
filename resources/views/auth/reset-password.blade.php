@extends('layouts.guest')

@section('title', 'Réinitialiser le Mot de passe | AssoCulture')

@section('content')
<div class="w-full max-w-md bg-[#FAF7F2] border border-[#0BA20B]/30 shadow-2xl overflow-hidden relative z-10 rounded-none p-8 sm:p-10">
    <div class="text-center mb-8">
        <h1 class="font-serif-title font-bold text-3xl text-[#2C221E] tracking-tight">Réinitialisation</h1>
        <p class="text-xs font-light text-[#6B574F] mt-2">Veuillez entrer votre nouveau mot de passe.</p>
    </div>

    @if (session('status'))
        <div class="mb-6 p-4 bg-[#52B788]/10 border-l-2 border-[#52B788] text-[#2D6A4F] text-xs rounded-none">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        
        <!-- Email field -->
        <div>
            <label for="email" class="block text-[10px] font-bold tracking-widest uppercase text-[#5C4A42] mb-2">Adresse Email</label>
            <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email', $request->email) }}" readonly
                class="w-full px-4 py-3 bg-white border @error('email') border-red-500 @else border-[#0BA20B]/40 @enderror text-[#2C221E] text-sm focus:outline-none focus:border-[#0BA20B] focus:ring-1 focus:ring-[#0BA20B] transition-all rounded-none placeholder-[#8C766B]/50">
            @error('email')
                <p class="text-[10px] text-red-600 mt-1 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password field -->
        <div>
            <label for="password" class="block text-[10px] font-bold tracking-widest uppercase text-[#5C4A42] mb-2">Nouveau mot de passe</label>
            <input id="password" name="password" type="password" required
                class="w-full px-4 py-3 bg-white border @error('password') border-red-500 @else border-[#0BA20B]/40 @enderror text-[#2C221E] text-sm focus:outline-none focus:border-[#0BA20B] focus:ring-1 focus:ring-[#0BA20B] transition-all rounded-none placeholder-[#8C766B]/50">
            @error('password')
                <p class="text-[10px] text-red-600 mt-1 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password field -->
        <div>
            <label for="password_confirmation" class="block text-[10px] font-bold tracking-widest uppercase text-[#5C4A42] mb-2">Confirmer le mot de passe</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required
                class="w-full px-4 py-3 bg-white border border-[#0BA20B]/40 text-[#2C221E] text-sm focus:outline-none focus:border-[#0BA20B] focus:ring-1 focus:ring-[#0BA20B] transition-all rounded-none placeholder-[#8C766B]/50">
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full px-6 py-3.5 bg-[#0BA20B] hover:bg-[#087A08] text-white font-bold text-sm tracking-wide uppercase shadow-lg transition-transform hover:-translate-y-0.5 rounded-none flex items-center justify-center gap-2">
                <span>Réinitialiser</span>
                <svg aria-hidden="true" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"></path>
                </svg>
            </button>
        </div>
        
        <div class="mt-6 border-t border-[#0BA20B]/20 pt-4 text-center">
            <a href="{{ route('login') }}" class="text-[10px] font-bold text-[#0BA20B] hover:text-[#087A08] transition-colors uppercase tracking-wider">← Retour à la connexion</a>
        </div>
    </form>
</div>
@endsection
