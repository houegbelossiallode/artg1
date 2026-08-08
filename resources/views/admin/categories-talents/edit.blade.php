@extends('layouts.dashboard')

@section('title', 'Modifier Catégorie de Talent | AssoCulture')

@section('content')
<div class="space-y-6">
  <!-- En-tête -->
  <div class="bg-white border border-slate-200 shadow-sm px-6 py-5 border-l-4 border-l-slate-900">
    <h1 class="text-lg font-bold text-slate-900 uppercase tracking-wide">MODIFIER LA CATÉGORIE DE TALENT</h1>
  </div>

  <div class="bg-white border border-slate-200 shadow-sm rounded-none p-6">
    <form action="{{ route('dashboard.admin.categories-talents.update', $category->id) }}" method="POST" class="space-y-4">
      @csrf
      @method('PUT')
      <div>
        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Libellé <span class="text-red-500">*</span></label>
        <input type="text" name="nom" value="{{ old('nom', $category->libelle) }}" required class="w-full px-4 py-2.5 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none">
      </div>

      <div class="flex justify-end gap-3 pt-4">
        <a href="{{ route('dashboard.admin.categories-talents.index') }}" class="px-4 py-2 text-xs uppercase font-bold tracking-wider text-slate-600 hover:bg-slate-100 transition-colors rounded-none">Annuler</a>
        <button type="submit" class="px-4 py-2 text-xs uppercase font-bold tracking-wider bg-brand-lime hover:bg-brand-lime-light text-slate-900 transition-colors rounded-none">Mettre à jour</button>
      </div>
    </form>
  </div>
</div>
@endsection
