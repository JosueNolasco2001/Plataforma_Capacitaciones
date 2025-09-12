<x-app-layout>
        <h2 class="font-semibold text-xl text-white leading-tight mt-[5%]">
            <i class="fas fa-plus-circle text-blue-600 mr-3"></i>
            {{ __('Agregar Nuevo Curso') }}
        </h2>
  

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Mostrar mensajes de éxito o error -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Información básica del curso -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mb-6">
                <form id="courseForm" action="{{ route('store.course') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            <i class="fas fa-info-circle text-green-600 mr-2"></i>
                            Información Básica del Curso
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Título del curso -->
                            <div class="md:col-span-2">
                                <x-label for="titulo" class="!text-black" value="{{ __('Título del Curso') }}" />
                                <x-input id="titulo" class="block mt-1 w-full !text-black" type="text" name="titulo" :value="old('titulo')" required />
                                @error('titulo')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Imagen del curso -->
                            <div>
                                <x-label for="urlImg" class="!text-black" value="{{ __('Imagen del Curso') }}" />
                                <input id="urlImg" name="urlImg" type="file" accept="image/*" required
                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-l-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-gray-300 rounded-md"/>
                                @error('urlImg')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Estado del curso -->
                            <div>
                                <x-label for="estado" class="!text-black" value="{{ __('Estado del Curso') }}" />
                                <select id="estado" name="estado" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="0" {{ old('estado') == '0' ? 'selected' : '' }}>Borrador</option>
                                    <option value="1" {{ old('estado') == '1' ? 'selected' : '' }}>Publicado</option>
                                </select>
                                @error('estado')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Descripción -->
                            <div class="md:col-span-2">
                                <x-label for="descripcion" class="!text-black" value="{{ __('Descripción del Curso') }}" />
                                <textarea id="descripcion" name="descripcion" rows="4" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    placeholder="Describe qué aprenderán los estudiantes en este curso...">{{ old('descripcion') }} </textarea>
                                @error('descripcion')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Sección de Videos -->
                    <div class="border-t pt-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">
                                <i class="fas fa-video text-red-600 mr-2"></i>
                                Videos del Curso
                            </h3>
                            <button type="button" id="addVideoBtn" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors">
                                <i class="fas fa-plus mr-2"></i>
                                Agregar Video
                            </button>
                        </div>

                        <div id="videosContainer">
                            <!-- Los videos se agregarán dinámicamente aquí -->
                        </div>

                        <!-- Mensaje cuando no hay videos -->
                        <div id="noVideosMessage" class="text-center py-8 text-gray-500 border-2 border-dashed border-gray-300 rounded-lg">
                            <i class="fas fa-video text-4xl mb-4"></i>
                            <p>No hay videos agregados. Haz clic en "Agregar Video" para comenzar.</p>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="flex justify-between items-center mt-8 pt-6 border-t">
                        <a href="#" class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600 transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Cancelar
                        </a>
                        
                        <div class="space-x-3">
                            
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition-colors">
                                <i class="fas fa-save mr-2"></i>
                                Crear Curso
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

  <!-- Template para videos - REEMPLAZAR COMPLETAMENTE -->
<template id="videoTemplate">
    <div class="video-item bg-gray-50 border border-gray-200 rounded-lg p-4 mb-4" data-video-index="">
        <div class="flex justify-between items-start mb-4">
            <h4 class="text-md font-medium text-gray-900">Video #<span class="video-number"></span></h4>
            <button type="button" class="remove-video text-red-600 hover:text-red-800 p-1">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Título del video -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Título del Video *
                </label>
                <input type="text" name="" required
                    class="video-titulo w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    placeholder="Ej: Lección 1 - Introducción">
            </div>

            <!-- URL de YouTube -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    URL de YouTube *
                </label>
                <input type="url" name="" required
                    class="video-url w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    placeholder="https://www.youtube.com/watch?v=...">
                <p class="text-xs text-gray-500 mt-1">Pega la URL completa del video de YouTube</p>
            </div>

            <!-- Orden -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Orden
                </label>
                <input type="number" name="" min="1"
                    class="video-orden w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>

            <!-- Estado del video -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Estado del Video
                </label>
                <select name="" class="video-estado w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="0">Borrador</option>
                    <option value="1">Publicado</option>
                </select>
            </div>
        </div>
    </div>
</template>

    <script>
