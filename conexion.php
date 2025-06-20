<?php 
$conexion = mysqli_connect("localhost", "root", "NuevaContraseña123!", "login_register_db");

// Verificar conexión y mostrar error si falla
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>