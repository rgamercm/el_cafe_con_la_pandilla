<?php
include 'conexion_be.php';

header('Content-Type: application/json');

$query = "SELECT * FROM categorias ORDER BY nombre";
$result = mysqli_query($conexion, $query);

$categorias = [];
while ($row = mysqli_fetch_assoc($result)) {
    $categorias[] = $row;
}

echo json_encode($categorias);

mysqli_close($conexion);
?>