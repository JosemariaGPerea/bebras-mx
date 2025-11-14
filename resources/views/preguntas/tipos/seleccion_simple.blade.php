
<div class="grid gap-3" id="opciones-container">
    @foreach($pregunta->configuracion['opciones'] as $opcion)
        <button 
            type="button"
            class="opcion-btn bg-white/80 dark:bg-neutral-800/80 backdrop-blur-sm border-2 border-white/40 hover:border-indigo-500 dark:hover:border-indigo-400 rounded-xl p-4 hover:bg-white/90 dark:hover:bg-neutral-800/90 transition-all duration-300 text-left shadow-md hover:shadow-xl transform hover:scale-[1.02] group"
            data-opcion="{{ $opcion['id'] }}"
            onclick="seleccionarOpcion(this)">
            
            @if($opcion['tipo'] === 'imagen')
                <img src="{{ asset('storage/' . $opcion['valor']) }}" 
                     alt="Opción {{ $opcion['id'] }}" 
                     class="max-w-full max-h-32 mx-auto object-contain rounded-lg">
            @else
                <div class="flex items-center gap-3">
                    <span class="font-bold text-lg bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent group-hover:scale-110 transition-transform duration-300">{{ $opcion['id'] }})</span>
                    <span class="text-sm text-neutral-700 dark:text-neutral-300 flex-1">{{ $opcion['valor'] }}</span>
                </div>
            @endif
        </button>
    @endforeach
</div>