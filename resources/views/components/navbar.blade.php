<header class="text-gray-600 body-font">
    <div class="container mx-auto flex flex-wrap p-5 flex-col md:flex-row items-center">
        <a href="{{ url('/') }}" class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0">
            <img src="{{ asset('img/logo-senacit.png') }}" class="h-20" alt="Flowbite Logo" />
        </a>
        
        @if (request()->is('/'))
            <nav class="md:ml-auto flex flex-wrap items-center text-base justify-center">
                @if (Route::has('login'))
                    <nav class="flex items-center justify-end gap-4">
                        @auth
                            <a
                                href="{{ url('/homepage') }}"
                                class="inline-block px-5 py-1.5 border-[#19140035] hover:border-[#1915014a] border text-[#ffffff] rounded-sm text-6xl leading-normal"
                            >
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="group relative w-full sm:w-auto px-6 py-3 min-w-[160px]">
                                <div class="absolute inset-0 bg-gradient-to-r from-violet-600 to-cyan-600 rounded-lg"></div>
                                <div class="absolute inset-0 bg-gradient-to-r from-violet-600 to-cyan-600 rounded-lg blur-lg group-hover:opacity-60 transition-opacity duration-500"></div>
                                <div class="relative flex items-center justify-center gap-2">
                                    <span class="text-white font-medium">Iniciar Sesion</span>
                                </div>
                            </a>
                            
                            @if (Route::has('register'))
                                <a
                                    href="{{ route('register') }}"
                                    class="inline-block px-2 underline underline-offset-4 border-[#19140035] hover:border-[#1915014a] border text-[#ffffff] rounded-sm text-xl leading-normal">
                                    Registrar
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </nav>
        @endif
    </div>
</header>