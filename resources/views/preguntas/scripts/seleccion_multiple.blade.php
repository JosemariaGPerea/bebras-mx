<script>
    function obtenerRespuesta() {
        const checkboxes = document.querySelectorAll('input[name="opciones[]"]:checked');
        const respuesta = Array.from(checkboxes).map(cb => cb.value);
        return respuesta.length > 0 ? respuesta : null;
    }

    function deshabilitarInteraccion() {
        document.querySelectorAll('input[name="opciones[]"]').forEach(cb => {
            cb.disabled = true;
            cb.parentElement.classList.add('opacity-50', 'cursor-not-allowed');
        });
    }
</script>