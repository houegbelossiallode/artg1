@extends('layouts.dashboard')

@section('title', 'Modifier l\'Association | AssoCulture')

@section('content')
<div class="space-y-6">

  {{-- ═══════════════════════ EN-TÊTE ═══════════════════════ --}}
  <div class="bg-white border border-slate-200 shadow-sm px-6 py-5 border-l-4 border-l-amber-500 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
        <a href="{{ route('dashboard.admin.associations.index') }}" class="hover:text-slate-900 transition-colors">Informations & Siège</a>
        <span>/</span>
        <span class="text-slate-700 font-bold">Modifier</span>
      </div>
      <h1 class="text-lg font-bold text-slate-900 uppercase tracking-wide">MODIFIER — {{ strtoupper($association->nom) }}</h1>
      <p class="text-slate-400 text-sm mt-0.5">Mettez à jour les informations, la mission, la vision et les coordonnées du siège.</p>
    </div>
    <a href="{{ route('dashboard.admin.associations.index') }}"
       class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold text-[10px] uppercase tracking-widest transition shadow-sm">
      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
      Retour à la liste
    </a>
  </div>

  {{-- Flash Erreurs --}}
  @if ($errors->any())
    <div class="p-4 bg-red-50 border border-l-4 border-l-red-600 border-red-200 text-red-800 text-xs shadow-sm">
      <p class="font-bold mb-1">Veuillez corriger les erreurs suivantes :</p>
      <ul class="list-disc pl-4 space-y-0.5">
        @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('dashboard.admin.associations.update', $association->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')

    {{-- ══ IDENTITÉ & LOGO ══ --}}
    <div class="bg-white border border-slate-200 shadow-sm">
      <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex items-center gap-3">
        <div class="w-7 h-7 bg-amber-500 flex items-center justify-center shrink-0">
          <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
          </svg>
        </div>
        <div>
          <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wide">Identité de l'Association</h2>
          <p class="text-[11px] text-slate-400">Nom officiel et logo</p>
        </div>
      </div>
      <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Nom de l'Association <span class="text-red-500">*</span></label>
          <input type="text" name="nom" value="{{ old('nom', $association->nom) }}" required
            class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-amber-500 transition @error('nom') border-red-400 bg-red-50 @enderror">
          @error('nom')<p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Logo actuel / Modifier</label>
          @if($association->logo)
            <div class="flex items-center gap-3 mb-2">
              <img src="{{ asset('storage/' . $association->logo) }}" alt="Logo actuel" class="w-12 h-12 object-cover border border-slate-200">
              <span class="text-[11px] text-slate-400">Logo actuel. Choisissez un fichier pour le remplacer.</span>
            </div>
          @endif
          <input type="file" name="logo" accept="image/*"
            class="w-full px-3 py-1.5 text-xs bg-slate-50 border border-slate-300 focus:outline-none focus:border-amber-500 transition cursor-pointer">
          @error('logo')<p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>@enderror
        </div>
      </div>
    </div>

    {{-- ══ COORDONNÉES ══ --}}
    <div class="bg-white border border-slate-200 shadow-sm">
      <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex items-center gap-3">
        <div class="w-7 h-7 bg-amber-500 flex items-center justify-center shrink-0">
          <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
          </svg>
        </div>
        <div>
          <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wide">Coordonnées & Siège</h2>
          <p class="text-[11px] text-slate-400">Email, téléphone et adresse physique</p>
        </div>
      </div>
      <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
          <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Email <span class="text-red-500">*</span></label>
          <input type="email" name="email" value="{{ old('email', $association->email) }}" required
            class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-amber-500 transition @error('email') border-red-400 bg-red-50 @enderror">
          @error('email')<p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Téléphone <span class="text-red-500">*</span></label>
          <input type="text" name="telephone" value="{{ old('telephone', $association->telephone) }}" required
            class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-amber-500 transition @error('telephone') border-red-400 bg-red-50 @enderror">
          @error('telephone')<p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Adresse <span class="text-red-500">*</span></label>
          <input type="text" name="adresse" value="{{ old('adresse', $association->adresse) }}" required
            class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-amber-500 transition @error('adresse') border-red-400 bg-red-50 @enderror">
          @error('adresse')<p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>@enderror
        </div>
      </div>
    </div>

    {{-- ══ RÉSEAUX SOCIAUX ══ --}}
    <div class="bg-white border border-slate-200 shadow-sm">
      <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex items-center gap-3">
        <div class="w-7 h-7 bg-amber-500 flex items-center justify-center shrink-0">
          <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
          </svg>
        </div>
        <div>
          <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wide">Présence en Ligne</h2>
          <p class="text-[11px] text-slate-400">Réseaux sociaux et site web (optionnels)</p>
        </div>
      </div>
      <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Facebook</label>
          <input type="text" name="facebook" value="{{ old('facebook', $association->facebook) }}"
            class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-amber-500 transition"
            placeholder="https://facebook.com/assoculture">
        </div>
        <div>
          <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Instagram</label>
          <input type="text" name="instagram" value="{{ old('instagram', $association->instagram) }}"
            class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-amber-500 transition"
            placeholder="https://instagram.com/assoculture">
        </div>
        <div>
          <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">YouTube</label>
          <input type="text" name="youtube" value="{{ old('youtube', $association->youtube) }}"
            class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-amber-500 transition"
            placeholder="https://youtube.com/@assoculture">
        </div>
        <div>
          <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Site Web</label>
          <input type="text" name="site_web" value="{{ old('site_web', $association->site_web) }}"
            class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-amber-500 transition"
            placeholder="https://assoculture.org">
        </div>
      </div>
    </div>

    {{-- ══ PRÉSENTATION NARRATIVE ══ --}}
    <div class="bg-white border border-slate-200 shadow-sm">
      <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex items-center gap-3">
        <div class="w-7 h-7 bg-amber-500 flex items-center justify-center shrink-0">
          <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
          </svg>
        </div>
        <div>
          <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wide">Présentation Narrative</h2>
          <p class="text-[11px] text-slate-400">Description, mission, vision et historique de l'association</p>
        </div>
      </div>
      <div class="p-6 space-y-4">
        <div>
          <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Description Globale</label>
          <textarea name="description" rows="3"
            class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-amber-500 transition resize-none"
            placeholder="Présentation synthétique...">{{ old('description', $association->description) }}</textarea>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div>
            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Mission</label>
            <textarea name="mission" rows="4"
              class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-amber-500 transition resize-none"
              placeholder="Notre mission...">{{ old('mission', $association->mission) }}</textarea>
          </div>
          <div>
            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Vision</label>
            <textarea name="vision" rows="4"
              class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-amber-500 transition resize-none"
              placeholder="Notre vision...">{{ old('vision', $association->vision) }}</textarea>
          </div>
          <div>
            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Historique</label>
            <textarea name="historique" rows="4"
              class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-amber-500 transition resize-none"
              placeholder="Notre histoire...">{{ old('historique', $association->historique) }}</textarea>
          </div>
        </div>
      </div>
    </div>

    {{-- ══ ACTIONS ══ --}}
    <div class="flex items-center justify-end gap-3 pb-4">
      <a href="{{ route('dashboard.admin.associations.index') }}"
        class="px-5 py-2 text-xs font-bold uppercase tracking-wider text-slate-500 hover:text-slate-900 hover:bg-slate-100 border border-transparent hover:border-slate-200 transition">
        Annuler
      </a>
      <button type="submit"
        class="px-6 py-2 bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs uppercase tracking-widest transition shadow-sm flex items-center gap-2">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        Mettre à Jour
      </button>
    </div>

  </form>

</div>
@endsection
