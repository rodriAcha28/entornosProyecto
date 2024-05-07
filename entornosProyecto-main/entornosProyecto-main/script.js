// script.js

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

function loadModule() {
    var moduleSelect = document.getElementById("module-select");
    var selectedModule = moduleSelect.value;
    var moduleInfoDiv = document.getElementById("module-info");
    
    // Aquí haces una petición AJAX para cargar la información del módulo seleccionado
    // Puedes usar fetch() o XMLHttpRequest
    // Supongamos que los archivos de texto de los módulos tienen la extensión .txt
    fetch("modules/" + selectedModule + ".txt")
        .then(response => response.text())
        .then(text => {
            moduleInfoDiv.innerHTML = text;
        })
        .catch(error => console.error('Error al cargar el módulo:', error));
}
