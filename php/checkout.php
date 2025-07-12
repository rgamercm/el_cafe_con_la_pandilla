<?php
require_once 'conexion_be.php';
require_once 'verificar_sesion.php';

// Establecer el tipo de contenido como JSON
header('Content-Type: application/json');

// Verificar sesión
if (!isset($_SESSION['usuario'])) {
    echo json_encode(['success' => false, 'message' => 'Debes iniciar sesión']);
    exit();
}

// Obtener datos del carrito y pago
$input = json_decode(file_get_contents('php://input'), true);
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
    exit();
}

$cart = $input['cart'] ?? [];
$paymentMethod = $input['paymentMethod'] ?? '';
$paymentDetails = $input['paymentDetails'] ?? [];
$deliveryAddress = $input['deliveryAddress'] ?? '';

if (empty($cart)) {
    echo json_encode(['success' => false, 'message' => 'Carrito vacío']);
    exit();
}

// Validar método de pago
$metodosPermitidos = ['tarjeta', 'transferencia', 'pago_movil', 'efectivo'];
if (!in_array($paymentMethod, $metodosPermitidos)) {
    echo json_encode(['success' => false, 'message' => 'Método de pago no válido']);
    exit();
}

// Desactivar la visualización de errores de PHP en la respuesta
ini_set('display_errors', 0);
error_reporting(0);

// Iniciar transacción
mysqli_begin_transaction($conexion);

try {
    // Calcular totales
    $subtotal = 0;
    foreach ($cart as $item) {
        if (!isset($item['id'], $item['price'], $item['quantity'])) {
            throw new Exception('Datos del carrito incompletos');
        }
        
        $subtotal += $item['price'] * $item['quantity'];
    }
    
    $tax = $subtotal * 0.16; // IVA 16%
    $total = $subtotal + $tax;

    // 1. Crear pedido
    $query = "INSERT INTO pedidos (usuario_id, estado, subtotal, impuestos, total, metodo_pago, datos_pago, direccion_envio) 
              VALUES (?, 'pendiente', ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexion, $query);
    
    if (!$stmt) {
        throw new Exception('Error al preparar la consulta: ' . mysqli_error($conexion));
    }
    
    $paymentData = json_encode($paymentDetails);
    mysqli_stmt_bind_param($stmt, "idddsss", $_SESSION['usuario']['id'], $subtotal, $tax, $total, $paymentMethod, $paymentData, $deliveryAddress);
    
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception('Error al ejecutar la consulta: ' . mysqli_stmt_error($stmt));
    }
    
    $pedido_id = mysqli_insert_id($conexion);
    
    // 2. Agregar detalles del pedido y actualizar inventario
    foreach ($cart as $item) {
        $producto_id = intval($item['id']);
        $cantidad = intval($item['quantity']);
        
        // Verificar disponibilidad con bloqueo
        $verificar = mysqli_query($conexion, "SELECT unidades_existentes FROM inventario WHERE id = $producto_id FOR UPDATE");
        if (!$verificar) {
            throw new Exception('Error al verificar inventario: ' . mysqli_error($conexion));
        }
        
        $producto = mysqli_fetch_assoc($verificar);
        
        if (!$producto || $producto['unidades_existentes'] < $cantidad) {
            throw new Exception("Producto ID $producto_id no disponible o cantidad insuficiente");
        }
        
        // Agregar detalle
        $precio_unitario = floatval($item['price']);
        $subtotal_item = $precio_unitario * $cantidad;
        
        $query = "INSERT INTO detalles_pedido (pedido_id, producto_id, cantidad, precio_unitario, subtotal) 
                  VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conexion, $query);
        
        if (!$stmt) {
            throw new Exception('Error al preparar la consulta: ' . mysqli_error($conexion));
        }
        
        mysqli_stmt_bind_param($stmt, "iiidd", $pedido_id, $producto_id, $cantidad, $precio_unitario, $subtotal_item);
        
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception('Error al ejecutar la consulta: ' . mysqli_stmt_error($stmt));
        }
        
        // Actualizar inventario
        $query = "UPDATE inventario 
                  SET unidades_existentes = unidades_existentes - ?, 
                      estado = IF(unidades_existentes - ? <= 0, 'agotado', estado)
                  WHERE id = ?";
        $stmt = mysqli_prepare($conexion, $query);
        
        if (!$stmt) {
            throw new Exception('Error al preparar la consulta: ' . mysqli_error($conexion));
        }
        
        mysqli_stmt_bind_param($stmt, "iii", $cantidad, $cantidad, $producto_id);
        
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception('Error al ejecutar la consulta: ' . mysqli_stmt_error($stmt));
        }
    }
    
    // Confirmar transacción
    mysqli_commit($conexion);
    
    echo json_encode([
        'success' => true,
        'message' => 'Pedido completado con éxito',
        'pedido_id' => $pedido_id
    ]);
    
} catch (Exception $e) {
    // Revertir transacción en caso de error
    mysqli_rollback($conexion);
    
    // Registrar el error para depuración (en un entorno de producción, usar un sistema de logging)
    error_log('Error en checkout: ' . $e->getMessage());
    
    echo json_encode([
        'success' => false,
        'message' => 'Error al procesar el pedido: ' . $e->getMessage()
    ]);
}
?>