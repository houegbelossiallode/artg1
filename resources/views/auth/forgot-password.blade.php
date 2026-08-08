@extends('layouts.app')

@section('title', 'Mot de passe oublié | AssoCulture')

@section('content')
<div class="min-h-screen pt-36 pb-20 flex items-center justify-center px-4 sm:px-6 lg:px-8">
  <div class="max-w-4xl w-full bg-white border border-slate-100 shadow-2xl flex flex-col md:flex-row overflow-hidden relative z-10 rounded-sm">
    <!-- Left Side: branding panel (same as login) -->
    <div class="md:w-1/2 bg-slate-900 text-white p-12 flex flex-col justify-between relative overflow-hidden">
      <div class="absolute -top-40 -left-40 w-96 h-96 rounded-full bg-brand-lime/20 blur-3xl"></div>
      <div class="absolute -bottom-40 -right-40 w-96 h-96 rounded-full bg-brand-lime/10 blur-3xl"></div>
      <div class="relative z-10">
        <div class="w-12 h-12 border border-white flex items-center justify-center font-serif-heading font-bold text-white text-xl tracking-wider mb-8">AC</div>
        <span class="font-serif-heading font-semibold text-xs tracking-widest uppercase text-brand-lime">Espace Membre</span>
        <h2 class="font-serif-heading font-bold text-3xl mt-2 tracking-wide leading-tight">Rejoignez le mouvement culturel &amp; artistique.</h2>
        <p class="text-xs font-light text-slate-300 leading-relaxed mt-4 max-w-sm">Connectez-vous pour accéder à vos cours, suivre vos réservations, gérer vos événements et partager vos créations.</p>
      </div>
      <div class="mt-12 relative z-10">
        <p class="text-[10px] tracking-widest uppercase text-slate-400 font-bold mb-2">Nos Actions</p>
        <div class="flex flex-wrap gap-2">
          <span class="text-[10px] border border-slate-700 px-3 py-1 font-medium rounded-full uppercase tracking-wider text-slate-300">Raphia</span>
          <span class="text-[10px] border border-slate-700 px-3 py-1 font-medium rounded-full uppercase tracking-wider text-slate-300">Musique</span>
          <span class="text-[10px] border border-slate-700 px-3 py-1 font-medium rounded-full uppercase tracking-wider text-slate-300">Artisanat</span>
        </div>
      </div>
    </div>
    <!-- Right Side: form panel -->
    <div class="md:w-1/2 p-12 flex flex-col justify-center">
      <div>
        <h3 class="font-serif-heading font-bold text-2xl text-slate-900 tracking-wide">Réinitialiser le mot de passe</h3>
        <p class="text-xs font-light text-slate-500 mt-1">Entrez votre adresse email et nous vous enverrons un lien de réinitialisation.</p>
      </div>

      @if (session('status'))
        <div class="mt-6 p-4 bg-lime-50 border-l-4 border-lime-600 text-lime-800 text-sm rounded">{{ session('status') }}</div>
      @endif

      <form method="POST" action="{{ route('password.email') }}" class="mt-8 space-y-6">
        @csrf
        <div class="space-y-4">
          <label for="email" class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Adresse Email <span class="text-red-500">*</span></label>
          <input id="email" type="email" name="email" required
                 class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-lime-500 transition @error('email') border-red-400 bg-red-50 @enderror"
                 placeholder="votre@email.com" value="{{ old('email') }}">
          @error('email')
            <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
          @enderror
        </div>
        <div class="flex items-center justify-between">
          <a href="{{ route('login') }}" class="text-sm text-slate-500 hover:text-slate-900">← Retour à la connexion</a>
          <button type="submit" class="px-6 py-2 bg-lime-500 hover:bg-lime-600 text-white font-bold text-xs uppercase tracking-widest transition shadow-sm flex items-center gap-2">Envoyer le lien</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
