@extends('layouts.app')

@section('title', 'Inscription Apprenant - Écho & Culture')

@section('content')
<div class="min-h-screen pt-32 pb-20 flex items-center justify-center px-4 sm:px-6 lg:px-8 bg-pattern-raphia">
    <div class="max-w-5xl w-full bg-[#FAF7F2] border border-[#D4A373]/30 shadow-2xl flex flex-col md:flex-row overflow-hidden relative z-10 rounded-none">
        
        <!-- Left Side: Cultural/Artistic Branding panel -->
        <div class="md:w-1/3 bg-[#1E1613] text-[#FAF7F2] p-10 flex flex-col justify-between relative overflow-hidden">
            <!-- Background pattern -->
            <div class="absolute inset-0 opacity-10 bg-pattern-raphia pointer-events-none"></div>
            
            <div class="relative z-10">
                <div class="w-12 h-12 border border-[#D4A373] flex items-center justify-center font-display font-bold text-[#D4A373] text-xl tracking-wider mb-8">
                    É&C
                </div>
                <span class="font-sans font-semibold text-xs tracking-widest uppercase text-[#D4A373]">Créer un compte</span>
                <h2 class="font-serif-title font-bold text-3xl mt-2 tracking-tight leading-tight">
                    Commencez votre voyage d'apprentissage.
                </h2>
                <p class="text-xs font-light text-[#D1C5B8] leading-relaxed mt-4">
                    Inscrivez-vous en tant qu'apprenant pour réserver des cours de musique et de tissage du raphia auprès de nos maîtres artisans et professeurs passionnés.
                </p>
            </div>
            
            <div class="mt-12 relative z-10">
                <div class="border-t border-white/10 pt-6">
                    <p class="text-[10px] tracking-widest uppercase text-[#8C766B] font-bold mb-3">Avantages Apprenant</p>
                    <ul class="text-xs font-light text-[#D1C5B8] space-y-3">
                        <li class="flex items-start gap-2">
                            <span class="text-[#D4A373] mt-0.5">✓</span>
                            <span>Accès exclusif au catalogue de cours</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-[#D4A373] mt-0.5">✓</span>
                            <span>Réservation et plannings interactifs</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-[#D4A373] mt-0.5">✓</span>
                            <span>Messagerie et suivi pédagogique</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Right Side: Form panel -->
        <div class="md:w-2/3 p-8 sm:p-12 flex flex-col justify-center bg-[#FAF7F2]">
            <div>
                <h3 class="font-serif-title font-bold text-3xl text-[#2C221E] tracking-tight">Créer mon compte Apprenant</h3>
                <p class="text-xs font-light text-[#6B574F] mt-1">Remplissez les informations ci-dessous pour vous inscrire.</p>
            </div>

            <form action="{{ route('register.post') }}" method="POST" class="mt-8 space-y-5">
                @csrf
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <!-- Nom -->
                    <div>
                        <label for="nom" class="block text-[10px] font-bold tracking-widest uppercase text-[#5C4A42] mb-1.5">Nom</label>
                        <input id="nom" name="nom" type="text" required value="{{ old('nom') }}"
                            class="w-full px-4 py-3 bg-white border @error('nom') border-red-500 @else border-[#D4A373]/40 @enderror text-[#2C221E] text-sm focus:outline-none focus:border-[#C85A32] focus:ring-1 focus:ring-[#C85A32] transition-all rounded-none placeholder-[#8C766B]/50"
                            placeholder="Nom de famille">
                        @error('nom')
                            <p class="text-[10px] text-red-600 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Prénom -->
                    <div>
                        <label for="prenom" class="block text-[10px] font-bold tracking-widest uppercase text-[#5C4A42] mb-1.5">Prénom</label>
                        <input id="prenom" name="prenom" type="text" required value="{{ old('prenom') }}"
                            class="w-full px-4 py-3 bg-white border @error('prenom') border-red-500 @else border-[#D4A373]/40 @enderror text-[#2C221E] text-sm focus:outline-none focus:border-[#C85A32] focus:ring-1 focus:ring-[#C85A32] transition-all rounded-none placeholder-[#8C766B]/50"
                            placeholder="Prénoms">
                        @error('prenom')
                            <p class="text-[10px] text-red-600 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="sm:col-span-2">
                        <label for="email" class="block text-[10px] font-bold tracking-widest uppercase text-[#5C4A42] mb-1.5">Adresse Email</label>
                        <input id="email" name="email" type="email" required value="{{ old('email') }}"
                            class="w-full px-4 py-3 bg-white border @error('email') border-red-500 @else border-[#D4A373]/40 @enderror text-[#2C221E] text-sm focus:outline-none focus:border-[#C85A32] focus:ring-1 focus:ring-[#C85A32] transition-all rounded-none placeholder-[#8C766B]/50"
                            placeholder="exemple@email.com">
                        @error('email')
                            <p class="text-[10px] text-red-600 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sexe -->
                    <div>
                        <label for="sexe" class="block text-[10px] font-bold tracking-widest uppercase text-[#5C4A42] mb-1.5">Genre</label>
                        <div class="relative">
                            <select id="sexe" name="sexe" required
                                class="w-full appearance-none px-4 py-3 bg-white border @error('sexe') border-red-500 @else border-[#D4A373]/40 @enderror text-[#2C221E] text-sm focus:outline-none focus:border-[#C85A32] focus:ring-1 focus:ring-[#C85A32] transition-all rounded-none">
                                <option value="">Sélectionnez</option>
                                <option value="M" {{ old('sexe') === 'M' ? 'selected' : '' }}>Masculin</option>
                                <option value="F" {{ old('sexe') === 'F' ? 'selected' : '' }}>Féminin</option>
                            </select>
                            <svg aria-hidden="true" class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2 text-[#8C766B] pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                        @error('sexe')
                            <p class="text-[10px] text-red-600 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date de Naissance -->
                    <div>
                        <label for="date_naissance" class="block text-[10px] font-bold tracking-widest uppercase text-[#5C4A42] mb-1.5">Date de Naissance</label>
                        <input id="date_naissance" name="date_naissance" type="date" required value="{{ old('date_naissance') }}"
                            class="w-full px-4 py-3 bg-white border @error('date_naissance') border-red-500 @else border-[#D4A373]/40 @enderror text-[#2C221E] text-sm focus:outline-none focus:border-[#C85A32] focus:ring-1 focus:ring-[#C85A32] transition-all rounded-none">
                        @error('date_naissance')
                            <p class="text-[10px] text-red-600 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Téléphone -->
                    <div>
                        <label for="telephone" class="block text-[10px] font-bold tracking-widest uppercase text-[#5C4A42] mb-1.5">Téléphone</label>
                        <input id="telephone" name="telephone" type="tel" required value="{{ old('telephone') }}"
                            class="w-full px-4 py-3 bg-white border @error('telephone') border-red-500 @else border-[#D4A373]/40 @enderror text-[#2C221E] text-sm focus:outline-none focus:border-[#C85A32] focus:ring-1 focus:ring-[#C85A32] transition-all rounded-none placeholder-[#8C766B]/50"
                            placeholder="+229 00 00 00 00">
                        @error('telephone')
                            <p class="text-[10px] text-red-600 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Adresse -->
                    <div>
                        <label for="adresse" class="block text-[10px] font-bold tracking-widest uppercase text-[#5C4A42] mb-1.5">Adresse</label>
                        <input id="adresse" name="adresse" type="text" required value="{{ old('adresse') }}"
                            class="w-full px-4 py-3 bg-white border @error('adresse') border-red-500 @else border-[#D4A373]/40 @enderror text-[#2C221E] text-sm focus:outline-none focus:border-[#C85A32] focus:ring-1 focus:ring-[#C85A32] transition-all rounded-none placeholder-[#8C766B]/50"
                            placeholder="Cotonou, Bénin">
                        @error('adresse')
                            <p class="text-[10px] text-red-600 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Mot de passe -->
                    <div>
                        <label for="password" class="block text-[10px] font-bold tracking-widest uppercase text-[#5C4A42] mb-1.5">Mot de Passe</label>
                        <input id="password" name="password" type="password" required
                            class="w-full px-4 py-3 bg-white border @error('password') border-red-500 @else border-[#D4A373]/40 @enderror text-[#2C221E] text-sm focus:outline-none focus:border-[#C85A32] focus:ring-1 focus:ring-[#C85A32] transition-all rounded-none placeholder-[#8C766B]/50"
                            placeholder="Min. 8 caractères">
                        @error('password')
                            <p class="text-[10px] text-red-600 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirmation -->
                    <div>
                        <label for="password_confirmation" class="block text-[10px] font-bold tracking-widest uppercase text-[#5C4A42] mb-1.5">Confirmation</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required
                            class="w-full px-4 py-3 bg-white border border-[#D4A373]/40 text-[#2C221E] text-sm focus:outline-none focus:border-[#C85A32] focus:ring-1 focus:ring-[#C85A32] transition-all rounded-none placeholder-[#8C766B]/50"
                            placeholder="Re-saisir le mot de passe">
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" class="w-full px-6 py-3.5 bg-[#C85A32] hover:bg-[#A84223] text-white font-bold text-sm tracking-wide uppercase shadow-lg transition-transform hover:-translate-y-0.5 rounded-none flex items-center justify-center gap-2">
                        <span>Créer mon compte</span>
                        <svg aria-hidden="true" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m14 0l-4-4m4 4l-4 4"></path>
                        </svg>
                    </button>
                </div>
            </form>

            <div class="mt-8 pt-6 border-t border-[#D4A373]/20 text-center">
                <p class="text-xs text-[#6B574F] font-light">
                    Vous possédez déjà un compte ? 
                    <a href="{{ route('login') }}" class="font-bold text-[#C85A32] hover:text-[#A84223] transition-colors underline underline-offset-4 border-[#C85A32]">Se connecter</a>
                </p>
            </div>
        </div>

    </div>
</div>
@endsection
