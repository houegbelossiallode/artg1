<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Espace Privé | AssoCulture')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    
    <!-- Icons (FontAwesome) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <style>
      body { font-family: 'Outfit', sans-serif; }
      [x-cloak] { display: none !important; }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  </head>
  <body class="bg-[#F4F6FA] min-h-screen text-slate-900 overflow-x-hidden font-sans">
    
    <!-- Sidebar -->
    @include('components.dashboard.sidebar')

    <!-- Main Content Wrapper -->
    <div class="md:ml-64 flex flex-col min-h-screen relative">
      
      <!-- Header -->
      @include('components.dashboard.header')

      <!-- Page Content -->
      <main class="flex-1 p-4 md:p-8 bg-[#F4F6FA]">
        @yield('content')
      </main>
      
      <!-- Footer Simple pour Dashboard -->
      <footer class="p-6 text-center text-[10px] text-slate-400 font-bold uppercase tracking-widest border-t border-slate-200 bg-[#F4F6FA]">
        &copy; 2026 AssoCulture. Espace Privé.
      </footer>
    </div>
    
    <!-- SweetAlert2 Toast Notifications (Top-Left) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 4000,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
          }
        });

        @if(session('success'))
          Toast.fire({
            icon: 'success',
            title: "{{ session('success') }}"
          });
        @endif

        @if(session('error'))
          Toast.fire({
            icon: 'error',
            title: "{{ session('error') }}"
          });
        @endif

        @if(session('warning'))
          Toast.fire({
            icon: 'warning',
            title: "{{ session('warning') }}"
          });
        @endif

        @if(session('info'))
          Toast.fire({
            icon: 'info',
            title: "{{ session('info') }}"
          });
        @endif
      });
    </script>
  </body>
</html>
