<?php
session_start();

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $conn = new mysqli('localhost', 'root', '', 'entornos');

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM Estudiantes WHERE email = '$email' AND contrasena = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['id_estudiante'] = $result->fetch_assoc()['id_estudiante'];
        header("Location: estudiante_home.html");
    } else {
        echo "Credenciales incorrectas";
    }

    $conn->close();
}
?>
