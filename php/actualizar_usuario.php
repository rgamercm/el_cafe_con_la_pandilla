<?php
session_start();
include 'conexion_be.php';
include 'verificar_sesion.php';
verificarAutenticacion('empleado');

if(!isset($_POST['id']) || empty($_POST['id'])) {
    header("Location: ../empleados/usuarios_registrados.php?error=ID no proporcionado");
    exit();
}

$id = mysqli_real_escape_string($conexion, $_POST['id']);
$nombre = mysqli_real_escape_string($conexion, trim($_POST['nombre']));
$apellido = mysqli_real_escape_string($conexion, trim($_POST['apellido']));
$usuario = mysqli_real_escape_string($conexion, trim($_POST['usuario']));
$correo = mysqli_real_escape_string($conexion, trim($_POST['correo']));
$rol = mysqli_real_escape_string($conexion, $_POST['rol']);

// Verificar si el correo ya existe (excluyendo el usuario actual)
$verificar_correo = mysqli_query($conexion, "SELECT id FROM usuarios WHERE correo='$correo' AND id != '$id'");
if(mysqli_num_rows($verificar_correo) > 0) {
    header("Location: ../empleados/usuarios_registrados.php?error=Correo ya registrado");
    exit();
}

// Verificar si el usuario ya existe (excluyendo el usuario actual)
$verificar_usuario = mysqli_query($conexion, "SELECT id FROM usuarios WHERE usuario='$usuario' AND id != '$id'");
if(mysqli_num_rows($verificar_usuario) > 0) {
    header("Location: ../empleados/usuarios_registrados.php?error=Usuario ya registrado");
    exit();
}

// Construir la consulta base
$query = "UPDATE usuarios SET 
          nombre = '$nombre',
          apellido = '$apellido',
          usuario = '$usuario',
          correo = '$correo',
          rol = '$rol'";

// Agregar cambio de contraseña si se proporcionó
if(!empty($_POST['contrasena'])) {
    $contrasena = trim($_POST['contrasena']);
    if(strlen($contrasena) < 8) {
        header("Location: ../empleados/usuarios_registrados.php?error=La contraseña debe tener al menos 8 caracteres");
        exit();
    }
    $contrasena_hash = hash('sha512', $contrasena);
    $query .= ", contrasena = '$contrasena_hash'";
}

$query .= " WHERE id = '$id'";

if(mysqli_query($conexion, $query)) {
    header("Location: ../empleados/usuarios_registrados.php?success=Usuario actualizado");
} else {
    header("Location: ../empleados/usuarios_registrados.php?error=Error al actualizar: " . mysqli_error($conexion));
}

mysqli_close($conexion);
?>