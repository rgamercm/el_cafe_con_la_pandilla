<?php
include 'conexion_be.php';

header('Content-Type: application/json');

if (empty($_GET['id'])) {
    echo json_encode(['error' => 'ID de producto no especificado']);
    exit();
}

$id = intval($_GET['id']);

$query = "SELECT * FROM inventario WHERE id = $id";
$result = mysqli_query($conexion, $query);

if (mysqli_num_rows($result) === 1) {
    $producto = mysqli_fetch_assoc($result);
    echo json_encode($producto);
} else {
    echo json_encode(['error' => 'Producto no encontrado']);
}

mysqli_close($conexion);
?>