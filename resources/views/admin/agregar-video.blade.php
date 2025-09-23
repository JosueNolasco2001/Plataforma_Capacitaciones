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

                    <!-- Sección de Exámenes -->
<div class="border-t pt-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-medium text-gray-900">
            <i class="fas fa-file-alt text-purple-600 mr-2"></i>
            Exámenes del Curso
        </h3>
        <button type="button" id="addExamBtn" class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 transition-colors">
            <i class="fas fa-plus mr-2"></i>
            Agregar Examen
        </button>
    </div>

    <div id="examsContainer">
        <!-- Los exámenes se agregarán dinámicamente aquí -->
    </div>

    <!-- Mensaje cuando no hay exámenes -->
    <div id="noExamsMessage" class="text-center py-8 text-gray-500 border-2 border-dashed border-gray-300 rounded-lg">
        <i class="fas fa-file-alt text-4xl mb-4"></i>
        <p>No hay exámenes agregados. Haz clic en "Agregar Examen" para comenzar.</p>
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

<!-- Template para exámenes -->
<template id="examTemplate">
    <div class="exam-item bg-purple-50 border border-purple-200 rounded-lg p-4 mb-6" data-exam-index="">
        <div class="flex justify-between items-start mb-4">
            <h4 class="text-md font-medium text-gray-900">Examen #<span class="exam-number"></span></h4>
            <button type="button" class="remove-exam text-red-600 hover:text-red-800 p-1">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <!-- Título del examen -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Título del Examen *
                </label>
                <input type="text" name="" required
                    class="exam-titulo w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    placeholder="Ej: Examen Final - Evaluación General">
            </div>

            <!-- Descripción -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Descripción
                </label>
                <textarea name="" rows="2"
                    class="exam-descripcion w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    placeholder="Describe el contenido del examen..."></textarea>
            </div>

            <!-- Duración -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Duración (minutos) *
                </label>
                <input type="number" name="" min="5" max="180" value="30" required
                    class="exam-duracion w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>

            <!-- Intentos permitidos -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Intentos Permitidos *
                </label>
                <input type="number" name="" min="1" max="10" value="1" required
                    class="exam-intentos w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>

            <!-- Porcentaje de aprobación -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    % Aprobación *
                </label>
                <input type="number" name="" min="50" max="100" value="70" required
                    class="exam-porcentaje w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>

            <!-- Estado del examen -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Estado del Examen
                </label>
                <select name="" class="exam-estado w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="0">Borrador</option>
                    <option value="1" selected>Publicado</option>
                </select>
            </div>

            <!-- Orden -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Orden
                </label>
                <input type="number" name="" min="1"
                    class="exam-orden w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>
        </div>

        <!-- Sección de Preguntas -->
        <div class="border-t pt-4">
            <div class="flex justify-between items-center mb-4">
                <h5 class="text-sm font-medium text-gray-900">
                    <i class="fas fa-question-circle text-green-600 mr-2"></i>
                    Preguntas del Examen
                </h5>
                <button type="button" class="add-question bg-green-600 text-white px-3 py-1 rounded-md hover:bg-green-700 transition-colors text-sm">
                    <i class="fas fa-plus mr-1"></i>
                    Agregar Pregunta
                </button>
            </div>

            <div class="questions-container space-y-4">
                <!-- Las preguntas se agregarán aquí -->
            </div>
        </div>
    </div>
</template>
<!-- Template para preguntas - SOLO VERDADERO/FALSO -->
<!-- Template para preguntas - SOLO VERDADERO/FALSO CORREGIDO -->
<template id="questionTemplate">
    <div class="question-item bg-white border border-gray-200 rounded-lg p-4" data-question-index="">
        <div class="flex justify-between items-start mb-3">
            <h6 class="text-sm font-medium text-gray-900">Pregunta #<span class="question-number"></span></h6>
            <button type="button" class="remove-question text-red-600 hover:text-red-800 p-1 text-sm">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="space-y-3">
            <!-- Texto de la pregunta -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Pregunta *
                </label>
                <textarea name="" rows="2" required
                    class="question-text w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    placeholder="Escribe la pregunta..."></textarea>
            </div>

            <!-- Tipo de pregunta FIJO en verdadero/falso -->
            <input type="hidden" name="" class="question-type" value="verdadero_falso">

            <!-- Puntos -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Puntos
                </label>
                <input type="number" name="" min="1" max="10" value="1"
                    class="question-points w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>

            <!-- Opciones de respuesta VERDADERO/FALSO - CORREGIDO -->
            <div class="options-container">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Respuesta Correcta *
                </label>
                <div class="options-list space-y-2">
                    <!-- Opciones predefinidas para verdadero/falso -->
                    <div class="option-item flex items-center space-x-2">
                        <input type="text" name="" value="Verdadero" readonly
                            class="option-text flex-1 border-gray-300 rounded-md shadow-sm bg-gray-100 text-sm">
                        <input type="radio" name="" class="option-correct" value="verdadero">
                        <label class="text-sm text-gray-700">Correcta</label>
                    </div>
                    <div class="option-item flex items-center space-x-2">
                        <input type="text" name="" value="Falso" readonly
                            class="option-text flex-1 border-gray-300 rounded-md shadow-sm bg-gray-100 text-sm">
                        <input type="radio" name="" class="option-correct" value="falso">
                        <label class="text-sm text-gray-700">Correcta</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<!-- Template para opciones -->
