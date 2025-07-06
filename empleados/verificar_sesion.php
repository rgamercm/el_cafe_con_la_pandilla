<?php
session_start();
include 'conexion_be.php';

// Verificar sesión activa o cookie persistente
if(!isset($_SESSION['usuario']) && isset($_COOKIE['panaderia_sesion'])) {
    try {
        $cookie_valor = base64_decode($_COOKIE['panaderia_sesion']);
        list($id, $contrasena_hash) = explode(':', $cookie_valor);
        
        // Prevenir inyección SQL usando consultas preparadas
        $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE id = ? AND contrasena = ?");
        $stmt->bind_param("is", $id, $contrasena_hash);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if($resultado->num_rows === 1) {
            $usuario = $resultado->fetch_assoc();
            
            $_SESSION['usuario'] = array(
                'id' => $usuario['id'],
                'nombre' => htmlspecialchars($usuario['nombre'], ENT_QUOTES, 'UTF-8'),
                'apellido' => htmlspecialchars($usuario['apellido'], ENT_QUOTES, 'UTF-8'),
                'usuario' => htmlspecialchars($usuario['usuario'], ENT_QUOTES, 'UTF-8'),
                'email' => htmlspecialchars($usuario['correo'], ENT_QUOTES, 'UTF-8'),
                'rol' => $usuario['rol']
            );
            
            // Regenerar ID de sesión para prevenir fixation
            session_regenerate_id(true);
        } else {
            // Cookie inválida - elimínala
            setcookie('panaderia_sesion', '', time() - 3600, '/', '', true, true);
        }
    } catch (Exception $e) {
        error_log("Error en verificación de sesión: " . $e->getMessage());
        setcookie('panaderia_sesion', '', time() - 3600, '/', '', true, true);
    }
}

// Función para verificar autenticación
function verificarAutenticacion($rolRequerido = null) {
    if(!isset($_SESSION['usuario'])) {
        header("Location: login_usuario_be.php");
        exit();
    }
    
    if($rolRequerido && $_SESSION['usuario']['rol'] !== $rolRequerido) {
        // Usuario no tiene el rol requerido
        header("Location: acceso_no_autorizado.php");
        exit();
    }
}
?>