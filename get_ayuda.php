<?php
session_start();

if (!isset($_SESSION['id_estudiante']) && !isset($_SESSION['id_maestro'])) {
    header("Location: login_estudiante.php"); // O redirigir a login_maestro.php
    exit();
}

if (isset($_GET['id_ejercicio']) && isset($_GET['ayuda'])) {
    $id_ejercicio = $_GET['id_ejercicio'];
    $ayuda = $_GET['ayuda'];

    $conn = new mysqli('localhost', 'root', '', 'entornos');
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $sql = "SELECT $ayuda FROM Ejercicios WHERE id_ejercicio = '$id_ejercicio'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode(['success' => true, 'data' => $row[$ayuda]]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No se encontró el ejercicio']);
    }

    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Datos insuficientes']);
}
?>
