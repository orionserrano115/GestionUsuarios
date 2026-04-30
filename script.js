document.getElementById("formularioUsuario").addEventListener("submit", function(e) {
    let nombre = document.querySelector("input[name='nombre']").value.trim();
    let cedula = document.querySelector("input[name='cedula']").value.trim();
    let telefono = document.querySelector("input[name='telefono']").value.trim();

    if (!nombre || !cedula || !telefono) {
        alert("Todos los campos son obligatorios");
        e.preventDefault();
    }

    if (cedula.length < 5) {
        alert("La cédula debe tener al menos 5 caracteres");
        e.preventDefault();
    }

    if (telefono.length < 7) {
        alert("El teléfono debe tener al menos 7 caracteres");
        e.preventDefault();
    }
});