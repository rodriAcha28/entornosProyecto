<?php
$conn = new mysqli('localhost', 'root', '', 'entornos');
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$id_ejercicio = 1; // Cambia esto por un ID de ejercicio válido
$id_estudiante = 1; // Cambia esto por un ID de estudiante válido
$codigo = "echo 'Hola Mundo';";
$resultado = "Hola Mundo";

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
