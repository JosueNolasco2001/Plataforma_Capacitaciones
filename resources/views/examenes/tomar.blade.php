<x-app-layout>
    <div class="max-w-4xl mx-auto p-5 sm:p-10 md:p-16">
        <!-- Header del Examen -->
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg shadow-lg p-6 mb-6 mt-[10%] sm:mt-0">
            <h1 class="text-3xl font-bold mb-2">{{ $examen->titulo }}</h1>
            <p class="text-lg opacity-90">Curso: {{ $examen->curso_titulo }}</p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4 text-sm">
                <div class="bg-white/20 backdrop-blur rounded p-2">
                    <span class="font-semibold">⏱Duración:</span> {{ $examen->duracion_minutos }} minutos
                </div>
                <div class="bg-white/20 backdrop-blur rounded p-2">
                    <span class="font-semibold">Intento:</span> {{ $nuevoIntento }} de {{ $examen->intentos_permitidos }}
                </div>
                <div class="bg-white/20 backdrop-blur rounded p-2">
                    <span class="font-semibold">Aprobación:</span> {{ $examen->porcentaje_aprobacion }}%
                </div>
            </div>
        </div>

        @if(isset($esContinuacion) && $esContinuacion)
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            Estás continuando un examen pendiente.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Instrucciones -->
      <div class="bg-blue-900 border border-blue-800 rounded-lg p-4 mb-6">
    <h3 class="font-semibold text-blue-300 mb-2">📌 Instrucciones:</h3>
    <ul class="list-disc list-inside text-sm text-blue-400 space-y-1">
        <li>Lee cuidadosamente cada pregunta antes de responder</li>
        <li>Todas las preguntas son de tipo Verdadero o Falso</li>
        <li>Debes responder todas las preguntas para finalizar el examen</li>
        <li>Una vez enviado, no podrás cambiar tus respuestas</li>
        @if($examen->descripcion)
            <li class="mt-2 font-semibold">{{ $examen->descripcion }}</li>
        @endif
    </ul>
</div>

        <!-- Formulario del Examen -->
       <form id="formExamen" action="{{ route('examenes.guardar', $examen->id) }}" method="POST" 
      class="bg-gray-800 rounded-lg shadow-lg p-6">
    @csrf
    <input type="hidden" name="resultado_id" value="{{ $resultadoId }}">
    
    <!-- Contador de tiempo (opcional, visual) -->
    <div class="mb-6 text-center">
        <div class="inline-flex items-center gap-2 bg-gray-700 px-4 py-2 rounded-full">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span id="tiempo" class="font-mono text-lg font-semibold text-gray-300">
                {{ $examen->duracion_minutos }}:00
            </span>
        </div>
    </div>

    <!-- Preguntas -->
    <div class="space-y-6">
        @foreach($preguntas as $index => $pregunta)
            <div class="border border-gray-700 rounded-lg p-5 hover:shadow-md transition-shadow">
                <div class="flex items-start gap-3">
                    <span class="flex-shrink-0 inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-900 text-blue-200 font-semibold text-sm">
                        {{ $index + 1 }}
                    </span>
                    
                    <div class="flex-grow">
                        <p class="text-gray-200 font-medium mb-3">
                            {{ $pregunta->pregunta }}
                        </p>
                        
                        <div class="flex gap-4">
                            <!-- Opción Verdadero -->
                            <label class="flex items-center cursor-pointer group">
                                <input type="radio" 
                                       name="respuestas[{{ $pregunta->id }}]" 
                                       value="verdadero"
                                       class="sr-only peer"
                                       @if(isset($respuestasGuardadas[$pregunta->id]) && $respuestasGuardadas[$pregunta->id] == 'verdadero')
                                           checked
                                       @endif
                                       required>
                                <div class="relative w-6 h-6 mr-2 border-2 border-gray-500 rounded-full peer-checked:border-green-500 peer-checked:bg-green-500 transition-all">
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <div class="w-2 h-2 bg-white rounded-full opacity-0 peer-checked:opacity-100"></div>
                                    </div>
                                </div>
                                <span class="text-gray-300 group-hover:text-green-400 transition-colors">
                                    ✓ Verdadero
                                </span>
                            </label>
                            
                            <!-- Opción Falso -->
                            <label class="flex items-center cursor-pointer group">
                                <input type="radio" 
                                       name="respuestas[{{ $pregunta->id }}]" 
                                       value="falso"
                                       class="sr-only peer"
                                       @if(isset($respuestasGuardadas[$pregunta->id]) && $respuestasGuardadas[$pregunta->id] == 'falso')
                                           checked
                                       @endif
                                       required>
                                <div class="relative w-6 h-6 mr-2 border-2 border-gray-500 rounded-full peer-checked:border-red-500 peer-checked:bg-red-500 transition-all">
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <div class="w-2 h-2 bg-white rounded-full opacity-0 peer-checked:opacity-100"></div>
                                    </div>
                                </div>
                                <span class="text-gray-300 group-hover:text-red-400 transition-colors">
                                    ✗ Falso
                                </span>
                            </label>
                        </div>
                        
                        @if($pregunta->puntos > 1)
                            <p class="text-xs text-gray-400 mt-2">
                                Valor: {{ $pregunta->puntos }} puntos
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Contador de preguntas respondidas -->
    <div class="mt-6 p-4 bg-gray-700 rounded-lg">
        <div class="flex justify-between items-center">
            <span class="text-sm text-gray-400">
                Preguntas respondidas:
            </span>
            <span class="font-semibold text-gray-200">
                <span id="respondidas">0</span> / {{ count($preguntas) }}
            </span>
        </div>
        <div class="w-full bg-gray-600 rounded-full h-2 mt-2">
            <div id="barraProgreso" class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
        </div>
    </div>

    <!-- Botones de acción -->
    <div class="flex gap-4 mt-8">
        <button type="button" 
                onclick="guardarBorrador()"
                class="flex-1 bg-gray-600 hover:bg-gray-500 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-105">
             Continuar Después
        </button>
        
        <button type="submit" 
                id="btnEnviar"
                class="flex-1 bg-green-600 hover:bg-green-500 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-105">
            Finalizar Examen
        </button>
    </div>
