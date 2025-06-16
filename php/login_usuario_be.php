<?php
session_start();
include 'conexion_be.php';

// Validar que los campos no estén vacíos
if (empty($_POST['email']) || empty($_POST['contrasena'])) {
    echo '
    <script>
        alert("Por favor complete todos los campos");
        window.location = "../registrar.php";
    </script>
    ';
    exit;
}

$email = mysqli_real_escape_string($conexion, $_POST['email']);
$contrasena = hash('sha512', $_POST['contrasena']);

$validar_login = mysqli_query($conexion, "SELECT * FROM usuarios WHERE email='$email' AND contrasena='$contrasena'");

if (mysqli_num_rows($validar_login) > 0) {
    $usuario = mysqli_fetch_assoc($validar_login);
    $_SESSION['usuario'] = $usuario['usuario'];  // Guardar nombre de usuario en sesión
    $_SESSION['email'] = $usuario['email'];      // Guardar email en sesión
    $_SESSION['id'] = $usuario['id'];           // Guardar ID en sesión
    
    header("location: ../bienvenida.php");
    exit;
} else {
    echo '
    <script>
        alert("Usuario no existe o contraseña incorrecta");
        window.location = "../registrar.php";
    </script>
    ';
    exit;
}
?>