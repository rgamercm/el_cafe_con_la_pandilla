<?php
$host = "localhost";
$usuario = "root";
$contrasena = "cristovive6234";
$base_datos = "panaderia";
$puerto = 3306; // Puerto por defecto

// Conexión con verificación de errores mejorada
$conexion = mysqli_connect($host, $usuario, $contrasena, $base_datos, $puerto);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error() . 
        " (Código: " . mysqli_connect_errno() . ")");
}

mysqli_set_charset($conexion, "utf8mb4");

// Verificación adicional (opcional)
if (!mysqli_ping($conexion)) {
    die("Error: La conexión se perdió");
}
?>