<template id="optionTemplate">
    <div class="option-item flex items-center space-x-2">
        <input type="text" name="" placeholder="Opción de respuesta" required
            class="option-text flex-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
        <input type="radio" name="" class="option-correct">
        <label class="text-sm text-gray-700">Correcta</label>
        <button type="button" class="remove-option text-red-600 hover:text-red-800 p-1">
            <i class="fas fa-times"></i>
        </button>
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
 // Validación adicional para el formulario
document.getElementById('courseForm').addEventListener('submit', function(e) {
    // Validación de exámenes
    const exams = document.querySelectorAll('.exam-item');
    
    exams.forEach((exam, index) => {
        const titulo = exam.querySelector('.exam-titulo').value.trim();
        const questions = exam.querySelectorAll('.question-item');
        
        if (!titulo) {
            e.preventDefault();
            exam.style.border = '2px solid red';
            alert(`Examen #${index + 1}: Falta el título`);
            return;
        }
        
        if (questions.length === 0) {
            e.preventDefault();
            exam.style.border = '2px solid red';
            alert(`Examen #${index + 1}: Debe tener al menos una pregunta`);
            return;
        }
        
        // Validar preguntas VERDADERO/FALSO
        questions.forEach((question, qIndex) => {
            const preguntaText = question.querySelector('.question-text').value.trim();
            const options = question.querySelectorAll('.option-item');
            const selectedOption = question.querySelector('.option-correct:checked');
            
            if (!preguntaText) {
                e.preventDefault();
                question.style.border = '2px solid red';
                alert(`Examen #${index + 1}, Pregunta #${qIndex + 1}: Falta el texto de la pregunta`);
                return;
            }
            
            if (!selectedOption) {
                e.preventDefault();
                question.style.border = '2px solid red';
                alert(`Examen #${index + 1}, Pregunta #${qIndex + 1}: Debes seleccionar la respuesta correcta (Verdadero o Falso)`);
                return;
            }
        });
    });
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


// Variables para exámenes
const addExamBtn = document.getElementById('addExamBtn');
const examsContainer = document.getElementById('examsContainer');
const noExamsMessage = document.getElementById('noExamsMessage');
const examTemplate = document.getElementById('examTemplate');
const questionTemplate = document.getElementById('questionTemplate');
const optionTemplate = document.getElementById('optionTemplate');
let examCount = 0;

// Agregar examen
addExamBtn.addEventListener('click', function() {
    examCount++;
    const examElement = examTemplate.content.cloneNode(true);
    
    // Configurar examen
    const examIndex = examCount - 1;
    configureExamElement(examElement, examIndex);
    
    examsContainer.appendChild(examElement);
    toggleNoExamsMessage();
});

function configureExamElement(examElement, examIndex) {
    // Configurar número y nombres
    examElement.querySelector('.exam-number').textContent = examCount;
    examElement.querySelector('.exam-titulo').name = `examenes[${examIndex}][titulo]`;
    examElement.querySelector('.exam-descripcion').name = `examenes[${examIndex}][descripcion]`;
    examElement.querySelector('.exam-duracion').name = `examenes[${examIndex}][duracion_minutos]`;
    examElement.querySelector('.exam-intentos').name = `examenes[${examIndex}][intentos_permitidos]`;
    examElement.querySelector('.exam-porcentaje').name = `examenes[${examIndex}][porcentaje_aprobacion]`;
    examElement.querySelector('.exam-estado').name = `examenes[${examIndex}][estado]`;
    examElement.querySelector('.exam-orden').name = `examenes[${examIndex}][orden]`;
    examElement.querySelector('.exam-orden').value = examCount;
    
    examElement.querySelector('.exam-item').setAttribute('data-exam-index', examIndex);
    
    // Evento para eliminar examen
    examElement.querySelector('.remove-exam').addEventListener('click', function() {
        this.closest('.exam-item').remove();
        updateExamNumbers();
        toggleNoExamsMessage();
    });
    
    // Evento para agregar pregunta
    examElement.querySelector('.add-question').addEventListener('click', function() {
        addQuestionToExam(this.closest('.exam-item'));
    });
    
    // Manejar cambio de tipo de pregunta
    examElement.querySelector('.question-type')?.addEventListener('change', function() {
        toggleOptionsContainer(this);
    });
}

function addQuestionToExam(examElement) {
    const questionsContainer = examElement.querySelector('.questions-container');
    const questionElement = questionTemplate.content.cloneNode(true);
    const examIndex = examElement.getAttribute('data-exam-index');
    const questionCount = questionsContainer.querySelectorAll('.question-item').length;
    
    configureQuestionElement(questionElement, examIndex, questionCount);
    questionsContainer.appendChild(questionElement);
}

function configureQuestionElement(questionElement, examIndex, questionIndex) {
    questionElement.querySelector('.question-number').textContent = questionIndex + 1;
    
    // Configurar nombres - ESTRUCTURA CORREGIDA
    questionElement.querySelector('.question-text').name = `examenes[${examIndex}][preguntas][${questionIndex}][pregunta]`;
    questionElement.querySelector('.question-type').name = `examenes[${examIndex}][preguntas][${questionIndex}][tipo]`;
    questionElement.querySelector('.question-points').name = `examenes[${examIndex}][preguntas][${questionIndex}][puntos]`;
    
    // Configurar opciones de verdadero/falso
    const options = questionElement.querySelectorAll('.option-item');
    options.forEach((option, optionIndex) => {
        const optionText = option.querySelector('.option-text');
        const optionCorrect = option.querySelector('.option-correct');
        
        // Nombres corregidos para guardar correctamente
        optionText.name = `examenes[${examIndex}][preguntas][${questionIndex}][opciones][${optionIndex}][opcion]`;
        optionCorrect.name = `examenes[${examIndex}][preguntas][${questionIndex}][opcion_correcta]`; // Mismo nombre para ambos radios
        
        // Valor único para cada opción
        optionCorrect.value = optionIndex === 0 ? 'verdadero' : 'falso';
    });
    
    questionElement.querySelector('.question-item').setAttribute('data-question-index', questionIndex);
    
    // Evento para eliminar pregunta
    questionElement.querySelector('.remove-question').addEventListener('click', function() {
        this.closest('.question-item').remove();
        updateQuestionNumbers(this.closest('.exam-item'));
    });
    
    // Asegurar que solo una opción pueda ser seleccionada
    const radioButtons = questionElement.querySelectorAll('.option-correct');
    radioButtons.forEach(radio => {
        radio.addEventListener('change', function() {
            radioButtons.forEach(r => {
                if (r !== this) r.checked = false;
            });
        });
    });
}

// Eliminar función toggleOptionsContainer ya que no es necesaria
function updateOptionNames(questionElement, examIndex, questionIndex) {
    const options = questionElement.querySelectorAll('.option-item');
    
    options.forEach((option, oIndex) => {
        const optionText = option.querySelector('.option-text');
        const optionCorrect = option.querySelector('.option-correct');
        
        optionText.name = `examenes[${examIndex}][preguntas][${questionIndex}][opciones][${oIndex}][opcion]`;
        optionCorrect.name = `examenes[${examIndex}][preguntas][${questionIndex}][opcion_correcta]`;
        optionCorrect.value = oIndex === 0 ? 'verdadero' : 'falso';
    });
}

function addOptionToQuestion(questionElement) {
    const optionsContainer = questionElement.querySelector('.options-list');
    const optionElement = optionTemplate.content.cloneNode(true);
    const examIndex = questionElement.closest('.exam-item').getAttribute('data-exam-index');
    const questionIndex = questionElement.getAttribute('data-question-index');
    const optionCount = optionsContainer.querySelectorAll('.option-item').length;
    
    configureOptionElement(optionElement, examIndex, questionIndex, optionCount);
    optionsContainer.appendChild(optionElement);
}

function configureOptionElement(optionElement, examIndex, questionIndex, optionIndex) {
    const optionText = optionElement.querySelector('.option-text');
    const optionCorrect = optionElement.querySelector('.option-correct');
    
    optionText.name = `examenes[${examIndex}][preguntas][${questionIndex}][opciones][${optionIndex}][opcion]`;
    optionCorrect.name = `examenes[${examIndex}][preguntas][${questionIndex}][opciones_correctas]`;
    optionCorrect.value = optionIndex;
    
    // Evento para eliminar opción
    optionElement.querySelector('.remove-option').addEventListener('click', function() {
        this.closest('.option-item').remove();
    });
}



function updateExamNumbers() {
    const examItems = examsContainer.querySelectorAll('.exam-item');
    examItems.forEach((item, index) => {
        item.querySelector('.exam-number').textContent = index + 1;
        item.querySelector('.exam-orden').value = index + 1;
        
        // Actualizar nombres
        const baseName = `examenes[${index}]`;
        item.querySelector('.exam-titulo').name = `${baseName}[titulo]`;
        item.querySelector('.exam-descripcion').name = `${baseName}[descripcion]`;
        item.querySelector('.exam-duracion').name = `${baseName}[duracion_minutos]`;
        item.querySelector('.exam-intentos').name = `${baseName}[intentos_permitidos]`;
        item.querySelector('.exam-porcentaje').name = `${baseName}[porcentaje_aprobacion]`;
        item.querySelector('.exam-estado').name = `${baseName}[estado]`;
        item.querySelector('.exam-orden').name = `${baseName}[orden]`;
        
        item.setAttribute('data-exam-index', index);
        
        // Actualizar números de preguntas
        updateQuestionNumbers(item);
    });
    examCount = examItems.length;
}

function updateQuestionNumbers(examElement) {
    const questions = examElement.querySelectorAll('.question-item');
    const examIndex = examElement.getAttribute('data-exam-index');
    
    questions.forEach((question, qIndex) => {
        question.querySelector('.question-number').textContent = qIndex + 1;
        
        const baseName = `examenes[${examIndex}][preguntas][${qIndex}]`;
        question.querySelector('.question-text').name = `${baseName}[pregunta]`;
        question.querySelector('.question-type').name = `${baseName}[tipo]`;
        question.querySelector('.question-points').name = `${baseName}[puntos]`;
        
        question.setAttribute('data-question-index', qIndex);
        
        // Actualizar opciones
        updateOptionNames(question, examIndex, qIndex);
    });
}



function toggleNoExamsMessage() {
    const hasExams = examsContainer.querySelectorAll('.exam-item').length > 0;
    noExamsMessage.style.display = hasExams ? 'none' : 'block';
}

// Validación adicional para el formulario
document.getElementById('courseForm').addEventListener('submit', function(e) {
    // Validación de exámenes
    const exams = document.querySelectorAll('.exam-item');
    
    exams.forEach((exam, index) => {
        const titulo = exam.querySelector('.exam-titulo').value.trim();
        const questions = exam.querySelectorAll('.question-item');
        
        if (!titulo) {
            e.preventDefault();
            exam.style.border = '2px solid red';
            alert(`Examen #${index + 1}: Falta el título`);
            return;
        }
        
        if (questions.length === 0) {
            e.preventDefault();
            exam.style.border = '2px solid red';
            alert(`Examen #${index + 1}: Debe tener al menos una pregunta`);
            return;
        }
        
        // Validar preguntas
        questions.forEach((question, qIndex) => {
            const preguntaText = question.querySelector('.question-text').value.trim();
            const tipo = question.querySelector('.question-type').value;
            const options = question.querySelectorAll('.option-item');
            
            if (!preguntaText) {
                e.preventDefault();
                question.style.border = '2px solid red';
                alert(`Examen #${index + 1}, Pregunta #${qIndex + 1}: Falta el texto de la pregunta`);
                return;
            }
            
            if (tipo !== 'texto' && options.length < 2) {
                e.preventDefault();
                question.style.border = '2px solid red';
                alert(`Examen #${index + 1}, Pregunta #${qIndex + 1}: Debe tener al menos 2 opciones`);
                return;
            }
            
            if (tipo !== 'texto') {
                const hasCorrect = Array.from(options).some(opt => opt.querySelector('.option-correct').checked);
                if (!hasCorrect) {
                    e.preventDefault();
                    question.style.border = '2px solid red';
                    alert(`Examen #${index + 1}, Pregunta #${qIndex + 1}: Debe tener una opción correcta`);
                    return;
                }
            }
        });
    });
});
</script>
</x-app-layout>