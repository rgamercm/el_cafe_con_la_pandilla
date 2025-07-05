<?php
session_start();
include 'conexion_be.php';

if(isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit;
}

if(empty($_POST['email']) || empty($_POST['contrasena'])) {
    echo '
        <script> 
            alert("Por favor complete todos los campos");
            window.location = "../registrar.php";
        </script>
    ';
    exit;
}

$email = mysqli_real_escape_string($conexion, trim($_POST['email']));
$contrasena = trim($_POST['contrasena']);
$contrasena_hash = hash('sha512', $contrasena);

$query = "SELECT * FROM usuarios WHERE correo = '$email' AND contrasena = '$contrasena_hash'";
$resultado = mysqli_query($conexion, $query);

if(mysqli_num_rows($resultado) > 0) {
    $usuario = mysqli_fetch_assoc($resultado);
    
    $_SESSION['usuario'] = array(
        'id' => $usuario['id'],
        'nombre' => $usuario['nombre'],
        'apellido' => $usuario['apellido'],
        'usuario' => $usuario['usuario'],
        'email' => $usuario['correo']
    );
    
    // Configurar cookie de sesión persistente si marcó "Recordar"
    if(isset($_POST['recordar'])) {
        $cookie_valor = base64_encode($usuario['id'] . ':' . $contrasena_hash);
        setcookie('panaderia_sesion', $cookie_valor, time() + (86400 * 30), "/");
    }
    
    header("Location: ../index.php");
} else {
    echo '
        <script> 
            alert("Usuario o contraseña incorrectos");
            window.location = "../registrar.php";
        </script>
    ';
}

mysqli_close($conexion);
?>