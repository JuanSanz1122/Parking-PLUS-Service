// Alternar la visibilidad del menú desplegable
function toggleDropdown() {
    const menu = document.getElementById('dropdownMenu');
    menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
}

// Cerrar el menú si se hace clic fuera de él
window.onclick = function(event) {
    if (!event.target.closest('.btn-group')) {
        const dropdown = document.getElementById('dropdownMenu');
        if (dropdown.style.display === 'block') {
            dropdown.style.display = 'none';
        }
    }
}

// Descargar la tabla en formato PDF
function downloadFile(format) {
    if (format === 'pdf') {
        downloadPDF();
    }
    // Cerrar el menú desplegable después de la selección
    const menu = document.getElementById('dropdownMenu');
    menu.style.display = 'none';
}

// Descargar la tabla como PDF
function downloadPDF() {
    const { jsPDF } = window.jspdf;
    const tabla = document.querySelector('.Factura'); // Selecciona el div completo que contiene la tabla

    html2canvas(tabla).then(canvas => {
        const imgData = canvas.toDataURL("image/png");
        const pdf = new jsPDF();
        const imgWidth = 190; // Ancho en mm
        const imgHeight = canvas.height * imgWidth / canvas.width;
        const position = 10; // Margen inicial en el PDF

        pdf.addImage(imgData, 'PNG', 10, position, imgWidth, imgHeight);
        pdf.save("Factura.pdf");
    });
}
