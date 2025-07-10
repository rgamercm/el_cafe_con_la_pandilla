<?php
session_start();
include 'conexion_be.php';
include 'verificar_sesion.php';
verificarAutenticacion('empleado');

if(!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: ../empleados/usuarios_registrados.php?error=ID no proporcionado");
    exit();
}

$id = mysqli_real_escape_string($conexion, $_GET['id']);

// No permitir eliminar el propio usuario
if($id == $_SESSION['usuario']['id']) {
    header("Location: ../empleados/usuarios_registrados.php?error=No puedes eliminarte a ti mismo");
    exit();
}

$query = "DELETE FROM usuarios WHERE id = '$id'";

if(mysqli_query($conexion, $query)) {
    header("Location: ../empleados/usuarios_registrados.php?success=Usuario eliminado");
} else {
    header("Location: ../empleados/usuarios_registrados.php?error=Error al eliminar: " . mysqli_error($conexion));
}

mysqli_close($conexion);
?>