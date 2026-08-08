@extends('layouts.dashboard')

@section('title', 'Supports de Cours')

@section('content')
{{-- ═══ Tout le contenu ET les modals doivent être dans le même x-data ═══ --}}
<div class="w-full flex flex-col gap-5" x-data="{
    showSupportModal: false,
    showEditModal: false,
    editId: null,
    editCours: '',
    openEdit(id, cours_id) {
        this.editId = id;
        this.editCours = String(cours_id);
        this.showEditModal = true;
    }
}">

  {{-- ═══════════════════════ FLASH MESSAGES ═══════════════════════ --}}
  @if (session('success'))
    <div class="p-4 bg-emerald-50 border border-l-4 border-l-emerald-600 border-emerald-200 text-emerald-800 text-xs flex items-center justify-between shadow-sm">
      <div class="flex items-center gap-2">
        <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span>{{ session('success') }}</span>
      </div>
      <button @click="$el.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800 font-bold text-xl leading-none">&times;</button>
    </div>
  @endif

  @if ($errors->any())
    <div class="p-4 bg-red-50 border border-l-4 border-l-red-600 border-red-200 text-red-800 text-xs shadow-sm">
      <p class="font-bold mb-1">Veuillez corriger les erreurs suivantes :</p>
      <ul class="list-disc pl-4 space-y-0.5">
        @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
      </ul>
    </div>
  @endif

  {{-- ═══════════════════════ PAGE HEADER ═══════════════════════ --}}
  <div class="bg-white border border-slate-200 shadow-sm px-6 py-5 border-l-4 border-l-slate-900 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <h1 class="text-lg font-bold text-slate-900 uppercase tracking-wide">SUPPORTS DE COURS</h1>
      <p class="text-slate-400 text-sm mt-0.5">Gérez les fichiers et ressources rattachés à vos cours.</p>
    </div>
    <button @click="showSupportModal = true"
      class="inline-flex items-center gap-1.5 px-4 py-2 bg-brand-lime text-slate-900 font-bold text-[10px] uppercase tracking-widest hover:brightness-105 transition shadow-sm cursor-pointer">
      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
      + SUPPORT
    </button>
  </div>

  {{-- ═══════════════════════ TABLEAU SUPPORTS ═══════════════════════ --}}
  <div class="bg-white border border-slate-200 shadow-sm">
    <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
      <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wide">LISTE DES SUPPORTS</h2>
      <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $supports->count() }} support(s)</span>
    </div>

    <table class="w-full text-left">
      <thead>
        <tr class="border-b border-slate-200 bg-slate-50">
          <th class="px-6 py-3 text-[9px] font-bold text-slate-400 uppercase tracking-widest">COURS</th>
          <th class="px-4 py-3 text-[9px] font-bold text-slate-400 uppercase tracking-widest">TYPE</th>
          <th class="px-4 py-3 text-[9px] font-bold text-slate-400 uppercase tracking-widest">FICHIER</th>
          <th class="px-4 py-3 text-[9px] font-bold text-slate-400 uppercase tracking-widest">STATUT</th>
          <th class="px-4 py-3 text-[9px] font-bold text-slate-400 uppercase tracking-widest">DATE</th>
          <th class="px-4 py-3 text-[9px] font-bold text-slate-400 uppercase tracking-widest text-right">ACTIONS</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-100">
        @forelse($supports as $support)
          <tr class="hover:bg-slate-50 transition-colors">
            <td class="px-6 py-3.5 text-xs text-slate-600 font-medium">{{ $support->cours->titre ?? '—' }}</td>
            <td class="px-4 py-3.5">
              @php
                $typeColors = [
                  'document' => 'bg-blue-100 text-blue-700 border-blue-200',
                  'video'    => 'bg-purple-100 text-purple-700 border-purple-200',
                  'audio'    => 'bg-amber-100 text-amber-700 border-amber-200',
                  'image'    => 'bg-pink-100 text-pink-700 border-pink-200',
                  'autre'    => 'bg-slate-100 text-slate-600 border-slate-200',
                ];
                $color = $typeColors[$support->type] ?? $typeColors['autre'];
              @endphp
              <span class="{{ $color }} text-[9px] font-bold px-2 py-0.5 uppercase tracking-widest border">{{ ucfirst($support->type) }}</span>
            </td>
            <td class="px-4 py-3.5">
              @if($support->fichier)
                <a href="{{ Storage::url($support->fichier) }}" target="_blank"
                  class="inline-flex items-center gap-1 text-xs text-indigo-600 hover:text-indigo-800 font-medium">
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                  Télécharger
                </a>
              @else
                <span class="text-xs text-slate-400">—</span>
              @endif
            </td>
            <td class="px-4 py-3.5">
              @if($support->actif === 'OUI')
                <span class="bg-emerald-100 text-emerald-700 text-[9px] font-bold px-2 py-0.5 uppercase tracking-widest border border-emerald-200">Actif</span>
              @else
                <span class="bg-red-100 text-red-600 text-[9px] font-bold px-2 py-0.5 uppercase tracking-widest border border-red-200">Inactif</span>
              @endif
            </td>
            <td class="px-4 py-3.5 text-xs text-slate-400">{{ $support->created_at->format('d/m/Y') }}</td>
            <td class="px-4 py-3.5 text-right">
              <div class="relative inline-block text-left" x-data="{ open: false }" @click.away="open = false">
                <button @click="open = !open" type="button"
                  class="w-7 h-7 border border-slate-300 bg-white hover:bg-slate-100 text-slate-500 inline-flex items-center justify-center focus:outline-none transition-colors">
                  <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/>
                  </svg>
                </button>
                <div x-show="open"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="absolute right-0 mt-1 w-44 bg-white shadow-lg border border-slate-200 z-50 divide-y divide-slate-100"
                     style="display:none;">
                  @if($support->fichier)
                    <a href="{{ Storage::url($support->fichier) }}" target="_blank"
                      class="flex items-center gap-2 px-4 py-2.5 text-xs text-slate-700 hover:bg-slate-50 font-semibold">
                      <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                      Télécharger
                    </a>
                  @endif
                  <button type="button"
                    @click="$root.openEdit({{ $support->id }}, '{{ $support->cours_id }}'); open = false"
                    class="w-full flex items-center gap-2 px-4 py-2.5 text-xs text-slate-700 hover:bg-slate-50 font-semibold">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Modifier
                  </button>
                  <form method="POST" action="{{ route('dashboard.professeur.supports.destroy', $support) }}" class="w-full">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Supprimer ce support ? Le fichier sera définitivement supprimé.')"
                      class="w-full flex items-center gap-2 px-4 py-2.5 text-xs text-red-600 hover:bg-red-50 font-semibold">
                      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                      Supprimer
                    </button>
                  </form>
                </div>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" class="px-6 py-16 text-center">
              <svg class="w-12 h-12 text-slate-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
              <p class="text-sm text-slate-400 mb-4">Aucun support de cours enregistré pour le moment.</p>
              <button @click="showSupportModal = true"
                class="inline-flex items-center gap-1.5 px-4 py-2 bg-brand-lime text-slate-900 font-bold text-[10px] uppercase tracking-widest hover:brightness-105 transition shadow-sm cursor-pointer">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                Ajouter le premier support
              </button>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- ══════════════════════ MODAL : Nouveau Support ══════════════════════ --}}
  <div x-show="showSupportModal"
       class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm"
       x-cloak
       style="display:none;">
    <div @click.away="showSupportModal = false"
         class="bg-white w-full max-w-lg shadow-2xl border border-slate-200 max-h-[90vh] overflow-y-auto">
      <div class="flex justify-between items-center px-6 py-4 border-b border-slate-200 bg-slate-50">
        <div>
          <h3 class="font-bold text-slate-900 text-sm uppercase tracking-wide">Ajouter un Support</h3>
          <p class="text-[11px] text-slate-400 mt-0.5">Rattachez un fichier à l'un de vos cours</p>
        </div>
        <button @click="showSupportModal = false"
          class="w-8 h-8 border border-slate-300 bg-white flex items-center justify-center text-slate-500 hover:text-slate-900 hover:bg-slate-100 transition-colors text-lg font-bold leading-none">&times;</button>
      </div>
      <form action="{{ route('dashboard.professeur.supports.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
        @csrf
        <div>
          <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Cours <span class="text-red-500">*</span></label>
          <select name="cours_id" required class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-brand-lime transition">
            <option value="">Sélectionner un cours</option>
            @foreach($coursList as $cours)
              <option value="{{ $cours->id }}">{{ $cours->titre }}</option>
            @endforeach
          </select>
        </div>
        <div>
          <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Fichier <span class="text-red-500">*</span></label>
          <input type="file" name="fichier" required
            class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-xs file:font-bold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 file:cursor-pointer" />
          <p class="text-[10px] text-slate-400 mt-1">PDF, Word, PPT, Excel, ZIP, MP4, MP3, PNG, JPG — Max 20 Mo</p>
        </div>
        <div class="flex justify-end gap-3 pt-3 border-t border-slate-200">
          <button type="button" @click="showSupportModal = false"
            class="px-4 py-2 text-xs font-bold uppercase tracking-wider text-slate-500 hover:text-slate-900 hover:bg-slate-100 border border-transparent hover:border-slate-200 transition">
            Annuler
          </button>
          <button type="submit"
            class="px-5 py-2 bg-brand-lime text-slate-900 font-bold text-xs uppercase tracking-widest hover:brightness-105 shadow-sm transition">
            Enregistrer
          </button>
        </div>
      </form>
    </div>
  </div>

  {{-- ══════════════════════ MODAL : Modifier Support ══════════════════════ --}}
  <div x-show="showEditModal"
       class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm"
       x-cloak
       style="display:none;">
    <div @click.away="showEditModal = false"
         class="bg-white w-full max-w-lg shadow-2xl border border-slate-200 max-h-[90vh] overflow-y-auto">
      <div class="flex justify-between items-center px-6 py-4 border-b border-slate-200 bg-slate-50">
        <div>
          <h3 class="font-bold text-slate-900 text-sm uppercase tracking-wide">Modifier le Support</h3>
          <p class="text-[11px] text-slate-400 mt-0.5">Mettez à jour les informations du support</p>
        </div>
        <button @click="showEditModal = false"
          class="w-8 h-8 border border-slate-300 bg-white flex items-center justify-center text-slate-500 hover:text-slate-900 hover:bg-slate-100 transition-colors text-lg font-bold leading-none">&times;</button>
      </div>
      <form :action="route('dashboard.professeur.supports.update', editId)" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
        @csrf
        @method('PUT')
        <div>
          <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Cours <span class="text-red-500">*</span></label>
          <select name="cours_id" required class="w-full px-3 py-2 bg-slate-50 border border-slate-300 text-sm focus:outline-none focus:border-brand-lime transition">
            <option value="">Sélectionner un cours</option>
            @foreach($coursList as $cours)
              <option value="{{ $cours->id }}" :selected="editCours === '{{ $cours->id }}'">{{ $cours->titre }}</option>
            @endforeach
          </select>
        </div>
        <div>
          <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Nouveau fichier (optionnel)</label>
          <input type="file" name="fichier"
            class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-xs file:font-bold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 file:cursor-pointer" />
          <p class="text-[10px] text-slate-400 mt-1">Laissez vide pour conserver le fichier existant.</p>
        </div>
        <div class="flex justify-end gap-3 pt-3 border-t border-slate-200">
          <button type="button" @click="showEditModal = false"
            class="px-4 py-2 text-xs font-bold uppercase tracking-wider text-slate-500 hover:text-slate-900 hover:bg-slate-100 border border-transparent hover:border-slate-200 transition">
            Annuler
          </button>
          <button type="submit"
            class="px-5 py-2 bg-brand-lime text-slate-900 font-bold text-xs uppercase tracking-widest hover:brightness-105 shadow-sm transition">
            Mettre à jour
          </button>
        </div>
      </form>
    </div>
  </div>

</div>{{-- fin x-data --}}
@endsection
