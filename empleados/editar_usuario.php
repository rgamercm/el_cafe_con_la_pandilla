<?php
include '../php/verificar_sesion.php';
verificarAutenticacion('empleado');
include '../php/conexion_be.php';

if(!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: usuarios_registrados.php?error=ID no proporcionado");
    exit();
}

$id = mysqli_real_escape_string($conexion, $_GET['id']);
$query = "SELECT * FROM usuarios WHERE id = '$id'";
$resultado = mysqli_query($conexion, $query);
$usuario = mysqli_fetch_assoc($resultado);

if(!$usuario) {
    header("Location: usuarios_registrados.php?error=Usuario no encontrado");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario - El Café Con La Pan-dilla</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .edit-form {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: var(--card-bg);
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .edit-form input, .edit-form select {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        .edit-form button {
            background-color: var(--primary-color);
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }
        .password-field {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #eee;
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
        <h2>Editar Usuario: <?php echo htmlspecialchars($usuario['nombre']); ?></h2>
        
        <form class="edit-form" action="../php/actualizar_usuario.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
            
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
            
            <label for="apellido">Apellido:</label>
            <input type="text" name="apellido" value="<?php echo htmlspecialchars($usuario['apellido']); ?>" required>
            
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" value="<?php echo htmlspecialchars($usuario['usuario']); ?>" required>
            
            <label for="correo">Correo:</label>
            <input type="email" name="correo" value="<?php echo htmlspecialchars($usuario['correo']); ?>" required>
            
            <label for="rol">Rol:</label>
            <select name="rol" required>
                <option value="cliente" <?php echo $usuario['rol'] == 'cliente' ? 'selected' : ''; ?>>Cliente</option>
                <option value="empleado" <?php echo $usuario['rol'] == 'empleado' ? 'selected' : ''; ?>>Empleado</option>
            </select>
            
            <div class="password-field">
                <label for="contrasena">Nueva Contraseña (dejar en blanco para no cambiar):</label>
                <input type="password" name="contrasena" placeholder="Nueva contraseña" minlength="8">
            </div>
            
            <button type="submit">Guardar Cambios</button>
            <a href="usuarios_registrados.php" class="btn-cancelar">Cancelar</a>
        </form>
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