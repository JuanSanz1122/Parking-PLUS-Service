let modal = document.getElementById("Modal");
let reservar = document.getElementById("reservar");
let span = document.getElementsByClassName("close")[0];

let modal_renta = document.getElementById("modal-renta");
let rentar = document.getElementById("rentar");
let close_rentar = document.getElementsByClassName("close-renta")[0];

// Al hacer clic en el botón "reservar", muestra el modal con la animación
reservar.onclick = function () {
    modal.style.display = "flex"; // Mostrar el modal
    setTimeout(() => modal.classList.add("show"), 10); // Agregar animación de zoom
}

// Al hacer clic en "X" del primer modal, cierra el modal con la animación
span.onclick = function () {
    modal.classList.remove("show"); // Remueve la animación
    setTimeout(() => modal.style.display = "none", 300); // Oculta después de la animación
}

// Al hacer clic en el botón "rentar", muestra el segundo modal con la animación
rentar.onclick = function () {
    modal_renta.style.display = "flex"; // Mostrar el modal
    setTimeout(() => modal_renta.classList.add("show"), 10); // Agregar animación de zoom
}

// Al hacer clic en "X" del segundo modal, cierra el modal con la animación
close_rentar.onclick = function () {
    modal_renta.classList.remove("show"); // Remueve la animación
    setTimeout(() => modal_renta.style.display = "none", 300); // Oculta después de la animación
}

// Cerrar el modal si se hace clic fuera del contenido, tanto para modal como modal_renta
window.onclick = function (event) {
    if (event.target == modal) {
        modal.classList.remove("show");
        setTimeout(() => modal.style.display = "none", 300);
    } else if (event.target == modal_renta) {
        modal_renta.classList.remove("show");
        setTimeout(() => modal_renta.style.display = "none", 300);
    }
}

// Función para manejar la reserva mediante AJAX
function reservarEspacio(espacio) {
    // Enviar la solicitud AJAX al servidor
    fetch('reservar.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `espacio=${encodeURIComponent(espacio)}`
    })
    .then(response => response.text())
    .then(data => {
        alert(data); // Muestra el mensaje del servidor
        // Puedes agregar lógica adicional para cambiar el estado del botón o realizar otras acciones.
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Ocurrió un error al intentar realizar la reserva.');
    });
}

// Función que se ejecuta al hacer clic en un botón de reserva
function seleccionarEspacio(espacio) {
    if (confirm(`¿Estás seguro que deseas reservar el espacio ${espacio}?`)) {
        reservarEspacio(espacio);  // Llama a la función AJAX para enviar la solicitud al backend
    }
}
