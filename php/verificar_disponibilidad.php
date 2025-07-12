<?php
require_once 'conexion_be.php';
require_once 'producto_comun.php';

header('Content-Type: application/json');

if (!isset($_GET['id'])) {
    echo json_encode(['disponible' => false, 'existencias' => 0]);
    exit();
}

$id_producto = intval($_GET['id']);
$cantidad = isset($_GET['cantidad']) ? intval($_GET['cantidad']) : 1;

$disponibilidad = verificarDisponibilidad($id_producto, $cantidad);

echo json_encode([
    'disponible' => $disponibilidad['disponible'],
    'existencias' => $disponibilidad['existencias']
]);
?>