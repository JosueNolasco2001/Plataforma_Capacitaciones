<x-app-layout>
    <div class="max-w-screen-xl mx-auto  p-5 sm:p-10 md:p-16">
        <!-- Header con resultado -->
        <div class="bg-gradient-to-r 
            @if($mejorIntento && $mejorIntento->calificacion >= $examen->porcentaje_aprobacion)
                from-green-500 to-emerald-600
            @else
                from-yellow-500 to-orange-600
            @endif
            text-white rounded-lg shadow-lg p-6 mb-6 mt-[10%] sm:mt-0">
            
            <h1 class="text-3xl font-bold mb-2">Resultados del Examen</h1>
            <p class="text-xl opacity-90">{{ $examen->titulo }}</p>
            <p class="text-lg opacity-80">Curso: {{ $examen->curso_titulo }}</p>
        </div>

        <!-- Resumen de intentos -->
       <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <!-- Mejor calificación -->
    <div class="bg-gray-800 rounded-lg p-6 shadow-lg text-center">
        <div class="text-4xl font-bold mb-2
            @if($mejorIntento && $mejorIntento->calificacion >= $examen->porcentaje_aprobacion)
                text-green-400
            @else
                text-yellow-400
            @endif">
            {{ $mejorIntento ? number_format($mejorIntento->calificacion, 1) : 0 }}%
        </div>
        <p class="text-gray-400">Mejor Calificación</p>
        @if($mejorIntento && $mejorIntento->calificacion >= $examen->porcentaje_aprobacion)
            <span class="inline-block mt-2 px-3 py-1 bg-green-900 text-green-300 rounded-full text-sm font-semibold">
                 APROBADO
            </span>
        @else
            <span class="inline-block mt-2 px-3 py-1 bg-yellow-900 text-yellow-300 rounded-full text-sm font-semibold">
                ⚠️ NO APROBADO
            </span>
        @endif
    </div>

    <!-- Intentos realizados -->
    <div class="bg-gray-800 rounded-lg p-6 shadow-lg text-center">
        <div class="text-4xl font-bold text-blue-400 mb-2">
            {{ count($intentos) }} / {{ $examen->intentos_permitidos }}
        </div>
        <p class="text-gray-400">Intentos Utilizados</p>
        @if($puedeReintentar)
            <span class="inline-block mt-2 px-3 py-1 bg-blue-900 text-blue-300 rounded-full text-sm">
                {{ $examen->intentos_permitidos - count($intentos) }} restante(s)
            </span>
        @else
            <span class="inline-block mt-2 px-3 py-1 bg-gray-700 text-gray-300 rounded-full text-sm">
                Sin intentos
            </span>
        @endif
    </div>

    <!-- Calificación mínima -->
    <div class="bg-gray-800 rounded-lg p-6 shadow-lg text-center">
        <div class="text-4xl font-bold text-purple-400 mb-2">
            {{ $examen->porcentaje_aprobacion }}%
        </div>
        <p class="text-gray-400">Calificación Mínima</p>
        <span class="inline-block mt-2 px-3 py-1 bg-purple-900 text-purple-300 rounded-full text-sm">
            Para aprobar
        </span>
    </div>
</div>

        <!-- Historial de intentos -->
       <!-- Historial de intentos -->
