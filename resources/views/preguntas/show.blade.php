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
<body class="bg-gradient-to-br from-blue-50 to-purple-50 min-h-screen pb-20">
    
    {{-- Navegación Superior --}}
    <div class="bg-white shadow-md">
        <div class="max-w-5xl mx-auto px-4 py-2 flex items-center justify-between">
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

    <div class="max-w-5xl mx-auto py-3 px-4">
        
        {{-- Descripción --}}
        <div class="bg-white rounded-lg shadow-lg p-3 mb-3">
            <div class="flex items-start justify-between mb-2">
                <div class="flex-1">
                    <h2 class="text-xl font-bold text-gray-800 mb-1">
                        {{ $pregunta->numero }}. {{ $pregunta->titulo }}
                    </h2>
                    <div class="flex gap-2 mb-2">
                        <span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">
                            Nivel {{ $pregunta->nivel }}
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                            {{ $pregunta->dificultad === 'Baja' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $pregunta->dificultad === 'Media' ? 'bg-yellow-100 text-yellow-700' : '' }}
                            {{ $pregunta->dificultad === 'Alta' ? 'bg-red-100 text-red-700' : '' }}">
                            {{ $pregunta->dificultad }}
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="prose max-w-none">
                <p class="text-sm text-gray-700 leading-snug whitespace-pre-line">{{ $pregunta->descripcion }}</p>
            </div>
            
            @if($pregunta->imagen_descripcion)
                <div class="mt-2 flex justify-center">
                    <img src="{{ asset('storage/' . $pregunta->imagen_descripcion) }}" 
                         alt="Descripción" 
                         class="max-w-full max-h-48 rounded-lg shadow-md object-contain">
                </div>
            @endif
        </div>

        {{-- Pregunta --}}
        <div class="bg-white rounded-lg shadow-lg p-3">
            <h3 class="text-lg font-semibold text-gray-800 mb-3 border-b-2 border-blue-500 pb-1">
                {{ $pregunta->pregunta }}
            </h3>
            
            @if($pregunta->imagen_pregunta)
                <div class="mb-3 flex justify-center">
                    <img src="{{ asset('storage/' . $pregunta->imagen_pregunta) }}" 
                         alt="Pregunta" 
                         class="max-w-full max-h-48 rounded-lg object-contain">
                </div>
            @endif

            {{-- Contenedor dinámico según tipo de interacción --}}
            <div id="contenedor-interaccion" class="mb-3">
                @if(!empty($pregunta->tipo_interaccion))
                    @php
                        $tipoVista = 'preguntas.tipos.' . $pregunta->tipo_interaccion;
                        $vistaExiste = view()->exists($tipoVista);
                    @endphp
                    @if($vistaExiste)
                        @include($tipoVista, ['config' => $pregunta->configuracion, 'pregunta' => $pregunta])
                    @else
                        <div class="bg-red-50 border-2 border-red-400 rounded-lg p-6 text-center">
                            <svg class="w-16 h-16 text-red-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <h4 class="text-xl font-bold text-red-800 mb-2">Vista No Encontrada</h4>
                            <p class="text-red-700 mb-2">No se encontró la vista para el tipo: <strong>{{ $pregunta->tipo_interaccion }}</strong></p>
                            <p class="text-sm text-red-600">Vista esperada: <code>{{ $tipoVista }}</code></p>
                        </div>
                    @endif
                @else
                    <div class="bg-yellow-50 border-2 border-yellow-400 rounded-lg p-6 text-center">
                        <svg class="w-16 h-16 text-yellow-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <h4 class="text-xl font-bold text-yellow-800 mb-2">Tipo de Interacción No Implementado</h4>
                        <p class="text-yellow-700">Esta pregunta aún no tiene un tipo de interacción implementado. Por favor, contacta al administrador.</p>
                    </div>
                @endif
            </div>

            {{-- Botón de verificar --}}
            <button 
                id="btnVerificar"
                onclick="verificarRespuesta()"
                @if(empty($pregunta->tipo_interaccion)) disabled @endif
                class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-2 rounded-lg hover:from-blue-700 hover:to-purple-700 font-semibold text-base transition-all shadow-lg @if(empty($pregunta->tipo_interaccion)) opacity-50 cursor-not-allowed @endif">
                @if(empty($pregunta->tipo_interaccion))
                    Tipo de Interacción No Disponible
                @else
                    Verificar Respuesta
                @endif
            </button>

            {{-- Resultado (oculto inicialmente) --}}
            <div id="resultado" class="hidden mt-3"></div>

            {{-- Botones de navegación (ocultos inicialmente) --}}
            <div id="navegacion" class="hidden mt-3 flex gap-2">
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
                       class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 px-4 rounded-lg font-semibold text-sm transition-all flex items-center justify-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Anterior
                    </a>
                @else
                    <div class="flex-1"></div>
                @endif

                @if($preguntaSiguiente)
                    <a href="{{ route('preguntas.show', $preguntaSiguiente->id) }}" 
                       class="flex-1 bg-gradient-to-r py-2 px-4 rounded-lg font-semibold text-sm transition-all flex items-center justify-center gap-1 colors-white from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600">
                        Siguiente
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                @else
                    <a href="{{ route('preguntas.index') }}" 
                       class="flex-1 bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white py-2 px-4 rounded-lg font-semibold text-sm transition-all flex items-center justify-center gap-1">
                        Finalizar
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </a>
                @endif
            </div>
        </div>

    </div>

    {{-- Scripts específicos por tipo --}}
    @if(!empty($pregunta->tipo_interaccion))
        @php
            $tipoScript = 'preguntas.scripts.' . $pregunta->tipo_interaccion;
            $scriptExiste = view()->exists($tipoScript);
        @endphp
        @if($scriptExiste)
            @include($tipoScript, ['config' => $pregunta->configuracion, 'progresoUsuario' => $progresoUsuario ?? null])
        @endif
    @endif

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
                    resultado.className = 'mt-3 p-3 rounded-lg bg-green-50 border-2 border-green-500';
                    resultado.innerHTML = `
                        <div class="flex items-start gap-2">
                            <svg class="w-8 h-8 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="flex-1">
                                <h4 class="font-bold text-green-800 text-lg mb-2">¡Respondiste Correctamente! 🎉</h4>
                                <p class="text-sm text-green-700 leading-snug mb-2">${data.explicacion}</p>
                                ${data.imagen_respuesta ? `
                                    <div class="mt-2 flex justify-center">
                                        <img src="/storage/${data.imagen_respuesta}" 
                                            alt="Solución" 
                                            class="max-w-full max-h-48 rounded-lg shadow-md object-contain">
                                    </div>
                                ` : ''}
                            </div>
                        </div>
                    `;
                } else {
                    resultado.className = 'mt-3 p-3 rounded-lg bg-red-50 border-2 border-red-500';
                    resultado.innerHTML = `
                        <div class="flex items-start gap-2">
                            <svg class="w-8 h-8 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="flex-1">
                                <h4 class="font-bold text-red-800 text-lg mb-2">Tu respuesta fue incorrecta</h4>
                                <p class="text-sm text-red-700 leading-snug mb-2">${data.explicacion}</p>
                                ${data.imagen_respuesta ? `
                                    <div class="mt-2 flex justify-center">
                                        <img src="/storage/${data.imagen_respuesta}" 
                                            alt="Solución" 
                                            class="max-w-full max-h-48 rounded-lg shadow-md object-contain">
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
                    resultado.className = 'mt-3 p-3 rounded-lg bg-green-50 border-2 border-green-500';
                    resultado.innerHTML = `
                        <div class="flex items-start gap-2">
                            <svg class="w-8 h-8 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="flex-1">
                                <h4 class="font-bold text-green-800 text-lg mb-2">Correcto!!!</h4>
                                <p class="text-sm text-green-700 leading-snug mb-2">${data.explicacion}</p>
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
                resultado.className = 'mt-3 p-3 rounded-lg bg-red-50 border-2 border-red-500';
                resultado.innerHTML = `
                    <div class="flex items-start gap-2">
                        <svg class="w-8 h-8 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div class="flex-1">
                            <h4 class="font-bold text-red-800 text-lg mb-2">Incorrecto </h4>
                            <p class="text-sm text-red-700 leading-snug mb-2">${data.explicacion}</p>
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

@include('layouts.footer')
</body>

</html>