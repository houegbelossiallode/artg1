@extends('layouts.dashboard')

@section('title', 'Modifier l\'Événement | AssoCulture')

@section('content')
<div class="space-y-6">
  <!-- En-tête de la page -->
  <div class="bg-white border border-slate-200 shadow-sm px-6 py-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <h1 class="admin-title">Modifier l'Événement</h1>
      <p class="admin-subtitle">Mettez à jour les détails de cet événement.</p>
    </div>
    <div class="flex flex-wrap items-center gap-2">
      <a href="{{ route('dashboard.admin.evenements.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-100 text-slate-600 font-bold text-[10px] uppercase tracking-widest hover:bg-slate-200 transition shadow-sm cursor-pointer">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        RETOUR
      </a>
    </div>
  </div>

  <form action="{{ route('dashboard.admin.evenements.update', $evenement->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6" x-data="editForm()">
    @csrf
    @method('PUT')
    
    <input type="hidden" name="deleted_images" x-model="deletedImages.join(',')">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      
      <!-- Colonne Principale : Informations -->
      <div class="lg:col-span-2 space-y-6">
        
        <!-- Bloc : Informations de l'événement -->
        <div class="bg-white border border-slate-200 shadow-sm p-6 relative overflow-hidden">
          <h2 class="text-xs font-bold text-slate-900 uppercase tracking-widest mb-5 flex items-center gap-2 font-sans">
            <svg class="w-4 h-4 text-[#0BA20B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Informations & Dates
          </h2>

          <div class="space-y-5">
            <div>
              <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Titre de l'événement <span class="text-red-500">*</span></label>
              <input type="text" name="titre" required class="w-full px-4 py-2.5 text-sm border border-slate-300 focus:border-[#0BA20B] focus:ring-1 focus:ring-[#0BA20B] focus:outline-none rounded-none bg-slate-50 transition-colors" placeholder="Ex: Festival des Arts Vivants" value="{{ old('titre', $evenement->titre) }}">
              @error('titre') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                  <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Catégorie <span class="text-red-500">*</span></label>
                  <select name="categorie_evenement_id" required class="w-full px-4 py-2.5 text-sm border border-slate-300 focus:border-[#0BA20B] focus:ring-1 focus:ring-[#0BA20B] focus:outline-none rounded-none bg-slate-50 transition-colors cursor-pointer appearance-none">
                      <option value="">Sélectionnez une catégorie</option>
                      @foreach($categories as $cat)
                          <option value="{{ $cat->id }}" {{ old('categorie_evenement_id', $evenement->categorie_evenement_id) == $cat->id ? 'selected' : '' }}>{{ $cat->libelle }}</option>
                      @endforeach
                  </select>
                  @error('categorie_evenement_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                  <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Lieu <span class="text-red-500">*</span></label>
                  <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <input type="text" name="lieu" required class="w-full pl-9 pr-4 py-2.5 text-sm border border-slate-300 focus:border-[#0BA20B] focus:ring-1 focus:ring-[#0BA20B] focus:outline-none rounded-none bg-slate-50 transition-colors" placeholder="Adresse ou lieu exact" value="{{ old('lieu', $evenement->lieu) }}">
                  </div>
                  @error('lieu') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
              <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Date de début <span class="text-red-500">*</span></label>
                <input type="date" name="date_debut" required class="w-full px-4 py-2.5 text-sm border border-slate-300 focus:border-[#0BA20B] focus:ring-1 focus:ring-[#0BA20B] focus:outline-none rounded-none bg-slate-50 transition-colors" value="{{ old('date_debut', \Carbon\Carbon::parse($evenement->date_debut)->format('Y-m-d')) }}">
                @error('date_debut') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
              </div>
              <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Date de fin <span class="text-red-500">*</span></label>
                <input type="date" name="date_fin" required class="w-full px-4 py-2.5 text-sm border border-slate-300 focus:border-[#0BA20B] focus:ring-1 focus:ring-[#0BA20B] focus:outline-none rounded-none bg-slate-50 transition-colors" value="{{ old('date_fin', \Carbon\Carbon::parse($evenement->date_fin)->format('Y-m-d')) }}">
                @error('date_fin') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
              </div>
              <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Heure <span class="text-red-500">*</span></label>
                <input type="time" name="heure" required class="w-full px-4 py-2.5 text-sm border border-slate-300 focus:border-[#0BA20B] focus:ring-1 focus:ring-[#0BA20B] focus:outline-none rounded-none bg-slate-50 transition-colors" value="{{ old('heure', \Carbon\Carbon::parse($evenement->heure)->format('H:i')) }}">
                @error('heure') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
              </div>
            </div>

          </div>
        </div>

      </div>

      <!-- Colonne Secondaire : Médias -->
      <div class="space-y-6">
        
        <!-- Bloc : Image Principale -->
        <div class="bg-white border border-slate-200 shadow-sm p-6 relative overflow-hidden h-full" x-data="singleImageUploader('{{ $evenement->images->where('is_principal', true)->first() ? asset('storage/' . $evenement->images->where('is_principal', true)->first()->image_path) : '' }}')">
          <h2 class="text-xs font-bold text-slate-900 uppercase tracking-widest mb-5 flex items-center gap-2 font-sans">
            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Affiche Principale
          </h2>

          <div 
            class="border-2 border-dashed border-slate-300 bg-slate-50 hover:bg-slate-100 hover:border-[#0BA20B] transition-colors p-6 flex flex-col items-center justify-center text-center cursor-pointer min-h-[175px] h-[calc(100%-40px)] relative overflow-hidden"
            @dragover.prevent="dragover = true"
            @dragleave.prevent="dragover = false"
            @drop.prevent="drop($event)"
            :class="{ 'border-[#0BA20B] bg-[#0BA20B]/5': dragover }"
            @click="$refs.fileInput.click()"
          >
            <input type="file" name="photo_principale" x-ref="fileInput" class="hidden" accept="image/*" @change="handleFileChange">
            
            <template x-if="!previewUrl">
              <div class="pointer-events-none flex flex-col items-center">
                <div class="w-12 h-12 bg-white shadow-sm border border-slate-200 rounded-none flex items-center justify-center mb-3">
                  <svg class="w-5 h-5 text-[#0BA20B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                </div>
                <p class="text-xs text-slate-600 font-bold uppercase tracking-wider mb-1">Modifier l'affiche</p>
                <p class="text-[10px] text-slate-400">Glissez-déposez ou cliquez</p>
                <p class="text-[9px] text-slate-400 uppercase tracking-widest mt-2 border-t border-slate-200 pt-2">Max: 4MB (JPG, WEBP, PNG)</p>
              </div>
            </template>

            <template x-if="previewUrl">
              <div class="absolute inset-0 w-full h-full group">
                <img :src="previewUrl" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300">
                  <button type="button" @click.stop="removeImage" class="bg-red-500 text-white font-bold text-[10px] uppercase tracking-widest px-4 py-2 hover:bg-red-600 transition-colors shadow-lg flex items-center gap-2">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Changer
                  </button>
                </div>
              </div>
            </template>
          </div>
          @error('photo_principale') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
        </div>
      </div>
    </div>

    <!-- Bloc : Description (Pleine Largeur) -->
    <div class="bg-white border border-slate-200 shadow-sm p-6 relative overflow-hidden mt-6">
      <h2 class="text-xs font-bold text-slate-900 uppercase tracking-widest mb-5 flex items-center gap-2 font-sans">
        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
        Description complète
      </h2>
      <textarea name="description" rows="6" class="w-full px-4 py-3 text-sm border border-slate-300 focus:border-[#0BA20B] focus:ring-1 focus:ring-[#0BA20B] focus:outline-none rounded-none bg-slate-50 transition-colors" placeholder="Détaillez le programme, les intervenants, etc...">{{ old('description', $evenement->description) }}</textarea>
      @error('description') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
    </div>

    <!-- Bloc : Galerie d'images secondaires -->
    <div class="bg-white border border-slate-200 shadow-sm p-6 relative overflow-hidden mt-6" x-data="multipleImageUploader()">
      <h2 class="text-xs font-bold text-slate-900 uppercase tracking-widest mb-5 flex items-center gap-2 font-sans">
        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
        Galerie d'Images (Optionnel)
      </h2>
      
      <div 
        class="border-2 border-dashed border-slate-300 bg-slate-50 hover:bg-slate-100 hover:border-[#0BA20B] transition-colors p-8 flex flex-col items-center justify-center text-center cursor-pointer min-h-[160px]"
        @dragover.prevent="dragover = true"
        @dragleave.prevent="dragover = false"
        @drop.prevent="drop($event)"
        :class="{ 'border-[#0BA20B] bg-[#0BA20B]/5': dragover }"
        @click="$refs.fileInput.click()"
      >
        <input type="file" name="images_secondaires[]" x-ref="fileInput" class="hidden" accept="image/*" multiple @change="handleFileChange">
        
        <div class="pointer-events-none flex flex-col items-center">
          <div class="w-12 h-12 bg-white shadow-sm border border-slate-200 rounded-none flex items-center justify-center mb-3">
            <svg class="w-5 h-5 text-[#0BA20B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
          </div>
          <p class="text-xs text-slate-600 font-bold uppercase tracking-wider mb-1">Ajouter des photos</p>
          <p class="text-[10px] text-slate-400">Sélectionnez ou glissez-déposez des fichiers ici</p>
        </div>
      </div>

      <!-- Prévisualisation des images existantes -->
      @php
          $secondaryImages = $evenement->images->where('is_principal', false);
      @endphp
      
      <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-4 mt-6" x-show="existingImages.length > 0 || files.length > 0" x-cloak>
        
        <!-- Images existantes -->
        <template x-for="(img, index) in existingImages" :key="'existing-'+index">
          <div class="relative group aspect-square border border-slate-200 bg-slate-100 shadow-sm overflow-hidden" x-show="!img.deleted">
            <img :src="img.url" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300">
              <button type="button" @click.stop="markAsDeleted(index)" class="bg-red-500 text-white p-2 hover:bg-red-600 transition-colors shadow-md rounded-none" title="Supprimer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
              </button>
            </div>
            <div class="absolute top-1 left-1 bg-slate-800 text-white text-[9px] px-1.5 py-0.5 uppercase tracking-wider">Actuelle</div>
          </div>
        </template>

        <!-- Nouvelles images -->
        <template x-for="(file, index) in files" :key="'new-'+index">
          <div class="relative group aspect-square border border-[#0BA20B] bg-slate-100 shadow-sm overflow-hidden">
            <img :src="file.preview" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300">
              <button type="button" @click.stop="removeFile(index)" class="bg-red-500 text-white p-2 hover:bg-red-600 transition-colors shadow-md rounded-none">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
              </button>
            </div>
            <div class="absolute top-1 left-1 bg-[#0BA20B] text-white text-[9px] font-bold px-1.5 py-0.5 uppercase tracking-wider">Nouvelle</div>
          </div>
        </template>
      </div>
    </div>

    <!-- Actions de formulaire -->
    <div class="bg-white border border-slate-200 shadow-sm px-6 py-4 flex flex-col sm:flex-row items-center justify-between gap-4">
      <p class="text-[10px] text-slate-400 uppercase tracking-widest font-bold">Sauvegardez vos modifications</p>
      <div class="flex gap-3 w-full sm:w-auto">
        <a href="{{ route('dashboard.admin.evenements.index') }}" class="flex-1 sm:flex-none px-6 py-3 text-xs uppercase font-bold tracking-widest text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors text-center">Annuler</a>
        <button type="submit" class="flex-1 sm:flex-none px-8 py-3 text-xs uppercase font-bold tracking-widest bg-[#0BA20B] text-white hover:brightness-105 transition-all shadow-md border border-[#0BA20B] text-center flex items-center justify-center gap-2">
          Mettre à jour
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
        </button>
      </div>
    </div>
  </form>
</div>

<script>
  function editForm() {
    return {
      deletedImages: []
    }
  }

  function singleImageUploader(existingUrl = null) {
    return {
      dragover: false,
      previewUrl: existingUrl,
      file: null,
      handleFileChange(e) {
        if (e.target.files.length > 0) {
          this.file = e.target.files[0];
          this.previewUrl = URL.createObjectURL(this.file);
        }
      },
      drop(e) {
        this.dragover = false;
        if (e.dataTransfer.files.length > 0) {
          this.file = e.dataTransfer.files[0];
          this.previewUrl = URL.createObjectURL(this.file);
          
          const dataTransfer = new DataTransfer();
          dataTransfer.items.add(this.file);
          this.$refs.fileInput.files = dataTransfer.files;
        }
      },
      removeImage() {
        this.previewUrl = null;
        this.file = null;
        this.$refs.fileInput.value = '';
      }
    }
  }

  function multipleImageUploader() {
    const existing = [
      @foreach($secondaryImages as $img)
        { id: {{ $img->id }}, url: '{{ asset("storage/" . $img->image_path) }}', deleted: false },
      @endforeach
    ];

    return {
      dragover: false,
      files: [],
      existingImages: existing,
      
      handleFileChange(e) {
        this.addFiles(e.target.files);
      },
      drop(e) {
        this.dragover = false;
        this.addFiles(e.dataTransfer.files);
      },
      addFiles(newFiles) {
        const dt = new DataTransfer();
        for(let i = 0; i < this.files.length; i++) {
            dt.items.add(this.files[i].file);
        }
        
        for (let i = 0; i < newFiles.length; i++) {
          let file = newFiles[i];
          if (!file.type.match('image.*')) continue;
          
          this.files.push({
            file: file,
            preview: URL.createObjectURL(file)
          });
          dt.items.add(file);
        }
        this.$refs.fileInput.files = dt.files;
      },
      removeFile(index) {
        this.files.splice(index, 1);
        const dt = new DataTransfer();
        for (let i = 0; i < this.files.length; i++) {
          dt.items.add(this.files[i].file);
        }
        this.$refs.fileInput.files = dt.files;
      },
      markAsDeleted(index) {
        this.existingImages[index].deleted = true;
        // The parent x-data editForm() has deletedImages array
        // We push the ID to it so the server knows what to delete
        this.$parent.deletedImages.push(this.existingImages[index].id);
      }
    }
  }
</script>
@endsection
