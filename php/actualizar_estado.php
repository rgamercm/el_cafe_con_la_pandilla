<?php
require_once 'conexion_be.php';

header('Content-Type: application/json');

if (!isset($_GET['id'])) {
    echo json_encode(['disponible' => false]);
    exit();
}

$id_producto = intval($_GET['id']);
$query = "SELECT unidades_existentes, estado FROM inventario WHERE id = $id_producto";
$result = mysqli_query($conexion, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $producto = mysqli_fetch_assoc($result);
    $disponible = ($producto['unidades_existentes'] > 0 && $producto['estado'] == 'activo');
    echo json_encode(['disponible' => $disponible]);
} else {
    echo json_encode(['disponible' => false]);
}
?>