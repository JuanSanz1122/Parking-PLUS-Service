<?php
session_start();
session_unset();  // Eliminar todas las variables de sesión
session_destroy(); // Destruir la sesión

// Redirigir al archivo index.html
header('Location: index.html');
exit;
?>