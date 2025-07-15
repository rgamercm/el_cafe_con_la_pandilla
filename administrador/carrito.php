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
            --success-color: #4CAF50;
            --danger-color: #F44336;
            --warning-color: #FFC107;
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

        .btn-outline {
            background: transparent;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
        }

        .btn-outline:hover {
            background: var(--primary-color);
            color: white;
        }

        /* Header */
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

        /* Página de Carrito */
        .cart-page {
            padding: var(--section-padding);
            min-height: calc(100vh - 200px);
        }

        .cart-container {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            padding: 30px;
            box-shadow: var(--box-shadow);
        }

        .cart-container h2 {
            color: var(--primary-color);
            margin-bottom: 30px;
            text-align: center;
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
            border-bottom: 1px solid rgba(0,0,0,0.1);
        }

        .cart-item-info {
            flex: 2;
        }

        .cart-item-quantity {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .cart-item-total {
            flex: 1;
            text-align: right;
            font-weight: bold;
            color: var(--primary-color);
        }

        .quantity-btn {
            background: var(--primary-color);
            border: none;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
            font-weight: bold;
            transition: var(--transition);
        }

        .quantity-btn:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
        }

        .remove-btn {
            background: var(--danger-color);
            border: none;
            color: white;
            padding: 5px 15px;
            border-radius: 30px;
            cursor: pointer;
            margin-left: 20px;
            transition: var(--transition);
        }

        .remove-btn:hover {
            background: #D32F2F;
            transform: translateY(-2px);
        }

        .cart-summary {
            text-align: right;
            margin-top: 30px;
            font-size: 1.2em;
        }

        #totalPrice {
            font-weight: bold;
            font-size: 24px;
            color: var(--primary-color);
            margin: 20px 0;
        }

        /* Formulario de pago */
        .checkout-form {
            display: none;
            margin-top: 30px;
            padding: 30px;
            background: var(--card-bg);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
        }

        .checkout-form h3 {
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            font-size: 16px;
            transition: var(--transition);
            background-color: var(--card-bg);
            color: var(--text-color);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 2px rgba(212, 167, 106, 0.2);
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
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: all 0.3s;
            background: var(--card-bg);
        }

        .payment-method.selected {
            border-color: var(--primary-color);
            background-color: rgba(212, 167, 106, 0.1);
        }

        .payment-method input[type="radio"] {
            margin-right: 10px;
        }

        .payment-details {
            display: none;
            margin-top: 20px;
            padding: 20px;
            background: var(--card-bg);
            border-radius: var(--border-radius);
            border: 1px solid rgba(0,0,0,0.1);
            box-shadow: var(--box-shadow);
        }

        .payment-details.active {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Recibo */
        .receipt {
            display: none;
            margin-top: 30px;
            padding: 30px;
            background: var(--card-bg);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
        }

        .receipt.active {
            display: block;
            animation: fadeIn 0.5s ease;
        }

        .receipt-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(0,0,0,0.1);
        }

        .receipt-header h3 {
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .receipt-items {
            margin-bottom: 20px;
        }

        .receipt-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 10px 0;
            border-bottom: 1px dashed rgba(0,0,0,0.1);
        }

        .receipt-totals {
            margin-top: 20px;
            border-top: 1px solid rgba(0,0,0,0.1);
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
            color: var(--primary-color);
        }

        .receipt-footer {
            margin-top: 30px;
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid rgba(0,0,0,0.1);
        }

        .receipt-actions {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }

        /* Login requerido */
        .login-required {
            text-align: center;
            padding: 40px 0;
        }

        .login-required p {
            font-size: 1.2em;
            margin-bottom: 20px;
            color: var(--text-color);
        }

        /* Footer */
        .footer {
            background: var(--header-bg);
            padding: 80px 0 30px;
            color: var(--header-text);
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
            color: var(--header-text);
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
            border-top: 1px solid rgba(255, 255, 255, 0.1);
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
            .form-row {
                flex-direction: column;
                gap: 0;
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

            #cartItems li {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .cart-item-quantity {
                justify-content: flex-start;
                width: 100%;
            }

            .remove-btn {
                margin-left: 0;
                width: 100%;
            }

            .payment-methods {
                flex-direction: column;
            }

            .payment-method {
                min-width: 100%;
            }

            .receipt-actions {
                flex-direction: column;
                align-items: center;
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
                background: white;
                color: black;
            }
            .receipt-actions {
                display: none;
            }
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="container header-container">
            <div class="logo">
                <img src="../img/cafe/cafe1.png" alt="Logotipo" class="logo-image">
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
                    <a href="diagrama_bd.php" class="nav-link">Estructura BD</a>
                    <a href="estadisticas.php" class="nav-link">Estadísticas</a>
                </nav>
            </div>
        </div>
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
                                <input type="text" id="mobileNumber" class="form-control" placeholder="+58000-0000000" 
                                       pattern="^\+58[0-9]{3}-[0-9]{7}$" title="Formato: +58XXX-XXXXXXX" required>
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

    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>Pana' Cafeteria</h3>
                    <p>Desde 2010 ofreciendo los mejores productos artesanales de panadería y cafetería, elaborados con ingredientes naturales y mucho amor.</p>
                    <div class="social-media">
                        <a href="https://www.facebook.com/" class="social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.instagram.com/" class="social-link"><i class="fab fa-instagram"></i></a>
                        <a href="https://github.com/rgamercm" class="social-link"><i class="fab fa-github"></i></a>
                    </div>
                </div>
                <div class="footer-column">
                    <h3>Enlaces rápidos</h3>
                    <ul class="footer-links">
                        <li><a href="index2.php"><i class="fas fa-chevron-right"></i> Inicio</a></li>
                        <li><a href="catalogo.php"><i class="fas fa-chevron-right"></i> Productos</a></li>
                        <li><a href="registrar.php"><i class="fas fa-chevron-right"></i> Registrarse</a></li>
                        <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] === 'administrador'): ?>
                            <li><a href="inventario.php"><i class="fas fa-chevron-right"></i> Inventario</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Contacto</h3>
                    <ul class="footer-links">
                        <li><a href="#"><i class="fas fa-map-marker-alt"></i> Av. Principal 123, Ciudad</a></li>
                        <li><a href="tel:+584244258944"><i class="fas fa-phone"></i> +58000-0000000</a></li>
                        <li><a href="mailto:panacafeteria@gmail.com"><i class="fas fa-envelope"></i> panacafeteria@gmail.com</a></li>
                        <li><a href="#"><i class="fas fa-clock"></i> Lunes a Domingo: 7am - 8pm</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy;Pana' Cafeteria. Todos los Derechos Reservados.</p>
            </div>
        </div>
    </footer>
    
    <div class="back-to-top" id="backToTop">
        <i class="fas fa-arrow-up"></i>
    </div>
    
    <audio id="backgroundMusic" loop>
        <source src="../musica/videoplayback (online-audio-converter.com).mp3" type="audio/mp3">
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
            const cartItemsList = document.getElementById('cartItems');
            const totalPriceElement = document.getElementById('totalPrice');
            const proceedToCheckoutBtn = document.getElementById('proceedToCheckout');
            const checkoutForm = document.getElementById('checkoutForm');
            const receipt = document.getElementById('receipt');
            const completePurchaseBtn = document.getElementById('completePurchase');
            const mobileNumberInput = document.getElementById('mobileNumber');

            let cart = JSON.parse(localStorage.getItem('cart')) || [];

            // Función para formatear el número de celular
            function formatMobileNumber(input) {
                let value = input.value.replace(/[^0-9]/g, ''); // Eliminar caracteres no numéricos
                
                if (!value.startsWith('58')) {
                    value = '58' + value; // Asegurar que empiece con 58
                }

                if (value.length > 10) { // 58 + 3 (código) + 7 (número)
                    value = value.substring(0, 10);
                }

                let formattedValue = '+';
                if (value.length > 0) {
                    formattedValue += value.substring(0, 2); // +58
                }
                if (value.length > 2) {
                    formattedValue += value.substring(2, 5); // +58XXX
                }
                if (value.length > 5) {
                    formattedValue += '-' + value.substring(5, 12); // +58XXX-XXXXXXX
                }
                input.value = formattedValue;
            }

            // Aplicar el formato al cargar y al escribir
            if (mobileNumberInput) {
                mobileNumberInput.addEventListener('input', function() {
                    formatMobileNumber(this);
                });
                // Asegurar el formato inicial si ya hay un valor
                if (mobileNumberInput.value) {
                    formatMobileNumber(mobileNumberInput);
                }
            }

            // Actualizar el carrito al cargar la página
            updateCartDisplay();

            proceedToCheckoutBtn.addEventListener('click', function() {
                if (cart.length === 0) {
                    alert('Tu carrito está vacío. Agrega productos antes de proceder al pago.');
                    return;
                }
                document.getElementById('cartContent').style.display = 'none';
                checkoutForm.style.display = 'block';
                selectPaymentMethod('tarjeta'); // Seleccionar tarjeta por defecto
            });

            completePurchaseBtn.addEventListener('click', function() {
                // Aquí iría la lógica para procesar el pago
                // Por ahora, solo mostramos el recibo
                displayReceipt();
            });

            function updateCartDisplay() {
                cartItemsList.innerHTML = '';
                let total = 0;

                if (cart.length === 0) {
                    cartItemsList.innerHTML = '<li>Tu carrito está vacío.</li>';
                    totalPriceElement.textContent = 'Total: $0.00';
                    proceedToCheckoutBtn.disabled = true;
                    return;
                }

                cart.forEach(item => {
                    const li = document.createElement('li');
                    const itemTotal = item.price * item.quantity;
                    total += itemTotal;

                    li.innerHTML = `
                        <div class="cart-item-info">
                            <img src="${item.image}" alt="${item.name}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px; margin-right: 10px;">
                            <span>${item.name}</span>
                        </div>
                        <div class="cart-item-quantity">
                            <button class="quantity-btn" data-id="${item.id}" data-change="-1">-</button>
                            <span>${item.quantity}</span>
                            <button class="quantity-btn" data-id="${item.id}" data-change="1">+</button>
                            <button class="remove-btn" data-id="${item.id}">Eliminar</button>
                        </div>
                        <div class="cart-item-total">$${itemTotal.toFixed(2)}</div>
                    `;
                    cartItemsList.appendChild(li);
                });

                totalPriceElement.textContent = `Total: $${total.toFixed(2)}`;
                proceedToCheckoutBtn.disabled = false;

                // Add event listeners for quantity buttons
                document.querySelectorAll('.quantity-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const productId = parseInt(this.dataset.id);
                        const change = parseInt(this.dataset.change);
                        updateCartItemQuantity(productId, change);
                    });
                });

                // Add event listeners for remove buttons
                document.querySelectorAll('.remove-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const productId = parseInt(this.dataset.id);
                        removeCartItem(productId);
                    });
                });
                updateCartCounter();
            }

            function updateCartItemQuantity(productId, change) {
                const itemIndex = cart.findIndex(item => item.id === productId);
                if (itemIndex > -1) {
                    const currentItem = cart[itemIndex];
                    const newQuantity = currentItem.quantity + change;

                    if (newQuantity <= 0) {
                        removeCartItem(productId);
                    } else {
                        // Simulate checking stock (in a real app, this would be an AJAX call to backend)
                        // For now, assume infinite stock or handle client-side
                        cart[itemIndex].quantity = newQuantity;
                        localStorage.setItem('cart', JSON.stringify(cart));
                        updateCartDisplay();
                    }
                }
            }

            function removeCartItem(productId) {
                cart = cart.filter(item => item.id !== productId);
                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartDisplay();
            }

            function updateCartCounter() {
                const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
                const cartCounterElement = document.getElementById('cartCounter');
                if (cartCounterElement) {
                    cartCounterElement.textContent = totalItems;
                }
            }

            window.selectPaymentMethod = function(method) {
                document.querySelectorAll('.payment-method').forEach(pm => {
                    pm.classList.remove('selected');
                    pm.querySelector('input[type="radio"]').checked = false;
                });
                document.getElementById(method).checked = true;
                document.getElementById(method).closest('.payment-method').classList.add('selected');

                document.querySelectorAll('.payment-details').forEach(pd => {
                    pd.classList.remove('active');
                });
                document.getElementById(method + 'Details').classList.add('active');
            };

            window.backToCart = function() {
                checkoutForm.style.display = 'none';
                document.getElementById('cartContent').style.display = 'block';
            };

            function displayReceipt() {
                checkoutForm.style.display = 'none';
                receipt.style.display = 'block';
                receipt.classList.add('active');

                const now = new Date();
                document.getElementById('receiptDate').textContent = now.toLocaleString();
                document.getElementById('receiptOrderId').textContent = Math.floor(Math.random() * 1000000); // Random order ID

                const receiptItemsList = document.getElementById('receiptItems');
                receiptItemsList.innerHTML = '';
                let subtotal = 0;

                cart.forEach(item => {
                    const itemTotal = item.price * item.quantity;
                    subtotal += itemTotal;
                    const div = document.createElement('div');
                    div.classList.add('receipt-item');
                    div.innerHTML = `
                        <span>${item.name} (x${item.quantity})</span>
                        <span>$${itemTotal.toFixed(2)}</span>
                    `;
                    receiptItemsList.appendChild(div);
                });

                const taxRate = 0.16; // 16% IVA
                const tax = subtotal * taxRate;
                const total = subtotal + tax;

                document.getElementById('receiptSubtotal').textContent = `$${subtotal.toFixed(2)}`;
                document.getElementById('receiptTax').textContent = `$${tax.toFixed(2)}`;
                document.getElementById('receiptTotal').textContent = `$${total.toFixed(2)}`;

                const selectedPaymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;
                let paymentMethodText = '';
                switch (selectedPaymentMethod) {
                    case 'tarjeta':
                        paymentMethodText = 'Método de Pago: Tarjeta de Crédito/Débito';
                        break;
                    case 'transferencia':
                        paymentMethodText = 'Método de Pago: Transferencia Bancaria';
                        break;
                    case 'pago_movil':
                        paymentMethodText = 'Método de Pago: Pago Móvil';
                        break;
                    case 'efectivo':
                        paymentMethodText = 'Método de Pago: Efectivo';
                        break;
                }
                document.getElementById('receiptPaymentMethod').textContent = paymentMethodText;

                const deliveryAddress = document.getElementById('deliveryAddress').value;
                document.getElementById('receiptDeliveryAddress').textContent = deliveryAddress ? `Dirección de Envío: ${deliveryAddress}` : 'Sin dirección de envío especificada.';

                // Clear cart after successful purchase
                cart = [];
                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartCounter();
            }

            window.newOrder = function() {
                receipt.style.display = 'none';
                document.getElementById('cartContent').style.display = 'block';
                updateCartDisplay(); // Refresh cart display to show it's empty
            };
        });
    </script>
</body>
</html>
