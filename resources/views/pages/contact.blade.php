@extends('layouts.app')
@section('title', 'Écho & Culture — Contact')

@section('content')
<section class="pt-32 pb-24 bg-[#FAF7F2] relative overflow-hidden" id="contact">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
<div class="text-center max-w-3xl mx-auto space-y-4">
<div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-none bg-[#F4EFE6] border border-[#0BA20B]/40 text-[#0BA20B] text-xs font-bold uppercase tracking-widest">
<svg aria-hidden="true" class="lucide lucide-mail w-3.5 h-3.5" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7">
</path>
<rect height="16" rx="2" width="20" x="2" y="4">
</rect>
</svg>
<span>
      Écrivez-nous &amp; Rejoignez-nous
     </span>
</div>
<h2 class="font-serif-title text-3xl sm:text-4xl md:text-5xl font-bold text-[#2C221E] tracking-tight">
     Contact &amp; Foire Aux Questions
    </h2>
<p class="text-sm sm:text-base text-[#6B574F] font-sans leading-relaxed">
     Vous souhaitez réserver un cours, proposer un partenariat, faire un don ou en savoir plus sur nos ateliers du Raphia ? Notre équipe est à votre écoute.
    </p>
</div>
<div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
<div class="lg:col-span-7 bg-white rounded-none p-8 sm:p-10 border border-[#0BA20B]/30 shadow-xl space-y-6">
<h3 class="font-serif-title text-2xl font-bold text-[#2C221E]">
      Envoyer un message à l'association
     </h3>
<form id="contactForm" class="space-y-4">
    @csrf
    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-xs font-bold text-[#2C221E] uppercase mb-1">
                Nom complet *
            </label>
            <input name="nom" class="w-full px-4 py-2.5 rounded-none bg-[#FAF7F2] border border-[#0BA20B]/30 text-xs focus:outline-none focus:border-[#0BA20B]" placeholder="e.g. Marie Nguema" required type="text" value="{{ old('nom') }}"/>
        </div>
        <div>
            <label class="block text-xs font-bold text-[#2C221E] uppercase mb-1">
                Adresse e-mail *
            </label>
            <input name="email" class="w-full px-4 py-2.5 rounded-none bg-[#FAF7F2] border border-[#0BA20B]/30 text-xs focus:outline-none focus:border-[#0BA20B]" placeholder="e.g. marie@exemple.com" required type="email" value="{{ old('email') }}"/>
        </div>
    </div>
    <div>
        <label class="block text-xs font-bold text-[#2C221E] uppercase mb-1">
            Objet de votre demande *
        </label>
        <input type="text" name="objet" class="w-full px-4 py-2.5 rounded-none bg-[#FAF7F2] border border-[#0BA20B]/30 text-xs focus:outline-none focus:border-[#0BA20B]" placeholder="e.g. Demande de renseignements" required value="{{ old('objet') }}"/>
    </div>
    <div>
        <label class="block text-xs font-bold text-[#2C221E] uppercase mb-1">
            Votre Message *
        </label>
        <textarea name="message" class="w-full px-4 py-2.5 rounded-none bg-[#FAF7F2] border border-[#0BA20B]/30 text-xs focus:outline-none focus:border-[#0BA20B]" placeholder="Précisez votre demande, vos disponibilités ou vos questions..." required rows="4">{{ old('message') }}</textarea>
    </div>
    <button type="submit" class="w-full py-3.5 rounded-none bg-[#0BA20B] hover:bg-[#087A08] text-white font-bold text-xs shadow-md transition-all flex items-center justify-center gap-2">
        <svg aria-hidden="true" class="lucide lucide-send w-4 h-4" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
            <path d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z">
            </path>
            <path d="m21.854 2.147-10.94 10.939">
            </path>
        </svg>
        <span>
            Envoyer mon Message
        </span>
    </button>
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(form);
            
            fetch('{{ route('contact.store') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Message envoyé !',
                        text: data.message,
                        confirmButtonColor: '#0BA20B',
                        confirmButtonText: 'OK'
                    });
                    form.reset();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: 'Une erreur est survenue. Veuillez réessayer.',
                        confirmButtonColor: '#0BA20B',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: 'Une erreur est survenue. Veuillez réessayer.',
                    confirmButtonColor: '#0BA20B',
                    confirmButtonText: 'OK'
                });
            });
        });
    }
});
</script>
</div>
<div class="lg:col-span-5 space-y-6">
<div class="bg-[#1E1613] text-[#FAF7F2] rounded-none p-8 border border-[#0BA20B]/30 space-y-6 shadow-xl">
<h3 class="font-serif-title text-2xl font-bold text-white">
       Maison de l’Association Culturelle
      </h3>
