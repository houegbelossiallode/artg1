@extends('layouts.dashboard')

@section('title', 'Contacts | AssoCulture')

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
  <div class="bg-white border border-slate-200 shadow-sm px-6 py-5 border-l-4 border-l-slate-900 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <h1 class="text-lg font-bold text-slate-900 uppercase tracking-wide">MESSAGES DE CONTACT</h1>
      <p class="text-slate-400 text-sm mt-0.5">Consultez et gérez les messages reçus via le formulaire de contact.</p>
    </div>
  </div>

  <!-- Table des Contacts -->
  <div class="bg-white border border-slate-200 shadow-sm rounded-none">
    <div class="overflow-x-auto overflow-y-visible min-h-[300px]">
      <table class="w-full text-left text-sm text-slate-600">
        <thead class="border-b border-slate-200 text-[10px] uppercase tracking-widest text-slate-400 font-bold bg-slate-50">
          <tr>
            <th class="p-4">Statut</th>
            <th class="p-4">Nom</th>
            <th class="p-4">Email</th>
            <th class="p-4">Objet</th>
            <th class="p-4">Date</th>
            <th class="p-4 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          @forelse ($contacts as $contact)
            <tr class="hover:bg-slate-50 transition-colors {{ !$contact->lu ? 'bg-blue-50' : '' }}">
              <td class="p-4">
                @if($contact->lu)
                  <span class="bg-slate-100 text-slate-700 text-[9px] font-bold px-2 py-0.5 uppercase tracking-widest rounded-sm">
                    Lu
                  </span>
                @else
                  <span class="bg-blue-100 text-blue-700 text-[9px] font-bold px-2 py-0.5 uppercase tracking-widest rounded-sm">
                    Nouveau
                  </span>
                @endif
              </td>
              <td class="p-4">
                <div class="font-serif font-bold text-slate-900 text-sm">{{ $contact->nom }}</div>
              </td>
              <td class="p-4 text-xs text-slate-600">
                {{ $contact->email }}
              </td>
              <td class="p-4 text-xs font-semibold text-slate-700">
                {{ $contact->objet }}
              </td>
              <td class="p-4 text-xs text-slate-400">
                {{ $contact->created_at->format('d/m/Y H:i') }}
              </td>
              <td class="p-4 text-right pr-6">
                <!-- DROPDOWN CARRÉ D'ACTIONS -->
                <div class="relative inline-block text-left" x-data="{ open: false }" @click.away="open = false">
                  <button @click="open = !open" type="button" class="w-7 h-7 bg-slate-100 hover:bg-slate-900 hover:text-white text-slate-700 inline-flex items-center justify-center rounded-none border border-slate-300 transition-colors focus:outline-none cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
                  </button>

                  <div x-show="open" 
                       x-transition:enter="transition ease-out duration-100" 
                       x-transition:enter-start="transform opacity-0 scale-95" 
                       x-transition:enter-end="transform opacity-100 scale-100" 
                       x-transition:leave="transition ease-in duration-75" 
                       x-transition:leave-start="transform opacity-100 scale-100" 
                       x-transition:leave-end="transform opacity-0 scale-95" 
                       class="origin-top-right absolute right-0 mt-2 w-40 rounded-none bg-white shadow-xl border border-slate-200 z-50 divide-y divide-slate-100" 
                       x-cloak>
                    <div class="py-1">
                      <a href="{{ route('dashboard.admin.contacts.show', $contact) }}" class="w-full text-left group flex items-center px-4 py-2 text-xs text-slate-700 hover:bg-slate-900 hover:text-white font-bold uppercase tracking-wider">
                        <svg class="mr-2 h-4 w-4 text-slate-400 group-hover:text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        Voir
                      </a>
                    </div>
                    <div class="py-1">
                      <form action="{{ route('dashboard.admin.contacts.destroy', $contact) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer ce message ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full text-left group flex items-center px-4 py-2 text-xs text-red-600 hover:bg-red-600 hover:text-white font-bold uppercase tracking-wider">
                          <svg class="mr-2 h-4 w-4 text-red-500 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                          Supprimer
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="p-8 text-center text-xs text-slate-400">Aucun message de contact pour le moment.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>
@endsection
