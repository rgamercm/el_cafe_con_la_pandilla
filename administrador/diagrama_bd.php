<?php
include '../php/conexion_be.php';
include '../php/verificar_sesion.php';
verificarAutenticacion('administrador');

// Función para obtener datos de una tabla
function obtenerDatosTabla($conexion, $tabla) {
    $query = "SELECT * FROM $tabla";
    $result = mysqli_query($conexion, $query);
    $datos = [];
    
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $datos[] = $row;
        }
    }
    
    return $datos;
}

// Obtener datos de todas las tablas
$usuarios = obtenerDatosTabla($conexion, 'usuarios');
$categorias = obtenerDatosTabla($conexion, 'categorias');
$metodos_pago = obtenerDatosTabla($conexion, 'metodos_pago');
$inventario = obtenerDatosTabla($conexion, 'inventario');
$pedidos = obtenerDatosTabla($conexion, 'pedidos');
$detalles_pedido = obtenerDatosTabla($conexion, 'detalles_pedido');
$imagenes_producto = obtenerDatosTabla($conexion, 'imagenes_producto');

// Función para mostrar datos en una tabla HTML
function mostrarDatosEnTabla($datos, $camposMostrar = null) {
    if (empty($datos)) return '<p>No hay registros en esta tabla</p>';
    
    // Si no se especifican campos, mostrar todos excepto algunos sensibles
    if (!$camposMostrar) {
        $camposMostrar = array_keys($datos[0]);
        // Eliminar campos sensibles si existen
        $camposSensibles = ['contrasena', 'datos_pago'];
        $camposMostrar = array_diff($camposMostrar, $camposSensibles);
    }
    
    $html = '<div class="table-responsive"><table class="data-table"><thead><tr>';
    
    // Encabezados
    foreach ($camposMostrar as $campo) {
        $html .= '<th>' . htmlspecialchars($campo) . '</th>';
    }
    $html .= '</tr></thead><tbody>';
    
    // Filas de datos
    foreach ($datos as $fila) {
        $html .= '<tr>';
        foreach ($camposMostrar as $campo) {
            $valor = $fila[$campo] ?? '';
            // Acortar valores largos
            if (is_string($valor) && strlen($valor) > 50) {
                $valor = substr($valor, 0, 50) . '...';
            }
            $html .= '<td>' . htmlspecialchars($valor) . '</td>';
        }
        $html .= '</tr>';
    }
    
    $html .= '</tbody></table></div>';
    return $html;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estructura de Base de Datos - El Café Con La Pan-dilla</title>
    <link rel="shortcut icon" href="../img/cafe.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Imperial+Script&family=Lobster&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
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

        .header-controls {
            display: flex;
            align-items: center;
            gap: 20px;
        }

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

        .database-structure {
            padding: var(--section-padding);
            background-color: var(--background-color-card);
        }

        .database-card {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            padding: 40px;
            box-shadow: var(--box-shadow);
            margin-bottom: 40px;
            transition: all 0.3s ease;
        }

        .database-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .database-card h2 {
            font-size: 28px;
            color: var(--primary-color);
            margin-bottom: 30px;
            position: relative;
            padding-bottom: 10px;
        }

        .database-card h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background: var(--primary-color);
        }

        .table-container {
            overflow-x: auto;
            margin: 30px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
        }

        tr:nth-child(even) {
            background-color: rgba(212, 167, 106, 0.1);
        }

        tr:hover {
            background-color: rgba(212, 167, 106, 0.2);
        }

        .relationship-diagram {
            display: flex;
            flex-direction: column;
            gap: 40px;
            margin: 40px 0;
        }

        .relationship-group {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            align-items: center;
            justify-content: center;
        }

        .table-box {
            background: var(--card-bg);
            border: 2px solid var(--primary-color);
            border-radius: var(--border-radius);
            padding: 20px;
            min-width: 220px;
            box-shadow: var(--box-shadow);
            transition: all 0.3s ease;
        }

        .table-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .table-box h3 {
            color: var(--primary-color);
            margin-top: 0;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--primary-color);
            font-size: 20px;
        }

        .table-box ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .table-box li {
            padding: 8px 0;
            font-size: 14px;
            color: var(--text-color);
            border-bottom: 1px dashed rgba(212, 167, 106, 0.3);
        }

        .table-box li:last-child {
            border-bottom: none;
        }

        .relationship-line {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .line {
            height: 2px;
            background: var(--primary-color);
            flex-grow: 1;
        }

        .relationship-arrow {
            color: var(--primary-color);
            font-size: 24px;
        }

        .relationship-description {
            background: var(--card-bg);
            padding: 20px;
            border-radius: var(--border-radius);
            border-left: 4px solid var(--primary-color);
            margin: 30px 0;
            box-shadow: var(--box-shadow);
        }

        .relationship-description strong {
            color: var(--primary-color);
        }

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

        /* Estilos para la sección de datos actuales */
        .current-data-section {
            margin-top: 60px;
            padding-top: 40px;
            border-top: 2px solid var(--primary-color);
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 14px;
        }
        
        .data-table th, .data-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        .data-table th {
            background-color: var(--primary-color);
            color: white;
            position: sticky;
            top: 0;
        }
        
        .data-table tr:nth-child(even) {
            background-color: rgba(212, 167, 106, 0.1);
        }
        
        .data-table tr:hover {
            background-color: rgba(212, 167, 106, 0.2);
        }
        
        .table-responsive {
            overflow-x: auto;
            margin-bottom: 30px;
            box-shadow: var(--box-shadow);
            border-radius: var(--border-radius);
        }
        
        .tabla-container {
            margin-bottom: 50px;
        }
        
        .tabla-container h3 {
            color: var(--primary-color);
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 1px solid var(--primary-color);
        }
        
        .tabla-info {
            font-size: 14px;
            color: var(--text-color);
            margin-bottom: 10px;
        }

        @media (max-width: 1200px) {
            .table-box {
                min-width: 200px;
            }
        }

        @media (max-width: 992px) {
            .relationship-group {
                flex-direction: column;
            }
            
            .relationship-line {
                width: 100%;
                flex-direction: row;
            }
            
            .line {
                width: 100%;
                height: 2px;
            }
        }

        @media (max-width: 768px) {
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
            
            .database-card {
                padding: 25px;
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
            
            .database-card {
                padding: 20px;
            }
            
            .table-box {
                min-width: 100%;
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
                    <a href="diagrama_procesos.php" class="nav-link">Flujo Productos</a>
                    <a href="diagrama_bd.php" class="nav-link">Estructura BD</a>
                </nav>
            </div>
        </div>
    </header>
    
    <main class="database-structure">
        <div class="container">
            <div class="section-title">
                <h2>Estructura de la Base de Datos</h2>
                <p>Descubre el diseño y relaciones de nuestra base de datos</p>
            </div>
            
            <div class="database-card">
                <h2>Tablas Principales</h2>
                
                <div class="table-container">
                    <h3>Tabla: usuarios</h3>
                    <table>
                        <tr><th>Campo</th><th>Tipo</th><th>Descripción</th></tr>
                        <tr><td>id</td><td>INT</td><td>Llave primaria autoincremental</td></tr>
                        <tr><td>nombre</td><td>VARCHAR(70)</td><td>Nombre del usuario</td></tr>
                        <tr><td>apellido</td><td>VARCHAR(70)</td><td>Apellido del usuario</td></tr>
                        <tr><td>correo</td><td>VARCHAR(30)</td><td>Correo electrónico (único)</td></tr>
                        <tr><td>usuario</td><td>VARCHAR(20)</td><td>Nombre de usuario (único)</td></tr>
                        <tr><td>contrasena</td><td>VARCHAR(128)</td><td>Contraseña encriptada (SHA512)</td></tr>
                        <tr><td>fecha_reg</td><td>VARCHAR(20)</td><td>Fecha de registro</td></tr>
                        <tr><td>rol</td><td>ENUM</td><td>administrador, cliente o empleado</td></tr>
                        <tr><td>codigo_acceso</td><td>VARCHAR(32)</td><td>Código para registro de empleados (único)</td></tr>
                        <tr><td>cedula</td><td>VARCHAR(15)</td><td>Cédula de identidad (única)</td></tr>
                        <tr><td>tipo_cedula</td><td>ENUM</td><td>V (Venezolano) o E (Extranjero)</td></tr>
                    </table>
                </div>
                
                <div class="table-container">
                    <h3>Tabla: categorias</h3>
                    <table>
                        <tr><th>Campo</th><th>Tipo</th><th>Descripción</th></tr>
                        <tr><td>id</td><td>INT</td><td>Llave primaria autoincremental</td></tr>
                        <tr><td>nombre</td><td>VARCHAR(50)</td><td>Nombre de la categoría (único)</td></tr>
                        <tr><td>descripcion</td><td>TEXT</td><td>Descripción de la categoría</td></tr>
                    </table>
                </div>
                
                <div class="table-container">
                    <h3>Tabla: metodos_pago</h3>
                    <table>
                        <tr><th>Campo</th><th>Tipo</th><th>Descripción</th></tr>
                        <tr><td>id</td><td>INT</td><td>Llave primaria autoincremental</td></tr>
                        <tr><td>nombre</td><td>VARCHAR(50)</td><td>Nombre del método (único)</td></tr>
                        <tr><td>descripcion</td><td>TEXT</td><td>Descripción del método</td></tr>
                        <tr><td>tipo</td><td>ENUM</td><td>tarjeta, transferencia, efectivo, pago_movil</td></tr>
                        <tr><td>activo</td><td>BOOLEAN</td><td>Si el método está disponible</td></tr>
                    </table>
                </div>
                
                <div class="table-container">
                    <h3>Tabla: inventario</h3>
                    <table>
                        <tr><th>Campo</th><th>Tipo</th><th>Descripción</th></tr>
                        <tr><td>id</td><td>INT</td><td>Llave primaria autoincremental</td></tr>
                        <tr><td>codigo</td><td>VARCHAR(20)</td><td>Código único del producto</td></tr>
                        <tr><td>nombre</td><td>VARCHAR(100)</td><td>Nombre del producto</td></tr>
                        <tr><td>descripcion</td><td>TEXT</td><td>Descripción del producto</td></tr>
                        <tr><td>precio</td><td>DECIMAL(10,2)</td><td>Precio unitario</td></tr>
                        <tr><td>unidades_existentes</td><td>INT</td><td>Cantidad en inventario</td></tr>
                        <tr><td>unidades_minimas</td><td>INT</td><td>Stock mínimo antes de reordenar</td></tr>
                        <tr><td>fecha_ingreso</td><td>DATE</td><td>Fecha de ingreso al inventario</td></tr>
                        <tr><td>fecha_actualizacion</td><td>TIMESTAMP</td><td>Última actualización</td></tr>
                        <tr><td>estado</td><td>ENUM</td><td>activo, inactivo o agotado</td></tr>
                        <tr><td>pagina</td><td>VARCHAR(10)</td><td>Página asociada (ej. p1, p2)</td></tr>
                        <tr><td>categoria_id</td><td>INT</td><td>Llave foránea a categorias</td></tr>
                    </table>
                </div>
                
                <div class="table-container">
                    <h3>Tabla: pedidos</h3>
                    <table>
                        <tr><th>Campo</th><th>Tipo</th><th>Descripción</th></tr>
                        <tr><td>id</td><td>INT</td><td>Llave primaria autoincremental</td></tr>
                        <tr><td>usuario_id</td><td>INT</td><td>Llave foránea a usuarios</td></tr>
                        <tr><td>fecha_pedido</td><td>DATETIME</td><td>Fecha y hora del pedido</td></tr>
                        <tr><td>estado</td><td>ENUM</td><td>pendiente, procesando, enviado, completado, cancelado</td></tr>
                        <tr><td>subtotal</td><td>DECIMAL(10,2)</td><td>Subtotal sin impuestos</td></tr>
                        <tr><td>impuestos</td><td>DECIMAL(10,2)</td><td>Monto de impuestos</td></tr>
                        <tr><td>total</td><td>DECIMAL(10,2)</td><td>Total a pagar</td></tr>
                        <tr><td>metodo_pago_id</td><td>INT</td><td>Llave foránea a metodos_pago</td></tr>
                        <tr><td>datos_pago</td><td>TEXT</td><td>Detalles del pago (JSON)</td></tr>
                        <tr><td>direccion_envio</td><td>TEXT</td><td>Dirección de envío</td></tr>
                    </table>
                </div>
                
                <div class="table-container">
                    <h3>Tabla: detalles_pedido</h3>
                    <table>
                        <tr><th>Campo</th><th>Tipo</th><th>Descripción</th></tr>
                        <tr><td>id</td><td>INT</td><td>Llave primaria autoincremental</td></tr>
                        <tr><td>pedido_id</td><td>INT</td><td>Llave foránea a pedidos</td></tr>
                        <tr><td>producto_id</td><td>INT</td><td>Llave foránea a inventario</td></tr>
                        <tr><td>cantidad</td><td>INT</td><td>Cantidad del producto</td></tr>
                        <tr><td>precio_unitario</td><td>DECIMAL(10,2)</td><td>Precio al momento del pedido</td></tr>
                        <tr><td>subtotal</td><td>DECIMAL(10,2)</td><td>Subtotal (cantidad * precio_unitario)</td></tr>
                    </table>
                </div>
                
                <div class="table-container">
                    <h3>Tabla: imagenes_producto</h3>
                    <table>
                        <tr><th>Campo</th><th>Tipo</th><th>Descripción</th></tr>
                        <tr><td>id</td><td>INT</td><td>Llave primaria autoincremental</td></tr>
                        <tr><td>producto_id</td><td>INT</td><td>Llave foránea a inventario</td></tr>
                        <tr><td>url_imagen</td><td>VARCHAR(255)</td><td>Ruta de la imagen</td></tr>
                        <tr><td>es_principal</td><td>BOOLEAN</td><td>Si es la imagen principal</td></tr>
                    </table>
                </div>
            </div>
            
            <div class="database-card">
                <h2>Diagrama de Relaciones</h2>
                
                <div class="relationship-diagram">
                    <!-- Relación usuarios → pedidos -->
                    <div class="relationship-group">
                        <div class="table-box">
                            <h3>usuarios</h3>
                            <ul>
                                <li>id (PK)</li>
                                <li>nombre</li>
                                <li>apellido</li>
                                <li>correo</li>
                                <li>rol</li>
                            </ul>
                        </div>
                        
                        <div class="relationship-line">
                            <div class="line"></div>
                            <i class="fas fa-arrow-right relationship-arrow"></i>
                            <div class="line"></div>
                        </div>
                        
                        <div class="table-box">
                            <h3>pedidos</h3>
                            <ul>
                                <li>id (PK)</li>
                                <li>usuario_id (FK)</li>
                                <li>estado</li>
                                <li>total</li>
                                <li>metodo_pago_id (FK)</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="relationship-description">
                        <strong>Relación 1:N (uno a muchos)</strong> - Un usuario puede tener muchos pedidos, 
                        pero cada pedido pertenece a un solo usuario. La relación se establece mediante 
                        el campo usuario_id en la tabla pedidos que referencia al id en la tabla usuarios.
                    </div>
                    
                    <!-- Relación pedidos → detalles_pedido -->
                    <div class="relationship-group">
                        <div class="table-box">
                            <h3>pedidos</h3>
                            <ul>
                                <li>id (PK)</li>
                                <li>usuario_id (FK)</li>
                                <li>estado</li>
                                <li>total</li>
                            </ul>
                        </div>
                        
                        <div class="relationship-line">
                            <div class="line"></div>
                            <i class="fas fa-arrow-right relationship-arrow"></i>
                            <div class="line"></div>
                        </div>
                        
                        <div class="table-box">
                            <h3>detalles_pedido</h3>
                            <ul>
                                <li>id (PK)</li>
                                <li>pedido_id (FK)</li>
                                <li>producto_id (FK)</li>
                                <li>cantidad</li>
                                <li>precio_unitario</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="relationship-description">
                        <strong>Relación 1:N (uno a muchos)</strong> - Un pedido puede contener muchos 
                        productos (detalles_pedido), pero cada detalle pertenece a un solo pedido.
                        La relación se establece mediante el campo pedido_id en detalles_pedido que
                        referencia al id en la tabla pedidos.
                    </div>
                    
                    <!-- Relación inventario → detalles_pedido -->
                    <div class="relationship-group">
                        <div class="table-box">
                            <h3>inventario</h3>
                            <ul>
                                <li>id (PK)</li>
                                <li>nombre</li>
                                <li>precio</li>
                                <li>unidades_existentes</li>
                                <li>categoria_id (FK)</li>
                            </ul>
                        </div>
                        
                        <div class="relationship-line">
                            <div class="line"></div>
                            <i class="fas fa-arrow-right relationship-arrow"></i>
                            <div class="line"></div>
                        </div>
                        
                        <div class="table-box">
                            <h3>detalles_pedido</h3>
                            <ul>
                                <li>id (PK)</li>
                                <li>producto_id (FK)</li>
                                <li>pedido_id (FK)</li>
                                <li>precio_unitario</li>
                                <li>cantidad</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="relationship-description">
                        <strong>Relación 1:N (uno a muchos)</strong> - Un producto puede aparecer en 
                        muchos detalles de pedido, pero cada detalle hace referencia a un solo producto.
                        La relación se establece mediante el campo producto_id en detalles_pedido que
                        referencia al id en la tabla inventario.
                    </div>
                    
                    <!-- Relación categorias → inventario -->
                    <div class="relationship-group">
                        <div class="table-box">
                            <h3>categorias</h3>
                            <ul>
                                <li>id (PK)</li>
                                <li>nombre</li>
                                <li>descripcion</li>
                            </ul>
                        </div>
                        
                        <div class="relationship-line">
                            <div class="line"></div>
                            <i class="fas fa-arrow-right relationship-arrow"></i>
                            <div class="line"></div>
                        </div>
                        
                        <div class="table-box">
                            <h3>inventario</h3>
                            <ul>
                                <li>id (PK)</li>
                                <li>nombre</li>
                                <li>precio</li>
                                <li>categoria_id (FK)</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="relationship-description">
                        <strong>Relación 1:N (uno a muchos)</strong> - Una categoría puede contener 
                        muchos productos, pero cada producto pertenece a una sola categoría.
                        La relación se establece mediante el campo categoria_id en inventario que
                        referencia al id en la tabla categorias.
                    </div>
                    
                    <!-- Relación metodos_pago → pedidos -->
                    <div class="relationship-group">
                        <div class="table-box">
                            <h3>metodos_pago</h3>
                            <ul>
                                <li>id (PK)</li>
                                <li>nombre</li>
                                <li>tipo</li>
                                <li>activo</li>
                            </ul>
                        </div>
                        
                        <div class="relationship-line">
                            <div class="line"></div>
                            <i class="fas fa-arrow-right relationship-arrow"></i>
                            <div class="line"></div>
                        </div>
                        
                        <div class="table-box">
                            <h3>pedidos</h3>
                            <ul>
                                <li>id (PK)</li>
                                <li>metodo_pago_id (FK)</li>
                                <li>datos_pago</li>
                                <li>total</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="relationship-description">
                        <strong>Relación 1:N (uno a muchos)</strong> - Un método de pago puede ser usado 
                        en muchos pedidos, pero cada pedido tiene un solo método de pago.
                        La relación se establece mediante el campo metodo_pago_id en pedidos que
                        referencia al id en la tabla metodos_pago.
                    </div>
                    
                    <!-- Relación inventario → imagenes_producto -->
                    <div class="relationship-group">
                        <div class="table-box">
                            <h3>inventario</h3>
                            <ul>
                                <li>id (PK)</li>
                                <li>nombre</li>
                                <li>codigo</li>
                                <li>descripcion</li>
                            </ul>
                        </div>
                        
                        <div class="relationship-line">
                            <div class="line"></div>
                            <i class="fas fa-arrow-right relationship-arrow"></i>
                            <div class="line"></div>
                        </div>
                        
                        <div class="table-box">
                            <h3>imagenes_producto</h3>
                            <ul>
                                <li>id (PK)</li>
                                <li>producto_id (FK)</li>
                                <li>url_imagen</li>
                                <li>es_principal</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="relationship-description">
                        <strong>Relación 1:N (uno a muchos)</strong> - Un producto puede tener 
                        muchas imágenes asociadas, pero cada imagen pertenece a un solo producto.
                        La relación se establece mediante el campo producto_id en imagenes_producto que
                        referencia al id en la tabla inventario.
                    </div>
                </div>
            </div>
            
            <div class="database-card">
                <h2>Resumen de Relaciones</h2>
                <ul class="footer-links">
                    <li><i class="fas fa-chevron-right"></i> <strong>usuarios → pedidos</strong>: 1 usuario puede tener N pedidos</li>
                    <li><i class="fas fa-chevron-right"></i> <strong>pedidos → detalles_pedido</strong>: 1 pedido puede tener N detalles</li>
                    <li><i class="fas fa-chevron-right"></i> <strong>inventario → detalles_pedido</strong>: 1 producto puede estar en N detalles</li>
                    <li><i class="fas fa-chevron-right"></i> <strong>categorias → inventario</strong>: 1 categoría puede tener N productos</li>
                    <li><i class="fas fa-chevron-right"></i> <strong>metodos_pago → pedidos</strong>: 1 método de pago puede usarse en N pedidos</li>
                    <li><i class="fas fa-chevron-right"></i> <strong>inventario → imagenes_producto</strong>: 1 producto puede tener N imágenes</li>
                </ul>
                
                <h3 style="margin-top: 30px;">Índices Clave</h3>
                <table>
                    <tr><th>Tabla</th><th>Índices</th></tr>
                    <tr><td>usuarios</td><td>id (PK), cedula (UNIQUE), correo (UNIQUE), usuario (UNIQUE), codigo_acceso (UNIQUE)</td></tr>
                    <tr><td>categorias</td><td>id (PK), nombre (UNIQUE)</td></tr>
                    <tr><td>metodos_pago</td><td>id (PK), nombre (UNIQUE)</td></tr>
                    <tr><td>inventario</td><td>id (PK), codigo (UNIQUE), categoria_id (INDEX)</td></tr>
                    <tr><td>pedidos</td><td>id (PK), usuario_id (INDEX), metodo_pago_id (INDEX), fecha_pedido (INDEX)</td></tr>
                    <tr><td>detalles_pedido</td><td>id (PK), pedido_id (INDEX), producto_id (INDEX)</td></tr>
                    <tr><td>imagenes_producto</td><td>id (PK), producto_id (INDEX)</td></tr>
                </table>
            </div>
            
            <!-- Nueva sección para mostrar datos actuales -->
            <div class="current-data-section">
                <div class="section-title">
                    <h2>Contenido Actual de las Tablas</h2>
                    <p>Datos reales almacenados en la base de datos en este momento</p>
                </div>
                
                <div class="database-card">
                    <h2>Datos Actuales</h2>
                    
                    <div class="tabla-container">
                        <h3>Tabla: usuarios (<?php echo count($usuarios); ?> registros)</h3>
                        <div class="tabla-info">
                            Muestra todos los usuarios registrados en el sistema con sus datos básicos.
                        </div>
                        <?php 
                        echo mostrarDatosEnTabla($usuarios, ['id', 'nombre', 'apellido', 'rol', 'correo', 'fecha_reg']);
                        ?>
                    </div>
                    
                    <div class="tabla-container">
                        <h3>Tabla: categorias (<?php echo count($categorias); ?> registros)</h3>
                        <div class="tabla-info">
                            Categorías disponibles para clasificar los productos.
                        </div>
                        <?php echo mostrarDatosEnTabla($categorias); ?>
                    </div>
                    
                    <div class="tabla-container">
                        <h3>Tabla: metodos_pago (<?php echo count($metodos_pago); ?> registros)</h3>
                        <div class="tabla-info">
                            Métodos de pago aceptados por el sistema.
                        </div>
                        <?php echo mostrarDatosEnTabla($metodos_pago); ?>
                    </div>
                    
                    <div class="tabla-container">
                        <h3>Tabla: inventario (<?php echo count($inventario); ?> registros)</h3>
                        <div class="tabla-info">
                            Productos disponibles en el inventario con sus detalles.
                        </div>
                        <?php 
                        echo mostrarDatosEnTabla($inventario, ['id', 'nombre', 'codigo', 'precio', 'unidades_existentes', 'estado']);
                        ?>
                    </div>
                    
                    <div class="tabla-container">
                        <h3>Tabla: pedidos (<?php echo count($pedidos); ?> registros)</h3>
                        <div class="tabla-info">
                            Pedidos realizados por los clientes.
                        </div>
                        <?php 
                        echo mostrarDatosEnTabla($pedidos, ['id', 'usuario_id', 'fecha_pedido', 'estado', 'total']);
                        ?>
                    </div>
                    
                    <div class="tabla-container">
                        <h3>Tabla: detalles_pedido (<?php echo count($detalles_pedido); ?> registros)</h3>
                        <div class="tabla-info">
                            Productos individuales que componen cada pedido.
                        </div>
                        <?php 
                        echo mostrarDatosEnTabla($detalles_pedido, ['id', 'pedido_id', 'producto_id', 'cantidad', 'precio_unitario']);
                        ?>
                    </div>
                    
                    <div class="tabla-container">
                        <h3>Tabla: imagenes_producto (<?php echo count($imagenes_producto); ?> registros)</h3>
                        <div class="tabla-info">
                            Imágenes asociadas a los productos del inventario.
                        </div>
                        <?php 
                        echo mostrarDatosEnTabla($imagenes_producto, ['id', 'producto_id', 'url_imagen', 'es_principal']);
                        ?>
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
                        <a href="https://github.com/rgamercm/" class="social-link"><i class="fab fa-github"></i></a>
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
                        <li><a href="tel:+584244258944"><i class="fas fa-phone"></i> +58000-0000000</a></li>
                        <li><a href="mailto:panacafeteria@gmail.com"><i class="fas fa-envelope"></i> panacafeteria@gmail.com</a></li>
                        <li><a href="#"><i class="fas fa-clock"></i> Lunes a Domingo: 7am - 8pm</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; Pana' Cafeteria. Todos los Derechos Reservados.</p>
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
    </script>
</body>
</html>