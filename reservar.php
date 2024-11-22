<?php
// Iniciar sesión para compartir datos
session_start();

// Conectar a la base de datos
$host = 'localhost'; // Servidor de la base de datos
$usuario = 'root';   // Usuario de la base de datos
$password = '';      // Contraseña del usuario
$baseDatos = 'parqueadero'; // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($host, $usuario, $password, $baseDatos);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fecha = $_POST['fecha'];
    $tipo_vehiculo = $_POST['tipo_vehiculo'];
    $hora_inicio = $_POST['hora_inicio'];
    $hora_fin = $_POST['hora_fin'];
    $placa = $_POST['placa'];
    $medio_pago = $_POST['medio_pago'];

    // Validar horas y calcular duración
    $horaInicio = strtotime($hora_inicio);
    $horaFin = strtotime($hora_fin);

    if ($horaInicio === false || $horaFin === false || $horaInicio >= $horaFin) {
        die("Por favor, ingresa un rango de horas válido.");
    }

    $duracionHoras = ($horaFin - $horaInicio) / 3600;

    // Definir precios por tipo de vehículo
    $precios = [
        'carro' => 2000,
        'moto' => 1500,
        'vehiculo_pesado' => 2500,
    ];

    if (!isset($precios[$tipo_vehiculo])) {
        die("Selecciona un tipo de vehículo válido.");
    }

    $precioPorHora = $precios[$tipo_vehiculo];
    $total = $duracionHoras * $precioPorHora;

    // Guardar en la base de datos
    $codigo_espacio = "E123"; // Asigna un código de espacio fijo o dinámico
    $sql = "INSERT INTO reservas (codigo_espacio, tipo_vehiculo, hora_inicio, hora_fin, fecha, placa, medio_pago, total)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "sssssssd", // Tipos de datos: s=string, d=decimal
        $codigo_espacio,
        $tipo_vehiculo,
        $hora_inicio,
        $hora_fin,
        $fecha,
        $placa,
        $medio_pago,
        $total
    );

    if ($stmt->execute()) {
        // Guardar datos en sesión para mostrar el resumen
        $_SESSION['reserva'] = [
            'codigo_espacio' => $codigo_espacio,
            'fecha' => $fecha,
            'tipo_vehiculo' => $tipo_vehiculo,
            'hora_inicio' => $hora_inicio,
            'hora_fin' => $hora_fin,
            'duracion_horas' => $duracionHoras,
            'placa' => $placa,
            'medio_pago' => $medio_pago,
            'total' => $total,
        ];

        // Redirigir a la página de resumen
        header("Location: resumen.php");
        exit;
    } else {
        die("Error al guardar los datos: " . $stmt->error);
    }

    $stmt->close();
} else {
    die("Acceso no permitido.");
}

$conn->close();
?>
