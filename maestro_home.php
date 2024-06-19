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
        WHERE Maestros_Clases.id_maestro = '$id_maestro'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Clases</title>
    <link rel="stylesheet" href="modulos.css">
    <link rel="stylesheet" href="examen.css">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="home.css">
    <style>
        .floating-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            font-size: 24px;
            text-align: center;
            line-height: 50px;
            cursor: pointer;
        }
    </style>
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
        <a href="logout.php" class="navbar-login">Cerrar Sesión</a>
        </div>
    </nav>
    <h2>Mis Clases</h2>
    <ul>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<li><a href='ver_clase.php?id_clase={$row['id_clase']}'>{$row['nombre_clase']}</a></li>";
            }
        } else {
            echo "<li>No estás a cargo de ninguna clase.</li>";
        }
        ?>
    </ul>
    <button class="floating-button" onclick="window.location.href='crear_clase.php'">+</button>
</body>
</html>

<?php
$conn->close();
?>