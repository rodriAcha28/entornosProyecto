<?php
session_start();
if (!isset($_SESSION['id_maestro'])) {
    header("Location: login_maestro.php");
    exit();
}

if (isset($_POST['submit'])) {
    $id_clase = $_POST['id_clase'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $ejerciciotexto = $_POST['ejerciciotexto'];

    $conn = new mysqli('localhost', 'root', '', 'entornos');
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $sql = "INSERT INTO Ejercicios (id_clase, titulo, descripcion, ejerciciotexto) VALUES ('$id_clase', '$titulo', '$descripcion', '$ejerciciotexto')";
    if ($conn->query($sql) === TRUE) {
        echo "Ejercicio subido exitosamente";
    } else {
        echo "Error al subir el ejercicio: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Subir Ejercicio</title>
</head>
<body>
    <h2>Subir Ejercicio</h2>
    <form action="subir_ejercicio.php" method="post">
        <input type="hidden" id="id_clase" name="id_clase" value="<?php echo $_GET['id_clase']; ?>">
        
        <label for="titulo">Título del Ejercicio:</label><br>
        <input type="text" id="titulo" name="titulo" required><br><br>
        
        <label for="descripcion">Descripción:</label><br>
        <textarea id="descripcion" name="descripcion" required></textarea><br><br>
        
        <label for="ejerciciotexto">Ejercicio:</label><br>
        <textarea id="ejerciciotexto" name="ejerciciotexto" required></textarea><br><br>
        
        <input type="submit" name="submit" value="Subir Ejercicio">
    </form>
</body>
</html>
