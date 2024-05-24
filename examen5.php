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
            <span class="navbar-title">Curso</span>
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
            <textarea id="code" class="code" placeholder="">
            <?php
                // Conexión a la base de datos
                $servername = "localhost"; // Nombre del servidor (usualmente localhost)
                $username = "root"; // Nombre de usuario de la base de datos
                $password = ""; // Contraseña de la base de datos
                $database = "entornos"; // Nombre de la base de datos

                // Crear conexión
                $conn = new mysqli($servername, $username, $password, $database);

                // Verificar la conexión
                if ($conn->connect_error) {
                    die("Error de conexión: " . $conn->connect_error);
                }

                // Consulta SQL para obtener el texto del ejercicio con id_ejercicio=1
                $sql = "SELECT ejerciciotexto FROM ejercicios WHERE id_ejercicio = 1";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        $ejercicio_texto = $row["ejerciciotexto"];
                    }
                } else {
                    $ejercicio_texto = "No se encontraron ejercicios con el ID especificado.";
                }

                // Cerrar conexión
                $conn->close();
            ?>
            <?php echo $ejercicio_texto; ?></textarea>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    var textarea = document.getElementById("code");
                    var initialText = textarea.value;

                    // Establecer el cursor al final del texto
                    textarea.focus();
                    textarea.setSelectionRange(initialText.indexOf("*"), initialText.indexOf("*") + 8);

                    // Capturar eventos de teclado
                    textarea.addEventListener("keydown", function(event) {
                        var caretPosition = textarea.selectionStart;

                        // Si la tecla presionada está dentro de los asteriscos, permitir la edición
                        if (caretPosition >= initialText.indexOf("*") && caretPosition < initialText.indexOf("*") + 22) {
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
            <button id="botonEjecutar" onclick="runCode()">Ejecutar</button>
            </div>
            <div id="output"></div>
            <script src="script.js"></script>
        </div>
    </div>
</body>
</html>
