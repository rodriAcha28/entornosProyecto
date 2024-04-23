function runCode() {
    var code = document.getElementById("code").value;
    var output = document.getElementById("output");
    output.innerHTML = ""; // Limpiamos el resultado anterior

    // Aquí hacemos una petición AJAX para enviar el código al servidor
    // y obtener el resultado
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
