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

    $sql = "SELECT id_clase FROM Clases WHERE codigo_clase = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $codigo_clase);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $id_clase = $result->fetch_assoc()['id_clase'];
        $sql_insert = "INSERT INTO Estudiantes_Clases (id_estudiante, id_clase) VALUES (?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("ii", $id_estudiante, $id_clase);

        if ($stmt_insert->execute() === TRUE) {
            echo "Te has unido a la clase exitosamente";
        } else {
            echo "Error al unirse a la clase: " . $conn->error;
        }

        $stmt_insert->close();
    } else {
        echo "Código de clase incorrecto";
    }

    $stmt->close();
    $conn->close();
}
?>
