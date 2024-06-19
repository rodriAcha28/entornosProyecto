<?php
session_start();

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $conn = new mysqli('localhost', 'root', '', 'entornos');

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $sql = "SELECT id_maestro FROM Maestros WHERE email = ? AND contrasena = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id_maestro);
        $stmt->fetch();
        $_SESSION['id_maestro'] = $id_maestro;
        header("Location: maestro_home.html");
        exit();
    } else {
        echo "Credenciales incorrectas";
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: login_maestro.html");
    exit();
}
?>
