<script>
    let ordenActual = [];

    // Inicializar Sortable.js
    const fuente = document.getElementById('elementos-fuente');
    const destino = document.getElementById('area-ordenamiento');

    Sortable.create(fuente, {
        group: {
            name: 'shared',
            pull: 'clone',
            put: false
        },
        animation: 150,
        sort: false
    });

    Sortable.create(destino, {
        group: 'shared',
        animation: 150,
        onAdd: function(evt) {
            document.getElementById('placeholder-orden').style.display = 'none';
            actualizarOrden();
        },
        onUpdate: function(evt) {
            actualizarOrden();
        },
        onRemove: function(evt) {
            actualizarOrden();
        }
    });

    function actualizarOrden() {
        ordenActual = [];
        const elementos = destino.querySelectorAll('.elemento-draggable');
        elementos.forEach(el => {
            ordenActual.push(el.dataset.id);
        });

        if (ordenActual.length === 0) {
            document.getElementById('placeholder-orden').style.display = 'block';
        }
    }

    function obtenerRespuesta() {
        return ordenActual.length > 0 ? ordenActual : null;
    }

    function deshabilitarInteraccion() {
        Sortable.get(fuente).option('disabled', true);
        Sortable.get(destino).option('disabled', true);
        document.querySelectorAll('.elemento-draggable').forEach(el => {
            el.classList.remove('cursor-move');
            el.classList.add('cursor-not-allowed');
        });
    }
</script>