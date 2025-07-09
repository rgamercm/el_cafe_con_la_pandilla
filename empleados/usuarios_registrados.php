<?php
include '../php/verificar_sesion.php';
verificarAutenticacion('empleado');
include '../php/conexion_be.php';

// Obtener todos los usuarios
$query = "SELECT * FROM usuarios ORDER BY fecha_reg DESC";
$resultado = mysqli_query($conexion, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios Registrados - El Café Con La Pan-dilla</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .usuarios-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .usuarios-table th, .usuarios-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .usuarios-table th {
            background-color: var(--primary-color);
            color: white;
        }
        .usuarios-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .action-buttons a {
            margin: 0 5px;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 4px;
        }
        .editar {
            background-color: #4CAF50;
            color: white;
        }
        .eliminar {
            background-color: #f44336;
            color: white;
        }
        .panel-link {
            display: block;
            margin: 20px 0;
            text-align: center;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-container">
            <div class="logo">
                <img src="img/cafe/cafe.png" alt="Logotipo" class="logo-image">
            </div>
            
            <h1 class="header-title">El Café Con La Pan-dilla</h1>
            
            <div class="header-controls">
                <button class="theme-toggle" id="themeToggle">🌙</button>
                
                <a href="carrito.php" class="cart-icon">
                    <img src="img/cart-icon.png" alt="Carrito de compras">
                    <span id="cartCounter">0</span>
                </a>
            </div>
        </div>

        <nav class="nav">
            <a href="index.php" class="nav-link active"><span>Inicio</span></a>
            <a href="catalogo.php" class="nav-link">Productos</a>
            <a href="nosotros.php" class="nav-link">Nosotros</a>
            <a href="registrar.php" class="nav-link">Registrarse</a>
            <a href="diagrama_procesos.php" class="nav-link">Flujo Productos</a>
            <a href="diagrama_bd.php" class="nav-link">Estructura BD</a>
        </nav>
    </header>

    <div class="container">
        <h2>Usuarios Registrados</h2>
        
        <table class="usuarios-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Usuario</th>
                    <th>Correo</th>
                    <th>Fecha Registro</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while($usuario = mysqli_fetch_assoc($resultado)): ?>
                <tr>
                    <td><?php echo $usuario['id']; ?></td>
                    <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['apellido']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['usuario']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['correo']); ?></td>
                    <td><?php echo $usuario['fecha_reg']; ?></td>
                    <td><?php echo ucfirst($usuario['rol']); ?></td>
                    <td class="action-buttons">
                        <a href="editar_usuario.php?id=<?php echo $usuario['id']; ?>" class="editar">Editar</a>
                        <a href="../php/eliminar_usuario.php?id=<?php echo $usuario['id']; ?>" class="eliminar" onclick="return confirm('¿Estás seguro?')">Eliminar</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        
        <a href="registro_empleado.php" class="panel-link">Registrar Nuevo Empleado</a>
        <a href="index2.php" class="panel-link">Volver al Panel de Empleado</a>
    </div>

    <footer class="footer">
        <div class="footer-content">
            <p>2024 El Café Con La Pan-dilla C.A<br>Todos los Derechos Reservados.</p>
            <p>Contactos<br>Tlf: +58-4244258944<br>Correo: cg9477083@gmail.com</p>
            <div class="social-media">
                <a href="https://www.facebook.com/profile.php?id=100089772800592" class="social-link">Facebook</a>
                <a href="https://www.instagram.com/carlosgz9477/" class="social-link">Instagram</a>
                <a href="https://github.com/NoobCoderMaster69" class="social-link">Github</a>
            </div>
        </div>
    </footer>
</body>
</html>