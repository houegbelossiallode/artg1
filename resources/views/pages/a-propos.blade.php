@extends('layouts.app')
@section('title', 'Écho & Culture — À Propos')

@section('content')
<section class="pt-32 pb-24 bg-[#FAF7F2] relative overflow-hidden" id="about">
<div class="absolute top-0 right-0 w-96 h-96 bg-[#0BA20B]/10 rounded-full blur-3xl -z-10">
</div>
<div class="absolute bottom-0 left-0 w-96 h-96 bg-[#0BA20B]/10 rounded-full blur-3xl -z-10">
</div>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-20">
<div class="text-center max-w-3xl mx-auto space-y-4">
<div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-none bg-[#F4EFE6] border border-[#0BA20B]/30 text-[#0BA20B] text-xs font-bold uppercase tracking-widest">
<svg aria-hidden="true" class="lucide lucide-sparkles w-3.5 h-3.5" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z">
</path>
<path d="M20 2v4">
</path>
<path d="M22 4h-4">
</path>
<circle cx="4" cy="20" r="2">
</circle>
</svg>
<span>
      Notre Historique &amp; Notre Vision
     </span>
</div>
<h2 class="font-serif-title text-3xl sm:text-4xl md:text-5xl font-bold text-[#2C221E] tracking-tight">
     Transmettre l’héritage culturel, valoriser les savoir-faire de la terre et propulser la jeunesse.
    </h2>
<p class="text-sm sm:text-base text-[#6B574F] font-sans leading-relaxed">
     Née de la passion d’artistes, de maîtres-enseignants et d’artisans passionnés, l’association œuvre pour la sauvegarde des traditions africaines tout en intégrant l’expression créative contemporaine.
    </p>
</div>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
<div class="space-y-6">
<h3 class="font-serif-title text-2xl sm:text-3xl font-bold text-[#2C221E] border-l-4 border-[#0BA20B] pl-4">
      Une mission vivante au cœur des communautés
     </h3>
<p class="text-sm sm:text-base text-[#5C4A42] leading-relaxed">
      Notre organisation s'articule autour d'une synergie unique : marier la
      <strong>
       pratique musicale
      </strong>
      (instruments traditionnels comme la Kora, le Balafon, le Djembé et chorale polyphonique) avec la
      <strong>
       valorisation agricole et artisanale du Raphia
      </strong>
      .
     </p>
<p class="text-sm sm:text-base text-[#5C4A42] leading-relaxed">
      Le Raphia n'est pas seulement un matériau végétal : c'est un symbole identitaire d'écologie, de patience et de tressage social. À travers nos ateliers, nous formons les femmes, les jeunes et les passionnés à la fabrication d'objets utilitaires et de décoration haut de gamme.
     </p>
<div class="space-y-3 pt-2">
<div class="flex items-start gap-3">
<svg aria-hidden="true" class="lucide lucide-circle-check w-5 h-5 text-[#0BA20B] shrink-0 mt-0.5" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<circle cx="12" cy="12" r="10">
</circle>
<path d="m9 12 2 2 4-4">
</path>
</svg>
<div>
<h4 class="text-sm font-bold text-[#2C221E]">
         Transmission Pédagogique Rigoireuse
        </h4>
<p class="text-xs text-[#6B574F]">
         Des cours structurés dispensés par des enseignants certifiés et des maÎtres-griots d'exception.
        </p>
</div>
</div>
<div class="flex items-start gap-3">
<svg aria-hidden="true" class="lucide lucide-circle-check w-5 h-5 text-[#0BA20B] shrink-0 mt-0.5" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<circle cx="12" cy="12" r="10">
</circle>
<path d="m9 12 2 2 4-4">
</path>
</svg>
<div>
<h4 class="text-sm font-bold text-[#2C221E]">
         Filière Artisanale Éco-Responsable
        </h4>
<p class="text-xs text-[#6B574F]">
         De la culture locale du Raphia jusqu'à la création d'objets décoratifs d'exception.
        </p>
</div>
</div>
<div class="flex items-start gap-3">
<svg aria-hidden="true" class="lucide lucide-circle-check w-5 h-5 text-[#0BA20B] shrink-0 mt-0.5" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<circle cx="12" cy="12" r="10">
</circle>
<path d="m9 12 2 2 4-4">
</path>
</svg>
<div>
<h4 class="text-sm font-bold text-[#2C221E]">
         Tremplin pour les Jeunes Talents
        </h4>
<p class="text-xs text-[#6B574F]">
         Résidences de création, enregistrement en studio et accompagnement scénique gratuit.
        </p>
</div>
</div>
</div>
</div>
<div class="relative">
<div class="relative rounded-none overflow-hidden shadow-2xl border-4 border-white">
<img alt="Enseignement musical et atelier culturel" class="w-full h-[400px] object-cover" referrerpolicy="no-referrer" src="https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&amp;fit=crop&amp;q=80&amp;w=900"/>
<div class="absolute inset-0 bg-gradient-to-t from-[#1E1613]/80 via-transparent to-transparent">
</div>
<div class="absolute bottom-6 left-6 right-6 text-white">
<span class="text-xs uppercase font-bold text-[#0BA20B] bg-[#1E1613]/80 px-2.5 py-1 rounded-none">
        Atelier Vivant
       </span>
<p class="text-sm font-serif-title italic mt-2 text-white/90">
        « La culture ne s'hérite pas seulement, elle se cultive chaque jour. »
       </p>
</div>
</div>
<div class="absolute -bottom-6 -left-6 bg-[#1E1613] text-[#FAF7F2] p-5 rounded-none shadow-xl border border-[#0BA20B]/40 max-w-xs hidden sm:block">
<div class="flex items-center gap-3">
<div class="w-10 h-10 rounded-none bg-[#0BA20B] flex items-center justify-center text-white shrink-0">
<svg aria-hidden="true" class="lucide lucide-shield-check w-5 h-5" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z">
</path>
<path d="m9 12 2 2 4-4">
</path>
</svg>
</div>
<div>
<span class="text-xs font-bold text-[#0BA20B] uppercase tracking-wider block">
         Association Agréée
        </span>
<span class="text-xs text-white/80">
         Reconnue d'Intérêt Culturel &amp; Social
        </span>
</div>
</div>
</div>
</div>
</div>
<div class="grid grid-cols-2 lg:grid-cols-4 gap-6 pt-8">
<div class="glass-panel rounded-none p-6 text-center space-y-2 hover:border-[#0BA20B]/40 transition-all transform hover:-translate-y-1 shadow-sm">
<div class="text-3xl sm:text-4xl font-bold font-serif-title text-[#0BA20B]">
      350+
     </div>
<div class="text-xs sm:text-sm font-semibold text-[#2C221E]">
      Apprenants Accompagnés
     </div>
</div>
<div class="glass-panel rounded-none p-6 text-center space-y-2 hover:border-[#0BA20B]/40 transition-all transform hover:-translate-y-1 shadow-sm">
<div class="text-3xl sm:text-4xl font-bold font-serif-title text-[#0BA20B]">
      18
     </div>
<div class="text-xs sm:text-sm font-semibold text-[#2C221E]">
      Maitres-Enseignants &amp; Artistes
     </div>
</div>
<div class="glass-panel rounded-none p-6 text-center space-y-2 hover:border-[#0BA20B]/40 transition-all transform hover:-translate-y-1 shadow-sm">
<div class="text-3xl sm:text-4xl font-bold font-serif-title text-[#0BA20B]">
      45+
     </div>
<div class="text-xs sm:text-sm font-semibold text-[#2C221E]">
      Événements &amp; Éco-Ateliers / an
     </div>
</div>
<div class="glass-panel rounded-none p-6 text-center space-y-2 hover:border-[#0BA20B]/40 transition-all transform hover:-translate-y-1 shadow-sm">
<div class="text-3xl sm:text-4xl font-bold font-serif-title text-[#0BA20B]">
      120+
     </div>
<div class="text-xs sm:text-sm font-semibold text-[#2C221E]">
      Œuvres en Raphia Façonnées
     </div>
</div>
</div>
<div class="pt-12 border-t border-[#0BA20B]/20 space-y-8" id="team">
<div class="text-center space-y-2">
<h3 class="font-serif-title text-2xl font-bold text-[#2C221E]">
      Équipe Dirigeante &amp; Maîtres-Artisans
     </h3>
<p class="text-xs sm:text-sm text-[#6B574F]">
      Des passionnés engagés pour la transmission des savoirs.
     </p>
</div>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
<div class="bg-white rounded-none p-4 border border-[#0BA20B]/20 text-center space-y-3 shadow-sm hover:shadow-md transition-shadow">
<img alt="Maître Sekou Kouyaté" class="w-20 h-20 rounded-none mx-auto object-cover ring-2 ring-[#0BA20B]/40" referrerpolicy="no-referrer" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&amp;fit=crop&amp;q=80&amp;w=300"/>
<div>
<h4 class="font-bold text-sm text-[#2C221E]">
        Maître Sekou Kouyaté
       </h4>
<p class="text-xs text-[#0BA20B] font-medium">
        Directeur Musical &amp; Conservateur
       </p>
</div>
</div>
<div class="bg-white rounded-none p-4 border border-[#0BA20B]/20 text-center space-y-3 shadow-sm hover:shadow-md transition-shadow">
<img alt="Maman Rose Edjang" class="w-20 h-20 rounded-none mx-auto object-cover ring-2 ring-[#0BA20B]/40" referrerpolicy="no-referrer" src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&amp;fit=crop&amp;q=80&amp;w=300"/>
<div>
<h4 class="font-bold text-sm text-[#2C221E]">
        Maman Rose Edjang
       </h4>
<p class="text-xs text-[#0BA20B] font-medium">
        Responsable Pôle Raphia &amp; Artisanat
       </p>
</div>
</div>
<div class="bg-white rounded-none p-4 border border-[#0BA20B]/20 text-center space-y-3 shadow-sm hover:shadow-md transition-shadow">
<img alt="Aline Mercier" class="w-20 h-20 rounded-none mx-auto object-cover ring-2 ring-[#0BA20B]/40" referrerpolicy="no-referrer" src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&amp;fit=crop&amp;q=80&amp;w=300"/>
<div>
<h4 class="font-bold text-sm text-[#2C221E]">
        Aline Mercier
       </h4>
<p class="text-xs text-[#0BA20B] font-medium">
        Coordinatrice Pédagogique Piano/Chant
       </p>
</div>
</div>
<div class="bg-white rounded-none p-4 border border-[#0BA20B]/20 text-center space-y-3 shadow-sm hover:shadow-md transition-shadow">
<img alt="Dr. Joseph Nguema" class="w-20 h-20 rounded-none mx-auto object-cover ring-2 ring-[#0BA20B]/40" referrerpolicy="no-referrer" src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&amp;fit=crop&amp;q=80&amp;w=300"/>
<div>
<h4 class="font-bold text-sm text-[#2C221E]">
        Dr. Joseph Nguema
       </h4>
<p class="text-xs text-[#0BA20B] font-medium">
        Président du Conseil Associatif
       </p>
</div>
</div>
</div>
</div>
</div>
</section>
@endsection
