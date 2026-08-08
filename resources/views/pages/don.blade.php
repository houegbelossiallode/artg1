@extends('layouts.app')
@section('title', 'Écho & Culture — Mécénat & Don')

@section('content')
<section class="pt-32 pb-24 bg-[#FAF7F2] relative overflow-hidden" id="donation">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
<div class="text-center max-w-3xl mx-auto space-y-4">
<div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-none bg-[#F4EFE6] border border-[#D4A373]/40 text-[#C85A32] text-xs font-bold uppercase tracking-widest">
<svg aria-hidden="true" class="lucide lucide-heart w-3.5 h-3.5 fill-current text-[#C85A32]" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="M2 9.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5">
</path>
</svg>
<span>
      Espace Générosité &amp; Engagement
     </span>
</div>
<h2 class="font-serif-title text-3xl sm:text-4xl md:text-5xl font-bold text-[#2C221E] tracking-tight">
     Faire un Don &amp; Adhérer à l'Association
    </h2>
<p class="text-sm sm:text-base text-[#6B574F] font-sans leading-relaxed">
     Vos contributions soutiennent directement l'achat d'instruments, le financement des bourses pour les jeunes talents et la transmission de l'artisanat du Raphia.
    </p>
</div>

<div class="flex justify-center max-w-md mx-auto bg-[#F4EFE6] p-1.5 rounded-none border border-[#D4A373]/30">
<button class="flex-1 py-2.5 rounded-none text-xs font-bold transition-all bg-[#C85A32] text-white shadow">
     Faire un Don Ponctuel ou Mensuel
    </button>
<button class="flex-1 py-2.5 rounded-none text-xs font-bold transition-all text-[#2C221E] hover:text-[#C85A32]">
     Devenir Membre / Adhérer
    </button>
</div>

<form action="{{ route('don.store') }}" method="POST" x-data="{
    selectedAmount: 50,
    customAmount: '',
    isAnonymous: false,
    get displayAmount() {
        return this.customAmount ? this.customAmount : this.selectedAmount;
    },
    get impactText() {
        const amount = parseFloat(this.displayAmount);
        if (amount >= 200) return 'Financement complet d\'un atelier de formation pour 10 jeunes artisans.';
        if (amount >= 100) return 'Achat de 20kg de fibres de raphia naturel & matériel d\'atelier.';
        if (amount >= 50) return 'Financement de 10kg de fibres de raphia naturel & matériel d\'atelier.';
        if (amount >= 20) return 'Achat de 4kg de fibres de raphia naturel pour un apprenti.';
        return 'Contribution aux frais généraux de l\'atelier.';
    },
    get realCost() {
        const amount = parseFloat(this.displayAmount);
        return (amount * 0.34).toFixed(0);
    }
}">
@csrf

<div class="bg-[#1E1613] text-[#FAF7F2] rounded-none p-8 sm:p-12 shadow-2xl border border-[#D4A373]/30 max-w-4xl mx-auto space-y-8">
<div class="text-center space-y-2">
<span class="text-xs uppercase font-bold text-[#D4A373]">
      Calculateur d'Impact Solidaire
     </span>
<h3 class="font-serif-title text-2xl sm:text-3xl font-bold text-white">
      Choisissez le montant de votre soutien
     </h3>
</div>

<div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
<button type="button" @click="selectedAmount = 20; customAmount = ''" :class="selectedAmount === 20 && !customAmount ? 'bg-[#C85A32] text-white border-[#C85A32] shadow-lg scale-105' : 'bg-white/5 text-white border-white/20 hover:bg-white/10'" class="py-4 rounded-none text-lg font-bold font-serif-title border transition-all">
      20 €
     </button>
<button type="button" @click="selectedAmount = 50; customAmount = ''" :class="selectedAmount === 50 && !customAmount ? 'bg-[#C85A32] text-white border-[#C85A32] shadow-lg scale-105' : 'bg-white/5 text-white border-white/20 hover:bg-white/10'" class="py-4 rounded-none text-lg font-bold font-serif-title border transition-all">
      50 €
     </button>
<button type="button" @click="selectedAmount = 100; customAmount = ''" :class="selectedAmount === 100 && !customAmount ? 'bg-[#C85A32] text-white border-[#C85A32] shadow-lg scale-105' : 'bg-white/5 text-white border-white/20 hover:bg-white/10'" class="py-4 rounded-none text-lg font-bold font-serif-title border transition-all">
      100 €
     </button>
<button type="button" @click="selectedAmount = 200; customAmount = ''" :class="selectedAmount === 200 && !customAmount ? 'bg-[#C85A32] text-white border-[#C85A32] shadow-lg scale-105' : 'bg-white/5 text-white border-white/20 hover:bg-white/10'" class="py-4 rounded-none text-lg font-bold font-serif-title border transition-all">
      200 €
     </button>
</div>

<div class="max-w-xs mx-auto">
<input x-model="customAmount" @input="selectedAmount = 0" class="w-full px-4 py-3 rounded-none bg-white/10 border border-white/20 text-white placeholder-white/50 text-sm text-center focus:outline-none focus:border-[#D4A373]" placeholder="Autre montant libre (€)" type="number" name="montant" required min="1" step="0.01"/>
</div>

<div class="glass-dark rounded-none p-6 border border-[#D4A373]/30 space-y-3 text-center max-w-2xl mx-auto">
<div class="flex items-center justify-center gap-2 text-[#D4A373] text-xs font-bold uppercase">
<svg aria-hidden="true" class="lucide lucide-gift w-4 h-4" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<rect height="4" rx="1" width="18" x="3" y="8">
</rect>
<path d="M12 8v13">
</path>
<path d="M19 12v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7">
</path>
<path d="M7.5 8a2.5 2.5 0 0 1 0-5A4.8 8 0 0 1 12 8a4.8 8 0 0 1 4.5-5 2.5 2.5 0 0 1 0 5">
</path>
</svg>
<span>
       Impact concret de votre don de <span x-text="displayAmount"></span> € :
      </span>
