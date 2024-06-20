<?php
session_start();
if (!isset($_SESSION['id_estudiante']) && !isset($_SESSION['id_maestro'])) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit();
}

if (!isset($_POST['id_ejercicio']) || !isset($_POST['code'])) {
    echo json_encode(['success' => false, 'message' => 'Datos insuficientes']);
    exit();
}

$id_ejercicio = intval($_POST['id_ejercicio']);
$code = $_POST['code'];

$conn = new mysqli('localhost', 'root', '', 'entornos');
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Conexión fallida: ' . $conn->connect_error]);
    exit();
}

$sql_ejercicio = "SELECT respuesta FROM Ejercicios WHERE id_ejercicio = ?";
$stmt = $conn->prepare($sql_ejercicio);
$stmt->bind_param("i", $id_ejercicio);
$stmt->execute();
$result = $stmt->get_result();
$ejercicio = $result->fetch_assoc();

if (!$ejercicio) {
    echo json_encode(['success' => false, 'message' => 'Ejercicio no encontrado']);
    exit();
}

$respuesta_correcta = $ejercicio['respuesta'];

// Ejecutar el código PHP de manera segura
// Aquí sólo un ejemplo básico, se recomienda usar sandboxing o contenedores para mayor seguridad
ob_start();
try {
    // Limitar el tiempo de ejecución del código
    set_time_limit(2); // 2 segundos como ejemplo
    eval($code);
    $output = ob_get_clean();
} catch (Throwable $e) {
    ob_end_clean(); // Limpiar cualquier contenido pendiente en el buffer
    echo json_encode(['success' => false, 'output' => '', 'message' => 'Error en la ejecución del código: ' . $e->getMessage()]);
    exit();
}

$conn->close();

if (trim($output) === trim($respuesta_correcta)) {
    echo json_encode(['success' => true, 'output' => $output]);
} else {
    echo json_encode(['success' => false, 'output' => $output]);
}
?>
