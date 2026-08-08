@extends('layouts.dashboard')

@section('title', 'Modifier Élément Galerie | AssoCulture')

@section('content')
<div class="space-y-6">
  
  <!-- Flash Messages -->
  @if ($errors->any())
    <div class="p-4 bg-red-50 border-l-4 border-l-red-600 border-red-200 text-red-800 text-xs shadow-sm">
      <p class="font-bold mb-1">Veuillez corriger les erreurs suivantes :</p>
      <ul class="list-disc pl-4 space-y-0.5">
        @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
      </ul>
    </div>
  @endif

  <!-- En-tête -->
  <div class="bg-white border border-slate-200 shadow-sm px-6 py-5 border-l-4 border-l-slate-900 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <h1 class="text-lg font-bold text-slate-900 uppercase tracking-wide">MODIFIER L'ÉLÉMENT</h1>
      <p class="text-slate-400 text-sm mt-0.5">Modifiez les informations de l'élément de la médiathèque.</p>
    </div>
    <div class="flex flex-wrap items-center gap-2">
      <a href="{{ route('dashboard.admin.galeries.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-[10px] uppercase tracking-widest transition shadow-sm cursor-pointer">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        RETOUR
      </a>
    </div>
  </div>

  <!-- Formulaire -->
  <div class="bg-white border border-slate-200 shadow-sm rounded-none">
    <form action="{{ route('dashboard.admin.galeries.update', $galerie) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
      @csrf
      @method('PUT')
      
      <div>
        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Titre <span class="text-red-500">*</span></label>
        <input type="text" name="titre" value="{{ old('titre', $galerie->titre) }}" required class="w-full px-4 py-2.5 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none">
        @error('titre') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Description</label>
        <textarea name="description" rows="3" class="w-full px-4 py-2.5 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none" placeholder="Description de l'élément...">{{ old('description', $galerie->description) }}</textarea>
        @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Catégorie <span class="text-red-500">*</span></label>
        <select name="categorie_galerie_id" required class="w-full px-4 py-2.5 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none bg-white">
          <option value="">Sélectionner une catégorie</option>
          @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ old('categorie_galerie_id', $galerie->categorie_galerie_id) == $cat->id ? 'selected' : '' }}>{{ $cat->libelle }}</option>
          @endforeach
        </select>
        @error('categorie_galerie_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>

      @if($galerie->fichier)
        <div class="p-4 bg-slate-50 border border-slate-200">
          <p class="text-xs font-bold text-slate-700 mb-2">Fichier actuel :</p>
          @if($galerie->categorie && $galerie->categorie->slug == 'videos')
            <video src="{{ asset('storage/' . $galerie->fichier) }}" class="w-48 h-32 object-cover" controls></video>
          @elseif($galerie->categorie && $galerie->categorie->slug == 'photos')
            <img src="{{ asset('storage/' . $galerie->fichier) }}" alt="{{ $galerie->titre }}" class="w-48 h-32 object-cover">
          @else
            <p class="text-xs text-slate-600">{{ $galerie->fichier }}</p>
          @endif
        </div>
      @endif

      <div>
        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Fichier</label>
        <input type="file" name="fichier" accept="image/*,video/*,audio/*" class="w-full px-4 py-2 text-xs border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none bg-slate-50">
        <p class="text-xs text-slate-400 mt-1">Laissez vide pour conserver le fichier actuel. Formats acceptés: JPG, PNG, GIF, MP4, WebM, MP3, WAV. Max 10 Mo.</p>
        @error('fichier') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>

      <div class="flex justify-end gap-3 pt-6 border-t border-slate-200">
        <a href="{{ route('dashboard.admin.galeries.index') }}" class="px-6 py-2.5 text-xs uppercase font-bold tracking-wider text-slate-600 hover:bg-slate-100 transition-colors rounded-none">Annuler</a>
        <button type="submit" class="px-6 py-2.5 text-xs uppercase font-bold tracking-wider bg-slate-900 hover:bg-slate-800 text-amber-500 transition-colors rounded-none">Mettre à jour</button>
      </div>
    </form>
  </div>

</div>
@endsection
