<?php
session_start();
include('conexion.php'); 

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['correo_usuario'])) {
    header('Location: login.html'); // Redirigir a la página de inicio de sesión si no hay sesión activa
    exit();
}

$correo = $_SESSION['correo_usuario'];

// Consultar la base de datos para obtener los datos del usuario
$sql = "SELECT nombre_completo, correo_electronico, contrasena FROM clientes WHERE correo_electronico = ?";
$stmt = $conexion->prepare($sql);

if ($stmt) {
    $stmt->bind_param('s', $correo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Usuario encontrado, obtener datos
        $row = $result->fetch_assoc();
        $nombre = $row['nombre_completo'];
        $correo = $row['correo_electronico'];
        $contrasena = $row['cotrasena']; // Aquí obtienes el hash de la contrasena almacenado en la base de datos
    } else {
        echo "<script>alert('Error: Usuario no encontrado'); window.location.href='index.html';</script>";
        exit();
    }

    $stmt->close();
} else {
    echo "Error en la preparación de la consulta: " . $conexion->error;
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil del Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style..css">
    <link rel="icon" href="img/isotipo (nuevo).png" type="image/png">
</head>
<body style="background-image: url(img/fondo.jpg);">
<div>
        <nav class="navbar navbar-expand-lg custom-navbar fixed-top">
            <a href="#home">
                <img src="img/isotipo (nuevo).png" alt="Logo" style="height: 60px;">
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
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link active" href="index_protegido.php">Inicio</a>
                            </li>
                        </ul>
                    </div>
                </div>
        </nav>
        <body>
        <div class="card">
        <!-- Imagen del perfil -->
        <div class="card-header bg-primary">
            <div class="foto"><img src="img/avatar.jpg" alt=""class= "profile-img"></div>
            <h3 class="text-white mt-2">Datos Personales</h3>
        </div>
        <div class="card-body">
            <p><strong>Nombre:</strong> <?php echo htmlspecialchars($nombre); ?></p>
            <p><strong>Correo Electrónico:</strong> <?php echo htmlspecialchars($correo); ?></p>
            <p><strong>Contrasena:</strong> ********</p>
            <a href="editar_perfil.php" class="btn-warning">Editar Perfil</a>
            <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
        </div>
    </div>
</body>
</html>