<div class="bg-gray-800 rounded-lg shadow-lg p-6 mb-6">
    <h2 class="text-xl font-bold text-gray-200 mb-4">📊 Historial de Intentos</h2>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-700">
                    <th class="text-left py-2 px-4 text-gray-400">Intento</th>
                    <th class="text-left py-2 px-4 text-gray-400">Calificación</th>
                    <th class="text-left py-2 px-4 text-gray-400">Estado</th>
                    <th class="text-left py-2 px-4 text-gray-400">Fecha</th>
                    <th class="text-left py-2 px-4 text-gray-400">Duración</th>
                </tr>
            </thead>
            <tbody>
                @foreach($intentos as $intento)
                    <tr class="border-b border-gray-700 hover:bg-gray-700">
                        <td class="py-3 px-4">
                            <span class="font-semibold text-white">Intento {{ $intento->intento }}</span>
                            @if($mejorIntento && $intento->id == $mejorIntento->id)
                                <span class="ml-2 text-xs bg-green-900 text-green-300 px-2 py-1 rounded">Mejor</span>
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            @if($intento->completado)
                                <span class="font-bold
                                    @if($intento->calificacion >= $examen->porcentaje_aprobacion)
                                        text-green-400
                                    @else
                                        text-red-400
                                    @endif">
                                    {{ number_format($intento->calificacion, 1) }}%
                                </span>
                            @else
                                <span class="text-gray-500">-</span>
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            @if($intento->completado)
                                @if($intento->calificacion >= $examen->porcentaje_aprobacion)
                                    <span class="text-green-400 font-semibold">✅ Aprobado</span>
                                @else
                                    <span class="text-red-400 font-semibold">❌ No Aprobado</span>
                                @endif
                            @else
                                <span class="text-yellow-400 font-semibold">⏸️ Pendiente</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-sm text-gray-400">
                            {{ \Carbon\Carbon::parse($intento->created_at)->format('d/m/Y H:i') }}
                        </td>
                        <td class="py-3 px-4 text-sm text-gray-400">
                            @if($intento->completado && $intento->tiempo_fin)
                                @php
                                    $inicio = \Carbon\Carbon::parse($intento->tiempo_inicio);
                                    $fin = \Carbon\Carbon::parse($intento->tiempo_fin);
                                    $minutos = $inicio->diffInMinutes($fin);
                                @endphp
                                {{ $minutos }} min
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

        <!-- Detalles del último intento (si está completado) -->
        @if($ultimoIntento && $ultimoIntento->completado && count($preguntasConRespuestas) > 0)
           <div class="bg-gray-800 rounded-lg shadow-lg p-6 mb-6">
    <h2 class="text-xl font-bold text-gray-200 mb-4">
        Detalle del Último Intento Completado
    </h2>
    
    <div class="space-y-4">
        @foreach($preguntasConRespuestas as $index => $pregunta)
            <div class="border rounded-lg p-4
                @if($pregunta->es_correcta)
                    border-green-600 bg-green-900
                @else
                    border-red-600 bg-red-900
                @endif">
                
                <div class="flex items-start gap-3">
                    <span class="flex-shrink-0 inline-flex items-center justify-center w-8 h-8 rounded-full
                        @if($pregunta->es_correcta)
                            bg-green-700 text-green-200
                        @else
                            bg-red-700 text-red-200
                        @endif
                        font-semibold text-sm">
                        {{ $index + 1 }}
                    </span>
                    
                    <div class="flex-grow">
                        <p class="font-medium text-gray-200 mb-2">
                            {{ $pregunta->pregunta }}
                        </p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm">
                            <div>
                                <span class="text-gray-400">Tu respuesta:</span>
                                <span class="font-semibold ml-2
                                    @if($pregunta->es_correcta)
                                        text-green-400
                                    @else
                                        text-red-400
                                    @endif">
                                    {{ $pregunta->respuesta_texto ? ucfirst($pregunta->respuesta_texto) : 'Sin respuesta' }}
                                    @if($pregunta->es_correcta)
                                        ✅
                                    @else
                                        ❌
                                    @endif
                                </span>
                            </div>
                            
                            @if(!$pregunta->es_correcta)
                                <div>
                                    <span class="text-gray-400">Respuesta correcta:</span>
                                    <span class="font-semibold text-green-400 ml-2">
                                        {{ $pregunta->respuesta_correcta ? ucfirst($pregunta->respuesta_correcta) : 'N/A' }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        
                        @if($pregunta->puntos > 1)
                            <p class="text-xs text-gray-400 mt-1">
                                Valor: {{ $pregunta->puntos }} puntos
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
        @endif

        <!-- Botones de acción -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            @if($tieneIntentoPendiente)
                <a href="{{ route('examenes.continuar', $examen->id) }}" 
                   class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-105 text-center">
                    ⏸️ Continuar Examen Pendiente
                </a>
            @elseif($puedeReintentar)
                <a href="{{ route('examenes.tomar', $examen->id) }}" 
                   class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-105 text-center">
                     Realizar Otro Intento
                </a>
            @endif
            
            <a href="{{ route('curso.videos', $examen->curso_id) }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-105 text-center">
                ← Volver al Curso
            </a>

            @if($mejorIntento && $mejorIntento->calificacion >= $examen->porcentaje_aprobacion)
                <a href="{{ route('diploma.descargar.directo', $examen->curso_id) }}" 
                   class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-105 text-center">
                     Descargar Diploma
                </a>
            @endif
        </div>
    </div>
</x-app-layout>