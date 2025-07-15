    <?php
    session_start(); // Asegúrate de que la sesión esté iniciada

    if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'administrador') {
        echo json_encode(['success' => false, 'message' => 'Acceso denegado. Solo administradores pueden ver las estadísticas.']); // <-- Mensaje actualizado
        exit();
    }

    // Resto del código para obtener estadísticas
    ?>
    
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadísticas - El Café Con La Pan-dilla</title>
    <link rel="shortcut icon" href="../img/cafe.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Imperial+Script&family=Lobster&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        .btn-outline {
            background: transparent;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
        }

        .btn-outline:hover {
            background: var(--primary-color);
            color: white;
        }

        .section-title {
            text-align: center;
            margin-bottom: 60px;
            position: relative;
        }

        .section-title h2 {
            font-size: 36px;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .section-title p {
            color: var(--text-color);
            max-width: 700px;
            margin: 0 auto;
        }

        .section-title::after {
            content: '';
            display: block;
            width: 80px;
            height: 3px;
            background: var(--primary-color);
            margin: 20px auto;
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

        .header-title {
            font-size: 24px;
            margin: 0;
            color: var(--primary-color);
            font-family: "Playfair Display", serif;
            font-weight: 700;
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

        /* Sección de Estadísticas */
        .statistics-section {
            padding: var(--section-padding);
            background-color: var(--bg-color);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-bottom: 50px;
        }

        .stat-card {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: var(--box-shadow);
            text-align: center;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .stat-card i {
            font-size: 40px;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .stat-card h3 {
            font-size: 20px;
            color: var(--text-color);
            margin-bottom: 10px;
        }

        .stat-card p {
            font-size: 28px;
            font-weight: bold;
            color: var(--primary-color);
        }

        .stats-detail-section {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            padding: 30px;
            box-shadow: var(--box-shadow);
            margin-bottom: 50px;
        }

        .stats-detail-section h3 {
            color: var(--primary-color);
            margin-bottom: 20px;
            font-size: 24px;
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 10px;
        }

        .stats-detail-section table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .stats-detail-section th,
        .stats-detail-section td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .stats-detail-section th {
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
        }

        .stats-detail-section tr:nth-child(even) {
            background-color: rgba(212, 167, 106, 0.05);
        }

        .stats-detail-section tr:hover {
            background-color: rgba(212, 167, 106, 0.1);
        }

        .table-responsive {
            overflow-x: auto;
        }

        /* Loader */
        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid var(--primary-color);
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
            display: none; /* Hidden by default */
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
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
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
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
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 576px) {
            .section-title h2 {
                font-size: 28px;
            }
            
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
        
        /* Estilos para los gráficos */
        .chart-container {
            position: relative;
            height: 400px;
            margin-bottom: 40px;
            background: var(--card-bg);
            padding: 20px;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            transition: var(--transition);
        }
        
        .view-toggle {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 15px;
            gap: 10px;
        }
        
        .view-toggle-btn {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .view-toggle-btn:hover {
            background: var(--secondary-color);
        }
        
        .view-toggle-btn.active {
            background: var(--secondary-color);
            box-shadow: 0 0 0 2px var(--primary-color);
        }
        
        .view-toggle-btn i {
            font-size: 16px;
        }
        
        .data-view {
            display: none;
        }
        
        .data-view.active {
            display: block;
        }
        
        canvas {
            width: 100% !important;
            height: 100% !important;
        }
        
        @media (max-width: 768px) {
            .chart-container {
                height: 300px;
            }
        }
        
    </style>
</head>

<body>
    <header class="header">
        <div class="container header-container">
            <div class="logo">
                <img src="../img/cafe/cafe1.png" alt="Logotipo" class="logo-image">
                <h1 class="header-title"></h1>
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
                    <a href="estadisticas.php" class="nav-link">Estadísticas</a>
                </nav>
            </div>
        </div>
    </header>

    <main class="statistics-section">
        <div class="container">
            <div class="section-title">
                <h2>Estadísticas del Negocio</h2>
                <p>Análisis visual de inventario, ventas y clientes</p>
            </div>
            <div class="loader" id="loader"></div>
            <!-- Estadísticas Generales -->
            <div class="stats-grid" id="generalStats">
                <div class="stat-card">
                    <i class="fas fa-boxes"></i>
                    <h3>Total Productos</h3>
                    <p id="totalProducts">Cargando...</p>
                </div>
                <div class="stat-card">
                    <i class="fas fa-dollar-sign"></i>
                    <h3>Valor Total Inventario</h3>
                    <p id="totalInventoryValue">Cargando...</p>
                </div>
                <div class="stat-card">
                    <i class="fas fa-shopping-bag"></i>
                    <h3>Total Ventas</h3>
                    <p id="totalSales">Cargando...</p>
                </div>
                <div class="stat-card">
                    <i class="fas fa-users"></i>
                    <h3>Total Clientes</h3>
                    <p id="totalCustomers">Cargando...</p>
                </div>
            </div>
            <!-- Inventario por Categoría con Gráfico -->
            <div class="stats-detail-section" id="inventoryStats">
                <h3>Inventario por Categoría</h3>
                
                <div class="view-toggle">
                    <button class="view-toggle-btn active" data-target="chart-inventory">
                        <i class="fas fa-chart-bar"></i> Gráfico
                    </button>
                    <button class="view-toggle-btn" data-target="table-inventory">
                        <i class="fas fa-table"></i> Tabla
                    </button>
                </div>
                
                <div class="data-view active" id="chart-inventory">
                    <div class="chart-container">
                        <canvas id="inventoryChart"></canvas>
                    </div>
                </div>
               
                <div class="data-view" id="table-inventory">
                    <div class="table-responsive">
                        <table id="inventoryByCategoryTable">
                            <thead>
                                <tr>
                                    <th>Categoría</th>
                                    <th>Cantidad de Productos</th>
                                    <th>Valor Estimado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Datos de inventario por categoría -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Productos Más Vendidos con Gráfico -->
            <div class="stats-detail-section" id="bestSellingProducts">
                <h3>Productos Más Vendidos</h3>
                
                <div class="view-toggle">
                    <button class="view-toggle-btn active" data-target="chart-best-sellers">
                        <i class="fas fa-chart-pie"></i> Gráfico
                    </button>
                    <button class="view-toggle-btn" data-target="table-best-sellers">
                        <i class="fas fa-table"></i> Tabla
                    </button>
                </div>
                
                <div class="data-view active" id="chart-best-sellers">
                    <div class="chart-container">
                        <canvas id="bestSellersChart"></canvas>
                    </div>
                </div>
                
                <div class="data-view" id="table-best-sellers">
                    <div class="table-responsive">
                        <table id="bestSellingProductsTable">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Categoría</th>
                                    <th>Cantidad Vendida</th>
                                    <th>Ingresos Generados</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Datos de productos más vendidos -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
           <!-- Productos Menos Vendidos con Gráfico -->
            <div class="stats-detail-section" id="leastSellingProducts">
                <h3>Productos Menos Vendidos</h3>
                
                <div class="view-toggle">
                    <button class="view-toggle-btn active" data-target="chart-least-sellers">
                        <i class="fas fa-chart-bar"></i> Gráfico
                    </button>
                    <button class="view-toggle-btn" data-target="table-least-sellers">
                        <i class="fas fa-table"></i> Tabla
                    </button>
                </div>
                
                <div class="data-view active" id="chart-least-sellers">
                    <div class="chart-container">
                        <canvas id="leastSellersChart"></canvas>
                    </div>
                </div>
               
                <div class="data-view" id="table-least-sellers">
                    <div class="table-responsive">
                        <table id="leastSellingProductsTable">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Categoría</th>
                                    <th>Cantidad Vendida</th>
                                    <th>Ingresos Generados</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Datos de productos menos vendidos -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Historial de Ventas con Gráfico -->
            <div class="stats-detail-section" id="salesHistory">
                <h3>Historial de Ventas</h3>
                
                <div class="view-toggle">
                    <button class="view-toggle-btn active" data-target="chart-sales-history">
                        <i class="fas fa-chart-line"></i> Gráfico
                    </button>
                    <button class="view-toggle-btn" data-target="table-sales-history">
                        <i class="fas fa-table"></i> Tabla
                    </button>
                </div>
                
                <div class="data-view active" id="chart-sales-history">
                    <div class="chart-container">
                        <canvas id="salesHistoryChart"></canvas>
                    </div>
                </div>
                
                <div class="data-view" id="table-sales-history">
                    <div class="table-responsive">
                        <table id="salesHistoryTable">
                            <thead>
                                <tr>
                                    <th>ID Pedido</th>
                                    <th>Fecha</th>
                                    <th>Cliente</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                    <th>Productos</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Datos del historial de ventas -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Historial de Compras por Cliente con Gráfico -->
            <div class="stats-detail-section" id="customerPurchaseHistory">
                <h3>Clientes Top</h3>
                
                <div class="view-toggle">
                    <button class="view-toggle-btn active" data-target="chart-customers">
                        <i class="fas fa-chart-radar"></i> Gráfico
                    </button>
                    <button class="view-toggle-btn" data-target="table-customers">
                        <i class="fas fa-table"></i> Tabla
                    </button>
                </div>
                
                <div class="data-view active" id="chart-customers">
                    <div class="chart-container">
                        <canvas id="customersChart"></canvas>
                    </div>
                </div>
                
                <div class="data-view" id="table-customers">
                    <div class="table-responsive">
                        <table id="customerPurchaseHistoryTable">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Correo</th>
                                    <th>Total Comprado ($)</th>
                                    <th>Cantidad de Pedidos</th>
                                    <th>Último Pedido</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Datos del historial de compras por cliente -->
                            </tbody>
                        </table>
                    </div>
                </div>
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
                        <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] === 'empleado'): ?>
                            <li><a href="inventario.php"><i class="fas fa-chevron-right"></i> Inventario</a></li>
                            <li><a href="estadisticas.php"><i class="fas fa-chevron-right"></i> Estadísticas</a></li>
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

        // Lógica para cargar estadísticas
        document.addEventListener('DOMContentLoaded', fetchStatistics);

        function showLoader() {
            document.getElementById('loader').style.display = 'block';
            document.getElementById('generalStats').style.display = 'none';
            document.getElementById('inventoryStats').style.display = 'none';
            document.getElementById('bestSellingProducts').style.display = 'none';
            document.getElementById('leastSellingProducts').style.display = 'none';
            document.getElementById('salesHistory').style.display = 'none';
            document.getElementById('customerPurchaseHistory').style.display = 'none';
        }

        function hideLoader() {
            document.getElementById('loader').style.display = 'none';
            document.getElementById('generalStats').style.display = 'grid';
            document.getElementById('inventoryStats').style.display = 'block';
            document.getElementById('bestSellingProducts').style.display = 'block';
            document.getElementById('leastSellingProducts').style.display = 'block';
            document.getElementById('salesHistory').style.display = 'block';
            document.getElementById('customerPurchaseHistory').style.display = 'block';
        }

        async function fetchStatistics() {
            showLoader();
            try {
                const response = await fetch('../php/obtener_estadisticas.php');
                const data = await response.json();

                if (data.success) {
                    updateGeneralStats(data.generalStats);
                    updateInventoryByCategory(data.inventoryByCategory);
                    updateBestSellingProducts(data.bestSellingProducts);
                    updateLeastSellingProducts(data.leastSellingProducts);
                    updateSalesHistory(data.salesHistory);
                    updateCustomerPurchaseHistory(data.customerPurchaseHistory);
                    
                    // Inicializar gráficos con los datos
                    initializeCharts(data);
                    setupViewToggles();
                } else {
                    console.error('Error al obtener estadísticas:', data.message);
                    alert('Error al cargar las estadísticas: ' + data.message);
                }
            } catch (error) {
                console.error('Error en la solicitud Fetch:', error);
                alert('Error de conexión al cargar las estadísticas.');
            } finally {
                hideLoader();
            }
        }

        function updateGeneralStats(stats) {
            document.getElementById('totalProducts').textContent = stats.totalProducts;
            document.getElementById('totalInventoryValue').textContent = `$${parseFloat(stats.totalInventoryValue).toFixed(2)}`;
            document.getElementById('totalSales').textContent = `$${parseFloat(stats.totalSales).toFixed(2)}`;
            document.getElementById('totalCustomers').textContent = stats.totalCustomers;
        }

        function updateInventoryByCategory(data) {
            const tbody = document.getElementById('inventoryByCategoryTable').querySelector('tbody');
            tbody.innerHTML = '';
            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="3">No hay datos de inventario por categoría.</td></tr>';
                return;
            }
            data.forEach(row => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${row.categoria_nombre}</td>
                    <td>${row.cantidad_productos}</td>
                    <td>$${parseFloat(row.valor_estimado).toFixed(2)}</td>
                `;
                tbody.appendChild(tr);
            });
        }

        function updateBestSellingProducts(data) {
            const tbody = document.getElementById('bestSellingProductsTable').querySelector('tbody');
            tbody.innerHTML = '';
            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="4">No hay productos vendidos aún.</td></tr>';
                return;
            }
            data.forEach(row => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${row.nombre_producto}</td>
                    <td>${row.categoria_nombre}</td>
                    <td>${row.cantidad_vendida}</td>
                    <td>$${parseFloat(row.ingresos_generados).toFixed(2)}</td>
                `;
                tbody.appendChild(tr);
            });
        }

        function updateLeastSellingProducts(data) {
            const tbody = document.getElementById('leastSellingProductsTable').querySelector('tbody');
            tbody.innerHTML = '';
            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="4">Todos los productos se han vendido.</td></tr>';
                return;
            }
            data.forEach(row => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${row.nombre_producto}</td>
                    <td>${row.categoria_nombre}</td>
                    <td>${row.cantidad_vendida}</td>
                    <td>$${parseFloat(row.ingresos_generados).toFixed(2)}</td>
                `;
                tbody.appendChild(tr);
            });
        }

        function updateSalesHistory(data) {
            const tbody = document.getElementById('salesHistoryTable').querySelector('tbody');
            tbody.innerHTML = '';
            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6">No hay historial de ventas.</td></tr>';
                return;
            }
            data.forEach(row => {
                const tr = document.createElement('tr');
                const productsList = row.productos.map(p => `${p.nombre} (x${p.cantidad})`).join('<br>');
                tr.innerHTML = `
                    <td>${row.id_pedido}</td>
                    <td>${new Date(row.fecha_pedido).toLocaleString()}</td>
                    <td>${row.nombre_cliente} ${row.apellido_cliente}</td>
                    <td>$${parseFloat(row.total_pedido).toFixed(2)}</td>
                    <td>${row.estado_pedido}</td>
                    <td>${productsList}</td>
                `;
                tbody.appendChild(tr);
            });
        }

        function updateCustomerPurchaseHistory(data) {
            const tbody = document.getElementById('customerPurchaseHistoryTable').querySelector('tbody');
            tbody.innerHTML = '';
            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5">No hay historial de compras de clientes.</td></tr>';
                return;
            }
            data.forEach(row => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${row.nombre_cliente} ${row.apellido_cliente}</td>
                    <td>${row.correo_cliente}</td>
                    <td>$${parseFloat(row.total_comprado).toFixed(2)}</td>
                    <td>${row.cantidad_pedidos}</td>
                    <td>${row.ultimo_pedido ? new Date(row.ultimo_pedido).toLocaleString() : 'N/A'}</td>
                `;
                tbody.appendChild(tr);
            });
        }
                // Función para alternar entre vistas (tabla/gráfico)
        function setupViewToggles() {
            const toggleButtons = document.querySelectorAll('.view-toggle-btn');
            
            toggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const parentSection = this.closest('.stats-detail-section');
                    const targetId = this.getAttribute('data-target');
                    
                    // Desactivar todos los data-views en esta sección
                    parentSection.querySelectorAll('.data-view').forEach(view => {
                        view.classList.remove('active');
                    });
                    
                    // Activar el target seleccionado
                    document.getElementById(targetId).classList.add('active');
                    
                    // Actualizar estado de los botones
                    parentSection.querySelectorAll('.view-toggle-btn').forEach(btn => {
                        btn.classList.remove('active');
                    });
                    this.classList.add('active');
                    
                    // Redibujar gráficos si es necesario
                    if (targetId.includes('chart')) {
                        const chartId = targetId.split('-').join('');
                        const chart = window[chartId + 'ChartInstance'];
                        if (chart) {
                            chart.update();
                        }
                    }
                });
            });
        }
        
        // Función para inicializar todos los gráficos
        function initializeCharts(data) {
            createInventoryChart(data.inventoryByCategory);
            createBestSellersChart(data.bestSellingProducts);
            createLeastSellersChart(data.leastSellingProducts);
            createSalesHistoryChart(data.salesHistory);
            createCustomersChart(data.customerPurchaseHistory);
        }
        
        // Gráfico de barras para inventario por categoría
        function createInventoryChart(data) {
            const ctx = document.getElementById('inventoryChart').getContext('2d');
            const labels = data.map(item => item.categoria_nombre);
            const values = data.map(item => item.valor_estimado);
            const counts = data.map(item => item.cantidad_productos);
            
            window.inventoryChartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Valor Estimado ($)',
                            data: values,
                            backgroundColor: 'rgba(212, 167, 106, 0.7)',
                            borderColor: 'rgba(212, 167, 106, 1)',
                            borderWidth: 1,
                            yAxisID: 'y'
                        },
                        {
                            label: 'Cantidad de Productos',
                            data: counts,
                            backgroundColor: 'rgba(90, 57, 33, 0.7)',
                            borderColor: 'rgba(90, 57, 33, 1)',
                            borderWidth: 1,
                            type: 'line',
                            yAxisID: 'y1'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Valor y Cantidad por Categoría',
                            color: 'var(--text-color)'
                        },
                        legend: {
                            labels: {
                                color: 'var(--text-color)'
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.datasetIndex === 0) {
                                        label += '$' + context.raw.toFixed(2);
                                    } else {
                                        label += context.raw;
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            title: {
                                display: true,
                                text: 'Valor ($)',
                                color: 'var(--text-color)'
                            },
                            ticks: {
                                color: 'var(--text-color)',
                                callback: function(value) {
                                    return '$' + value.toLocaleString();
                                }
                            }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            title: {
                                display: true,
                                text: 'Cantidad',
                                color: 'var(--text-color)'
                            },
                            ticks: {
                                color: 'var(--text-color)'
                            },
                            grid: {
                                drawOnChartArea: false
                            }
                        },
                        x: {
                            ticks: {
                                color: 'var(--text-color)'
                            }
                        }
                    }
                }
            });
        }
        
        // Gráfico circular para productos más vendidos
        function createBestSellersChart(data) {
            const ctx = document.getElementById('bestSellersChart').getContext('2d');
            const labels = data.map(item => item.nombre_producto);
            const values = data.map(item => item.cantidad_vendida);
            
            // Generar colores dinámicos basados en el tema
            const backgroundColors = data.map((_, i) => {
                const hue = (i * 360 / data.length) % 360;
                return `hsla(${hue}, 70%, 60%, 0.7)`;
            });
            
            window.bestSellersChartInstance = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        data: values,
                        backgroundColor: backgroundColors,
                        borderColor: 'var(--card-bg)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Productos Más Vendidos (Cantidad)',
                            color: 'var(--text-color)'
                        },
                        legend: {
                            position: 'right',
                            labels: {
                                color: 'var(--text-color)',
                                font: {
                                    size: window.innerWidth < 768 ? 10 : 12
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = (value / total * 100).toFixed(1);
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    },
                    layout: {
                        padding: {
                            right: window.innerWidth < 768 ? 0 : 20
                        }
                    }
                }
            });
        }
        
        // Gráfico de barras horizontales para productos menos vendidos
        function createLeastSellersChart(data) {
            const ctx = document.getElementById('leastSellersChart').getContext('2d');
            const labels = data.map(item => item.nombre_producto);
            const values = data.map(item => item.cantidad_vendida);
            
            window.leastSellersChartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Unidades Vendidas',
                        data: values,
                        backgroundColor: 'rgba(212, 167, 106, 0.7)',
                        borderColor: 'rgba(212, 167, 106, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Productos Menos Vendidos',
                            color: 'var(--text-color)'
                        },
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: {
                                color: 'var(--text-color)'
                            }
                        },
                        y: {
                            ticks: {
                                color: 'var(--text-color)'
                            }
                        }
                    }
                }
            });
        }
        
        // Gráfico de líneas para historial de ventas
        function createSalesHistoryChart(data) {
            // Agrupar ventas por fecha
            const salesByDate = data.reduce((acc, sale) => {
                const date = new Date(sale.fecha_pedido).toLocaleDateString();
                if (!acc[date]) {
                    acc[date] = { total: 0, count: 0 };
                }
                acc[date].total += parseFloat(sale.total_pedido);
                acc[date].count += 1;
                return acc;
            }, {});
            
            const dates = Object.keys(salesByDate).reverse();
            const totals = dates.map(date => salesByDate[date].total);
            const counts = dates.map(date => salesByDate[date].count);
            
            const ctx = document.getElementById('salesHistoryChart').getContext('2d');
            
            window.salesHistoryChartInstance = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dates,
                    datasets: [
                        {
                            label: 'Total de Ventas ($)',
                            data: totals,
                            borderColor: 'rgba(212, 167, 106, 1)',
                            backgroundColor: 'rgba(212, 167, 106, 0.2)',
                            borderWidth: 2,
                            tension: 0.1,
                            yAxisID: 'y'
                        },
                        {
                            label: 'Número de Pedidos',
                            data: counts,
                            borderColor: 'rgba(90, 57, 33, 1)',
                            backgroundColor: 'rgba(90, 57, 33, 0.2)',
                            borderWidth: 2,
                            tension: 0.1,
                            yAxisID: 'y1'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Tendencia de Ventas',
                            color: 'var(--text-color)'
                        },
                        legend: {
                            labels: {
                                color: 'var(--text-color)'
                            }
                        }
                    },
                    scales: {
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            title: {
                                display: true,
                                text: 'Total ($)',
                                color: 'var(--text-color)'
                            },
                            ticks: {
                                color: 'var(--text-color)',
                                callback: function(value) {
                                    return '$' + value.toLocaleString();
                                }
                            }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            title: {
                                display: true,
                                text: 'Número de Pedidos',
                                color: 'var(--text-color)'
                            },
                            ticks: {
                                color: 'var(--text-color)'
                            },
                            grid: {
                                drawOnChartArea: false
                            }
                        },
                        x: {
                            ticks: {
                                color: 'var(--text-color)'
                            }
                        }
                    }
                }
            });
        }
        
        // Gráfico de radar para clientes top
        function createCustomersChart(data) {
            const ctx = document.getElementById('customersChart').getContext('2d');
            const labels = data.map(item => `${item.nombre_cliente} ${item.apellido_cliente}`);
            const totals = data.map(item => parseFloat(item.total_comprado));
            const orders = data.map(item => parseFloat(item.cantidad_pedidos));
            
            // Normalizar datos para radar
            const maxTotal = Math.max(...totals);
            const maxOrders = Math.max(...orders);
            const normalizedTotals = totals.map(t => (t / maxTotal * 10).toFixed(1));
            const normalizedOrders = orders.map(o => (o / maxOrders * 10).toFixed(1));
            
            window.customersChartInstance = new Chart(ctx, {
                type: 'radar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Total Comprado',
                            data: normalizedTotals,
                            backgroundColor: 'rgba(212, 167, 106, 0.2)',
                            borderColor: 'rgba(212, 167, 106, 1)',
                            pointBackgroundColor: 'rgba(212, 167, 106, 1)',
                            pointBorderColor: '#fff',
                            pointHoverBackgroundColor: '#fff',
                            pointHoverBorderColor: 'rgba(212, 167, 106, 1)'
                        },
                        {
                            label: 'Número de Pedidos',
                            data: normalizedOrders,
                            backgroundColor: 'rgba(90, 57, 33, 0.2)',
                            borderColor: 'rgba(90, 57, 33, 1)',
                            pointBackgroundColor: 'rgba(90, 57, 33, 1)',
                            pointBorderColor: '#fff',
                            pointHoverBackgroundColor: '#fff',
                            pointHoverBorderColor: 'rgba(90, 57, 33, 1)'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Clientes Top (Normalizado)',
                            color: 'var(--text-color)'
                        },
                        legend: {
                            labels: {
                                color: 'var(--text-color)'
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const index = context.dataIndex;
                                    const datasetLabel = context.dataset.label;
                                    if (datasetLabel === 'Total Comprado') {
                                        return `${datasetLabel}: $${totals[index].toFixed(2)}`;
                                    } else {
                                        return `${datasetLabel}: ${orders[index]}`;
                                    }
                                }
                            }
                        }
                    },
                    scales: {
                        r: {
                            angleLines: {
                                color: 'rgba(200, 200, 200, 0.5)'
                            },
                            grid: {
                                color: 'rgba(200, 200, 200, 0.5)'
                            },
                            pointLabels: {
                                color: 'var(--text-color)'
                            },
                            ticks: {
                                backdropColor: 'var(--bg-color)',
                                color: 'var(--text-color)',
                                showLabelBackdrop: false
                            }
                        }
                    }
                }
            });
        }
        
        // Modificar la función fetchStatistics para inicializar gráficos
        async function fetchStatistics() {
            showLoader();
            try {
                const response = await fetch('../php/obtener_estadisticas.php');
                const data = await response.json();

                if (data.success) {
                    updateGeneralStats(data.generalStats);
                    updateInventoryByCategory(data.inventoryByCategory);
                    updateBestSellingProducts(data.bestSellingProducts);
                    updateLeastSellingProducts(data.leastSellingProducts);
                    updateSalesHistory(data.salesHistory);
                    updateCustomerPurchaseHistory(data.customerPurchaseHistory);
                    
                    // Inicializar gráficos con los datos
                    initializeCharts(data);
                    setupViewToggles();
                } else {
                    console.error('Error al obtener estadísticas:', data.message);
                    alert('Error al cargar las estadísticas: ' + data.message);
                }
            } catch (error) {
                console.error('Error en la solicitud Fetch:', error);
                alert('Error de conexión al cargar las estadísticas.');
            } finally {
                hideLoader();
            }
        }

    </script>
</body>
</html>
