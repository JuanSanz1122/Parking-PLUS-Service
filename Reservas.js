let modal = document.getElementById("Modal");
let span = document.getElementsByClassName("close")[0];
let espacioSeleccionadoLabel = document.getElementById("espacio-seleccionado"); // Etiqueta dentro del modal para mostrar el espacio seleccionado

// Marcar espacios reservados al cargar la página
const espaciosReservados = ["A1", "A3", "B2"];
document.addEventListener("DOMContentLoaded", function () {
    espaciosReservados.forEach(espacio => {
        const elementoEspacio = document.getElementById(espacio.toLowerCase()); // Convertir a minúsculas si el ID es case-sensitive
        if (elementoEspacio) {
            elementoEspacio.classList.remove('disponible');
            elementoEspacio.classList.add('reservado');
        }
    });
});

// Función para manejar la selección de un espacio
function seleccionarEspacio(codigoEspacio) {
    const espacio = document.getElementById(codigoEspacio.toLowerCase()); // ID en minúsculas

    // Mostrar el modal
    modal.classList.add("show");
    modal.style.display = "block";

    // Mostrar el código del espacio seleccionado en el modal
    espacioSeleccionadoLabel.innerText = "Espacio seleccionado: " + codigoEspacio;

    // Asignar el código del espacio al formulario
    document.getElementById("codigo-espacio").value = codigoEspacio;
}

// Función para manejar la reserva del espacio
function reservarEspacio() {
    // Validar campos antes de enviar
    const espacio = document.getElementById("codigo-espacio").value.toLowerCase(); // ID en minúsculas
    const elementoEspacio = document.getElementById(espacio);

    if (!espacio) {
        alert("Selecciona un espacio antes de reservar.");
        return false; // Evitar el envío del formulario
    }

    // Cerrar el modal después de realizar la acción
    modal.classList.remove("show");
    setTimeout(() => {
        modal.style.display = "none";
    }, 300);

    // Continuar con el envío del formulario
    return true;
}

// Evento para cerrar el modal al hacer clic en el botón de cerrar
span.onclick = function () {
    modal.classList.remove("show");
    setTimeout(() => {
        modal.style.display = "none";
    }, 300);
};

// Evento para cerrar el modal al hacer clic fuera del mismo
window.onclick = function (event) {
    if (event.target === modal) {
        modal.classList.remove("show");
        setTimeout(() => {
            modal.style.display = "none";
        }, 300);
    }
};
