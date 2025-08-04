<x-app-layout>
    
    <div class="max-w-screen-xl mx-auto p-5 sm:p-10 md:p-16 motion-preset-slide-right">
       
         
        <!-- Header del curso -->
        <div class="curso-header text-center py-8 text-white px-4 rounded-lg shadow-lg 
        animate-gradient-intense bg-[length:400%_400%] 
        bg-gradient-to-r from-blue-500 via-purple-500 to-pink-600 mt-[10%] sm:mt-0">
            <h1 class="text-4xl md:text-5xl font-bold mb-2 animate-title-pop">
                {{ $curso->titulo }}
            </h1>
            <p class="text-xl md:text-2xl font-light opacity-90 animate-subtitle-slide">
                Impartido por <span class="font-semibold text-yellow-300 drop-shadow-sm">{{ $curso->instructor_nombre }}</span> | Especialista en Programación
            </p>
        </div>

        <!-- Descripción del curso -->
        <p class="text-sm text-white p-4">
            {{ $curso->descripcion }}
        </p>   

        @if($porcentajeProgreso == 100)
            <!-- Mensaje de felicitaciones por completar el curso -->
            <div class="mt-8 text-center mb-8">
                <div class="rounded-lg p-6 text-white ">
                    <h3 class="text-3xl font-bold mb-4 flex items-center justify-center gap-3">
                        ¡Felicitaciones! 
                    </h3>
                    <p class="text-xl mb-6">Has completado exitosamente el curso "{{ $curso->titulo }}"</p>
                    
                  

                    
<!-- Botones de diploma cambiados a GET -->
<div class="flex flex-col sm:flex-row gap-4 justify-center">
    <!-- Botón para descargar diploma (GET) -->
    <a href="{{ route('diploma.descargar.directo', $curso->id) }}" 
       class="group relative px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold text-lg rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-blue-500/50 inline-flex items-center justify-center">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 blur-sm"></div>
        
        <div class="relative flex items-center gap-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <span>Descargar Diploma</span>
        </div>
    </a>

    <!-- Botón para ver diploma (GET) -->
    <a href="{{ route('diploma.ver.directo', $curso->id) }}" 
       target="_blank"
       class="group relative px-8 py-4 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold text-lg rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-purple-500/50 inline-flex items-center justify-center">
        <div class="absolute inset-0 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 blur-sm"></div>
        
        <div class="relative flex items-center gap-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
            </svg>
            <span>Ver Diploma</span>
        </div>
    </a>
</div>
                
                </div>
            </div>
        @endif 

        @if($estaInscrito)
          <!-- Estadísticas del progreso -->
<div class="flex justify-center mb-4">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-lg">
        <div class="flex items-center ">
            <div class="text-center px-2">
                <div class="text-2xl font-bold text-blue-600 mb-2">{{ $videosCompletados }}</div>
                <div class="text-sm text-gray-500 whitespace-nowrap">Videos Vistos</div>
            </div>
            <div class="text-center px-2">
                <div class="text-2xl font-bold text-gray-600 mb-2">{{ $totalVideos }}</div>
                <div class="text-sm text-gray-500 whitespace-nowrap">Total Videos</div>
            </div>
            <div class="text-center px-2">
                <div class="text-2xl font-bold text-green-600 mb-2">{{ $porcentajeProgreso }}%</div>
                <div class="text-sm text-gray-500 whitespace-nowrap">Completado</div>
            </div>
        </div>
    </div>
</div>

            <!-- Barra de progreso -->
            <div class="flex justify-between mt-3">
                <span class="text-base font-medium text-blue-700 dark:text-white">Progreso del Curso</span>
                <span class="text-sm font-medium text-blue-700 dark:text-white">{{ $porcentajeProgreso }}%</span>
            </div>

            <div class="w-full bg-gray-200 rounded-full mb-10 h-2.5 dark:bg-gray-700">
                <div 
                    class="bg-blue-600 h-2.5 rounded-full animate-progress transition-all duration-1000 ease-in-out"
                    style="--target-width: {{ $porcentajeProgreso }}%; width: {{ $porcentajeProgreso }}%"
                ></div>
            </div>

            <!-- Grid de videos -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
               @forelse($videos as $video)
    <a href="{{ route('video.mostrar', $video->id) }}" 
       class="group relative block bg-black rounded-lg overflow-hidden">
        
        <!-- Imagen del video -->
     <img
    alt="{{ $video->titulo }}"
    src="https://images.pexels.com/photos/771742/pexels-photo-771742.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500"
    class="absolute inset-0 h-full w-full rounded-lg object-cover 
           {{ $video->completado ? 'opacity-50' : 'opacity-75 group-hover:opacity-50' }} 
           transition-opacity"