</div>
<p class="text-sm font-semibold text-white" x-text="impactText">
     </p>
<div class="pt-3 border-t border-white/10 text-xs text-white/70 flex items-center justify-center gap-2">
<svg aria-hidden="true" class="lucide lucide-shield-check w-4 h-4 text-[#52B788]" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z">
</path>
<path d="m9 12 2 2 4-4">
</path>
</svg>
<span>
       Après déduction fiscale (66%), ce don ne vous coûte en réalité que
       <strong class="text-[#D4A373] font-bold">
        <span x-text="realCost"></span> €
       </strong>
       .
      </span>
</div>
</div>

<!-- Informations personnelles -->
<div class="space-y-4">
    <div class="flex items-center gap-3 mb-4">
        <input type="checkbox" id="anonyme" x-model="isAnonymous" name="anonyme" class="w-4 h-4 rounded border-white/30 bg-white/10 text-[#C85A32] focus:ring-[#C85A32] focus:ring-offset-0">
        <label for="anonyme" class="text-sm text-white/80">Je souhaite rester anonyme</label>
    </div>

    <div x-show="!isAnonymous" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-xs font-bold text-[#D4A373] mb-2">Nom complet</label>
            <input type="text" name="nom" class="w-full px-4 py-3 rounded-none bg-white/10 border border-white/20 text-white placeholder-white/50 text-sm focus:outline-none focus:border-[#D4A373]" placeholder="Votre nom">
        </div>
        <div>
            <label class="block text-xs font-bold text-[#D4A373] mb-2">Email</label>
            <input type="email" name="email" class="w-full px-4 py-3 rounded-none bg-white/10 border border-white/20 text-white placeholder-white/50 text-sm focus:outline-none focus:border-[#D4A373]" placeholder="votre@email.com">
        </div>
        <div class="sm:col-span-2">
            <label class="block text-xs font-bold text-[#D4A373] mb-2">Téléphone</label>
            <input type="tel" name="telephone" class="w-full px-4 py-3 rounded-none bg-white/10 border border-white/20 text-white placeholder-white/50 text-sm focus:outline-none focus:border-[#D4A373]" placeholder="+229 XX XX XX XX">
        </div>
    </div>
</div>

<!-- Mode de paiement -->
<div>
    <label class="block text-xs font-bold text-[#D4A373] mb-3">Mode de paiement préféré</label>
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        <label class="flex items-center gap-2 p-3 bg-white/5 border border-white/20 rounded-none cursor-pointer hover:bg-white/10 transition-all">
            <input type="radio" name="mode_paiement" value="especes" checked class="w-4 h-4 rounded border-white/30 bg-white/10 text-[#C85A32] focus:ring-[#C85A32] focus:ring-offset-0">
            <span class="text-sm text-white">Espèces</span>
        </label>
        <label class="flex items-center gap-2 p-3 bg-white/5 border border-white/20 rounded-none cursor-pointer hover:bg-white/10 transition-all">
            <input type="radio" name="mode_paiement" value="cheque" class="w-4 h-4 rounded border-white/30 bg-white/10 text-[#C85A32] focus:ring-[#C85A32] focus:ring-offset-0">
            <span class="text-sm text-white">Chèque</span>
        </label>
        <label class="flex items-center gap-2 p-3 bg-white/5 border border-white/20 rounded-none cursor-pointer hover:bg-white/10 transition-all">
            <input type="radio" name="mode_paiement" value="virement" class="w-4 h-4 rounded border-white/30 bg-white/10 text-[#C85A32] focus:ring-[#C85A32] focus:ring-offset-0">
            <span class="text-sm text-white">Virement</span>
        </label>
        <label class="flex items-center gap-2 p-3 bg-white/5 border border-white/20 rounded-none cursor-pointer hover:bg-white/10 transition-all">
            <input type="radio" name="mode_paiement" value="mobile_money" class="w-4 h-4 rounded border-white/30 bg-white/10 text-[#C85A32] focus:ring-[#C85A32] focus:ring-offset-0">
            <span class="text-sm text-white">Mobile Money</span>
        </label>
    </div>
</div>

<!-- Message -->
<div>
    <label class="block text-xs font-bold text-[#D4A373] mb-2">Message (optionnel)</label>
    <textarea name="message" rows="3" class="w-full px-4 py-3 rounded-none bg-white/10 border border-white/20 text-white placeholder-white/50 text-sm focus:outline-none focus:border-[#D4A373]" placeholder="Un message pour notre équipe..."></textarea>
</div>

<div class="text-center">
<button type="submit" class="px-8 py-4 rounded-none bg-[#C85A32] hover:bg-[#A84223] text-white font-bold text-sm shadow-xl transition-all transform hover:scale-105 inline-flex items-center gap-2">
<svg aria-hidden="true" class="lucide lucide-heart w-4 h-4 fill-current text-white" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="M2 9.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5">
</path>
</svg>
<span x-text="'Valider mon Don de ' + displayAmount + ' €'">
     </span>
<svg aria-hidden="true" class="lucide lucide-arrow-right w-4 h-4" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="M5 12h14">
</path>
<path d="m12 5 7 7-7 7">
</path>
</svg>
</button>
</div>
</div>
</form>
</div>
</section>
@endsection
