@php
    $config = is_string($config) ? json_decode($config, true) : $config;
    $filas = $config['filas'] ?? 6;
    $columnas = $config['columnas'] ?? 6;
    $simbolosDisponibles = $config['simbolos_disponibles'] ?? ['purple', 'red', 'yellow', 'green'];
    
    // Mapeo de símbolos a colores y letras
    $simbolosMap = [
        'purple' => ['letra' => 'M', 'nombre' => 'Morado', 'color' => 'bg-purple-500', 'border' => 'border-purple-600', 'text' => 'text-white'],
        'red' => ['letra' => 'R', 'nombre' => 'Rojo', 'color' => 'bg-red-500', 'border' => 'border-red-600', 'text' => 'text-white'],
        'yellow' => ['letra' => 'A', 'nombre' => 'Amarillo', 'color' => 'bg-yellow-400', 'border' => 'border-yellow-600', 'text' => 'text-gray-800'],
        'green' => ['letra' => 'V', 'nombre' => 'Verde', 'color' => 'bg-green-500', 'border' => 'border-green-600', 'text' => 'text-white'],
    ];
@endphp

<div class="tejer-alfombra-container">
    {{-- Instrucciones --}}
    <div class="bg-blue-50 border-l-4 border-blue-500 p-2 rounded mb-2 text-xs text-blue-800">
        <strong>Instrucciones:</strong> Selecciona un símbolo y haz clic en una celda para colocarlo. Sigue el diagrama de decisiones para cada celda.
    </div>

    {{-- Selector de símbolos --}}
    <div class="mb-3">
        <h4 class="text-sm font-semibold text-gray-800 mb-2">Selecciona un símbolo:</h4>
        <div class="flex gap-2 justify-center flex-wrap">
            @foreach($simbolosDisponibles as $simbolo)
                @php
                    $simboloInfo = $simbolosMap[$simbolo] ?? ['letra' => '?', 'nombre' => ucfirst($simbolo), 'color' => 'bg-gray-500', 'border' => 'border-gray-600', 'text' => 'text-white'];
                @endphp
                <button 
                    type="button"
                    class="simbolo-btn px-4 py-2 rounded-lg text-sm font-bold transition-all shadow-md border-2 {{ $simboloInfo['color'] }} {{ $simboloInfo['border'] }} {{ $simboloInfo['text'] }} hover:opacity-80"
                    data-simbolo="{{ $simbolo }}"
                    data-letra="{{ $simboloInfo['letra'] }}"
                    onclick="seleccionarSimbolo('{{ $simbolo }}', '{{ $simboloInfo['letra'] }}')">
                    {{ $simboloInfo['letra'] }} - {{ $simboloInfo['nombre'] }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- Grid de la alfombra --}}
    <div class="bg-white border-2 border-gray-300 rounded-lg p-4">
        <h4 class="text-sm font-semibold text-gray-700 mb-3 text-center">
            Alfombra ({{ $filas }}x{{ $columnas }})
        </h4>
        
        <div class="overflow-x-auto">
            <div class="inline-block">
                {{-- Labels de columnas --}}
                <div class="flex mb-1 pl-8">
                    @for($col = 1; $col <= $columnas; $col++)
                        <div class="w-12 text-center font-bold text-xs text-gray-700">{{ $col }}</div>
                    @endfor
                </div>

                {{-- Grid --}}
                @for($fila = 1; $fila <= $filas; $fila++)
                    <div class="flex items-center mb-1">
                        {{-- Label de fila --}}
                        <div class="w-8 text-center font-bold text-xs text-gray-700">
                            {{ $fila }}
                        </div>
                        
                        {{-- Celdas --}}
                        @for($col = 1; $col <= $columnas; $col++)
                            <button 
                                type="button"
                                class="celda-alfombra w-12 h-12 border-2 border-gray-300 rounded-lg transition-all mr-1 relative bg-gray-50 hover:bg-gray-100 cursor-pointer"
                                data-fila="{{ $fila }}"
                                data-columna="{{ $col }}"
                                onclick="colorearCelda(this)">
                                <span class="text-xs text-gray-400 celda-coordenadas">{{ $fila }}-{{ $col }}</span>
                                <span class="celda-simbolo hidden text-lg font-bold"></span>
                            </button>
                        @endfor
                    </div>
                @endfor
            </div>
        </div>
    </div>

    {{-- Resumen --}}
    <div class="mt-2 bg-gray-50 border border-gray-200 rounded-lg p-2">
        <h5 class="text-xs font-semibold text-gray-700 mb-1">Celdas completadas:</h5>
        <div id="resumen-alfombra" class="text-xs text-gray-600">
            <p>Ninguna celda completada aún.</p>
        </div>
    </div>
</div>

<style>
    .celda-alfombra.coloreada {
        border-width: 3px;
    }
    
    .simbolo-btn.seleccionado {
        transform: scale(1.1);
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.3);
    }
</style>

