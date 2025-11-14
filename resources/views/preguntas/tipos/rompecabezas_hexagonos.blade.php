@php
    $config = is_string($config) ? json_decode($config, true) : $config;
    $piezasDisponibles = $config['piezas_disponibles'] ?? [];
    $estructura = $config['estructura'] ?? [];
    $colores = $config['colores'] ?? ['red', 'blue', 'green'];
    
    // Mezclar piezas para orden aleatorio
    $piezasMezcladas = $piezasDisponibles;
    shuffle($piezasMezcladas);
@endphp

<div class="rompecabezas-hexagonos-container">
    {{-- Instrucciones --}}
    <div class="bg-blue-50 border-l-4 border-blue-500 p-2 rounded mb-2 text-xs text-blue-800">
        <strong>Instrucciones:</strong> Arrastra las piezas hexagonales al rompecabezas. Cada triángulo formado (pieza nueva + 2 de abajo) debe tener todas las piezas del mismo color O todas de colores diferentes.
    </div>

    <div class="grid lg:grid-cols-3 gap-3">
        {{-- Panel de piezas disponibles --}}
        <div class="lg:col-span-1">
            <h4 class="text-sm font-semibold text-gray-700 mb-2">
                Piezas disponibles: 
                <span class="text-xs font-normal text-gray-500" id="contador-piezas">
                    ({{ count($piezasMezcladas) }})
                </span>
            </h4>
            <div id="piezas-disponibles" class="bg-gray-100 border-2 border-dashed border-gray-300 rounded-lg p-2 min-h-[200px] space-y-2 max-h-[400px] overflow-y-auto">
                @foreach($piezasMezcladas as $pieza)
                    <div class="pieza-item bg-white border-2 border-gray-300 rounded-lg p-2 cursor-move hover:shadow-lg transition-shadow"
                         data-pieza-id="{{ $pieza['id'] }}"
                         data-color="{{ $pieza['color'] }}"
                         draggable="true">
                        <div class="flex items-center gap-2">
                            <div class="flex-shrink-0 w-12 h-12 rounded-lg flex items-center justify-center border-2"
                                 style="background-color: {{ $pieza['color'] }}; border-color: {{ $pieza['color'] }};">
                                <span class="text-xs font-bold text-white drop-shadow">{{ $pieza['id'] }}</span>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-semibold text-gray-800">Pieza {{ $pieza['id'] }}</p>
                                <p class="text-xs text-gray-500 capitalize">{{ $pieza['color'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Grid del rompecabezas --}}
        <div class="lg:col-span-2">
            <h4 class="text-sm font-semibold text-gray-700 mb-2">
                Rompecabezas: 
                <span class="text-xs font-normal text-gray-500" id="contador-colocadas">
                    (0/{{ count($estructura) }} colocadas)
                </span>
            </h4>
            
            {{-- Grid hexagonal del rompecabezas --}}
            <div class="bg-white border-2 border-gray-300 rounded-lg p-3">
                <div id="grid-rompecabezas" class="flex flex-col items-center gap-1">
                    @foreach($estructura as $filaIndex => $fila)
                        <div class="flex gap-1 justify-center" style="margin-left: {{ $filaIndex * 20 }}px;">
                            @foreach($fila as $colIndex => $celda)
                                @if($celda === null)
                                    {{-- Celda vacía, no se muestra --}}
                                @elseif(isset($celda['fija']) && $celda['fija'])
                                    {{-- Celda fija (ya colocada inicialmente) --}}
                                    <div class="celda-hexagono w-14 h-14 rounded-lg flex items-center justify-center border-2 relative"
                                         style="background-color: {{ $celda['color'] }}; border-color: {{ $celda['color'] }};"
                                         data-fila="{{ $filaIndex }}"
                                         data-columna="{{ $celda['columna'] ?? $colIndex }}"
                                         data-fija="true"
                                         data-color="{{ $celda['color'] }}">
                                        <span class="text-xs font-bold text-white drop-shadow">{{ $celda['id'] ?? '' }}</span>
                                    </div>
                                @else
                                    {{-- Celda vacía para colocar pieza --}}
                                    <div class="celda-hexagono w-14 h-14 rounded-lg border-2 border-gray-300 bg-gray-50 hover:bg-gray-100 transition-all cursor-pointer flex items-center justify-center relative"
                                         data-fila="{{ $filaIndex }}"
                                         data-columna="{{ $celda['columna'] ?? $colIndex }}"
                                         data-fija="false"
                                         data-ocupada="false">
                                        <span class="text-xs text-gray-400">{{ $celda['columna'] ?? $colIndex }}</span>
                                        <div class="pieza-en-celda hidden absolute inset-0 flex items-center justify-center rounded-lg border-2">
                                            <span class="text-xs font-bold text-white drop-shadow"></span>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Resumen de colocación --}}
    <div class="mt-2 bg-gray-50 border border-gray-200 rounded-lg p-2">
        <h5 class="text-xs font-semibold text-gray-700 mb-1">Piezas colocadas:</h5>
        <div id="resumen-colocacion" class="text-xs text-gray-600">
            <p>Ninguna pieza colocada aún.</p>
        </div>
    </div>
</div>

<style>
    .pieza-item {
        user-select: none;
    }
    
    .pieza-item.dragging {
        opacity: 0.5;
    }
    
    .celda-hexagono {
        position: relative;
    }
    
    .celda-hexagono.ocupada {
        background-color: #fef3c7;
        border-color: #f59e0b;
    }
    
    .celda-hexagono.drag-over {
        background-color: #dbeafe;
        border-color: #3b82f6;
        transform: scale(1.05);
    }
    
    .celda-hexagono:hover:not(.ocupada):not([data-fija="true"]) {
        background-color: #e0e7ff;
        border-color: #6366f1;
    }
    
    .celda-hexagono[data-fija="true"] {
        cursor: default;
    }
</style>

