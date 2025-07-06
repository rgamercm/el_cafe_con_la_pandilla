<?php
session_start();
include 'conexion_be.php';

// Validar campos requeridos
$required_fields = ['nombre', 'apellido', 'usuario', 'correo', 'contrasena', 'rol'];
foreach ($required_fields as $field) {
    if (empty($_POST[$field])) {
        echo '
            <script> 
                alert("Por favor complete todos los campos requeridos");
                window.location = "../registrar.php";
            </script>
        ';
        exit();
    }
}

// Limpiar datos
$nombre = mysqli_real_escape_string($conexion, trim($_POST['nombre']));
$apellido = mysqli_real_escape_string($conexion, trim($_POST['apellido']));
$usuario = mysqli_real_escape_string($conexion, trim($_POST['usuario']));
$correo = mysqli_real_escape_string($conexion, trim($_POST['correo']));
$contrasena = trim($_POST['contrasena']);
$rol = mysqli_real_escape_string($conexion, trim($_POST['rol']));
$fecha_reg = date("d/m/y");

// Validaciones adicionales
if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    echo '
        <script> 
            alert("Por favor ingrese un correo electrónico válido");
            window.location = "../registrar.php";
        </script>
    ';
    exit();
}

if (strlen($contrasena) < 8) {
    echo '
        <script> 
            alert("La contraseña debe tener al menos 8 caracteres");
            window.location = "../registrar.php";
        </script>
    ';
    exit();
}

$contrasena_hash = hash('sha512', $contrasena);

// Verificar si el correo ya existe
$verificar_correo = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo='$correo'");
if (mysqli_num_rows($verificar_correo) > 0) {
    echo '
        <script> 
            alert("Este correo ya está registrado, intenta con otro diferente");
            window.location = "../registrar.php";
        </script>
    ';
    exit();
}

// Verificar si el usuario ya existe
$verificar_usuario = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario='$usuario'");
if (mysqli_num_rows($verificar_usuario) > 0) {
    echo '
        <script> 
            alert("Este usuario ya está registrado, intenta con otro diferente");
            window.location = "../registrar.php";
        </script>
    ';
    exit();
}

// Insertar nuevo usuario
$query = "INSERT INTO usuarios(nombre, apellido, usuario, correo, contrasena, fecha_reg, rol) 
          VALUES ('$nombre', '$apellido', '$usuario', '$correo', '$contrasena_hash', '$fecha_reg', '$rol')";

if (mysqli_query($conexion, $query)) {
    // Iniciar sesión automáticamente después del registro
    $_SESSION['usuario'] = array(
        'nombre' => $nombre,
        'apellido' => $apellido,
        'usuario' => $usuario,
        'email' => $correo,
        'rol' => $rol
    );
    
    // Redirigir según el rol - AQUÍ ESTABA EL ERROR PRINCIPAL
    // Usamos rutas absolutas desde la raíz del sitio
    if ($rol === 'empleado') {
        header("Location: /paginaweb/empleados/index2.php");
    } else {
        header("Location: /paginaweb/empleados/index2.php");
    }
    exit();
} else {
    echo '
        <script> 
            alert("Error al registrar usuario: ' . mysqli_error($conexion) . '");
            window.location = "../registrar.php";
        </script>
    ';
}

mysqli_close($conexion);
?>