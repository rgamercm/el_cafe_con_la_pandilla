<?php
require_once 'conexion_be.php';
require_once 'verificar_sesion.php';

header('Content-Type: application/json');

// Verificar sesión
if (!isset($_SESSION['usuario'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Debes iniciar sesión']);
    exit();
}

// Verificar método de la petición
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit();
}

// Obtener y validar datos JSON
$input = json_decode(file_get_contents('php://input'), true);
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
    exit();
}

// Extraer y validar datos básicos
$cart = $input['cart'] ?? [];
$paymentMethod = $input['paymentMethod'] ?? ''; // Cambiado de paymentMethodType
$paymentDetails = $input['paymentDetails'] ?? [];
$deliveryAddress = $input['deliveryAddress'] ?? '';

if (empty($cart)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Carrito vacío']);
    exit();
}

// Validar método de pago
$metodosPermitidos = ['tarjeta', 'transferencia', 'pago_movil', 'efectivo'];
if (!in_array($paymentMethod, $metodosPermitidos)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Método de pago no válido']);
    exit();
}

// Calcular totales (mejor hacerlo en el backend)
$subtotal = 0;
foreach ($cart as $item) {
    if (!isset($item['price'], $item['quantity'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Datos del carrito incompletos']);
        exit();
    }
    $subtotal += floatval($item['price']) * intval($item['quantity']);
}
$tax = $subtotal * 0.16; // IVA 16%
$total = $subtotal + $tax;

// Iniciar transacción
mysqli_begin_transaction($conexion);

try {
    // 1. Obtener ID del método de pago
    $query = "SELECT id FROM metodos_pago WHERE tipo = ?";
    $stmt = mysqli_prepare($conexion, $query);
    
    if (!$stmt) {
        throw new Exception('Error al preparar la consulta: ' . mysqli_error($conexion));
    }
    
    mysqli_stmt_bind_param($stmt, "s", $paymentMethod);
    
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
              ) VALUES (?, NOW(), 'pendiente', ?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($conexion, $query);
    
    if (!$stmt) {
        throw new Exception('Error al preparar la consulta: ' . mysqli_error($conexion));
    }
    
    $paymentData = json_encode($paymentDetails, JSON_UNESCAPED_UNICODE);
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
        $producto_id = intval($item['id']);
        $cantidad = intval($item['quantity']);
        $precio_unitario = floatval($item['price']);
        
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
    
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => 'Pedido completado con éxito',
        'pedido_id' => $pedido_id
    ]);
    
} catch (Exception $e) {
    // Revertir transacción en caso de error
    mysqli_rollback($conexion);
    
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error al procesar el pedido',
        'error' => $e->getMessage()
    ]);
    
    // Registrar error para depuración
    error_log('Error en checkout: ' . $e->getMessage());
}
?>