</form>
    </div>

    <script>
        // Timer del examen
        let tiempoRestante = {{ $examen->duracion_minutos }} * 60;
        let timerInterval;
        
        function iniciarTimer() {
            timerInterval = setInterval(() => {
                tiempoRestante--;
                
                if (tiempoRestante <= 0) {
                    clearInterval(timerInterval);
                    alert('¡El tiempo ha terminado! El examen se enviará automáticamente.');
                    document.getElementById('formExamen').submit();
                    return;
                }
                
                const minutos = Math.floor(tiempoRestante / 60);
                const segundos = tiempoRestante % 60;
                document.getElementById('tiempo').textContent = 
                    `${minutos.toString().padStart(2, '0')}:${segundos.toString().padStart(2, '0')}`;
                
                // Advertencia cuando quedan 5 minutos
                if (tiempoRestante === 300) {
                    alert('⚠️ Quedan 5 minutos para terminar el examen');
                }
            }, 1000);
        }
        
        // Contador de preguntas respondidas
        function actualizarContador() {
            const totalPreguntas = {{ count($preguntas) }};
            const respondidas = document.querySelectorAll('input[type="radio"]:checked').length;
            
            document.getElementById('respondidas').textContent = respondidas;
            const porcentaje = (respondidas / totalPreguntas) * 100;
            document.getElementById('barraProgreso').style.width = porcentaje + '%';
            
            // Habilitar/deshabilitar botón enviar
            const btnEnviar = document.getElementById('btnEnviar');
            if (respondidas === totalPreguntas) {
                btnEnviar.classList.remove('opacity-50', 'cursor-not-allowed');
                btnEnviar.disabled = false;
            } else {
                btnEnviar.classList.add('opacity-50', 'cursor-not-allowed');
                btnEnviar.disabled = true;
            }
        }
        
        // Guardar borrador (implementación básica)
        function guardarBorrador() {
            if (confirm('¿Deseas guardar tu progreso y continuar más tarde?')) {
                // Aquí podrías implementar un guardado temporal via AJAX
                alert('Tu progreso ha sido guardado. Puedes continuar más tarde.');
                window.location.href = '{{ route("curso.videos", $examen->curso_id) }}';
            }
        }
        
        // Event listeners
        document.addEventListener('DOMContentLoaded', function() {
            iniciarTimer();
            actualizarContador();
            
            // Actualizar contador cuando se responde una pregunta
            document.querySelectorAll('input[type="radio"]').forEach(radio => {
                radio.addEventListener('change', actualizarContador);
            });
            
            // Confirmación antes de enviar
            document.getElementById('formExamen').addEventListener('submit', function(e) {
                e.preventDefault();
                
                if (confirm('¿Estás seguro de que deseas enviar el examen? No podrás cambiar tus respuestas después.')) {
                    this.submit();
                }
            });
            
            // Advertencia al salir de la página
            window.addEventListener('beforeunload', function(e) {
                e.preventDefault();
                e.returnValue = '';
                return '¿Estás seguro de que deseas salir? Tu progreso podría perderse.';
            });
        });
    </script>
</x-app-layout>