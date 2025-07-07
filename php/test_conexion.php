<?php
include 'php/conexion_be.php';

if ($conexion) {
    echo '<h1 style="color: green;">¡Conexión exitosa a la base de datos!</h1>';
    echo '<p>Base de datos: panaderia</p>';
} else {
    echo '<h1 style="color: red;">Error de conexión</h1>';
    echo '<p>' . mysqli_connect_error() . '</p>';
}

// Opcional: Mostrar información del servidor MySQL
echo '<h2>Información del servidor MySQL:</h2>';
echo '<pre>';
print_r(mysqli_get_host_info($conexion));
echo '</pre>';
?>