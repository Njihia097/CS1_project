<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            .active-link {
                color: #1d4ed8; /* Tailwind blue-600 */
                border-bottom-color: #1d4ed8; /* Tailwind blue-600 */
            }
        </style>
        <style>
            .gradient-text::first-letter {
                font-size: 1.2em; /* Adjust size as needed */
                background: -webkit-linear-gradient(45deg, #1e13be, #000000);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }

            .sticky{
                position: fixed;
                top: 0;
                width: 100%;
            }
        </style>


        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow" id="appHeader">
                    <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="pt-16">
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts
        <!-- <script src="{{ asset('js/inactivity.js')}}"></script> -->
         <script>
            window.onscroll = function() {
                fixedHeader();
            }
            var header =document.getElementById('appHeader');
            //get offset position of the navbar
            var sticky = header.offsetTop;
            //Add sticky class once header scoll position is reached
            function fixedHeader() {
                if (window.pageYOffset > sticky) {
                    header.classList.add("sticky");
                } else{
                    header.classList.remove("sticky");
                }
            }

         </script>
    </body>
</html>
