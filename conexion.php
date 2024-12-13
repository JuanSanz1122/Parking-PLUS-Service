<?php
$host = 'localhost'; // Servidor de la base de datos
$usuario = 'root';   // Usuario de la base de datos
$password = '';      // Contrasena del usuario
$baseDatos = 'parqueadero'; // Nombre de la base de datos

// Crear conexión
$conexion = new mysqli($host, $usuario, $password, $baseDatos);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexion: " . $conexion->connect_error);
}
?>
