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
include('conexion.php'); // Incluir la conexión a la base de datos

// Obtener datos del formulario
$correo = $_POST['correo'];
$contrasena = $_POST['contrasena'];

// Verificar si las credenciales corresponden al operador
if ($correo === 'operador@parkingPlus.com' && $contrasena === 'Operador1234*') {
    // Guardar información del operador en la sesión
    $_SESSION['rol'] = 'operador';
    $_SESSION['nombre_completo'] = 'Operador ParkingPlus';

    // Redirigir al operador a su página específica
    header('Location: indexOperador.html');
    exit();
}

// Consultar la base de datos para verificar el cliente
$sql = "SELECT contrasena, nombre_completo FROM clientes WHERE correo_electronico = ?";
$stmt = $conexion->prepare($sql);

if ($stmt) {
    $stmt->bind_param('s', $correo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Usuario encontrado
        $row = $result->fetch_assoc();
        $hash_almacenado = $row['contrasena']; // Hash de la contrasena almacenado en la base de datos
        $nombre_usuario = $row['nombre_completo']; // Nombre del usuario

        // Verificar la contrasena ingresada con el hash almacenado
        if (password_verify($contrasena, $hash_almacenado)) {
            // Contrasena válida, guardar datos en la sesión
            $_SESSION['nombre_completo'] = $nombre_usuario; // Almacena el nombre en la sesión
            $_SESSION['correo_usuario'] = $correo; // Almacena el correo si es necesario
            $_SESSION['rol'] = 'cliente';

            // Redirigir al usuario a la página protegida
            header('Location: index_protegido.php');
            exit();
        } else {
            // Contrasena incorrecta
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                    Swal.fire({
                        title: 'Error',
                        text: 'Correo o contrasena incorrectos.',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        window.location.href = 'index.html';
                    });
                </script>";
        }
    } else {
        // Usuario no encontrado
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    title: 'Error',
                    text: 'Correo o contrasena incorrectos.',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    window.location.href = 'index.html';
                });
            </script>";
    }

    // Cerrar el statement
    $stmt->close();
} else {
    echo "Error en la preparación de la consulta: " . $conexion->error;
}

// Cerrar conexión
$conexion->close();
?>

</body>
</html>
