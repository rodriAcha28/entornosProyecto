<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio de Sesión de Maestro</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="login-container">
        <h2>Inicio de Sesión de Maestro</h2>
        <form action="login_maestro.php" method="post">
            <label for="email">Correo electrónico:</label><br>
            <input type="email" id="email" name="email" required><br><br>
            <label for="password">Contraseña:</label><br>
            <input type="password" id="password" name="password" required><br><br>
            <input type="submit" name="submit" value="Iniciar Sesión">
        </form>
    </div>

    <?php
    if (isset($_POST['submit'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $conn = new mysqli('localhost', 'root', '', 'entornos');

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM Maestros WHERE email = '$email' AND contrasena = '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $_SESSION['id_maestro'] = $result->fetch_assoc()['id_maestro'];
            header("Location: maestro_home.php");
        } else {
            echo "Credenciales incorrectas";
        }

        $conn->close();
    }
    ?>
</body>
</html>