<div class="space-y-4 text-xs font-sans">
<div class="flex items-start gap-3">
<svg aria-hidden="true" class="lucide lucide-map-pin w-5 h-5 text-[#0BA20B] shrink-0 mt-0.5" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
</path>
<circle cx="12" cy="10" r="3">
</circle>
</svg>
<div>
<span class="font-bold text-white block">
          Adresse du Centre Cultural :
         </span>
<p class="text-[#D1C5B8]">
          14 Avenue des Arts &amp; du Patrimoine, Quartier de la Culture
         </p>
</div>
</div>
<div class="flex items-start gap-3">
<svg aria-hidden="true" class="lucide lucide-phone-call w-5 h-5 text-[#0BA20B] shrink-0 mt-0.5" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="M13 2a9 9 0 0 1 9 9">
</path>
<path d="M13 6a5 5 0 0 1 5 5">
</path>
<path d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384">
</path>
</svg>
<div>
<span class="font-bold text-white block">
          Téléphone / WhatsApp :
         </span>
<p class="text-[#D1C5B8]">
          +33 (0)1 42 68 90 00 / +241 07 45 12 89
         </p>
</div>
</div>
<div class="flex items-start gap-3">
<svg aria-hidden="true" class="lucide lucide-mail w-5 h-5 text-[#0BA20B] shrink-0 mt-0.5" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7">
</path>
<rect height="16" rx="2" width="20" x="2" y="4">
</rect>
</svg>
<div>
<span class="font-bold text-white block">
          E-mail Officiel :
         </span>
<p class="text-[#D1C5B8]">
          contact@echo-culture.org
         </p>
</div>
</div>
<div class="flex items-start gap-3 pt-2 border-t border-white/10">
<svg aria-hidden="true" class="lucide lucide-clock w-5 h-5 text-[#0BA20B] shrink-0 mt-0.5" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="M12 6v6l4 2">
</path>
<circle cx="12" cy="12" r="10">
</circle>
</svg>
<div>
<span class="font-bold text-white block">
          Horaires d'Ouverture :
         </span>
<p class="text-[#D1C5B8]">
          Mardi au Samedi : 09h00 – 19h00
         </p>
<p class="text-[#D1C5B8]">
          Dimanche : 10h00 – 17h00 (Ateliers Raphia)
         </p>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="pt-12 border-t border-[#0BA20B]/20 space-y-8 max-w-4xl mx-auto">
<div class="text-center space-y-2">
<h3 class="font-serif-title text-2xl font-bold text-[#2C221E]">
      Foire Aux Questions (FAQ)
     </h3>
<p class="text-xs text-[#6B574F]">
      Réponses aux questions les plus fréquemment posées.
     </p>
</div>
<div class="space-y-3">
<div class="bg-white rounded-none border border-[#0BA20B]/30 overflow-hidden shadow-sm">
<button class="w-full p-5 text-left flex items-center justify-between font-bold text-sm text-[#2C221E] hover:text-[#0BA20B] transition-colors">
<span class="flex items-center gap-2">
<svg aria-hidden="true" class="lucide lucide-circle-question-mark w-4 h-4 text-[#0BA20B]" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<circle cx="12" cy="12" r="10">
</circle>
<path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3">
</path>
<path d="M12 17h.01">
</path>
</svg>
        Comment puis-je réserver un cours de musique ou un atelier ?
       </span>
