<nav class="bg-white border-b border-gray-200 dark:bg-gray-900 dark:border-gray-700 shadow-lg fixed w-full top-0 left-0 z-50">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto px-4 py-2">
        
        <!-- Logo y Menú Hamburguesa (Mobile) -->
        <div class="flex items-center justify-between w-full md:w-auto">
            <!-- Logo -->
            <a href="{{ route('cursos.disponibles') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="{{ asset('img/logo-senacit.png') }}" class="h-20 " alt="Flowbite Logo" />

            </a>

            <!-- Mobile menu button -->
            <button data-collapse-toggle="navbar-cta" type="button" 
                    class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600 transition-colors" 
                    aria-controls="navbar-cta" aria-expanded="false">
                <span class="sr-only">Abrir menú principal</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                </svg>
            </button>
        </div>

        <!-- Navigation Menu (Centrado) -->
       <!-- Navigation Menu (Centrado) -->
<div class="hidden md:flex md:order-1 md:w-auto md:flex-1 md:justify-center">
    <ul class="flex space-x-8">
        @unless (Auth::user()->role === 'admin')
            <!-- Menú para usuarios normales -->
            <li>
                <a href="{{ route('cursos.disponibles') }}" 
                   class="py-2 px-4 rounded-lg font-medium transition-all duration-200 
                          {{ request()->routeIs('cursos.disponibles') || request()->routeIs('dashboard') 
                             ? 'text-blue-700' 
                             : 'text-gray-700 hover:text-blue-700 hover:bg-blue-50 dark:text-gray-300 dark:hover:text-blue-400 dark:hover:bg-gray-700' }}">
                    Inicio
                </a>
            </li>
            <li>
                <a href="{{ route('cursos.mis-cursos') }}" 
                   class="py-2 px-4 rounded-lg font-medium transition-all duration-200 
                          {{ request()->routeIs('cursos.mis-cursos') 
                             ? 'text-blue-700' 
                             : 'text-gray-700 hover:text-blue-700 hover:bg-blue-50 dark:text-gray-300 dark:hover:text-blue-400 dark:hover:bg-gray-700' }}">
                    Cursos en progreso
                </a>
            </li>
            <li>
                <a href="{{ route('cursos.completados') }}" 
                   class="py-2 px-4 rounded-lg font-medium transition-all duration-200 
                          {{ request()->routeIs('cursos.completados') 
                             ? 'text-blue-700' 
                             : 'text-gray-700 hover:text-blue-700 hover:bg-blue-50 dark:text-gray-300 dark:hover:text-blue-400 dark:hover:bg-gray-700' }}">
                    Cursos Terminados
                </a>
            </li>
        @endunless

        <!-- Menú común para todos (incluyendo admins) -->
        <li>
            <a href="{{ route('cursos.buscar') }}" 
               class="py-2 px-4 rounded-lg font-medium transition-all duration-200 
                      {{ request()->routeIs('cursos.buscar') 
                         ? 'text-blue-700' 
                         : 'text-gray-700 hover:text-blue-700 hover:bg-blue-50 dark:text-gray-300 dark:hover:text-blue-400 dark:hover:bg-gray-700' }}">
                Buscar Curso
            </a>
        </li>

        <!-- Opción solo para admins -->
        @if (Auth::user()->role === 'admin')
            <li>
                <a href="{{ route('agregar.video') }}" 
                   class="py-2 px-4 rounded-lg font-medium transition-all duration-200 
                          {{ request()->routeIs('agregar.video') 
                             ? 'text-blue-700' 
                             : 'text-gray-700 hover:text-blue-700 hover:bg-blue-50 dark:text-gray-300 dark:hover:text-blue-400 dark:hover:bg-gray-700' }}">
                    Agregar nuevo curso
                </a>
            </li>
        @endif
    </ul>
