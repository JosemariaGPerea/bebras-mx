<!-- resources/views/preguntas/index.blade.php - ACTUALIZAR -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca de Preguntas - Bebras MX</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-purple-50 min-h-screen">
    
    {{-- Header --}}
    <div class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold text-gray-800">Bebras MX - Primavera 2025</h1>
                    <p class="text-gray-600 mt-2">Biblioteca de Preguntas de Pensamiento Computacional</p>
                </div>
                <div class="flex items-center gap-4">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" 
                               class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                                Panel Admin
                            </a>
                        @endif
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ auth()->user()->role === 'admin' ? 'Administrador' : 'Alumno' }}</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                Cerrar Sesión
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-8">
        
        {{-- Estadísticas del alumno --}}
        @auth
            @if(auth()->user()->isAlumno())
                @php
                    $totalPreguntas = $preguntas->count();
                    $respondidas = $progreso->count();
                    $correctas = $progreso->filter(fn($p) => $p)->count();
                    $porcentaje = $respondidas > 0 ? round(($correctas / $respondidas) * 100) : 0;
                @endphp
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Tu Progreso</h2>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-blue-600">{{ $respondidas }}</div>
                            <div class="text-sm text-gray-600">Respondidas</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-green-600">{{ $correctas }}</div>
                            <div class="text-sm text-gray-600">Correctas</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-red-600">{{ $respondidas - $correctas }}</div>
                            <div class="text-sm text-gray-600">Incorrectas</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-purple-600">{{ $porcentaje }}%</div>
                            <div class="text-sm text-gray-600">Éxito</div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-blue-600 h-3 rounded-full transition-all" 
                                 style="width: {{ ($respondidas / $totalPreguntas) * 100 }}%"></div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1 text-center">
                            {{ $respondidas }} de {{ $totalPreguntas }} preguntas completadas
                        </p>
                    </div>
                </div>
            @endif
        @endauth

        {{-- Filtros --}}
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="grid md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nivel</label>
                    <select id="filtro-nivel" class="w-full border-gray-300 rounded-lg">
                        <option value="">Todos</option>
                        <option value="I">Nivel I</option>
                        <option value="II">Nivel II</option>
                        <option value="III">Nivel III</option>
                        <option value="IV">Nivel IV</option>
                        <option value="V">Nivel V</option>
                        <option value="VI">Nivel VI</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Dificultad</label>
                    <select id="filtro-dificultad" class="w-full border-gray-300 rounded-lg">
                        <option value="">Todas</option>
                        <option value="Baja">Baja</option>
                        <option value="Media">Media</option>
                        <option value="Alta">Alta</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                    <select id="filtro-estado" class="w-full border-gray-300 rounded-lg">
                        <option value="">Todas</option>
                        <option value="correcta">Correctas</option>
                        <option value="incorrecta">Incorrectas</option>
                        <option value="pendiente">Pendientes</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button onclick="aplicarFiltros()" 
                            class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                        Aplicar Filtros
                    </button>
                </div>
            </div>
        </div>

        {{-- Grid de Preguntas --}}
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($preguntas as $pregunta)
                @php
                    $yaRespondio = $progreso->has($pregunta->id);
                    $esCorrecta = $yaRespondio && $progreso->get($pregunta->id);
                @endphp
                
                <a href="{{ route('preguntas.show', $pregunta->id) }}" 
                   class="pregunta-card block bg-white rounded-lg shadow-md hover:shadow-xl transition-all transform hover:-translate-y-1 relative"
                   data-nivel="{{ $pregunta->nivel }}"
                   data-dificultad="{{ $pregunta->dificultad }}"
                   data-estado="{{ $yaRespondio ? ($esCorrecta ? 'correcta' : 'incorrecta') : 'pendiente' }}">
                    
                    {{-- Status Badge --}}
                    <div class="absolute top-3 right-3 z-10">
                        @if($yaRespondio)
                            @if($esCorrecta)
                                <div class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-semibold flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Correcta
                                </div>
                            @else
                                <div class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                    Incorrecta
                                </div>
                            @endif
                        @endif
                    </div>
                    
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-3xl font-bold text-blue-600">{{ $pregunta->numero }}</span>
                            <div class="flex gap-2">
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-semibold">
                                    Nivel {{ $pregunta->nivel }}
                                </span>
                                <span class="px-2 py-1 rounded text-xs font-semibold
                                    {{ $pregunta->dificultad === 'Baja' ? 'bg-green-100 text-green-700' : '' }}
                                    {{ $pregunta->dificultad === 'Media' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                    {{ $pregunta->dificultad === 'Alta' ? 'bg-red-100 text-red-700' : '' }}">
                                    {{ $pregunta->dificultad }}
                                </span>
                            </div>
                        </div>
                        
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $pregunta->titulo }}</h3>
                        <p class="text-gray-600 text-sm line-clamp-3">{{ Str::limit($pregunta->descripcion, 150) }}</p>
                        
                        <div class="mt-4 pt-4 border-t border-gray-200 flex items-center justify-between text-sm text-gray-500">
                            <span>{{ $pregunta->pais_origen }}</span>
                            @if($yaRespondio)
                                <span class="font-medium text-blue-600">Ver resultado →</span>
                            @else
                                <span class="font-medium text-blue-600">Resolver →</span>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <script>
        function aplicarFiltros() {
            const nivel = document.getElementById('filtro-nivel').value;
            const dificultad = document.getElementById('filtro-dificultad').value;
            const estado = document.getElementById('filtro-estado').value;
            
            document.querySelectorAll('.pregunta-card').forEach(card => {
                let mostrar = true;
                
                if (nivel && card.dataset.nivel !== nivel) mostrar = false;
                if (dificultad && card.dataset.dificultad !== dificultad) mostrar = false;
                if (estado && card.dataset.estado !== estado) mostrar = false;
                
                card.style.display = mostrar ? 'block' : 'none';
            });
        }
    </script>
    @extends('layouts.footer')
</body>
</html>