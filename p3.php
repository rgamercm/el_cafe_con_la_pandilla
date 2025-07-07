<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Producto - El Café Con La Pan-dilla</title>
    <link rel="shortcut icon" href="img/cafe.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Imperial+Script&family=Lobster&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <style>
        /* Variables y estilos base */
        :root {
            --primary-color: #d2691e;
            --secondary-color: #5a3921;
            --bg-color: #f5f5f5;
            --text-color: #333;
            --header-bg: #fdf2f2;
            --card-bg: #fff;
            --transition: all 0.3s ease;
            --background-color--registrar: #e0ecfa;
            --background-color-card: #faf3e0;
            --background-color-carusel: #c7c7c7a9;
            --background-color: rgb(245, 227, 227);
            --header-text-color: black;
            --hover-color: #747474;
            --dropdown-background: #f9f9f9;
            --dropdown-hover: #ddd;
        }

        [data-theme="dark"] {
            --bg-color: #131111;
            --text-color: #fff;
            --header-bg: #333;
            --card-bg: #2e2c27;
            --background-color--registrar: #878c91;
            --background-color-card: #2e2c27;
            --background-color-carusel: #111111a9;
            --background-color: #131111;
            --header-text-color: white;
            --hover-color: #575757;
            --dropdown-background: #333;
            --dropdown-hover: #575757;
        }

        /* Estilos generales */
        body {
            font-family: "Lobster", sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--bg-color);
            color: var(--text-color);
            transition: var(--transition);
        }

        /* Header */
        .header {
            background-color: var(--header-bg);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
            padding: 0.5rem 1rem;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0.5rem 0;
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
            font-size: 1.5rem;
            margin: 0;
            color: var(--primary-color);
            font-family: "Lobster", sans-serif;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }

        .header-controls {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .theme-toggle {
            background: transparent;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
            transition: transform 0.3s ease;
        }

        .theme-toggle:hover {
            transform: scale(1.1);
        }

        /* Navegación */
        .nav {
            display: flex;
            justify-content: center;
            gap: 1rem;
            padding: 0.5rem 0;
            background-color: rgba(210, 105, 30, 0.1);
            border-top: 1px solid rgba(0,0,0,0.1);
            border-bottom: 1px solid rgba(0,0,0,0.1);
        }

        .nav-link {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            position: relative;
            text-decoration: none;
            color: var(--text-color);
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--primary-color);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-link:hover::after, .nav-link.active::after {
            width: 80%;
        }

        /* Contenido principal */
        main {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .titulocard h2 {
            text-align: center;
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 2rem;
            position: relative;
        }

        .titulocard h2::after {
            content: '';
            display: block;
            width: 80px;
            height: 3px;
            background: var(--primary-color);
            margin: 0.5rem auto;
        }

        /* Estilos para las tarjetas de productos */
        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            padding: 0 1rem;
        }

        .card {
            background: var(--card-bg);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            padding: 1rem;
            text-align: center;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease;
            border-radius: 8px;
        }

        .card:hover img {
            transform: scale(1.03);
        }

        .card-text {
            padding: 1rem 0;
        }

        .card h2 {
            margin: 0 0 0.5rem;
            font-size: 1.5rem;
            color: var(--primary-color);
        }

        .card p {
            margin: 0.5rem 0;
            color: var(--text-color);
        }

        #addToCart {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 1rem;
        }

        #addToCart:hover {
            background: var(--secondary-color);
        }

        /* Estilos para el carrito */
        .cart {
            background: var(--card-bg);
            border-radius: 8px;
            padding: 1.5rem;
            margin-top: 2rem;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        .cart h2 {
            color: var(--primary-color);
            margin-bottom: 1rem;
            text-align: center;
        }

        #cartItems {
            list-style: none;
            padding: 0;
            margin: 0 0 1.5rem 0;
        }

        #cartItems li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
            border-bottom: 1px solid #eee;
        }

        .cart-item-controls {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .remove-one, .remove-all {
            background: #ff4444;
            color: white;
            border: none;
            padding: 0.3rem 0.6rem;
            border-radius: 4px;
            cursor: pointer;
            transition: var(--transition);
        }

        .remove-one {
            background: #ff7676;
        }

        .remove-all {
            background: #cc0000;
        }

        .remove-one:hover, .remove-all:hover {
            opacity: 0.9;
        }

        .item-quantity {
            min-width: 20px;
            text-align: center;
        }

        #totalPrice {
            font-weight: bold;
            font-size: 1.2rem;
            color: var(--primary-color);
            text-align: right;
            margin: 1rem 0;
        }

        #checkout {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 30px;
            font-weight: bold;
            cursor: pointer;
            transition: var(--transition);
            display: block;
            width: 100%;
            margin-top: 1rem;
        }

        #checkout:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
        }

        #checkout:disabled {
            background: #cccccc;
            cursor: not-allowed;
            transform: none;
        }

        /* Footer */
        .footer {
            background: var(--header-bg);
            padding: 2rem 1rem;
            margin-top: 3rem;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .footer p {
            margin: 0.5rem 0;
            line-height: 1.5;
        }

        .social-media {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .social-link {
            color: var(--text-color);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .social-link:hover {
            color: var(--primary-color);
        }

        /* Media Queries */
        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .header-title {
                font-size: 1.3rem;
            }
            
            .nav {
                flex-wrap: wrap;
                padding: 0.5rem;
            }
            
            .nav-link {
                padding: 0.3rem 0.5rem;
                font-size: 0.8rem;
            }
            
            .card-container {
                grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            }
        }

        @media (max-width: 480px) {
            .logo-image {
                height: 40px;
            }
            
            .header-title {
                font-size: 1.1rem;
            }
            
            .card-container {
                grid-template-columns: 1fr;
            }
            
            .footer-content {
                grid-template-columns: 1fr;
                text-align: center;
            }
            
            .social-media {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <!-- Header original de p1.php -->
        <div class="container header-container">
            <div class="logo">
                <img src="img/cafe/cafe.png" alt="Logotipo" class="logo-image">
                <h1 class="header-title">El Café Con La Pan-dilla</h1>
            </div>
            
            <div class="header-controls">
                <button class="theme-toggle" id="themeToggle">🌙</button>
                
                <a href="carrito.php" class="cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-count" id="cartCounter">0</span>
                </a>
            </div>
        </div>

        <nav class="nav">
            <div class="container">
                <a href="index.php" class="nav-link"><span>Inicio</span></a>
                <a href="catalogo.php" class="nav-link">Productos</a>
                <a href="nosotros.php" class="nav-link">Nosotros</a>
                <a href="registrar.php" class="nav-link">Registrarse</a>
            </div>
        </nav>
    </header>

    <?php include 'php/contenido_producto.php'; ?>
</body>
</html>