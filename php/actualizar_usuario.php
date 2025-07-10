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
$tipo_cedula = mysqli_real_escape_string($conexion, $_POST['tipo_cedula']);
$cedula = mysqli_real_escape_string($conexion, trim($_POST['cedula']));
$usuario = mysqli_real_escape_string($conexion, trim($_POST['usuario']));
$correo = mysqli_real_escape_string($conexion, trim($_POST['correo']));
$rol = mysqli_real_escape_string($conexion, $_POST['rol']);

// Validaciones
if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/", $nombre)) {
    header("Location: ../empleados/usuarios_registrados.php?error=Nombre inválido");
    exit();
}

if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/", $apellido)) {
    header("Location: ../empleados/usuarios_registrados.php?error=Apellido inválido");
    exit();
}

if (!in_array($tipo_cedula, ['V', 'E'])) {
    header("Location: ../empleados/usuarios_registrados.php?error=Tipo de cédula inválido");
    exit();
}

if (!preg_match("/^[0-9]{6,15}$/", $cedula)) {
    header("Location: ../empleados/usuarios_registrados.php?error=Cédula inválida");
    exit();
}

if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    header("Location: ../empleados/usuarios_registrados.php?error=Correo inválido");
    exit();
}

// Verificar duplicados (excluyendo el usuario actual)
$verificar_correo = mysqli_query($conexion, "SELECT id FROM usuarios WHERE correo='$correo' AND id != '$id'");
if(mysqli_num_rows($verificar_correo) > 0) {
    header("Location: ../empleados/usuarios_registrados.php?error=Correo ya registrado");
    exit();
}

$verificar_usuario = mysqli_query($conexion, "SELECT id FROM usuarios WHERE usuario='$usuario' AND id != '$id'");
if(mysqli_num_rows($verificar_usuario) > 0) {
    header("Location: ../empleados/usuarios_registrados.php?error=Usuario ya registrado");
    exit();
}

$verificar_cedula = mysqli_query($conexion, "SELECT id FROM usuarios WHERE cedula='$cedula' AND id != '$id'");
if(mysqli_num_rows($verificar_cedula) > 0) {
    header("Location: ../empleados/usuarios_registrados.php?error=Cédula ya registrada");
    exit();
}

// Construir la consulta de actualización
$query = "UPDATE usuarios SET 
          nombre = '$nombre',
          apellido = '$apellido',
          tipo_cedula = '$tipo_cedula',
          cedula = '$cedula',
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