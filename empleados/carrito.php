<?php
require_once '../php/verificar_sesion.php';
$usuario_logeado = isset($_SESSION['usuario']);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras - El Café Con La Pan-dilla</title>
    <link rel="shortcut icon" href="../img/cafe.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Imperial+Script&family=Lobster&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #6F4E37;
            --secondary-color: #C4A484;
            --light-color: #F5F5DC;
            --dark-color: #3E2723;
            --success-color: #4CAF50;
            --danger-color: #F44336;
            --warning-color: #FFC107;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--light-color);
            color: var(--dark-color);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .cart-page {
            min-height: calc(100vh - 200px);
            padding: 40px 0;
        }

        .cart-container {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .cart-content {
            margin-bottom: 30px;
        }

        #cartItems {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        #cartItems li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }

        .cart-item-info {
            flex: 2;
        }

        .cart-item-quantity {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cart-item-total {
            flex: 1;
            text-align: right;
            font-weight: bold;
        }

        .quantity-btn {
            background: var(--secondary-color);
            border: none;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
            margin: 0 10px;
            font-weight: bold;
        }

        .quantity-btn:hover {
            background: var(--primary-color);
        }

        .remove-btn {
            background: var(--danger-color);
            border: none;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 20px;
        }

        .remove-btn:hover {
            background: #D32F2F;
        }

        .cart-summary {
            text-align: right;
            margin-top: 20px;
            font-size: 1.2em;
        }

        .btn {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s;
            margin-top: 20px;
        }

        .btn:hover {
            background: var(--dark-color);
            transform: translateY(-2px);
        }

        .btn-outline {
            background: transparent;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
        }

        .btn-outline:hover {
            background: var(--primary-color);
            color: white;
        }

        .checkout-form {
            display: none;
            margin-top: 30px;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 8px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        .form-row {
            display: flex;
            gap: 20px;
        }

        .form-row .form-group {
            flex: 1;
        }

        .payment-methods {
            display: flex;
            gap: 15px;
            margin-top: 10px;
            flex-wrap: wrap;
        }

        .payment-method {
            flex: 1;
            min-width: 200px;
            padding: 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .payment-method.selected {
            border-color: var(--primary-color);
            background-color: rgba(111, 78, 55, 0.1);
        }

        .payment-method input[type="radio"] {
            margin-right: 10px;
        }

        .payment-details {
            display: none;
            margin-top: 20px;
            padding: 20px;
            background: white;
            border-radius: 8px;
            border: 1px solid #eee;
        }

        .payment-details.active {
            display: block;
        }

        .receipt {
            display: none;
            margin-top: 30px;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .receipt.active {
            display: block;
        }

        .receipt-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }

        .receipt-items {
            margin-bottom: 20px;
        }

        .receipt-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .receipt-totals {
            margin-top: 20px;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }

        .receipt-total {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .receipt-total.grand {
            font-weight: bold;
            font-size: 1.2em;
            margin-top: 15px;
        }

        .receipt-footer {
            margin-top: 30px;
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .receipt-actions {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }

        .login-required {
            text-align: center;
            padding: 40px 0;
        }

        .login-required p {
            font-size: 1.2em;
            margin-bottom: 20px;
        }

        @media print {
            body * {
                visibility: hidden;
            }
            .receipt, .receipt * {
                visibility: visible;
            }
            .receipt {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                box-shadow: none;
            }
            .receipt-actions {
                display: none;
            }
        }
    </style>
</head>

<body>
    <!-- [MANTENER TU HEADER ACTUAL] -->
    <header class="header">
    </header>

    <main class="cart-page">
        <div class="container">
            <div class="cart-container">
                <h2>Tu Carrito de Compras</h2>
                
                <?php if($usuario_logeado): ?>
                    <div class="cart-content" id="cartContent">
                        <ul id="cartItems"></ul>
                        <div class="cart-summary">
                            <p id="totalPrice">Total: $0.00</p>
                            <button id="proceedToCheckout" class="btn">Proceder al Pago</button>
                        </div>
                    </div>
                    
                    <!-- Formulario de pago (inicialmente oculto) -->
                    <div class="checkout-form" id="checkoutForm">
                        <h3>Información de Pago</h3>
                        
                        <div class="form-group">
                            <label>Método de Pago</label>
                            <div class="payment-methods">
                                <div class="payment-method selected" onclick="selectPaymentMethod('tarjeta')">
                                    <input type="radio" name="paymentMethod" id="tarjeta" value="tarjeta" checked>
                                    <label for="tarjeta">Tarjeta de Crédito/Débito</label>
                                </div>
                                <div class="payment-method" onclick="selectPaymentMethod('transferencia')">
                                    <input type="radio" name="paymentMethod" id="transferencia" value="transferencia">
                                    <label for="transferencia">Transferencia Bancaria</label>
                                </div>
                                <div class="payment-method" onclick="selectPaymentMethod('pago_movil')">
                                    <input type="radio" name="paymentMethod" id="pago_movil" value="pago_movil">
                                    <label for="pago_movil">Pago Móvil</label>
                                </div>
                                <div class="payment-method" onclick="selectPaymentMethod('efectivo')">
                                    <input type="radio" name="paymentMethod" id="efectivo" value="efectivo">
                                    <label for="efectivo">Efectivo</label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Detalles de pago con tarjeta -->
                        <div class="payment-details active" id="tarjetaDetails">
                            <div class="form-group">
                                <label for="cardNumber">Número de Tarjeta</label>
                                <input type="text" id="cardNumber" class="form-control" placeholder="1234 5678 9012 3456" maxlength="16">
                            </div>
                            <div class="form-group">
                                <label for="cardName">Nombre en la Tarjeta</label>
                                <input type="text" id="cardName" class="form-control" placeholder="Nombre Apellido">
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="cardExpiry">Fecha de Expiración</label>
                                    <input type="text" id="cardExpiry" class="form-control" placeholder="MM/AA" maxlength="5">
                                </div>
                                <div class="form-group">
                                    <label for="cardCvv">CVV</label>
                                    <input type="text" id="cardCvv" class="form-control" placeholder="123" maxlength="3">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Detalles de transferencia bancaria -->
                        <div class="payment-details" id="transferenciaDetails">
                            <p>Por favor realiza una transferencia a la siguiente cuenta:</p>
                            <p><strong>Banco:</strong> Banco Nacional</p>
                            <p><strong>Cuenta:</strong> 1234-5678-9012-3456</p>
                            <p><strong>A nombre de:</strong> El Café Con La Pan-dilla C.A.</p>
                            <p><strong>RIF:</strong> J-123456789</p>
                            <p>Envía el comprobante a cg9477083@gmail.com</p>
                        </div>
                        
                        <!-- Detalles de pago móvil -->
                        <div class="payment-details" id="pago_movilDetails">
                            <div class="form-group">
                                <label for="mobileNumber">Número de Teléfono</label>
                                <input type="text" id="mobileNumber" class="form-control" placeholder="0424-1234567">
                            </div>
                            <div class="form-group">
                                <label for="mobileBank">Banco</label>
                                <select id="mobileBank" class="form-control">
                                    <option value="banco_nacional">Banco Nacional</option>
                                    <option value="banco_provincial">Banco Provincial</option>
                                    <option value="banco_venezuela">Banco de Venezuela</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="mobileId">Cédula/Pasaporte</label>
                                <input type="text" id="mobileId" class="form-control" placeholder="V-12345678">
                            </div>
                        </div>
                        
                        <!-- Detalles de pago en efectivo -->
                        <div class="payment-details" id="efectivoDetails">
                            <p>Puedes pagar en efectivo al momento de recibir tu pedido.</p>
                            <p>Por favor ten el monto exacto o cercano para facilitar el proceso.</p>
                        </div>
                        
                        <div class="form-group">
                            <label for="deliveryAddress">Dirección de Envío (opcional)</label>
                            <textarea id="deliveryAddress" class="form-control" rows="3" placeholder="Si deseas delivery, por favor indica tu dirección completa"></textarea>
                        </div>
                        
                        <button id="completePurchase" class="btn">Completar Compra</button>
                        <button id="backToCart" class="btn btn-outline" onclick="backToCart()">Volver al Carrito</button>
                    </div>
                    
                    <!-- Recibo (inicialmente oculto) -->
                    <div class="receipt" id="receipt">
                        <div class="receipt-header">
                            <h3>El Café Con La Pan-dilla C.A.</h3>
                            <p>Av. Principal 123, Ciudad</p>
                            <p>RIF: J-123456789</p>
                            <p>Teléfono: +58 424-4258944</p>
                            <p>Fecha: <span id="receiptDate"></span></p>
                            <p>Pedido #<span id="receiptOrderId"></span></p>
                        </div>
                        
                        <div class="receipt-items" id="receiptItems">
                            <!-- Los ítems se agregarán dinámicamente -->
                        </div>
                        
                        <div class="receipt-totals">
                            <div class="receipt-total">
                                <span>Subtotal:</span>
                                <span id="receiptSubtotal">$0.00</span>
                            </div>
                            <div class="receipt-total">
                                <span>IVA (16%):</span>
                                <span id="receiptTax">$0.00</span>
                            </div>
                            <div class="receipt-total grand">
                                <span>Total:</span>
                                <span id="receiptTotal">$0.00</span>
                            </div>
                        </div>
                        
                        <div class="receipt-footer">
                            <p id="receiptPaymentMethod"></p>
                            <p id="receiptDeliveryAddress"></p>
                            <p>¡Gracias por tu compra!</p>
                            <div class="receipt-actions">
                                <button id="printReceipt" class="btn" onclick="window.print()">Imprimir Recibo</button>
                                <button id="newOrder" class="btn" onclick="newOrder()">Nueva Orden</button>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="login-required">
                        <p>Debes iniciar sesión para acceder al carrito</p>
                        <a href="registrar.php" class="btn">Iniciar Sesión</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <!-- [MANTENER TU FOOTER ACTUAL] -->
    <footer class="footer">
    </footer>
    
    <div class="back-to-top" id="backToTop">
        <i class="fas fa-arrow-up"></i>
    </div>
    
    <audio id="backgroundMusic" loop>
        <source src="../musica/videoplayback (online-audio-converter.com).mp3" type="audio/mp3">
    </audio>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            loadCartFromStorage();
            updateCartCounter();
            
            // Configurar botón de checkout
            const proceedToCheckout = document.getElementById('proceedToCheckout');
            if (proceedToCheckout) {
                proceedToCheckout.addEventListener('click', showCheckoutForm);
            }
            
            // Configurar botón de completar compra
            const completePurchase = document.getElementById('completePurchase');
            if (completePurchase) {
                completePurchase.addEventListener('click', completePurchaseProcess);
            }
        });

        function loadCartFromStorage() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            const cartItemsList = document.getElementById('cartItems');
            const totalPriceElement = document.getElementById('totalPrice');
            
            cartItemsList.innerHTML = '';
            
            if (cart.length === 0) {
                cartItemsList.innerHTML = '<li>Tu carrito está vacío</li>';
                totalPriceElement.textContent = 'Total: $0.00';
                if (document.getElementById('proceedToCheckout')) {
                    document.getElementById('proceedToCheckout').disabled = true;
                }
                return;
            }
            
            let total = 0;
            
            cart.forEach((item, index) => {
                const itemTotal = item.price * item.quantity;
                total += itemTotal;
                
                const li = document.createElement('li');
                li.innerHTML = `
                    <div class="cart-item-info">
                        <div class="cart-item-name">${item.name}</div>
                        <div class="cart-item-price">$${item.price.toFixed(2)} c/u</div>
                    </div>
                    <div class="cart-item-quantity">
                        <button class="quantity-btn" onclick="updateQuantity(${index}, -1)">-</button>
                        <span>${item.quantity}</span>
                        <button class="quantity-btn" onclick="updateQuantity(${index}, 1)">+</button>
                    </div>
                    <div class="cart-item-total">$${itemTotal.toFixed(2)}</div>
                    <button class="remove-btn" onclick="removeItem(${index})">Eliminar</button>
                `;
                
                cartItemsList.appendChild(li);
            });
            
            totalPriceElement.textContent = `Total: $${total.toFixed(2)}`;
            if (document.getElementById('proceedToCheckout')) {
                document.getElementById('proceedToCheckout').disabled = false;
            }
        }

        function updateQuantity(index, change) {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            if (index >= 0 && index < cart.length) {
                const productId = cart[index].id;
                const newQuantity = cart[index].quantity + change;
                
                // Verificar disponibilidad con el servidor
                fetch(`../php/verificar_disponibilidad.php?id=${productId}&cantidad=${newQuantity}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.disponible) {
                            cart[index].quantity = newQuantity;
                            
                            if (cart[index].quantity <= 0) {
                                cart.splice(index, 1);
                            }
                            
                            localStorage.setItem('cart', JSON.stringify(cart));
                            loadCartFromStorage();
                            updateCartCounter();
                        } else {
                            alert('No hay suficientes unidades disponibles de este producto');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error al verificar disponibilidad');
                    });
            }
        }

        function removeItem(index) {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            if (index >= 0 && index < cart.length) {
                cart.splice(index, 1);
                localStorage.setItem('cart', JSON.stringify(cart));
                loadCartFromStorage();
                updateCartCounter();
            }
        }
        
        function updateCartCounter() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            if (document.getElementById('cartCounter')) {
                document.getElementById('cartCounter').textContent = totalItems;
            }
        }
        
        function showCheckoutForm() {
            document.getElementById('cartContent').style.display = 'none';
            document.getElementById('checkoutForm').style.display = 'block';
        }
        
        function backToCart() {
            document.getElementById('checkoutForm').style.display = 'none';
            document.getElementById('cartContent').style.display = 'block';
        }
        
        function selectPaymentMethod(method) {
            // Ocultar todos los detalles de pago
            document.querySelectorAll('.payment-details').forEach(el => {
                el.classList.remove('active');
            });
            
            // Desmarcar todos los métodos
            document.querySelectorAll('.payment-method').forEach(el => {
                el.classList.remove('selected');
            });
            
            // Mostrar detalles del método seleccionado
            document.getElementById(`${method}Details`).classList.add('active');
            
            // Marcar como seleccionado
            event.currentTarget.classList.add('selected');
        }
        
        function completePurchaseProcess() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            if (cart.length === 0) {
                alert('Tu carrito está vacío');
                return;
            }
            
            const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;
            let paymentDetails = {};
            
            // Obtener detalles según el método de pago
            if (paymentMethod === 'tarjeta') {
                const cardNumber = document.getElementById('cardNumber').value;
                if (!cardNumber || cardNumber.length < 16) {
                    alert('Por favor ingrese un número de tarjeta válido');
                    return;
                }
                
                paymentDetails = {
                    cardNumber: cardNumber,
                    cardName: document.getElementById('cardName').value,
                    cardExpiry: document.getElementById('cardExpiry').value,
                    cardCvv: document.getElementById('cardCvv').value
                };
            } else if (paymentMethod === 'pago_movil') {
                paymentDetails = {
                    mobileNumber: document.getElementById('mobileNumber').value,
                    mobileBank: document.getElementById('mobileBank').value,
                    mobileId: document.getElementById('mobileId').value
                };
            }
            
            const deliveryAddress = document.getElementById('deliveryAddress').value;
            
            // Calcular totales
            const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const tax = subtotal * 0.16; // IVA 16%
            const total = subtotal + tax;
            
            // Enviar datos al servidor
            fetch('../php/checkout.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    cart: cart,
                    paymentMethod: paymentMethod,
                    paymentDetails: paymentDetails,
                    deliveryAddress: deliveryAddress
                })
            })
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => { throw new Error(text || 'Error en el servidor'); });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showReceipt(cart, subtotal, tax, total, paymentMethod, paymentDetails, deliveryAddress);
                    document.getElementById('receiptOrderId').textContent = data.pedido_id;
                    document.getElementById('checkoutForm').style.display = 'none';
                    document.getElementById('receipt').classList.add('active');
                    localStorage.removeItem('cart');
                    updateCartCounter();
                } else {
                    throw new Error(data.message || 'Error al procesar el pago');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error: ' + error.message);
            });
        }
        
        function showReceipt(items, subtotal, tax, total, paymentMethod, paymentDetails, deliveryAddress) {
            // Formatear fecha
            const now = new Date();
            const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
            document.getElementById('receiptDate').textContent = now.toLocaleDateString('es-ES', options);
            
            // Agregar ítems
            const receiptItems = document.getElementById('receiptItems');
            receiptItems.innerHTML = '';
            
            items.forEach(item => {
                const itemDiv = document.createElement('div');
                itemDiv.className = 'receipt-item';
                itemDiv.innerHTML = `
                    <span>${item.quantity} x ${item.name}</span>
                    <span>$${(item.price * item.quantity).toFixed(2)}</span>
                `;
                receiptItems.appendChild(itemDiv);
            });
            
            // Mostrar totales
            document.getElementById('receiptSubtotal').textContent = `$${subtotal.toFixed(2)}`;
            document.getElementById('receiptTax').textContent = `$${tax.toFixed(2)}`;
            document.getElementById('receiptTotal').textContent = `$${total.toFixed(2)}`;
            
            // Mostrar método de pago
            let paymentMethodText = '';
            switch(paymentMethod) {
                case 'tarjeta':
                    paymentMethodText = `Tarjeta terminada en ${paymentDetails.cardNumber.slice(-4)}`;
                    break;
                case 'transferencia':
                    paymentMethodText = 'Transferencia Bancaria';
                    break;
                case 'pago_movil':
                    paymentMethodText = `Pago Móvil (${paymentDetails.mobileBank})`;
                    break;
                case 'efectivo':
                    paymentMethodText = 'Efectivo al recibir';
                    break;
            }
            document.getElementById('receiptPaymentMethod').textContent = `Método de pago: ${paymentMethodText}`;
            
            // Mostrar dirección si existe
            if (deliveryAddress) {
                document.getElementById('receiptDeliveryAddress').textContent = `Dirección: ${deliveryAddress}`;
            }
        }
        
        function newOrder() {
            window.location.href = 'catalogo.php';
        }
    </script>
</body>
</html>