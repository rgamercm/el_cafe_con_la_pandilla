<?php
session_start();

if(isset($_SESSION['usuario'])){
    header("location: bienvenida_despues_de_iniciarsesion.php");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - El Café Con La Pan-dilla</title>
    <link rel="shortcut icon" href="../img/cafe.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Imperial+Script&family=Lobster&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Variables y estilos base del CÓDIGO ORIGINAL */
        :root {
            --primary-color: #D4A76A;
            --secondary-color: #5a3921;
            --bg-color: #f8f5f2;
            --text-color: #333;
            --header-bg: #000000;
            --header-text: #ffffff;
            --card-bg: #fff;
            --transition: all 0.3s ease;
            --background-color--registrar: #e0ecfa;
            --background-color-card: #ffffff;
            --background-color-carusel: #c7c7c7a9;
            --background-color: #f8f5f2;
            --hover-color: #747474;
            --dropdown-background: #f9f9f9;
            --dropdown-hover: #ddd;
            --section-padding: 80px 0;
            --box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            --border-radius: 12px;
        }

        [data-theme="dark"] {
            --bg-color: #1a1a1a;
            --text-color: #f0f0f0;
            --header-bg: #000000;
            --card-bg: #333;
            --background-color--registrar: #878c91;
            --background-color-card: #2e2c27;
            --background-color-carusel: #111111a9;
            --background-color: #131111;
            --header-text-color: white;
            --hover-color: #575757;
            --dropdown-background: #444;
            --dropdown-hover: #575757;
            --box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        /* Estilos generales */
        body {
            font-family: "Montserrat", sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--bg-color);
            color: var(--text-color);
            transition: var(--transition);
            line-height: 1.6;
        }

        h1, h2, h3, h4 {
            font-family: "Playfair Display", serif;
            font-weight: 600;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .btn {
            display: inline-block;
            background: var(--primary-color);
            color: white;
            padding: 12px 30px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            text-transform: uppercase;
            font-size: 14px;
            letter-spacing: 1px;
        }

        .btn:hover {
            background: var(--secondary-color);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-outline {
            background: transparent;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
        }

        .btn-outline:hover {
            background: var(--primary-color);
            color: white;
        }

        .section-title {
            text-align: center;
            margin-bottom: 60px;
            position: relative;
        }

        .section-title h2 {
            font-size: 36px;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .section-title p {
            color: var(--text-color);
            max-width: 700px;
            margin: 0 auto;
        }

        .section-title::after {
            content: '';
            display: block;
            width: 80px;
            height: 3px;
            background: var(--primary-color);
            margin: 20px auto;
        }

        /* Header Rediseñado */
        .header {
            background-color: var(--header-bg);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
            padding: 15px 0;
            transition: all 0.3s ease;
        }

        .header.scrolled {
            padding: 10px 0;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo-image {
            height: 50px;
            width: auto;
            transition: transform 0.3s ease;
        }

        .logo-image:hover {
            transform: scale(1.05);
        }

        .header-title {
            font-size: 24px;
            margin: 0;
            color: var(--primary-color);
            font-family: "Playfair Display", serif;
            font-weight: 700;
        }

        /* Controles del header */
        .header-controls {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        /* Menú Hamburguesa */
        .menu-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--header-text);
            font-size: 24px;
            cursor: pointer;
            transition: all 0.3s ease;
            padding: 8px;
            z-index: 1001;
        }

        .menu-toggle:hover {
            color: var(--primary-color);
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 25px;
        }

        .nav-menu.active {
            transform: translateX(0);
        }

        .nav-link {
            padding: 8px 0;
            font-size: 16px;
            position: relative;
            text-decoration: none;
            color: var(--header-text);
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary-color);
            transition: all 0.3s ease;
        }

        .nav-link:hover::after, .nav-link.active::after {
            width: 100%;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--primary-color);
        }

        /* Carrito y tema */
        .theme-toggle {
            background: transparent;
            border: none;
            font-size: 20px;
            cursor: pointer;
            padding: 8px;
            transition: transform 0.3s ease;
            color: var(--header-text);
        }

        .theme-toggle:hover {
            transform: scale(1.1);
            color: var(--primary-color);
        }

        .cart-icon {
            position: relative;
            color: var(--header-text);
            font-size: 20px;
            transition: all 0.3s ease;
        }

        .cart-icon:hover {
            color: var(--primary-color);
        }

        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--primary-color);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
        }

        /* Estilos específicos del formulario de registro/login - MEJORADOS */
        .auth-section {
            padding: var(--section-padding);
            text-align: center;
        }

        .auth-title {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 2rem;
            position: relative;
            display: inline-block;
        }

        .auth-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: var(--primary-color);
            border-radius: 3px;
        }

        .form-container {
            background-color: var(--card-bg);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            position: relative;
            overflow: hidden;
            width: 800px;
            max-width: 100%;
            min-height: 600px;
            margin: 2rem auto;
            transition: all 0.6s ease-in-out;
        }

        .form-container-inner {
            position: absolute;
            top: 0;
            height: 100%;
            transition: all 0.6s ease-in-out;
            padding: 2rem;
            box-sizing: border-box;
            width: 50%;
            z-index: 2;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .sign-in-container {
            left: 0;
            opacity: 1;
        }

        .sign-up-container {
            left: 0;
            opacity: 0;
            z-index: 1;
        }

        .form-container.right-panel-active .sign-in-container {
            transform: translateX(100%);
            opacity: 0;
        }

        .form-container.right-panel-active .sign-up-container {
            transform: translateX(100%);
            opacity: 1;
            z-index: 5;
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateX(20px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .overlay-container {
            position: absolute;
            top: 0;
            left: 50%;
            width: 50%;
            height: 100%;
            overflow: hidden;
            transition: transform 0.6s ease-in-out;
            z-index: 100;
        }

        .form-container.right-panel-active .overlay-container {
            transform: translateX(-100%);
        }

        .overlay {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            background-repeat: no-repeat;
            background-size: cover;
            background-position: 0 0;
            color: #FFFFFF;
            position: relative;
            left: -100%;
            height: 100%;
            width: 200%;
            transform: translateX(0);
            transition: transform 0.6s ease-in-out;
        }

        .form-container.right-panel-active .overlay {
            transform: translateX(50%);
        }

        .overlay-panel {
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 0px;
            text-align: center;
            top: 0;
            height: 100%;
            width: 50%;
            transform: translateX(0);
            transition: all 0.6s ease-in-out;
        }

        .overlay-left {
            transform: translateX(-20%);
            opacity: 0;
        }

        .form-container.right-panel-active .overlay-left {
            transform: translateX(0);
            opacity: 1;
            animation: slideInFromLeft 0.6s ease-out;
        }

        .overlay-right {
            right: 0;
            transform: translateX(0);
            opacity: 1;
        }

        .form-container.right-panel-active .overlay-right {
            transform: translateX(20%);
            opacity: 0;
            animation: slideOutToRight 0.6s ease-out;
        }

        @keyframes slideInFromLeft {
            0% {
                transform: translateX(-20%);
                opacity: 0;
            }
            100% {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOutToRight {
            0% {
                transform: translateX(0);
                opacity: 1;
            }
            100% {
                transform: translateX(20%);
                opacity: 0;
            }
        }

        form {
            background-color: var(--card-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 40px;
            height: 100%;
            text-align: center;
            transition: all 0.6s ease-in-out;
        }

        /* MODIFICACIONES PARA TEXTO VISIBLE */
        input, select {
            background-color: #eee;
            border: none;
            padding: 12px 15px;
            margin: 10px 0;
            width: 100%;
            border-radius: 5px;
            transition: all 0.3s ease;
            font-size: 14px;
            color: #000000 !important; /* Fuerza texto negro */
        }

        input::placeholder {
            color: #666 !important; /* Color gris oscuro para placeholders */
        }

        select option {
            color: #000000 !important; /* Fuerza texto negro en opciones */
            background-color: #ffffff !important; /* Fondo blanco para opciones */
        }

        input:focus {
            outline: none;
            box-shadow: 0 0 0 2px var(--primary-color);
            transform: translateY(-2px);
        }

        button {
            border-radius: 30px;
            border: 1px solid var(--primary-color);
            background-color: var(--primary-color);
            color: #FFFFFF;
            font-size: 14px;
            font-weight: bold;
            padding: 14px 45px;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: all 0.3s ease;
            margin-top: 1.5rem;
            cursor: pointer;
            width: 100%;
            max-width: 250px;
        }

        button:active {
            transform: scale(0.95);
        }

        button:focus {
            outline: none;
        }

        button.ghost {
            background-color: transparent;
            border-color: #FFFFFF;
            position: relative;
            overflow: hidden;
            z-index: 1;
            margin-top: 20px;
        }

        button.ghost::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.2);
            transition: width 0.3s ease;
            z-index: -1;
        }

        button.ghost:hover::before {
            width: 100%;
        }

        button.ghost:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .input-group {
            display: flex;
            align-items: center;
            width: 100%;
        }

        .input-group select {
            flex: 0 0 auto;
        }

        .input-group input {
            flex: 1;
        }

        .social-container {
            margin: 20px 0;
        }

        .social-container a {
            border: 1px solid #DDDDDD;
            border-radius: 50%;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            margin: 0 5px;
            height: 40px;
            width: 40px;
            color: var(--text-color);
            background-color: var(--card-bg);
            transition: all 0.3s ease;
        }

        .social-container a:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .remember-me {
            margin: 15px 0;
            display: flex;
            align-items: center;
            font-size: 14px;
            width: 100%;
            justify-content: center;
        }

        .remember-me input {
            width: auto;
            margin-right: 8px;
        }

        .remember-me label {
            color: var(--text-color);
        }

        form h1 {
            margin: 0 0 25px 0;
            color: var(--primary-color);
            position: relative;
            padding-bottom: 15px;
            font-size: 28px;
        }

        form h1::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: var(--primary-color);
            border-radius: 3px;
        }

        form span {
            font-size: 14px;
            margin: 15px 0;
            display: block;
            color: var(--text-color);
        }

        form a {
            color: var(--primary-color);
            font-size: 14px;
            text-decoration: none;
            margin: 15px 0;
            transition: all 0.3s ease;
            position: relative;
        }

        /* Estilos para el grupo de cédula */
        .cedula-group {
            display: flex;
            width: 100%;
            gap: 10px;
        }

        .tipo-cedula {
            width: 60px !important;
            padding: 12px 5px !important;
            text-align: center;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 8px center;
            background-size: 12px;
            cursor: pointer;
            color: #000000 !important; /* Fuerza texto negro */
        }

        .tipo-cedula:focus {
            outline: none;
            box-shadow: 0 0 0 2px var(--primary-color);
        }

        /* Ajuste para el input de cédula */
        .cedula-group input {
            flex: 1;
            margin: 10px 0 !important;
        }

        form a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 1px;
            background: var(--primary-color);
            transition: width 0.3s ease;
        }

        form a:hover::after {
            width: 100%;
        }

        select {
            background-color: #eee;
            border: none;
            padding: 12px 15px;
            margin: 10px 0;
            width: 100%;
            border-radius: 5px;
            font-size: 14px;
            color: #000000 !important; /* Fuerza texto negro */
            transition: all 0.3s ease;
        }

        select:focus {
            outline: none;
            box-shadow: 0 0 0 2px var(--primary-color);
            transform: translateY(-2px);
        }

        /* Footer */
        .footer {
            background: var(--header-bg);
            padding: 80px 0 30px;
            color: var(--text-color);
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 50px;
        }

        .footer-column h3 {
            font-size: 20px;
            margin-bottom: 25px;
            color: var(--primary-color);
            position: relative;
            padding-bottom: 10px;
        }

        .footer-column h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 2px;
            background: var(--primary-color);
        }

        .footer-column p {
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: var(--text-color);
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .footer-links a:hover {
            color: var(--primary-color);
            padding-left: 5px;
        }

        .footer-links i {
            width: 20px;
            text-align: center;
        }

        .social-media {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .social-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: var(--primary-color);
            color: white;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .social-link:hover {
            background: var(--secondary-color);
            transform: translateY(-3px);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }

        /* Back to top button */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: var(--primary-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 999;
        }

        .back-to-top.active {
            opacity: 1;
            visibility: visible;
        }

        .back-to-top:hover {
            background: var(--secondary-color);
            transform: translateY(-5px);
        }

        /* Media Queries */
        @media (max-width: 992px) {
            .form-container {
                width: 700px;
            }
        }

        @media (max-width: 768px) {
            /* Menú hamburguesa para móviles */
            .menu-toggle {
                display: block;
            }
            
            .nav-menu {
                position: fixed;
                top: 0;
                right: -100%;
                width: 80%;
                max-width: 300px;
                height: 100vh;
                background-color: var(--header-bg);
                flex-direction: column;
                justify-content: center;
                align-items: center;
                gap: 30px;
                transition: all 0.5s ease;
                box-shadow: -5px 0 15px rgba(0, 0, 0, 0.2);
                z-index: 1000;
                padding: 20px;
            }
            
            .nav-menu.active {
                right: 0;
            }
            
            .header-container {
                gap: 15px;
            }
            
            .form-container {
                width: 100%;
                min-height: 650px;
            }
            
            .sign-in-container,
            .sign-up-container {
                width: 100%;
            }
            
            .overlay-container {
                display: none;
            }
            
            .form-container.right-panel-active .sign-in-container,
            .form-container.right-panel-active .sign-up-container {
                transform: none;
            }

            .auth-title {
                font-size: 2rem;
            }

            form {
                padding: 0 30px;
            }

            form h1 {
                font-size: 24px;
                margin-bottom: 20px;
            }
        }

        @media (max-width: 576px) {
            .auth-title {
                font-size: 1.8rem;
            }
            
            .footer-content {
                grid-template-columns: 1fr;
                text-align: center;
            }
            
            .footer-column h3::after {
                left: 50%;
                transform: translateX(-50%);
            }
            
            .social-media {
                justify-content: center;
            }

            form {
                padding: 0 20px;
            }

            button, button.ghost {
                padding: 12px 30px;
                font-size: 13px;
                max-width: 200px;
            }

            input, select {
                padding: 10px 12px;
                font-size: 13px;
            }
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="container header-container">
            <div class="logo">
                <img src="img/cafe/cafe.png" alt="Logotipo" class="logo-image">
                <h1 class="header-title"></h1>
            </div>
            
            <div class="header-controls">
                <button class="theme-toggle" id="themeToggle">🌙</button>
                
                <a href="carrito.php" class="cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-count" id="cartCounter">0</span>
                </a>
                
                <button class="menu-toggle" id="menuToggle">
                    <i class="fas fa-bars"></i>
                </button>
                
                <nav class="nav-menu" id="navMenu">
                    <a href="index.php" class="nav-link"><span>Inicio</span></a>
                    <a href="catalogo.php" class="nav-link">Productos</a>
                    <a href="nosotros.php" class="nav-link">Nosotros</a>
                    <a href="registrar.php" class="nav-link active">Registrarse</a>
                    <a href="inventario.php" class="nav-link">Inventario</a>
                    <a href="registro_empleado.php" class="nav-link">Generar Acceso</a>
                    <a href="diagrama_procesos.php" class="nav-link">Flujo Productos</a>
                    <a href="diagrama_bd.php" class="nav-link">Estructura BD</a>
                </nav>
            </div>
        </div>
    </header>

    <main class="auth-section">
        <div class="container">
            <h2 class="auth-title">Bienvenid@s a <br>El Café Con La Pan-dilla</h2>
            
            <div class="form-container" id="formContainer">
                <div class="form-container-inner sign-up-container">
                    <form action="php/registro_usuario_be.php" method="POST">
                        <h1>Crear Cuenta</h1>
                        <input type="text" placeholder="Nombre" name="nombre" required>
                        <input type="text" placeholder="Apellido" name="apellido" required>
                        <div class="cedula-group">
                            <select name="tipo_cedula" class="tipo-cedula" required>
                                <option value="V">V</option>
                                <option value="E">E</option>
                            </select>
                            <input type="text" name="cedula" placeholder="Cédula" pattern="[0-9]{6,15}" title="Solo números (6-15 dígitos)" required>
                        </div>
                        <input type="text" placeholder="Usuario" name="usuario" required>
                        <input type="email" placeholder="Email" name="correo" required>
                        <input type="password" placeholder="Contraseña" name="contrasena" minlength="8" required>
                        
                        <select name="rol" required>
                            <option value="" disabled selected>Seleccione su rol</option>
                            <option value="cliente">Cliente</option>
                            <option value="empleado">Empleado</option>
                        </select>
                        
                        <button type="submit">Crear cuenta</button>
                    </form>
                </div>
                <div class="form-container-inner sign-in-container">
                    <form action="php/login_usuario_be.php" method="POST">
                        <h1>Iniciar Sesión</h1>
                        <div class="social-container">
                            <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                        </div>
                        <span>O utiliza tu cuenta</span>
                        <input type="email" placeholder="Email" name="email" required>
                        <input type="password" placeholder="Contraseña" name="contrasena" required>
                        <div class="remember-me">
                            <input type="checkbox" id="recordar" name="recordar">
                            <label for="recordar">Recordar mi sesión</label>
                        </div>
                        <a href="#">¿Olvidaste tu contraseña?</a>
                        <button type="submit">Iniciar sesión</button>
                    </form>
                </div>
                <div class="overlay-container">
                    <div class="overlay">
                        <div class="overlay-panel overlay-left">
                            <h1>¡Bienvenido de nuevo!</h1>
                            <p>Para mantenerse conectado con nosotros, inicie sesión con su información personal.</p>
                            <button class="ghost" id="signIn">Iniciar sesión</button>
                        </div>
                        <div class="overlay-panel overlay-right">
                            <h1>Hola amig@</h1>
                            <p>Introduce tus datos personales para comenzar tu experiencia con nosotros</p>
                            <button class="ghost" id="signUp">Crear cuenta</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>El Café Con La Pan-dilla</h3>
                    <p>Desde 2010 ofreciendo los mejores productos artesanales de panadería y cafetería, elaborados con ingredientes naturales y mucho amor.</p>
                    <div class="social-media">
                        <a href="https://www.facebook.com/profile.php?id=100089772800592" class="social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.instagram.com/carlosgz9477/" class="social-link"><i class="fab fa-instagram"></i></a>
                        <a href="https://github.com/NoobCoderMaster69" class="social-link"><i class="fab fa-github"></i></a>
                    </div>
                </div>
                <div class="footer-column">
                    <h3>Enlaces rápidos</h3>
                    <ul class="footer-links">
                        <li><a href="index.php"><i class="fas fa-chevron-right"></i> Inicio</a></li>
                        <li><a href="catalogo.php"><i class="fas fa-chevron-right"></i> Productos</a></li>
                        <li><a href="nosotros.php"><i class="fas fa-chevron-right"></i> Nosotros</a></li>
                        <li><a href="registrar.php"><i class="fas fa-chevron-right"></i> Registrarse</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Contacto</h3>
                    <ul class="footer-links">
                        <li><a href="#"><i class="fas fa-map-marker-alt"></i> Av. Principal 123, Ciudad</a></li>
                        <li><a href="tel:+584244258944"><i class="fas fa-phone"></i> +58 424-4258944</a></li>
                        <li><a href="mailto:cg9477083@gmail.com"><i class="fas fa-envelope"></i> cg9477083@gmail.com</a></li>
                        <li><a href="#"><i class="fas fa-clock"></i> Lunes a Domingo: 7am - 8pm</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 El Café Con La Pan-dilla C.A. Todos los Derechos Reservados.</p>
            </div>
        </div>
    </footer>
    
    <div class="back-to-top" id="backToTop">
        <i class="fas fa-arrow-up"></i>
    </div>
    
    <audio id="backgroundMusic" loop>
        <source src="../musica/videoplayback (online-audio-converter.com).mp3" type="audio/mp3">
    </audio>

    <script>
        // Configuración del tema oscuro/claro
        const userPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        const currentTheme = localStorage.getItem('theme') || (userPrefersDark ? 'dark' : 'light');
        document.body.setAttribute('data-theme', currentTheme);

        const themeToggle = document.getElementById('themeToggle');
        if (themeToggle) {
            themeToggle.textContent = currentTheme === 'dark' ? '☀️' : '🌙';

            themeToggle.addEventListener('click', () => {
                const newTheme = document.body.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
                document.body.setAttribute('data-theme', newTheme);
                localStorage.setItem('theme', newTheme);
                themeToggle.textContent = newTheme === 'dark' ? '☀️' : '🌙';
            });
        }

        // Header scroll effect
        const header = document.querySelector('.header');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // Back to top button
        const backToTopButton = document.getElementById('backToTop');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                backToTopButton.classList.add('active');
            } else {
                backToTopButton.classList.remove('active');
            }
        });

        backToTopButton.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Música de fondo
        const audio = document.getElementById("backgroundMusic");
        if (audio) {
            audio.volume = 0.03;
            const lastTime = localStorage.getItem("audioCurrentTime") || 0;
            audio.currentTime = lastTime;
            audio.play().catch(e => console.log("Autoplay prevented:", e));
            audio.addEventListener("timeupdate", () => {
                localStorage.setItem("audioCurrentTime", audio.currentTime);
            });
        }

        // Contador del carrito (simulado)
        const cartCounter = document.getElementById('cartCounter');
        if (cartCounter) {
            const randomCount = Math.floor(Math.random() * 5) + 1;
            cartCounter.textContent = randomCount;
        }

        // Menú hamburguesa
        const menuToggle = document.getElementById('menuToggle');
        const navMenu = document.getElementById('navMenu');

        menuToggle.addEventListener('click', () => {
            navMenu.classList.toggle('active');
            menuToggle.innerHTML = navMenu.classList.contains('active') ? 
                '<i class="fas fa-times"></i>' : '<i class="fas fa-bars"></i>';
        });

        // Cerrar menú al hacer clic en un enlace (para móviles)
        const navLinks = document.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 768) {
                    navMenu.classList.remove('active');
                    menuToggle.innerHTML = '<i class="fas fa-bars"></i>';
                }
            });
        });

        // Funcionalidad del formulario de registro/login
        const signUpButton = document.getElementById('signUp');
        const signInButton = document.getElementById('signIn');
        const formContainer = document.getElementById('formContainer');

        // Animación mejorada para los botones
        const animateButton = (button) => {
            button.style.transform = 'scale(0.95)';
            button.style.boxShadow = '0 2px 5px rgba(0, 0, 0, 0.2)';
            
            setTimeout(() => {
                button.style.transform = '';
                button.style.boxShadow = '';
            }, 200);
        };

        signUpButton.addEventListener('click', (e) => {
            e.preventDefault();
            animateButton(signUpButton);
            formContainer.classList.add("right-panel-active");
            
            setTimeout(() => {
                document.querySelector('.sign-up-container h1').style.animation = 'fadeIn 0.6s ease-out';
                document.querySelector('.sign-up-container form').style.animation = 'fadeIn 0.6s ease-out 0.2s';
            }, 300);
        });

        signInButton.addEventListener('click', (e) => {
            e.preventDefault();
            animateButton(signInButton);
            formContainer.classList.remove("right-panel-active");
            
            setTimeout(() => {
                document.querySelector('.sign-in-container h1').style.animation = 'fadeIn 0.6s ease-out';
                document.querySelector('.sign-in-container form').style.animation = 'fadeIn 0.6s ease-out 0.2s';
            }, 300);
        });

        // Efecto hover mejorado para los botones
        const ghostButtons = document.querySelectorAll('.ghost');
        ghostButtons.forEach(button => {
            button.addEventListener('mouseenter', () => {
                button.style.transform = 'translateY(-3px)';
                button.style.boxShadow = '0 5px 15px rgba(0, 0, 0, 0.2)';
            });
            
            button.addEventListener('mouseleave', () => {
                if (!formContainer.classList.contains('right-panel-active') && button === signUpButton || 
                    formContainer.classList.contains('right-panel-active') && button === signInButton) {
                    button.style.transform = '';
                    button.style.boxShadow = '';
                }
            });
        });

        // Validación en tiempo real para nombre y apellido (solo letras)
        document.querySelectorAll('input[name="nombre"], input[name="apellido"]').forEach(input => {
            input.addEventListener('input', function() {
                const letrasRegex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]*$/;
                if (!letrasRegex.test(this.value)) {
                    this.style.borderColor = 'red';
                    // Eliminar caracteres no permitidos
                    this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]/g, '');
                } else {
                    this.style.borderColor = '';
                }
            });
        });

        // Validación de cédula en tiempo real (solo números)
        document.querySelector('input[name="cedula"]').addEventListener('input', function() {
            // Eliminar cualquier caracter que no sea número
            this.value = this.value.replace(/[^0-9]/g, '');
            
            // Validar longitud
            if (this.value.length > 15) {
                this.value = this.value.slice(0, 15);
            }
            
            // Cambiar color del borde según validación
            if (this.value.length < 6) {
                this.style.borderColor = 'red';
            } else {
                this.style.borderColor = 'green';
            }
        });

        // Validación al enviar el formulario de registro
        document.querySelector('form[action="php/registro_usuario_be.php"]').addEventListener('submit', function(e) {
            const nombre = document.querySelector('input[name="nombre"]').value;
            const apellido = document.querySelector('input[name="apellido"]').value;
            const cedula = document.querySelector('input[name="cedula"]').value;
            const letrasRegex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/;
            
            // Validar nombre y apellido
            if (!letrasRegex.test(nombre)) {
                e.preventDefault();
                alert('El nombre solo puede contener letras y espacios');
                return;
            }
            
            if (!letrasRegex.test(apellido)) {
                e.preventDefault();
                alert('El apellido solo puede contener letras y espacios');
                return;
            }
            
            // Validar cédula
            if (!/^[0-9]{6,15}$/.test(cedula)) {
                e.preventDefault();
                alert('La cédula debe contener entre 6 y 15 dígitos numéricos');
                return;
            }
        });

        // Validación al enviar el formulario de login
        document.querySelector('form[action="php/login_usuario_be.php"]').addEventListener('submit', function(e) {
            // Aquí puedes agregar validaciones adicionales para el login si es necesario
        });

        // Efectos de entrada para los formularios
        const forms = document.querySelectorAll('form');
        forms.forEach((form, index) => {
            form.style.opacity = '0';
            form.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                form.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
                form.style.opacity = '1';
                form.style.transform = 'translateY(0)';
            }, index * 200 + 300);
        });

        // Efecto para los inputs al enfocar
        const inputs = document.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.addEventListener('focus', () => {
                input.style.transform = 'translateY(-2px)';
                input.style.boxShadow = '0 0 0 2px var(--primary-color)';
            });
            
            input.addEventListener('blur', () => {
                input.style.transform = '';
                input.style.boxShadow = '';
            });
        });
    </script>
</body>
</html>