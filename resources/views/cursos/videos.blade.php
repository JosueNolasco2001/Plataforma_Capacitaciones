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
                Impartido por <span class="font-semibold text-yellow-300 drop-shadow-sm">{{ $curso->instructor_nombre }}</span> 
            </p>
        </div>

        <!-- Descripción del curso -->
        <p class="text-sm text-white p-4">
            {{ $curso->descripcion }}
        </p>   

        @if($estaInscrito)
            <!-- Estadísticas del progreso -->
          <div class="flex justify-center mb-4">
    <div class="bg-gray-800 rounded-lg p-6 shadow-lg">
        <div class="flex items-center">
            <div class="text-center px-2">
                <div class="text-2xl font-bold text-blue-400 mb-2">{{ $videosCompletados }}</div>
                <div class="text-sm text-gray-400 whitespace-nowrap">Videos Vistos</div>
            </div>
            <div class="text-center px-2">
                <div class="text-2xl font-bold text-gray-300 mb-2">{{ $totalVideos }}</div>
                <div class="text-sm text-gray-400 whitespace-nowrap">Total Videos</div>
            </div>
            <div class="text-center px-2">
                <div class="text-2xl font-bold text-green-400 mb-2">{{ $porcentajeProgreso }}%</div>
                <div class="text-sm text-gray-400 whitespace-nowrap">Completado</div>
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

            <!-- SECCIÓN DE EXAMEN - SOLO para usuarios inscritos -->
            @if($examenCurso)
            <div class="mb-8 p-6 bg-gradient-to-r from-gray-800 to-gray-900 rounded-xl border border-gray-700 shadow-lg">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex-1">
            <h3 class="text-xl font-bold text-white mb-2 flex items-center gap-2">
                Examen Final: {{ $examenCurso->titulo }}
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-300">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span><strong>Duración:</strong> {{ $examenCurso->duracion_minutos }} min</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <span><strong>Intentos:</strong> {{ $examenCurso->intentos_permitidos }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span><strong>Aprobación:</strong> {{ $examenCurso->porcentaje_aprobacion }}%</span>
                </div>
            </div>
            
            @if($examenCurso->descripcion)
                <p class="mt-3 text-gray-300 text-sm">{{ $examenCurso->descripcion }}</p>
            @endif
        </div>
        
        <div class="flex flex-col gap-3">
            @if($puedeRealizarExamen)
                <!-- Botón para realizar examen (habilitado) -->
                @if($tieneExamenPendiente)
                    <a href="{{ route('examenes.continuar', $examenCurso->id) }}" 
                       class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-105 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Continuar Examen Pendiente
                    </a>
                @else
                    <a href="{{ route('examenes.tomar', $examenCurso->id) }}" 
                       class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-105 flex items-center justify-center gap-2">
                       Realizar Examen
                    </a>
                @endif
                
                <!-- Ver resultados si ya ha realizado intentos -->
                @if($mejorCalificacion > 0)
                    <a href="{{ route('examenes.resultado', $examenCurso->id) }}" 
                       class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition-all duration-300 transform hover:scale-105 flex items-center justify-center gap-2 text-sm">
                        Ver Resultados
                    </a>
                @endif
            @else
                <!-- Botón deshabilitado (no ha completado videos) -->
                <button disabled
                       class="bg-gray-600 cursor-not-allowed text-gray-300 font-bold py-3 px-6 rounded-lg flex items-center justify-center gap-2 opacity-75">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    Completa todos los videos para habilitar
                </button>
            @endif
            
            <!-- Mostrar mejor calificación si existe -->
            @if($mejorCalificacion > 0)
                <div class="text-center">
                    <span class="text-sm font-medium {{ $mejorCalificacion >= $examenCurso->porcentaje_aprobacion ? 'text-green-400' : 'text-yellow-400' }}">
                        Mejor calificación: <strong>{{ $mejorCalificacion }}%</strong>
                        @if($mejorCalificacion >= $examenCurso->porcentaje_aprobacion)
                             Aprobado
                        @else
                             Por mejorar
                        @endif
                    </span>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Mensaje informativo sobre requisitos -->
    @if(!$puedeRealizarExamen)
        <div class="mt-4 p-3 bg-blue-900/20 border border-blue-800 rounded-lg">
            <p class="text-sm text-blue-300 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Debes completar <strong>{{ $totalVideos - $videosCompletados }} video(s) más</strong> para habilitar el examen.
            </p>
        </div>
    @endif
