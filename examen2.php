<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modulo 1: Fundamentos PHP</title>
    <link rel="stylesheet" href="modulos.css">
    <link rel="stylesheet" href="examen.css">
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-left">
            <span class="navbar-title">Curso PHP</span>
        </div>
        <div class="navbar-center">
            <a href="#" class="navbar-link">Inicio</a>
            <a href="#" class="navbar-link">Lecciones</a>
            <a href="#" class="navbar-link">Recursos</a>
        </div>
        <div class="navbar-right">
            <a href="#" class="navbar-login">Iniciar sesión</a>
        </div>
    </nav>

    <div class="pastel-blue">
        <button class="arrow-button">&lt;&lt;</button>
        <span class="content-title2">Modulo 1: Fundamentos PHP</span>
        <button onclick="window.location.href = 'modulo1-2.html';" class="arrow-button">&gt;&gt;</button>
    </div>

    <div class="fundamentos">
        <div class="fundamento">
            <p>Prueba 1:</p>
            <p>Realice la impresión del texto Hola en php</p>
            <p>Apoyo: utilice la función "echo" y las etiquetas al inicio y al final del código de php no hace falta colocarlas</p>
        </div>
        <div class="fundamento">
            <div class="editor">
            <textarea id="code" class="code" placeholder="Escribe tu código aquí">
            echo "****";
            </textarea>
            <script>
            document.addEventListener("DOMContentLoaded", function() {
                var textarea = document.getElementById("code");

                // Guarda el texto inicial
                var initialText = textarea.value;

                // Establece el cursor al final del texto
                textarea.focus();
                textarea.setSelectionRange(initialText.length, initialText.length);

                // Captura los eventos de teclado
                textarea.addEventListener("input", function() {
                    var caretPosition = textarea.selectionStart;

                    // Restablece el texto si se intenta editar fuera del área designada
                    if (caretPosition < initialText.length) {
                        textarea.value = initialText;
                        textarea.setSelectionRange(initialText.length, initialText.length);
                    }
                });

                // Captura el evento de pegado
                textarea.addEventListener("paste", function(event) {
                    event.preventDefault();
                });
            });
            </script>
            <button id="botonEjecutar" onclick="runCode()">Ejecutar</button>
            </div>
            <div id="output"></div>
            <script src="script.js"></script>
            
        </div>
    </div>
</body>
</html>
