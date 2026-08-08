<?php
/**
 * Permissions Management View – Redesigned to use the dashboard layout and match the provided mockup.
 */
?>
@extends('layouts.dashboard')

@section('title', 'Gestion des permissions – ' . ($profile->nom ?? 'Profil'))

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    
    <!-- Header Block -->
    <div class="bg-white p-6 shadow-sm border border-slate-200 flex flex-col justify-center min-h-[100px]">
        <h1 class="text-lg font-bold text-slate-900 uppercase tracking-widest mb-2">PERMISSIONS DES PROFILS</h1>
        <p class="text-sm text-slate-500">Définissez les accès aux différents modules et menus pour chaque rôle.</p>
    </div>

    <form method="POST" action="{{ route('dashboard.admin.profils.permissions.update', ['profil' => $profile->id]) }}">
        @csrf
        @method('PUT')
        <input type="hidden" name="profilId" value="{{ $profile->id }}">

        <!-- Action Bar -->
        <div class="bg-white p-4 shadow-sm border border-slate-200 flex items-center justify-between sticky top-0 z-10">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center text-brand-lime">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"/></svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-900">Droits d'accès : <span class="text-brand-lime uppercase">{{ $profile->nom }}</span></h2>
                    <p class="text-sm text-slate-500">Cochez les sous-menus auxquels ce profil peut accéder.</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard.admin.profils.index') }}" class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition-colors border border-slate-200">
                    Annuler
                </a>
                <button type="submit" class="px-6 py-2.5 bg-[#008955] hover:bg-[#007044] text-white font-bold text-xs uppercase tracking-wider transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                    Enregistrer les Permissions
                </button>
            </div>
        </div>

        <!-- Modules Loop -->
        <div class="space-y-6 mt-6">
            @foreach($modules as $module)
                <div class="bg-white shadow-sm border border-slate-200" x-data="{ moduleChecked: false }">
                    <!-- Module Header -->
                    <div class="p-4 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-white border border-slate-200 rounded flex items-center justify-center text-[#008955]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            </div>
                            <h3 class="text-sm font-bold text-[#008955] uppercase tracking-widest">{{ $module->nom ?? $module->libelle ?? 'Module ' . $module->id }}</h3>
                        </div>
                        <div class="flex items-center gap-3">
                            <label class="text-xs font-bold text-slate-400 uppercase tracking-widest cursor-pointer">Tout cocher</label>
                            <input type="checkbox" x-model="moduleChecked" @change="$el.closest('.bg-white').querySelectorAll('.perm-checkbox').forEach(cb => cb.checked = moduleChecked)" class="w-5 h-5 border-slate-300 text-[#008955] rounded focus:ring-[#008955] cursor-pointer">
                        </div>
                    </div>

                    <!-- Menus inside Module -->
                    <div class="p-6 space-y-8">
                        @foreach($module->menus as $menu)
                            @if($menu->submenus->count() > 0)
                                <div>
                                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                                        {{ $menu->libelle }}
                                    </h4>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        @foreach($menu->submenus as $sousmenu)
                                            @php
                                                $perm = $permissions->firstWhere('sousmenu_id', $sousmenu->id);
                                                $checked = $perm && $perm->is_granted ? 'checked' : '';
                                            @endphp
                                            <label class="flex items-start gap-4 p-4 border border-slate-200 rounded hover:border-[#008955] transition-colors cursor-pointer bg-white group">
                                                <input type="checkbox" name="permissions[{{ $sousmenu->id }}]" value="1" class="perm-checkbox w-5 h-5 mt-0.5 border-slate-300 text-[#008955] rounded focus:ring-[#008955] cursor-pointer" {{ $checked }}>
                                                <div class="flex-1">
                                                    <div class="font-bold text-sm text-slate-800 group-hover:text-[#008955] transition-colors">{{ $sousmenu->nom ?? $sousmenu->libelle }}</div>
                                                    <div class="text-xs text-slate-400 mt-1 font-mono break-all">{{ $sousmenu->route ?? 'route.non.definie' }}</div>
                                                </div>
                                                <div class="text-[9px] font-bold uppercase tracking-widest text-[#008955] bg-green-50 px-2 py-1 rounded">
                                                    {{ $profile->nom }}
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        @if($module->menus->isEmpty() || $module->menus->flatMap->submenus->isEmpty())
                            <div class="text-sm text-slate-400 italic">Aucun sous-menu disponible dans ce module.</div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </form>
</div>
@endsection
