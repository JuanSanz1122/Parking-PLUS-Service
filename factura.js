// Alternar la visibilidad del menú desplegable
function toggleDropdown() {
    const menu = document.getElementById('dropdownMenu');
    menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
}

// Cerrar el menú si se hace clic fuera de él
window.onclick = function (event) {
    const menu = document.getElementById('dropdownMenu');
    if (!event.target.closest('.btn-group')) {
        if (menu.style.display === 'block') {
            menu.style.display = 'none';
        }
    }
};

// Descargar la tabla en formato PDF
function descargarPDF() {
    const { jsPDF } = window.jspdf; // Asegúrate de que jsPDF esté disponible
    const tabla = document.querySelector('.Factura'); // Selecciona el contenedor con la clase Factura

    if (!tabla) {
        alert('No se encontró el elemento con la clase "Factura".');
        return;
    }

    html2canvas(tabla).then(canvas => {
        const imgData = canvas.toDataURL("image/png");
        const pdf = new jsPDF();
        
        const imgWidth = 400; // Ajusta el ancho para que ocupe toda la página
        const imgHeight = canvas.height * imgWidth / canvas.width; // Ajuste proporcional de la altura

        // Centrar la imagen
        const xOffset = (pdf.internal.pageSize.width - imgWidth) / 2;

        pdf.addImage(imgData, 'PNG', xOffset, 10, imgWidth, imgHeight); // Agrega la imagen centrada
        pdf.save("Factura.pdf"); // Guarda el archivo PDF
    }).catch(error => {
        console.error("Error al generar el PDF:", error);
    });
}

