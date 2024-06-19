<?php
session_start();
if (!isset($_SESSION['id_estudiante'])) {
    header("Location: login_estudiante.php");
    exit();
}

$id_estudiante = $_SESSION['id_estudiante'];
$conn = new mysqli('localhost', 'root', '', 'entornos');
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT Clases.id_clase, Clases.nombre_clase FROM Clases
        INNER JOIN Estudiantes_Clases ON Clases.id_clase = Estudiantes_Clases.id_clase
        WHERE Estudiantes_Clases.id_estudiante = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_estudiante);
$stmt->execute();
$result = $stmt->get_result();

$clases = array();
while ($row = $result->fetch_assoc()) {
    $clases[] = $row;
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($clases);
?>