<svg aria-hidden="true" class="lucide lucide-chevron-up w-4 h-4" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="m18 15-6-6-6 6">
</path>
</svg>
</button>
<div class="p-5 pt-0 text-xs text-[#6B574F] font-sans leading-relaxed border-t border-[#0BA20B]/10 animate-in fade-in duration-200">
       Vous pouvez réserver directement en ligne via le bouton 'Réserver un cours' ou dans la section Formations. Choisissez votre discipline, l'enseignant, le créneau horaire souhaité et confirmez votre inscription.
      </div>
</div>
<div class="bg-white rounded-none border border-[#0BA20B]/30 overflow-hidden shadow-sm">
<button class="w-full p-5 text-left flex items-center justify-between font-bold text-sm text-[#2C221E] hover:text-[#0BA20B] transition-colors">
<span class="flex items-center gap-2">
<svg aria-hidden="true" class="lucide lucide-circle-question-mark w-4 h-4 text-[#0BA20B]" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<circle cx="12" cy="12" r="10">
</circle>
<path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3">
</path>
<path d="M12 17h.01">
</path>
</svg>
        Le matériel est-il fourni pour les ateliers d'artisanat du raphia ?
       </span>
<svg aria-hidden="true" class="lucide lucide-chevron-down w-4 h-4" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="m6 9 6 6 6-6">
</path>
</svg>
</button>
</div>
<div class="bg-white rounded-none border border-[#0BA20B]/30 overflow-hidden shadow-sm">
<button class="w-full p-5 text-left flex items-center justify-between font-bold text-sm text-[#2C221E] hover:text-[#0BA20B] transition-colors">
<span class="flex items-center gap-2">
<svg aria-hidden="true" class="lucide lucide-circle-question-mark w-4 h-4 text-[#0BA20B]" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<circle cx="12" cy="12" r="10">
</circle>
<path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3">
</path>
<path d="M12 17h.01">
</path>
</svg>
        Comment fonctionne le programme de promotion des jeunes talents ?
       </span>
<svg aria-hidden="true" class="lucide lucide-chevron-down w-4 h-4" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="m6 9 6 6 6-6">
</path>
</svg>
</button>
</div>
<div class="bg-white rounded-none border border-[#0BA20B]/30 overflow-hidden shadow-sm">
<button class="w-full p-5 text-left flex items-center justify-between font-bold text-sm text-[#2C221E] hover:text-[#0BA20B] transition-colors">
<span class="flex items-center gap-2">
<svg aria-hidden="true" class="lucide lucide-circle-question-mark w-4 h-4 text-[#0BA20B]" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<circle cx="12" cy="12" r="10">
</circle>
<path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3">
</path>
<path d="M12 17h.01">
</path>
</svg>
        Puis-je bénéficier d'une déduction fiscale pour un don à l'association ?
       </span>
<svg aria-hidden="true" class="lucide lucide-chevron-down w-4 h-4" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="m6 9 6 6 6-6">
</path>
</svg>
</button>
</div>
<div class="bg-white rounded-none border border-[#0BA20B]/30 overflow-hidden shadow-sm">
<button class="w-full p-5 text-left flex items-center justify-between font-bold text-sm text-[#2C221E] hover:text-[#0BA20B] transition-colors">
<span class="flex items-center gap-2">
<svg aria-hidden="true" class="lucide lucide-circle-question-mark w-4 h-4 text-[#0BA20B]" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<circle cx="12" cy="12" r="10">
</circle>
<path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3">
</path>
<path d="M12 17h.01">
</path>
</svg>
        Les cours sont-ils adaptés aux débutants complets ?
       </span>
<svg aria-hidden="true" class="lucide lucide-chevron-down w-4 h-4" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="m6 9 6 6 6-6">
</path>
</svg>
</button>
</div>
</div>
</div>
</div>
</section>
@endsection
