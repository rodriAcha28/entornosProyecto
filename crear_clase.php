<?php
session_start();
if (!isset($_SESSION['id_maestro'])) {
    header("Location: login_maestro.php");
    exit();
}

if (isset($_POST['submit'])) {
    $nombre_clase = $_POST['nombre_clase'];
    $codigo_clase = uniqid();
    $id_maestro = $_SESSION['id_maestro'];

    $conn = new mysqli('localhost', 'root', '', 'entornos');
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $sql = "INSERT INTO Clases (nombre_clase, codigo_clase) VALUES ('$nombre_clase', '$codigo_clase')";
    if ($conn->query($sql) === TRUE) {
        $id_clase = $conn->insert_id;
        $sql_assign = "INSERT INTO Maestros_Clases (id_maestro, id_clase) VALUES ('$id_maestro', '$id_clase')";
        if ($conn->query($sql_assign) === TRUE) {
            echo "Clase creada exitosamente. Código de la clase: " . $codigo_clase;
        } else {
            echo "Error al asignar la clase: " . $conn->error;
        }
    } else {
        echo "Error al crear la clase: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Clase</title>
</head>
<body>
    <h2>Crear Clase</h2>
    <form action="crear_clase.php" method="post">
        <label for="nombre_clase">Nombre de la Clase:</label><br>
        <input type="text" id="nombre_clase" name="nombre_clase" required><br><br>
        <input type="submit" name="submit" value="Crear Clase">
    </form>
</body>
</html>
