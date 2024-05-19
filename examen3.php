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
    var textarea = document.getElementById("code");
    var initialText = textarea.value;

    function getEditableRanges() {
        var ranges = [];
        var start = 0;
        while ((start = textarea.value.indexOf('¿', start)) !== -1) {
            var end = textarea.value.indexOf('?', start + 1);
            if (end === -1) break;
            ranges.push([start + 1, end]);
            start = end + 1;
        }
        return ranges;
    }



    function isCaretInRange(ranges, caretPosition) {
        return ranges.some(range => caretPosition >= range[0] && caretPosition <= range[1]);
    }

    textarea.addEventListener("keydown", function(event) {
        var caretPosition = textarea.selectionStart;
        var ranges = getEditableRanges();

        if (!isCaretInRange(ranges, caretPosition)) {
            event.preventDefault();
        }
    });

    textarea.addEventListener("input", function(event) {
        var caretPosition = textarea.selectionStart;
        var ranges = getEditableRanges();

        if (!isCaretInRange(ranges, caretPosition)) {
            textarea.value = initialText; // Revert the change
            textarea.setSelectionRange(initialText.length, initialText.length); // Move cursor to end
        } else {
            initialText = textarea.value; // Update the initialText to the latest value
        }
    });

    textarea.addEventListener("paste", function(event) {
        event.preventDefault();
    });

    // Set initial caret position to the first editable area
    var ranges = getEditableRanges();
    if (ranges.length > 0) {
        textarea.setSelectionRange(ranges[0][0], ranges[0][0]);
    }
});
</script>

</body>
</html>
