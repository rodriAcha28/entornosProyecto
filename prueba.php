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
    <!-- ...tu navegación y otros contenidos... -->
    
    <div class="fundamentos">
        <div class="fundamento">
            <p>Prueba 1:</p>
            <p>Realice la impresión del texto Hola en php</p>
            <p>Apoyo: utilice la función "echo" y las etiquetas al inicio y al final del código de php no hace falta colocarlas</p>
        </div>
        <div class="fundamento">
            <div class="editor">
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "entornos";
                
                $conn = new mysqli($servername, $username, $password, $database);
                
                if ($conn->connect_error) {
                    die("Error de conexión: " . $conn->connect_error);
                }
                
                $sql = "SELECT ejerciciotexto FROM ejercicios WHERE id_ejercicio = 1";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $ejercicio_texto = $row["ejerciciotexto"];
                } else {
                    $ejercicio_texto = "No se encontraron ejercicios con el ID especificado.";
                }
                
                $conn->close();
                ?>
                <textarea id="code" class="code" placeholder="Escribe tu código aquí"><?php echo $ejercicio_texto; ?></textarea>
            </div>
            <button onclick="runCode()">Ejecutar Código</button>
            <div id="output"></div>
        </div>
    </div>

    <script>
    function runCode() {
        var code = document.getElementById("code").value;
        var output = document.getElementById("output");
        output.innerHTML = ""; 

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                output.innerHTML = xhr.responseText;
            }
        };
        xhr.open("POST", "run_code.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("code=" + encodeURIComponent(code));
    }
    </script>
</body>
</html>
