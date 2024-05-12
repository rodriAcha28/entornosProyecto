<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modulo 1: Fundamentos PHP</title>
    <link rel="stylesheet" href="modulos.css">
    <link rel="stylesheet" href="examen.css">
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-left">
            <span class="navbar-title">Curso PHP</span>
        </div>
        <div class="navbar-center">
            <a href="#" class="navbar-link">Inicio</a>
            <a href="#" class="navbar-link">Lecciones</a>
            <a href="#" class="navbar-link">Recursos</a>
        </div>
        <div class="navbar-right">
            <a href="#" class="navbar-login">Iniciar sesión</a>
        </div>
    </nav>

    <div class="pastel-blue">
        <button class="arrow-button">&lt;&lt;</button>
        <span class="content-title2">Modulo 1: Fundamentos PHP</span>
        <button onclick="window.location.href = 'modulo1-2.html';" class="arrow-button">&gt;&gt;</button>
    </div>

    <div class="fundamentos">
        <div class="fundamento">
            <p>Prueba 1:</p>

            <p>Realice la impresión del texto Hola en php</p>
            <p>Apoyo: utilice la función "echo" y las etiquetas al inicio y al final del código de php no hace falta colocarlas</p>
        </div>
        <div class="fundamento">
            <div class="editor">
                <textarea id="code" class="code" placeholder="Escribe tu código aquí"><?php
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

                // Consulta SQL para obtener el dato de la columna "ejerciciotexto" en la tabla "ejercicios"
                $query = "SELECT ejerciciotexto FROM ejercicios WHERE id_ejercicio = 1";
                $resultado = mysqli_query($conexion, $query);

                if (!$resultado) {
                    die("Error al ejecutar la consulta: " . mysqli_error($conexion));
                }

                // Verificar si se encontraron filas
                if (mysqli_num_rows($resultado) > 0) {
                    // Obtener el resultado de la consulta
                    $fila = mysqli_fetch_assoc($resultado);
                    $ejercicioTexto = $fila['ejerciciotexto'];
                } else {
                    // No se encontraron filas
                    $ejercicioTexto = "No se encontraron datos para el ID 1";
                }

                // Cerrar la conexión
                mysqli_close($conexion);

                echo $ejercicioTexto;
                ?></textarea>
                <button id="botonEjecutar" onclick="runCode()">Ejecutar</button>
            </div>
            <div id="output"></div>
            <script src="script.js"></script>
        </div>
    </div>
</body>
</html>
