<?php
$code = $_POST["code"];
$output = "";

// Ejecutar el código PHP de manera segura
// Puedes usar sandboxing o contenedores para mayor seguridad
// Aquí solo un ejemplo básico
ob_start();
eval($code);
$output = ob_get_clean();

echo $output;
?>
