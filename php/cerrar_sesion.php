<?php
session_start();

// Eliminar todas las variables de sesión
$_SESSION = array();

// Destruir la sesión
session_destroy();

// Eliminar la cookie de sesión persistente
if(isset($_COOKIE['panaderia_sesion'])) {
    setcookie('panaderia_sesion', '', time() - 3600, '/');
}

// Redirigir a la página de inicio
header("Location: ../index.php");
exit;
?>