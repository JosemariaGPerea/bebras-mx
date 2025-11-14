
<div class="max-w-md mx-auto">
    @if(isset($pregunta->configuracion['tipo_respuesta']) && $pregunta->configuracion['tipo_respuesta'] === 'numero')
        <label class="block mb-2 font-medium text-gray-700">Ingresa tu respuesta (número):</label>
        <input 
            type="number" 
            id="respuesta-numero"
            min="{{ $pregunta->configuracion['min'] ?? 0 }}"
            max="{{ $pregunta->configuracion['max'] ?? 999 }}"
            class="w-full px-4 py-3 text-2xl text-center border-3 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
            placeholder="0">
    @else
        <label class="block mb-2 font-medium text-gray-700">Ingresa tu respuesta:</label>
        <textarea 
            id="respuesta-texto"
            rows="4"
            class="w-full px-4 py-3 border-3 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
            placeholder="Escribe tu respuesta aquí..."></textarea>
    @endif
</div>