<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réunion en ligne | AssoCulture</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-slate-100">
  <!-- Header de la réunion -->
  <div class="bg-white border-b border-slate-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
      <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
          <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center">
            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
            </svg>
          </div>
          <div>
            <h1 class="text-lg font-bold text-slate-900">{{ $reservation->course->titre }}</h1>
            <p class="text-xs text-slate-500">
              {{ \Carbon\Carbon::parse($reservation->date_reservation)->format('d/m/Y') }}
              de {{ $reservation->heure_debut }} à {{ $reservation->heure_fin }}
            </p>
          </div>
        </div>
        <div class="flex items-center gap-3">
          @if($isModerator)
            <span class="px-2 py-1 bg-amber-100 text-amber-700 text-xs font-bold uppercase tracking-wider rounded-full">
              Modérateur
            </span>
          @else
            <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs font-bold uppercase tracking-wider rounded-full">
              Participant
            </span>
          @endif
          <button onclick="closeMeeting()" class="text-slate-400 hover:text-slate-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Iframe Jitsi plein écran -->
  <div class="relative" style="height: calc(100vh - 60px);">
    <iframe
      src="{{ $meetingUrl }}"
      allow="camera; microphone; fullscreen; display-capture; autoplay"
      style="width: 100%; height: 100%; border: none;"
      id="jitsiFrame"
      class="bg-slate-900"
      sandbox="allow-same-origin allow-scripts allow-forms allow-popups allow-presentation">
    </iframe>

    <!-- Overlay de chargement -->
    <div id="loadingOverlay" class="absolute inset-0 bg-slate-900 flex items-center justify-center z-10">
      <div class="text-center">
        <div class="w-16 h-16 border-4 border-emerald-500 border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
        <p class="text-white text-sm" id="loadingText">Chargement de la réunion...</p>
        <p class="text-slate-400 text-xs mt-2" id="loadingHint">Si cela prend trop de temps, cliquez sur "Rafraîchir"</p>
      </div>
    </div>

    <!-- Overlay d'erreur -->
    <div id="errorOverlay" class="hidden absolute inset-0 bg-slate-900 flex items-center justify-center z-20">
      <div class="text-center max-w-md p-6">
        <div class="w-16 h-16 bg-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
          </svg>
        </div>
        <h3 class="text-white text-lg font-bold mb-2">Erreur de chargement</h3>
        <p class="text-slate-300 text-sm mb-4" id="errorMessage">La réunion n'a pas pu être chargée. Vérifiez votre connexion internet ou réessayez.</p>
        <div class="space-y-2">
          <button onclick="refreshMeeting()" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-2 px-4 rounded-lg text-sm font-medium">
            Rafraîchir
          </button>
          <button onclick="openInNewTab()" class="w-full bg-slate-700 hover:bg-slate-600 text-white py-2 px-4 rounded-lg text-sm font-medium">
            Ouvrir dans un nouvel onglet
          </button>
        </div>
      </div>
    </div>

    <!-- Menu flottant -->
    <div class="absolute bottom-4 right-4 z-20">
      <button onclick="toggleMenu()" class="bg-slate-800 hover:bg-slate-700 text-white p-3 rounded-full shadow-lg">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
        </svg>
      </button>

      <!-- Menu déroulant -->
      <div id="dropdownMenu" class="hidden absolute bottom-14 right-0 bg-white rounded-lg shadow-xl border border-slate-200 p-2 w-64">
        <div class="mb-3 pb-3 border-b border-slate-100">
          <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Informations</p>
          <p class="text-sm text-slate-700">{{ $reservation->course->professeur ? $reservation->course->professeur->name : 'Non spécifié' }}</p>
          <p class="text-xs text-slate-500">{{ $reservation->heure_debut }} - {{ $reservation->heure_fin }}</p>
        </div>

        <div class="space-y-2">
          <button onclick="copyMeetingLink()" class="w-full flex items-center gap-2 px-3 py-2 text-sm text-slate-700 hover:bg-slate-100 rounded-lg">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
            </svg>
            Copier le lien
          </button>

          @if($isModerator)
          <button onclick="regenerateToken()" class="w-full flex items-center gap-2 px-3 py-2 text-sm text-slate-700 hover:bg-slate-100 rounded-lg">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a4 4 0 11-8 0 4 4 0 018 0zm0 0v5m0 5h6m-6-6h6"/>
            </svg>
            Régénérer le token
          </button>
          @endif

          <button onclick="refreshMeeting()" class="w-full flex items-center gap-2 px-3 py-2 text-sm text-slate-700 hover:bg-slate-100 rounded-lg">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
            Rafraîchir
          </button>

          <button onclick="closeMeeting()" class="w-full flex items-center gap-2 px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
            Quitter la réunion
          </button>
        </div>
      </div>
    </div>
  </div>

<script>
// Variables pour le timeout
let loadingTimeout;
let iframeLoadTimeout;
const MAX_LOADING_TIME = 30000; // 30 secondes max pour le chargement

