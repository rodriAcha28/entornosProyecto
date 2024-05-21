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

$sql = "INSERT INTO Intentos (id_ejercicio, id_estudiante, codigo, resultado) VALUES ('$id_ejercicio', '$id_estudiante', '$codigo', '$resultado')";
if ($conn->query($sql) === TRUE) {
    echo "Intento guardado";
} else {
    echo "Error al guardar el intento: " . $conn->error;
}

$conn->close();
?>
