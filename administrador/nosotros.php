<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nosotros - El Café Con La Pan-dilla</title>
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

        /* Cards Section */
        .cards-section {
            padding: var(--section-padding);
            background-color: var(--bg-color);
        }

        .card-all {
            display: flex;
            flex-direction: column;
            gap: 40px;
        }

        .noso-card {
            display: flex;
            align-items: center;
            gap: 40px;
            background: var(--card-bg);
            border-radius: var(--border-radius);
            padding: 30px;
            box-shadow: var(--box-shadow);
            transition: all 0.3s ease;
        }

        .noso-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .noso-card img {
            width: 400px;
            height: 300px;
            object-fit: cover;
            border-radius: var(--border-radius);
            transition: transform 0.5s ease;
        }

        .noso-card:hover img {
            transform: scale(1.03);
        }

        .noso-card p {
            flex: 1;
            line-height: 1.8;
            color: var(--text-color);
            font-size: 16px;
        }

        .noso-card:nth-child(even) {
            flex-direction: row-reverse;
        }

        /* Misión, Visión y Objetivo Section */
        .mvv-section {
            padding: var(--section-padding);
            background-color: var(--background-color-card);
        }

        .mvv-container {
            display: flex;
            flex-direction: column;
            gap: 60px;
        }

        .mvv-item {
            display: flex;
            align-items: center;
            gap: 50px;
            background: var(--card-bg);
            border-radius: var(--border-radius);
            padding: 40px;
            box-shadow: var(--box-shadow);
            transition: all 0.3s ease;
        }

        .mvv-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .mvv-content {
            flex: 1;
        }

        .mvv-content h3 {
            font-size: 28px;
            color: var(--primary-color);
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
        }

        .mvv-content h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background: var(--primary-color);
        }

        .mvv-content p {
            margin-bottom: 15px;
            color: var(--text-color);
            line-height: 1.8;
        }

        .mvv-image {
            flex: 1;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--box-shadow);
        }

        .mvv-image img {
            width: 100%;
            height: auto;
            display: block;
            transition: transform 0.5s ease;
        }

        .mvv-image:hover img {
            transform: scale(1.05);
        }

        .mvv-item:nth-child(even) {
            flex-direction: row-reverse;
        }

        /* Footer */
        .footer {
            background: var(--header-bg);
            padding: 80px 0 30px;
            color: var(--header-text);
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
            color: var(--header-text);
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
            border-top: 1px solid rgba(255, 255, 255, 0.1);
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
        @media (max-width: 1200px) {
            .noso-card img {
                width: 350px;
                height: 250px;
            }
        }

        @media (max-width: 992px) {
            .about-container {
                flex-direction: column;
            }
            
            .noso-card, .mvv-item {
                flex-direction: column;
                gap: 30px;
            }
            
            .noso-card:nth-child(even), .mvv-item:nth-child(even) {
                flex-direction: column;
            }
            
            .noso-card img, .mvv-image img {
                width: 100%;
                height: auto;
                max-height: 300px;
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
            
            .noso-card, .mvv-item {
                padding: 20px;
            }
        }

        @media (max-width: 576px) {
            .section-title h2 {
                font-size: 28px;
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
            
            .noso-card, .mvv-item {
                padding: 15px;
            }
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="container header-container">
            <div class="logo">
                <img src="../img/cafe/cafe1.png" alt="Logotipo" class="logo-image">
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
                    <a href="diagrama_bd.php" class="nav-link">Estructura BD</a>
                    <a href="estadisticas.php" class="nav-link">Estadísticas</a>
                </nav>
            </div>
        </div>
    </header>
    
    <main>
        <!-- Hero Section -->
        <section class="about-section">
            <div class="container">
                <div class="about-container">
                    <div class="about-image">
                        <img src="../img/cafe/cafe-shop.jpg" alt="Nuestra cafetería">
                    </div>
                    <div class="about-content">
                        <h2>Nuestra Historia</h2>
                        <p>Desde 2010, "El Café Con La Pan-dilla" ha sido un refugio para los amantes del buen café y el pan artesanal. Lo que comenzó como un pequeño local familiar se ha convertido en un referente de calidad y tradición en nuestra comunidad.</p>
                        <p>Nuestros maestros panaderos trabajan durante la noche para que puedas disfrutar de pan recién horneado cada mañana, mientras que nuestros baristas seleccionan los mejores granos de café para ofrecerte una experiencia única.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Misión, Visión y Objetivo Section -->
        <section class="mvv-section">
            <div class="container">
                <div class="section-title">
                    <h2>Nuestros Fundamentos</h2>
                    <p>Conoce los principios que nos guían y nos inspiran cada día</p>
                </div>
                
                <div class="mvv-container">
                    <div class="mvv-item">
                        <div class="mvv-content">
                            <h3>Misión</h3>
                            <p>En "El Café Con La Pan-dilla", nos comprometemos a ofrecer experiencias gastronómicas memorables a través de productos artesanales de la más alta calidad. Nuestra misión es crear un espacio cálido y acogedor donde cada cliente se sienta como en casa, disfrutando de pan recién horneado, café de especialidad y postres exquisitos, todos elaborados con ingredientes naturales y procesos tradicionales.</p>
                            <p>Buscamos preservar las recetas auténticas mientras innovamos con sabores contemporáneos, manteniendo siempre nuestro compromiso con la excelencia y la satisfacción de nuestros clientes.</p>
                        </div>
                        <div class="mvv-image">
                            <img src="../img/mision/mision.png" alt="Nuestra misión">
                        </div>
                    </div>
                    
                    <div class="mvv-item">
                        <div class="mvv-content">
                            <h3>Visión</h3>
                            <p>Aspiramos a ser reconocidos como el referente de cafetería-panadería artesanal en nuestra región, destacando por nuestra autenticidad, calidad y servicio excepcional. Visualizamos un futuro donde "El Café Con La Pan-dilla" expanda su presencia manteniendo siempre su esencia familiar y su compromiso con la comunidad.</p>
                            <p>Nuestra visión incluye ser líderes en prácticas sostenibles, desde el abastecimiento responsable de ingredientes hasta la reducción de nuestro impacto ambiental, convirtiéndonos en un modelo de negocio gastronómico ético y responsable.</p>
                        </div>
                        <div class="mvv-image">
                            <img src="../img/mision/vision.png" alt="Nuestra visión">
                        </div>
                    </div>
                    
                    <div class="mvv-item">
                        <div class="mvv-content">
                            <h3>Objetivo</h3>
                            <p>Nuestro principal objetivo es superar las expectativas de nuestros clientes día tras día, ofreciendo productos frescos, sabrosos y consistentes. Nos esforzamos por mantener los más altos estándares de calidad en cada etapa de nuestro proceso, desde la selección de ingredientes hasta la presentación final.</p>
                            <p>Buscamos fomentar la cultura del buen comer, educando a nuestros clientes sobre los procesos artesanales y el valor de los productos naturales. Además, aspiramos a ser un pilar en nuestra comunidad, apoyando productores locales y participando activamente en iniciativas sociales que mejoren nuestro entorno.</p>
                        </div>
                        <div class="mvv-image">
                            <img src="../img/mision/objetivo.png" alt="Nuestro objetivo">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Cards Section -->
        <section class="cards-section">
            <div class="container">
                <div class="card-all">
                    <div class="noso-card">
                        <img src="../img/panes/panes.jpg" alt="panes">
                        <p>En "El Café con La Pan-dilla", creemos que cada bocado cuenta una historia y que cada taza de café
                            puede ser el inicio de algo especial. Nuestra misión es ofrecer productos frescos y auténticos que hagan
                            sentir a cada visitante como en casa. Desde panes artesanales y pasteles delicadamente horneados, hasta el café
                            perfecto para acompañarlos, trabajamos día a día para brindar una experiencia de calidad y calidez.</p>
                    </div>
                    <div class="noso-card">
                        <p>Nuestra historia comenzó con una pasión compartida por la buena panadería y el placer de reunir a las
                            personas en torno a una mesa. Con un equipo comprometido y una inspiración en los sabores de siempre, creamos un
                            espacio donde la tradición se encuentra con la innovación, ofreciendo productos que mezclan recetas clásicas con
                            un toque contemporáneo.</p>
                        <img src="../img/postre/postre (3).jpg" alt="postre">
                    </div>
                    <div class="noso-card">
                        <img src="../img/cafe/cafe (1).jpg" alt="cafe">
                        <p>Nuestros valores están en la calidad, la frescura, y el compromiso de entregar siempre lo mejor. Nos
                            enorgullece trabajar con ingredientes seleccionados cuidadosamente, muchos de ellos locales, para apoyar la
                            economía de nuestra comunidad y reducir nuestro impacto ambiental.</p>
                    </div>
                    <div class="noso-card">
                        <p>Además, somos una familia unida por el amor a lo que hacemos. Cada miembro de nuestro equipo aporta
                            su entusiasmo y dedicación, asegurándose de que cada detalle esté a la altura de nuestros estándares. Creemos en
                            el poder de una sonrisa, y en que el mejor ingrediente es siempre la pasión por nuestro oficio.</p>
                        <img src="../img/cafe/cafe (2).jpg" alt="cafe">
                    </div>
                    <div class="noso-card">
                        <img src="../img/postre/postre.jpg" alt="cafe">
                        <p>Estamos comprometidos con nuestra comunidad, participando en eventos locales y colaborando con
                            proveedores sostenibles. En El Café con La Pan-dilla, no solo ofrecemos café y pan, sino un rincón
                            acogedor para todos. Además, hemos ampliado nuestro menú con postres especiales, incluyendo tortas y
                            dulces Oreo, para brindar a cada cliente una experiencia dulce y memorable en cada visita.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>Pana' Cafeteria</h3>
                    <p>Desde 2010 ofreciendo los mejores productos artesanales de panadería y cafetería, elaborados con ingredientes naturales y mucho amor.</p>
                    <div class="social-media">
                        <a href="https://www.facebook.com/" class="social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.instagram.com/" class="social-link"><i class="fab fa-instagram"></i></a>
                        <a href="https://github.com/rgamercm/" class="social-link"><i class="fab fa-github"></i></a>
                    </div>
                </div>
                <div class="footer-column">
                    <h3>Enlaces rápidos</h3>
                    <ul class="footer-links">
                        <li><a href="index2.php"><i class="fas fa-chevron-right"></i> Inicio</a></li>
                        <li><a href="catalogo.php"><i class="fas fa-chevron-right"></i> Productos</a></li>
                        <li><a href="nosotros.php"><i class="fas fa-chevron-right"></i> Nosotros</a></li>
                        <li><a href="registrar.php"><i class="fas fa-chevron-right"></i> Registrarse</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Contacto</h3>
                    <ul class="footer-links">
                        <li><a href="#"><i class="fas fa-map-marker-alt"></i> Av. Principal 123, Ciudad</a></li>
                        <li><a href="tel:+584244258944"><i class="fas fa-phone"></i> +58000-0000000</a></li>
                        <li><a href="mailto:panacafeteria@gmail.com"><i class="fas fa-envelope"></i> panacafeteria@gmail.com</a></li>
                        <li><a href="#"><i class="fas fa-clock"></i> Lunes a Domingo: 7am - 8pm</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; Pana' Cafeteria. Todos los Derechos Reservados.</p>
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