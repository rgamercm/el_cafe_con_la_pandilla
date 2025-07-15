<?php
session_start();
include 'conexion_be.php';

// Verificar si ya hay una sesión activa
if(isset($_SESSION['usuario'])) {
    // Redirigir según el rol del usuario
    switch($_SESSION['usuario']['rol']) {
        case 'empleado':
            header("Location: ../empleados/bienvenida_despues_de_iniciarsesion.php");
            break;
        case 'administrador':
            header("Location: ../administrador/bienvenida_despues_de_iniciarsesion.php");
            break;
        default: // cliente
            header("Location: ../bienvenida_despues_de_iniciarsesion.php");
            break;
    }
    exit();
}

// Validar que los campos no estén vacíos
if(empty($_POST['email']) || empty($_POST['contrasena'])) {
    echo '
        <script> 
            alert("Por favor complete todos los campos");
            window.location = "../registrar.php";
        </script>
    ';
    exit();
}

// Limpiar y escapar los datos de entrada
$email = mysqli_real_escape_string($conexion, trim($_POST['email']));
$contrasena = trim($_POST['contrasena']);
$contrasena_hash = hash('sha512', $contrasena);

// Consulta para verificar las credenciales usando consulta preparada
$query = "SELECT * FROM usuarios WHERE correo = ? AND contrasena = ?";
$stmt = mysqli_prepare($conexion, $query);

if ($stmt === false) {
    die('Error en la preparación de la consulta: ' . mysqli_error($conexion));
}

mysqli_stmt_bind_param($stmt, "ss", $email, $contrasena_hash);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);

// Verificar si se encontró el usuario
if($resultado && mysqli_num_rows($resultado) > 0) {
    $usuario = mysqli_fetch_assoc($resultado);
    
    $_SESSION['usuario'] = array(
        'id' => $usuario['id'],
        'nombre' => $usuario['nombre'],
        'apellido' => $usuario['apellido'],
        'usuario' => $usuario['usuario'],
        'email' => $usuario['correo'],
        'rol' => $usuario['rol']
    );
    
    // Configurar cookie de sesión persistente si marcó "Recordar"
    if(isset($_POST['recordar'])) {
        $cookie_valor = base64_encode($usuario['id'] . ':' . $contrasena_hash);
        setcookie('panaderia_sesion', $cookie_valor, time() + (86400 * 30), "/");
    }
    
    // Redirección basada en el rol del usuario
    switch($usuario['rol']) {
        case 'empleado':
            header("Location: ../empleados/bienvenida_despues_de_iniciarsesion.php");
            break;
        case 'administrador':
            header("Location: ../administrador/bienvenida_despues_de_iniciarsesion.php");
            break;
        default: // cliente
            header("Location: ../bienvenida_despues_de_iniciarsesion.php");
            break;
    }
    exit();
} else {
    // Credenciales incorrectas
    echo '
        <script> 
            alert("Usuario o contraseña incorrectos");
            window.location = "../registrar.php";
        </script>
    ';
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>