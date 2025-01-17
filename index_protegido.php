<?php
session_start();
if (!isset($_SESSION['nombre_completo'])) {
    // Redirige al inicio de sesión si no hay una sesión activa
    header('Location: login.html');
    exit();
}

// Obtén el nombre del usuario desde la sesión
$nombre_completo = $_SESSION['nombre_completo'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Index</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style..css">
    <link rel="icon" href="img/isotipo (nuevo).png" type="image/png">
</head>

<body>
    <div class="header">
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
                                <a class="nav-link active" href="reservas.html">Reservar</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="soporte.html">Soporte</a>
                            </li>
                            <li class="nav-item">
                                <div class="menu">
                                    <span style="color: #007bff;" class="config"><?php echo htmlspecialchars($nombre_completo); ?></span>
                                    <div class="menu-content">
                                        <a href="perfil.php">Perfil</a>
                                        <a href="logout.php">Cerrar sesion</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
        </nav>
        <video autoplay muted loop id="myVideo">
            <source src="img/carro.mp4" type="video/mp4">
            Tu navegador no soporta el elemento de video.
        </video>
        <div class="banner_text">
            <h1>Bienvenido a Parking Plus Service, <span style="color: #007bff;"><?php echo htmlspecialchars($nombre_completo); ?></span>!</h1>
            <h5>"Más que un parqueadero, una experiencia PLUS"</h5>
        </div>
    </div>

    <!-- Sección principal con información a la izquierda y imagen a la derecha -->
    <section class="main_section" style="background-image: url(img/fondo.jpg);">
        <div class="info-container">
            <ul>
                <li>Ubicación ideal: En el corazón de la ciudad, cerca de todo.</li>
                <li>Precios competitivos y descuentos especiales.</li>
                <li>Acceso rápido y seguro, con cámaras de vigilancia.</li>
                <li>Espacios amplios y servicios adicionales como cargadores eléctricos.</li>
            </ul>

            <h2>¡Beneficios Exclusivos para Nuestros Clientes!</h2>
            <div class="promo">
                <p><strong>Descuentos para Primeros Usuarios:</strong> Regístrate hoy y obtén un <strong>10% de descuento</strong> en tu primera tarifa de estacionamiento.</p>
            </div>
            <div class="promo">
                <p><strong>Puntos de Fidelidad:</strong> Acumula puntos con cada visita y canjéalos por descuentos o servicios gratuitos.</p>
            </div>
            <div class="promo">
                <p><strong>Promociones de Temporada:</strong> Aprovecha ofertas especiales durante eventos locales y festividades.</p>
            </div>
        </div>
        <div class="image-container">
            <img src="img/Post de Instagram Ubicación Moderno Azul (1).png" alt="Imagen del Parqueadero">
        </div>
    </section>

    <footer
        style="background-color: #000000; color: white; padding: 9px 0; text-align: center;">
        <div style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
            <div style="margin-bottom: 15px;">
                <a href="https://www.facebook.com" target="_blank" style="color: black; margin: 0 10px;">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg" alt="Facebook" style="width: 30px; height: 30px;">
                </a>
                <a href="https://www.twitter.com" target="_blank" style="color: black; margin: 0 10px;">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/6/6f/Logo_of_Twitter.svg" alt="Twitter" style="width: 30px; height: 30px;">
                </a>
                <a href="https://www.instagram.com" target="_blank" style="color: black; margin: 0 10px;">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/a/a5/Instagram_icon.png" alt="Instagram" style="width: 30px; height: 30px;">
                </a>
            </div>

            <div style="margin-bottom: 15px;">
                <a href="/terms" style="color: white; margin: 0 10px; text-decoration: none;">Términos y Condiciones</a> |
                <a href="/privacy" style="color: white; margin: 0 10px; text-decoration: none;">Política de Privacidad</a>
            </div>

            <div style="font-size: 14px;">
                &copy; 2024 Parking PLUS Service. Todos los derechos reservados.
            </div>
        </div>

    </footer>
    <script src="index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>