<!DOCTYPE html>
<html lang="en">
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

    <main>
        <div class="titulocard">
            <h2>Productos</h2>
            <div class="card-container">
                <div class="card">
                    <img src="img/cafe/coffee (3).jpg" alt="Imagen 1">
                    <div class="card-text">
                        <h3>Capuchino con Caritas de Gato</h3>
                        <p>Nuestros dulces Oreo te traen el clásico sabor en un formato único. Estos postres son crujientes y cremosos, perfectos para quienes desean disfrutar de un snack diferente.</p>
                    </div>
                </div>
                <div class="card">
                    <img src="img/panes/Sandwich Bread WITHOUT yeast.jpg" alt="Imagen 2">
                    <div class="card-text">
                        <h3>Pan Artesanal</h3>
                        <p>Elaborado con técnicas tradicionales, nuestro pan artesanal ofrece un sabor único y una textura esponjosa, perfecto para acompañar cualquier comida.</p>
                    </div>
                </div>
                <div class="card">
                    <img src="img/cafe/coffee (4).jpg" alt="Imagen 3">
                    <div class="card-text">
                        <h3>Café Expreso</h3>
                        <p>Miau, miau miau miau miau. Miau miau miau miau, miau miau miau… miau, miau miau.</p>
                    </div>
                </div>
                <div class="card">
                    <img src="img/tortas/tortas (4).jpg" alt="Imagen 4">
                    <div class="card-text">
                        <h3>Torta de Chocolate</h3>
                        <p>Elaboradas con los mejores ingredientes, nuestras tortas están pensadas para regalarte dulzura y frescura. Con sabores variados, texturas suaves y una presentación irresistible, estas tortas encantarán cada momento.</p>
                    </div>
                </div>
                <div class="card">
                    <img src="img/panes/panes (2).jpg" alt="Imagen 5">
                    <div class="card-text">
                        <h3>Pan Con Forma de Gato</h3>
                        <p>Miau, miau miau... miau miau pan miau suave miau crujiente, miau miau miau. Miau, miau mordisquito, miau caricias miau miau.</p>
                    </div>
                </div>
                <div class="card">
                    <img src="img/tortas/tortas (3).jpg" alt="Imagen 6">
                    <div class="card-text">
                        <h3>Helado Con Oreo</h3>
                        <p>Nuestros dulces Oreo te traen el clásico sabor en un formato único. Estos postres son crujientes y cremosos, perfectos para quienes desean disfrutar de un snack diferente.</p>
                    </div>
                </div>
            </div>
        </div>
        
    </main>

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
    <audio id="backgroundMusic" loop>
        <source src="./musica/videoplayback (online-audio-converter.com).mp3" type="audio/mp3">
    </audio>
    <script src="js/style.js"></script>
    
</body>
</html>