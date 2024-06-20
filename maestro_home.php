<?php
session_start();
if (!isset($_SESSION['id_maestro'])) {
    header("Location: login_maestro.php");
    exit();
}

$id_maestro = $_SESSION['id_maestro'];
$conn = new mysqli('localhost', 'root', '', 'entornos');
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT Clases.id_clase, Clases.nombre_clase FROM Clases
        INNER JOIN Maestros_Clases ON Clases.id_clase = Maestros_Clases.id_clase
        WHERE Maestros_Clases.id_maestro = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_maestro);
$stmt->execute();
$result = $stmt->get_result();

$clases = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $clases[] = $row;
    }
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($clases);
?>
