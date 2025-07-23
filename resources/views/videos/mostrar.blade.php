<x-app-layout>
    <div class="max-w-screen-xl mx-auto p-5 sm:p-10 md:p-16 motion-preset-slide-right">

        <!-- Header del curso -->
        <div
            class="mt-[10%] sm:mt-0 curso-header text-center py-8 text-white px-4 rounded-lg shadow-lg 
        animate-gradient-intense bg-[length:400%_400%] 
        bg-gradient-to-r from-blue-500 via-purple-500 to-pink-600">
            <h1 class="text-4xl md:text-5xl font-bold mb-2 animate-title-pop">
                {{ $video->curso_titulo }}
            </h1>
        </div>

        <!-- Título del video -->
        <center>
            <p class="mt-8 text-xl md:text-2xl font-light opacity-90 animate-subtitle-slide text-white">
                VIDEO {{ $video->orden }}: <span
                    class="font-semibold text-yellow-300 drop-shadow-sm">{{ strtoupper($video->titulo) }}</span>
            </p>
        </center>

        <!-- Reproductor de video -->
        <center>
            <video id="videoPlayer" class="rounded-lg" controls>
                <source  src="{{ asset('storage/videos/' . $video->url) }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </center>

        <!-- Indicador de estado del video -->
        <div id="video-status" class="text-center mt-4 text-white">
            @if ($yaVisto)
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                    Video Completado
                </span>
            @else
                <span id="pending-status"
                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                    Pendiente de Completar
                </span>
                <span id="completed-status"
                    class="hidden inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                    ¡Video Completado! 🎉
                </span>
            @endif
        </div>

        <!-- Formulario de comentarios -->
        @if (auth()->user()->email_verified_at)
            <!-- Usuario verificado - mostrar formulario normal -->
            <form id="comentarioForm" class="mt-10">
                @csrf
                <div class="w-full mb-4 rounded-lg dark:bg-[rgba(17,24,39,0.4)]">
                    <div class="px-4 py-2 dark:bg-[rgba(17,24,39,0.4)]">
                        <label for="contenido" class="sr-only">Your comment</label>
                        <textarea id="contenido" name="contenido" rows="4"
                            class="w-full px-0 text-sm text-gray-900 bg-white border-0 dark:bg-[rgba(17,24,39,0.4)] focus:ring-0 dark:text-white dark:placeholder-gray-400"
                            placeholder="Escribe un comentario" required></textarea>
                    </div>
                    <div
                        class="flex items-center justify-between px-3 py-2 border-t dark:border-gray-600 border-gray-200">
                        <button type="submit" id="btnComentario"
                            class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-900 hover:bg-blue-800">
                            <span class="btn-text">Comentar</span>
                            <svg class="animate-spin ml-2 h-4 w-4 text-white hidden" id="loading-spinner" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
        @else
            <!-- Usuario NO verificado - mostrar formulario bloqueado -->
            <div class="mt-10">
                <div class="w-full mb-4 rounded-lg dark:bg-[rgba(17,24,39,0.4)] opacity-60">
                    <div class="px-4 py-2 dark:bg-[rgba(17,24,39,0.4)]">
                        <label for="contenido-blocked" class="sr-only">Your comment</label>
                        <textarea id="contenido-blocked" rows="4" disabled
                            class="w-full px-0 text-sm text-gray-900 bg-white border-0 dark:bg-[rgba(17,24,39,0.4)] focus:ring-0 dark:text-white dark:placeholder-gray-400 cursor-not-allowed"
                            placeholder="Verifica tu email para poder comentar..."></textarea>
                    </div>
                    <div
                        class="flex items-center justify-between px-3 py-2 border-t dark:border-gray-600 border-gray-200">
                        <button type="button" id="btnComentarioBlocked" onclick="showVerificationModal()"
                            class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-gray-500 rounded-lg cursor-not-allowed">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m0 0v2m0-2h2m-2 0H8m4-10V9m0 0V7m0 2h2m-2 0H8" />
                            </svg>
                            Verificar email presionando aqui para comentar
                        </button>
                    </div>
                </div>
                <div id="verificationMessage"
                    class="hidden mt-4 bg-green-50 border-l-4 border-green-400 p-4 mb-4 rounded">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">
                                <strong>¡Correo enviado exitosamente!</strong> Revisa tu bandeja de entrada y haz clic
                                en el enlace de verificación.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Mensaje informativo -->
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4 rounded">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                <strong>Cuenta no verificada:</strong> Necesitas verificar tu email antes de poder
                                participar en comentarios.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Mensaje de estado -->
        <div id="mensaje" class="hidden mb-4 p-4 rounded-lg"></div>

        <p class="ms-auto text-xs text-gray-500 dark:text-gray-400">
            Recuerda que las contribuciones a este tema deben seguir nuestras
            <a href="#" class="text-blue-600 dark:text-blue-500 hover:underline">Normas de la Comunidad</a>.
        </p>

        <!-- Contenedor de comentarios -->
        <div id="comentarios-container">
            @forelse($comentarios as $comentario)
                <article
                    class="comentario-item p-6 text-base rounded-lg bg-[rgba(255,255,255,0.6)] dark:bg-[rgba(17,24,39,0.4)] mb-4"
                    data-comentario-id="{{ $comentario->id }}">
                    <footer class="flex justify-between items-center mb-2">
                        <div class="flex items-center">
                            <p
                                class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white font-semibold">
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

                    <!-- Botón para responder (solo si está verificado) -->
                    @if (auth()->user()->email_verified_at)
                        <div class="flex items-center mt-4 space-x-4">
                            <button type="button" onclick="toggleRespuestaForm({{ $comentario->id }})"
                                class="flex items-center text-sm text-gray-500 hover:underline dark:text-gray-400 font-medium">
                                <svg class="mr-1.5 w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 20 18">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M5 5h5M5 8h2m6-3h2m-5 3h6m2-7H2a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h3v5l5-5h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1Z" />
                                </svg>
                                Responder
                            </button>
                        </div>

                        <!-- Formulario de respuesta -->
                        <form id="respuestaForm-{{ $comentario->id }}" class="respuesta-form hidden mt-4 ml-6">
                            @csrf
                            <div class="flex items-start space-x-4">
                                <div class="flex-1">
                                    <textarea name="contenido" rows="3"
                                        class="w-full px-3 py-2 text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Escribe tu respuesta..." required></textarea>
                                </div>
                                <div class="flex flex-col space-y-2">
                                    <button type="submit"
                                        class="px-4 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-200">
                                        <span class="btn-text">Responder</span>
                                    </button>
                                    <button type="button" onclick="toggleRespuestaForm({{ $comentario->id }})"
                                        class="px-4 py-2 text-xs font-medium text-center text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:ring-gray-200">
                                        Cancelar
                                    </button>
                                </div>
                            </div>
                        </form>
                    @else
                        <!-- Usuario no verificado - botón de respuesta bloqueado -->
                        <div class="flex items-center mt-4 space-x-4">
                            <button type="button" onclick="showVerificationModal()"
                                class="flex items-center text-sm text-gray-400 cursor-not-allowed font-medium">
                                <svg class="mr-1.5 w-3.5 h-3.5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m0 0v2m0-2h2m-2 0H8" />
                                </svg>
                                Verificar email para responder
                            </button>
                        </div>
                    @endif

                    <!-- Respuestas existentes -->
                    <div class="respuestas-container">
                        @if (isset($comentario->respuestas) && count($comentario->respuestas) > 0)
                            @foreach ($comentario->respuestas as $respuesta)
                                <article
                                    class="respuesta-item p-6 mb-3 mt-3 ml-6 lg:ml-12 text-base bg-[rgba(255,255,255,0.6)] dark:bg-[rgba(17,24,39,0.4)] rounded-lg">
                                    <footer class="flex justify-between items-center mb-2">
                                        <div class="flex items-center">
                                            <p
                                                class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white font-semibold">
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

    <!-- Modal de verificación de email -->
    <div id="verificationModal"
        class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        📧 Verificar Email
                    </h3>
                    <button type="button" onclick="hideVerificationModal()"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <div class="text-center">
                        <div
                            class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 mb-4">
                            <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.232 19c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                        </div>
                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                            Para participar en comentarios necesitas verificar tu dirección de email.
                        </h3>
                        <p class="mb-5 text-sm text-gray-600 dark:text-gray-300">
                            Te hemos enviado un enlace de verificación a: <br>
                            <strong class="text-blue-600">{{ auth()->user()->email }}</strong>
                        </p>
                        <div class="flex justify-center gap-3">
                            <!-- En tu blade template (HTML) -->
                            <form id="verificationForm" method="POST"
                                action="{{ route('custom.verification.send') }}" style="display: inline;">
                                @php
                                    $key = 'email-verification:' . auth()->id();
                                    $tooMany = \Illuminate\Support\Facades\RateLimiter::tooManyAttempts($key, 1);
                                    $retryAfter = $tooMany
                                        ? \Illuminate\Support\Facades\RateLimiter::availableIn($key)
                                        : 0;
                                @endphp
                                @csrf
                                <button type="submit" id="verificationButton"
                                    @if ($tooMany) disabled @endif
                                    class="text-white {{ $tooMany ? 'bg-gray-400 cursor-not-allowed' : 'bg-blue-600 hover:bg-blue-800' }} focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                    <span id="buttonText">
                                        @if ($tooMany)
                                            ⏳ Espera {{ $retryAfter }}s para reenviar
                                        @else
                                            📧 Enviar Correo de Verificación
                                        @endif
                                    </span>
                                    <svg id="buttonSpinner" class="animate-spin ml-2 h-4 w-4 text-white hidden"
                                        fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                </button>
                            </form>

                            <!-- Mensaje de confirmación (añade esto donde quieras que aparezca) -->
                            <div id="verificationMessage"
                                class="hidden mt-2 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
                            </div>
                            <button type="button" onclick="hideVerificationModal()"
                                class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                Cerrar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Variables globales
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const isVerified = {{ auth()->user()->email_verified_at ? 'true' : 'false' }};
        let videoMarcadoComoVisto = {{ $yaVisto ? 'true' : 'false' }};

        // Funciones del modal
        function showVerificationModal() {
            document.getElementById('verificationModal').classList.remove('hidden');
            document.getElementById('verificationModal').classList.add('flex');
        }

        function hideVerificationModal() {
            document.getElementById('verificationModal').classList.add('hidden');
            document.getElementById('verificationModal').classList.remove('flex');
        }

        // Cerrar modal con ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                hideVerificationModal();
            }
        });

        // Cerrar modal clicando fuera
        document.getElementById('verificationModal').addEventListener('click', function(e) {
            if (e.target === this) {
                hideVerificationModal();
            }
        });

        // Función para marcar video como visto
        function marcarVideoComoVisto() {
            if (videoMarcadoComoVisto) return;

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
                        const pendingStatus = document.getElementById('pending-status');
                        const completedStatus = document.getElementById('completed-status');

                        if (pendingStatus && completedStatus) {
                            pendingStatus.classList.add('hidden');
                            completedStatus.classList.remove('hidden');
                        }

                        mostrarMensaje('¡Video completado exitosamente! 🎉', 'success');
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        // Función para mostrar mensajes
        function mostrarMensaje(mensaje, tipo = 'success') {
            const messageDiv = document.getElementById('mensaje');
            messageDiv.textContent = mensaje;
            messageDiv.className =
                `mb-4 p-4 rounded-lg ${tipo === 'success' ? 'bg-green-100 border border-green-400 text-green-700' : 'bg-red-100 border border-red-400 text-red-700'}`;
            messageDiv.classList.remove('hidden');

            setTimeout(() => {
                messageDiv.classList.add('hidden');
            }, 3000);
        }

        // Función para alternar formulario de respuesta
        function toggleRespuestaForm(comentarioId) {
            if (!isVerified) {
                showVerificationModal();
                return;
            }

            const form = document.getElementById(`respuestaForm-${comentarioId}`);
            form.classList.toggle('hidden');

            if (!form.classList.contains('hidden')) {
                form.querySelector('textarea').focus();
            }
        }

        // Event listeners del video
        document.addEventListener('DOMContentLoaded', function() {
            const videoPlayer = document.getElementById('videoPlayer');

            if (videoPlayer) {
                videoPlayer.addEventListener('ended', function() {
                    marcarVideoComoVisto();
                });

                videoPlayer.addEventListener('timeupdate', function() {
                    if (!videoMarcadoComoVisto) {
                        const porcentaje = (this.currentTime / this.duration) * 100;
                        if (porcentaje >= 95) {
                            marcarVideoComoVisto();
                        }
                    }
                });
            }
        });

        // Solo agregar event listeners si el usuario está verificado
        if (isVerified) {
            // Manejo del formulario de comentarios
            document.getElementById('comentarioForm').addEventListener('submit', async function(e) {
                e.preventDefault();

                const button = document.getElementById('btnComentario');
                const spinner = document.getElementById('loading-spinner');
                const btnText = button.querySelector('.btn-text');
                const contenido = document.getElementById('contenido').value;

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
                        body: JSON.stringify({
                            contenido: contenido
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        document.getElementById('contenido').value = '';
                        const noCommentsDiv = document.getElementById('no-comments');
                        if (noCommentsDiv) {
                            noCommentsDiv.remove();
                        }

                        // Agregar nuevo comentario (código anterior)

                        // Agregar nuevo comentario al DOM
                        const comentario = data.comentario;
                        const fechaFormateada = new Date(comentario.fecha_creacion).toLocaleDateString(
                            'en-US', {
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

                        document.getElementById('comentarios-container').insertAdjacentHTML('afterbegin',
                            comentarioHtml);

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
                    button.disabled = false;
                    spinner.classList.add('hidden');
                    btnText.textContent = 'Post comment';
                }
            });

            // Event listeners para formularios de respuesta
            const respuestaForms = document.querySelectorAll('.respuesta-form');
            respuestaForms.forEach(form => {
                form.addEventListener('submit', handleRespuestaSubmit);
            });
        }

        // Función para manejar respuestas
        async function handleRespuestaSubmit(e) {
            if (!isVerified) {
                e.preventDefault();
                showVerificationModal();
                return;
            }

            e.preventDefault();

            const form = e.target;
            const comentarioId = form.id.split('-')[1];
            const contenido = form.querySelector('textarea').value;
            const button = form.querySelector('button[type="submit"]');
            const btnText = button.querySelector('.btn-text');

            button.disabled = true;
            btnText.textContent = 'Replying...';

            try {
                const baseUrl = "{{ route('comentario.respuesta', ':id') }}";
                const url = baseUrl.replace(':id', comentarioId);

                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        contenido: contenido
                    })
                });

                const data = await response.json();

                if (data.success) {
                    form.querySelector('textarea').value = '';
                    form.classList.add('hidden');

                    // Agregar nueva respuesta (código anterior)
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
                button.disabled = false;
                btnText.textContent = 'Reply';
            }
        }

        // JavaScript actualizado
        document.addEventListener('DOMContentLoaded', function() {
            const verificationForm = document.getElementById('verificationForm');
            const verificationButton = document.getElementById('verificationButton');
            const buttonText = document.getElementById('buttonText');
            const buttonSpinner = document.getElementById('buttonSpinner');
            const verificationMessage = document.getElementById('verificationMessage');

            if (verificationForm) {
                // 1. Manejar el contador de espera si está activo
                @if ($tooMany)
                    let secondsLeft = {{ $retryAfter }};

                    const updateCountdown = () => {
                        if (secondsLeft > 0) {
                            buttonText.textContent = `⏳ Espera ${secondsLeft}s para reenviar`;
                            secondsLeft--;
                            setTimeout(updateCountdown, 1000);
                        } else {
                            buttonText.textContent = '📧 Enviar Correo de Verificación';
                            verificationButton.disabled = false;
                            verificationButton.classList.remove('bg-gray-400', 'cursor-not-allowed');
                            verificationButton.classList.add('bg-blue-600', 'hover:bg-blue-800');
                        }
                    };

                    updateCountdown();
                @endif

                // 2. Manejar el envío del formulario con AJAX
                verificationForm.addEventListener('submit', async function(e) {
                    e.preventDefault();

                    if (verificationButton.disabled) return;

                    // Mostrar estado de "enviando"
                    verificationButton.disabled = true;
                    verificationButton.classList.remove('bg-blue-600', 'hover:bg-blue-800');
                    verificationButton.classList.add('bg-blue-400');
                    buttonSpinner.classList.remove('hidden');
                    buttonText.textContent = 'Enviando...';

                    try {
                        const response = await fetch(verificationForm.action, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                _token: '{{ csrf_token() }}'
                            })
                        });

                        const data = await response.json();

                        if (data.success) {
                            // Mostrar mensaje de éxito
                            verificationMessage.textContent =
                                '✅ Correo de verificación enviado. Por favor revisa tu bandeja de entrada.';
                            verificationMessage.classList.remove('hidden');


                            setTimeout(() => {
                                hideVerificationModal()

                            }, 1);
                            // Ocultar mensaje después de 5 segundos
                            setTimeout(() => {
                                verificationMessage.classList.add('hidden');

                            }, 5000);


                            // Activar rate limiting en el frontend
                            verificationButton.disabled = true;
                            verificationButton.classList.remove('bg-blue-400');
                            verificationButton.classList.add('bg-gray-400', 'cursor-not-allowed');

                            let secondsLeft = data.retry_after || 60;
                            buttonText.textContent = `⏳ Espera ${secondsLeft}s para reenviar`;

                            const updateCountdown = () => {
                                if (secondsLeft > 0) {
                                    buttonText.textContent =
                                        `⏳ Espera ${secondsLeft}s para reenviar`;
                                    secondsLeft--;
                                    setTimeout(updateCountdown, 1000);
                                } else {
                                    buttonText.textContent = '📧 Enviar Correo de Verificación';
                                    verificationButton.disabled = false;
                                    verificationButton.classList.remove('bg-gray-400',
                                        'cursor-not-allowed');
                                    verificationButton.classList.add('bg-blue-600',
                                        'hover:bg-blue-800');
                                }
                            };

                            updateCountdown();
                        } else {
                            setTimeout(() => {
                                hideVerificationModal()

                            }, 1000);
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                            throw new Error(data.message || 'Error al enviar el correo');
                        }
                    } catch (error) {
                        verificationMessage.textContent = '⚠️ ' + error.message;
                        verificationMessage.classList.remove('hidden', 'bg-green-100',
                            'border-green-400', 'text-green-700');
                        verificationMessage.classList.add('bg-red-100', 'border-red-400',
                            'text-red-700');

                        // Restaurar botón
                        verificationButton.disabled = false;
                        verificationButton.classList.remove('bg-blue-400');
                        verificationButton.classList.add('bg-blue-600', 'hover:bg-blue-800');
                        buttonText.textContent = '📧 Enviar Correo de Verificación';
                    } finally {
                        buttonSpinner.classList.add('hidden');
                    }
                });
            }
        });

        // Ejecutar cuando el DOM esté listo
        document.addEventListener('DOMContentLoaded', updateVerificationButton);
    </script>
</x-app-layout>
