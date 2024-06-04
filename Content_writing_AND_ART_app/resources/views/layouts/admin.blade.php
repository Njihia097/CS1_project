<!DOCTYPE html>
<html lang="en">

<head>
  @include('admin/partials.css')
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
  
  @vite(['resources/css/app.css', 'resources/js/app.js'])

    

  @livewireStyles
</head>

<body>
  

  <div class="container-scroller">
    <!-- partial:partials/_sidebar.html -->

    @include('admin/partials.sidebar')
    
    <!-- partial -->
    
    @include('admin/partials.header')

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

  @include('admin/partials.script')
  <script src="{{ mix('js/app.js') }}" defer></script>

  <!-- End custom js for this page -->
</body>

</html>