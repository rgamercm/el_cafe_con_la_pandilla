<?php
include 'conexion_be.php';

// Validar campos requeridos
$required_fields = ['nombre', 'apellido', 'usuario', 'correo', 'contrasena'];
foreach ($required_fields as $field) {
    if (empty($_POST[$field])) {
        echo '
            <script> 
                alert("Por favor complete todos los campos requeridos");
                window.location = "../registrar.php";
            </script>
        ';
        exit();
    }
}

// Limpiar datos
$nombre = mysqli_real_escape_string($conexion, trim($_POST['nombre']));
$apellido = mysqli_real_escape_string($conexion, trim($_POST['apellido']));
$usuario = mysqli_real_escape_string($conexion, trim($_POST['usuario']));
$correo = mysqli_real_escape_string($conexion, trim($_POST['correo']));
$contrasena = trim($_POST['contrasena']);
$fecha_reg = date("d/m/y");

// Validaciones
if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    echo '
        <script> 
            alert("Por favor ingrese un correo electrónico válido");
            window.location = "../registrar.php";
        </script>
    ';
    exit();
}

if (strlen($contrasena) < 8) {
    echo '
        <script> 
            alert("La contraseña debe tener al menos 8 caracteres");
            window.location = "../registrar.php";
        </script>
    ';
    exit();
}

$contrasena_hash = hash('sha512', $contrasena);

// Verificar correo y usuario existentes
$verificar_correo = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo='$correo'");
if (mysqli_num_rows($verificar_correo) > 0) {
    echo '
        <script> 
            alert("Este correo ya está registrado, intenta con otro diferente");
            window.location = "../registrar.php";
        </script>
    ';
    exit();
}

$verificar_usuario = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario='$usuario'");
if (mysqli_num_rows($verificar_usuario) > 0) {
    echo '
        <script> 
            alert("Este usuario ya está registrado, intenta con otro diferente");
            window.location = "../registrar.php";
        </script>
    ';
    exit();
}

// Insertar nuevo usuario
$query = "INSERT INTO usuarios(nombre, apellido, usuario, correo, contrasena, fecha_reg) 
          VALUES ('$nombre', '$apellido', '$usuario', '$correo', '$contrasena_hash', '$fecha_reg')";

if (mysqli_query($conexion, $query)) {
    echo '
        <script> 
            alert("Usuario registrado exitosamente");
            window.location = "../index.php";
        </script>
    ';
} else {
    echo '
        <script> 
            alert("Error al registrar usuario: ' . mysqli_error($conexion) . '");
            window.location = "../registrar.php";
        </script>
    ';
}

mysqli_close($conexion);
?>