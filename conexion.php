<?php
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
?>
