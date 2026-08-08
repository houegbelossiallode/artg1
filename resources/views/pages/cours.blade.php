      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif
<div class="text-center max-w-3xl mx-auto space-y-4">
<div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-none bg-[#F4EFE6] border border-[#D4A373]/40 text-[#C85A32] text-xs font-bold uppercase tracking-widest">
<svg aria-hidden="true" class="lucide lucide-graduation-cap w-3.5 h-3.5" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z">
</path>
<path d="M22 10v6">
</path>
<path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5">
</path>
</svg>
<span>
      Formations, Ateliers &amp; Transmission des Savoirs
     </span>
</div>
<h2 class="font-serif-title text-3xl sm:text-4xl md:text-5xl font-bold text-[#2C221E] tracking-tight">
     Catalogue des Cours &amp; Ateliers de Pratique
    </h2>
<p class="text-sm sm:text-base text-[#6B574F] font-sans leading-relaxed">
     Formez-vous aux instruments traditionnels et modernes, à la polyphonie vocale ou au tressage éco-artisanat du Raphia. Cours dispensés en présentiel ou à distance.
    </p>
</div>
<div class="bg-[#F4EFE6] p-4 rounded-none border border-[#D4A373]/30 flex flex-col md:flex-row items-center justify-between gap-4">
    <div class="flex items-center gap-2 overflow-x-auto w-full md:w-auto pb-2 md:pb-0">
        <span class="text-xs font-bold text-[#2C221E] uppercase flex items-center gap-1 shrink-0">
            <svg aria-hidden="true" class="lucide lucide-funnel w-3.5 h-3.5 text-[#C85A32]" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                <path d="M10 20a1 1 0 0 0 .553.895l2 1A1 1 0 0 0 14 21v-7a2 2 0 0 1 .517-1.341L21.74 4.67A1 1 0 0 0 21 3H3a1 1 0 0 0-.742 1.67l7.225 7.989A2 2 0 0 1 10 14z"></path>
            </svg>
            Catégories :
        </span>
        <button class="px-3 py-1.5 rounded-none text-xs font-semibold capitalize whitespace-nowrap transition-all bg-[#C85A32] text-white shadow-sm">
            Tous
        </button>
        @foreach($categoriesCours ?? [] as $cat)
            <button class="px-3 py-1.5 rounded-none text-xs font-semibold capitalize whitespace-nowrap transition-all bg-[#FAF7F2] text-[#2C221E] hover:bg-white border border-[#D4A373]/30">
                {{ $cat->nom }}
            </button>
        @endforeach
    </div>
    <div class="flex items-center gap-2 shrink-0 overflow-x-auto">
        <span class="text-xs font-bold text-[#2C221E] uppercase">
            Modes :
        </span>
        <button class="px-3 py-1.5 rounded-none text-xs font-semibold transition-all bg-[#2C221E] text-white shadow-sm">
            Tous
        </button>
        @foreach($modes ?? [] as $m)
            <button class="px-3 py-1.5 rounded-none text-xs font-semibold transition-all bg-[#FAF7F2] text-[#2C221E] hover:bg-white border border-[#D4A373]/30">
                {{ $m->libelle }}
            </button>
        @endforeach
    </div>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
<div class="bg-white rounded-none overflow-hidden border border-[#D4A373]/30 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
<div>
<div class="relative h-52 overflow-hidden">
<img alt="Initiation à la Kora &amp; Instruments Traditionnels" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" referrerpolicy="no-referrer" src="https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&amp;fit=crop&amp;q=80&amp;w=800"/>
<div class="absolute top-3 left-3 right-3 flex items-center justify-between">
<span class="bg-[#1E1613]/85 text-[#D4A373] text-[10px] font-bold px-2.5 py-1 rounded-none backdrop-blur-sm uppercase">
         musique
        </span>
<span class="text-[10px] font-bold px-2.5 py-1 rounded-none text-white backdrop-blur-sm bg-[#C85A32]">
         Présentiel
        </span>
</div>
<div class="absolute bottom-3 left-3 bg-[#1E1613]/80 text-white text-[10px] font-semibold px-2 py-0.5 rounded-none backdrop-blur-sm">
        Tous niveaux
       </div>
</div>
<div class="p-6 space-y-4">
<div class="flex items-center gap-3 pb-3 border-b border-[#D4A373]/20">
<img alt="Maître Sekou Kouyaté" class="w-10 h-10 rounded-none object-cover ring-2 ring-[#D4A373]/40" referrerpolicy="no-referrer" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&amp;fit=crop&amp;q=80&amp;w=300"/>
<div>
<h5 class="font-bold text-xs text-[#2C221E]">
          Maître Sekou Kouyaté
         </h5>
<span class="text-[10px] text-[#C85A32] font-semibold">
          Virtuose de la Kora &amp; Griot
         </span>
</div>
</div>
<h4 class="font-serif-title font-bold text-lg text-[#2C221E] leading-snug line-clamp-2">
        Initiation à la Kora &amp; Instruments Traditionnels
       </h4>
<p class="text-xs text-[#6B574F] line-clamp-3 leading-relaxed">
        Apprenez les accords ancestraux de la harpe-luth ouest-africaine. Travail de la posture, du pincement des cordes et des rythmes traditionnels.
       </p>
<div class="space-y-1.5 text-xs text-[#8C766B] pt-2 border-t border-[#D4A373]/20">
<p class="flex items-center gap-2">
<svg aria-hidden="true" class="lucide lucide-calendar w-3.5 h-3.5 text-[#D4A373]" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="M8 2v4">
</path>
<path d="M16 2v4">
</path>
<rect height="18" rx="2" width="18" x="3" y="4">
</rect>
<path d="M3 10h18">
</path>
</svg>
<span>
          Mardi &amp; Samedi • 15h00
         </span>
</p>
<p class="flex items-center gap-2">
<svg aria-hidden="true" class="lucide lucide-clock w-3.5 h-3.5 text-[#D4A373]" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="M12 6v6l4 2">
</path>
<circle cx="12" cy="12" r="10">
</circle>
</svg>
<span>
          1h30 / séance
         </span>
</p>
<p class="flex items-center gap-2">
<svg aria-hidden="true" class="lucide lucide-users w-3.5 h-3.5 text-[#D4A373]" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2">
</path>
<path d="M16 3.128a4 4 0 0 1 0 7.744">
</path>
<path d="M22 21v-2a4 4 0 0 0-3-3.87">
</path>
<circle cx="9" cy="7" r="4">
</circle>
</svg>
<span>
          Places disponibles:
          <strong class="text-[#C85A32]">
           4 places
          </strong>
</span>
</p>
</div>
</div>
</div>
<div class="p-6 pt-0 flex items-center justify-between border-t border-[#D4A373]/10 mt-2">
<div>
<span class="text-[10px] uppercase text-[#8C766B] block">
        Tarif
       </span>
<span class="font-bold font-serif-title text-base text-[#C85A32]">
        25€ / séance
       </span>
</div>
<button class="px-4 py-2 rounded-none bg-[#C85A32] hover:bg-[#A84223] text-white text-xs font-bold transition-all shadow-md hover:shadow-lg flex items-center gap-1.5">
<svg aria-hidden="true" class="lucide lucide-graduation-cap w-4 h-4" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z">
</path>
<path d="M22 10v6">
</path>
<path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5">
</path>
</svg>
<span>
        S'inscrire
       </span>
</button>
</div>
</div>
<div class="bg-white rounded-none overflow-hidden border border-[#D4A373]/30 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
<div>
<div class="relative h-52 overflow-hidden">
<img alt="Piano &amp; Harmonisation Polyphonique" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" referrerpolicy="no-referrer" src="https://images.unsplash.com/photo-1520523839897-bd0b52f945a0?auto=format&amp;fit=crop&amp;q=80&amp;w=800"/>
<div class="absolute top-3 left-3 right-3 flex items-center justify-between">
<span class="bg-[#1E1613]/85 text-[#D4A373] text-[10px] font-bold px-2.5 py-1 rounded-none backdrop-blur-sm uppercase">
         musique
        </span>
<span class="text-[10px] font-bold px-2.5 py-1 rounded-none text-white backdrop-blur-sm bg-[#B8860B]">
         Hybride
        </span>
</div>
<div class="absolute bottom-3 left-3 bg-[#1E1613]/80 text-white text-[10px] font-semibold px-2 py-0.5 rounded-none backdrop-blur-sm">
        Intermédiaire
       </div>
</div>
<div class="p-6 space-y-4">
<div class="flex items-center gap-3 pb-3 border-b border-[#D4A373]/20">
<img alt="Aline Mercier" class="w-10 h-10 rounded-none object-cover ring-2 ring-[#D4A373]/40" referrerpolicy="no-referrer" src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&amp;fit=crop&amp;q=80&amp;w=300"/>
<div>
<h5 class="font-bold text-xs text-[#2C221E]">
          Aline Mercier
         </h5>
<span class="text-[10px] text-[#C85A32] font-semibold">
          Pianiste &amp; Compositrice
         </span>
</div>
</div>
<h4 class="font-serif-title font-bold text-lg text-[#2C221E] leading-snug line-clamp-2">
        Piano &amp; Harmonisation Polyphonique
       </h4>
<p class="text-xs text-[#6B574F] line-clamp-3 leading-relaxed">
        Combinaison de la théorie classique et de l’improvisation rythmique afro-jazz. Idéal pour pianistes souhaitant enrichir leur vocabulaire harmonique.
       </p>
<div class="space-y-1.5 text-xs text-[#8C766B] pt-2 border-t border-[#D4A373]/20">
<p class="flex items-center gap-2">
<svg aria-hidden="true" class="lucide lucide-calendar w-3.5 h-3.5 text-[#D4A373]" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="M8 2v4">
</path>
<path d="M16 2v4">
</path>
<rect height="18" rx="2" width="18" x="3" y="4">
</rect>
<path d="M3 10h18">
</path>
</svg>
<span>
          Mercredi &amp; Vendredi • 17h30
         </span>
</p>
<p class="flex items-center gap-2">
<svg aria-hidden="true" class="lucide lucide-clock w-3.5 h-3.5 text-[#D4A373]" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="M12 6v6l4 2">
</path>
<circle cx="12" cy="12" r="10">
</circle>
</svg>
<span>
          1h00 / séance
         </span>
</p>
<p class="flex items-center gap-2">
<svg aria-hidden="true" class="lucide lucide-users w-3.5 h-3.5 text-[#D4A373]" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2">
</path>
<path d="M16 3.128a4 4 0 0 1 0 7.744">
</path>
<path d="M22 21v-2a4 4 0 0 0-3-3.87">
</path>
<circle cx="9" cy="7" r="4">
</circle>
</svg>
<span>
          Places disponibles:
          <strong class="text-[#C85A32]">
           2 places
          </strong>
</span>
</p>
</div>
</div>
</div>
<div class="p-6 pt-0 flex items-center justify-between border-t border-[#D4A373]/10 mt-2">
<div>
<span class="text-[10px] uppercase text-[#8C766B] block">
        Tarif
       </span>
<span class="font-bold font-serif-title text-base text-[#C85A32]">
        30€ / séance
       </span>
</div>
<button class="px-4 py-2 rounded-none bg-[#C85A32] hover:bg-[#A84223] text-white text-xs font-bold transition-all shadow-md hover:shadow-lg flex items-center gap-1.5">
<svg aria-hidden="true" class="lucide lucide-graduation-cap w-4 h-4" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z">
</path>
<path d="M22 10v6">
</path>
<path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5">
</path>
</svg>
<span>
        S'inscrire
       </span>
</button>
</div>
</div>
<div class="bg-white rounded-none overflow-hidden border border-[#D4A373]/30 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
<div>
<div class="relative h-52 overflow-hidden">
<img alt="Percussions Africaines (Djembé &amp; Balafon)" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" referrerpolicy="no-referrer" src="https://images.unsplash.com/photo-1519892300165-cb5542fb47c7?auto=format&amp;fit=crop&amp;q=80&amp;w=800"/>
<div class="absolute top-3 left-3 right-3 flex items-center justify-between">
<span class="bg-[#1E1613]/85 text-[#D4A373] text-[10px] font-bold px-2.5 py-1 rounded-none backdrop-blur-sm uppercase">
         percussion
        </span>
<span class="text-[10px] font-bold px-2.5 py-1 rounded-none text-white backdrop-blur-sm bg-[#C85A32]">
         Présentiel
        </span>
</div>
<div class="absolute bottom-3 left-3 bg-[#1E1613]/80 text-white text-[10px] font-semibold px-2 py-0.5 rounded-none backdrop-blur-sm">
        Tous niveaux
       </div>
</div>
<div class="p-6 space-y-4">
<div class="flex items-center gap-3 pb-3 border-b border-[#D4A373]/20">
<img alt="Bakary Traoré" class="w-10 h-10 rounded-none object-cover ring-2 ring-[#D4A373]/40" referrerpolicy="no-referrer" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&amp;fit=crop&amp;q=80&amp;w=300"/>
<div>
<h5 class="font-bold text-xs text-[#2C221E]">
          Bakary Traoré
         </h5>
<span class="text-[10px] text-[#C85A32] font-semibold">
          Percussionniste Soliste
         </span>
</div>
</div>
<h4 class="font-serif-title font-bold text-lg text-[#2C221E] leading-snug line-clamp-2">
        Percussions Africaines (Djembé &amp; Balafon)
       </h4>
<p class="text-xs text-[#6B574F] line-clamp-3 leading-relaxed">
        Découverte de la frappe, de la clarté des sons (basse, tonique, claqué) et maîtrise des polyrythmies festives et cérémonielles.
       </p>
<div class="space-y-1.5 text-xs text-[#8C766B] pt-2 border-t border-[#D4A373]/20">
<p class="flex items-center gap-2">
<svg aria-hidden="true" class="lucide lucide-calendar w-3.5 h-3.5 text-[#D4A373]" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="M8 2v4">
</path>
<path d="M16 2v4">
</path>
<rect height="18" rx="2" width="18" x="3" y="4">
</rect>
<path d="M3 10h18">
</path>
</svg>
<span>
          Samedi • 10h00
         </span>
</p>
<p class="flex items-center gap-2">
<svg aria-hidden="true" class="lucide lucide-clock w-3.5 h-3.5 text-[#D4A373]" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="M12 6v6l4 2">
</path>
<circle cx="12" cy="12" r="10">
</circle>
</svg>
<span>
          2h00 / séance
         </span>
</p>
<p class="flex items-center gap-2">
<svg aria-hidden="true" class="lucide lucide-users w-3.5 h-3.5 text-[#D4A373]" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2">
</path>
<path d="M16 3.128a4 4 0 0 1 0 7.744">
</path>
<path d="M22 21v-2a4 4 0 0 0-3-3.87">
</path>
<circle cx="9" cy="7" r="4">
</circle>
</svg>
<span>
          Places disponibles:
          <strong class="text-[#C85A32]">
           6 places
          </strong>
</span>
</p>
</div>
</div>
</div>
<div class="p-6 pt-0 flex items-center justify-between border-t border-[#D4A373]/10 mt-2">
<div>
<span class="text-[10px] uppercase text-[#8C766B] block">
        Tarif
       </span>
<span class="font-bold font-serif-title text-base text-[#C85A32]">
        20€ / séance
       </span>
</div>
<button class="px-4 py-2 rounded-none bg-[#C85A32] hover:bg-[#A84223] text-white text-xs font-bold transition-all shadow-md hover:shadow-lg flex items-center gap-1.5">
<svg aria-hidden="true" class="lucide lucide-graduation-cap w-4 h-4" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z">
</path>
<path d="M22 10v6">
</path>
<path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5">
</path>
</svg>
<span>
        S'inscrire
       </span>
</button>
</div>
</div>
<div class="bg-white rounded-none overflow-hidden border border-[#D4A373]/30 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
<div>
<div class="relative h-52 overflow-hidden">
<img alt="Tissage Traditionnel &amp; Eco-Artisanat du Raphia" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" referrerpolicy="no-referrer" src="/assets/raphia_artisanal_crafts_1785764982514-DDF_8lz7.jpg"/>
<div class="absolute top-3 left-3 right-3 flex items-center justify-between">
<span class="bg-[#1E1613]/85 text-[#D4A373] text-[10px] font-bold px-2.5 py-1 rounded-none backdrop-blur-sm uppercase">
         artisanat
        </span>
<span class="text-[10px] font-bold px-2.5 py-1 rounded-none text-white backdrop-blur-sm bg-[#C85A32]">
         Présentiel
        </span>
</div>
<div class="absolute bottom-3 left-3 bg-[#1E1613]/80 text-white text-[10px] font-semibold px-2 py-0.5 rounded-none backdrop-blur-sm">
        Débutant
       </div>
</div>
<div class="p-6 space-y-4">
<div class="flex items-center gap-3 pb-3 border-b border-[#D4A373]/20">
<img alt="Maman Rose Edjang" class="w-10 h-10 rounded-none object-cover ring-2 ring-[#D4A373]/40" referrerpolicy="no-referrer" src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&amp;fit=crop&amp;q=80&amp;w=300"/>
<div>
<h5 class="font-bold text-xs text-[#2C221E]">
          Maman Rose Edjang
         </h5>
<span class="text-[10px] text-[#C85A32] font-semibold">
          Maitre Artisane du Raphia
         </span>
</div>
</div>
<h4 class="font-serif-title font-bold text-lg text-[#2C221E] leading-snug line-clamp-2">
        Tissage Traditionnel &amp; Eco-Artisanat du Raphia
       </h4>
<p class="text-xs text-[#6B574F] line-clamp-3 leading-relaxed">
        Inscrivez-vous à la transformation de la fibre de raphia : séchage, teinture végétale, tressage et fabrication de vanneries ou objets de décoration.
       </p>
<div class="space-y-1.5 text-xs text-[#8C766B] pt-2 border-t border-[#D4A373]/20">
<p class="flex items-center gap-2">
<svg aria-hidden="true" class="lucide lucide-calendar w-3.5 h-3.5 text-[#D4A373]" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="M8 2v4">
</path>
<path d="M16 2v4">
</path>
<rect height="18" rx="2" width="18" x="3" y="4">
</rect>
<path d="M3 10h18">
</path>
</svg>
<span>
          Dimanche • 14h00
         </span>
</p>
<p class="flex items-center gap-2">
<svg aria-hidden="true" class="lucide lucide-clock w-3.5 h-3.5 text-[#D4A373]" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="M12 6v6l4 2">
</path>
<circle cx="12" cy="12" r="10">
</circle>
</svg>
<span>
          3h00 / atelier
         </span>
</p>
<p class="flex items-center gap-2">
<svg aria-hidden="true" class="lucide lucide-users w-3.5 h-3.5 text-[#D4A373]" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2">
</path>
<path d="M16 3.128a4 4 0 0 1 0 7.744">
</path>
<path d="M22 21v-2a4 4 0 0 0-3-3.87">
</path>
<circle cx="9" cy="7" r="4">
</circle>
</svg>
<span>
          Places disponibles:
          <strong class="text-[#C85A32]">
           5 places
          </strong>
</span>
</p>
</div>
</div>
</div>
<div class="p-6 pt-0 flex items-center justify-between border-t border-[#D4A373]/10 mt-2">
<div>
<span class="text-[10px] uppercase text-[#8C766B] block">
        Tarif
       </span>
<span class="font-bold font-serif-title text-base text-[#C85A32]">
        35€ (Matériel inclus)
       </span>
</div>
<button class="px-4 py-2 rounded-none bg-[#C85A32] hover:bg-[#A84223] text-white text-xs font-bold transition-all shadow-md hover:shadow-lg flex items-center gap-1.5">
<svg aria-hidden="true" class="lucide lucide-graduation-cap w-4 h-4" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z">
</path>
<path d="M22 10v6">
</path>
<path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5">
</path>
</svg>
<span>
        S'inscrire
       </span>
</button>
</div>
</div>
<div class="bg-white rounded-none overflow-hidden border border-[#D4A373]/30 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
<div>
<div class="relative h-52 overflow-hidden">
<img alt="Technique Vocale &amp; Chorale Polyphonique" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" referrerpolicy="no-referrer" src="https://images.unsplash.com/photo-1516280440614-37939bbacd81?auto=format&amp;fit=crop&amp;q=80&amp;w=800"/>
<div class="absolute top-3 left-3 right-3 flex items-center justify-between">
<span class="bg-[#1E1613]/85 text-[#D4A373] text-[10px] font-bold px-2.5 py-1 rounded-none backdrop-blur-sm uppercase">
         chant
        </span>
<span class="text-[10px] font-bold px-2.5 py-1 rounded-none text-white backdrop-blur-sm bg-[#C85A32]">
         Présentiel
        </span>
</div>
<div class="absolute bottom-3 left-3 bg-[#1E1613]/80 text-white text-[10px] font-semibold px-2 py-0.5 rounded-none backdrop-blur-sm">
        Tous niveaux
       </div>
</div>
<div class="p-6 space-y-4">
<div class="flex items-center gap-3 pb-3 border-b border-[#D4A373]/20">
<img alt="Grace Nseke" class="w-10 h-10 rounded-none object-cover ring-2 ring-[#D4A373]/40" referrerpolicy="no-referrer" src="https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?auto=format&amp;fit=crop&amp;q=80&amp;w=300"/>
<div>
<h5 class="font-bold text-xs text-[#2C221E]">
          Grace Nseke
         </h5>
<span class="text-[10px] text-[#C85A32] font-semibold">
          Cheffe de Chœur
         </span>
</div>
</div>
<h4 class="font-serif-title font-bold text-lg text-[#2C221E] leading-snug line-clamp-2">
        Technique Vocale &amp; Chorale Polyphonique
       </h4>
<p class="text-xs text-[#6B574F] line-clamp-3 leading-relaxed">
        Développement du souffle, harmonie à plusieurs voix, répertoires sacrés et populaires traditionnels d’Afrique et du monde.
       </p>
<div class="space-y-1.5 text-xs text-[#8C766B] pt-2 border-t border-[#D4A373]/20">
<p class="flex items-center gap-2">
<svg aria-hidden="true" class="lucide lucide-calendar w-3.5 h-3.5 text-[#D4A373]" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="M8 2v4">
</path>
<path d="M16 2v4">
</path>
<rect height="18" rx="2" width="18" x="3" y="4">
</rect>
<path d="M3 10h18">
</path>
</svg>
<span>
          Jeudi • 19h00
         </span>
</p>
<p class="flex items-center gap-2">
<svg aria-hidden="true" class="lucide lucide-clock w-3.5 h-3.5 text-[#D4A373]" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="M12 6v6l4 2">
</path>
<circle cx="12" cy="12" r="10">
</circle>
</svg>
<span>
          1h45 / séance
         </span>
</p>
<p class="flex items-center gap-2">
<svg aria-hidden="true" class="lucide lucide-users w-3.5 h-3.5 text-[#D4A373]" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2">
</path>
<path d="M16 3.128a4 4 0 0 1 0 7.744">
</path>
<path d="M22 21v-2a4 4 0 0 0-3-3.87">
</path>
<circle cx="9" cy="7" r="4">
</circle>
</svg>
<span>
          Places disponibles:
          <strong class="text-[#C85A32]">
           8 places
          </strong>
</span>
</p>
</div>
</div>
</div>
<div class="p-6 pt-0 flex items-center justify-between border-t border-[#D4A373]/10 mt-2">
<div>
<span class="text-[10px] uppercase text-[#8C766B] block">
        Tarif
       </span>
<span class="font-bold font-serif-title text-base text-[#C85A32]">
        18€ / séance
       </span>
</div>
<button class="px-4 py-2 rounded-none bg-[#C85A32] hover:bg-[#A84223] text-white text-xs font-bold transition-all shadow-md hover:shadow-lg flex items-center gap-1.5">
<svg aria-hidden="true" class="lucide lucide-graduation-cap w-4 h-4" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z">
</path>
<path d="M22 10v6">
</path>
<path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5">
</path>
</svg>
<span>
        S'inscrire
       </span>
</button>
</div>
</div>
<div class="bg-white rounded-none overflow-hidden border border-[#D4A373]/30 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
<div>
<div class="relative h-52 overflow-hidden">
<img alt="Guitare Acoustique &amp; Rythmiques Africaines" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" referrerpolicy="no-referrer" src="https://images.unsplash.com/photo-1510915361894-db8b60106cb1?auto=format&amp;fit=crop&amp;q=80&amp;w=800"/>
<div class="absolute top-3 left-3 right-3 flex items-center justify-between">
<span class="bg-[#1E1613]/85 text-[#D4A373] text-[10px] font-bold px-2.5 py-1 rounded-none backdrop-blur-sm uppercase">
         musique
        </span>
<span class="text-[10px] font-bold px-2.5 py-1 rounded-none text-white backdrop-blur-sm bg-[#2D6A4F]">
         À distance
        </span>
</div>
<div class="absolute bottom-3 left-3 bg-[#1E1613]/80 text-white text-[10px] font-semibold px-2 py-0.5 rounded-none backdrop-blur-sm">
        Intermédiaire
       </div>
</div>
<div class="p-6 space-y-4">
<div class="flex items-center gap-3 pb-3 border-b border-[#D4A373]/20">
<img alt="David Mbo" class="w-10 h-10 rounded-none object-cover ring-2 ring-[#D4A373]/40" referrerpolicy="no-referrer" src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&amp;fit=crop&amp;q=80&amp;w=300"/>
<div>
<h5 class="font-bold text-xs text-[#2C221E]">
          David Mbo
         </h5>
<span class="text-[10px] text-[#C85A32] font-semibold">
          Guitariste &amp; Sound Designer
         </span>
</div>
</div>
<h4 class="font-serif-title font-bold text-lg text-[#2C221E] leading-snug line-clamp-2">
        Guitare Acoustique &amp; Rythmiques Africaines
       </h4>
<p class="text-xs text-[#6B574F] line-clamp-3 leading-relaxed">
        Exploration du style fingerpicking afro, des rythmes Makossa, Highlife et Soukous transposés sur guitare acoustique.
       </p>
<div class="space-y-1.5 text-xs text-[#8C766B] pt-2 border-t border-[#D4A373]/20">
<p class="flex items-center gap-2">
<svg aria-hidden="true" class="lucide lucide-calendar w-3.5 h-3.5 text-[#D4A373]" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="M8 2v4">
</path>
<path d="M16 2v4">
</path>
<rect height="18" rx="2" width="18" x="3" y="4">
</rect>
<path d="M3 10h18">
</path>
</svg>
<span>
          Lundi • 18h00
         </span>
</p>
<p class="flex items-center gap-2">
<svg aria-hidden="true" class="lucide lucide-clock w-3.5 h-3.5 text-[#D4A373]" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="M12 6v6l4 2">
</path>
<circle cx="12" cy="12" r="10">
</circle>
</svg>
<span>
          1h00 / séance
         </span>
</p>
<p class="flex items-center gap-2">
<svg aria-hidden="true" class="lucide lucide-users w-3.5 h-3.5 text-[#D4A373]" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2">
</path>
<path d="M16 3.128a4 4 0 0 1 0 7.744">
</path>
<path d="M22 21v-2a4 4 0 0 0-3-3.87">
</path>
<circle cx="9" cy="7" r="4">
</circle>
</svg>
<span>
          Places disponibles:
          <strong class="text-[#C85A32]">
           3 places
          </strong>
</span>
</p>
</div>
</div>
</div>
<div class="p-6 pt-0 flex items-center justify-between border-t border-[#D4A373]/10 mt-2">
<div>
<span class="text-[10px] uppercase text-[#8C766B] block">
        Tarif
       </span>
<span class="font-bold font-serif-title text-base text-[#C85A32]">
        22€ / séance
       </span>
</div>
<button @click="openBookingModal(1, 'Guitare Acoustique & Rythmiques Africaines', 'David Mbo')" class="px-4 py-2 rounded-none bg-[#C85A32] hover:bg-[#A84223] text-white text-xs font-bold transition-all shadow-md hover:shadow-lg flex items-center gap-1.5 cursor-pointer">
<svg aria-hidden="true" class="lucide lucide-graduation-cap w-4 h-4" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z">
</path>
<path d="M22 10v6">
</path>
<path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5">
</path>
</svg>
<span>
        S'inscrire
       </span>
</button>
</div>
</div>
</div>
</div>

  {{-- MODAL DE RÉSERVATION DE COURS SELON LES DISPONIBILITÉS DU PROFESSEUR --}}
  <div x-show="showModal"
       class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-[#1E1613]/70 backdrop-blur-sm"
       x-cloak
       style="display:none;">
    <div @click.away="showModal = false"
         class="bg-[#FAF7F2] w-full max-w-lg shadow-2xl border border-[#D4A373]/40 p-6 sm:p-8 relative">
      
      <div class="flex justify-between items-start border-b border-[#D4A373]/20 pb-4 mb-5">
        <div>
          <div class="flex items-center gap-2">
            <span class="text-[10px] font-bold uppercase tracking-widest text-[#C85A32]">Réservation de cours</span>
            <span x-show="coursMode" class="text-[9px] font-bold uppercase px-2 py-0.5 bg-[#1E1613] text-[#D4A373]" x-text="coursMode"></span>
          </div>
          <h3 class="font-serif-title font-bold text-xl text-[#2C221E] mt-0.5" x-text="coursTitre"></h3>
          <p class="text-xs text-[#6B574F] mt-1" x-text="'Professeur : ' + profName"></p>
        </div>
        <button @click="showModal = false" class="text-[#2C221E] hover:text-[#C85A32] text-2xl font-bold leading-none cursor-pointer">&times;</button>
      </div>

      {{-- Loader --}}
      <div x-show="loading" class="py-8 text-center text-xs text-[#6B574F]">
        <svg class="animate-spin h-6 w-6 text-[#C85A32] mx-auto mb-2" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Chargement des disponibilités du professeur...
      </div>

      <div x-show="!loading">
        {{-- Section Disponibilités du professeur --}}
        <div class="mb-5 bg-[#F4EFE6] border border-[#D4A373]/30 p-3.5">
          <h4 class="text-[10px] font-bold uppercase tracking-widest text-[#2C221E] mb-2 flex items-center gap-1.5">
            <svg class="w-3.5 h-3.5 text-[#C85A32]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Disponibilités hebdomadaires du professeur :
          </h4>
          <template x-if="disponibilites.length === 0">
            <p class="text-xs text-[#8C766B] italic">Aucune disponibilité enregistrée pour le moment.</p>
          </template>
          <div class="flex flex-wrap gap-2 mt-1">
            <template x-for="slot in disponibilites" :key="slot.id">
              <span class="inline-flex items-center gap-1 bg-white border border-[#D4A373]/40 px-2.5 py-1 text-[11px] font-bold text-[#2C221E]">
                <span class="w-1.5 h-1.5 bg-[#5EF527] rounded-full inline-block"></span>
                <span x-text="slot.jour + ' : ' + slot.debut.substring(0,5) + ' - ' + slot.fin.substring(0,5)"></span>
              </span>
            </template>
          </div>
        </div>

        {{-- Formulaire de réservation --}}
        <form action="{{ route('reservations.store') }}" method="POST" @submit="validateForm($event)" class="space-y-4">
          @csrf
          <input type="hidden" name="cours_id" :value="coursId" />

          <div>
            <label class="block text-[10px] font-bold uppercase tracking-widest text-[#2C221E] mb-1">
              Date souhaitée <span class="text-[#C85A32]">*</span>
            </label>
            <input type="date" name="date_reservation" required min="{{ date('Y-m-d') }}"
                   x-model="dateReservation" @change="onDateChange($event)"
                   class="w-full px-3 py-2 bg-white border border-[#D4A373]/50 text-xs text-[#2C221E] focus:outline-none focus:border-[#C85A32]" />
          </div>

          <div class="grid grid-cols-2 gap-3">
            <div>
              <label class="block text-[10px] font-bold uppercase tracking-widest text-[#2C221E] mb-1">
                Heure de début <span class="text-[#C85A32]">*</span>
              </label>
              <input type="time" name="heure_debut" required x-model="heureDebut"
                     class="w-full px-3 py-2 bg-white border border-[#D4A373]/50 text-xs text-[#2C221E] focus:outline-none focus:border-[#C85A32]" />
            </div>
            <div>
              <label class="block text-[10px] font-bold uppercase tracking-widest text-[#2C221E] mb-1">
                Heure de fin <span class="text-[#C85A32]">*</span>
              </label>
              <input type="time" name="heure_fin" required x-model="heureFin"
                     class="w-full px-3 py-2 bg-white border border-[#D4A373]/50 text-xs text-[#2C221E] focus:outline-none focus:border-[#C85A32]" />
            </div>
          </div>

          <div x-show="errorMessage" class="p-3 bg-red-50 border border-red-200 text-red-700 text-xs font-semibold">
            <span x-text="errorMessage"></span>
          </div>

          <div class="flex justify-end gap-3 pt-3 border-t border-[#D4A373]/20">
            <button type="button" @click="showModal = false"
                    class="px-4 py-2 text-xs font-bold uppercase tracking-wider text-[#6B574F] hover:text-[#2C221E] cursor-pointer">
              Annuler
            </button>
            <button type="submit" :disabled="disponibilites.length === 0"
                    class="px-5 py-2.5 bg-[#C85A32] hover:bg-[#A84223] disabled:opacity-50 text-white font-bold text-xs uppercase tracking-widest transition shadow-md cursor-pointer">
              Confirmer la réservation
            </button>
          </div>
        </form>
      </div>

    </div>
  </div>

</section>
@endsection
