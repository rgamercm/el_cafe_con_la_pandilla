<?php
require_once 'php/verificar_sesion.php';
?>
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
                <a href="inventario.php" class="nav-link active">Inventario</a>
                <a href="nosotros.php" class="nav-link">Nosotros</a>
                <a href="registrar.php" class="nav-link">Registrarse</a>
                <a href="diagrama_procesos.php" class="nav-link">Flujo Productos</a>
                <a href="diagrama_bd.php" class="nav-link">Estructura BD</a>
            </div>
        </nav>
    </header>

    <main>
        <section class="featured-products">
            <h2>Nuestros Productos</h2>
            <div class="card-container">
                <!-- Producto 1 - Café Capuchino -->
                <div class="card">
                    <a href="p1.php"><img src="img/cafe/coffee (3).jpg" alt="Café Capuchino"></a>
                    <div class="card-text">
                        <h3><a href="p1.php">Capuchino con Caritas de Gato</a></h3>
                        <p>Nuestros dulces Oreo te traen el clásico sabor en un formato único. Estos postres son crujientes y cremosos, perfectos para quienes desean disfrutar de un snack diferente.</p>
                        <p class="price">Precio: <strong>$1.60</strong></p>
                    </div>
                </div>
                
                <!-- Producto 2 - Pan Artesanal -->
                <div class="card">
                    <a href="p2.php"><img src="img/panes/Sandwich Bread WITHOUT yeast.jpg" alt="Pan Artesanal"></a>
                    <div class="card-text">
                        <h3><a href="p2.php">Pan Artesanal</a></h3>
                        <p>Elaborado con técnicas tradicionales, nuestro pan artesanal ofrece un sabor único y una textura esponjosa, perfecto para acompañar cualquier comida.</p>
                        <p class="price">Precio: <strong>$3.60</strong></p>
                    </div>
                </div>
                
                <!-- Producto 3 - Café Expreso -->
                <div class="card">
                    <a href="p3.php"><img src="img/cafe/coffee (4).jpg" alt="Café Expreso"></a>
                    <div class="card-text">
                        <h3><a href="p3.php">Café Expreso</a></h3>
                        <p>Intenso y aromático, nuestro café expreso es perfecto para los amantes del buen café. Disfruta de su sabor robusto y su crema característica.</p>
                        <p class="price">Precio: <strong>$1.80</strong></p>
                    </div>
                </div>
                
                <!-- Producto 4 - Torta de Chocolate -->
                <div class="card">
                    <a href="p4.php"><img src="img/tortas/tortas (4).jpg" alt="Torta de Chocolate"></a>
                    <div class="card-text">
                        <h3><a href="p4.php">Torta de Chocolate</a></h3>
                        <p>Elaboradas con los mejores ingredientes, nuestras tortas están pensadas para regalarte dulzura y frescura. Con sabores variados, texturas suaves y una presentación irresistible.</p>
                        <p class="price">Precio: <strong>$10.10</strong></p>
                    </div>
                </div>
                
                <!-- Producto 5 - Pan Con Forma de Gato -->
                <div class="card">
                    <a href="p5.php"><img src="img/panes/panes (2).jpg" alt="Pan Con Forma de Gato"></a>
                    <div class="card-text">
                        <h3><a href="p5.php">Pan Con Forma de Gato</a></h3>
                        <p>Divertido y delicioso pan con forma de gatito, perfecto para los amantes de los animales y los panes artesanales. Suave por dentro y crujiente por fuera.</p>
                        <p class="price">Precio: <strong>$5.00</strong></p>
                    </div>
                </div>
                
                <!-- Producto 6 - Helado Con Oreo -->
                <div class="card">
                    <a href="p6.php"><img src="img/tortas/tortas (3).jpg" alt="Helado Con Oreo"></a>
                    <div class="card-text">
                        <h3><a href="p6.php">Helado Con Oreo</a></h3>
                        <p>Nuestros dulces Oreo te traen el clásico sabor en un formato único. Estos postres son crujientes y cremosos, perfectos para quienes desean disfrutar de un snack diferente.</p>
                        <p class="price">Precio: <strong>$4.60</strong></p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="footer-content">
            <p>2024 El Café Con La Pan-dilla C.A<br>Todos los Derechos Reservados.</p>
            <p>Contactos<br>Tlf: +58-0000000000<br>Correo: cg9477083@gmail.com</p>
            <div class="social-media">
                <a href="https://www.facebook.com/profile.php?id=100089772800592" class="social-link">Facebook</a>
                <a href="https://www.instagram.com/carlosgz9477/" class="social-link">Instagram</a>
                <a href="https://github.com/rgamercm" class="social-link">Github</a>
            </div>
        </div>
    </footer>

    <audio id="backgroundMusic" loop>
        <source src="./musica/videoplayback (online-audio-converter.com).mp3" type="audio/mp3">
    </audio>

    <script>
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

        // Música de fondo
        const audio = document.getElementById("backgroundMusic");
        if (audio) {
            audio.volume = 0.03;
            const lastTime = localStorage.getItem("audioCurrentTime") || 0;
            audio.currentTime = lastTime;
            audio.play();
            audio.addEventListener("timeupdate", () => {
                localStorage.setItem("audioCurrentTime", audio.currentTime);
            });
        }
    </script>
</body>
</html>