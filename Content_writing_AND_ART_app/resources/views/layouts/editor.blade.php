<!DOCTYPE html>
<html lang="en">

<head>
  @include('editor/Partials.css')
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <style>
        /* Add your custom styles here */

    </style>
    

  @livewireStyles
</head>

<body>
  

  <div class="container-scroller">
    <!-- partial:partials/_sidebar.html -->

    @include('editor/Partials.sidebar')
    
    <!-- partial -->
    
    @include('editor/Partials.header')

      <!-- partial -->
    <div class="main-panel">

      <div class="content-wrapper">

        @yield('content')

      </div>

    </div>

    
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  @stack('modals')

@livewireScripts

  @include('editor/Partials.script')
  <script src="{{ mix('js/app.js') }}" defer></script>

  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/2.8.2/alpine.js" integrity="sha512-CJqnUsEMUTIbFuxtSCyjjC3ZQ1Y1Oo+/lh4Dw/D5RBvDZVtx6+O37NcRaEkXfDXI2O0GRNEfivHQ/l+G6m2Q1g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
    document.addEventListener('alpine:init', () => {
      Alpine.data('dropdown', () => ({
        open: false,
        toggle() {
          this.open = !this.open
        }
      }))
    })
  </script> -->

  <!-- <script src="{{ asset('js/inactivity.js')}}"></script> -->

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const toggleButton = document.querySelector('[data-toggle="collapsed"]');
      const collapseElement = document.querySelector(toggleButton.getAttribute('href'));

      toggleButton.addEventListener('click', function(event) {
        event.preventDefault();
        collapseElement.classList.toggle('hidden');
        toggleButton.setAttribute('aria-expanded', collapseElement.classList.contains('hidden') ? 'false' : 'true');
      });
    });
  </script>

  <!-- End custom js for this page -->
</body>

</html>