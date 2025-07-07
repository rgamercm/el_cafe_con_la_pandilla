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