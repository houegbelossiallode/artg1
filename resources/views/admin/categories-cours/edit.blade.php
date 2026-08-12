@extends('layouts.dashboard')

@section('title', 'Modifier Catégorie de Cours | AssoCulture')

@section('content')
<div class="space-y-6">
  <!-- En-tête -->
  <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 pb-4 border-b border-slate-200">
    <h1 class="admin-title">Modifier la Catégorie de Cours</h1>
  </div>

  <div class="bg-white border border-slate-200 shadow-sm rounded-none p-6">
    <form action="{{ route('dashboard.admin.categories-cours.update', $category->id) }}" method="POST" class="space-y-4">
      @csrf
      @method('PUT')
      <div>
        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Nom <span class="text-red-500">*</span></label>
        <input type="text" name="nom" value="{{ old('nom', $category->nom) }}" required class="w-full px-4 py-2.5 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none">
      </div>

      <div>
        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Description</label>
        <textarea name="description" rows="3" class="w-full px-4 py-2.5 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none" placeholder="Description de la catégorie...">{{ old('description', $category->description) }}</textarea>
      </div>

      <div class="flex justify-end gap-3 pt-4">
        <a href="{{ route('dashboard.admin.categories-cours.index') }}" class="px-4 py-2 text-xs uppercase font-bold tracking-wider text-slate-600 hover:bg-slate-100 transition-colors rounded-none">Annuler</a>
        <button type="submit" class="px-4 py-2 text-xs uppercase font-bold tracking-wider bg-[#0BA20B] hover:bg-[#0BA20B]-light text-white transition-colors rounded-none">Mettre à jour</button>
      </div>
    </form>
  </div>
</div>
@endsection
