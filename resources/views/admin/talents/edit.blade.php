@extends('layouts.dashboard')

@section('title', 'Modifier Talent | AssoCulture')

@section('content')
<div class="space-y-6">
  
  <!-- Flash Messages -->
  @if (session('success'))
    <div class="p-4 bg-emerald-50 border-l-4 border-emerald-600 text-emerald-800 text-xs shadow-sm flex items-center justify-between">
      <span>{{ session('success') }}</span>
      <button onclick="this.parentElement.remove()" class="text-emerald-600 font-bold ml-4">&times;</button>
    </div>
  @endif

  @if ($errors->any())
    <div class="p-4 bg-red-50 border-l-4 border-l-red-600 border-red-200 text-red-800 text-xs shadow-sm">
      <p class="font-bold mb-1">Veuillez corriger les erreurs suivantes :</p>
      <ul class="list-disc pl-4 space-y-0.5">
        @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
      </ul>
    </div>
  @endif

  <!-- En-tête -->
  <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 pb-4 border-b border-slate-200">
    <div>
      <h1 class="admin-title">Modifier le Talent</h1>
      <p class="admin-subtitle">Mettez à jour les informations du talent.</p>
    </div>
    <div class="flex flex-wrap items-center gap-2">
      <a href="{{ route('dashboard.admin.talents.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-[10px] uppercase tracking-widest transition shadow-sm cursor-pointer">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        RETOUR
      </a>
    </div>
  </div>

  <!-- Formulaire -->
  <div class="bg-white border border-slate-200 shadow-sm rounded-none">
    <form action="{{ route('dashboard.admin.talents.update', $talent->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
      @csrf
      @method('PUT')
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Nom <span class="text-red-500">*</span></label>
          <input type="text" name="nom" value="{{ old('nom', $talent->nom) }}" required class="w-full px-4 py-2.5 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none">
          @error('nom') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Prénom <span class="text-red-500">*</span></label>
          <input type="text" name="prenom" value="{{ old('prenom', $talent->prenom) }}" required class="w-full px-4 py-2.5 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none">
          @error('prenom') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
      </div>

      <div>
        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Catégorie de Talent <span class="text-red-500">*</span></label>
        <select name="categorie_talent_id" required class="w-full px-4 py-2.5 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none bg-white">
          <option value="">Sélectionner une catégorie</option>
          @foreach($categories as $catT)
            <option value="{{ $catT->id }}" {{ old('categorie_talent_id', $talent->categorie_talent_id) == $catT->id ? 'selected' : '' }}>{{ $catT->libelle }}</option>
          @endforeach
        </select>
        @error('categorie_talent_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Biographie / Description</label>
        <textarea name="biographie" rows="4" class="w-full px-4 py-2.5 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none" placeholder="Parcours et œuvre de l'artiste...">{{ old('biographie', $talent->biographie) }}</textarea>
        @error('biographie') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Téléphone</label>
          <input type="tel" name="telephone" value="{{ old('telephone', $talent->telephone) }}" class="w-full px-4 py-2.5 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none">
          @error('telephone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Email</label>
          <input type="email" name="email" value="{{ old('email', $talent->email) }}" class="w-full px-4 py-2.5 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none">
          @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Lien Facebook</label>
          <input type="url" name="facebook" value="{{ old('facebook', $talent->facebook) }}" class="w-full px-4 py-2.5 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none" placeholder="https://facebook.com/...">
          @error('facebook') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Lien Instagram</label>
          <input type="url" name="instagram" value="{{ old('instagram', $talent->instagram) }}" class="w-full px-4 py-2.5 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none" placeholder="https://instagram.com/...">
          @error('instagram') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Lien YouTube (Démo)</label>
          <input type="url" name="youtube" value="{{ old('youtube', $talent->youtube) }}" class="w-full px-4 py-2.5 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none" placeholder="https://youtube.com/...">
          @error('youtube') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Numéro WhatsApp</label>
          <input type="tel" name="whatsapp" value="{{ old('whatsapp', $talent->whatsapp) }}" class="w-full px-4 py-2.5 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none" placeholder="Ex: +241...">
          @error('whatsapp') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
      </div>

      <div class="p-4 bg-slate-50 border border-slate-200">
        <label class="flex items-center gap-3 cursor-pointer">
          <input type="checkbox" name="actif" value="OUI" {{ old('actif', $talent->actif) === 'OUI' ? 'checked' : '' }} class="w-5 h-5 text-slate-900 border-slate-300 rounded-none focus:ring-slate-900">
          <div>
            <span class="block text-sm font-bold text-slate-800">Mettre en avant sur la page d'accueil</span>
            <span class="block text-xs text-slate-500">Si coché, ce talent apparaîtra dans la section "Talent du mois" s'il est le plus récent.</span>
          </div>
        </label>
      </div>

      <div>
        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Photo de profil</label>
        @if($talent->photo)
          <div class="mb-3">
            <img src="{{ asset('storage/' . $talent->photo) }}" alt="Photo actuelle" class="w-20 h-20 object-cover border border-slate-200">
            <p class="text-xs text-slate-400 mt-1">Photo actuelle</p>
          </div>
        @endif
        <input type="file" name="photo" accept="image/*" class="w-full px-4 py-2 text-xs border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none bg-slate-50">
        <p class="text-xs text-slate-400 mt-1">Laissez vide pour conserver la photo actuelle.</p>
        @error('photo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>

      <div class="flex justify-end gap-3 pt-6 border-t border-slate-200">
        <a href="{{ route('dashboard.admin.talents.index') }}" class="px-6 py-2.5 text-xs uppercase font-bold tracking-wider text-slate-600 hover:bg-slate-100 transition-colors rounded-none">Annuler</a>
        <button type="submit" class="btn-primary">Mettre à jour</button>
      </div>
    </form>
  </div>

</div>
@endsection
