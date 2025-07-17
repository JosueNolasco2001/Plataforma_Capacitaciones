

<x-app-layout>
    <div class="max-w-screen-xl mx-auto p-5 sm:p-10 md:p-16 motion-preset-slide-right">

        <!-- Header del curso -->
        <div class="curso-header text-center py-8 text-white px-4 rounded-lg shadow-lg 
        animate-gradient-intense bg-[length:400%_400%] 
        bg-gradient-to-r from-blue-500 via-purple-500 to-pink-600">
            <h1 class="text-4xl md:text-5xl font-bold mb-2 animate-title-pop">
                {{ $video->curso_titulo }}
            </h1>
        </div>

        <!-- Título del video -->
        <center>
            <p class="mt-8 text-xl md:text-2xl font-light opacity-90 animate-subtitle-slide text-white">
                VIDEO {{ $video->orden }}: <span class="font-semibold text-yellow-300 drop-shadow-sm">{{ strtoupper($video->titulo) }}</span>
            </p>
        </center>

        <!-- Reproductor de video -->
        <center>
           <video id="videoPlayer" class="rounded-lg" controls>
                <source src="{{ asset('storage/videos/' . $video->url) }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </center>
        <!-- Indicador de estado del video -->
<div id="video-status" class="text-center mt-4 text-white">
    @if($yaVisto)
        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
       
            Video Completado
        </span>
    @else
        <span id="pending-status" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
          
            Pendiente de Completar
        </span>
        <span id="completed-status" class="hidden inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
          
            ¡Video Completado! 🎉
        </span>
    @endif
