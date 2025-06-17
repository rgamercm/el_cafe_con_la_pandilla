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
    <link href="https://fonts.googleapis.com/css2?family=Imperial+Script&family=Lobster&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
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
                
                <!-- Icono del carrito mejorado -->
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
        <section class="carouse">
            <div class="carousel-container">
                <div class="carousel" id="carousel">
                    <div class="carousel-slide">
                        <img src="img/panes/1167653.jpg" height="500" width="800" alt="Imagen 1">
                        <div class="info">
                            <p>Nuestro pan recién horneado es ese abrazo crujiente que te da la bienvenida a un buen día,
                                aunque empieces la dieta… bueno, mañana. Cada mordisco es pura felicidad, sin culpa, porque
                                lo hacemos con amor y sin remordimientos.</p>
                        </div>
                    </div>
                    <div class="carousel-slide">
                        <img src="img/cafe/cafe (1).jpg" height="500" width="800" alt="Imagen 2">
                        <div class="info">
                            <p>Nuestro café es ese impulso de energía que ni tus ganas de dormir pueden resistir. Aquí el
                                café te mira y te dice: 'Hoy serás imparable, o al menos no dormirás en el trabajo.'
                                Perfecto para días que solo arrancan con una buena dosis de cafeína</p>
                        </div>
                    </div>
                    <div class="carousel-slide">
                        <img src="img/postre/postre (1).jpg" height="500" width="800" alt="Imagen 3">
                        <div class="info">
                            <p>Nuestras tortas artesanales están diseñadas para esos momentos únicos. Cada bocado es un
                                viaje de sabor, con capas de frescura y suavidad. Son ideales para celebraciones, o incluso
                                para consentirte a ti mismo.</p>
                        </div>
                    </div>
                    <div class="carousel-slide">
                        <img src="img/postre/postre.jpg" height="500" width="800" alt="Imagen 3">
                        <div class="info">
                            <p>Descubre los dulces de Oreo, en los que la cremosa galleta se une con sabores únicos. Son
                                ideales para quienes buscan una explosión de sabor, en un dulce crujiente y divertido.</p>
                        </div>
                    </div>
                </div>
                <button class="carousel-btn prev" onclick="prevSlide()">&#10094;</button>
                <button class="carousel-btn next" onclick="nextSlide()">&#10095;</button>
            </div>
        </section>

        <div class="titulocard">
            <h2>Productos</h2>
            <div class="card-container">
                <div class="card">
                    <a href="p1.php"><img src="img/cafe/coffee (3).jpg" alt="Café Capuchino"></a>
                    <div class="card-text">
                        <h3><a href="p1.php">Café Capuchino</a></h3>
                        <p>Delicioso café con espuma cremosa y aroma irresistible.</p>
                        <p>Precio: <strong>$1.60</strong></p>
                    </div>
                </div>
                <div class="card">
                    <a href="p2.php"><img src="img/panes/Sandwich Bread WITHOUT yeast.jpg" alt="Pan Artesanal"></a>
                    <div class="card-text">
                        <h3><a href="p2.php">Pan Artesanal</a></h3>
                        <p>Pan recién horneado con ingredientes naturales.</p>
                        <p>Precio: <strong>$3.60</strong></p>
                    </div>
                </div>
                <div class="card">
                    <a href="p3.php"><img src="img/tortas/tortas (3).jpg" alt="Helado con Oreo"></a>
                    <div class="card-text">
                        <h3><a href="p3.php">Helado con Oreo</a></h3>
                        <p>Delicioso helado con trozos de galleta Oreo.</p>
                        <p>Precio: <strong>$4.60</strong></p>
                    </div>
                </div>
            </div>
            <div class="button-container">
                <a href="catalogo.php" class="view-more-button">Ver Más</a>
            </div>
        </div>
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

    <audio id="backgroundMusic" loop>
        <source src="./musica/videoplayback (online-audio-converter.com).mp3" type="audio/mp3">
    </audio>

    <script src="js/carrito.js"></script>
    <script src="js/style.js"></script>
</body>
</html>