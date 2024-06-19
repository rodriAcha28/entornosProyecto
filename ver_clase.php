<?php
session_start();
if (!isset($_SESSION['id_estudiante']) && !isset($_SESSION['id_maestro'])) {
    header("Location: login_estudiante.php"); // O redirigir a login_maestro.php
    exit();
}

$id_clase = $_GET['id_clase'];
$conn = new mysqli('localhost', 'root', '', 'entornos');
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql_clase = "SELECT * FROM Clases WHERE id_clase = ?";
$stmt_clase = $conn->prepare($sql_clase);
$stmt_clase->bind_param("i", $id_clase);
$stmt_clase->execute();
$result_clase = $stmt_clase->get_result();
$clase = $result_clase->fetch_assoc();

$sql_estudiantes = "SELECT Estudiantes.nombre, Estudiantes.apellido FROM Estudiantes
                    INNER JOIN Estudiantes_Clases ON Estudiantes.id_estudiante = Estudiantes_Clases.id_estudiante
                    WHERE Estudiantes_Clases.id_clase = ?";
$stmt_estudiantes = $conn->prepare($sql_estudiantes);
$stmt_estudiantes->bind_param("i", $id_clase);
$stmt_estudiantes->execute();
$result_estudiantes = $stmt_estudiantes->get_result();

$estudiantes = [];
while ($row = $result_estudiantes->fetch_assoc()) {
    $estudiantes[] = $row;
}

$sql_ejercicios = "SELECT * FROM Ejercicios WHERE id_clase = ?";
$stmt_ejercicios = $conn->prepare($sql_ejercicios);
$stmt_ejercicios->bind_param("i", $id_clase);
$stmt_ejercicios->execute();
$result_ejercicios = $stmt_ejercicios->get_result();

$ejercicios = [];
while ($row = $result_ejercicios->fetch_assoc()) {
    $ejercicios[] = $row;
}

$response = [
    'clase' => $clase,
    'estudiantes' => $estudiantes,
    'ejercicios' => $ejercicios,
    'maestro' => isset($_SESSION['id_maestro'])
];

$stmt_clase->close();
$stmt_estudiantes->close();
$stmt_ejercicios->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>
