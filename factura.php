<?php
// Obtener los datos de la reserva desde los parámetros de la URL
$codigo_espacio = $_GET['codigo'] ?? 'N/A';
$fecha = $_GET['fecha'] ?? 'N/A';
$hora_inicio = $_GET['inicio'] ?? 'N/A';
$hora_fin = $_GET['fin'] ?? 'N/A';
$tipo_vehiculo = $_GET['vehiculo'] ?? 'N/A';
$placa = $_GET['placa'] ?? 'N/A';
$medio_pago = $_GET['medio'] ?? 'N/A';
$precio = $_GET['precio'] ?? 0;

// Convertir el medio de pago a un formato más legible
$medios_pago_legibles = [
    "tarjeta_credito" => "Tarjeta de Crédito",
    "tarjeta_debito" => "Tarjeta Débito",
    "nequi" => "Nequi",
    "daviplata" => "Daviplata",
    "pse" => "PSE",
];
$medio_pago_legible = $medios_pago_legibles[$medio_pago] ?? $medio_pago;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style..css">
    <link rel="icon" href="img/isotipo.png" type="image/png">
</head>

<body>
    <nav class="navbar navbar-expand-lg custom-navbar fixed-top">
        <a href="#home">

            <div class="container col-lg-10 col-md-8 col-sm-10">
                <a class="navbar-brand navbar-brand-sm" href="#">
                    <h1 class="nav-titulo">
                        Parking PLUS Service
                    </h1>
                </a>
                <button class="navbar-toggler custom-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                </div>
            </div>
    </nav>
    <div class="Factura">
    <table border="1" class="custom-table table table-bordered">
        <thead>
            <tr>
                <th colspan="2" class="text-center" style="background-color: #002060; color: white;">
                    Factura Detallada
                </th>
            </tr>
            <tr>
                <th colspan="2" class="text-center" style="background-color: white;">Información de Reserva</th>
            </tr>
        </thead>
        <tr>
            <th>Espacio Reservado</th>
            <td><?= htmlspecialchars($codigo_espacio) ?></td>
        </tr>
        <tr>
            <th>Fecha</th>
            <td><?= htmlspecialchars($fecha) ?></td>
        </tr>
        <tr>
            <th>Hora de Inicio</th>
            <td><?= htmlspecialchars($hora_inicio) ?></td>
        </tr>
        <tr>
            <th>Hora de Fin</th>
            <td><?= htmlspecialchars($hora_fin) ?></td>
        </tr>
        <tr>
            <th>Tipo de Vehículo</th>
            <td><?= ucfirst(htmlspecialchars($tipo_vehiculo)) ?></td>
        </tr>
        <tr>
            <th>Placa</th>
            <td><?= htmlspecialchars($placa) ?></td>
        </tr>
        <tr>
            <th>Medio de Pago</th>
            <td><?= htmlspecialchars($medio_pago_legible) ?></td>
        </tr>
        <tr>
            <th>Precio Total</th>
            <td>$<?= number_format($precio, 0, ',', '.') ?> COP</td>
        </tr>
    </table>
</div>

<div class="btn-group mt-3">
    <button id="mainButton" type="button" class="btn btn-outline-primary" onclick="toggleDropdown()">Descargar</button>
    <button type="button" class="btn btn-outline-primary dropdown-toggle" onclick="toggleDropdown()">
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" id="dropdownMenu" role="menu">
        <li><a href="#" onclick="descargarPDF()">PDF (pdf)</a></li>
    </ul>
    <a href="indexOperador.html" class="btn btn-outline-primary">Inicio</a>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9>fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="factura.js"></script>
</body>

</html>