@extends('layouts.dashboard')

@section('title', 'Mon Profil | Espace Professeur')

@section('content')
<div class="space-y-6">

  <!-- En-tête -->
  <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 pb-4 border-b border-slate-200">
    <div>
      <h1 class="admin-title">Mon Profil</h1>
      <p class="admin-subtitle">Gérez vos informations personnelles et paramètres de connexion.</p>
    </div>
  </div>

  <!-- @if (session('success'))
    <div class="p-4 bg-emerald-50 border-l-4 border-[#0BA20B] text-[#0BA20B] text-xs font-bold uppercase tracking-wider shadow-sm flex items-center justify-between rounded-none">
      <span>{{ session('success') }}</span>
      <button onclick="this.parentElement.remove()" class="text-[#0BA20B] font-bold ml-4">&times;</button>
    </div>
  @endif

  @if ($errors->any())
    <div class="p-4 bg-red-50 border-l-4 border-red-500 text-red-700 text-xs shadow-sm rounded-none">
      <ul class="list-disc list-inside">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif -->

  <!-- Formulaire Profil -->
  <div class="bg-white border border-slate-200 shadow-sm rounded-none relative overflow-hidden">
    <!-- Décoration Bento -->
    <div class="absolute -right-16 -top-16 w-48 h-48 bg-[#0BA20B]/5 rotate-12 pointer-events-none"></div>

    <form action="{{ route('dashboard.professeur.profile.update') }}" method="POST" enctype="multipart/form-data" class="relative z-10">
      @csrf
      @method('PUT')
      
      <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex flex-col md:flex-row items-start md:items-center gap-6">
        <div class="w-24 h-24 bg-slate-200 border-2 border-white shadow-md rounded-none overflow-hidden shrink-0 flex items-center justify-center relative group">
          @if($user->photo)
            <img src="{{ asset('storage/' . $user->photo) }}" alt="Photo de profil" class="w-full h-full object-cover">
          @else
            <span class="text-3xl text-slate-400 font-bold tracking-tighter">{{ strtoupper(substr($user->prenom, 0, 1) . substr($user->nom, 0, 1)) }}</span>
          @endif
          
          <div class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
          </div>
          <input type="file" name="photo" class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*">
        </div>
        <div>
          <h2 class="text-lg font-bold text-slate-900 font-sans tracking-tight">{{ $user->prenom }} {{ $user->nom }}</h2>
          <p class="text-xs text-slate-500 font-mono uppercase tracking-widest mt-1">Professeur</p>
          <p class="text-[10px] text-slate-400 mt-2">Cliquez sur l'image pour modifier votre photo.</p>
        </div>
      </div>

      <div class="p-6 md:p-8 space-y-8">
        <!-- Informations Générales -->
        <div>
          <h3 class="text-xs font-bold uppercase tracking-widest text-[#0BA20B] mb-4 flex items-center gap-2">
            <span class="w-2 h-2 bg-[#0BA20B] block"></span>
            Informations Générales
          </h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1">Prénom *</label>
              <input type="text" name="prenom" value="{{ old('prenom', $user->prenom) }}" required class="w-full px-4 py-2.5 text-sm border border-slate-300 focus:border-[#0BA20B] focus:ring-0 focus:outline-none rounded-none transition-colors bg-white">
            </div>
            <div>
              <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1">Nom *</label>
              <input type="text" name="nom" value="{{ old('nom', $user->nom) }}" required class="w-full px-4 py-2.5 text-sm border border-slate-300 focus:border-[#0BA20B] focus:ring-0 focus:outline-none rounded-none transition-colors bg-white">
            </div>
            <div>
              <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1">Email *</label>
              <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-2.5 text-sm border border-slate-300 focus:border-[#0BA20B] focus:ring-0 focus:outline-none rounded-none transition-colors bg-slate-50">
            </div>
            <div>
              <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1">Sexe</label>
              <select name="sexe" class="w-full px-4 py-2.5 text-sm border border-slate-300 focus:border-[#0BA20B] focus:ring-0 focus:outline-none rounded-none transition-colors bg-white">
                <option value="">Sélectionnez...</option>
                <option value="H" {{ old('sexe', $user->sexe) == 'H' ? 'selected' : '' }}>Homme</option>
                <option value="F" {{ old('sexe', $user->sexe) == 'F' ? 'selected' : '' }}>Femme</option>
              </select>
            </div>
          </div>
        </div>

        <hr class="border-slate-100">

        <!-- Coordonnées -->
        <div>
          <h3 class="text-xs font-bold uppercase tracking-widest text-[#0BA20B] mb-4 flex items-center gap-2">
            <span class="w-2 h-2 bg-[#0BA20B] block"></span>
            Coordonnées
          </h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1">Téléphone</label>
              <input type="text" name="telephone" value="{{ old('telephone', $user->telephone) }}" class="w-full px-4 py-2.5 text-sm border border-slate-300 focus:border-[#0BA20B] focus:ring-0 focus:outline-none rounded-none transition-colors bg-white">
            </div>
            <div>
              <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1">Adresse Complète</label>
              <input type="text" name="adresse" value="{{ old('adresse', $user->adresse) }}" class="w-full px-4 py-2.5 text-sm border border-slate-300 focus:border-[#0BA20B] focus:ring-0 focus:outline-none rounded-none transition-colors bg-white">
            </div>
          </div>
        </div>

        <hr class="border-slate-100">

        <!-- Sécurité -->
        <div>
          <h3 class="text-xs font-bold uppercase tracking-widest text-slate-700 mb-4 flex items-center gap-2">
            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            Sécurité & Mot de passe
          </h3>
          <p class="text-[10px] text-slate-400 mb-4 uppercase tracking-wider">Laissez vide si vous ne souhaitez pas modifier votre mot de passe.</p>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1">Nouveau mot de passe</label>
              <input type="password" name="password" class="w-full px-4 py-2.5 text-sm border border-slate-300 focus:border-slate-900 focus:ring-0 focus:outline-none rounded-none transition-colors bg-white">
            </div>
            <div>
              <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1">Confirmer le mot de passe</label>
              <input type="password" name="password_confirmation" class="w-full px-4 py-2.5 text-sm border border-slate-300 focus:border-slate-900 focus:ring-0 focus:outline-none rounded-none transition-colors bg-white">
            </div>
          </div>
        </div>

      </div>

      <div class="p-6 bg-slate-50 border-t border-slate-100 flex justify-end">
        <button type="submit" class="btn-primary flex items-center gap-2">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
          ENREGISTRER LES MODIFICATIONS
        </button>
      </div>

    </form>
  </div>
</div>
@endsection