/>
        
        <!-- Overlay de video completado -->
        @if($video->completado)
            <div class="absolute inset-0 bg-gray-900 opacity-50 rounded-lg"></div>
            <div class="absolute top-2 right-2 bg-green-500 text-white p-2 rounded-full shadow-lg">
             
            </div>
            <div class="absolute top-2 left-2 bg-green-500 text-white px-2 py-1 rounded text-xs font-medium">
                VISTO
            </div>
        @else
            <!-- Indicador de video no visto -->
            <div class="absolute top-2 left-2 bg-red-500 text-white px-2 py-1 rounded text-xs font-medium">
                PENDIENTE
            </div>
        @endif

        <!-- Play button overlay -->
        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
            <div class="bg-white bg-opacity-90 rounded-full p-4">
                <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path>
                </svg>
            </div>
        </div>
    
        <div class="relative p-8 mt-3">
            <p class="text-sm font-medium tracking-widest text-pink-500 uppercase">
                VIDEO {{ $video->orden }}
            </p>
    
            <p class="text-xl font-bold text-white sm:text-2xl">
                {{ $video->titulo }}
            </p>
    
            <div class="mt-32 sm:mt-48 lg:mt-64">
                <div class="translate-y-8 transform opacity-0 transition-all group-hover:translate-y-0 group-hover:opacity-100">
                    <p class="text-sm text-white">
                        @if($video->duracion)
                            Duración: {{ $video->duracion }} min
                        @endif
                        @if($video->completado && $video->ultima_vista)
                            <br><span class="text-green-300">Visto: {{ \Carbon\Carbon::parse($video->ultima_vista)->format('d/m/Y') }}</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </a>
@empty
                    <div class="col-span-full text-center py-8">
                        <p class="text-gray-500">No hay videos disponibles para este curso</p>
                    </div>
                @endforelse
            </div>


        @else
            <!-- Botón de Suscribirse -->
            <div class="flex justify-center mb-8">
                <button id="btnSuscribirse" class="group relative px-8 py-4 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold text-lg rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-green-500/50">
                    <div class="absolute inset-0 bg-gradient-to-r from-green-400 to-emerald-500 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 blur-sm"></div>
                    
                    <div class="relative flex items-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span class="btn-text">Suscribirse al Curso</span>
                        <svg class="animate-spin ml-2 h-5 w-5 text-white hidden" id="loading-suscripcion" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <div class="w-2 h-2 bg-white rounded-full animate-pulse" id="pulse-dot"></div>
                    </div>
                </button>
            </div>

            <!-- Mensaje de estado para suscripción -->
            <div id="mensaje-suscripcion" class="hidden mb-4 p-4 rounded-lg"></div>

            <!-- Mensaje de que debe suscribirse para ver videos -->
            <div class="text-center py-16">
                <div class="max-w-md mx-auto">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Contenido Restringido</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Suscríbete al curso para acceder a todos los videos y contenido educativo.</p>
                </div>
            </div>
        @endif

        <style>
            @keyframes progress {
                from { width: 0%; }
                to { width: var(--target-width); }
            }
            .animate-progress {
                animation: progress 1.5s ease-out forwards;
            }
        </style>
        
        <script>
            // Script para manejar suscripción
            const btnSuscribirse = document.getElementById('btnSuscribirse');
            if (btnSuscribirse) {
                btnSuscribirse.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const button = this;
                    const spinner = document.getElementById('loading-suscripcion');
                    const btnText = button.querySelector('.btn-text');
                    const pulseDot = document.getElementById('pulse-dot');
                    
                    button.disabled = true;
                    spinner.classList.remove('hidden');
                    pulseDot.classList.add('hidden');
                    btnText.textContent = 'Suscribiendo...';
                    
                    fetch(`{{ route('curso.suscribirse', $curso->id) }}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const messageDiv = document.getElementById('mensaje-suscripcion');
                            messageDiv.textContent = '¡Te has suscrito exitosamente! Recargando página...';
                            messageDiv.className = 'mb-4 p-4 rounded-lg bg-green-100 border border-green-400 text-green-700';
                            messageDiv.classList.remove('hidden');
                            
                            setTimeout(() => {
                                window.location.reload();
                            }, 2000);
                        } else {
                            throw new Error(data.message);
                        }
                    })
                    .catch(error => {
                        const messageDiv = document.getElementById('mensaje-suscripcion');
                        messageDiv.textContent = `Error: ${error.message}`;
                        messageDiv.className = 'mb-4 p-4 rounded-lg bg-red-100 border border-red-400 text-red-700';
                        messageDiv.classList.remove('hidden');
                        
                        button.disabled = false;
                        spinner.classList.add('hidden');
                        pulseDot.classList.remove('hidden');
                        btnText.textContent = 'Suscribirse al Curso';
                    });
                });
            }
        </script>

    </div>
</x-app-layout>