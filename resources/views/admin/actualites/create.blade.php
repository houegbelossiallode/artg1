@extends('layouts.dashboard')

@section('title', 'Créer une Actualité | AssoCulture')

@section('content')
<div class="space-y-6">
  <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 pb-4 border-b border-slate-200">
    <div>
      <h1 class="admin-title">Nouvelle Actualité</h1>
      <p class="admin-subtitle">Remplissez les informations ci-dessous pour publier une nouvelle actualité.</p>
    </div>
    <div class="flex flex-wrap items-center gap-2">
      <a href="{{ route('dashboard.admin.actualites.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-100 text-slate-600 font-bold text-[10px] uppercase tracking-widest hover:bg-slate-200 transition shadow-sm cursor-pointer">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        RETOUR
      </a>
    </div>
  </div>

  <form action="{{ route('dashboard.admin.actualites.store') }}" method="POST" enctype="multipart/form-data" class="bg-white border border-slate-200 shadow-sm p-6 space-y-6">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <div class="lg:col-span-2 space-y-4">
        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Titre de l'Actualité *</label>
          <input type="text" name="titre" required class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none bg-slate-50" placeholder="Titre de l'article" value="{{ old('titre') }}">
          @error('titre') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Contenu de l'Article *</label>
          <textarea name="contenu" rows="8" required class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none bg-slate-50" placeholder="Texte complet de l'article...">{{ old('contenu') }}</textarea>
          @error('contenu') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
      </div>

      <div class="space-y-4">
        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Date de Publication *</label>
          <input type="date" name="date_publication" required class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none bg-slate-50" value="{{ old('date_publication', date('Y-m-d')) }}">
          @error('date_publication') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <!-- DROPZONE AlpineJS for Main Image -->
        <div x-data="singleImageUploader()">
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Image Principale (A la une)</label>
          <div 
            class="border-2 border-dashed border-slate-300 bg-slate-50 hover:bg-slate-100 transition-colors p-4 flex flex-col items-center justify-center text-center cursor-pointer min-h-[150px] relative overflow-hidden"
            @dragover.prevent="dragover = true"
            @dragleave.prevent="dragover = false"
            @drop.prevent="drop($event)"
            :class="{ 'border-slate-900 bg-slate-100': dragover }"
            @click="$refs.fileInput.click()"
          >
            <input type="file" name="photo_principale" x-ref="fileInput" class="hidden" accept="image/*" @change="handleFileChange">
            
            <template x-if="!previewUrl">
              <div class="pointer-events-none">
                <svg class="w-8 h-8 text-slate-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <p class="text-xs text-slate-500 font-medium">Glissez une image ici ou <span class="text-slate-900 underline">cliquez</span></p>
                <p class="text-[10px] text-slate-400 mt-1">PNG, JPG, WEBP jusqu'à 4MB</p>
              </div>
            </template>

            <template x-if="previewUrl">
              <div class="absolute inset-0 w-full h-full group">
                <img :src="previewUrl" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-slate-900/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                  <button type="button" @click.stop="removeImage" class="bg-red-500 text-white p-2 rounded-none hover:bg-red-600 transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                  </button>
                </div>
              </div>
            </template>
          </div>
          @error('photo_principale') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

      </div>
    </div>

    <div class="border-t border-slate-200 pt-6">
      <!-- DROPZONE AlpineJS for Multiple Images -->
      <div x-data="multipleImageUploader()">
        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Images Secondaires (Galerie)</label>
        
        <div 
          class="border-2 border-dashed border-slate-300 bg-slate-50 hover:bg-slate-100 transition-colors p-8 flex flex-col items-center justify-center text-center cursor-pointer min-h-[150px]"
          @dragover.prevent="dragover = true"
          @dragleave.prevent="dragover = false"
          @drop.prevent="drop($event)"
          :class="{ 'border-slate-900 bg-slate-100': dragover }"
          @click="$refs.fileInput.click()"
        >
          <input type="file" name="images_secondaires[]" x-ref="fileInput" class="hidden" accept="image/*" multiple @change="handleFileChange">
          
          <div class="pointer-events-none">
            <svg class="w-8 h-8 text-slate-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
            <p class="text-xs text-slate-500 font-medium">Glissez plusieurs images ici ou <span class="text-slate-900 underline">cliquez</span> pour parcourir</p>
          </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-4 mt-4" x-show="files.length > 0" x-cloak>
          <template x-for="(file, index) in files" :key="index">
            <div class="relative group aspect-square border border-slate-200 bg-slate-100 shadow-sm">
              <img :src="file.preview" class="w-full h-full object-cover">
              <div class="absolute inset-0 bg-slate-900/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                <button type="button" @click="removeFile(index)" class="bg-red-500 text-white p-1.5 rounded-none hover:bg-red-600 transition-colors shadow-sm">
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
              </div>
            </div>
          </template>
        </div>
      </div>
    </div>

    <div class="flex justify-end gap-3 pt-6 border-t border-slate-200">
      <a href="{{ route('dashboard.admin.actualites.index') }}" class="px-6 py-2.5 text-xs uppercase font-bold tracking-wider text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors rounded-none">Annuler</a>
      <button type="submit" class="btn-primary">Publier l'Actualité</button>
    </div>
  </form>
</div>

<script>
  function singleImageUploader() {
    return {
      dragover: false,
      previewUrl: null,
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
    return {
      dragover: false,
      files: [],
      handleFileChange(e) {
        this.addFiles(e.target.files);
      },
      drop(e) {
        this.dragover = false;
        this.addFiles(e.dataTransfer.files);
      },
      addFiles(newFiles) {
        const dt = new DataTransfer();
        // Keep existing files
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
      }
    }
  }
</script>
@endsection
