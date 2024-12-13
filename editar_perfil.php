<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style..css">
    <link rel="icon" href="img/isotipo (nuevo).png" type="image/png">
</head>
<body style="background-image: url(img/fondo.jpg);">
<?php
session_start();
include('conexion.php');

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['correo_usuario'])) {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            Swal.fire({
                title: 'Sesión no iniciada',
                text: 'Por favor, inicia sesión primero.',
                icon: 'warning',
                confirmButtonText: 'Aceptar',
                customClass: {
                    confirmButton: 'boton-alert'
                }
            }).then(() => {
                window.location.href = 'login.html';
            });
        </script>";
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
        $contrasena = $row['contrasena'];
    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    title: 'Error',
                    text: 'Usuario no encontrado.',
                    icon: 'error',
                    confirmButtonText: 'Aceptar',
                    customClass: {
                        confirmButton: 'boton-alert'
                    }
                }).then(() => {
                    window.location.href = 'index.html';
                });
            </script>";
        exit();
    }

    $stmt->close();
} else {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            Swal.fire({
                title: 'Error',
                text: 'Error en la consulta. Por favor, intenta de nuevo.',
                icon: 'error',
                confirmButtonText: 'Aceptar',
                customClass: {
                    confirmButton: 'boton-alert'
                }
            });
        </script>";
    exit();
}

// Si el formulario de edición fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nuevo_nombre = $_POST['nombre_completo'];
    $nuevo_correo = $_POST['correo_electronico'];
    $nueva_contrasena = $_POST['contrasena'];

    if (!empty($nueva_contrasena)) {
        $nueva_contrasena_hash = password_hash($nueva_contrasena, PASSWORD_DEFAULT);
    } else {
        $nueva_contrasena_hash = $contrasena;
    }

    $sql_update = "UPDATE clientes SET nombre_completo = ?, correo_electronico = ?, contrasena = ? WHERE correo_electronico = ?";
    $stmt_update = $conexion->prepare($sql_update);

    if ($stmt_update) {
        $stmt_update->bind_param('ssss', $nuevo_nombre, $nuevo_correo, $nueva_contrasena_hash, $correo);
        $stmt_update->execute();

        if ($stmt_update->affected_rows > 0) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                    Swal.fire({
                        title: 'Éxito',
                        text: 'Datos actualizados correctamente.',
                        icon: 'success',
                        confirmButtonText: 'Aceptar',
                        customClass: {
                            confirmButton: 'boton-alert'
                        }
                    }).then(() => {
                        window.location.href = 'editar_perfil.php';
                    });
                </script>";
        } else {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                    Swal.fire({
                        title: 'Sin cambios',
                        text: 'No se realizaron cambios en los datos.',
                        icon: 'info',
                        confirmButtonText: 'Aceptar',
                        customClass: {
                            confirmButton: 'boton-alert'
                        }
                    });
                </script>";
        }

        $stmt_update->close();
    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    title: 'Error',
                    text: 'Error al actualizar los datos.',
                    icon: 'error',
                    confirmButtonText: 'Aceptar',
                    customClass: {
                        confirmButton: 'boton-alert'
                    }
                });
            </script>";
    }
}

$conexion->close();
?>

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
        <div class="card1">
        <div class="card-header bg-primary text-center">
            <div class="foto"><img src="img/avatar.jpg" alt="" class="profile-img"></div>
            <h3 class="text-white mt-2">Editar Perfil</h3>
        </div>
        <div class="card-body">
            <form action="editar_perfil.php" method="POST">
                <div class="mb-3">
                    <label for="nombre_completo" class="form-label">Nombre Completo</label>
                    <input type="text" class="form-control" id="nombre_completo" name="nombre_completo" value="<?php echo htmlspecialchars($nombre); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="correo_electronico" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" id="correo_electronico" name="correo_electronico" value="<?php echo htmlspecialchars($correo); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="contrasena" class="form-label">Nueva Contrasena</label>
                    <input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="Deja vacío si no deseas cambiarla">
                </div>
                <button type="submit" class="btn_primary1">Guardar</button>
                <a href="perfil.php" class="btn_secondary2">Cancelar</a>
            </form>
        </div>
    </div>
</body>
</html>