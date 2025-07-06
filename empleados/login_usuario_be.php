<?php
session_start();
include 'conexion_be.php';

// Verificar si ya hay una sesión activa
if(isset($_SESSION['usuario'])) {
    // Redirigir según el rol del usuario
    if($_SESSION['usuario']['rol'] === 'empleado') {
        header("Location: ../empleados/index2.php");
    } else {
        header("Location: ../index.php");
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

// Consulta para verificar las credenciales
$query = "SELECT * FROM usuarios WHERE correo = '$email' AND contrasena = '$contrasena_hash'";
$resultado = mysqli_query($conexion, $query);

// Verificar si se encontró el usuario
if(mysqli_num_rows($resultado) > 0) {
    $usuario = mysqli_fetch_assoc($resultado);
    
    // Crear la sesión del usuario con todos los datos necesarios
    $_SESSION['usuario'] = array(
        'id' => $usuario['id'],
        'nombre' => $usuario['nombre'],
        'apellido' => $usuario['apellido'],
        'usuario' => $usuario['usuario'],
        'email' => $usuario['correo'],
        'rol' => $usuario['rol'] // Asegurar que el rol se guarda en la sesión
    );
    
    // Configurar cookie de sesión persistente si marcó "Recordar"
    if(isset($_POST['recordar'])) {
        $cookie_valor = base64_encode($usuario['id'] . ':' . $contrasena_hash);
        setcookie('panaderia_sesion', $cookie_valor, time() + (86400 * 30), "/");
    }
    
    // Redirección basada en el rol del usuario
    if($usuario['rol'] === 'empleado') {
        header("Location: ../empleados/index2.php");  // Redirige a la interfaz de empleados
    } else {
        header("Location: ../index.php");           // Redirige a la interfaz normal
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