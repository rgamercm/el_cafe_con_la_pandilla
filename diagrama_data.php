<?php
include('conexion.php');
header('Content-Type: application/json');

// Consulta mejorada con joins para obtener más información
$sql = "SELECT 
            m.id_movimiento, 
            m.tipo, 
            p.nombre AS producto, 
            p.descripcion,
            m.cantidad, 
            u.nombre AS usuario,
            r.nombre_rol AS rol,
            m.fecha 
        FROM movimientos m
        JOIN productos p ON m.id_producto = p.id_producto
        JOIN usuarios u ON m.id_usuario = u.id_usuario
        JOIN roles r ON u.id_rol = r.id_rol
        ORDER BY m.fecha DESC 
        LIMIT 20";

$result = $conn->query($sql);
$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>