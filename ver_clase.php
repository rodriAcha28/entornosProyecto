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

$sql_clase = "SELECT * FROM Clases WHERE id_clase = '$id_clase'";
$result_clase = $conn->query($sql_clase);
$clase = $result_clase->fetch_assoc();

$sql_estudiantes = "SELECT Estudiantes.nombre, Estudiantes.apellido FROM Estudiantes
                    INNER JOIN Estudiantes_Clases ON Estudiantes.id_estudiante = Estudiantes_Clases.id_estudiante
                    WHERE Estudiantes_Clases.id_clase = '$id_clase'";
$result_estudiantes = $conn->query($sql_estudiantes);

$sql_ejercicios = "SELECT * FROM Ejercicios WHERE id_clase = '$id_clase'";
$result_ejercicios = $conn->query($sql_ejercicios);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($clase['nombre_clase']); ?></title>
    
    <link rel="stylesheet" href="modulos.css">
    <link rel="stylesheet" href="examen.css">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="clase.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-left">
            <span class="navbar-title">Curso</span>
        </div>
        <div class="navbar-center">
            <a href="#" class="navbar-link">Inicio</a>
            <a href="#" class="navbar-link">Lecciones</a>
            <a href="#" class="navbar-link">Recursos</a>
        </div>
        <div class="navbar-right">
            <div class="user-info">
                <!--<img src="user.jpg" alt="Usuario" class="user-image">
                <span class="user-role"><php echo ($_SESSION['tipo_usuario'] == 'maestro') ? 'Maestro' : 'Estudiante'; ?></span>-->
                <a href="logout.php" class="navbar-login">Cerrar Sesión</a>
            </div>
        </div>
    </nav>
    <div class="content-container">      
        <h2><?php echo htmlspecialchars($clase['nombre_clase']); ?></h2>
        <div class="grid-container">    
            <div class="box">
                <h3>Estudiantes</h3>
                <ul>
                    <?php
                    if ($result_estudiantes->num_rows > 0) {
                        while ($row = $result_estudiantes->fetch_assoc()) {
                            echo "<li>" . htmlspecialchars($row['nombre']) . " " . htmlspecialchars($row['apellido']) . "</li>";
                        }
                    } else {
                        echo "<li>No hay estudiantes inscritos en esta clase.</li>";
                    }
                    ?>
                </ul>
            </div>
            <div class="box">
                <h3>Ejercicios</h3>
                <ul>
                    <?php
                    if ($result_ejercicios->num_rows > 0) {
                        while ($row = $result_ejercicios->fetch_assoc()) {
                            echo '<li><a href="examen.php?id_ejercicio=' . $row['id_ejercicio'] . '">' . htmlspecialchars($row['titulo']) . '</a></li>';
                        }
                    } else {
                        echo "<li>No hay ejercicios para esta clase.</li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>

    <?php
    if (isset($_SESSION['id_maestro'])) {
        echo '<button onclick="window.location.href=\'subir_ejercicio.php?id_clase=' . $id_clase . '\'">Crear Ejercicio</button>';
        echo '<button onclick="window.location.href=\'ver_intentos.php?id_clase=' . $id_clase . '\'">Ver Intentos de Estudiantes</button>';
    }
    ?>

</body>
</html>

<?php
$conn->close();
?>
