<?php
$error = true; // Simula un error
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alertas con PHP y SweetAlert2</title>

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php
session_start(); // Iniciar sesión

// Conexión a la base de datos
include("conexion.php");
// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Capturar datos del formulario
    $codigo_espacio = $_POST['codigo_espacio'];
    $fecha = $_POST['fecha'];
    $hora_inicio = $_POST['hora_inicio'];
    $hora_fin = $_POST['hora_fin'];
    $tipo_vehiculo = $_POST['tipo_vehiculo'];
    $placa = $_POST['placa'];
    $medio_pago = $_POST['medio_pago'];

    // Validar datos básicos
    if (empty($codigo_espacio) || empty($fecha) || empty($hora_inicio) || empty($hora_fin) || empty($tipo_vehiculo) || empty($placa) || empty($medio_pago)) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    title: 'Campos incompletos',
                    text: 'Por favor, completa todos los campos.',
                    icon: 'warning',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    window.history.back();
                });
            </script>";
        exit;
    }

    // Verificar si el espacio ya está reservado en el mismo rango de tiempo
    $sql_verificacion = "SELECT * FROM reservas WHERE codigo_espacio = ? AND fecha = ? AND (
        (hora_inicio < ? AND hora_fin > ?) OR
        (hora_inicio < ? AND hora_fin > ?) OR
        (hora_inicio >= ? AND hora_fin <= ?)
    )";
    $stmt_verificacion = $conexion->prepare($sql_verificacion);
    $stmt_verificacion->bind_param("ssssssss", $codigo_espacio, $fecha, $hora_fin, $hora_inicio, $hora_inicio, $hora_fin, $hora_inicio, $hora_fin);
    $stmt_verificacion->execute();
    $resultado_verificacion = $stmt_verificacion->get_result();

    if ($resultado_verificacion->num_rows > 0) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    title: 'Espacio reservado',
                    text: 'El espacio ya está reservado en el rango de tiempo seleccionado.',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    window.history.back();
                });
            </script>";
        $stmt_verificacion->close();
        exit;
    }
    $stmt_verificacion->close();

    // Calcular el tiempo en horas
    $inicio = strtotime($hora_inicio);
    $fin = strtotime($hora_fin);

    if ($inicio === false || $fin === false || $fin <= $inicio) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    title: 'Horas inválidas',
                    text: 'Las horas ingresadas no son válidas.',
                    icon: 'warning',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    window.history.back();
                });
            </script>";
        exit;
    }

    $horas = ceil(($fin - $inicio) / 3600); // Convertir segundos a horas y redondear hacia arriba

    // Calcular precio según el tipo de vehículo
    $precios_por_hora = [
        "moto" => 1500,
        "carro" => 2000,
        "vehiculo_pesado" => 2500,
    ];

    $precio_por_hora = $precios_por_hora[$tipo_vehiculo] ?? 0;
    $precio_total = $precio_por_hora * $horas;

    // Insertar la reserva en la base de datos
    $sql = "INSERT INTO reservas (codigo_espacio, fecha, hora_inicio, hora_fin, tipo_vehiculo, placa, medio_pago, precio) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sssssssi", $codigo_espacio, $fecha, $hora_inicio, $hora_fin, $tipo_vehiculo, $placa, $medio_pago, $precio_total);

    if ($stmt->execute()) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    title: '¡Reserva exitosa!',
                    text: 'Tu reserva ha sido registrada correctamente.',
                    icon: 'success',
                    confirmButtonText: 'Ver resumen'
                }).then(() => {
                    window.location.href = 'resumen.php?codigo=$codigo_espacio&fecha=$fecha&inicio=$hora_inicio&fin=$hora_fin&vehiculo=$tipo_vehiculo&placa=$placa&medio=$medio_pago&precio=$precio_total';
                });
            </script>";
        exit;
    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    title: 'Error',
                    text: 'Error al guardar la reserva.',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    window.history.back();
                });
            </script>";
    }

    $stmt->close();
}

// Cerrar conexión
$conexion->close();
?>
</body>
</html>
