@extends('layouts.dashboard')

@section('title', 'Ajouter une Œuvre | AssoCulture')

@section('content')
<div class="space-y-6">

  <!-- En-tête -->
  <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 pb-4 border-b border-slate-200">
    <div>
      <h1 class="admin-title">Nouvelle Œuvre</h1>
      <p class="admin-subtitle">Ajouter une œuvre (vidéo, audio, image) pour {{ $talent->prenom }} {{ $talent->nom }}</p>
    </div>
    
  </div>

  

  <!-- Formulaire -->
  <form action="{{ route('dashboard.admin.talents.oeuvres.store') }}" method="POST" enctype="multipart/form-data" class="bg-white border border-slate-200 shadow-sm p-6 space-y-6" x-data="oeuvreForm()">
    @csrf
    <input type="hidden" name="talent_id" value="{{ $talent->id }}">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      
      <!-- Colonne Principale -->
      <div class="lg:col-span-2 space-y-4">
        
        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Type d'œuvre *</label>
          <select name="type" required class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none bg-slate-50" x-model="type">
            <option value="">Sélectionnez le type...</option>
            <option value="video">Vidéo (YouTube/Vimeo)</option>
            <option value="audio">Piste Audio (Fichier local)</option>
            <option value="image">Image / Peinture (Fichier local)</option>
            <option value="lien">Lien Externe</option>
          </select>
          @error('type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Nom / Titre *</label>
          <input type="text" name="nom" required class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none bg-slate-50" placeholder="Ex: Echo du fleuve" value="{{ old('nom') }}">
          @error('nom') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Description</label>
          <textarea name="description" rows="5" class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none bg-slate-50" placeholder="Quelques mots sur l'œuvre...">{{ old('description') }}</textarea>
          @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <!-- Fichier ou Lien -->
        <div class="mt-6 pt-6 border-t border-slate-200">
          
          <div x-show="['video', 'lien'].includes(type)" x-cloak>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Lien (URL) *</label>
            <input type="text" name="fichier_text" :required="['video', 'lien'].includes(type)" :disabled="!['video', 'lien'].includes(type)" class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none bg-slate-50" placeholder="Ex: https://youtube.com/watch?v=..." value="{{ old('fichier_text') }}">
            <p class="text-[10px] text-slate-400 mt-1 uppercase tracking-wider">Entrez l'URL de la vidéo ou du lien.</p>
            @error('fichier_text') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
          </div>

          <div x-show="['audio', 'image'].includes(type)" x-cloak>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Fichier (Upload) *</label>
            <input type="file" name="fichier_file" :required="['audio', 'image'].includes(type)" :disabled="!['audio', 'image'].includes(type)" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-none file:border-0 file:text-xs file:font-bold file:bg-slate-900 file:text-white hover:file:bg-slate-700 cursor-pointer">
            <p class="text-[10px] text-slate-400 mt-1 uppercase tracking-wider" x-text="type === 'audio' ? 'Fichiers acceptés: .mp3, .wav' : 'Fichiers acceptés: .jpg, .png, .webp'"></p>
            @error('fichier_file') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
          </div>
          
        </div>

      </div>

      <!-- Colonne Secondaire -->
      <div class="space-y-4">
        
        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Date de réalisation *</label>
          <input type="date" name="date_publication" required class="w-full px-3 py-2 text-sm border border-slate-300 focus:border-slate-900 focus:outline-none rounded-none bg-slate-50" value="{{ old('date_publication', date('Y-m-d')) }}">
          @error('date_publication') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <!-- DROPZONE AlpineJS for Thumbnail -->
        <div x-data="singleImageUploader()" class="pt-4">
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Miniature / Couverture</label>
          <p class="text-[10px] text-slate-500 mb-2 leading-tight">Optionnel pour les vidéos, recommandé pour l'audio.</p>
          
          <div 
            class="border-2 border-dashed border-slate-300 bg-slate-50 hover:bg-slate-100 transition-colors p-4 flex flex-col items-center justify-center text-center cursor-pointer min-h-[150px] relative overflow-hidden"
            @dragover.prevent="dragover = true"
            @dragleave.prevent="dragover = false"
            @drop.prevent="drop($event)"
            :class="{ 'border-slate-900 bg-slate-100': dragover }"
            @click="$refs.fileInput.click()"
          >
            <input type="file" name="image" x-ref="fileInput" class="hidden" accept="image/*" @change="handleFileChange">
            
            <template x-if="!previewUrl">
              <div class="pointer-events-none">
                <svg class="w-8 h-8 text-slate-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <p class="text-xs text-slate-500 font-medium">Glissez une image ici ou <span class="text-slate-900 underline">cliquez</span></p>
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
          @error('image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

      </div>
    </div>

    <div class="flex justify-end gap-3 pt-6 border-t border-slate-200">
      <a href="{{ route('dashboard.admin.talents.oeuvres.index', ['talent_id' => $talent->id]) }}" class="px-6 py-2.5 text-xs uppercase font-bold tracking-wider text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors rounded-none">Annuler</a>
      <button type="submit" class="btn-primary">Enregistrer l'Œuvre</button>
    </div>

  </form>
</div>

<script>
  function oeuvreForm() {
    return {
      type: '{{ old("type", "") }}',
    }
  }

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
</script>
@endsection
