<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El Café Con La Pan-dilla</title>
    <link rel="shortcut icon" href="img/cafe.png" type="image/x-icon">
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

        /* Hero Section - Carrusel Mejorado */
        .hero {
            height: 80vh;
            min-height: 600px;
            position: relative;
            overflow: hidden;
            width: 100%;
        }

        .hero-slides-container {
            position: absolute;
            width: 100%;
            height: 100%;
            display: flex;
            transition: transform 1s cubic-bezier(0.645, 0.045, 0.355, 1);
        }

        .hero-slide {
            min-width: 100%;
            height: 100%;
            position: relative;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            transform: translateX(0);
            transition: transform 0.5s ease-out;
        }

        .hero-slide::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
        }

        /* About Section */
        .about-section {
            padding: var(--section-padding);
            background-color: var(--background-color-card);
        }

        .about-container {
            display: flex;
            align-items: center;
            gap: 50px;
        }

        .about-image {
            flex: 1;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--box-shadow);
        }

        .about-image img {
            width: 100%;
            height: auto;
            display: block;
            transition: transform 0.5s ease;
        }

        .about-image:hover img {
            transform: scale(1.05);
        }

        .about-content {
            flex: 1;
        }

        .about-content h2 {
            font-size: 36px;
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        .about-content p {
            margin-bottom: 20px;
            color: var(--text-color);
        }

        /* Productos destacados */
        .featured-products {
            padding: var(--section-padding);
            background-color: var(--bg-color);
        }

        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .card {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--box-shadow);
            transition: all 0.3s ease;
            position: relative;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        .card-image {
            height: 250px;
            overflow: hidden;
        }

        .card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .card:hover img {
            transform: scale(1.1);
        }

        .card-text {
            padding: 25px;
        }

        .card-text h3 {
            margin: 0 0 15px;
            font-size: 22px;
            color: var(--primary-color);
        }

        .card-text p {
            margin: 10px 0;
            color: var(--text-color);
        }

        .price {
            color: var(--primary-color);
            font-weight: bold;
            font-size: 20px;
            margin: 15px 0;
            display: block;
        }

        .card-badge {
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

        /* Testimonials */
        .testimonials {
            padding: var(--section-padding);
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('img/cafe/cafe-background.jpg') no-repeat center center/cover;
            color: white;
            text-align: center;
        }

        .testimonials .section-title h2,
        .testimonials .section-title p {
            color: white;
        }

        .testimonials .section-title::after {
            background: white;
        }

        .testimonial-container {
            display: flex;
            gap: 30px;
            overflow-x: auto;
            padding: 20px 0;
            scroll-snap-type: x mandatory;
        }

        .testimonial-card {
            min-width: 300px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: var(--border-radius);
            padding: 30px;
            scroll-snap-align: start;
            transition: all 0.3s ease;
        }

        .testimonial-card:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.2);
        }

        .testimonial-text {
            font-style: italic;
            margin-bottom: 20px;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 15px;
            justify-content: center;
        }

        .author-image {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            overflow: hidden;
        }

        .author-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .author-info h4 {
            margin: 0;
            font-size: 18px;
        }

        .author-info p {
            margin: 5px 0 0;
            font-size: 14px;
            opacity: 0.8;
        }

        /* Newsletter */
        .newsletter {
            padding: var(--section-padding);
            background-color: var(--primary-color);
            color: white;
            text-align: center;
        }

        .newsletter h2 {
            margin-bottom: 20px;
        }

        .newsletter p {
            max-width: 600px;
            margin: 0 auto 30px;
        }

        .newsletter-form {
            display: flex;
            max-width: 500px;
            margin: 0 auto;
        }

        .newsletter-input {
            flex: 1;
            padding: 15px;
            border: none;
            border-radius: 30px 0 0 30px;
            font-size: 16px;
        }

        .newsletter-btn {
            padding: 15px 30px;
            background: var(--secondary-color);
            color: white;
            border: none;
            border-radius: 0 30px 30px 0;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .newsletter-btn:hover {
            background: #3a2515;
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
            .about-container {
                flex-direction: column;
            }
            
            .hero h1 {
                font-size: 36px;
            }
            
            .hero p {
                font-size: 18px;
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
            
            .hero {
                height: auto;
                padding: 100px 0;
                min-height: auto;
            }
            
            .hero-content {
                padding-top: 80px;
                padding-bottom: 80px;
            }
            
            .newsletter-form {
                flex-direction: column;
                gap: 15px;
            }
            
            .newsletter-input,
            .newsletter-btn {
                border-radius: 30px;
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            .section-title h2 {
                font-size: 28px;
            }
            
            .card-container {
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
            
            .hero h1 {
                font-size: 32px;
            }
            
            .hero p {
                font-size: 16px;
            }
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="container header-container">
            <div class="logo">
                <img src="img/cafe/cafe.png" alt="Logotipo" class="logo-image">
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
                    <a href="registrar.php" class="nav-link">Registrarse</a>
                </nav>
            </div>
        </div>
    </header>
    <main>
        <!-- Hero Section con Carrusel Mejorado -->
        <section class="hero">
            <div class="hero-slides-container" id="heroSlidesContainer">
                <!-- Las imágenes se cargarán automáticamente desde JavaScript -->
            </div>
        </section>

        <!-- About Section -->
        <section class="about-section">
            <div class="container">
                <div class="about-container">
                    <div class="about-image">
                        <img src="img/cafe/cafe-shop.jpg" alt="Nuestra cafetería">
                    </div>
                    <div class="about-content">
                        <h2>Nuestra Historia</h2>
                        <p>Desde 2010, "El Café Con La Pan-dilla" ha sido un refugio para los amantes del buen café y el pan artesanal. Lo que comenzó como un pequeño local familiar se ha convertido en un referente de calidad y tradición en nuestra comunidad.</p>
                        <p>Nuestros maestros panaderos trabajan durante la noche para que puedas disfrutar de pan recién horneado cada mañana, mientras que nuestros baristas seleccionan los mejores granos de café para ofrecerte una experiencia única.</p>
                        <a href="nosotros.php" class="btn">Más sobre nosotros</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Productos destacados -->
        <section class="featured-products">
            <div class="container">
                <div class="section-title">
                    <h2>Nuestros Productos Destacados</h2>
                    <p>Descubre nuestras creaciones más populares, elaboradas con ingredientes de la más alta calidad y mucho amor.</p>
                </div>
                <div class="card-container">
                    <div class="card">
                        <div class="card-badge">Más vendido</div>
                        <div class="card-image">
                            <a href="p1.php"><img src="img/cafe/coffee (3).jpg" alt="Café Capuchino"></a>
                        </div>
                        <div class="card-text">
                            <h3><a href="p1.php">Café Capuchino</a></h3>
                            <p>Delicioso café con espuma cremosa y aroma irresistible, perfecto para empezar el día.</p>
                            <span class="price">$1.60</span>
                            <a href="p1.php" class="btn">Ver detalles</a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-badge">Recomendado</div>
                        <div class="card-image">
                            <a href="p2.php"><img src="img/panes/Sandwich Bread WITHOUT yeast.jpg" alt="Pan Artesanal"></a>
                        </div>
                        <div class="card-text">
                            <h3><a href="p2.php">Pan Artesanal</a></h3>
                            <p>Pan recién horneado con ingredientes naturales, masa madre y larga fermentación.</p>
                            <span class="price">$3.60</span>
                            <a href="p2.php" class="btn">Ver detalles</a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-badge">Novedad</div>
                        <div class="card-image">
                            <a href="p3.php"><img src="img/tortas/tortas (3).jpg" alt="Helado con Oreo"></a>
                        </div>
                        <div class="card-text">
                            <h3><a href="p3.php">Helado con Oreo</a></h3>
                            <p>Delicioso helado artesanal con trozos de galleta Oreo, ideal para días calurosos.</p>
                            <span class="price">$4.60</span>
                            <a href="p3.php" class="btn">Ver detalles</a>
                        </div>
                    </div>
                </div>
                <div class="view-more-container">
                    <a href="catalogo.php" class="btn">Ver Todos los Productos</a>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section class="testimonials">
            <div class="container">
                <div class="section-title">
                    <h2>Lo que dicen nuestros clientes</h2>
                    <p>La satisfacción de nuestros clientes es nuestra mejor recompensa</p>
                </div>
                <div class="testimonial-container">
                    <div class="testimonial-card">
                        <div class="testimonial-text">
                            "El mejor café de la ciudad, sin duda. Cada vez que paso por aquí me llevo un pan recién hecho y un capuchino. ¡Insuperable!"
                        </div>
                        <div class="testimonial-author">
                            <div class="author-image">
                                <img src="img/testimonials/person1.jpg" alt="María González">
                            </div>
                            <div class="author-info">
                                <h4>María González</h4>
                                <p>Cliente frecuente</p>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-card">
                        <div class="testimonial-text">
                            "El ambiente es acogedor y el personal muy amable. Sus croissants son adictivos, los mejores que he probado fuera de Francia."
                        </div>
                        <div class="testimonial-author">
                            <div class="author-image">
                                <img src="img/testimonials/person2.jpg" alt="Carlos Rodríguez">
                            </div>
                            <div class="author-info">
                                <h4>Carlos Rodríguez</h4>
                                <p>Food Blogger</p>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-card">
                        <div class="testimonial-text">
                            "Siempre que tengo una reunión de trabajo, la programo aquí. El café es excelente y el wifi funciona perfectamente. ¡Muy recomendado!"
                        </div>
                        <div class="testimonial-author">
                            <div class="author-image">
                                <img src="img/testimonials/person3.jpg" alt="Laura Méndez">
                            </div>
                            <div class="author-info">
                                <h4>Laura Méndez</h4>
                                <p>Empresaria</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Newsletter Section -->
        <section class="newsletter">
            <div class="container">
                <h2>Suscríbete a nuestro newsletter</h2>
                <p>Recibe nuestras promociones, novedades y consejos directamente en tu correo electrónico.</p>
                <form class="newsletter-form">
                    <input type="email" class="newsletter-input" placeholder="Tu correo electrónico" required>
                    <button type="submit" class="newsletter-btn">Suscribirse</button>
                </form>
            </div>
        </section>
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
        <source src="./musica/videoplayback (online-audio-converter.com).mp3" type="audio/mp3">
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

        // Testimonials carousel
        const testimonialContainer = document.querySelector('.testimonial-container');
        if (testimonialContainer) {
            let isDown = false;
            let startX;
            let scrollLeft;

            testimonialContainer.addEventListener('mousedown', (e) => {
                isDown = true;
                startX = e.pageX - testimonialContainer.offsetLeft;
                scrollLeft = testimonialContainer.scrollLeft;
            });

            testimonialContainer.addEventListener('mouseleave', () => {
                isDown = false;
            });

            testimonialContainer.addEventListener('mouseup', () => {
                isDown = false;
            });

            testimonialContainer.addEventListener('mousemove', (e) => {
                if (!isDown) return;
                e.preventDefault();
                const x = e.pageX - testimonialContainer.offsetLeft;
                const walk = (x - startX) * 2;
                testimonialContainer.scrollLeft = scrollLeft - walk;
            });
        }

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

        // Carrusel Hero Section Mejorado con efecto de deslizamiento continuo
        const heroSlidesContainer = document.getElementById('heroSlidesContainer');
        
        // Configuración del carrusel - AQUÍ DEBES AGREGAR TUS IMÁGENES Y AJUSTAR LA VELOCIDAD
        const carouselSettings = {
            images: [
                'img/carrusel/1.jpg',
                'img/carrusel/2.jpg',
                'img/carrusel/3.jpg',
                // Añade más rutas de imágenes aquí según necesites
                // Ejemplo: 'img/carrusel/4.jpg', 'img/carrusel/5.jpg'
            ],
            transitionSpeed: 1000, // Velocidad de transición en milisegundos (1 segundo)
            slideDuration: 5000    // Duración de cada slide en milisegundos (5 segundos)
        };
        
        // Crear slides dinámicamente
        function createSlides() {
            heroSlidesContainer.innerHTML = '';
            
            // Duplicamos las imágenes para crear un efecto de bucle infinito
            const allImages = [...carouselSettings.images, ...carouselSettings.images];
            
            allImages.forEach((image, index) => {
                const slide = document.createElement('div');
                slide.className = 'hero-slide';
                slide.style.backgroundImage = `url('${image}')`;
                heroSlidesContainer.appendChild(slide);
            });
            
            // Iniciar el carrusel
            startCarousel();
        }
        
        // Iniciar el carrusel con efecto de deslizamiento continuo
        function startCarousel() {
            const slides = document.querySelectorAll('.hero-slide');
            let currentIndex = 0;
            const totalSlides = carouselSettings.images.length;
            let isAnimating = false;
            
            // Posicionamos el carrusel al inicio
            heroSlidesContainer.style.transform = 'translateX(0)';
            
            // Función para cambiar de slide
            function goToNextSlide() {
                if (isAnimating) return;
                
                isAnimating = true;
                currentIndex++;
                
                // Aplicamos la transición
                heroSlidesContainer.style.transition = `transform ${carouselSettings.transitionSpeed}ms cubic-bezier(0.645, 0.045, 0.355, 1)`;
                heroSlidesContainer.style.transform = `translateX(-${currentIndex * 100}%)`;
                
                // Cuando llegamos al final (que es el inicio duplicado), reiniciamos sin animación
                if (currentIndex >= totalSlides) {
                    setTimeout(() => {
                        heroSlidesContainer.style.transition = 'none';
                        heroSlidesContainer.style.transform = 'translateX(0)';
                        currentIndex = 0;
                        isAnimating = false;
                    }, carouselSettings.transitionSpeed);
                } else {
                    setTimeout(() => {
                        isAnimating = false;
                    }, carouselSettings.transitionSpeed);
                }
            }
            
            // Configurar intervalo para cambio automático
            let carouselInterval = setInterval(goToNextSlide, carouselSettings.slideDuration);
            
            // Pausar al hacer hover
            heroSlidesContainer.addEventListener('mouseenter', () => {
                clearInterval(carouselInterval);
            });
            
            // Reanudar al salir del hover
            heroSlidesContainer.addEventListener('mouseleave', () => {
                carouselInterval = setInterval(goToNextSlide, carouselSettings.slideDuration);
            });
            
            // Manejar el evento de cambio de tamaño de ventana
            window.addEventListener('resize', () => {
                heroSlidesContainer.style.transform = `translateX(-${currentIndex * 100}%)`;
            });
        }
        
        // Inicializar el carrusel cuando el DOM esté listo
        document.addEventListener('DOMContentLoaded', createSlides);
    </script>
</body>
</html>