document.addEventListener('DOMContentLoaded', function() {
    const addVideoBtn = document.getElementById('addVideoBtn');
    const videosContainer = document.getElementById('videosContainer');
    const noVideosMessage = document.getElementById('noVideosMessage');
    const videoTemplate = document.getElementById('videoTemplate');
    let videoCount = 0;

    console.log('Script cargado'); // Para debugging

    // Agregar video
    addVideoBtn.addEventListener('click', function() {
        console.log('Botón clicked'); // Para debugging
        
        videoCount++;
        const videoElement = videoTemplate.content.cloneNode(true);
        
        // Actualizar número del video
        videoElement.querySelector('.video-number').textContent = videoCount;
        
        // Configurar los nombres correctos de los campos - ACTUALIZADO PARA YOUTUBE
        const index = videoCount - 1;
        videoElement.querySelector('.video-titulo').name = `videos[${index}][titulo]`;
        videoElement.querySelector('.video-url').name = `videos[${index}][url_youtube]`; // CAMBIO: era video-archivo
        videoElement.querySelector('.video-orden').name = `videos[${index}][orden]`;
        videoElement.querySelector('.video-estado').name = `videos[${index}][estado]`;
        
        // Configurar valor por defecto del orden
        videoElement.querySelector('.video-orden').value = videoCount;
        
        // Configurar data attribute para el index
        videoElement.querySelector('.video-item').setAttribute('data-video-index', index);
        
        // Agregar evento para eliminar video
        videoElement.querySelector('.remove-video').addEventListener('click', function() {
            this.closest('.video-item').remove();
            updateVideoNumbers();
            toggleNoVideosMessage();
        });
        
        videosContainer.appendChild(videoElement);
        toggleNoVideosMessage();
        
        console.log('Video agregado con índice:', index);
    });

    // Actualizar números de videos
    function updateVideoNumbers() {
        const videoItems = videosContainer.querySelectorAll('.video-item');
        videoItems.forEach((item, index) => {
            item.querySelector('.video-number').textContent = index + 1;
            item.querySelector('.video-orden').value = index + 1;
            
            // Actualizar los nombres de los campos - ACTUALIZADO PARA YOUTUBE
            item.querySelector('.video-titulo').name = `videos[${index}][titulo]`;
            item.querySelector('.video-url').name = `videos[${index}][url_youtube]`; // CAMBIO: era video-archivo
            item.querySelector('.video-orden').name = `videos[${index}][orden]`;
            item.querySelector('.video-estado').name = `videos[${index}][estado]`;
            
            item.setAttribute('data-video-index', index);
        });
        videoCount = videoItems.length;
        
        console.log('Videos renumerados. Total:', videoCount);
    }

    // Mostrar/ocultar mensaje de no videos
    function toggleNoVideosMessage() {
        const hasVideos = videosContainer.querySelectorAll('.video-item').length > 0;
        noVideosMessage.style.display = hasVideos ? 'none' : 'block';
    }

    // Función para validar URL de YouTube
    function isValidYouTubeUrl(url) {
        const youtubePatterns = [
            /^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/.+$/,
            /^(https?:\/\/)?(www\.)?youtube\.com\/watch\?v=.+$/,
            /^(https?:\/\/)?(www\.)?youtu\.be\/.+$/
        ];
        
        return youtubePatterns.some(pattern => pattern.test(url));
    }

    // Validación del formulario - ACTUALIZADO PARA YOUTUBE
    document.getElementById('courseForm').addEventListener('submit', function(e) {
        const videos = document.querySelectorAll('.video-item');
        
        // Validación estricta: Bloquear si no hay videos
        if (videos.length === 0) {
            e.preventDefault();
            noVideosMessage.innerHTML = `
                <i class="fas fa-exclamation-circle text-red-500 text-4xl mb-4"></i>
                <p class="text-red-600 font-bold">¡Error!</p>
                <p>Debes agregar al menos un video para crear el curso.</p>
            `;
            noVideosMessage.style.display = 'block';
            noVideosMessage.scrollIntoView({ behavior: 'smooth' });
            return;
        }
        
        // Validar que todos los videos tengan título y URL válida - ACTUALIZADO
        let hasError = false;
        let errorMessages = [];
        
        videos.forEach((video, index) => {
            const titulo = video.querySelector('.video-titulo').value.trim();
            const url = video.querySelector('.video-url').value.trim(); // CAMBIO: era video-archivo.files[0]
            
            // Restablecer estilo
            video.style.border = '';
            
            if (!titulo) {
                hasError = true;
                video.style.border = '2px solid red';
                errorMessages.push(`Video #${index + 1}: Falta el título`);
            }
            
            if (!url) {
                hasError = true;
                video.style.border = '2px solid red';
                errorMessages.push(`Video #${index + 1}: Falta la URL de YouTube`);
            } else if (!isValidYouTubeUrl(url)) {
                hasError = true;
                video.style.border = '2px solid red';
                errorMessages.push(`Video #${index + 1}: URL de YouTube no válida`);
            }
        });
        
        if (hasError) {
            e.preventDefault();
            alert('Errores encontrados:\n\n' + errorMessages.join('\n') + '\n\nCorrige los errores e intenta de nuevo.');
            return;
        }
        
        // Mostrar confirmación antes de enviar
        const totalVideos = videos.length;
        if (!confirm(`¿Confirmas crear el curso con ${totalVideos} video${totalVideos > 1 ? 's' : ''}?`)) {
            e.preventDefault();
            return;
        }
    });

    // Validación en tiempo real de URLs de YouTube
    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('video-url')) {
            const url = e.target.value.trim();
            const videoItem = e.target.closest('.video-item');
            
            if (url && !isValidYouTubeUrl(url)) {
                e.target.style.borderColor = '#ef4444'; // rojo
                // Mostrar mensaje de error si no existe
                if (!e.target.nextElementSibling || !e.target.nextElementSibling.classList.contains('url-error')) {
                    const errorMsg = document.createElement('p');
                    errorMsg.className = 'url-error text-xs text-red-500 mt-1';
                    errorMsg.textContent = 'URL de YouTube no válida. Ej: https://www.youtube.com/watch?v=...';
                    e.target.parentNode.insertBefore(errorMsg, e.target.nextSibling);
                }
            } else {
                e.target.style.borderColor = ''; // restablecer
                // Remover mensaje de error
                const errorMsg = e.target.parentNode.querySelector('.url-error');
                if (errorMsg) {
                    errorMsg.remove();
                }
            }
        }
    });
});
</script>
</x-app-layout>