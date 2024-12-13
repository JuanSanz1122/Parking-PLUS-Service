<?php
// Incluir archivo de conexión
include('conexion.php');

// Verificar que los datos se hayan enviado mediante POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        if (isset($_POST['cedula'], $_POST['nombre'], $_POST['correo'], $_POST['contrasena'])) {
            $cedula = trim($_POST['cedula']);
            $nombre = trim($_POST['nombre']);
            $correo = trim($_POST['correo']);
            $contrasena = trim($_POST['contrasena']);

            if (empty($cedula) || empty($nombre) || empty($correo) || empty($contrasena)) {
                throw new Exception("Todos los campos son obligatorios.");
            }

            // Verificar si el correo ya existe
            $sql_check = "SELECT correo_electronico FROM clientes WHERE correo_electronico = ?";
            $stmt_check = $conexion->prepare($sql_check);
            $stmt_check->bind_param("s", $correo);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();

            if ($result_check->num_rows > 0) {
                echo json_encode(["icon" => "error", "message" => "El correo ya está registrado."]);
                $stmt_check->close();
                $conexion->close();
                exit;
            }

            // Verificar si la cédula ya existe
            $sql_check_cedula = "SELECT cedula FROM clientes WHERE cedula = ?";
            $stmt_check_cedula = $conexion->prepare($sql_check_cedula);
            $stmt_check_cedula->bind_param("s", $cedula);
            $stmt_check_cedula->execute();
            $result_check_cedula = $stmt_check_cedula->get_result();

            if ($result_check_cedula->num_rows > 0) {
                echo json_encode(["icon" => "error", "message" => "La cédula ya está registrada."]);
                $stmt_check_cedula->close();
                $conexion->close();
                exit;
            }

            // Insertar los datos en la base de datos
            $contrasenaHash = password_hash($contrasena, PASSWORD_BCRYPT);
            $sql_insert = "INSERT INTO clientes (cedula, nombre_completo, correo_electronico, contrasena) VALUES (?, ?, ?, ?)";
            $stmt_insert = $conexion->prepare($sql_insert);

            if (!$stmt_insert) {
                throw new Exception("Error al preparar la consulta de inserción: " . $conexion->error);
            }

            $stmt_insert->bind_param("ssss", $cedula, $nombre, $correo, $contrasenaHash);

            if ($stmt_insert->execute()) {
                echo json_encode(["icon" => "success", "message" => "Registro exitoso, ya puedes iniciar sesión."]);
            } else {
                throw new Exception("Error en la ejecución de la inserción: " . $stmt_insert->error);
            }
        } else {
            echo json_encode(["icon" => "warning", "message" => "Todos los campos son obligatorios."]);
        }
    } catch (Exception $e) {
        echo json_encode(["icon" => "error", "message" => $e->getMessage()]);
    } finally {
        $conexion->close();
    }
} else {
    echo json_encode(["icon" => "error", "message" => "Acceso no autorizado."]);
}
?>
