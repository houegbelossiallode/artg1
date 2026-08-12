@extends('layouts.dashboard')

@section('title', 'Détail du Contact | AssoCulture')

@section('content')
<div class="space-y-6">
  
  <!-- Flash Messages -->
  @if (session('success'))
    <div class="p-4 bg-emerald-50 border-l-4 border-emerald-600 text-emerald-800 text-xs shadow-sm flex items-center justify-between">
      <span>{{ session('success') }}</span>
      <button onclick="this.parentElement.remove()" class="text-emerald-600 font-bold ml-4">&times;</button>
    </div>
  @endif

  <!-- En-tête -->
  <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 pb-4 border-b border-slate-200">
    <div>
      <h1 class="admin-title">Détail Du Message</h1>
      <p class="admin-subtitle">Consultez les détails du message de contact.</p>
    </div>
    <div class="flex flex-wrap items-center gap-2">
      <a href="{{ route('dashboard.admin.contacts.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-[10px] uppercase tracking-widest transition shadow-sm cursor-pointer">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        RETOUR
      </a>
    </div>
  </div>

  <!-- Détails du Contact -->
  <div class="bg-white border border-slate-200 shadow-sm rounded-none p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div>
        <label class="block text-[10px] uppercase tracking-widest text-slate-400 font-bold mb-1">Nom complet</label>
        <div class="text-sm text-slate-900 font-sans font-bold">{{ $contact->nom }}</div>
      </div>
      <div>
        <label class="block text-[10px] uppercase tracking-widest text-slate-400 font-bold mb-1">Adresse e-mail</label>
        <div class="text-sm text-slate-600">
          <a href="mailto:{{ $contact->email }}" class="text-blue-600 hover:underline">{{ $contact->email }}</a>
        </div>
      </div>
      <div>
        <label class="block text-[10px] uppercase tracking-widest text-slate-400 font-bold mb-1">Objet</label>
        <div class="text-sm text-slate-900 font-semibold">{{ $contact->objet }}</div>
      </div>
      <div>
        <label class="block text-[10px] uppercase tracking-widest text-slate-400 font-bold mb-1">Date de réception</label>
        <div class="text-sm text-slate-600">{{ $contact->created_at->format('d/m/Y H:i') }}</div>
      </div>
    </div>
    
    <div class="mt-6">
      <label class="block text-[10px] uppercase tracking-widest text-slate-400 font-bold mb-1">Message</label>
      <div class="p-4 bg-slate-50 border border-slate-200 rounded-none text-sm text-slate-700 whitespace-pre-wrap">{{ $contact->message }}</div>
    </div>

    <div class="mt-6 pt-6 border-t border-slate-200 flex justify-end gap-2">
      <form action="{{ route('dashboard.admin.contacts.destroy', $contact) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer ce message ?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-bold text-[10px] uppercase tracking-widest transition shadow-sm cursor-pointer">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
          SUPPRIMER
        </button>
      </form>
    </div>
  </div>

</div>
@endsection
