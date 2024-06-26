<?php
session_start();
if (!isset($_SESSION['id_estudiante'])) {
    echo "Acceso denegado";
    exit();
}

$id_ejercicio = $_POST['id_ejercicio'];
$id_estudiante = $_SESSION['id_estudiante'];
$codigo = $_POST['codigo'];
$resultado = $_POST['resultado'];

$conn = new mysqli('localhost', 'root', '', 'entornos');
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Prepara la consulta
$sql = "INSERT INTO Intentos (id_ejercicio, id_estudiante, codigo, resultado) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiss", $id_ejercicio, $id_estudiante, $codigo, $resultado);

if ($stmt->execute()) {
    echo "Intento guardado";
} else {
    echo "Error al guardar el intento: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>