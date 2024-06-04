<?php
session_start();
if (!isset($_SESSION['id_maestro'])) {
    header("Location: login_maestro.php");
    exit();
}

if (isset($_POST['submit'])) {
    $id_clase = $_POST['id_clase'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $ejerciciotexto = $_POST['ejerciciotexto'];
    $ayuda1 = $_POST['ayuda1'];
    $ayuda2 = $_POST['ayuda2'];
    $ayuda3 = $_POST['ayuda3'];
    $ayuda4 = $_POST['ayuda4'];
    $respuesta = $_POST['respuesta'];

    $conn = new mysqli('localhost', 'root', '', 'entornos');
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $sql = "INSERT INTO Ejercicios (id_clase, titulo, descripcion, ejerciciotexto, ayuda1, ayuda2, ayuda3, ayuda4, respuesta) VALUES ('$id_clase', '$titulo', '$descripcion', '$ejerciciotexto', '$ayuda1', '$ayuda2', '$ayuda3', '$ayuda4', '$respuesta')";
    if ($conn->query($sql) === TRUE) {
        echo "Ejercicio subido exitosamente";
    } else {
        echo "Error al subir el ejercicio: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Subir Ejercicio</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        .form-container h2 {
            color: #007BFF;
            text-align: center;
        }

        .form-container label {
            color: #333333;
            font-weight: bold;
        }

        .form-container input[type="text"],
        .form-container textarea {
            width: 100%;
            padding: 10px;
            margin: 5px 0 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .form-container input[type="submit"] {
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        .form-container input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .form-container .success-message,
        .form-container .error-message {
            text-align: center;
            margin-top: 10px;
        }

        .form-container .success-message {
            color: green;
        }

        .form-container .error-message {
            color: red;
        }
    </style>
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
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Subir Ejercicio</h2>
        <?php
        if (isset($_POST['submit'])) {
            if ($conn->query($sql) === TRUE) {
                echo '<p class="success-message">Ejercicio subido exitosamente</p>';
            } else {
                echo '<p class="error-message">Error al subir el ejercicio: ' . $conn->error . '</p>';
            }
        }
        ?>
        <form action="subir_ejercicio.php" method="post">
            <input type="hidden" id="id_clase" name="id_clase" value="<?php echo $_GET['id_clase']; ?>">
            
            <label for="titulo">Título del Ejercicio:</label><br>
            <input type="text" id="titulo" name="titulo" required><br><br>
            
            <label for="descripcion">Descripción:</label><br>
            <textarea id="descripcion" name="descripcion" required></textarea><br><br>
            
            <label for="ejerciciotexto">Ejercicio:</label><br>
            <textarea id="ejerciciotexto" name="ejerciciotexto" required></textarea><br><br>
            
            <label for="ayuda1">Texto de Ayuda para Segundo Intento:</label><br>
            <textarea id="ayuda1" name="ayuda1"></textarea><br><br>
        </div>
        <div class="form-container">
            
            <label for="ayuda2">Texto de Ayuda para Tercero Intento:</label><br>
            <textarea id="ayuda2" name="ayuda2"></textarea><br><br>

            <label for="ayuda3">Texto de Ayuda para Cuarto Intento:</label><br>
            <textarea id="ayuda3" name="ayuda3"></textarea><br><br>
            
            <label for="ayuda4">Texto de Ayuda para Quinto Intento:</label><br>
            <textarea id="ayuda4" name="ayuda4"></textarea><br><br>
            
            <label for="respuesta">Respuesta Correcta:</label><br>
            <textarea id="respuesta" name="respuesta"></textarea><br><br>
            
            <input type="submit" name="submit" value="Subir Ejercicio">
        </form>
        <button id="showAnswerBtn" onclick="document.getElementById('myModal').style.display='block'" style="bottom: 10px; right: 10px;">Indicaciones</button>
    </div>
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="document.getElementById('myModal').style.display='none'">&times;</span>
            <p>Las partes que quiere que el estudiante deba editar deben estar marcadas con <span class="highlight">????</span>. Para que el estudiante pueda identificar correctamente que partes modificar.</p>
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
