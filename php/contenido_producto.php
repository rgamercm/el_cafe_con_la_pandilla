<?php
require_once 'conexion_be.php';

// Obtener el nombre de la página de forma más confiable
$pagina = pathinfo($_SERVER['SCRIPT_NAME'], PATHINFO_FILENAME); // Obtiene "p1" desde p1.php

// Consultar el producto en inventario que tenga esta página asociada
$query = "SELECT * FROM inventario WHERE pagina = '$pagina' AND estado = 'activo' LIMIT 1";
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addToCartBtn = document.getElementById('addToCart');
        const cartItemsList = document.getElementById('cartItems');
        const totalPriceElement = document.getElementById('totalPrice');
        const checkoutBtn = document.getElementById('checkout');
        const cartCounter = document.getElementById('cartCounter');
        const estadoProducto = document.querySelector('.product-status');
        
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        
        // Actualizar el carrito al cargar la página
        updateCartDisplay();
        
        // Añadir producto al carrito
        addToCartBtn.addEventListener('click', function() {
            // Verificar disponibilidad antes de añadir
            fetch(`verificar_disponibilidad.php?id=<?php echo $id_producto; ?>`)
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
                        fetch(`actualizar_estado.php?id=<?php echo $id_producto; ?>`)
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
                if (cartCounter) cartCounter.textContent = '0';
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
            if (cartCounter) cartCounter.textContent = cart.reduce((sum, item) => sum + item.quantity, 0);
        }
    });
</script>