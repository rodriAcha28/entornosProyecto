<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Texto Editable</title>
    <style>
        textarea {
            width: 100%;
            height: 150px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <textarea id="editableTextarea"></textarea>

    <script>
        const textarea = document.getElementById('editableTextarea');

        // Simular obtener el texto dinámico de una base de datos
        let dynamicText = "Hola Juan <edit>????</edit> y cómo estás <edit>????</edit>";

        // Establecer el texto dinámico en el textarea
        textarea.value = dynamicText;

        textarea.addEventListener('input', (event) => {
            const value = textarea.value;
            const editableRanges = getEditableRanges(dynamicText);
            const newValue = enforceEditableRanges(value, editableRanges);
            textarea.value = newValue;
        });

        textarea.addEventListener('keydown', (event) => {
            const cursorPosition = textarea.selectionStart;
            const editableRanges = getEditableRanges(dynamicText);

            if (!isCursorInEditableRange(cursorPosition, editableRanges)) {
                event.preventDefault();
                moveCursorToEditableRange(cursorPosition, editableRanges);
            }
        });

        function getEditableRanges(text) {
            const ranges = [];
            const regex = /<edit>(.*?)<\/edit>/g;
            let match;

            while ((match = regex.exec(text)) !== null) {
                const start = match.index + 6; // Start index of editable content
                const end = start + match[1].length; // End index of editable content
                ranges.push([start, end]);
            }

            return ranges;
        }

        function enforceEditableRanges(value, ranges) {
            let enforcedValue = '';
            let lastIndex = 0;

            for (let i = 0; i < ranges.length; i++) {
                const [start, end] = ranges[i];
                enforcedValue += dynamicText.slice(lastIndex, start);
                enforcedValue += value.slice(start, end);
                lastIndex = end;
            }

            enforcedValue += dynamicText.slice(lastIndex);
            return enforcedValue;
        }

        function isCursorInEditableRange(cursorPosition, ranges) {
            for (let i = 0; i < ranges.length; i++) {
                const [start, end] = ranges[i];
                if (cursorPosition >= start && cursorPosition <= end) {
                    return true;
                }
            }
            return false;
        }

        function moveCursorToEditableRange(cursorPosition, ranges) {
            for (let i = 0; i < ranges.length; i++) {
                const [start, end] = ranges[i];
                if (cursorPosition < start) {
                    textarea.setSelectionRange(start, start);
                    return;
                } else if (cursorPosition > end) {
                    textarea.setSelectionRange(end, end);
                    return;
                }
            }
        }
    </script>
</body>
</html>
