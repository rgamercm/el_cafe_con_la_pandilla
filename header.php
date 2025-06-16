<?php
// includes/header.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El Café Con La Pan-dilla</title>
    <link rel="shortcut icon" href="img/cafe.png" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Imperial+Script&family=Lobster&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap"
        rel="stylesheet">
</head>
<body>
    <header class="header">
        <div class="logo">
            <a href="index.php"><img src="img/cafe/cafe.png" alt="Logotipo" class="logo-image"></a>
        </div>
        <h1 class="header-title">El Café Con La Pan-dilla</h1>
        <button class="theme-toggle" id="themeToggle">🌙</button>
        <nav class="nav">
            <a href="index.php" class="nav-link">Inicio</a>
            <a href="catalogo.php" class="nav-link">Productos</a>
            <a href="nosotros.php" class="nav-link">Nosotros</a>
            <a href="registrar.php" class="nav-link">Registrarse</a>
            <a href="diagrama_procesos.php" class="nav-link">Flujo Productos</a>
            <a href="diagrama_bd.php" class="nav-link">Estructura BD</a>
        </nav>
    </header>
    <main>