<?php
require_once '../php/verificar_sesion.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - El Café Con La Pan-dilla</title>
    <link rel="shortcut icon" href="../img/cafe.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Imperial+Script&family=Lobster&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Variables y estilos base */
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

        /* Productos destacados */
        .products-section {
            padding: var(--section-padding);
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
        }

        .product-card {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--box-shadow);
            transition: all 0.3s ease;
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .product-image {
            height: 200px;
            overflow: hidden;
        }

        .product-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .product-card:hover img {
            transform: scale(1.05);
        }

        .product-content {
            padding: 20px;
        }

        .product-content h3 {
            margin: 0 0 10px;
            font-size: 18px;
            color: var(--primary-color);
        }

        .product-content p {
            margin: 10px 0;
            color: var(--text-color);
            font-size: 14px;
            line-height: 1.5;
        }

        .price {
            color: var(--primary-color);
            font-weight: bold;
            font-size: 18px;
            margin: 15px 0;
            display: block;
        }

        .product-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--primary-color);
            color: white;
            padding: 5px 15px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            z-index: 1;
        }

        .view-more-container {
            text-align: center;
            margin-top: 50px;
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
            .products-grid {
                grid-template-columns: repeat(2, 1fr);
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
        }

        @media (max-width: 576px) {
            .section-title h2 {
                font-size: 28px;
            }
            
            .products-grid {
                grid-template-columns: 1fr;
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
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="container header-container">
            <div class="logo">
                <img src="../img/cafe/cafe.png" alt="Logotipo" class="logo-image">
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
                    <a href="index2.php" class="nav-link"><span>Inicio</span></a>
                    <a href="catalogo.php" class="nav-link">Productos</a>
                    <a href="nosotros.php" class="nav-link">Nosotros</a>
                    <a href="registrar.php" class="nav-link">Registrarse</a>
                    <a href="inventario.php" class="nav-link">Inventario</a>
                    <a href="registro_empleado.php" class="nav-link">Generar Acceso</a>
                    <a href="diagrama_procesos.php" class="nav-link">Flujo Productos</a>
                    <a href="diagrama_bd.php" class="nav-link">Estructura BD</a>
                </nav>
            </div>
        </div>
    </header>

    <main class="products-section">
        <div class="container">
            <div class="section-title">
                <h2>Nuestros Productos</h2>
                <p>Descubre nuestras deliciosas creaciones, elaboradas con ingredientes de la más alta calidad y mucho amor.</p>
            </div>
            
            <div class="products-grid">
                <!-- Producto 1 - Café Capuchino -->
                <div class="product-card">
                    <div class="product-badge">Popular</div>
                    <div class="product-image">
                        <a href="p1.php"><img src="../img/productosgeneral/1_Maracaibo Mocha (Chocolate venezolano + espresso + leche cremosa.png" alt="Café Capuchino"></a>
                    </div>
                    <div class="product-content">
                        <h3><a href="p1.php">Maracaibo Mocha</a></h3>
                        <p>Chocolate venezolano + espresso + leche cremosa. </p>
                        <span class="price"></span>
                        <a href="p1.php" class="btn">Ver detalles</a>
                    </div>
                </div>
                
                <!-- Producto 2 - Pan Artesanal -->
                <div class="product-card">
                    <div class="product-badge">Recomendado</div>
                    <div class="product-image">
                        <a href="p2.php"><img src="../img/productosgeneral/2_Café Catire (Leche dorada (cúrcuma) + espresso + miel de abeja).png" alt="Pan Artesanal"></a>
                    </div>
                    <div class="product-content">
                        <h3><a href="p2.php">Café Catire</a></h3>
                        <p>Leche dorada (cúrcuma) + espresso + miel de abeja.</p>
                        <span class="price"> </span>
                        <a href="p2.php" class="btn">Ver detalles</a>
                    </div>
                </div>
                
                <!-- Producto 3 - Café Expreso -->
                <div class="product-card">
                    <div class="product-badge">Especial</div>
                    <div class="product-image">
                        <a href="p3.php"><img src="../img/productosgeneral/3_Chorreado de Oriente (Café colado en tela con notas de cacao).png" alt="Café Expreso"></a>
                    </div>
                    <div class="product-content">
                        <h3><a href="p3.php">Chorreado de Oriente</a></h3>
                        <p>Café colado en tela con notas de cacao.</p>
                        <span class="price"></span>
                        <a href="p3.php" class="btn">Ver detalles</a>
                    </div>
                </div>
                
                <!-- Producto 4 - Torta de Chocolate -->
                <div class="product-card">
                    <div class="product-badge">Nuevo</div>
                    <div class="product-image">
                        <a href="p4.php"><img src="../img/productosgeneral/4_Paragüitas (Café helado con coco rallado y leche de almendras).png"></a>
                    </div>
                    <div class="product-content">
                        <h3><a href="p4.php">Paragüitas</a></h3>
                        <p>Café helado con coco rallado y leche de almendras.</p>
                        <span class="price"></span>
                        <a href="p4.php" class="btn">Ver detalles</a>
                    </div>
                </div>
                
                <!-- Producto 5 - Pan Con Forma de Gato -->
                <div class="product-card">
                    <div class="product-badge">Divertido</div>
                    <div class="product-image">
                        <a href="p5.php"><img src="../img/productosgeneral/5_Café en Piedra (Espresso servido sobre una piedra de chocolate para rallar).png" alt="Pan Con Forma de Gato"></a>
                    </div>
                    <div class="product-content">
                        <h3><a href="p5.php">Café en Piedra</a></h3>
                        <p>Espresso servido sobre una piedra de chocolate para rallar.</p>
                        <span class="price"></span>
                        <a href="p5.php" class="btn">Ver detalles</a>
                    </div>
                </div>
                
                <!-- Producto 6 - Helado Con Oreo -->
                <div class="product-card">
                    <div class="product-badge">Fresco</div>
                    <div class="product-image">
                        <a href="p6.php"><img src="../img/productosgeneral/6_Pan de PANA’ (Pan artesanal con harina de maíz y mantequilla).jpeg.jpg" alt="Helado Con Oreo"></a>
                    </div>
                    <div class="product-content">
                        <h3><a href="p6.php">Pan de PANA</a></h3>
                        <p>Pan artesanal con harina de maíz y mantequilla.</p>
                        <span class="price"></span>
                        <a href="p6.php" class="btn">Ver detalles</a>
                    </div>
                </div>
                
                <!-- Producto 7 - Helado Con Oreo -->
                <div class="product-card">
                    <div class="product-badge">Fresco</div>
                    <div class="product-image">
                        <a href="p7.php"><img src="../img/productosgeneral/7_Cachitos Rebeldes (Hojaldre relleno de pernil y queso amarillo).jpeg.jpg" alt="Helado Con Oreo"></a>
                    </div>
                    <div class="product-content">
                        <h3><a href="p7.php">Cachitos Rebeldes</a></h3>
                        <p>Hojaldre relleno de pernil y queso amarillo.</p>
                        <span class="price"></span>
                        <a href="p7.php" class="btn">Ver detalles</a>
                    </div>
                </div>
                
                <!-- Producto 8 - Helado Con Oreo -->
                <div class="product-card">
                    <div class="product-badge">Fresco</div>
                    <div class="product-image">
                        <a href="p8.php"><img src="../img/productosgeneral/8_Bollitos Pelones (Pan de maíz relleno de caraotas negras).jpeg.jpg" alt="Helado Con Oreo"></a>
                    </div>
                    <div class="product-content">
                        <h3><a href="p8.php">Bollitos Pelones</a></h3>
                        <p>Pan de maíz relleno de caraotas negras</p>
                        <span class="price"></span>
                        <a href="p8.php" class="btn">Ver detalles</a>
                    </div>
                </div>
                
                <!-- Producto 9 - Helado Con Oreo -->
                <div class="product-card">
                    <div class="product-badge">Fresco</div>
                    <div class="product-image">
                        <a href="p9.php"><img src="../img/productosgeneral/9_Pan de Queso Llanero (Qeso de mano derretido en pan campesino).jpeg.jpg" alt="Helado Con Oreo"></a>
                    </div>
                    <div class="product-content">
                        <h3><a href="p9.php">Pan de Queso Llanero</a></h3>
                        <p>Qeso de mano derretido en pan campesino</p>
                        <span class="price"></span>
                        <a href="p9.php" class="btn">Ver detalles</a>
                    </div>
                </div>
                
                <!-- Producto 10 - Helado Con Oreo -->
                <div class="product-card">
                    <div class="product-badge">Fresco</div>
                    <div class="product-image">
                        <a href="p10.php"><img src="../img/productosgeneral/10_Pan de Coco Punk (Coco rallado y panela en masa esponjosa).jpeg.jpg" alt="Helado Con Oreo"></a>
                    </div>
                    <div class="product-content">
                        <h3><a href="p10.php">Pan de Coco Punk</a></h3>
                        <p>Coco rallado y panela en masa esponjosa</p>
                        <span class="price"></span>
                        <a href="p10.php" class="btn">Ver detalles</a>
                    </div>
                </div>
                
                <!-- Producto 11 - Helado Con Oreo -->
                <div class="product-card">
                    <div class="product-badge">Fresco</div>
                    <div class="product-image">
                        <a href="p11.php"><img src="../img/productosgeneral/11_Palos de Ajo (Bastones de pan con ajo y perejil, estilo venezolano).jpeg.jpg" alt="Helado Con Oreo"></a>
                    </div>
                    <div class="product-content">
                        <h3><a href="p11.php">Palos de Ajo</a></h3>
                        <p>Bastones de pan con ajo y perejil, estilo venezolano</p>
                        <span class="price">$4.60</span>
                        <a href="p11.php" class="btn">Ver detalles</a>
                    </div>
                </div>
                
                <!-- Producto 12 - Helado Con Oreo -->
                <div class="product-card">
                    <div class="product-badge">Fresco</div>
                    <div class="product-image">
                        <a href="p12.php"><img src="../img/productosgeneral/12_Mochila de Chocolate (Torta negra con relleno de ganache y café).png" alt="Helado Con Oreo"></a>
                    </div>
                    <div class="product-content">
                        <h3><a href="p12.php">Mochila de Chocolate</a></h3>
                        <p>Torta negra con relleno de ganache y café.</p>
                        <span class="price"></span>
                        <a href="p12.php" class="btn">Ver detalles</a>
                    </div>
                </div>
                
                <!-- Producto 13 - Helado Con Oreo -->
                <div class="product-card">
                    <div class="product-badge">Fresco</div>
                    <div class="product-image">
                        <a href="p13.php"><img src="../img/productosgeneral/13_Dulce de Lechosa (Lechosa verde en almíbar con especias).jpg" alt="Helado Con Oreo"></a>
                    </div>
                    <div class="product-content">
                        <h3><a href="p13.php">Dulce de Lechosa</a></h3>
                        <p>Lechosa verde en almíbar con especias</p>
                        <span class="price"></span>
                        <a href="p13.php" class="btn">Ver detalles</a>
                    </div>
                </div>
                
                <!-- Producto 14 - Helado Con Oreo -->
                <div class="product-card">
                    <div class="product-badge">Fresco</div>
                    <div class="product-image">
                        <a href="p14.php"><img src="../img/productosgeneral/14_conserva de Coco (Cocadas con panela y limón).jpg" alt="Helado Con Oreo"></a>
                    </div>
                    <div class="product-content">
                        <h3><a href="p14.php">Conservas de Coco</a></h3>
                        <p>dulce tradicional venezolano hecho con coco rallado y azúcar, cocinado hasta obtener una textura caramelizada, y luego moldeado en porciones individuales</p>
                        <span class="price"></span>
                        <a href="p14.php" class="btn">Ver detalles</a>
                    </div>
                </div>
                
                <!-- Producto 15 - Helado Con Oreo -->
                <div class="product-card">
                    <div class="product-badge">Fresco</div>
                    <div class="product-image">
                        <a href="p15.php"><img src="../img/productosgeneral/15_torta Mandarinas en Miel (Gajos de mandarina caramelizados con anís).jpeg" alt="Helado Con Oreo"></a>
                    </div>
                    <div class="product-content">
                        <h3><a href="p15.php">Torta Mandarinas en Miel </a></h3>
                        <p>Gajos de mandarina caramelizados con anís</p>
                        <span class="price"></span>
                        <a href="p15.php" class="btn">Ver detalles</a>
                    </div>
                </div>
            </div>
            
            <div class="view-more-container">
                <a href="catalogo.php" class="btn">Ver Todos los Productos</a>
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
                        <li><a href="index2.php"><i class="fas fa-chevron-right"></i> Inicio</a></li>
                        <li><a href="catalogo.php"><i class="fas fa-chevron-right"></i> Productos</a></li>
                        <li><a href="inventario.php"><i class="fas fa-chevron-right"></i> Inventario</a></li>
                        <li><a href="registro_empleado.php"><i class="fas fa-chevron-right"></i> Registro Empleado</a></li>
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
            // Simular productos en el carrito (en una aplicación real esto vendría de tu backend)
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
    </script>
</body>
</html>