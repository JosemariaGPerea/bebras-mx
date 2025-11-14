
<div class="grid gap-4" id="opciones-container">
    @foreach($pregunta->configuracion['opciones'] as $opcion)
        <button 
            type="button"
            class="opcion-btn border-3 border-gray-300 rounded-lg p-4 hover:border-blue-500 hover:bg-blue-50 transition-all text-left"
            data-opcion="{{ $opcion['id'] }}"
            onclick="seleccionarOpcion(this)">
            
            @if($opcion['tipo'] === 'imagen')
                <img src="{{ asset('storage/' . $opcion['valor']) }}" 
                     alt="Opción {{ $opcion['id'] }}" 
                     class="max-w-full mx-auto">
            @else
                <div class="text-lg">
                    <span class="font-bold text-blue-600 mr-2">{{ $opcion['id'] }})</span>
                    {{ $opcion['valor'] }}
                </div>
            @endif
        </button>
    @endforeach
</div>