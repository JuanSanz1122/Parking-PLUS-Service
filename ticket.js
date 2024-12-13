document.getElementById("imprimir").addEventListener("click", function () {
    const content = document.querySelector(".info-registro");

    html2canvas(content, {
        scale: 2, // Mejora la calidad
        useCORS: true, // Habilita recursos externos
    })
    .then(canvas => {
        const imgData = canvas.toDataURL("image/png");
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF("p", "mm", "a4");

        const imgWidth = 190; // Ancho máximo de la imagen en mm
        const imgHeight = (canvas.height * imgWidth) / canvas.width; // Altura proporcional
        const pageWidth = 210; // Ancho de la página A4
        const xOffset = (pageWidth - imgWidth) / 2; // Centrado horizontal
        const yOffset = 10; // Margen superior

        pdf.addImage(imgData, "PNG", xOffset, yOffset, imgWidth, imgHeight);
        pdf.save("info-registro.pdf");
    })
    .catch(error => {
        console.error("Error al generar el PDF:", error);
    });
});
