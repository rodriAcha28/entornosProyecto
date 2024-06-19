<?php
session_start();
if (!isset($_SESSION['id_maestro'])) {
    header("Location: login_maestro.php");
    exit();
}

$id_clase = $_GET['id_clase'];
$conn = new mysqli('localhost', 'root', '', 'entornos');
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener información de la clase
$sql_clase = "SELECT * FROM Clases WHERE id_clase = ?";
$stmt_clase = $conn->prepare($sql_clase);
$stmt_clase->bind_param("i", $id_clase);
$stmt_clase->execute();
$result_clase = $stmt_clase->get_result();
$clase = $result_clase->fetch_assoc();

// Obtener intentos de los estudiantes
$sql_intentos = "SELECT 
                    Intentos.id_intento,
                    Intentos.id_ejercicio,
                    Intentos.id_estudiante,
                    Intentos.codigo,
                    Intentos.resultado,
                    Intentos.fecha,
                    Estudiantes.nombre,
                    Estudiantes.apellido,
                    Ejercicios.titulo
                FROM Intentos
                INNER JOIN Estudiantes ON Intentos.id_estudiante = Estudiantes.id_estudiante
                INNER JOIN Ejercicios ON Intentos.id_ejercicio = Ejercicios.id_ejercicio
                WHERE Ejercicios.id_clase = ?
                ORDER BY Intentos.fecha DESC";
$stmt_intentos = $conn->prepare($sql_intentos);
$stmt_intentos->bind_param("i", $id_clase);
$stmt_intentos->execute();
$result_intentos = $stmt_intentos->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Intentos de Estudiantes - <?php echo htmlspecialchars($clase['nombre_clase']); ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'ver_intentos.html'; ?>
</body>
</html>

<?php
$stmt_clase->close();
$stmt_intentos->close();
$conn->close();
?>
