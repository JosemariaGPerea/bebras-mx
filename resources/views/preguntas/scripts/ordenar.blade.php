<script>
    let ordenActual = [];

    // Inicializar Sortable.js
    const fuente = document.getElementById('elementos-fuente');
    const destino = document.getElementById('area-ordenamiento');

    // Configuración para la fuente: permite mover elementos (no clonar)
    Sortable.create(fuente, {
        group: {
            name: 'shared',
            pull: true,  // Mover en lugar de clonar
            put: true    // Permitir regresar elementos
        },
        animation: 150,
        sort: false,     // No permitir ordenar en la fuente
        onAdd: function(evt) {
            // Cuando un elemento regresa a la fuente
            actualizarOrden();
        },
        onRemove: function(evt) {
            // Cuando un elemento sale de la fuente
            actualizarOrden();
        }
    });

    // Configuración para el destino: permite recibir y ordenar elementos
    Sortable.create(destino, {
        group: 'shared',
        animation: 150,
        onAdd: function(evt) {
            // Cuando se agrega un elemento al destino
            document.getElementById('placeholder-orden').style.display = 'none';
            actualizarOrden();
            actualizarFuente();
        },
        onUpdate: function(evt) {
            // Cuando se reordena en el destino
            actualizarOrden();
        },
        onRemove: function(evt) {
            // Cuando se remueve un elemento del destino (regresa a fuente)
            actualizarOrden();
            actualizarFuente();
            
            // Mostrar placeholder si no hay elementos
            if (destino.querySelectorAll('.elemento-draggable').length === 0) {
                document.getElementById('placeholder-orden').style.display = 'block';
            }
        }
    });

    function actualizarOrden() {
        ordenActual = [];
        const elementos = destino.querySelectorAll('.elemento-draggable');
        elementos.forEach(el => {
            ordenActual.push(el.dataset.id);
        });

        if (ordenActual.length === 0) {
            const placeholder = document.getElementById('placeholder-orden');
            if (placeholder) {
                placeholder.style.display = 'block';
            }
        }
    }

    function actualizarFuente() {
        // Actualizar contador de elementos en fuente
        const elementosEnFuente = fuente.querySelectorAll('.elemento-draggable');
        const contadorFuente = document.getElementById('contador-fuente');
        if (contadorFuente) {
            contadorFuente.textContent = `(${elementosEnFuente.length})`;
        }
        
        // Actualizar contador de elementos en destino
        const elementosEnDestino = destino.querySelectorAll('.elemento-draggable');
        const contadorDestino = document.getElementById('contador-destino');
        if (contadorDestino) {
            contadorDestino.textContent = `(${elementosEnDestino.length})`;
        }
        
        if (elementosEnFuente.length === 0) {
            // Mostrar mensaje si no hay más elementos
            const mensaje = fuente.querySelector('.mensaje-vacio');
            if (!mensaje) {
                const msg = document.createElement('p');
                msg.className = 'mensaje-vacio text-gray-400 text-center py-4 italic';
                msg.textContent = 'Todos los elementos han sido movidos';
                fuente.appendChild(msg);
            }
        } else {
            // Remover mensaje si hay elementos
            const mensaje = fuente.querySelector('.mensaje-vacio');
            if (mensaje) {
                mensaje.remove();
            }
        }
    }

    function obtenerRespuesta() {
        return ordenActual.length > 0 ? ordenActual : null;
    }

    function deshabilitarInteraccion() {
        if (Sortable.get(fuente)) {
            Sortable.get(fuente).option('disabled', true);
        }
        if (Sortable.get(destino)) {
            Sortable.get(destino).option('disabled', true);
        }
        document.querySelectorAll('.elemento-draggable').forEach(el => {
            el.classList.remove('cursor-move');
            el.classList.add('cursor-not-allowed', 'opacity-75');
        });
    }

    // Inicializar estado
    actualizarFuente();
</script>