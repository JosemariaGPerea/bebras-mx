
<div class="grid md:grid-cols-2 gap-6">
    {{-- Elementos desordenados --}}
    <div>
        <h4 class="font-semibold text-gray-700 mb-3">Elementos disponibles:</h4>
        <div id="elementos-fuente" class="bg-gray-100 border-2 border-dashed border-gray-300 rounded-lg p-4 min-h-[200px]">
            @foreach($pregunta->configuracion['elementos'] as $elemento)
                <div class="elemento-draggable bg-white border-2 border-gray-300 rounded-lg p-3 mb-2 cursor-move hover:shadow-lg transition-shadow"
                     data-id="{{ $elemento['id'] }}">
                    @if(isset($elemento['imagen']))
                        <img src="{{ asset('storage/' . $elemento['imagen']) }}" alt="{{ $elemento['id'] }}" class="full w-auto h-16 object-contain mb-2">
                    @else
                        <span class="font-medium">{{ $elemento['nombre'] ?? $elemento['id'] }}</span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    {{-- Área de ordenamiento --}}
    <div>
        <h4 class="font-semibold text-gray-700 mb-3">Arrastra aquí en el orden correcto:</h4>
        <div id="area-ordenamiento" class="bg-blue-50 border-2 border-dashed border-blue-300 rounded-lg p-4 min-h-[200px]">
            <p class="text-gray-400 text-center py-8" id="placeholder-orden">Arrastra los elementos aquí</p>
        </div>
    </div>
</div>

@if(isset($pregunta->configuracion['mostrar_numeros']) && $pregunta->configuracion['mostrar_numeros'])
    <p class="text-sm text-gray-600 mt-3">Pist a: Puedes ponerles números del 1 al {{ count($pregunta->configuracion['elementos']) }}</p>
@endif