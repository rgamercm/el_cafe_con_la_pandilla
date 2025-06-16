<?php
include 'conexion_be.php';

// Validar que todos los campos requeridos estén presentes
$required_fields = ['nombre', 'apellido', 'usuario', 'email', 'contrasena'];
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

// Limpiar y asignar variables
$nombre = mysqli_real_escape_string($conexion, trim($_POST['nombre']));
$apellido = mysqli_real_escape_string($conexion, trim($_POST['apellido']));
$usuario = mysqli_real_escape_string($conexion, trim($_POST['usuario']));
$email = mysqli_real_escape_string($conexion, trim($_POST['email']));
$contrasena = trim($_POST['contrasena']);
$fecha_reg = date("d/m/y");

// Validar formato de email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo '
        <script> 
            alert("Por favor ingrese un correo electrónico válido");
            window.location = "../registrar.php";
        </script>
    ';
    exit();
}

// Validar fortaleza de contraseña (mínimo 8 caracteres)
if (strlen($contrasena) < 8) {
    echo '
        <script> 
            alert("La contraseña debe tener al menos 8 caracteres");
            window.location = "../registrar.php";
        </script>
    ';
    exit();
}

// Encriptar contraseña
$contrasena_hash = hash('sha512', $contrasena);

// Verificar que el correo no exista
$verificar_correo = mysqli_query($conexion, "SELECT * FROM usuarios WHERE email='$email'");
if (mysqli_num_rows($verificar_correo) > 0) {
    echo '
        <script> 
            alert("Este correo ya está registrado, intenta con otro diferente");
            window.location = "../registrar.php";
        </script>
    ';
    exit();
}

// Verificar que el usuario no exista
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
$query = "INSERT INTO usuarios(nombre, apellido, usuario, email, contrasena, fecha_reg) 
          VALUES ('$nombre', '$apellido', '$usuario', '$email', '$contrasena_hash', '$fecha_reg')";

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