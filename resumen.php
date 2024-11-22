<?php
// Iniciar sesión
session_start();

// Verificar si la reserva está en sesión
if (!isset($_SESSION['reserva'])) {
    die("No hay datos de reserva disponibles.");
}

// Obtener los datos de la reserva
$reserva = $_SESSION['reserva'];

// Mostrar los datos al usuario
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura</title>
    <link rel="stylesheet" href="style..css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #A7B8FC;">
<nav class="navbar navbar-expand-lg custom-navbar fixed-top">
  <a href="#home">
  
  <div class="container col-lg-10 col-md-8 col-sm-10">
    <a class="navbar-brand navbar-brand-sm" href="#">   
      <h1 class="nav-titulo">
        Parking PLUS Service 
      </h1>
      </a>
        <button class="navbar-toggler custom-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
        </div>
  </div>
</nav>
<div class="container mt-5">
    <h1>Resumen de tu Reserva</h1>
    <div class="Factura">
    <table class="custom-table">
        <tr>
            <th>Fecha</th>
            <td><?php echo htmlspecialchars($reserva['fecha']); ?></td>
        </tr>
        <tr>
            <th>Tipo de Vehículo</th>
            <td><?php echo htmlspecialchars($reserva['tipo_vehiculo']); ?></td>
        </tr>
        <tr>
            <th>Hora de Inicio</th>
            <td><?php echo htmlspecialchars($reserva['hora_inicio']); ?></td>
        </tr>
        <tr>
            <th>Hora Final</th>
            <td><?php echo htmlspecialchars($reserva['hora_fin']); ?></td>
        </tr>
        <tr>
            <th>Duración (Horas)</th>
            <td><?php echo htmlspecialchars($reserva['duracion_horas']); ?></td>
        </tr>
        <tr>
            <th>Placa</th>
            <td><?php echo htmlspecialchars($reserva['placa']); ?></td>
        </tr>
        <tr>
            <th>Medio de Pago</th>
            <td><?php echo htmlspecialchars($reserva['medio_pago']); ?></td>
        </tr>
        <tr>
            <th>Total</th>
            <td>$<?php echo number_format($reserva['total'], 2); ?></td>
        </tr>
    </table>
</div>
<div class="btn-group">
                <button id="mainButton" type="button" class="btn btn-outline-primary"
                    onclick="toggleDropdown()">Descargar</button>
                <button type="button" class="btn btn-outline-primary dropdown-toggle" onclick="toggleDropdown()">
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" id="dropdownMenu" role="menu">
                    <li><a href="#" onclick="downloadFile('pdf')">PDF (pdf)</a></li>
                </ul>
            </div>
            <a href="index_protegido.html" class="btn btn-outline-primary" >Volver al inicio</a>
</div>
<script src="factura.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
</body>
</html>
