<?php
session_start();
require_once 'conexion_be.php';

header('Content-Type: application/json');

// Verificar sesión
if (!isset($_SESSION['usuario'])) {
    echo json_encode(['success' => false, 'message' => 'Debes iniciar sesión']);
    exit();
}

// Obtener datos del carrito
$input = json_decode(file_get_contents('php://input'), true);
$cart = $input['cart'] ?? [];

if (empty($cart)) {
    echo json_encode(['success' => false, 'message' => 'Carrito vacío']);
    exit();
}

// Procesar cada producto
foreach ($cart as $item) {
    $id = intval($item['id']);
    $cantidad = intval($item['quantity']);
    
    // Actualizar inventario
    $query = "UPDATE inventario 
              SET unidades_existentes = unidades_existentes - $cantidad,
                  estado = IF(unidades_existentes - $cantidad <= 0, 'agotado', estado)
              WHERE id = $id";
    
    if (!mysqli_query($conexion, $query)) {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar inventario']);
        exit();
    }
}

// Vaciar carrito de sesión
unset($_SESSION['cart']);

echo json_encode(['success' => true, 'message' => 'Compra completada']);
?>