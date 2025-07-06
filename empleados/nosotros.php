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

        /* Estilos para la sección "Sobre Nosotros" */
        .titulocard {
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

        .card-all {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .noso-card {
            display: flex;
            align-items: center;
            gap: 2rem;
            background: var(--card-bg);
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        .noso-card img {
            width: 300px;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }

        .noso-card p {
            flex: 1;
            line-height: 1.6;
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
            
            .noso-card {
                flex-direction: column;
                gap: 1rem;
            }
            
            .noso-card img {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .logo-image {
                height: 40px;
            }
            
            .header-title {
                font-size: 1.1rem;
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
        <div class="titulocard">
            <h2>Sobre Nosotros</h2>
            <div class="card-all">
                <div class="noso-card">
                    <img src="img/panes/panes.jpg" alt="panes">
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
                    <img src="img/postre/postre (3).jpg" alt="postre">
                </div>
                <div class="noso-card">
                    <img src="img/cafe/cafe (1).jpg" alt="cafe">
                    <p>Nuestros valores están en la calidad, la frescura, y el compromiso de entregar siempre lo mejor. Nos
                        enorgullece trabajar con ingredientes seleccionados cuidadosamente, muchos de ellos locales, para apoyar la
                        economía de nuestra comunidad y reducir nuestro impacto ambiental.</p>
                </div>
                <div class="noso-card">
                    <p>Además, somos una familia unida por el amor a lo que hacemos. Cada miembro de nuestro equipo aporta
                        su entusiasmo y dedicación, asegurándose de que cada detalle esté a la altura de nuestros estándares. Creemos en
                        el poder de una sonrisa, y en que el mejor ingrediente es siempre la pasión por nuestro oficio.</p>
                    <img src="img/cafe/cafe (2).jpg" alt="cafe">
                </div>
                <div class="noso-card">
                    <img src="img/postre/postre.jpg" alt="cafe">
                    <p>Estamos comprometidos con nuestra comunidad, participando en eventos locales y colaborando con
                        proveedores sostenibles. En El Café con La Pan-dilla, no solo ofrecemos café y pan, sino un rincón
                        acogedor para todos. Además, hemos ampliado nuestro menú con postres especiales, incluyendo tortas y
                        dulces Oreo, para brindar a cada cliente una experiencia dulce y memorable en cada visita.</p>
                </div>
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