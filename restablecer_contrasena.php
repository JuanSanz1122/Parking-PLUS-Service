<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Document</title>
</head>
<body>
<?php
// Incluir archivo de conexión
include('conexion.php');

// Verificar que los datos se hayan enviado mediante POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Verificar que todos los campos estén presentes
        if (
            empty($_POST['correo']) || 
            empty($_POST['nueva_contrasena']) || 
            empty($_POST['confirmar_contrasena'])
        ) {
            echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Todos los campos son obligatorios.'
                }).then(() => {
                    window.history.back();
                });
            </script>";
            exit;
        }

        // Recibir y limpiar los datos del formulario
        $correo = trim($_POST['correo']);
        $nueva_contrasena = trim($_POST['nueva_contrasena']);
        $confirmar_contrasena = trim($_POST['confirmar_contrasena']);

        // Validar que las contraseñas coincidan
        if ($nueva_contrasena !== $confirmar_contrasena) {
            echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Las contraseñas no coinciden. Por favor, inténtalo nuevamente.'
                }).then(() => {
                    window.history.back();
                });
            </script>";
            exit;
        }

        // Verificar si el correo existe en la base de datos
        $sql_check = "SELECT * FROM clientes WHERE correo_electronico = ?";
        $stmt_check = $conexion->prepare($sql_check);
        $stmt_check->bind_param("s", $correo);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            // El correo existe, proceder a actualizar la contraseña
            $contrasenaHash = password_hash($nueva_contrasena, PASSWORD_BCRYPT);
            $sql_update = "UPDATE clientes SET contrasena = ? WHERE correo_electronico = ?";
            $stmt_update = $conexion->prepare($sql_update);
            $stmt_update->bind_param("ss", $contrasenaHash, $correo);

            if ($stmt_update->execute()) {
                echo "
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: 'La contraseña se ha actualizado correctamente.'
                    }).then(() => {
                        window.location.href = 'iniciar_sesion.html'; // Redirige a la página de inicio de sesión
                    });
                </script>";
            } else {
                echo "
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo actualizar la contraseña. Por favor, inténtalo más tarde.'
                    }).then(() => {
                        window.history.back();
                    });
                </script>";
            }
        } else {
            // El correo no existe en la base de datos
            echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'El correo electrónico no está registrado.'
                }).then(() => {
                    window.history.back();
                });
            </script>";
        }
    } catch (Exception $e) {
        echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error del servidor',
                text: '" . addslashes($e->getMessage()) . "'
            }).then(() => {
                window.history.back();
            });
        </script>";
    }
} else {
    echo "
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Método no permitido.'
        }).then(() => {
            window.history.back();
        });
    </script>";
}
?>

</body>
</html>