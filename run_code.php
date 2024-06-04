<?php
session_start();
if (!isset($_SESSION['id_estudiante']) && !isset($_SESSION['id_maestro'])) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit();
}

$id_ejercicio = $_POST['id_ejercicio'];
$code = $_POST['code'];

$conn = new mysqli('localhost', 'root', '', 'entornos');
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Conexión fallida: ' . $conn->connect_error]);
    exit();
}

$sql_ejercicio = "SELECT respuesta FROM Ejercicios WHERE id_ejercicio = '$id_ejercicio'";
$result_ejercicio = $conn->query($sql_ejercicio);
$ejercicio = $result_ejercicio->fetch_assoc();

$respuesta_correcta = $ejercicio['respuesta'];

// Ejecutar el código PHP de manera segura
// Aquí solo un ejemplo básico, se recomienda usar sandboxing o contenedores para mayor seguridad
ob_start();
eval($code);
$output = ob_get_clean();

$conn->close();

if (trim($output) === trim($respuesta_correcta)) {
    echo json_encode(['success' => true, 'output' => $output]);
} else {
    echo json_encode(['success' => false, 'output' => $output]);
}
?>