</div>
            @endif

            <!-- Grid de videos -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
               @forelse($videos as $video)
             <a href="{{ route('video.mostrar', $video->id) }}"                     class="group relative block rounded-lg overflow-hidden min-h-[400px]">
                    
    <!-- Fondo animado con gradiente - Colores violeta/fucsia/cyan/azul -->
    <div class="absolute inset-0 bg-gradient-to-br from-violet-600 via-fuchsia-600 to-cyan-600 animate-gradient"></div>
    
    <!-- Capa de blur y oscurecimiento -->
    <div class="absolute inset-0 backdrop-blur-sm bg-[#0A0A0A]/40 
                {{ $video->completado ? 'bg-[#0A0A0A]/70' : 'group-hover:bg-[#0A0A0A]/50' }} 
                transition-all duration-300"></div>
    
    <!-- Efecto de brillo animado con esferas flotantes -->
    <div class="absolute inset-0 opacity-40">
        <div class="absolute top-0 -left-4 w-24 h-24 bg-violet-400 rounded-full mix-blend-overlay blur-xl animate-blob"></div>
        <div class="absolute top-0 -right-4 w-24 h-24 bg-fuchsia-400 rounded-full mix-blend-overlay blur-xl animate-blob-delay-2"></div>
        <div class="absolute -bottom-8 left-20 w-24 h-24 bg-cyan-400 rounded-full mix-blend-overlay blur-xl animate-blob-delay-4"></div>
    </div>
                                      
    <!-- Badges de estado -->
    @if($video->completado)
        <div class="absolute top-4 left-4 bg-emerald-500 text-white px-3 py-1.5 rounded-md text-xs font-semibold z-20 shadow-lg backdrop-blur-sm">
            VISTO
        </div>
    @else
        <div class="absolute top-4 left-4 bg-fuchsia-600 text-white px-3 py-1.5 rounded-md text-xs font-semibold z-20 shadow-lg backdrop-blur-sm">
            ● PENDIENTE
        </div>
    @endif
     
    <!-- Play button overlay -->
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 z-10">
        <div class="bg-white/95 rounded-full p-5 shadow-2xl transform group-hover:scale-110 transition-transform duration-300">
            <svg class="w-10 h-10 text-violet-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path>
            </svg>
        </div>
    </div>
                                 
    <!-- Contenido de la tarjeta -->
    <div class="relative h-full flex flex-col justify-between p-6 sm:p-8 z-10">
        <div>
         
                                      
            <h3 class="text-xlc mt-10 sm:text-2xl lg:text-3xl font-bold text-white leading-tight drop-shadow-lg">
                {{ $video->titulo }}
            </h3>
        </div>
                                      
        <!-- Información adicional -->
        <div class="mt-32 sm:mt-48 lg:mt-64">
            <div class="translate-y-8 transform opacity-0 transition-all duration-300 group-hover:translate-y-0 group-hover:opacity-100">
              
                   
                    @if($video->completado && $video->ultima_vista)
                      <div class="bg-[#0A0A0A]/60 backdrop-blur-md rounded-lg px-4 py-3 inline-block border border-violet-500/30">
                        <p class="text-sm text-emerald-300 mt-1">
                            <span class="text-emerald-400">✓</span> Visto el {{ \Carbon\Carbon::parse($video->ultima_vista)->format('d/m/Y') }}
                        </p>
                      </div>
                    @endif
             
            </div>
        </div>
    </div>
</a>

<style>
/* Animación de gradiente */
@keyframes gradient {
    0%, 100% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
}

/* Animación de esferas flotantes */
@keyframes blob {
    0%, 100% {
        transform: translate(0, 0) scale(1);
    }
    33% {
        transform: translate(30px, -50px) scale(1.1);
    }
    66% {
        transform: translate(-20px, 20px) scale(0.9);
    }
}

.animate-gradient {
    background-size: 200% 200%;
    animation: gradient 15s ease infinite;
}

.animate-blob {
    animation: blob 7s infinite;
}

.animate-blob-delay-2 {
    animation: blob 7s infinite;
    animation-delay: 2s;
}

.animate-blob-delay-4 {
    animation: blob 7s infinite;
    animation-delay: 4s;
}
</style>
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