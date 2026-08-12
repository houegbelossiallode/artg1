@extends('layouts.dashboard')

@section('title', 'Modifier Catégorie Galerie | AssoCulture')

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
  <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 pb-4 border-b border-slate-200">
    <div>
      <h1 class="admin-title">Modifier la Catégorie</h1>
      <p class="admin-subtitle">Modifiez les informations de la catégorie.</p>
    </div>
    <div class="flex flex-wrap items-center gap-2">
      <a href="{{ route('dashboard.admin.categories-galeries.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-[10px] uppercase tracking-widest transition shadow-sm cursor-pointer">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        RETOUR
      </a>
    </div>
  </div>

  <!-- Formulaire -->
  <div class="bg-white border border-slate-200 shadow-sm rounded-none">
    <form action="{{ route('dashboard.admin.categories-galeries.update', $category) }}" method="POST" class="p-6 space-y-6">
      @csrf
      @method('PUT')
      
      <div>
        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Libellé <span class="text-red-500">*</span></label>
        <input type="text" name="libelle" value="{{ old('libelle', $category->libelle) }}" required class="w-full px-4 py-2.5 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none">
        @error('libelle') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Description</label>
        <textarea name="description" rows="3" class="w-full px-4 py-2.5 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none" placeholder="Description de la catégorie...">{{ old('description', $category->description) }}</textarea>
        @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Statut <span class="text-red-500">*</span></label>
        <select name="actif" required class="w-full px-4 py-2.5 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none bg-white">
          <option value="OUI" {{ old('actif', $category->actif) == 'OUI' ? 'selected' : '' }}>Actif</option>
          <option value="NON" {{ old('actif', $category->actif) == 'NON' ? 'selected' : '' }}>Inactif</option>
        </select>
        @error('actif') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>

      <div class="flex justify-end gap-3 pt-6 border-t border-slate-200">
        <a href="{{ route('dashboard.admin.categories-galeries.index') }}" class="px-6 py-2.5 text-xs uppercase font-bold tracking-wider text-slate-600 hover:bg-slate-100 transition-colors rounded-none">Annuler</a>
        <button type="submit" class="btn-primary">Mettre à jour</button>
      </div>
    </form>
  </div>

</div>
@endsection
