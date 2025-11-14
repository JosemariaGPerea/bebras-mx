
<div class="grid md:grid-cols-2 gap-8">
    {{-- Objetos --}}
    <div>
        <h4 class="font-semibold text-gray-700 mb-4">Objetos:</h4>
        <div class="space-y-3">
            @foreach($pregunta->configuracion['objetos'] as $objeto)
                <div class="flex items-center gap-3">
                    <img src="{{ asset('storage/' . $objeto['imagen']) }}" 
                         alt="{{ $objeto['nombre'] }}" 
                         class="w-16 h-16 object-contain">
                    <span class="font-medium">{{ $objeto['nombre'] }}</span>
                    <select 
                        class="ml-auto border-2 border-gray-300 rounded-lg px-3 py-2 emparejamiento"
                        data-objeto="{{ $objeto['id'] }}">
                        <option value="">Selecciona...</option>
                        @foreach($pregunta->configuracion['destinos'] as $destino)
                            <option value="{{ $destino['id'] }}">{{ $destino['nombre'] }}</option>
                        @endforeach
                    </select>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Destinos (visual) --}}
    <div>
        <h4 class="font-semibold text-gray-700 mb-4">Destinos:</h4>
        <div class="space-y-3">
            @foreach($pregunta->configuracion['destinos'] as $destino)
                <div class="p-4 bg-gray-100 border-2 border-gray-300 rounded-lg">
                    <span class="font-bold text-lg">{{ $destino['nombre'] }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>