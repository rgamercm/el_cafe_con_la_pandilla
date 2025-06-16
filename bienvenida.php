<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("location: registrar.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido - El Café Con La Pan-dilla</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<body>
    <header class="header">
        <div class="logo">
            <img src="img/cafe/cafe.png" alt="Logotipo" class="logo-image">
        </div>
        <h1 class="header-title">El Café Con La Pan-dilla</h1>
        <button class="theme-toggle" id="themeToggle">🌙</button>
        <nav class="nav">
            <a href="index.php" class="nav-link"><span>Inicio</span></a>
            <a href="catalogo.php" class="nav-link">Productos</a>
            <a href="nosotros.php" class="nav-link">Nosotros</a>
            <a href="registrar.php" class="nav-link">Registrarse</a>
            <a href="diagrama_procesos.php" class="nav-link">Flujo Productos</a>
            <a href="diagrama_bd.php" class="nav-link">Estructura BD</a>
        </nav>
    </header>

    <main>
        <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?>!</h1>
        <p>Has iniciado sesión correctamente con el email: <?php echo htmlspecialchars($_SESSION['email']); ?></p>
        <a href="php/cerrar_sesion.php">Cerrar sesión</a>
    </main>

    <footer class="footer">
        <div class="footer-content">
            <p>2024 El Café Con La Pan-dilla C.A<br>Todos los Derechos Reservados.</p>
            <p>Contactos<br>Tlf: +58-4244258944<br>Correo: cg9477083@gmail.com 
            </p>
            <div class="social-media">
                <a href="https://www.facebook.com/profile.php?id=100089772800592" class="social-link">Facebook</a>
                <a href="https://www.instagram.com/carlosgz9477/" class="social-link">Instagram</a>
                <a href="https://github.com/NoobCoderMaster69" class="social-link">Github</a>
            </div>
        </div>
    </footer>
</body>
</html>