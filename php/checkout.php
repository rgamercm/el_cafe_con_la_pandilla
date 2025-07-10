<?php
require_once 'php/conexion_be.php';
require_once 'php/verificar_sesion.php';

header('Content-Type: application/json');

// Verificar sesión
if (!isset($_SESSION['usuario'])) {
    echo json_encode(['success' => false, 'message' => 'Debes iniciar sesión']);
    exit();
}

// Obtener datos del carrito y pago
$input = json_decode(file_get_contents('php://input'), true);
$cart = $input['cart'] ?? [];
$paymentMethod = $input['paymentMethod'] ?? '';
$paymentDetails = $input['paymentDetails'] ?? [];
$deliveryAddress = $input['deliveryAddress'] ?? '';

if (empty($cart)) {
    echo json_encode(['success' => false, 'message' => 'Carrito vacío']);
    exit();
}

// Calcular totales
$subtotal = 0;
foreach ($cart as $item) {
    $subtotal += $item['price'] * $item['quantity'];
}
$tax = $subtotal * 0.16; // IVA 16%
$total = $subtotal + $tax;

// Iniciar transacción
mysqli_begin_transaction($conexion);

try {
    // 1. Crear pedido
    $query = "INSERT INTO pedidos (usuario_id, estado, subtotal, impuestos, total, metodo_pago, datos_pago, direccion_envio) 
              VALUES (?, 'pendiente', ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexion, $query);
    $paymentData = json_encode($paymentDetails);
    mysqli_stmt_bind_param($stmt, "idddsss", $_SESSION['usuario']['id'], $subtotal, $tax, $total, $paymentMethod, $paymentData, $deliveryAddress);
    mysqli_stmt_execute($stmt);
    $pedido_id = mysqli_insert_id($conexion);
    
    // 2. Agregar detalles del pedido y actualizar inventario
    foreach ($cart as $item) {
        $producto_id = intval($item['id']);
        $cantidad = intval($item['quantity']);
        
        // Verificar disponibilidad
        $verificar = mysqli_query($conexion, "SELECT unidades_existentes FROM inventario WHERE id = $producto_id FOR UPDATE");
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
        mysqli_stmt_bind_param($stmt, "iiidd", $pedido_id, $producto_id, $cantidad, $precio_unitario, $subtotal_item);
        mysqli_stmt_execute($stmt);
        
        // Actualizar inventario
        $query = "UPDATE inventario 
                  SET unidades_existentes = unidades_existentes - ?, 
                      estado = IF(unidades_existentes - ? <= 0, 'agotado', estado)
                  WHERE id = ?";
        $stmt = mysqli_prepare($conexion, $query);
        mysqli_stmt_bind_param($stmt, "iii", $cantidad, $cantidad, $producto_id);
        mysqli_stmt_execute($stmt);
    }
    
    // Confirmar transacción
    mysqli_commit($conexion);
    
    // Limpiar carrito
    localStorage.removeItem('cart');
    
    echo json_encode([
        'success' => true,
        'message' => 'Pedido completado con éxito',
        'pedido_id' => $pedido_id
    ]);
} catch (Exception $e) {
    // Revertir transacción en caso de error
    mysqli_rollback($conexion);
    
    echo json_encode([
        'success' => false,
        'message' => 'Error al procesar el pedido: ' . $e->getMessage()
    ]);
}
?>