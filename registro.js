document.getElementById("formRegistro").addEventListener("submit", function (event) {
    event.preventDefault(); // Evitar el envío predeterminado del formulario

    // Capturar los valores de los campos
    const cedula = document.getElementById("cedula").value.trim();
    const nombre = document.getElementById("nombre").value.trim();
    const correo = document.getElementById("correo").value.trim();
    const contrasena = document.getElementById("contrasena").value.trim();

    // Validar cédula
    if (!cedula) {
        Swal.fire({
            title: 'Cédula inválida',
            text: 'Por favor, ingresa tu cédula.',
            icon: 'warning',
            confirmButtonText: 'Aceptar',
            customClass: {
                confirmButton: 'boton-alert'
            }
        });
        return;
    }
    if (!/^\d{8,10}$/.test(cedula)) {
        Swal.fire({
            title: 'Cédula inválida',
            text: 'La cédula debe contener entre 8 y 10 dígitos.',
            icon: 'warning',
            confirmButtonText: 'Aceptar',
            customClass: {
                confirmButton: 'boton-alert'
            }
        });
        return;
    }

    // Validar nombre
    if (!nombre) {
        Swal.fire({
            title: 'Nombre inválido',
            text: 'Por favor, ingresa tu nombre.',
            icon: 'warning',
            confirmButtonText: 'Aceptar',
            customClass: {
                confirmButton: 'boton-alert'
            }
        });
        return;
    }
    if (!/^[a-zA-Z\s]+$/.test(nombre)) {
        Swal.fire({
            title: 'Nombre inválido',
            text: 'El nombre debe contener solo letras.',
            icon: 'warning',
            confirmButtonText: 'Aceptar',
            customClass: {
                confirmButton: 'boton-alert'
            }
        });
        return;
    }

    // Validar correo
    if (!correo) {
        Swal.fire({
            title: 'Correo inválido',
            text: 'Por favor, ingresa tu correo.',
            icon: 'warning',
            confirmButtonText: 'Aceptar',
            customClass: {
                confirmButton: 'boton-alert'
            }
        });
        return;
    }
    const correoRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!correoRegex.test(correo)) {
        Swal.fire({
            title: 'Correo inválido',
            text: 'El correo electrónico no es válido.',
            icon: 'warning',
            confirmButtonText: 'Aceptar',
            customClass: {
                confirmButton: 'boton-alert'
            }
        });
        return;
    }

    // Validar contrasena
    if (!contrasena) {
        Swal.fire({
            title: 'Contrasena inválida',
            text: 'Por favor, ingresa tu contrasena.',
            icon: 'warning',
            confirmButtonText: 'Aceptar',
            customClass: {
                confirmButton: 'boton-alert'
            }
        });
        return;
    }
    if (!/^(?=.*[A-Z]).{8,}$/.test(contrasena)) {
        Swal.fire({
            title: 'Contrasena inválida',
            text: 'La contrasena debe tener al menos 8 caracteres y una letra mayúscula.',
            icon: 'warning',
            confirmButtonText: 'Aceptar',
            customClass: {
                confirmButton: 'boton-alert'
            }
        });
        return;
    }

    // Crear un objeto FormData para enviar los datos al servidor
    const formData = new FormData();
    formData.append("cedula", cedula);
    formData.append("nombre", nombre);
    formData.append("correo", correo);
    formData.append("contrasena", contrasena);

    // Enviar los datos al servidor con fetch
    fetch("procesar_registro.php", {
        method: "POST",
        body: formData,
    })
        .then(response => response.json()) // Procesar la respuesta como JSON
        .then(data => {
            Swal.fire({
                title: data.icon === "success" ? "Éxito" : "Información",
                text: data.message,
                icon: data.icon,
                confirmButtonText: "Aceptar",
                customClass: {
                    confirmButton: "boton-alert"
                }
            });
        })
        .catch(error => {
            console.error("Error:", error);
            Swal.fire({
                title: "Error",
                text: "Ocurrió un error inesperado. Por favor, inténtalo de nuevo.",
                icon: "error",
                confirmButtonText: "Aceptar",
                customClass: {
                    confirmButton: "boton-alert"
                }
            });
        });
});
