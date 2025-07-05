<?php
require_once 'php/conexion_be.php';

// Obtener el ID del producto basado en el nombre del archivo (p1.php -> ID 1)
$pagina = basename($_SERVER['PHP_SELF'], '.php'); // Obtiene "p1" desde p1.php

// Consultar el producto en inventario que tenga esta página asociada
$query = "SELECT * FROM inventario WHERE pagina = '$pagina' LIMIT 1";
$result = mysqli_query($conexion, $query);

$disponible = false;
$producto = null;

if ($result && mysqli_num_rows($result) > 0) {
    $producto = mysqli_fetch_assoc($result);
    $disponible = ($producto['unidades_existentes'] > 0 && $producto['estado'] == 'activo');
}

// Datos por defecto si no está en inventario
$nombre = $producto ? $producto['nombre'] : "Producto no configurado";
$precio = $producto ? $producto['precio'] : 0.00;
$descripcion = $producto ? $producto['descripcion'] : "Este producto no ha sido configurado en el inventario. Por favor, contacte al administrador.";
$imagen = $producto && file_exists("img/cafe/".$producto['codigo'].".jpg") ? 
           "img/cafe/".$producto['codigo'].".jpg" : "img/cafe/default.jpg";
$id_producto = $producto ? $producto['id'] : 0;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($nombre); ?> - El Café Con La Pan-dilla</title>
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
            <h2>Compra lo mejor</h2>
            <div class="card-container">
                <div class="card">
                    <h2><?php echo htmlspecialchars($nombre); ?></h2>
                    <a href="<?php echo $pagina; ?>.php">
                        <img src="<?php echo $imagen; ?>" alt="<?php echo htmlspecialchars($nombre); ?>">
                    </a>
                    <div class="card-text">
                        <p><?php echo htmlspecialchars($descripcion); ?></p>
                        <p>Precio: <strong>$<?php echo number_format($precio, 2); ?></strong></p>
                        <p>Estado: <span id="estadoProducto"><?php echo $disponible ? 'Disponible' : 'Agotado'; ?></span></p>
                        <button id="addToCart" <?php echo $disponible ? '' : 'disabled'; ?>>
                            <?php echo $disponible ? 'Añadir al carrito' : 'Agotado'; ?>
                        </button>
                    </div>
                </div>
            </div>
            
            <section class="cart">
                <h2>Carrito de Compras</h2>
                <ul id="cartItems"></ul>
                <p id="totalPrice">Total: $0.00</p>
                <button id="checkout" disabled>Finalizar Compra</button>
            </section>
        </div>
    </main>

    <footer class="footer">
        <div class="footer-content">
            <p>2024 El Café Con La Pan-dilla C.A<br>Todos los Derechos Reservados.</p>
            <p>Contactos<br>Tlf: +58-4244258944<br>Correo: cg9477083@gmail.com</p>
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

        // Funcionalidad del carrito
        document.addEventListener('DOMContentLoaded', function() {
            const addToCartBtn = document.getElementById('addToCart');
            const cartItemsList = document.getElementById('cartItems');
            const totalPriceElement = document.getElementById('totalPrice');
            const checkoutBtn = document.getElementById('checkout');
            const cartCounter = document.getElementById('cartCounter');
            const estadoProducto = document.getElementById('estadoProducto');
            
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            
            // Actualizar el carrito al cargar la página
            updateCartDisplay();
            
            // Añadir producto al carrito
            addToCartBtn.addEventListener('click', function() {
                // Verificar disponibilidad antes de añadir
                fetch(`php/verificar_disponibilidad.php?id=<?php echo $id_producto; ?>`)
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
                            
                            // Actualizar estado en la página
                            fetch(`php/actualizar_estado.php?id=<?php echo $id_producto; ?>`)
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
                alert('¡Compra finalizada con éxito! Gracias por tu compra.');
                cart = [];
                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartDisplay();
            });
            
            // Actualizar visualización del carrito
            function updateCartDisplay() {
                cartItemsList.innerHTML = '';
                
                if (cart.length === 0) {
                    cartItemsList.innerHTML = '<li>Tu carrito está vacío</li>';
                    totalPriceElement.textContent = 'Total: $0.00';
                    checkoutBtn.disabled = true;
                    cartCounter.textContent = '0';
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
                    });
                });
                
                document.querySelectorAll('.remove-all').forEach(button => {
                    button.addEventListener('click', function() {
                        const index = parseInt(this.getAttribute('data-index'));
                        cart.splice(index, 1);
                        localStorage.setItem('cart', JSON.stringify(cart));
                        updateCartDisplay();
                    });
                });
                
                totalPriceElement.textContent = `Total: $${total.toFixed(2)}`;
                checkoutBtn.disabled = false;
                cartCounter.textContent = cart.reduce((sum, item) => sum + item.quantity, 0);
            }
        });
    </script>
</body>
</html>