<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El Café Con La Pan-dilla</title>
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

        /* Estilos para el carrusel */
        .carousel-section {
            position: relative;
            margin: 2rem auto;
            max-width: 1200px;
            width: 100%;
            padding: 0 1rem;
        }

        .carousel-container {
            position: relative;
            width: 100%;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .carousel {
            display: flex;
            transition: transform 0.5s ease-in-out;
            height: 400px;
        }

        .carousel-slide {
            min-width: 100%;
            flex-shrink: 0;
            position: relative;
        }

        .carousel-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .info {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0,0,0,0.7);
            color: white;
            padding: 1rem;
            text-align: center;
        }

        .carousel-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255,255,255,0.3);
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            font-size: 1.2rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            z-index: 10;
        }

        .carousel-btn:hover {
            background: rgba(255,255,255,0.5);
        }

        .prev {
            left: 20px;
        }

        .next {
            right: 20px;
        }

        /* Indicadores del carrusel */
        .carousel-indicators {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 8px;
            z-index: 10;
        }

        .indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255,255,255,0.5);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .indicator.active {
            background: white;
            transform: scale(1.2);
        }

        /* Productos destacados */
        .featured-products {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .featured-products h2 {
            text-align: center;
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 2rem;
            position: relative;
        }

        .featured-products h2::after {
            content: '';
            display: block;
            width: 80px;
            height: 3px;
            background: var(--primary-color);
            margin: 0.5rem auto;
        }

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
        }

        .card:hover img {
            transform: scale(1.03);
        }

        .card-text {
            padding: 1rem;
        }

        .card-text h3 {
            margin: 0 0 0.5rem;
            font-size: 1.2rem;
        }

        .card-text p {
            margin: 0.3rem 0;
            color: var(--text-color);
        }

        .price {
            color: var(--primary-color);
            font-weight: bold;
            font-size: 1.1rem;
        }

        .view-more-container {
            text-align: center;
            margin: 2rem 0;
        }

        .view-more-button {
            display: inline-block;
            background: var(--primary-color);
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 30px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
            border: 2px solid var(--primary-color);
        }

        .view-more-button:hover {
            background: transparent;
            color: var(--primary-color);
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
            
            .carousel {
                height: 300px;
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
            
            .carousel {
                height: 250px;
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
        <div class="header-container">
            <div class="logo">
                <img src="img/cafe/cafe.png" alt="Logotipo" class="logo-image">
            </div>
            
            <h1 class="header-title">El Café Con La Pan-dilla</h1>
            
            <div class="header-controls">
                <button class="theme-toggle" id="themeToggle">🌙</button>
                
                <a href="carrito.php" class="cart-icon">
                    <img src="img/cart-icon.png" alt="Carrito de compras">
                    <span id="cartCounter">0</span>
                </a>
            </div>
        </div>

        <nav class="nav">
            <a href="index.php" class="nav-link active"><span>Inicio</span></a>
            <a href="catalogo.php" class="nav-link">Productos</a>
            <a href="nosotros.php" class="nav-link">Nosotros</a>
            <a href="registrar.php" class="nav-link">Registrarse</a>
            <a href="diagrama_procesos.php" class="nav-link">Flujo Productos</a>
            <a href="diagrama_bd.php" class="nav-link">Estructura BD</a>
        </nav>
    </header>

    <main>
        <!-- Carrusel -->
        <section class="carousel-section">
            <div class="carousel-container">
                <div class="carousel" id="carousel">
                    <div class="carousel-slide">
                        <img src="img/panes/1167653.jpg" alt="Nuestros panes">
                        <div class="info">
                            <p>Nuestro pan recién horneado es ese abrazo crujiente que te da la bienvenida a un buen día,
                                aunque empieces la dieta… bueno, mañana.</p>
                        </div>
                    </div>
                    <div class="carousel-slide">
                        <img src="img/cafe/cafe (1).jpg" alt="Nuestro café">
                        <div class="info">
                            <p>Nuestro café es ese impulso de energía que ni tus ganas de dormir pueden resistir.</p>
                        </div>
                    </div>
                    <div class="carousel-slide">
                        <img src="img/postre/postre (1).jpg" alt="Nuestros postres">
                        <div class="info">
                            <p>Nuestras tortas artesanales están diseñadas para esos momentos únicos.</p>
                        </div>
                    </div>
                </div>
                <button class="carousel-btn prev">&#10094;</button>
                <button class="carousel-btn next">&#10095;</button>
                <div class="carousel-indicators" id="carouselIndicators">
                    <div class="indicator active" data-index="0"></div>
                    <div class="indicator" data-index="1"></div>
                    <div class="indicator" data-index="2"></div>
                </div>
            </div>
        </section>

        <!-- Productos destacados -->
        <section class="featured-products">
            <h2>Nuestros Productos Destacados</h2>
            <div class="card-container">
                <div class="card">
                    <a href="p1.php"><img src="img/cafe/coffee (3).jpg" alt="Café Capuchino"></a>
                    <div class="card-text">
                        <h3><a href="p1.php">Café Capuchino</a></h3>
                        <p>Delicioso café con espuma cremosa y aroma irresistible.</p>
                        <p class="price">Precio: <strong>$1.60</strong></p>
                    </div>
                </div>
                <div class="card">
                    <a href="p2.php"><img src="img/panes/Sandwich Bread WITHOUT yeast.jpg" alt="Pan Artesanal"></a>
                    <div class="card-text">
                        <h3><a href="p2.php">Pan Artesanal</a></h3>
                        <p>Pan recién horneado con ingredientes naturales.</p>
                        <p class="price">Precio: <strong>$3.60</strong></p>
                    </div>
                </div>
                <div class="card">
                    <a href="p3.php"><img src="img/tortas/tortas (3).jpg" alt="Helado con Oreo"></a>
                    <div class="card-text">
                        <h3><a href="p3.php">Helado con Oreo</a></h3>
                        <p>Delicioso helado con trozos de galleta Oreo.</p>
                        <p class="price">Precio: <strong>$4.60</strong></p>
                    </div>
                </div>
            </div>
            <div class="view-more-container">
                <a href="catalogo.php" class="view-more-button">Ver Todos los Productos</a>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="footer-content">
            <p>2024 El Café Con La Pan-dilla C.A<br>Todos los Derechos Reservados.</p>
            <p>Contactos<br>Tlf: +58-4244258944<br>Correo: cg9477083@gmail.com</p>
            <div class="social-media">
                <a href="https://www.facebook.com/profile.php?id=100089772800592" class="social-link">Facebook</a>
                <a href="https://www.instagram.com/carlosgz9477/" class="social-link">Instagram</a>
                <a href="https://github.com/NoobCoderMaster69" class="social-link">Github</a>
            </div>
        </div>
    </footer>

    <script>
        // Configuración del carrusel
        document.addEventListener('DOMContentLoaded', function() {
            const carousel = document.getElementById('carousel');
            const slides = document.querySelectorAll('.carousel-slide');
            const prevBtn = document.querySelector('.prev');
            const nextBtn = document.querySelector('.next');
            const indicators = document.querySelectorAll('.indicator');
            let currentIndex = 0;
            const totalSlides = slides.length;
            let autoPlayInterval;
            const intervalTime = 5000; // 5 segundos
            
            // Inicializar el carrusel
            function initCarousel() {
                // Asegurar que cada slide tenga el ancho correcto
                const containerWidth = document.querySelector('.carousel-container').offsetWidth;
                slides.forEach(slide => {
                    slide.style.width = `${containerWidth}px`;
                });
                
                // Configurar el ancho total del carrusel
                carousel.style.width = `${totalSlides * containerWidth}px`;
                
                // Iniciar autoplay
                startAutoPlay();
            }
            
            // Mover al slide específico
            function goToSlide(index) {
                currentIndex = (index + totalSlides) % totalSlides;
                const containerWidth = document.querySelector('.carousel-container').offsetWidth;
                carousel.style.transform = `translateX(-${currentIndex * containerWidth}px)`;
                
                // Actualizar indicadores
                updateIndicators();
            }
            
            // Slide anterior
            function prevSlide() {
                goToSlide(currentIndex - 1);
                resetAutoPlay();
            }
            
            // Siguiente slide
            function nextSlide() {
                goToSlide(currentIndex + 1);
                resetAutoPlay();
            }
            
            // Actualizar indicadores
            function updateIndicators() {
                indicators.forEach((indicator, index) => {
                    if (index === currentIndex) {
                        indicator.classList.add('active');
                    } else {
                        indicator.classList.remove('active');
                    }
                });
            }
            
            // Iniciar autoplay
            function startAutoPlay() {
                autoPlayInterval = setInterval(nextSlide, intervalTime);
            }
            
            // Reiniciar autoplay
            function resetAutoPlay() {
                clearInterval(autoPlayInterval);
                startAutoPlay();
            }
            
            // Event listeners
            prevBtn.addEventListener('click', prevSlide);
            nextBtn.addEventListener('click', nextSlide);
            
            // Indicadores click
            indicators.forEach(indicator => {
                indicator.addEventListener('click', function() {
                    const slideIndex = parseInt(this.getAttribute('data-index'));
                    goToSlide(slideIndex);
                    resetAutoPlay();
                });
            });
            
            // Pausar al hacer hover
            const carouselContainer = document.querySelector('.carousel-container');
            carouselContainer.addEventListener('mouseenter', () => {
                clearInterval(autoPlayInterval);
            });
            
            carouselContainer.addEventListener('mouseleave', startAutoPlay);
            
            // Inicializar
            initCarousel();
            
            // Ajustar al cambiar tamaño de ventana
            window.addEventListener('resize', initCarousel);
        });

        // Tema oscuro/claro
        const userPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        const currentTheme = localStorage.getItem('theme') || (userPrefersDark ? 'dark' : 'light');
        document.body.setAttribute('data-theme', currentTheme);

        const themeToggle = document.getElementById('themeToggle');
        if (themeToggle) {
            themeToggle.textContent = currentTheme === 'dark' ? '🌙' : '☀️';

            themeToggle.addEventListener('click', () => {
                const newTheme = document.body.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
                document.body.setAttribute('data-theme', newTheme);
                localStorage.setItem('theme', newTheme);
                themeToggle.textContent = newTheme === 'dark' ? '🌙' : '☀️';
            });
        }
    </script>
</body>
</html>