</div>

        <!-- User Menu (Derecha) -->
        <div class="hidden md:flex items-center md:order-2 space-x-3">
            
            <!-- Teams Dropdown (Solo Desktop) -->
            @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                <div class="hidden md:block ms-3 relative">
                    <x-dropdown align="right" width="60">
                        <x-slot name="trigger">
                            <span class="inline-flex rounded-md">
                                <button type="button" class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm leading-4 font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                                    {{ Auth::user()->currentTeam->name }}
                                    <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
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

            <!-- User Profile Dropdown -->
            <div class="ms-3 relative">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown" 
                            class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition hover:border-gray-400" 
                            type="button">
                        <img class="size-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                    </button>
                @else
                    <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown" 
                            class="group relative w-full sm:w-auto px-5 py-2.5 min-w-[160px] 
                                   font-medium rounded-lg text-sm text-center inline-flex items-center 
                                   focus:outline-none focus:ring-4 focus:ring-cyan-600/30 transition-all duration-300" 
                            type="button">
                        <!-- Gradiente base -->
                        <div class="absolute inset-0 bg-gradient-to-r from-violet-600 to-cyan-600 rounded-lg transition-all duration-300"></div>
                        <!-- Efecto blur hover -->
                        <div class="absolute inset-0 bg-gradient-to-r from-violet-600 to-cyan-600 
                                    rounded-lg blur-lg opacity-0 group-hover:opacity-60 transition-opacity 
                                    duration-500"></div>
                        
                        <!-- Contenido del botón -->
                        <div class="relative flex items-center gap-2 text-white">
                            <span class="truncate">{{ Auth::user()->name }}</span>
                            <svg class="w-2.5 h-2.5 ms-3 transition-transform duration-200 group-hover:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                            </svg>
                        </div>
                    </button>
                @endif
                
                <!-- Dropdown menu -->
                <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-lg border border-gray-200 w-48 dark:bg-gray-700 dark:divide-gray-600 dark:border-gray-600">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                        <!-- Account Management -->
                        <li>
                            <span class="block px-4 py-2 text-xs text-gray-400 dark:text-gray-500">{{ __('Manejo de cuentas') }}</span>
                        </li>
                        
                        <li>
                            <a href="{{ route('profile.show') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white transition-colors">
                                {{ __('Perfil') }}
                            </a>
                        </li>
{{--                 
                        @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                        <li>
                            <a href="{{ route('api-tokens.index') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white transition-colors">
                                {{ __('API Tokens') }}
                            </a>
                        </li>
                        @endif --}}
                
                        <li class="border-t border-gray-200 dark:border-gray-600"></li>
                
                        <!-- Authentication -->
                        <li>
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf
                                <button type="submit" class="w-full text-left block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white transition-colors">
                                    Salir
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Menu (Expandible) -->
    <div id="navbar-cta" class="hidden md:hidden border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">
        <div class="px-4 py-3 space-y-1">
            <!-- Mobile Teams Section -->
            @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                <div class="pb-3 border-b border-gray-200 dark:border-gray-700">
                    <div class="text-xs text-gray-400 dark:text-gray-500 mb-2">Equipo</div>
                    <div class="px-3 py-2 text-sm text-gray-700 dark:text-gray-300">
                        {{ Auth::user()->currentTeam->name }}
                    </div>
                    <a href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" 
                       class="block px-3 py-1 text-xs text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 rounded transition-colors">
                        Configuración del Equipo
                    </a>
                </div>
            @endif
            
            <!-- Mobile Navigation Links -->
           <!-- Mobile Navigation Links -->
<div class="space-y-1 pt-2">
    @unless (Auth::user()->role === 'admin')
        <!-- Menú para usuarios normales -->
        <a href="{{ route('cursos.disponibles') }}" 
           class="block px-3 py-2 text-sm font-medium rounded-lg transition-colors
                  {{ request()->routeIs('cursos.disponibles') || request()->routeIs('dashboard') 
                     ? 'text-blue-700' 
                     : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }}">
            Inicio
        </a>
        <a href="{{ route('cursos.mis-cursos') }}" 
           class="block px-3 py-2 text-sm font-medium rounded-lg transition-colors
                  {{ request()->routeIs('cursos.mis-cursos') 
                     ? 'text-blue-700' 
                     : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }}">
            Cursos en progreso
        </a>
        <a href="{{ route('cursos.completados') }}" 
           class="block px-3 py-2 text-sm font-medium rounded-lg transition-colors
                  {{ request()->routeIs('cursos.completados') 
                     ? 'text-blue-700' 
                     : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }}">
            Cursos Terminados
        </a>
    @endunless

    <!-- Menú común para todos -->
    <a href="{{ route('cursos.buscar') }}" 
       class="block px-3 py-2 text-sm font-medium rounded-lg transition-colors
              {{ request()->routeIs('cursos.buscar') 
                 ? 'text-blue-700' 
                 : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }}">
        Buscar Curso
    </a>

    <!-- Opción solo para admins -->
    @if (Auth::user()->role === 'admin')
        <a href="{{ route('agregar.video') }}" 
           class="block px-3 py-2 text-sm font-medium rounded-lg transition-colors
                  {{ request()->routeIs('agregar.video') 
                     ? 'text-blue-700' 
                     : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }}">
            Agregar Video
        </a>
    @endif
</div>
            
            <!-- Mobile User Menu -->
            <div class="pt-3 border-t border-gray-200 dark:border-gray-700">
                <div class="text-xs text-gray-400 dark:text-gray-500 mb-2">Cuenta</div>
                <a href="{{ route('profile.show') }}" 
                   class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700 rounded-lg transition-colors">
                    Perfil
                </a>
                {{-- @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <a href="{{ route('api-tokens.index') }}" 
                       class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700 rounded-lg transition-colors">
                        Tokens API
                    </a>
                @endif --}}
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf
                    <button type="submit" 
                            class="w-full text-left px-3 py-2 text-sm text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-gray-700 rounded-lg transition-colors">
                        Salir
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>