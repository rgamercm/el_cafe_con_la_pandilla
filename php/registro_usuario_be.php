<?php
session_start();
include 'conexion_be.php';

// Función para mostrar errores
function mostrarError($mensaje) {
    echo '
        <script> 
            alert("'.addslashes($mensaje).'");
            window.location = "../registrar.php";
        </script>
    ';
    exit();
}

// Función para verificar si existe una columna
function columnaExiste($conexion, $tabla, $columna) {
    $result = mysqli_query($conexion, "SHOW COLUMNS FROM $tabla LIKE '$columna'");
    return (mysqli_num_rows($result) > 0);
}

// Verificar y crear las columnas necesarias si no existen
if (!columnaExiste($conexion, 'usuarios', 'tipo_cedula')) {
    $sql = "ALTER TABLE usuarios ADD COLUMN tipo_cedula ENUM('V', 'E') NOT NULL DEFAULT 'V'";
    if (!mysqli_query($conexion, $sql)) {
        mostrarError("Error en configuración de base de datos (tipo_cedula)");
    }
}

if (!columnaExiste($conexion, 'usuarios', 'cedula')) {
    $sql = "ALTER TABLE usuarios ADD COLUMN cedula VARCHAR(15) NOT NULL";
    if (!mysqli_query($conexion, $sql)) {
        mostrarError("Error en configuración de base de datos (cedula)");
    }
    
    // Intentar agregar índice único (no crítico si falla)
    mysqli_query($conexion, "ALTER TABLE usuarios ADD UNIQUE INDEX idx_cedula (cedula)");
}

// Validar campos requeridos
$required_fields = ['nombre', 'apellido', 'tipo_cedula', 'cedula', 'usuario', 'correo', 'contrasena', 'rol'];
foreach ($required_fields as $field) {
    if (empty($_POST[$field])) {
        mostrarError("Por favor complete todos los campos requeridos");
    }
}

// Limpiar y validar datos
$nombre = mysqli_real_escape_string($conexion, trim($_POST['nombre']));
$apellido = mysqli_real_escape_string($conexion, trim($_POST['apellido']));
$tipo_cedula = in_array($_POST['tipo_cedula'], ['V', 'E']) ? $_POST['tipo_cedula'] : 'V';
$cedula = preg_replace('/[^0-9]/', '', $_POST['cedula']);
$usuario = mysqli_real_escape_string($conexion, trim($_POST['usuario']));
$correo = mysqli_real_escape_string($conexion, trim($_POST['correo']));
$contrasena = trim($_POST['contrasena']);
$rol = mysqli_real_escape_string($conexion, trim($_POST['rol']));
$fecha_reg = date("d/m/y");

// Validar nombre y apellido (solo letras y espacios)
if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/", $nombre)) {
    mostrarError("El nombre solo puede contener letras y espacios");
}

if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/", $apellido)) {
    mostrarError("El apellido solo puede contener letras y espacios");
}

// Validar cédula (6-15 dígitos)
if (strlen($cedula) < 6 || strlen($cedula) > 15) {
    mostrarError("La cédula debe tener entre 6 y 15 dígitos");
}

// Validar email
if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    mostrarError("Por favor ingrese un correo electrónico válido");
}

// Validar contraseña (mínimo 8 caracteres)
if (strlen($contrasena) < 8) {
    mostrarError("La contraseña debe tener al menos 8 caracteres");
}

// Verificar duplicados
function verificarDuplicado($conexion, $campo, $valor, $mensaje) {
    $query = mysqli_query($conexion, "SELECT id FROM usuarios WHERE $campo = '".mysqli_real_escape_string($conexion, $valor)."'");
    if (mysqli_num_rows($query) > 0) {
        mostrarError($mensaje);
    }
}

verificarDuplicado($conexion, 'correo', $correo, "Este correo ya está registrado");
verificarDuplicado($conexion, 'usuario', $usuario, "Este usuario ya está registrado");
verificarDuplicado($conexion, 'cedula', $cedula, "Esta cédula ya está registrada");

// Hash de la contraseña
$contrasena_hash = hash('sha512', $contrasena);

// Insertar nuevo usuario
$query = "INSERT INTO usuarios(nombre, apellido, tipo_cedula, cedula, usuario, correo, contrasena, fecha_reg, rol) 
          VALUES ('$nombre', '$apellido', '$tipo_cedula', '$cedula', '$usuario', '$correo', '$contrasena_hash', '$fecha_reg', '$rol')";

if (mysqli_query($conexion, $query)) {
    // Iniciar sesión automáticamente
    $_SESSION['usuario'] = [
        'id' => mysqli_insert_id($conexion),
        'nombre' => $nombre,
        'apellido' => $apellido,
        'tipo_cedula' => $tipo_cedula,
        'cedula' => $cedula,
        'usuario' => $usuario,
        'email' => $correo,
        'rol' => $rol
    ];
    
    // Redirigir según rol
    $redirect = ($rol === 'empleado') ? 
        "../empleados/bienvenida_despues_de_iniciarsesion.php" : 
        "../bienvenida_despues_de_iniciarsesion.php";
    
    header("Location: $redirect");
    exit();
} else {
    mostrarError("Error al registrar usuario: ".mysqli_error($conexion));
}

mysqli_close($conexion);
?>