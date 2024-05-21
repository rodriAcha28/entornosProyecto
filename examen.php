<?php
session_start();
if (!isset($_SESSION['id_estudiante']) && !isset($_SESSION['id_maestro'])) {
    header("Location: login_estudiante.php"); // O redirigir a login_maestro.php
    exit();
}

$id_ejercicio = $_GET['id_ejercicio'];
$conn = new mysqli('localhost', 'root', '', 'entornos');
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql_ejercicio = "SELECT * FROM Ejercicios WHERE id_ejercicio = '$id_ejercicio'";
$result_ejercicio = $conn->query($sql_ejercicio);
$ejercicio = $result_ejercicio->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($ejercicio['titulo']); ?></title>
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
            <a href="#" class="navbar-login"></a>
        </div>
    </nav>

    <div class="pastel-blue">
        <button class="arrow-button">&lt;&lt;</button>
        <span class="content-title2"><?php echo htmlspecialchars($ejercicio['titulo']); ?></span>
        <button onclick="window.location.href = 'modulo1-2.html';" class="arrow-button">&gt;&gt;</button>
    </div>
    <div class="fundamentos">
        <div class="fundamento">
            <?php echo nl2br(htmlspecialchars($ejercicio['descripcion'])); ?>
        </div>
        <div class="fundamento">
            <div class="editor">
                <textarea id="code" class="code" placeholder="Escribe tu código aquí"><?php echo htmlspecialchars($ejercicio['ejerciciotexto']); ?></textarea>
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

                    function runCode() {
                        var code = document.getElementById('code').value;
                        var outputDiv = document.getElementById('output');
                        outputDiv.innerHTML = ''; // Clear previous output

                        // Run the code (This is a placeholder for actual code execution logic)
                        try {
                            // Simulate code execution
                            var result = eval(code);
                            outputDiv.innerHTML = result;

                            // Save the attempt via AJAX
                            saveAttempt(code, result);
                        } catch (e) {
                            outputDiv.innerHTML = 'Error: ' + e.message;

                            // Save the attempt with error message
                            saveAttempt(code, 'Error: ' + e.message);
                        }
                    }

                    function saveAttempt(code, result) {
                        var xhr = new XMLHttpRequest();
                        xhr.open('POST', 'guardar_intento.php', true);
                        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState == 4 && xhr.status == 200) {
                                console.log('Intento guardado');
                            }
                        };
                        xhr.send('id_ejercicio=<?php echo $id_ejercicio; ?>&codigo=' + encodeURIComponent(code) + '&resultado=' + encodeURIComponent(result));
                    }
                </script>
                <button id="botonEjecutar" onclick="runCode()">Ejecutar</button>
            </div>
            <div id="output"></div>
            <script src="script.js"></script>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
