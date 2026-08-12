@extends('layouts.dashboard')

@section('title', 'Nouvelle Catégorie de Talent | AssoCulture')

@section('content')
<div class="space-y-6">
  <!-- En-tête -->
  <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 pb-4 border-b border-slate-200">
    <h1 class="admin-title">Nouvelle Catégorie de Talent</h1>
  </div>

  <div class="bg-white border border-slate-200 shadow-sm rounded-none p-6">
    <form action="{{ route('dashboard.admin.categories-talents.store') }}" method="POST" class="space-y-4">
      @csrf
      <div>
        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Libellé <span class="text-red-500">*</span></label>
        <input type="text" name="nom" required class="w-full px-4 py-2.5 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none">
      </div>

      <div class="flex justify-end gap-3 pt-4">
        <a href="{{ route('dashboard.admin.categories-talents.index') }}" class="px-4 py-2 text-xs uppercase font-bold tracking-wider text-slate-600 hover:bg-slate-100 transition-colors rounded-none">Annuler</a>
        <button type="submit" class="px-4 py-2 text-xs uppercase font-bold tracking-wider bg-[#0BA20B] hover:bg-[#0BA20B]-light text-white transition-colors rounded-none">Enregistrer</button>
      </div>
    </form>
  </div>
</div>
@endsection
