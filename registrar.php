<?php

    session_start();

    if(isset($_SESSION['usuario'])){
        header("location: bienvenida.php");
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El Café Con La Pan-dilla</title>
    <link rel="shortcut icon" href="img/cafe.png" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/registrar.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Imperial+Script&family=Lobster&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap"
        rel="stylesheet">
</head>
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

    <div class="bienvenido">
        <h2>bienvenid@s a <br>El Café Con La Pan-dilla</h2>
    </div>

    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form action="php/registro_usuario_be.php" method="POST">
                <input type="text" placeholder="Nombre" name="nombre" required>
                <input type="text" placeholder="Apellido" name="apellido" required>
                <input type="text" placeholder="Usuario" name="usuario" required>
                <input type="email" placeholder="Email" name="email" required>
                <input type="password" placeholder="Contraseña" name="contrasena" minlength="8" required>
                <button type="submit">Crear cuenta</button>
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form action="php/login_usuario_be.php" method="POST">
                <h1>Iniciar Sesion</h1>
                <div class="social-container">
                    <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                </div>
                <span>O utiliza tu cuenta</span>
                <input type="email" placeholder="Email" name="email"/>
                <input type="password" placeholder="Contraseña" name="contrasena"/>
                <a href="#">Olvidaste tu contraseña?</a>
                <button>Iniciar sesión</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>¡Bienvenido de nuevo!</h1>
                    <p>Para mantenerse conectado con nosotros, inicie sesión con su información personal.
                    </p>
                    <button class="ghost" id="signIn">Iniciar sesión</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hola amig@</h1>
                    <p>
                        Introduce tus datos personales para el registro</p>
                    <button class="ghost" id="signUp">Crear cuenta</button>
                </div>
            </div>
        </div>
    </div>
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
    <script src="js/registro.js"></script>
    <script src="js/style.js"></script>
</body>
</html>