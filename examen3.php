<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Editable Textarea</title>
<style>
    .code {
        width: 400px;
        height: 200px;
        white-space: pre-wrap;
    }
</style>
</head>
<body>

<textarea id="code" class="code" placeholder="Escribe tu código aquí">
Hola ¿como haz? estado haciendo ¿la tarea?
</textarea>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Obtener el elemento textarea
    var textarea = document.getElementById("code");
    // Guardar el texto inicial del textarea
    var initialText = textarea.value;

    // Función para obtener los rangos editables del texto
    function getEditableRanges() {
        var ranges = [];
        var text = textarea.value;
        var start = 0;
        // Buscar cada aparición de '¿' en el texto
        while ((start = text.indexOf('¿', start)) !== -1) {
            // Encontrar la siguiente '?'
            var end = text.indexOf('?', start + 1);
            // Si no se encuentra, salir del bucle
            if (end === -1) break;
            // Agregar el rango editable al array de rangos
            ranges.push([start, end + 1]); // Sumamos 1 para incluir '?' en el rango
            // Actualizar la posición de inicio para la próxima búsqueda
            start = end + 1;
        }
        return ranges;
    }

    // Función para verificar si la posición del cursor está dentro de un rango editable
    function isCaretInRange(ranges, caretPosition) {
        // Verificar si la posición del cursor está dentro de alguno de los rangos
        return ranges.some(range => caretPosition >= range[0] && caretPosition <= range[1]);
    }

    // Evento keydown: evitar que se escriba fuera de los rangos editables
    textarea.addEventListener("keydown", function(event) {
        // Obtener la posición del cursor
        var caretPosition = textarea.selectionStart;
        // Obtener los rangos editables del texto
        var ranges = getEditableRanges();

        // Si el cursor no está dentro de un rango editable, prevenir la acción
        if (!isCaretInRange(ranges, caretPosition)) {
            event.preventDefault();
        }
    });

    // Evento input: revertir los cambios si se intenta escribir fuera de los rangos editables
    textarea.addEventListener("input", function(event) {
        // Obtener la posición del cursor
        var caretPosition = textarea.selectionStart;
        // Obtener los rangos editables del texto
        var ranges = getEditableRanges();

        // Si el cursor no está dentro de un rango editable
        if (!isCaretInRange(ranges, caretPosition)) {
            // Revertir el cambio
            textarea.value = initialText;
            // Mover el cursor al final del texto
            textarea.setSelectionRange(initialText.length, initialText.length);
        } else {
            // Si el cursor está dentro de un rango editable, actualizar el texto inicial
            initialText = textarea.value;
        }
    });

    // Evento paste: prevenir la acción de pegar
    textarea.addEventListener("paste", function(event) {
        event.preventDefault();
    });
});
</script>

</body>
</html>
