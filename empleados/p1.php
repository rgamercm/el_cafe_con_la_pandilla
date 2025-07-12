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
        /* Estilos generales */
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            line-height: 1.6;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px 0;
        }

        /* Estilos de producto */
        .product-container {
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
            margin-bottom: 60px;
        }

        .product-image {
            flex: 1;
            min-width: 300px;
        }

        .product-image img {
            width: 100%;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .product-content {
            flex: 1;
            min-width: 300px;
        }

        .product-content h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            margin-top: 0;
            color: #2c3e50;
        }

        .product-status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .product-status[data-available="true"] {
            background-color: #d4edda;
            color: #155724;
        }

        .product-status[data-available="false"] {
            background-color: #f8d7da;
            color: #721c24;
        }

        .product-price {
            font-size: 1.8rem;
            font-weight: 700;
            color: #e67e22;
            margin: 20px 0;
        }

        /* Estilos del carrito */
        .cart-section {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 8px;
            margin-top: 40px;
        }

        .cart-section h2 {
            margin-top: 0;
            font-family: 'Playfair Display', serif;
            color: #2c3e50;
        }

        #cartItems {
            list-style: none;
            padding: 0;
            margin: 0 0 20px 0;
        }

        #cartItems li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #eee;
        }

        .cart-item-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .cart-item-controls button {
            background: none;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 2px 8px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .cart-item-controls button:hover {
            background: #f0f0f0;
        }

        .item-quantity {
            min-width: 20px;
            text-align: center;
        }

        #totalPrice {
            font-size: 1.2rem;
            font-weight: 600;
            text-align: right;
            margin: 20px 0;
        }

        /* Botones */
        .btn {
            display: inline-block;
            background-color: #e67e22;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
        }

        .btn:hover {
            background-color: #d35400;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .btn:disabled {
            background-color: #95a5a6;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .product-container {
                flex-direction: column;
            }
            
            .product-image, .product-content {
                min-width: 100%;
            }
        }
    </style>
</head>

