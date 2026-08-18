@extends('layouts.guest')

@section('title', 'Vérification de votre Email | AssoCulture')

@section('content')
<div class="w-full max-w-md bg-[#FAF7F2] border border-[#0BA20B]/30 shadow-2xl overflow-hidden relative z-10 rounded-none p-8 sm:p-10 text-center">
    
    <div class="w-16 h-16 bg-[#0BA20B]/10 rounded-full flex items-center justify-center mx-auto mb-6">
        <svg aria-hidden="true" class="w-8 h-8 text-[#0BA20B]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
        </svg>
    </div>

    <h1 class="font-serif-title font-bold text-3xl text-[#2C221E] tracking-tight mb-4">Vérifiez votre Email</h1>
    
    <p class="text-sm font-light text-[#6B574F] mb-6 leading-relaxed">
        Merci pour votre inscription ! Avant de commencer, pourriez-vous vérifier votre adresse email en cliquant sur le lien que nous venons de vous envoyer ? 
        Si vous n'avez pas reçu l'email, nous vous en enverrons un autre avec plaisir.
    </p>

    @if (session('message'))
        <div class="mb-6 p-4 bg-[#52B788]/10 border-l-2 border-[#52B788] text-[#2D6A4F] text-xs rounded-none font-bold">
            {{ session('message') }}
        </div>
    @endif

    <div class="flex flex-col gap-4 mt-8">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="w-full px-6 py-3.5 bg-[#0BA20B] hover:bg-[#087A08] text-white font-bold text-sm tracking-wide uppercase shadow-lg transition-transform hover:-translate-y-0.5 rounded-none flex items-center justify-center gap-2">
                <span>Renvoyer l'email</span>
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full px-6 py-3.5 bg-transparent border border-[#0BA20B]/40 text-[#2C221E] hover:bg-[#0BA20B]/10 font-bold text-sm tracking-wide uppercase transition-colors rounded-none">
                Se déconnecter
            </button>
        </form>
    </div>
</div>
@endsection
