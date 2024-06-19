<?php
session_start();
if (!isset($_SESSION['id_estudiante']) && !isset($_SESSION['id_maestro'])) {
    header("Location: login_estudiante.php"); // O redirigir a login_maestro.php
    exit();
}

$id_ejercicio = $_GET['id_ejercicio'];
$conn = new mysqli('localhost', 'root', '', 'entornos');
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql_ejercicio = "SELECT * FROM Ejercicios WHERE id_ejercicio = ?";
$stmt_ejercicio = $conn->prepare($sql_ejercicio);
$stmt_ejercicio->bind_param("i", $id_ejercicio);
$stmt_ejercicio->execute();
$result_ejercicio = $stmt_ejercicio->get_result();
$ejercicio = $result_ejercicio->fetch_assoc();

$response = [
    'titulo' => htmlspecialchars($ejercicio['titulo']),
    'descripcion' => nl2br(htmlspecialchars($ejercicio['descripcion'])),
    'ejerciciotexto' => htmlspecialchars($ejercicio['ejerciciotexto'])
];

header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>
