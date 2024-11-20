document.getElementById("formRegistro").addEventListener("submit", function (event) {
    event.preventDefault();

    const cedula = document.getElementById("cedula").value;
    const nombre = document.getElementById("nombre").value;
    const correo = document.getElementById("correo").value;
    const contraseña = document.getElementById("contraseña").value;

    // Validación de cédula
    if (!cedula) {
        alert("Por favor, ingresa tu cédula.");
        return;
    }
    if (!/^\d{8,10}$/.test(cedula)) {
        alert("La cédula debe ser un número válido (entre 8 y 10 dígitos).");
        return;
    }

    // Validación de nombre
    if (!nombre) {
        alert("Por favor, ingresa tu nombre.");
        return;
    }
    if (!/^[a-zA-Z\s]+$/.test(nombre) || nombre.trim().length < 3) {
        alert("El nombre debe contener solo letras y al menos 3 caracteres.");
        return;
    }

    // Validación de correo
    if (!correo) {
        alert("Por favor, ingresa tu correo.");
        return;
    }
    const correoRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!correoRegex.test(correo)) {
        alert("El correo electrónico no es válido.");
        return;
    }

    // Validación de contraseña
    if (!contraseña) {
        alert("Por favor, ingresa tu contraseña.");
        return;
    }
    if (!/^(?=.*[A-Z]).{8,}$/.test(contraseña)) {
        alert("La contraseña debe tener al menos 8 caracteres y una letra mayúscula.");
        return;
    }

    // Preparar los datos para enviar al servidor
    const formData = new FormData();
    formData.append("cedula", cedula);
    formData.append("nombre", nombre);
    formData.append("correo", correo);
    formData.append("contraseña", contraseña);

    // Enviar los datos con fetch
    fetch("procesar_registro.php", {
        method: "POST",
        body: formData,
    })
        .then(response => response.text())
        .then(data => {
            // Mostrar respuesta del servidor
            alert(data); // Puedes usar un modal o una notificación en lugar de alert
        })
        .catch(error => {
            alert("Hubo un error al procesar el formulario. Inténtalo de nuevo.");
            console.error("Error:", error);
        });
});
