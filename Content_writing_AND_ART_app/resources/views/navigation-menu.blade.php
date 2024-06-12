@php
    $dashboardRoute = '#';
    if (auth()->user()->hasRole('admin')) {
    $dashboardRoute = route('admin.adminHome');
    }
    elseif (auth()->user()->hasRole('editor')) {
    $dashboardRoute = route('editor.editorHome');
    } elseif (auth()->user()->hasRole('student')) {
    $dashboardRoute = route('student.studentHome');
    }
@endphp

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <a href="{{ route('welcome') }}" class="flex items-center">
                    <!-- SVG Logo with Application Name -->
                    <svg class="h-10 mr-2 sm:h-10 md:h-12 lg:h-12 xl:h-16" viewBox="0 0 512 512">
                        <!-- Background Rectangle -->
                        <rect width="512" height="512" x="0" y="0" rx="80" fill="url(#linearGradient-iconWithBackground)" stroke="#000000" stroke-width="0" stroke-opacity="100%" paint-order="stroke"/>

                        <!-- Gradient Definition -->
                        <defs>
                            <linearGradient id="linearGradient-iconWithBackground" gradientUnits="userSpaceOnUse" gradientTransform="rotate(0)" style="transform-origin:center center">
                                <stop stop-color="#1e13be"/>
                                <stop offset="1" stop-color="#000000"/>
                            </linearGradient>
                        </defs>

                        <!-- SVG Logo Content -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="340" height="340" viewBox="0 0 64 64" x="86" y="86">
                            <!-- Logo Path -->
                            <path fill="#ffffff" d="M55.339 30.79c-2.519-1.382-11.341-4.241-18.681-6.38l5.328-5.503l.578.599l1.273-1.314l-.578-.6l3.684-3.807l-.705-.73l3.684-3.805L46.778 6l-3.685 3.806l-.709-.73l-3.687 3.806l-1.38-1.424l-8.511 8.802l1.073 1.113l7.221-7.466l.316.3l-7.795 8.051c-7.035-3.226-9.701.335-13.346 5.255c-1.995 2.692-4.479 6.044-8.344 9.308c-1.264 1.065-2.559 2.899-2.4 4.853c.078.97.574 2.344 2.356 3.55l-3.794 7.037L2 54.427l1.036 1.071l2.103-2.171l4.873-2.797c.909 1.213 2.311 2.074 3.742 2.215c3.441.344 6.357 1.625 9.178 2.864C25.729 56.839 28.37 58 31.128 58c3.637 0 6.477-.493 9.482-1.016c3.901-.677 8.323-1.444 15.791-1.444c2.778 0 4.736-2.27 5.372-6.224c1.123-6.956-2.065-16.132-6.434-18.526M26.007 41.379c-.959-.442-1.871-.861-2.623-1.137c-.055-.02-.116-.037-.171-.057c.432-.677 1.31-1.824 3.042-3.444c-.131 1.918-.21 3.691-.248 4.638m16.378-30.508l2.822 2.914l-2.816 2.908l-2.822-2.914l2.816-2.908m-4.091 4.225l2.822 2.914l-20.901 21.588c-2.745-.175-6.041.573-8.878 3.343l26.957-27.845M9.236 38.367c4.085-3.368 6.606-6.871 8.664-9.647c3.544-4.783 5.396-7.568 10.644-5.348l-18.53 19.141c-.917-.541-3.09-2.24-.778-4.146M5.965 51.405l2.959-5.508l.255.263a4.758 4.758 0 0 0 .161 3.206l-3.375 2.039m54.381-2.683c-.271 1.688-2.309 3.986-4.612 3.986c-7.643 0-11.49 1.126-15.48 1.772c-7.724 1.249-13.457-.34-15.953-1.931c-6.256-3.986-9.667-1.93-12.542-4.145c-.925-.713-.842-2.455.063-3.544c4-4.802 9.208-3.997 10.898-3.195c4.865 2.31 9.289 2.65 10.472 2.392c1.185-.242 2.233-.886 3.051-1.693c-.93.683-2.016 1.133-3.124 1.192c-1.105.077-4.287-.916-4.826-1.147c-.195-.957-.509-2.663-.538-3.914c1.994 2.033 4.186 2.549 4.186 2.549l-4.265-5.624s6.24-6.871 10.392-8.98c6.99 2.052 14.336 4.354 16.45 5.514c3.598 1.971 6.798 10.756 5.828 16.768"/>
                        </svg>
                    </svg>
                    <span class="text-lg font-semibold sm:text-xl md:text-2xl lg:text-3xl xl:text-4xl gradient-text" font-family="Arial, sans-serif">Creative</span>
                    <span class="text-lg font-semibold sm:text-xl md:text-2xl lg:text-3xl xl:text-4xl gradient-text" font-family="Arial, sans-serif">Hub</span>
                </a>

                <!-- Navigation Links -->
                <!-- <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div> -->
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Create Content Dropdown -->
                 @auth
                    @if (Auth::user()->hasRole('student'))
                        <div class="relative ms-3">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <span class="inline-flex rounded-md">
                                        <button type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50">
                                        <svg class="w-5 h-5 me-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 4c-.552 0-1 .448-1 1v6H5c-.552 0-1 .448-1 1s.448 1 1 1h6v6c0 .552.448 1 1 1s1-.448 1-1v-6h6c.552 0 1-.448 1-1s-.448-1-1-1h-6V5c0-.552-.448-1-1-1z"/>
                                        </svg>
                                            Create Content
                                            <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </button>
                                    </span>
                                </x-slot>

                                <x-slot name="content">
                                    <x-dropdown-link href="{{ route('student.createContent')}}">
                                        {{ __('Create a new story') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link href="#">
                                        {{ __('Post new artwork') }}
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    @endif
                @endauth


                <!-- Teams Dropdown -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="relative ms-3">
                        <x-dropdown align="right" width="60">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50">
                                        {{ Auth::user()->currentTeam->name }}

                                        <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                        </svg>
                                    </button>
                                </span>
                            </x-slot>

                            <x-slot name="content">
                                <div class="w-60">
                                    <!-- Team Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Manage Team') }}
                                    </div>

                                    <!-- Team Settings -->
                                    <x-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                        {{ __('Team Settings') }}
                                    </x-dropdown-link>

                                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                        <x-dropdown-link href="{{ route('teams.create') }}">
                                            {{ __('Create New Team') }}
                                        </x-dropdown-link>
                                    @endcan

                                    <!-- Team Switcher -->
                                    @if (Auth::user()->allTeams()->count() > 1)
                                        <div class="border-t border-gray-200"></div>

                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            {{ __('Switch Teams') }}
                                        </div>

                                        @foreach (Auth::user()->allTeams() as $team)
                                            <x-switchable-team :team="$team" />
                                        @endforeach
                                    @endif
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endif

                <!-- Settings Dropdown -->
                <div class="relative ms-3">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button class="flex text-sm transition border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300">
                                    <img class="object-cover w-8 h-8 rounded-full" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50">
                                        {{ Auth::user()->name }}

                                        <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Account') }}
                            </div>

                            <x-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <x-dropdown-link href="{{ $dashboardRoute }}">
                                {{ __('Dashboard') }}
                            </x-dropdown-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                    {{ __('API Tokens') }}
                                </x-dropdown-link>
                            @endif

                            <div class="border-t border-gray-200"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-dropdown-link href="{{ route('logout') }}"
                                         @click.prevent="$root.submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="flex items-center -me-2 sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 text-gray-400 transition duration-150 ease-in-out rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500">
                    <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Create Content Dropdown -->
        @auth
            @if (Auth::user()->hasRole('student'))
                <div class="pt-2 pb-3 space-y-1">
                    <x-responsive-nav-link href="#">
                        {{ __('Create a new story') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="#">
                        {{ __('Post new artwork') }}
                    </x-responsive-nav-link>
                </div>
            @endif
        @endauth

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="shrink-0 me-3">
                        <img class="object-cover w-10 h-10 rounded-full" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                    </div>
                @endif

                <div>
                    <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <x-responsive-nav-link href="{{ route('logout') }}"
                                   @click.prevent="$root.submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>

                <!-- Team Management -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="border-t border-gray-200"></div>

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Manage Team') }}
                    </div>

                    <!-- Team Settings -->
                    <x-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
                        {{ __('Team Settings') }}
                    </x-responsive-nav-link>

                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                        <x-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                            {{ __('Create New Team') }}
                        </x-responsive-nav-link>
                    @endcan

                    <!-- Team Switcher -->
                    @if (Auth::user()->allTeams()->count() > 1)
                        <div class="border-t border-gray-200"></div>

                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Switch Teams') }}
                        </div>

                        @foreach (Auth::user()->allTeams() as $team)
                            <x-switchable-team :team="$team" component="responsive-nav-link" />
                        @endforeach
                    @endif
                @endif
            </div>
        </div>
    </div>
</nav>
