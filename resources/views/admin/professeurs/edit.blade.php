@extends('layouts.dashboard')

@section('title', "Modifier le Professeur | AssoCulture")

@section('content')
<div class="space-y-6">

  {{-- Header --}}
  <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 pb-4 border-b border-slate-200">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
        <a href="{{ route('dashboard.admin.professeurs.index') }}" class="hover:text-slate-900 transition-colors">Corps Enseignant</a>
        <span>/</span>
        <span class="text-slate-700 font-bold">Modifier Professeur</span>
      </div>
      <h1 class="admin-title">Modifier Un Professeur</h1>
      <p class="admin-subtitle">Mettez à jour les informations du professeur. Un email de confirmation peut être envoyé.</p>
    </div>
    <a href="{{ route('dashboard.admin.professeurs.index') }}"
       class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold text-[10px] uppercase tracking-widest transition shadow-sm">
      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
      Retour à la liste
    </a>
  </div>

  {{-- Flash Errors --}}
  @if ($errors->any())
    <div class="p-4 bg-red-50 border border-l-4 border-l-red-600 border-red-200 text-red-800 text-xs shadow-sm">
      <p class="font-bold mb-1">Veuillez corriger les erreurs suivantes :</p>
      <ul class="list-disc pl-4 space-y-0.5">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  {{-- Form --}}
  <div class="bg-white border border-slate-200 shadow-sm">
    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex items-center gap-3">
      <div class="w-7 h-7 bg-[#0BA20B] flex items-center justify-center shrink-0">
        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
      </div>
      <div>
        <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wide font-sans">Informations du Professeur</h2>
        <p class="text-[11px] text-slate-400">Corps enseignant · Arts &amp; Culture</p>
      </div>
    </div>

    <form action="{{ route('dashboard.admin.professeurs.update', $professeur->id) }}" method="POST" class="p-6 space-y-6">
      @csrf
      @method('PUT')

      {{-- Identité --}}
      <div>
        <h3 class="text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-3 pb-2 border-b border-slate-100 font-sans">Identité</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Nom <span class="text-red-500">*</span></label>
            <input type="text" name="nom" value="{{ old('nom', $professeur->nom) }}" required
                   class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-[#0BA20B] transition @error('nom') border-red-400 bg-red-50 @enderror"
                   placeholder="Nom de famille">
            @error('nom')<p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>@enderror
          </div>
          <div>
            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Prénom <span class="text-red-500">*</span></label>
            <input type="text" name="prenom" value="{{ old('prenom', $professeur->prenom) }}" required
                   class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-[#0BA20B] transition @error('prenom') border-red-400 bg-red-50 @enderror"
                   placeholder="Prénom">
            @error('prenom')<p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>@enderror
          </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
          <div>
            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Genre <span class="text-red-500">*</span></label>
            <select name="sexe" required class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-[#0BA20B] transition @error('sexe') border-red-400 bg-red-50 @enderror">
              <option value="M" {{ old('sexe', $professeur->sexe) == 'M' ? 'selected' : '' }}>Masculin</option>
              <option value="F" {{ old('sexe', $professeur->sexe) == 'F' ? 'selected' : '' }}>Féminin</option>
            </select>
            @error('sexe')<p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>@enderror
          </div>
          <div>
            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Date de Naissance <span class="text-red-500">*</span></label>
            <input type="date" name="date_naissance" value="{{ old('date_naissance', $professeur->date_naissance) }}" required
                   class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-[#0BA20B] transition @error('date_naissance') border-red-400 bg-red-50 @enderror">
            @error('date_naissance')<p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>@enderror
          </div>
        </div>
      </div>

      {{-- Coordonnées --}}
      <div>
        <h3 class="text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-3 pb-2 border-b border-slate-100 font-sans">Coordonnées</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Téléphone <span class="text-red-500">*</span></label>
            <input type="tel" name="telephone" value="{{ old('telephone', $professeur->telephone) }}" required
                   class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-[#0BA20B] transition @error('telephone') border-red-400 bg-red-50 @enderror"
                   placeholder="+229 00 00 00 00">
            @error('telephone')<p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>@enderror
          </div>
          <div>
            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Adresse <span class="text-red-500">*</span></label>
            <input type="text" name="adresse" value="{{ old('adresse', $professeur->adresse) }}" required
                   class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-[#0BA20B] transition @error('adresse') border-red-400 bg-red-50 @enderror"
                   placeholder="Ville / Commune">
            @error('adresse')<p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>@enderror
          </div>
        </div>
      </div>

      {{-- Accès & Sécurité --}}
      <div>
        <h3 class="text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-3 pb-2 border-b border-slate-100 font-sans">Accès &amp; Sécurité</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Adresse Email <span class="text-red-500">*</span></label>
            <input type="email" name="email" value="{{ old('email', $professeur->email) }}" required
                   class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-[#0BA20B] transition @error('email') border-red-400 bg-red-50 @enderror"
                   placeholder="professeur@assoculture.com">
            @error('email')<p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>@enderror
          </div>
          <div>
            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Nouveau Mot de passe</label>
            <input type="password" name="password"
                   class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-[#0BA20B] transition @error('password') border-red-400 bg-red-50 @enderror"
                   placeholder="Laisser vide pour garder l'actuel">
            @error('password')<p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>@enderror
          </div>
        </div>
      </div>

      {{-- Profil Artistique --}}
      <div>
        <h3 class="text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-3 pb-2 border-b border-slate-100 font-sans">Profil Artistique</h3>
        <div>
          <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Biographie / Spécialité Artistique</label>
          <textarea name="biographie" rows="4"
                    class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-[#0BA20B] transition resize-none"
                    placeholder="Présentation du professeur, domaine artistique, parcours pédagogique...">{{ old('biographie', $professeur->biographie) }}</textarea>
        </div>
      </div>

      {{-- Actions --}}
      <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
        <a href="{{ route('dashboard.admin.professeurs.index') }}"
           class="px-5 py-2 text-xs font-bold uppercase tracking-wider text-slate-500 hover:text-slate-900 hover:bg-slate-100 border border-transparent hover:border-slate-200 transition">Annuler</a>
        <button type="submit"
                class="px-6 py-2 bg-[#0BA20B] hover:bg-[#087A08] text-white font-bold text-xs uppercase tracking-widest transition shadow-sm flex items-center gap-2">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
          Mettre à Jour
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