// Masquer l'overlay de chargement quand l'iframe est chargée
const jitsiFrame = document.getElementById('jitsiFrame');
const loadingOverlay = document.getElementById('loadingOverlay');
const errorOverlay = document.getElementById('errorOverlay');
const loadingText = document.getElementById('loadingText');

// Timeout pour détecter un chargement trop long
loadingTimeout = setTimeout(function() {
  if (loadingOverlay.style.display !== 'none') {
    loadingText.textContent = 'Chargement en cours... Cela prend plus de temps que prévu.';
    document.getElementById('loadingHint').textContent = 'Cliquez sur "Rafraîchir" ou "Ouvrir dans un nouvel onglet" si le problème persiste.';
  }
}, 15000); // 15 secondes

// Timeout pour détecter une erreur de chargement
iframeLoadTimeout = setTimeout(function() {
  if (loadingOverlay.style.display !== 'none') {
    loadingOverlay.style.display = 'none';
    errorOverlay.classList.remove('hidden');
    document.getElementById('errorMessage').textContent =
      'La réunion n\'a pas pu être chargée dans le délai imparti. ' +
      'Cela peut être dû à une connexion internet instable ou à un problème avec le serveur Jitsi.';
  }
}, MAX_LOADING_TIME);

jitsiFrame.onload = function() {
  clearTimeout(loadingTimeout);
  clearTimeout(iframeLoadTimeout);

  setTimeout(function() {
    loadingOverlay.style.display = 'none';
  }, 2000);
};

jitsiFrame.onerror = function() {
  clearTimeout(loadingTimeout);
  clearTimeout(iframeLoadTimeout);
  loadingOverlay.style.display = 'none';
  errorOverlay.classList.remove('hidden');
  document.getElementById('errorMessage').textContent =
    'Une erreur est survenue lors du chargement de la réunion.';
};

// Toggle menu
function toggleMenu() {
  const menu = document.getElementById('dropdownMenu');
  menu.classList.toggle('hidden');
}

// Fermer le menu si on clique ailleurs
document.addEventListener('click', function(event) {
  const menu = document.getElementById('dropdownMenu');
  const button = event.target.closest('button');
  if (!menu.contains(event.target) && !button?.onclick?.toString().includes('toggleMenu')) {
    menu.classList.add('hidden');
  }
});

// Copier le lien de la réunion
function copyMeetingLink() {
  const meetingUrl = '{{ $meetingUrl }}';
  navigator.clipboard.writeText(meetingUrl).then(function() {
    alert('Lien de la réunion copié !');
  }).catch(function(err) {
    console.error('Erreur lors de la copie :', err);
  });
}

// Rafraîchir la réunion
function refreshMeeting() {
  clearTimeout(loadingTimeout);
  clearTimeout(iframeLoadTimeout);

  const iframe = document.getElementById('jitsiFrame');
  iframe.src = iframe.src;
  loadingOverlay.style.display = 'flex';
  errorOverlay.classList.add('hidden');
  document.getElementById('dropdownMenu').classList.add('hidden');

  // Relancer les timeouts
  loadingTimeout = setTimeout(function() {
    if (loadingOverlay.style.display !== 'none') {
      loadingText.textContent = 'Chargement en cours... Cela prend plus de temps que prévu.';
      document.getElementById('loadingHint').textContent = 'Cliquez sur "Rafraîchir" ou "Ouvrir dans un nouvel onglet" si le problème persiste.';
    }
  }, 15000);

  iframeLoadTimeout = setTimeout(function() {
    if (loadingOverlay.style.display !== 'none') {
      loadingOverlay.style.display = 'none';
      errorOverlay.classList.remove('hidden');
    }
  }, MAX_LOADING_TIME);
}

// Ouvrir dans un nouvel onglet
function openInNewTab() {
  const meetingUrl = '{{ $meetingUrl }}';
  window.open(meetingUrl, '_blank');
}

// Régénérer le token JWT (pour le modérateur)
function regenerateToken() {
  if (confirm('Voulez-vous vraiment régénérer le token d\'accès ? Le lien actuel ne fonctionnera plus.')) {
    fetch('{{ route('meeting.regenerate-token', $reservation->id) }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}'
      },
      body: JSON.stringify({})
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert('Nouveau token généré avec succès !');
        window.location.href = data.meetingUrl;
      } else {
        alert('Erreur lors de la régénération du token.');
      }
    })
    .catch(error => {
      console.error('Erreur :', error);
      alert('Erreur lors de la régénération du token.');
    });
  }
  document.getElementById('dropdownMenu').classList.add('hidden');
}

// Quitter la réunion
function closeMeeting() {
  if (confirm('Voulez-vous vraiment quitter la réunion ?')) {
    window.location.href = '{{ Auth::user()->profil_id == 2 ? route('dashboard.professeur.reservations') : route('dashboard.apprenant') }}';
  }
}
</script>
</body>
</html>
