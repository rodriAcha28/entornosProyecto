<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modulo 1: Fundamentos PHP</title>
    <link rel="stylesheet" href="modulos.css">
    <link rel="stylesheet" href="examen.css">
    <link rel="stylesheet" href="index.css">
    <style>
        /* Estilo para el modal */
        .modal {
            display: none; 
            position: fixed; 
            z-index: 1; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgb(0,0,0); 
            background-color: rgba(0,0,0,0.4); 
            padding-top: 60px; 
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
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
            <button id="showAnswerBtn" onclick="document.getElementById('myModal').style.display='block'" style="bottom: 10px; right: 10px;">Mostrar respuesta</button>
            <br>
            <br>
            <br>
            <br>
            <p>La respuesta correcta es: Hola</p>
        </div>
        <div class="fundamento">
            <div class="editor">
                <textarea id="code" class="code" placeholder="Escribe tu código aquí">
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
                        textarea.setSelectionRange(initialText.indexOf("?"), initialText.indexOf("*") + 4);

                        // Capturar eventos de teclado
                        textarea.addEventListener("keydown", function(event) {
                            var caretPosition = textarea.selectionStart;

                            // Si la tecla presionada está dentro de los asteriscos, permitir la edición
                            if (caretPosition >= initialText.indexOf("?") && caretPosition < initialText.indexOf("?") + 4) {
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

                    function runCode() {
                        // Aquí puedes agregar la lógica para ejecutar el código si es necesario
                        // Por ahora, simplemente actualiza el área de salida (si se necesita)
                        document.getElementById('output').innerText = "Código ejecutado";
                    }
                </script>
                <button id="botonEjecutar" onclick="runCode()">Ejecutar</button>
            </div>
            <div id="output"></div>
            <script src="script.js"></script>
        </div>
    </div>

    <!-- Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="document.getElementById('myModal').style.display='none'">&times;</span>
            <p>La respuesta correcta es: <?php echo "Hola"; ?></p>
        </div>
    </div>

    <script>
        // Para cerrar el modal cuando el usuario haga clic fuera del contenido
        window.onclick = function(event) {
            var modal = document.getElementById('myModal');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