</div>

        <!-- Formulario de comentarios -->
        <form id="comentarioForm" class="mt-10">
            @csrf
            <div class="w-full mb-4 rounded-lg dark:bg-[rgba(17,24,39,0.4)]">
                <div class="px-4 py-2 dark:bg-[rgba(17,24,39,0.4)]">
                    <label for="contenido" class="sr-only">Your comment</label>
                    <textarea id="contenido" name="contenido" rows="4" 
                              class="w-full px-0 text-sm text-gray-900 bg-white border-0 dark:bg-[rgba(17,24,39,0.4)] focus:ring-0 dark:text-white dark:placeholder-gray-400" 
                              placeholder="Write a comment..." required></textarea>
                </div>
                <div class="flex items-center justify-between px-3 py-2 border-t dark:border-gray-600 border-gray-200">
                    <button type="submit" id="btnComentario"
                            class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-900 hover:bg-blue-800">
                        <span class="btn-text">Post comment</span>
                        <svg class="animate-spin ml-2 h-4 w-4 text-white hidden" id="loading-spinner" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </form>

        <!-- Mensaje de estado -->
        <div id="mensaje" class="hidden mb-4 p-4 rounded-lg"></div>

        <p class="ms-auto text-xs text-gray-500 dark:text-gray-400">
            Remember, contributions to this topic should follow our 
            <a href="#" class="text-blue-600 dark:text-blue-500 hover:underline">Community Guidelines</a>.
        </p>

        <!-- Contenedor de comentarios -->
        <div id="comentarios-container">
            @forelse($comentarios as $comentario)
                <article class="comentario-item p-6 text-base rounded-lg bg-[rgba(255,255,255,0.6)] dark:bg-[rgba(17,24,39,0.4)] mb-4" data-comentario-id="{{ $comentario->id }}">
                    <footer class="flex justify-between items-center mb-2">
                        <div class="flex items-center">
                            <p class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white font-semibold">
                                <img class="mr-2 w-6 h-6 rounded-full"
                                     src="{{ $comentario->profile_photo_path ? asset('storage/' . $comentario->profile_photo_path) : 'https://flowbite.com/docs/images/people/profile-picture-2.jpg' }}"
                                     alt="{{ $comentario->usuario_nombre }}">
                                {{ $comentario->usuario_nombre }}
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                <time>{{ \Carbon\Carbon::parse($comentario->fecha_creacion)->format('M. d, Y') }}</time>
                            </p>
                        </div>
                    </footer>
                    <p class="text-gray-500 dark:text-gray-400">{{ $comentario->contenido }}</p>
                    
                    <!-- Botón para responder -->
                    <div class="flex items-center mt-4 space-x-4">
                        <button type="button" onclick="toggleRespuestaForm({{ $comentario->id }})"
                                class="flex items-center text-sm text-gray-500 hover:underline dark:text-gray-400 font-medium">
                            <svg class="mr-1.5 w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 18">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5h5M5 8h2m6-3h2m-5 3h6m2-7H2a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h3v5l5-5h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1Z"/>
                            </svg>
                            Reply
                        </button>
                    </div>

                    <!-- Formulario de respuesta (oculto por defecto) -->
                    <form id="respuestaForm-{{ $comentario->id }}" class="respuesta-form hidden mt-4 ml-6">
                        @csrf
                        <div class="flex items-start space-x-4">
                            <div class="flex-1">
                                <textarea name="contenido" rows="3" 
                                          class="w-full px-3 py-2 text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                          placeholder="Write a reply..." required></textarea>
                            </div>
                            <div class="flex flex-col space-y-2">
                                <button type="submit" 
                                        class="px-4 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-200">
                                    <span class="btn-text">Reply</span>
                                </button>
                                <button type="button" onclick="toggleRespuestaForm({{ $comentario->id }})"
                                        class="px-4 py-2 text-xs font-medium text-center text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:ring-gray-200">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    <!-- Respuestas existentes -->
                    <div class="respuestas-container">
                        @if(isset($comentario->respuestas) && count($comentario->respuestas) > 0)
                            @foreach($comentario->respuestas as $respuesta)
                                <article class="respuesta-item p-6 mb-3 mt-3 ml-6 lg:ml-12 text-base bg-[rgba(255,255,255,0.6)] dark:bg-[rgba(17,24,39,0.4)] rounded-lg">
                                    <footer class="flex justify-between items-center mb-2">
                                        <div class="flex items-center">
                                            <p class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white font-semibold">
                                                <img class="mr-2 w-6 h-6 rounded-full"
                                                     src="{{ $respuesta->profile_photo_path ? asset('storage/' . $respuesta->profile_photo_path) : 'https://flowbite.com/docs/images/people/profile-picture-5.jpg' }}"
                                                     alt="{{ $respuesta->usuario_nombre }}">
                                                {{ $respuesta->usuario_nombre }}
                                            </p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                <time>{{ \Carbon\Carbon::parse($respuesta->fecha_creacion)->format('M. d, Y') }}</time>
                                            </p>
                                        </div>
                                    </footer>
                                    <p class="text-gray-500 dark:text-gray-400">{{ $respuesta->contenido }}</p>
                                </article>
                            @endforeach
                        @endif
                    </div>
                </article>
            @empty
                <div id="no-comments" class="text-center py-8">
                    <p class="text-gray-500 dark:text-gray-400">No hay comentarios aún. ¡Sé el primero en comentar!</p>
                </div>
            @endforelse
        </div>
    </div>

    <script>
        // Token CSRF para las peticiones AJAX
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        

        let videoMarcadoComoVisto = {{ $yaVisto ? 'true' : 'false' }};

