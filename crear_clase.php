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

    // Inserción de la clase en la tabla Clases usando prepared statements
    $sql = "INSERT INTO Clases (nombre_clase, codigo_clase) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nombre_clase, $codigo_clase);

    if ($stmt->execute()) {
        $id_clase = $conn->insert_id;
        // Asignación de la clase al maestro en la tabla Maestros_Clases usando prepared statements
        $sql_assign = "INSERT INTO Maestros_Clases (id_maestro, id_clase) VALUES (?, ?)";
        $stmt_assign = $conn->prepare($sql_assign);
        $stmt_assign->bind_param("ii", $id_maestro, $id_clase);

        if ($stmt_assign->execute()) {
            echo "Clase creada exitosamente. Código de la clase: " . $codigo_clase;
        } else {
            echo "Error al asignar la clase: " . $stmt_assign->error;
        }
        $stmt_assign->close();
    } else {
        echo "Error al crear la clase: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
