<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Estudiante</title>
</head>
<body>
    <?php
    if (isset($_POST['submit'])) {
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $conn = new mysqli('localhost', 'root', '', 'entornos');

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        $sql = "INSERT INTO Estudiantes (nombre, apellido, email, contrasena) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $nombre, $apellido, $email, $password);

        if ($stmt->execute()) {
            // Redirige a la página de login
    header("Location: login_estudiante.html");
    exit();
        } else {
            echo "Error al registrar estudiante: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
    ?>
</body>
</html>
