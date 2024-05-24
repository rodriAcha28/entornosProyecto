<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curso</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="modulos.css">
    <link rel="stylesheet" href="examen.css">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="menu.css">
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
            <a href="#" class="navbar-login"></a>
        </div>
    </nav>
    <div class="content-box">
        <span class="content-title"></span>
    </div>
    <div class="fundamentos">
        <div class="fundamento">
            <h2>Iniciar sesión como Maestro</h2>
            <a href="login_maestro.php" class="login-button">
                <img src="imagen_maestro.jpg" alt="Imagen Maestro" class="login-image">
                <span>Iniciar sesión</span>
            </a>
        </div>
        <div class="fundamento">
            <h2>Iniciar sesión como Estudiante</h2>
            <a href="login_estudiante.php" class="login-button">
                <img src="imagen_estudiante.jpg" alt="Imagen Estudiante" class="login-image">
                <span>Iniciar sesión</span>
            </a>
        </div>
    </div>
</body>
</html>
