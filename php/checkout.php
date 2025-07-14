<?php
require_once 'conexion_be.php';
require_once 'verificar_sesion.php';

header('Content-Type: application/json');

if (!isset($_SESSION['usuario'])) {
    echo json_encode(['success' => false, 'message' => 'Debes iniciar sesión']);
    exit();
}

$input = json_decode(file_get_contents('php://input'), true);
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
    exit();
}

$cart = $input['cart'] ?? [];
$paymentMethodType = $input['paymentMethodType'] ?? '';
$paymentDetails = $input['paymentDetails'] ?? [];
$deliveryAddress = $input['deliveryAddress'] ?? '';
$subtotal = $input['subtotal'] ?? 0;
$tax = $input['tax'] ?? 0;
$total = $input['total'] ?? 0;

if (empty($cart)) {
    echo json_encode(['success' => false, 'message' => 'Carrito vacío']);
    exit();
}

$metodosPermitidos = ['tarjeta', 'transferencia', 'pago_movil', 'efectivo'];
if (!in_array($paymentMethodType, $metodosPermitidos)) {
    echo json_encode(['success' => false, 'message' => 'Método de pago no válido']);
    exit();
}

ini_set('display_errors', 0);
error_reporting(0);

mysqli_begin_transaction($conexion);

try {
    // 1. Obtener ID del método de pago
    $query = "SELECT id FROM metodos_pago WHERE tipo = ?";
    $stmt = mysqli_prepare($conexion, $query);
    
    if (!$stmt) {
        throw new Exception('Error al preparar la consulta: ' . mysqli_error($conexion));
    }
    
    mysqli_stmt_bind_param($stmt, "s", $paymentMethodType);
    
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception('Error al ejecutar la consulta: ' . mysqli_stmt_error($stmt));
    }
    
    $result = mysqli_stmt_get_result($stmt);
    $metodo_pago = mysqli_fetch_assoc($result);
    
    if (!$metodo_pago) {
        throw new Exception('Método de pago no encontrado en la base de datos');
    }
    
    $metodo_pago_id = $metodo_pago['id'];

    // 2. Insertar el pedido principal
    $query = "INSERT INTO pedidos (
                usuario_id,
                fecha_pedido,
                estado,
                subtotal,
                impuestos,
                total,
                metodo_pago_id,
                datos_pago,
                direccion_envio
              ) VALUES (
                ?,
                NOW(),  -- Usamos NOW() para la fecha actual
                'pendiente',
                ?,
                ?,
                ?,
                ?,
                ?,
                ?
              )";
    
    $stmt = mysqli_prepare($conexion, $query);
    
    if (!$stmt) {
        throw new Exception('Error al preparar la consulta: ' . mysqli_error($conexion));
    }
    
    $paymentData = json_encode($paymentDetails);
    mysqli_stmt_bind_param(
        $stmt, 
        "idddiss", 
        $_SESSION['usuario']['id'],
        $subtotal,
        $tax,
        $total,
        $metodo_pago_id,
        $paymentData,
        $deliveryAddress
    );
    
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception('Error al ejecutar la consulta: ' . mysqli_stmt_error($stmt));
    }
    
    $pedido_id = mysqli_insert_id($conexion);
    
    // 3. Procesar cada item del carrito
    foreach ($cart as $item) {
        if (!isset($item['id'], $item['price'], $item['quantity'])) {
            throw new Exception('Datos del carrito incompletos');
        }
        
        $producto_id = intval($item['id']);
        $cantidad = intval($item['quantity']);
        
        // Verificar disponibilidad con bloqueo
        $verificar = mysqli_query($conexion, 
            "SELECT unidades_existentes FROM inventario WHERE id = $producto_id FOR UPDATE");
        
        if (!$verificar) {
            throw new Exception('Error al verificar inventario: ' . mysqli_error($conexion));
        }
        
        $producto = mysqli_fetch_assoc($verificar);
        
        if (!$producto || $producto['unidades_existentes'] < $cantidad) {
            throw new Exception("Producto ID $producto_id no disponible o cantidad insuficiente");
        }
        
        // Insertar detalle del pedido
        $precio_unitario = floatval($item['price']);
        $subtotal_item = $precio_unitario * $cantidad;
        
        $query = "INSERT INTO detalles_pedido (
                    pedido_id,
                    producto_id,
                    cantidad,
                    precio_unitario,
                    subtotal
                  ) VALUES (?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($conexion, $query);
        
        if (!$stmt) {
            throw new Exception('Error al preparar la consulta: ' . mysqli_error($conexion));
        }
        
        mysqli_stmt_bind_param(
            $stmt,
            "iiidd",
            $pedido_id,
            $producto_id,
            $cantidad,
            $precio_unitario,
            $subtotal_item
        );
        
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
    error_log('Error en checkout: ' . $e->getMessage());
    
    echo json_encode([
        'success' => false,
        'message' => 'Error al procesar el pedido: ' . $e->getMessage()
    ]);
}
?>