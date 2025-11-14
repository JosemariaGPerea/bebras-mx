<!-- resources/views/preguntas/show.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $pregunta->titulo }} - Bebras MX</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @if($pregunta->tipo_interaccion === 'ordenar')
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    @endif
</head>
<body class="bg-gradient-to-br from-blue-50 to-purple-50 min-h-screen">
    
    {{-- Navegación Superior --}}
    <div class="bg-white shadow-md">
        <div class="max-w-5xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ route('preguntas.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Volver a preguntas
            </a>
            <div class="text-sm text-gray-600">
                Pregunta {{ $pregunta->numero }} de 27
            </div>
        </div>
    </div>

    <div class="max-w-5xl mx-auto py-8 px-4">
        
        {{-- Descripción --}}
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="flex items-start justify-between mb-4">
                <div class="flex-1">
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">
                        {{ $pregunta->numero }}. {{ $pregunta->titulo }}
                    </h2>
                    <div class="flex gap-2 mb-4">
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold">
                            Nivel {{ $pregunta->nivel }}
                        </span>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold
                            {{ $pregunta->dificultad === 'Baja' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $pregunta->dificultad === 'Media' ? 'bg-yellow-100 text-yellow-700' : '' }}
                            {{ $pregunta->dificultad === 'Alta' ? 'bg-red-100 text-red-700' : '' }}">
                            {{ $pregunta->dificultad }}
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="prose max-w-none">
                <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $pregunta->descripcion }}</p>
            </div>
            
            @if($pregunta->imagen_descripcion)
                <div class="mt-4 flex justify-center">
                    <img src="{{ asset('storage/' . $pregunta->imagen_descripcion) }}" 
                         alt="Descripción" 
                         class="max-w-full rounded-lg shadow-md">
                </div>
            @endif
        </div>

        {{-- Pregunta --}}
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-2xl font-semibold text-gray-800 mb-6 border-b-2 border-blue-500 pb-2">
                {{ $pregunta->pregunta }}
            </h3>
            
            @if($pregunta->imagen_pregunta)
                <div class="mb-6 flex justify-center">
                    <img src="{{ asset('storage/' . $pregunta->imagen_pregunta) }}" 
                         alt="Pregunta" 
                         class="max-w-full rounded-lg">
                </div>
            @endif

            {{-- Contenedor dinámico según tipo de interacción --}}
            <div id="contenedor-interaccion" class="mb-6">
                @include('preguntas.tipos.' . $pregunta->tipo_interaccion, ['config' => $pregunta->configuracion])
            </div>

            {{-- Botón de verificar --}}
            <button 
                id="btnVerificar"
                onclick="verificarRespuesta()"
                class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-4 rounded-lg hover:from-blue-700 hover:to-purple-700 font-bold text-lg transition-all transform hover:scale-105 shadow-lg">
                Verificar Respuesta
            </button>

            {{-- Resultado (oculto inicialmente) --}}
            <div id="resultado" class="hidden mt-6"></div>

            {{-- Botones de navegación (ocultos inicialmente) --}}
            <div id="navegacion" class="hidden mt-6 flex gap-4">
                @php
                    $preguntaAnterior = \App\Models\Pregunta::where('numero', '<', $pregunta->numero)
                        ->orderBy('numero', 'desc')
                        ->first();
                    $preguntaSiguiente = \App\Models\Pregunta::where('numero', '>', $pregunta->numero)
                        ->orderBy('numero', 'asc')
                        ->first();
                @endphp

                @if($preguntaAnterior)
                    <a href="{{ route('preguntas.show', $preguntaAnterior->id) }}" 
                       class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 py-3 px-6 rounded-lg font-semibold transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Pregunta Anterior
                    </a>
                @else
                    <div class="flex-1"></div>
                @endif

                @if($preguntaSiguiente)
                    <a href="{{ route('preguntas.show', $preguntaSiguiente->id) }}" 
                       class="flex-1 bg-gradient-to-r py-3 px-6 rounded-lg font-semibold transition-all flex items-center justify-center gap-2 colors-white from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600">
                        Siguiente Pregunta
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                @else
                    <a href="{{ route('preguntas.index') }}" 
                       class="flex-1 bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white py-3 px-6 rounded-lg font-semibold transition-all flex items-center justify-center gap-2">
                        Finalizar
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </a>
                @endif
            </div>
        </div>

    </div>

    {{-- Scripts específicos por tipo --}}
    @include('preguntas.scripts.' . $pregunta->tipo_interaccion)

    {{-- Script general de verificación --}}
    <script>
        let respondido = {{ $yaRespondio ? 'true' : 'false' }};
        const preguntaId = {{ $pregunta->id }};
        const yaRespondioAntes = {{ $yaRespondio ? 'true' : 'false' }};

        @if($yaRespondio)
            document.addEventListener('DOMContentLoaded', function() {
                const btnVerificar = document.getElementById('btnVerificar');
                btnVerificar.disabled = true;
                btnVerificar.classList.add('opacity-50', 'cursor-not-allowed');
                btnVerificar.textContent = 'Ya Respondiste Esta Pregunta';
                
                deshabilitarInteraccion();
                
                // Mostrar resultado previo
                mostrarResultadoPrevio({
                    correcta: {{ $progresoUsuario->es_correcta ? 'true' : 'false' }},
                    explicacion: @json($pregunta->explicacion),
                    respuesta_correcta_visual: '',
                    imagen_respuesta: @json($pregunta->imagen_respuesta)
                });
                
                mostrarNavegacion();
            });

            function mostrarResultadoPrevio(data) {
                const resultado = document.getElementById('resultado');
                resultado.classList.remove('hidden');
                
                if (data.correcta) {
                    resultado.className = 'mt-6 p-6 rounded-lg bg-green-50 border-2 border-green-500';
                    resultado.innerHTML = `
                        <div class="flex items-start gap-4">
                            <svg class="w-12 h-12 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="flex-1">
                                <h4 class="font-bold text-green-800 text-2xl mb-3">¡Respondiste Correctamente! 🎉</h4>
                                <p class="text-green-700 leading-relaxed mb-4">${data.explicacion}</p>
                                ${data.imagen_respuesta ? `
                                    <div class="mt-4 flex justify-center">
                                        <img src="/storage/${data.imagen_respuesta}" 
                                            alt="Solución" 
                                            class="max-w-full rounded-lg shadow-md">
                                    </div>
                                ` : ''}
                            </div>
                        </div>
                    `;
                } else {
                    resultado.className = 'mt-6 p-6 rounded-lg bg-red-50 border-2 border-red-500';
                    resultado.innerHTML = `
                        <div class="flex items-start gap-4">
                            <svg class="w-12 h-12 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="flex-1">
                                <h4 class="font-bold text-red-800 text-2xl mb-3">Tu respuesta fue incorrecta</h4>
                                <p class="text-red-700 leading-relaxed mb-4">${data.explicacion}</p>
                                ${data.imagen_respuesta ? `
                                    <div class="mt-4 flex justify-center">
                                        <img src="/storage/${data.imagen_respuesta}" 
                                            alt="Solución" 
                                            class="max-w-full rounded-lg shadow-md">
                                    </div>
                                ` : ''}
                            </div>
                        </div>
                    `;
                }
            }
        @endif
        function verificarRespuesta() {
            if (respondido || yaRespondioAntes) {
                alert('Ya respondiste esta pregunta anteriormente.');
                return;
            }

            const respuesta = obtenerRespuesta();
            
            if (!respuesta) {
                alert('Por favor completa tu respuesta antes de verificar');
                return;
            }

            // Enviar a Laravel
            fetch(`/preguntas/${preguntaId}/verificar`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ respuesta })
            })
            .then(response => response.json())
            .then(data => {
                respondido = true;
                mostrarResultado(data);
                deshabilitarInteraccion();
                mostrarNavegacion(); // 
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Hubo un error al verificar la respuesta');
            });
        }

        function mostrarResultado(data) {
            const resultado = document.getElementById('resultado');
            const btnVerificar = document.getElementById('btnVerificar');

            resultado.classList.remove('hidden');
            btnVerificar.disabled = true;
            btnVerificar.classList.add('opacity-50', 'cursor-not-allowed');

            if (data.correcta) {
                resultado.className = 'mt-6 p-6 rounded-lg bg-green-50 border-2 border-green-500';
                resultado.innerHTML = `
                    <div class="flex items-start gap-4">
                        <svg class="w-12 h-12 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div class="flex-1">
                            <h4 class="font-bold text-green-800 text-2xl mb-3">Correcto!!!</h4>
                            <p class="text-green-700 leading-relaxed mb-4">${data.explicacion}</p>
                            ${data.imagen_respuesta ? `
                                <div class="mt-4 flex justify-center">
                                    <img src="/storage/${data.imagen_respuesta}" 
                                        alt="Solución" 
                                        class="max-w-full rounded-lg shadow-md">
                                </div>
                            ` : ''}
                        </div>
                    </div>
                `;
            } else {
                resultado.className = 'mt-6 p-6 rounded-lg bg-red-50 border-2 border-red-500';
                resultado.innerHTML = `
                    <div class="flex items-start gap-4">
                        <svg class="w-12 h-12 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div class="flex-1">
                            <h4 class="font-bold text-red-800 text-2xl mb-3">Incorrecto </h4>
                            <p class="text-red-700 leading-relaxed mb-4">${data.explicacion}</p>
                            ${data.imagen_respuesta ? `
                                <div class="mt-4 flex justify-center">
                                    <img src="/storage/${data.imagen_respuesta}" 
                                        alt="Solución" 
                                        class="max-w-full rounded-lg shadow-md">
                                </div>
                            ` : ''}
                            ${data.respuesta_correcta_visual ? `
                                <div class="mt-4 p-4 bg-white rounded border border-red-200">
                                    <p class="font-semibold text-red-800 mb-2">Respuesta correcta:</p>
                                    <p class="text-red-700">${data.respuesta_correcta_visual}</p>
                                </div>
                            ` : ''}
                        </div>
                    </div>
                `;
            }

            // Scroll suave al resultado
            resultado.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }

        // Funcion para mostrar los botones de navegación
        function mostrarNavegacion() {
            const navegacion = document.getElementById('navegacion');
            navegacion.classList.remove('hidden');
            navegacion.classList.add('animate-fadeIn');
            
            // Scroll suave hacia los botones
            setTimeout(() => {
                navegacion.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }, 500);
        }
    </script>

@extends('layouts.footer')
</body>

</html>