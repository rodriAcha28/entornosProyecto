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
    <style>
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
            padding: 30px;
            border: 1px solid #888;
            width: 40%;
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
        .highlight {
            color: red;
            font-weight: bold;
        }
        .dynamic-button {
            display: none;
            margin: 10px;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
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
        <a href="logout.php" class="navbar-login">Cerrar Sesión</a>
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
            <br>
            <br>
            <br>
            <button id="showAnswerBtn" onclick="document.getElementById('myModal').style.display='block'" style="bottom: 10px; right: 10px;">Indicaciones</button>
            <br>
            <button id="boton1" class="dynamic-button" onclick="openModal('ayuda1')">Primera Ayuda</button>
            <button id="boton2" class="dynamic-button" onclick="openModal('ayuda2')">Segunda Ayuda</button>
            <button id="boton3" class="dynamic-button" onclick="openModal('ayuda3')">Tercera Ayuda</button>
            <button id="boton4" class="dynamic-button" onclick="openModal('ayuda4')">Cuarta Ayuda</button>
        </div>
        <div class="fundamento">
            <div class="editor">
                <textarea id="code" class="code" placeholder="Escribe tu código aquí"><?php echo htmlspecialchars($ejercicio['ejerciciotexto']); ?></textarea>
                
                <button id="botonEjecutar" onclick="handleButtonClick()">Ejecutar</button>
            </div>
            <div id="output"></div>
            <script src="script.js"></script>
        </div>
    </div>
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <p id="modalText">Querido estudiante, a continuación encontrarás un fragmento de código. Tu tarea es editar solo las partes que están marcadas con <span class="highlight">????</span>. Asegúrate de no modificar otras partes del código para evitar errores. Las secciones que debes editar están resaltadas en negrita y rojo para tu conveniencia.</p>
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

        let clickCount = 0;

        function handleButtonClick() {
            runCode();

            clickCount++;

            // Ocultar todos los botones
            document.getElementById('boton1').style.display = 'none';
            document.getElementById('boton2').style.display = 'none';
            document.getElementById('boton3').style.display = 'none';
            document.getElementById('boton4').style.display = 'none';

            // Mostrar el botón correspondiente según la cantidad de clics
            switch(clickCount) {
                case 1:
                    document.getElementById('boton1').style.display = 'block';
                    break;
                case 2:
                    document.getElementById('boton2').style.display = 'block';
                    break;
                case 3:
                    document.getElementById('boton3').style.display = 'block';
                    break;
                case 4:
                    document.getElementById('boton4').style.display = 'block';
                    clickCount = 0; // Reiniciar el contador para que el ciclo comience de nuevo
                    break;
                default:
                    clickCount = 0; // Reiniciar el contador si es mayor que 4
                    break;
            }
        }

        function runCode() {
            const code = document.getElementById('code').value;

            // Realiza la solicitud AJAX al servidor
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'run_code.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    const response = JSON.parse(xhr.responseText);
                    document.getElementById('output').innerText = response.output; // Muestra el resultado en el div
                    if (response.success) {
                        alert('¡Examen correcto!');
                    } else {
                        alert('La respuesta no es correcta. Inténtalo de nuevo.');
                    }
                }
            };
            xhr.send('code=' + encodeURIComponent(code) + '&id_ejercicio=' + <?php echo $id_ejercicio; ?>);
        }

        function openModal(ayuda) {
            const idEjercicio = <?php echo $id_ejercicio; ?>;

            const xhr = new XMLHttpRequest();
            xhr.open('GET', `get_ayuda.php?id_ejercicio=${idEjercicio}&ayuda=${ayuda}`, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        document.getElementById('modalText').innerText = response.data;
                        document.getElementById('myModal').style.display = 'block';
                    } else {
                        alert('No se pudo obtener la ayuda.');
                    }
                }
            };
            xhr.send();
        }

        function closeModal() {
            document.getElementById('myModal').style.display = 'none';
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>
