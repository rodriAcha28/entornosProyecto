<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Editable Textarea</title>
<style>
    .code {
        width: 300px;
        height: 200px;
    }
</style>
</head>
<body>

<textarea id="code" class="code" placeholder="Escribe tu código aquí">
echo "****";
</textarea>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var textarea = document.getElementById("code");
    var initialText = textarea.value;

    // Establecer el cursor al final del texto
    textarea.focus();
    textarea.setSelectionRange(initialText.indexOf("*"), initialText.indexOf("*") + 4);

    // Capturar eventos de teclado
    textarea.addEventListener("keydown", function(event) {
        var caretPosition = textarea.selectionStart;

        // Si la tecla presionada está dentro de los asteriscos, permitir la edición
        if (caretPosition >= initialText.indexOf("*") && caretPosition < initialText.indexOf("*") + 4) {
            textarea.removeAttribute("readonly");
        } else {
            textarea.setAttribute("readonly", true);
        }
    });

    // Capturar el evento de pegado y evitar que se modifique el contenido
    textarea.addEventListener("paste", function(event) {
        event.preventDefault();
    });
});
</script>

</body>
</html>
