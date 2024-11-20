<?php
// Incluir archivo de conexión
include('conexion.php');

// Verificar que los datos se hayan enviado mediante POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Recibir los datos del formulario
        $cedula = $_POST['cedula'];
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $contraseña = $_POST['contraseña'];

        // Verificar si el correo ya existe en la base de datos
        $sql_check = "SELECT * FROM clientes WHERE correo_electronico = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("s", $correo);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            // El correo ya existe
            echo "El correo electrónico ya está registrado. Por favor, utiliza otro.";
        } else {
            // Insertar los datos en la base de datos
            $contraseñaHash = password_hash($contraseña, PASSWORD_BCRYPT);
            $sql_insert = "INSERT INTO clientes (cedula, nombre_completo, correo_electronico, cotraseña) 
                           VALUES (?, ?, ?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("ssss", $cedula, $nombre, $correo, $contraseñaHash);

            if ($stmt_insert->execute()) {
                echo "Registro exitoso, ya puedes iniciar sesión.";
            } else {
                throw new Exception("Error en la ejecución: " . $stmt_insert->error);
            }
        }

        $stmt_check->close(); // Cerrar el statement de verificación

        // Cerrar el statement de inserción solo si fue inicializado
        if (isset($stmt_insert)) {
            $stmt_insert->close();
        }

        $conn->close(); // Cerrar la conexión
    } catch (mysqli_sql_exception $e) {
        // Capturar error de llave primaria duplicada
        echo "Cedula ya registrada. Por favor, verifique sus datos.";
    } catch (Exception $e) {
        echo "Error: {$e->getMessage()}')";
    }
} else {
    echo "Acceso no autorizado.";
}
