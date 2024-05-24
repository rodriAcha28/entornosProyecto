<?php
session_start();
if (!isset($_SESSION['id_estudiante'])) {
    header("Location: login_estudiante.php");
    exit();
}

if (isset($_POST['submit'])) {
    $codigo_clase = $_POST['codigo_clase'];
    $id_estudiante = $_SESSION['id_estudiante'];

    $conn = new mysqli('localhost', 'root', '', 'entornos');
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $sql = "SELECT id_clase FROM Clases WHERE codigo_clase = '$codigo_clase'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $id_clase = $result->fetch_assoc()['id_clase'];
        $sql_insert = "INSERT INTO Estudiantes_Clases (id_estudiante, id_clase) VALUES ('$id_estudiante', '$id_clase')";
        if ($conn->query($sql_insert) === TRUE) {
            echo "Te has unido a la clase exitosamente";
        } else {
            echo "Error al unirse a la clase: " . $conn->error;
        }
    } else {
        echo "Código de clase incorrecto";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Unirse a una Clase</title>
</head>
<body>
    <h2>Unirse a una Clase</h2>
    <form action="unirse_clase.php" method="post">
        <label for="codigo_clase">Código de la Clase:</label><br>
        <input type="text" id="codigo_clase" name="codigo_clase" required><br><br>
        <input type="submit" name="submit" value="Unirse">
    </form>
</body>
</html>