<?php
require_once '../php/verificar_sesion.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    // Si no hay sesión activa, redirigir al login
    header("Location:../php/login_usuario_be.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario - El Café Con La Pan-dilla</title>
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

        /* Inventario */
        .inventory-section {
            padding: var(--section-padding);
            background-color: var(--background-color-card);
        }

        .inventory-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            box-shadow: var(--box-shadow);
            background-color: var(--card-bg);
            border-radius: var(--border-radius);
            overflow: hidden;
        }

        .inventory-table th, 
        .inventory-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid rgba(0,0,0,0.1);
        }

        .inventory-table th {
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
        }

        .inventory-table tr:hover {
            background-color: rgba(212, 167, 106, 0.1);
        }

        .inventory-table .low-stock {
            color: #ff6b6b;
            font-weight: bold;
        }

        .inventory-actions {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .user-welcome {
            text-align: center;
            margin-bottom: 20px;
            font-size: 18px;
            color: var(--primary-color);
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

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: var(--card-bg);
            margin: 5% auto;
            padding: 30px;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            max-width: 600px;
            width: 90%;
        }

        .close-btn {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close-btn:hover {
            color: var(--primary-color);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: var(--card-bg);
            color: var(--text-color);
        }

        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-col {
            flex: 1;
        }

        .required-field::after {
            content: " *";
            color: #ff6b6b;
        }

        /* Media Queries */
        @media (max-width: 992px) {
            .inventory-table {
                display: block;
                overflow-x: auto;
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
            
            .inventory-actions {
                flex-direction: column;
                gap: 15px;
            }

            .form-row {
                flex-direction: column;
                gap: 0;
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

            .modal-content {
                margin: 10% auto;
                width: 95%;
                padding: 20px;
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
                </nav>
            </div>
        </div>
    </header>

    <main class="dashboard">
        <div class="container">
            <div class="section-title">
                <h2>Gestión de Inventario</h2>
                <p>Administra los productos disponibles en tu cafetería</p>
            </div>
            
            <div class="user-welcome">
                <p>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']['nombre']) . ' ' . htmlspecialchars($_SESSION['usuario']['apellido']); ?></p>
            </div>
            
            <div class="inventory-actions">
                <button class="btn" id="addProductBtn">
                    <i class="fas fa-plus"></i> Agregar Producto
                </button>

                <button class="btn btn-outline" id="addSampleBtn">
                    <i class="fas fa-vial"></i> Agregar Ejemplos
                </button>

                <button class="btn btn-outline" id="removeAllBtn">
                    <i class="fas fa-minus"></i> Quitar Todos
                </button>

                <div>
                    <button class="btn btn-outline" id="exportBtn">
                        <i class="fas fa-file-export"></i> Exportar
                    </button>
                    <button class="btn btn-outline" id="printBtn">
                        <i class="fas fa-print"></i> Imprimir
                    </button>
                </div>
            </div>
            
            <table class="inventory-table">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Existencias</th>
                        <th>Mínimo</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include '../php/conexion_be.php';
                    
                    $query = "SELECT i.*, c.nombre AS categoria_nombre 
                            FROM inventario i
                            LEFT JOIN categorias c ON i.categoria_id = c.id
                            ORDER BY c.nombre, i.nombre";
                    $result = mysqli_query($conexion, $query);
                    
                    if(mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            $lowStockClass = ($row['unidades_existentes'] < $row['unidades_minimas']) ? 'low-stock' : '';
                            $statusClass = '';
                            
                            if($row['estado'] == 'inactivo') {
                                $statusClass = 'text-muted';
                            } elseif($row['estado'] == 'agotado') {
                                $statusClass = 'text-danger';
                            }
                            
                            echo "<tr>
                                <td>{$row['codigo']}</td>
                                <td>{$row['nombre']}</td>
                                <td>{$row['descripcion']}</td>
                                <td>{$row['categoria_nombre']}</td>
                                <td>\${$row['precio']}</td>
                                <td class='{$lowStockClass}'>{$row['unidades_existentes']}";
                            
                            if($row['unidades_existentes'] < $row['unidades_minimas']) {
                                echo " <i class='fas fa-exclamation-triangle'></i>";
                            }
                            
                            echo "</td>
                                <td>{$row['unidades_minimas']}</td>
                                <td class='{$statusClass}'>{$row['estado']}</td>
                                <td>
                                    <button class='btn btn-outline btn-sm edit-btn' data-id='{$row['id']}'>
                                        <i class='fas fa-edit'></i>
                                    </button>
                                    <button class='btn btn-outline btn-sm delete-btn' data-id='{$row['id']}'>
                                        <i class='fas fa-trash'></i>
                                    </button>              
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9' style='text-align: center;'>No hay productos en el inventario</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
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
                        <li><a href="inventario.php"><i class="fas fa-chevron-right"></i> Inventario</a></li>
                        <li><a href="nosotros.php"><i class="fas fa-chevron-right"></i> Nosotros</a></li>
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
    
    <!-- Modal para agregar/editar productos -->
    <div id="productModal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2 id="modalTitle">Agregar Nuevo Producto</h2>
            <form id="productForm">
                <input type="hidden" id="productId" name="id">
                <input type="hidden" id="action" name="action" value="agregar">
                
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="codigo" class="required-field">Código</label>
                            <input type="text" id="codigo" name="codigo" required>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="nombre" class="required-field">Nombre</label>
                            <input type="text" id="nombre" name="nombre" required>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea id="descripcion" name="descripcion" rows="3"></textarea>
                </div>
                
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="categoria">Categoría</label>
                            <select id="categoria" name="categoria">
                                <option value="Bebidas">Bebidas</option>
                                <option value="Panadería">Panadería</option>
                                <option value="Postres">Postres</option>
                                <option value="Otros">Otros</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="precio" class="required-field">Precio</label>
                            <input type="number" id="precio" name="precio" step="0.01" min="0" required>
                        </div>
                        <div class="form-group">
                            <label for="pagina" class="required-field">Página asociada (p1, p2, etc.)</label>
                            <input type="text" id="pagina" name="pagina" required>
                        </div>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="cantidad">Cantidad</label>
                            <input type="number" id="cantidad" name="cantidad" min="0" value="0">
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="unidades_existentes">Existencias</label>
                            <input type="number" id="unidades_existentes" name="unidades_existentes" min="0">
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="unidades_minimas">Mínimo requerido</label>
                            <input type="number" id="unidades_minimas" name="unidades_minimas" min="1" value="10">
                        </div>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="fecha_ingreso">Fecha de ingreso</label>
                            <input type="date" id="fecha_ingreso" name="fecha_ingreso" pattern="\d{4}-\d{2}-\d{2}">
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="estado">Estado</label>
                            <select id="estado" name="estado">
                                <option value="activo">Activo</option>
                                <option value="inactivo">Inactivo</option>
                                <option value="agotado">Agotado</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="btn">
                    <i class="fas fa-save"></i> Guardar Producto
                </button>
            </form>
        </div>
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

    // Modal para agregar/editar productos
    const modal = document.getElementById("productModal");
    const addProductBtn = document.getElementById("addProductBtn");
    const addSampleBtn = document.getElementById("addSampleBtn");
    const closeBtn = document.querySelector(".close-btn");
    const productForm = document.getElementById("productForm");
    const modalTitle = document.getElementById("modalTitle");

    // Cargar categorías al iniciar
    function cargarCategorias() {
        fetch('../php/obtener_categorias.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al cargar categorías');
                }
                return response.json();
            })
            .then(categorias => {
                const select = document.getElementById('categoria');
                select.innerHTML = '';
                
                categorias.forEach(categoria => {
                    const option = document.createElement('option');
                    option.value = categoria.nombre;
                    option.textContent = categoria.nombre;
                    select.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error al cargar categorías:', error);
            });
    }

    // Mostrar modal para agregar producto
    addProductBtn.onclick = function() {
        modalTitle.textContent = "Agregar Nuevo Producto";
        document.getElementById('action').value = 'agregar';
        productForm.reset();
        
        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0');
        const day = String(today.getDate()).padStart(2, '0');
        document.getElementById('fecha_ingreso').value = `${year}-${month}-${day}`;
        
        document.getElementById('unidades_existentes').value = document.getElementById('cantidad').value || '0';
        modal.style.display = "block";
    }

    // Agregar productos de ejemplo
    addSampleBtn.onclick = function() {
        if (confirm('¿Deseas agregar los productos de ejemplo al inventario?')) {
            const formData = new FormData();
            formData.append('action', 'agregar_ejemplos');
            
            // Mostrar loader
            addSampleBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Procesando...';
            addSampleBtn.disabled = true;
            
            fetch('../php/operaciones_inventario.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => { throw new Error(text || 'Error en el servidor'); });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    throw new Error(data.message || 'Error al agregar ejemplos');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error: ' + error.message);
            })
            .finally(() => {
                addSampleBtn.innerHTML = '<i class="fas fa-vial"></i> Agregar Ejemplos';
                addSampleBtn.disabled = false;
            });
        }
    }

    // Cerrar modal
    closeBtn.onclick = function() {
        modal.style.display = "none";
    }

    // Cerrar modal al hacer clic fuera
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    // Sincronizar cantidad con existencias
    document.getElementById('cantidad').addEventListener('input', function() {
        const existentes = document.getElementById('unidades_existentes');
        if (!existentes.value || existentes.value === "0") {
            existentes.value = this.value;
        }
    });

    // Manejar envío del formulario
    productForm.onsubmit = function(e) {
        e.preventDefault();
        
        // Validar campos obligatorios
        if (!document.getElementById('codigo').value || 
            !document.getElementById('nombre').value || 
            !document.getElementById('precio').value ||
            !document.getElementById('pagina').value ||
            !document.getElementById('categoria').value) {
            alert('Complete los campos obligatorios (Código, Nombre, Precio, Página y Categoría)');
            return;
        }
        
        if (parseFloat(document.getElementById('precio').value) <= 0) {
            alert('El precio debe ser mayor a cero');
            return;
        }
        
        if (!/^p\d+$/.test(document.getElementById('pagina').value)) {
            alert('El formato de página debe ser p1, p2, etc.');
            return;
        }
        
        const formData = new FormData(productForm);
        
        // Mostrar loader
        const submitBtn = productForm.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Procesando...';
        submitBtn.disabled = true;
        
        fetch('../php/operaciones_inventario.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => { throw new Error(text || 'Error en el servidor'); });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                alert(data.message);
                modal.style.display = "none";
                location.reload();
            } else {
                throw new Error(data.message || 'Error al guardar');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error: ' + error.message);
        })
        .finally(() => {
            submitBtn.innerHTML = originalBtnText;
            submitBtn.disabled = false;
        });
    };

    // Eliminar todos los productos
    document.getElementById('removeAllBtn').addEventListener('click', function() {
        if (confirm('¿Estás seguro de eliminar TODOS los productos? Esta acción no se puede deshacer.')) {
            const formData = new FormData();
            formData.append('action', 'quitar_todos');
            
            // Mostrar loader
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Procesando...';
            this.disabled = true;
            
            fetch('../php/operaciones_inventario.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => { throw new Error(text || 'Error en el servidor'); });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    document.querySelector('.inventory-table tbody').innerHTML = 
                        '<tr><td colspan="9" style="text-align: center;">No hay productos en el inventario</td></tr>';
                    alert(data.message);
                } else {
                    throw new Error(data.message || 'Error al eliminar');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error: ' + error.message);
            })
            .finally(() => {
                this.innerHTML = '<i class="fas fa-minus"></i> Quitar Todos';
                this.disabled = false;
            });
        }
    });

    // Eliminar producto individual
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');
            const productName = this.closest('tr').querySelector('td:nth-child(2)').textContent;
            
            if(confirm(`¿Eliminar el producto "${productName}"?`)) {
                const formData = new FormData();
                formData.append('action', 'quitar');
                formData.append('id', productId);
                
                // Mostrar loader
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                this.disabled = true;
                
                fetch('../php/operaciones_inventario.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        return response.text().then(text => { throw new Error(text || 'Error en el servidor'); });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        this.closest('tr').remove();
                        
                        const tbody = document.querySelector('.inventory-table tbody');
                        if (tbody.querySelectorAll('tr').length === 0) {
                            tbody.innerHTML = '<tr><td colspan="9" style="text-align: center;">No hay productos en el inventario</td></tr>';
                        }
                        
                        alert(data.message);
                    } else {
                        throw new Error(data.message || 'Error al eliminar');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error: ' + error.message);
                })
                .finally(() => {
                    this.innerHTML = '<i class="fas fa-trash"></i>';
                    this.disabled = false;
                });
            }
        });
    });

    // Editar producto
    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');
            
            // Mostrar loader
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            this.disabled = true;
            
            fetch(`../php/obtener_producto.php?id=${productId}`)
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => { throw new Error(text || 'Error en el servidor'); });
                }
                return response.json();
            })
            .then(product => {
                if (product.error) {
                    throw new Error(product.error);
                }
                
                modalTitle.textContent = "Editar Producto";
                document.getElementById('action').value = 'editar';
                document.getElementById('productId').value = product.id;
                document.getElementById('codigo').value = product.codigo;
                document.getElementById('nombre').value = product.nombre;
                document.getElementById('descripcion').value = product.descripcion;
                document.getElementById('categoria').value = product.categoria_nombre;
                document.getElementById('precio').value = product.precio;
                document.getElementById('pagina').value = product.pagina || '';
                document.getElementById('cantidad').value = product.cantidad;
                document.getElementById('unidades_existentes').value = product.unidades_existentes;
                document.getElementById('unidades_minimas').value = product.unidades_minimas;
                document.getElementById('fecha_ingreso').value = product.fecha_ingreso;
                document.getElementById('estado').value = product.estado;
                
                modal.style.display = "block";
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error: ' + error.message);
            })
            .finally(() => {
                this.innerHTML = '<i class="fas fa-edit"></i>';
                this.disabled = false;
            });
        });
    });

    // Exportar a CSV
    document.getElementById('exportBtn').addEventListener('click', function() {
        let csvContent = "Código,Nombre,Descripción,Categoría,Precio,Existencias,Mínimo,Estado,Página\n";
        
        document.querySelectorAll('.inventory-table tbody tr').forEach(row => {
            if (row.cells.length > 1) {
                const cells = row.cells;
                csvContent += `"${cells[0].textContent}","${cells[1].textContent}","${cells[2].textContent}",` +
                              `"${cells[3].textContent}","${cells[4].textContent.replace('$', '')}",` +
                              `"${cells[5].textContent}","${cells[6].textContent}","${cells[7].textContent}","${cells[8].textContent}"\n`;
            }
        });
        
        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const url = URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.setAttribute('href', url);
        link.setAttribute('download', 'inventario.csv');
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    });

    // Imprimir inventario
    document.getElementById('printBtn').addEventListener('click', function() {
        const originalContents = document.body.innerHTML;
        const printContents = document.querySelector('.inventory-table').outerHTML;
        
        document.body.innerHTML = `
            <h1 style="text-align:center;margin:20px 0;">Inventario - El Café Con La Pan-dilla</h1>
            ${printContents}
            <div style="text-align:center;margin:20px;font-size:12px;">
                Impreso el ${new Date().toLocaleDateString()} a las ${new Date().toLocaleTimeString()}
            </div>
        `;
        
        window.print();
        document.body.innerHTML = originalContents;
    });

    // Cargar categorías al cargar la página
    document.addEventListener('DOMContentLoaded', cargarCategorias);
</script>
</body>
</html>