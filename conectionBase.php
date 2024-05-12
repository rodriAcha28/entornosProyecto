<?php
// Credenciales de la base de datos
$servidor = "localhost"; 
$usuario = "root"; 
$contraseña = ""; 
$base_datos = "entornos"; 

// Establecer la conexión
$conexion = mysqli_connect($servidor, $usuario, $contraseña, $base_datos);

// Verificar la conexión
if (!$conexion) {
    die("La conexión a la base de datos ha fallado: " . mysqli_connect_error());
}

// Consulta SQL para obtener el dato con ID 1 de la tabla "ejercicios"
// Consulta SQL para obtener el dato con ID 1 de la tabla "ejercicios"
$query = "SELECT dato FROM ejercicios WHERE id = 1";
$resultado = mysqli_query($conexion, $query);

if (!$resultado) {
    die("Error al ejecutar la consulta: " . mysqli_error($conexion));
}

// Verificar si se encontraron filas
if (mysqli_num_rows($resultado) > 0) {
    // Obtener el resultado de la consulta
    $fila = mysqli_fetch_assoc($resultado);
    $dato = $fila['dato'];
} else {
    // No se encontraron filas
    $dato = "No se encontraron datos para el ID 1";
}
// Cerrar la conexión
mysqli_close($conexion);
?>
