@extends('layouts.app')

@section('title', 'Réinitialiser le Mot de passe | AssoCulture')

@section('content')
<div class="space-y-6 max-w-lg mx-auto">
    <div class="bg-white border border-slate-200 shadow-sm px-6 py-5 border-l-4 border-l-lime-500">
        <h1 class="text-lg font-bold text-slate-900 uppercase tracking-wide">Réinitialisation du mot de passe</h1>
        <p class="text-slate-400 text-sm mt-0.5">Entrez votre nouveau mot de passe.</p>
    </div>

    @if (session('status'))
        <div class="p-4 bg-lime-50 border border-l-4 border-l-lime-600 text-lime-800 text-sm rounded">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}" class="bg-white border border-slate-200 shadow-sm p-6 space-y-4">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <div>
            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5" for="email">Adresse Email</label>
            <input id="email" type="email" name="email" required value="{{ old('email', $request->email) }}"
                class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-lime-500 transition @error('email') border-red-400 bg-red-50 @enderror">
            @error('email')
                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5" for="password">Nouveau mot de passe</label>
            <input id="password" type="password" name="password" required
                class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-lime-500 transition @error('password') border-red-400 bg-red-50 @enderror">
            @error('password')
                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5" for="password_confirmation">Confirmer le mot de passe</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required
                class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-lime-500 transition">
        </div>
        <div class="flex items-center justify-between">
            <a href="{{ route('login') }}" class="text-sm text-slate-500 hover:text-slate-900">← Retour à la connexion</a>
            <button type="submit" class="px-6 py-2 bg-lime-500 hover:bg-lime-600 text-white font-bold text-xs uppercase tracking-widest transition shadow-sm flex items-center gap-2">
                Réinitialiser le mot de passe
            </button>
        </div>
    </form>
</div>
@endsection