// Función para marcar video como visto
function marcarVideoComoVisto() {
    if (videoMarcadoComoVisto) return; // Ya está marcado

    fetch(`{{ route('video.marcar-visto', $video->id) }}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            videoMarcadoComoVisto = true;
            
            // Actualizar UI
            const pendingStatus = document.getElementById('pending-status');
            const completedStatus = document.getElementById('completed-status');
            
            if (pendingStatus && completedStatus) {
                pendingStatus.classList.add('hidden');
                completedStatus.classList.remove('hidden');
            }

            // Mostrar mensaje de éxito
            mostrarMensaje('¡Video completado exitosamente! 🎉', 'success');
            
            console.log('Video marcado como completado');
        } else {
            console.error('Error al marcar video:', data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Detectar cuando el video termina
document.addEventListener('DOMContentLoaded', function() {
    const videoPlayer = document.getElementById('videoPlayer');
    
    if (videoPlayer) {
        videoPlayer.addEventListener('ended', function() {
            console.log('Video terminado, marcando como visto...');
            marcarVideoComoVisto();
        });

        // También detectar si el usuario llega muy cerca del final (95%)
        videoPlayer.addEventListener('timeupdate', function() {
            if (!videoMarcadoComoVisto) {
                const porcentaje = (this.currentTime / this.duration) * 100;
                if (porcentaje >= 95) {
                    console.log('Video casi terminado (95%), marcando como visto...');
                    marcarVideoComoVisto();
                }
            }
        });
    }
});
        // Función para mostrar mensajes
        function mostrarMensaje(mensaje, tipo = 'success') {
            const messageDiv = document.getElementById('mensaje');
            messageDiv.textContent = mensaje;
            messageDiv.className = `mb-4 p-4 rounded-lg ${tipo === 'success' ? 'bg-green-100 border border-green-400 text-green-700' : 'bg-red-100 border border-red-400 text-red-700'}`;
            messageDiv.classList.remove('hidden');
            
            // Ocultar mensaje después de 3 segundos
            setTimeout(() => {
                messageDiv.classList.add('hidden');
            }, 3000);
        }

        // Función para alternar formulario de respuesta
        function toggleRespuestaForm(comentarioId) {
            const form = document.getElementById(`respuestaForm-${comentarioId}`);
            form.classList.toggle('hidden');
            
            if (!form.classList.contains('hidden')) {
                form.querySelector('textarea').focus();
            }
        }

        // Manejo del formulario de comentarios
        document.getElementById('comentarioForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const button = document.getElementById('btnComentario');
            const spinner = document.getElementById('loading-spinner');
            const btnText = button.querySelector('.btn-text');
            const contenido = document.getElementById('contenido').value;
            
            // Mostrar loading
            button.disabled = true;
            spinner.classList.remove('hidden');
            btnText.textContent = 'Posting...';
            
            try {
                const response = await fetch(`{{ route('video.comentario', $video->id) }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ contenido: contenido })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Limpiar formulario
                    document.getElementById('contenido').value = '';
                    
                    // Ocultar mensaje "no hay comentarios"
                    const noCommentsDiv = document.getElementById('no-comments');
                    if (noCommentsDiv) {
                        noCommentsDiv.remove();
                    }
                    
                    // Agregar nuevo comentario al DOM
                    const comentario = data.comentario;
                    const fechaFormateada = new Date(comentario.fecha_creacion).toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric'
                    });
                    
                    const comentarioHtml = `
                        <article class="comentario-item p-6 text-base rounded-lg bg-[rgba(255,255,255,0.6)] dark:bg-[rgba(17,24,39,0.4)] mb-4" data-comentario-id="${comentario.id}">
                            <footer class="flex justify-between items-center mb-2">
                                <div class="flex items-center">
                                    <p class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white font-semibold">
                                        <img class="mr-2 w-6 h-6 rounded-full"
                                             src="${comentario.profile_photo_path ? '/storage/' + comentario.profile_photo_path : 'https://flowbite.com/docs/images/people/profile-picture-2.jpg'}"
                                             alt="${comentario.usuario_nombre}">
                                        ${comentario.usuario_nombre}
                                    </p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        <time>${fechaFormateada}</time>
                                    </p>
                                </div>
                            </footer>
                            <p class="text-gray-500 dark:text-gray-400">${comentario.contenido}</p>
                            
                            <div class="flex items-center mt-4 space-x-4">
                                <button type="button" onclick="toggleRespuestaForm(${comentario.id})"
                                        class="flex items-center text-sm text-gray-500 hover:underline dark:text-gray-400 font-medium">
                                    <svg class="mr-1.5 w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 18">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5h5M5 8h2m6-3h2m-5 3h6m2-7H2a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h3v5l5-5h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1Z"/>
                                    </svg>
                                    Reply
                                </button>
                            </div>

                            <form id="respuestaForm-${comentario.id}" class="respuesta-form hidden mt-4 ml-6">
                                <div class="flex items-start space-x-4">
                                    <div class="flex-1">
                                        <textarea name="contenido" rows="3" 
                                                  class="w-full px-3 py-2 text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                                  placeholder="Write a reply..." required></textarea>
                                    </div>
                                    <div class="flex flex-col space-y-2">
                                        <button type="submit" 
                                                class="px-4 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-200">
                                            <span class="btn-text">Reply</span>
                                        </button>
                                        <button type="button" onclick="toggleRespuestaForm(${comentario.id})"
                                                class="px-4 py-2 text-xs font-medium text-center text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:ring-gray-200">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </form>
                            
                            <div class="respuestas-container"></div>
                        </article>
                    `;
                    
                    document.getElementById('comentarios-container').insertAdjacentHTML('afterbegin', comentarioHtml);
                    
                    // Agregar event listener al nuevo formulario de respuesta
                    const nuevoForm = document.getElementById(`respuestaForm-${comentario.id}`);
                    nuevoForm.addEventListener('submit', handleRespuestaSubmit);
                    
                    mostrarMensaje('Comentario agregado exitosamente');
                } else {
                    mostrarMensaje(data.message, 'error');
                }
            } catch (error) {
                mostrarMensaje('Error al agregar comentario', 'error');
            } finally {
                // Restaurar botón
                button.disabled = false;
                spinner.classList.add('hidden');
                btnText.textContent = 'Post comment';
            }
        });

        // Función para manejar envío de respuestas
        async function handleRespuestaSubmit(e) {
            e.preventDefault();
            
            const form = e.target;
            const comentarioId = form.id.split('-')[1];
            const contenido = form.querySelector('textarea').value;
            const button = form.querySelector('button[type="submit"]');
            const btnText = button.querySelector('.btn-text');
            
            // Mostrar loading
            button.disabled = true;
            btnText.textContent = 'Replying...';
            
            try {
                const response = await fetch(`/comentario/${comentarioId}/respuesta`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ contenido: contenido })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Limpiar formulario y ocultarlo
                    form.querySelector('textarea').value = '';
                    form.classList.add('hidden');
                    
                    // Agregar nueva respuesta al DOM
                    const respuesta = data.respuesta;
                    const fechaFormateada = new Date(respuesta.fecha_creacion).toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric'
                    });
                    
                    const respuestaHtml = `
                        <article class="respuesta-item p-6 mb-3 mt-3 ml-6 lg:ml-12 text-base bg-[rgba(255,255,255,0.6)] dark:bg-[rgba(17,24,39,0.4)] rounded-lg">
                            <footer class="flex justify-between items-center mb-2">
                                <div class="flex items-center">
                                    <p class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white font-semibold">
                                        <img class="mr-2 w-6 h-6 rounded-full"
                                             src="${respuesta.profile_photo_path ? '/storage/' + respuesta.profile_photo_path : 'https://flowbite.com/docs/images/people/profile-picture-5.jpg'}"
                                             alt="${respuesta.usuario_nombre}">
                                        ${respuesta.usuario_nombre}
                                    </p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        <time>${fechaFormateada}</time>
                                    </p>
                                </div>
                            </footer>
                            <p class="text-gray-500 dark:text-gray-400">${respuesta.contenido}</p>
                        </article>
                    `;
                    
                    const comentarioArticle = document.querySelector(`[data-comentario-id="${comentarioId}"]`);
                    const respuestasContainer = comentarioArticle.querySelector('.respuestas-container');
                    respuestasContainer.insertAdjacentHTML('beforeend', respuestaHtml);
                    
                    mostrarMensaje('Respuesta agregada exitosamente');
                } else {
                    mostrarMensaje(data.message, 'error');
                }
            } catch (error) {
                mostrarMensaje('Error al agregar respuesta', 'error');
            } finally {
                // Restaurar botón
                button.disabled = false;
                btnText.textContent = 'Reply';
            }
        }

        // Agregar event listeners a todos los formularios de respuesta existentes
        document.addEventListener('DOMContentLoaded', function() {
            const respuestaForms = document.querySelectorAll('.respuesta-form');
            respuestaForms.forEach(form => {
                form.addEventListener('submit', handleRespuestaSubmit);
            });
        });

      
document.addEventListener('DOMContentLoaded', function() {
    const videoPlayer = document.getElementById('videoPlayer');
    
    // Detectar si algo está interfiriendo
    videoPlayer.addEventListener('seeking', function() {
        console.log('🔍 SEEKING iniciado - Tiempo objetivo:', this.currentTime);
    });
    
    videoPlayer.addEventListener('seeked', function() {
        console.log('✅ SEEKING completado - Tiempo actual:', this.currentTime);
    });
    
    // Detectar si algo cambia el currentTime
    let lastTime = 0;
    videoPlayer.addEventListener('timeupdate', function() {
        if (Math.abs(this.currentTime - lastTime) > 5) {
            console.log('⚠️ SALTO DETECTADO de', lastTime, 'a', this.currentTime);
        }
        lastTime = this.currentTime;
    });
});  
    </script>
</x-app-layout>