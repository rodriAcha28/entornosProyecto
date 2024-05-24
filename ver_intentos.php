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
$sql_clase = "SELECT * FROM Clases WHERE id_clase = '$id_clase'";
$result_clase = $conn->query($sql_clase);
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
                WHERE Ejercicios.id_clase = '$id_clase'
                ORDER BY Intentos.fecha DESC";
$result_intentos = $conn->query($sql_intentos);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Intentos de Estudiantes - <?php echo htmlspecialchars($clase['nombre_clase']); ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Intentos de Estudiantes en <?php echo htmlspecialchars($clase['nombre_clase']); ?></h2>
    
    <table border="1">
        <tr>
            <th>Estudiante</th>
            <th>Ejercicio</th>
            <th>Código</th>
            <th>Resultado</th>
            <th>Fecha</th>
        </tr>
        <?php
        if ($result_intentos->num_rows > 0) {
            while ($row = $result_intentos->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['nombre']) . " " . htmlspecialchars($row['apellido']) . "</td>";
                echo "<td>" . htmlspecialchars($row['titulo']) . "</td>";
                echo "<td><pre>" . htmlspecialchars($row['codigo']) . "</pre></td>";
                echo "<td><pre>" . htmlspecialchars($row['resultado']) . "</pre></td>";
                echo "<td>" . htmlspecialchars($row['fecha']) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No hay intentos registrados para esta clase.</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
