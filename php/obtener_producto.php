<?php
include 'conexion_be.php';

header('Content-Type: application/json');

if (empty($_GET['id'])) {
    echo json_encode(['error' => 'ID de producto no especificado']);
    exit();
}

$id = intval($_GET['id']);

$query = "SELECT i.*, c.nombre AS categoria_nombre 
          FROM inventario i
          LEFT JOIN categorias c ON i.categoria_id = c.id
          WHERE i.id = $id";
$result = mysqli_query($conexion, $query);

if (mysqli_num_rows($result) === 1) {
    $producto = mysqli_fetch_assoc($result);
    
    // Obtener imagen principal
    $query_img = "SELECT url_imagen FROM imagenes_producto 
                 WHERE producto_id = $id AND es_principal = TRUE
                 LIMIT 1";
    $result_img = mysqli_query($conexion, $query_img);
    
    if ($result_img && mysqli_num_rows($result_img) > 0) {
        $imagen = mysqli_fetch_assoc($result_img);
        $producto['imagen'] = $imagen['url_imagen'];
    } else {
        $producto['imagen'] = "img/cafe/default.jpg";
    }
    
    echo json_encode($producto);
} else {
    echo json_encode(['error' => 'Producto no encontrado']);
}

mysqli_close($conexion);
?>