<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Producto - El Café Con La Pan-dilla</title>
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

        /* Producto Section */
        .product-section {
            padding: var(--section-padding);
        }

        .product-container {
            display: flex;
            gap: 50px;
            margin-bottom: 50px;
        }

        .product-image {
            flex: 1;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--box-shadow);
        }

        .product-image img {
            width: 100%;
            height: auto;
            display: block;
            transition: transform 0.5s ease;
        }

        .product-image:hover img {
            transform: scale(1.02);
        }

        .product-content {
            flex: 1;
        }

        .product-content h1 {
            font-size: 36px;
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        .product-price {
            font-size: 28px;
            color: var(--primary-color);
            margin: 20px 0;
            font-weight: bold;
        }

        .product-content p {
            margin-bottom: 20px;
            color: var(--text-color);
        }

        .product-status {
            display: inline-block;
            padding: 5px 15px;
            background: var(--primary-color);
            color: white;
            border-radius: 30px;
            font-size: 14px;
            margin-bottom: 20px;
        }

        /* Carrito */
        .cart-section {
            background: var(--background-color-card);
            padding: 40px 0;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
        }

        .cart-section h2 {
            text-align: center;
            margin-bottom: 30px;
            color: var(--primary-color);
        }

        #cartItems {
            list-style: none;
            padding: 0;
            margin: 0 0 30px 0;
        }

        #cartItems li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid rgba(0,0,0,0.1);
        }

        .cart-item-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .remove-one, .remove-all {
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            transition: var(--transition);
        }

        .remove-one {
            background: #ff7676;
            color: white;
        }

        .remove-all {
            background: #cc0000;
            color: white;
        }

        .remove-one:hover, .remove-all:hover {
            opacity: 0.9;
        }

        .item-quantity {
            min-width: 30px;
            text-align: center;
        }

        #totalPrice {
            font-weight: bold;
            font-size: 24px;
            color: var(--primary-color);
            text-align: right;
            margin: 20px 0;
        }

        #checkout {
            display: block;
            width: 100%;
            max-width: 300px;
            margin: 0 auto;
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
            .product-container {
                flex-direction: column;
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
                <img src="img/cafe/cafe1.png" alt="Logotipo" class="logo-image">
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

    <?php
    require_once '../php/conexion_be.php';

    // Obtener el producto para p5.php
    $query = "SELECT * FROM inventario WHERE pagina = 'p5' AND estado = 'activo' LIMIT 1";
    $result = mysqli_query($conexion, $query);

    $disponible = false;
    $producto = null;

    if ($result && mysqli_num_rows($result) > 0) {
        $producto = mysqli_fetch_assoc($result);
        $disponible = ($producto['unidades_existentes'] > 0);
    }

    // Datos por defecto si no está en inventario
    $nombre = $producto ? $producto['nombre'] : "Producto no configurado";
    $precio = $producto ? $producto['precio'] : 0.00;
    $descripcion = $producto ? $producto['descripcion'] : "Este producto no ha sido configurado en el inventario. Por favor, contacte al administrador.";
    $imagen = $producto && file_exists("img/cafe/".$producto['codigo'].".jpg") ? 
               "img/cafe/".$producto['codigo'].".jpg" : "img/cafe/default.jpg";
    $id_producto = $producto ? $producto['id'] : 0;
    ?>

    <main class="product-section">
        <div class="container">
            <div class="product-container">
                <div class="product-image">
                    <img src="<?php echo $imagen; ?>" alt="<?php echo htmlspecialchars($nombre); ?>">
                </div>
                <div class="product-content">
                    <h1><?php echo htmlspecialchars($nombre); ?></h1>
                    <span class="product-status"><?php echo $disponible ? 'Disponible' : 'Agotado'; ?></span>
                    <p class="product-price">$<?php echo number_format($precio, 2); ?></p>
                    <p><?php echo htmlspecialchars($descripcion); ?></p>
                    <button id="addToCart" class="btn" <?php echo $disponible ? '' : 'disabled'; ?>>
                        <?php echo $disponible ? 'Añadir al carrito' : 'Agotado'; ?>
                    </button>
                </div>
            </div>

            <div class="cart-section container">
                <h2>Carrito de Compras</h2>
                <ul id="cartItems"></ul>
                <p id="totalPrice">Total: $0.00</p>
                <button id="checkout" class="btn" disabled>Finalizar Compra</button>
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

        // Funcionalidad del carrito
        document.addEventListener('DOMContentLoaded', function() {
            const addToCartBtn = document.getElementById('addToCart');
            const cartItemsList = document.getElementById('cartItems');
            const totalPriceElement = document.getElementById('totalPrice');
            const checkoutBtn = document.getElementById('checkout');
            const estadoProducto = document.querySelector('.product-status');
            
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            
            // Actualizar el carrito al cargar la página
            updateCartDisplay();
            
            // Añadir producto al carrito
            addToCartBtn.addEventListener('click', function() {
                // Verificar disponibilidad antes de añadir
                fetch(`../php/verificar_disponibilidad.php?id=<?php echo $id_producto; ?>`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.disponible) {
                            const product = {
                                id: <?php echo $id_producto; ?>,
                                name: "<?php echo addslashes($nombre); ?>",
                                price: <?php echo $precio; ?>,
                                quantity: 1,
                                image: "<?php echo $imagen; ?>"
                            };
                            
                            // Verificar si el producto ya está en el carrito
                            const existingItem = cart.find(item => item.id === product.id);
                            
                            if (existingItem) {
                                existingItem.quantity += 1;
                            } else {
                                cart.push(product);
                            }
                            
                            localStorage.setItem('cart', JSON.stringify(cart));
                            updateCartDisplay();
                            updateCartCounter();
                            
                            // Actualizar estado en la página
                            fetch(`../php/actualizar_estado.php?id=<?php echo $id_producto; ?>`)
                                .then(response => response.json())
                                .then(data => {
                                    if (!data.disponible) {
                                        estadoProducto.textContent = 'Agotado';
                                        addToCartBtn.textContent = 'Agotado';
                                        addToCartBtn.disabled = true;
                                    }
                                });
                        } else {
                            alert('Lo sentimos, este producto ya no está disponible');
                            estadoProducto.textContent = 'Agotado';
                            addToCartBtn.textContent = 'Agotado';
                            addToCartBtn.disabled = true;
                        }
                    });
            });
            
            // Finalizar compra
            checkoutBtn.addEventListener('click', function() {
                window.location.href = 'carrito.php';
            });
            
            // Actualizar visualización del carrito
            function updateCartDisplay() {
                cartItemsList.innerHTML = '';
                
                if (cart.length === 0) {
                    cartItemsList.innerHTML = '<li>Tu carrito está vacío</li>';
                    totalPriceElement.textContent = 'Total: $0.00';
                    checkoutBtn.disabled = true;
                    return;
                }
                
                let total = 0;
                
                cart.forEach((item, index) => {
                    const li = document.createElement('li');
                    const itemTotal = item.price * item.quantity;
                    total += itemTotal;
                    
                    li.innerHTML = `
                        <span>${item.name}</span>
                        <div class="cart-item-controls">
                            <button class="remove-one" data-index="${index}">-</button>
                            <span class="item-quantity">x${item.quantity}</span>
                            <button class="remove-all" data-index="${index}">×</button>
                            <span>$${itemTotal.toFixed(2)}</span>
                        </div>
                    `;
                    
                    cartItemsList.appendChild(li);
                });
                
                // Agregar event listeners a los botones de eliminar
                document.querySelectorAll('.remove-one').forEach(button => {
                    button.addEventListener('click', function() {
                        const index = parseInt(this.getAttribute('data-index'));
                        if (cart[index].quantity > 1) {
                            cart[index].quantity -= 1;
                        } else {
                            cart.splice(index, 1);
                        }
                        localStorage.setItem('cart', JSON.stringify(cart));
                        updateCartDisplay();
                        updateCartCounter();
                    });
                });
                
                document.querySelectorAll('.remove-all').forEach(button => {
                    button.addEventListener('click', function() {
                        const index = parseInt(this.getAttribute('data-index'));
                        cart.splice(index, 1);
                        localStorage.setItem('cart', JSON.stringify(cart));
                        updateCartDisplay();
                        updateCartCounter();
                    });
                });
                
                totalPriceElement.textContent = `Total: $${total.toFixed(2)}`;
                checkoutBtn.disabled = false;
            }
            
            function updateCartCounter() {
                const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
                if (cartCounter) cartCounter.textContent = totalItems;
            }
        });
    </script>
</body>
</html>