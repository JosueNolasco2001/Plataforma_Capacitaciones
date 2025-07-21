<x-app-layout>
    <!-- Contenedor con padding superior -->
    <div class="pt-14 pb-12">
        <form action="{{ route('cursos.buscar') }}" method="GET" class="max-w-2xl mx-auto px-4">
            <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input type="search"
                        name="buscar"
                        value="{{ $busqueda ?? '' }}"
                        class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300/50 rounded-lg bg-white/90 backdrop-blur-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800/90 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 shadow-lg"
                        placeholder="Buscar cursos, temas, instructores..."
                        required />
                <button type="submit"
                         class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors shadow-md">
                    Buscar
                </button>
            </div>
        </form>

        <!-- Resultados de búsqueda -->
        @if(isset($busqueda) && !empty($busqueda))
            <div class="max-w-7xl mx-auto mt-8 sm:px-6 lg:px-8">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-white">
                        Resultados para: "{{ $busqueda }}"
                        <span class="text-lg font-normal text-gray-300">({{ $cursos->total() }} {{ $cursos->total() == 1 ? 'resultado' : 'resultados' }})</span>
                    </h2>
                </div>
                
                <div class="overflow-hidden sm:rounded-lg">
                    <div class="max-w-screen-xl mx-auto p-5 sm:p-10 md:p-16 motion-preset-slide-right">
                        <div class="grid grid-cols-1 md:grid-cols-3 sm:grid-cols-2 gap-10">
                            @forelse($cursos as $curso)
                                <div class="rounded overflow-hidden shadow-lg relative">
                                    <!-- Badge de estado -->
                                    @if($curso->estado_inscripcion == 'inscrito')
                                        <div class="absolute top-2 right-2 z-10 bg-blue-500 text-white px-2 py-1 rounded text-xs font-medium">
                                            INSCRITO
                                        </div>
                                    @endif

                                    <div class="relative">
                                        <a href="{{ route('curso.videos', $curso->id) }}">
                                            <img class="w-full" 
                                                 src="{{ $curso->urlImg ? asset('storage/img/' . $curso->urlImg) : 'https://images.pexels.com/photos/257816/pexels-photo-257816.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500' }}"                                             
                                                 alt="{{ $curso->titulo }}">
                                            <div class="hover:bg-transparent transition duration-300 absolute bottom-0 top-0 right-0 left-0 bg-gray-900 opacity-25"></div>
                                        </a> 
                                        <a href="#!">
                                            <div class="absolute bottom-0 left-0 bg-indigo-600 px-4 py-2 text-white text-sm hover:bg-white hover:text-indigo-600 transition duration-500 ease-in-out">
                                                {{ $curso->categoria ?? 'Curso' }}
                                            </div>
                                        </a>
                                    </div>
                                    <div class="px-6 py-4">
                                        <a href="{{ route('curso.videos', $curso->id) }}" 
                                           class="font-semibold text-white text-lg inline-block hover:text-indigo-600 transition duration-500 ease-in-out">
                                            {{ $curso->titulo }}
                                        </a>
                                        <p class="text-gray-500 text-sm">
                                            {{ Str::limit($curso->descripcion, 100) }}
                                        </p>
                                        <p class="text-gray-400 text-xs mt-2">
                                            Instructor: {{ $curso->instructor_nombre }}
                                        </p>
                                    </div>
                                    <div class="px-6 py-4 flex flex-row items-center">
                                        <div class="flex items-center flex-wrap">
                                            <span class="text-gray-400 mr-3 inline-flex items-center leading-none text-sm pr-3 py-1 border-r-2 border-gray-600">
                                                <svg class="w-4 h-4 mr-1" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                                    <path d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                                </svg>{{ $curso->videos_count }}
                                            </span>
                                            <span class="text-gray-400 inline-flex items-center leading-none text-sm">
                                                <svg class="w-4 h-4 mr-1" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                                    <path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"></path>
                                                </svg>{{ $curso->comentarios_count }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full text-center py-8">
                                    <p class="text-gray-500">No se encontraron cursos que coincidan con tu búsqueda</p>
                                </div>
                            @endforelse
                        </div>
                        
                        <!-- Paginación Laravel (igual que tu ejemplo) -->
                        @if($cursos->hasPages())
                            <center class="mt-8">{{ $cursos->links() }}</center>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>