<?php
include('conexion.php');

// Obtener datos del formulario
$correo = $_POST['correo'];
$contraseña = $_POST['contraseña'];

// Consultar la base de datos para obtener el hash de la contraseña
$sql = "SELECT cotraseña FROM clientes WHERE correo_electronico = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param('s', $correo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Usuario encontrado
        $row = $result->fetch_assoc();
        $hash_almacenado = $row['cotraseña']; // Hash de la contraseña almacenado en la base de datos

        // Verificar la contraseña ingresada con el hash almacenado
        if (password_verify($contraseña, $hash_almacenado)) {
            // Contraseña válida, iniciar sesión
            header('Location: index_protegido.html');
        } else {
            // Contraseña incorrecta
            echo "<script>alert('Correo o contraseña incorrectos'); window.location.href='index.html';</script>";
        }
    } else {
        // Usuario no encontrado
        echo "<script>alert('Correo o contraseña incorrectos'); window.location.href='index.html';</script>";
    }

    // Cerrar el statement
    $stmt->close();
} else {
    echo "Error en la preparación de la consulta: " . $conn->error;
}

// Cerrar conexión
$conn->close();
?>
