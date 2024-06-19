<?php
session_start();
if (!isset($_SESSION['id_maestro'])) {
    header("Location: login_maestro.php");
    exit();
}

if (isset($_POST['submit'])) {
    // Debugging: show all POST data
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    $id_clase = $_POST['id_clase'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $ejerciciotexto = $_POST['ejerciciotexto'];
    $ayuda1 = $_POST['ayuda1'];
    $ayuda2 = $_POST['ayuda2'];
    $ayuda3 = $_POST['ayuda3'];
    $ayuda4 = $_POST['ayuda4'];
    $respuesta = $_POST['respuesta'];

    // Mostrar los valores para depuración
    echo "id_clase: $id_clase<br>";
    echo "titulo: $titulo<br>";
    echo "descripcion: $descripcion<br>";
    echo "ejerciciotexto: $ejerciciotexto<br>";
    echo "ayuda1: $ayuda1<br>";
    echo "ayuda2: $ayuda2<br>";
    echo "ayuda3: $ayuda3<br>";
    echo "ayuda4: $ayuda4<br>";
    echo "respuesta: $respuesta<br>";

    // Verifica que los valores no estén vacíos
    if (empty($id_clase) || empty($titulo) || empty($descripcion) || empty($ejerciciotexto) || empty($respuesta)) {
        die("Por favor, complete todos los campos requeridos.");
    }

    $conn = new mysqli('localhost', 'root', '', 'entornos');
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Verificar que el id_clase existe en la tabla clases
    $check_sql = "SELECT id_clase FROM clases WHERE id_clase = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("i", $id_clase);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        // id_clase existe, proceder con la inserción
        $sql = "INSERT INTO ejercicios (id_clase, titulo, descripcion, ejerciciotexto, ayuda1, ayuda2, ayuda3, ayuda4, respuesta) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issssssss", $id_clase, $titulo, $descripcion, $ejerciciotexto, $ayuda1, $ayuda2, $ayuda3, $ayuda4, $respuesta);

        if ($stmt->execute()) {
            echo "Ejercicio subido exitosamente";
        } else {
            echo "Error al subir el ejercicio: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error: id_clase no existe en la tabla clases.";
    }

    $check_stmt->close();
    $conn->close();
}
?>