<body>
    <header class="header">
        <!-- Tu header aquí -->
    </header>

    <?php
    require_once '../php/conexion_be.php';
    require_once '../php/producto_comun.php';

    // Obtener el producto para p1.php
    $producto = obtenerProductoPorPagina('p1');

    if ($producto) {
        $nombre = htmlspecialchars($producto['nombre']);
        $precio = $producto['precio'];
        $descripcion = htmlspecialchars($producto['descripcion']);
        $imagen = $producto['imagen'];
        $id_producto = $producto['id'];
        $disponible = $producto['disponible'];
    } else {
        $nombre = "Producto no configurado";
        $precio = 0.00;
        $descripcion = "Este producto no ha sido configurado en el inventario. Por favor, contacte al administrador.";
        $imagen = "img/cafe/default.jpg";
        $id_producto = 0;
        $disponible = false;
    }
    ?>

    <main class="product-section">
        <div class="container">
            <div class="product-container">
                <div class="product-image">
                    <img src="<?php echo $imagen; ?>" alt="<?php echo $nombre; ?>">
                </div>
                <div class="product-content">
                    <h1><?php echo $nombre; ?></h1>
                    <span class="product-status" data-available="<?php echo $disponible ? 'true' : 'false'; ?>">
                        <?php echo $disponible ? 'Disponible' : 'Agotado'; ?>
                    </span>
                    <p class="product-price">$<?php echo number_format($precio, 2); ?></p>
                    <p><?php echo $descripcion; ?></p>
                    <button id="addToCart" class="btn" <?php echo $disponible ? '' : 'disabled'; ?>>
                        <?php echo $disponible ? 'Añadir al carrito' : 'Agotado'; ?>
                    </button>
                </div>
            </div>

            <div class="cart-section">
                <h2>Carrito de Compras</h2>
                <ul id="cartItems"></ul>
                <p id="totalPrice">Total: $0.00</p>
                <button id="checkout" class="btn" disabled>Finalizar Compra</button>
            </div>
        </div>
    </main>

    <footer class="footer">
        <!-- Tu footer aquí -->
    </footer>

    <script>
        // Configuración del tema oscuro/claro
        const userPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        const currentTheme = localStorage.getItem('theme') || (userPrefersDark ? 'dark' : 'light');
        document.body.setAttribute('data-theme', currentTheme);

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
                addToCart(
                    <?php echo $id_producto; ?>, 
                    "<?php echo addslashes($nombre); ?>", 
                    <?php echo $precio; ?>, 
                    "<?php echo $imagen; ?>"
                );
            });
            
            // Finalizar compra
            checkoutBtn.addEventListener('click', function() {
                proceedToCheckout();
            });
            
            // Función para añadir producto al carrito
            function addToCart(productId, productName, price, image) {
                // Verificar disponibilidad primero
                fetch(`../php/verificar_disponibilidad.php?id=${productId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.disponible) {
                            const existingItem = cart.find(item => item.id === productId);
                            
                            if (existingItem) {
                                // Verificar si podemos añadir una unidad más
                                fetch(`../php/verificar_disponibilidad.php?id=${productId}&cantidad=${existingItem.quantity + 1}`)
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.disponible) {
                                            existingItem.quantity += 1;
                                            localStorage.setItem('cart', JSON.stringify(cart));
                                            updateCartDisplay();
                                            updateCartCounter();
                                        } else {
                                            alert('No hay suficientes unidades disponibles de este producto');
                                        }
                                    });
                            } else {
                                const product = {
                                    id: productId,
                                    name: productName,
                                    price: price,
                                    quantity: 1,
                                    image: image
                                };
                                cart.push(product);
                                localStorage.setItem('cart', JSON.stringify(cart));
                                updateCartDisplay();
                                updateCartCounter();
                            }
                            
                            // Actualizar estado en la página
                            fetch(`../php/actualizar_estado.php?id=${productId}`)
                                .then(response => response.json())
                                .then(data => {
                                    if (!data.disponible) {
                                        estadoProducto.textContent = 'Agotado';
                                        estadoProducto.setAttribute('data-available', 'false');
                                        addToCartBtn.textContent = 'Agotado';
                                        addToCartBtn.disabled = true;
                                    }
                                });
                        } else {
                            alert('Lo sentimos, este producto ya no está disponible');
                            estadoProducto.textContent = 'Agotado';
                            estadoProducto.setAttribute('data-available', 'false');
                            addToCartBtn.textContent = 'Agotado';
                            addToCartBtn.disabled = true;
                        }
                    });
            }
            
            // Función para proceder al checkout
            function proceedToCheckout() {
                if (cart.length === 0) {
                    alert('Tu carrito está vacío');
                    return;
                }
                
                // Redirigir a la página de carrito
                window.location.href = 'carrito.php';
            }
            
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
                            <button class="add-one" data-index="${index}">+</button>
                            <button class="remove-all" data-index="${index}">×</button>
                            <span>$${itemTotal.toFixed(2)}</span>
                        </div>
                    `;
                    
                    cartItemsList.appendChild(li);
                });
                
                // Agregar event listeners a los botones
                document.querySelectorAll('.remove-one').forEach(button => {
                    button.addEventListener('click', function() {
                        const index = parseInt(this.getAttribute('data-index'));
                        updateCartItem(cart[index].id, -1);
                    });
                });
                
                document.querySelectorAll('.add-one').forEach(button => {
                    button.addEventListener('click', function() {
                        const index = parseInt(this.getAttribute('data-index'));
                        updateCartItem(cart[index].id, 1);
                    });
                });
                
                document.querySelectorAll('.remove-all').forEach(button => {
                    button.addEventListener('click', function() {
                        const index = parseInt(this.getAttribute('data-index'));
                        removeCartItem(cart[index].id);
                    });
                });
                
                totalPriceElement.textContent = `Total: $${total.toFixed(2)}`;
                checkoutBtn.disabled = false;
            }
            
            // Función para actualizar cantidad de un item
            function updateCartItem(productId, change) {
                const itemIndex = cart.findIndex(item => item.id === productId);
                
                if (itemIndex !== -1) {
                    const newQuantity = cart[itemIndex].quantity + change;
                    
                    if (newQuantity <= 0) {
                        removeCartItem(productId);
                        return;
                    }
                    
                    // Verificar disponibilidad
                    fetch(`../php/verificar_disponibilidad.php?id=${productId}&cantidad=${newQuantity}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.disponible) {
                                cart[itemIndex].quantity = newQuantity;
                                localStorage.setItem('cart', JSON.stringify(cart));
                                updateCartDisplay();
                                updateCartCounter();
                            } else {
                                alert('No hay suficientes unidades disponibles de este producto');
                            }
                        });
                }
            }
            
            // Función para eliminar un item del carrito
            function removeCartItem(productId) {
                cart = cart.filter(item => item.id !== productId);
                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartDisplay();
                updateCartCounter();
            }
            
            // Función para actualizar el contador del carrito
            function updateCartCounter() {
                const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
                const cartCounter = document.getElementById('cartCounter');
                if (cartCounter) {
                    cartCounter.textContent = totalItems;
                }
            }
        });
    </script>
</body>
</html>