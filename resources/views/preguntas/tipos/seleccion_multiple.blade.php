
<div class="space-y-3">
    @foreach($pregunta->configuracion['opciones'] as $opcion)
        <label class="flex items-center p-4 border-2 border-gray-300 rounded-lg hover:bg-blue-50 hover:border-blue-500 cursor-pointer transition-all">
            <input 
                type="checkbox" 
                name="opciones[]" 
                value="{{ $opcion['id'] }}"
                class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500 mr-3">
            <span class="flex-1 text-lg">
                <span class="font-bold text-blue-600 mr-2">{{ $opcion['id'] }})</span>
                {{ $opcion['valor'] }}
            </span>
        </label>
    @endforeach
</div>

@if(isset($pregunta->configuracion['nota']))
    <p class="text-sm text-gray-600 mt-4 italic">ℹ️ {{ $pregunta->configuracion['nota'] }}</p>
@endif