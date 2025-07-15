<?php
header('Content-Type: application/json');
include 'conexion_be.php'; // Asegúrate de que la ruta sea correcta
include 'verificar_sesion.php'; // Asegúrate de que la ruta sea correcta

// Verificar autenticación para empleados
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'administrador') {
    echo json_encode(['success' => false, 'message' => 'Acceso denegado. Solo empleados pueden ver las estadísticas.']);
    exit();
}

$response = ['success' => true, 'message' => 'Estadísticas obtenidas con éxito.', 'data' => []];

try {
    // 1. Estadísticas Generales
    $queryTotalProducts = "SELECT COUNT(id) AS total_productos FROM inventario";
    $resultTotalProducts = mysqli_query($conexion, $queryTotalProducts);
    $totalProducts = mysqli_fetch_assoc($resultTotalProducts)['total_productos'];

    $queryTotalInventoryValue = "SELECT SUM(precio * unidades_existentes) AS valor_total_inventario FROM inventario";
    $resultTotalInventoryValue = mysqli_query($conexion, $queryTotalInventoryValue);
    $totalInventoryValue = mysqli_fetch_assoc($resultTotalInventoryValue)['valor_total_inventario'];

    $queryTotalSales = "SELECT SUM(total) AS total_ventas FROM pedidos WHERE estado = 'completado'";
    $resultTotalSales = mysqli_query($conexion, $queryTotalSales);
    $totalSales = mysqli_fetch_assoc($resultTotalSales)['total_ventas'];

    $queryTotalCustomers = "SELECT COUNT(DISTINCT id) AS total_clientes FROM usuarios WHERE rol = 'cliente'";
    $resultTotalCustomers = mysqli_query($conexion, $queryTotalCustomers);
    $totalCustomers = mysqli_fetch_assoc($resultTotalCustomers)['total_clientes'];

    $response['generalStats'] = [
        'totalProducts' => $totalProducts,
        'totalInventoryValue' => $totalInventoryValue ?: 0, // Si es null, poner 0
        'totalSales' => $totalSales ?: 0,
        'totalCustomers' => $totalCustomers,
    ];

    // 2. Inventario por Categoría
    $queryInventoryByCategory = "
        SELECT 
            c.nombre AS categoria_nombre,
            COUNT(i.id) AS cantidad_productos,
            SUM(i.precio * i.unidades_existentes) AS valor_estimado
        FROM inventario i
        JOIN categorias c ON i.categoria_id = c.id
        GROUP BY c.nombre
        ORDER BY c.nombre;
    ";
    $resultInventoryByCategory = mysqli_query($conexion, $queryInventoryByCategory);
    $inventoryByCategory = [];
    while ($row = mysqli_fetch_assoc($resultInventoryByCategory)) {
        $inventoryByCategory[] = $row;
    }
    $response['inventoryByCategory'] = $inventoryByCategory;

    // 3. Productos Más Vendidos (Top 10)
    $queryBestSellingProducts = "
        SELECT 
            i.nombre AS nombre_producto,
            c.nombre AS categoria_nombre,
            SUM(dp.cantidad) AS cantidad_vendida,
            SUM(dp.cantidad * dp.precio_unitario) AS ingresos_generados
        FROM detalles_pedido dp
        JOIN inventario i ON dp.producto_id = i.id
        JOIN categorias c ON i.categoria_id = c.id
        GROUP BY i.id, i.nombre, c.nombre
        ORDER BY cantidad_vendida DESC
        LIMIT 10;
    ";
    $resultBestSellingProducts = mysqli_query($conexion, $queryBestSellingProducts);
    $bestSellingProducts = [];
    while ($row = mysqli_fetch_assoc($resultBestSellingProducts)) {
        $bestSellingProducts[] = $row;
    }
    $response['bestSellingProducts'] = $bestSellingProducts;

    // 4. Productos Menos Vendidos (Top 10, incluyendo no vendidos)
    // Primero, obtener todos los productos que no se han vendido
    $queryNotSoldProducts = "
        SELECT
            i.nombre AS nombre_producto,
            c.nombre AS categoria_nombre,
            0 AS cantidad_vendida,
            0.00 AS ingresos_generados
        FROM inventario i
        JOIN categorias c ON i.categoria_id = c.id
        LEFT JOIN detalles_pedido dp ON i.id = dp.producto_id
        WHERE dp.producto_id IS NULL;
    ";
    $resultNotSoldProducts = mysqli_query($conexion, $queryNotSoldProducts);
    $notSoldProducts = [];
    while ($row = mysqli_fetch_assoc($resultNotSoldProducts)) {
        $notSoldProducts[] = $row;
    }

    // Luego, obtener los productos con menos ventas (excluyendo los no vendidos si ya los tenemos)
    $queryLeastSellingProducts = "
        SELECT
            i.nombre AS nombre_producto,
            c.nombre AS categoria_nombre,
            SUM(dp.cantidad) AS cantidad_vendida,
            SUM(dp.cantidad * dp.precio_unitario) AS ingresos_generados
        FROM detalles_pedido dp
        JOIN inventario i ON dp.producto_id = i.id
        JOIN categorias c ON i.categoria_id = c.id
        GROUP BY i.id, i.nombre, c.nombre
        ORDER BY cantidad_vendida ASC
        LIMIT 10;
    ";
    $resultLeastSellingProducts = mysqli_query($conexion, $queryLeastSellingProducts);
    $leastSellingProducts = [];
    while ($row = mysqli_fetch_assoc($resultLeastSellingProducts)) {
        $leastSellingProducts[] = $row;
    }

    // Combinar y asegurar que los no vendidos aparezcan primero si hay espacio
    $response['leastSellingProducts'] = array_slice(array_merge($notSoldProducts, $leastSellingProducts), 0, 10);


    // 5. Historial de Ventas
    $querySalesHistory = "
        SELECT
            p.id AS id_pedido,
            p.fecha_pedido,
            p.total AS total_pedido,
            p.estado AS estado_pedido,
            u.nombre AS nombre_cliente,
            u.apellido AS apellido_cliente
        FROM pedidos p
        JOIN usuarios u ON p.usuario_id = u.id
        ORDER BY p.fecha_pedido DESC
        LIMIT 20; -- Limitar a los últimos 20 pedidos para no sobrecargar
    ";
    $resultSalesHistory = mysqli_query($conexion, $querySalesHistory);
    $salesHistory = [];
    while ($row = mysqli_fetch_assoc($resultSalesHistory)) {
        // Obtener detalles de productos para cada pedido
        $queryProductsInOrder = "
            SELECT
                i.nombre,
                dp.cantidad
            FROM detalles_pedido dp
            JOIN inventario i ON dp.producto_id = i.id
            WHERE dp.pedido_id = " . $row['id_pedido'];
        $resultProductsInOrder = mysqli_query($conexion, $queryProductsInOrder);
        $products = [];
        while ($p_row = mysqli_fetch_assoc($resultProductsInOrder)) {
            $products[] = $p_row;
        }
        $row['productos'] = $products;
        $salesHistory[] = $row;
    }
    $response['salesHistory'] = $salesHistory;

    // 6. Historial de Compras por Cliente
    $queryCustomerPurchaseHistory = "
        SELECT
            u.nombre AS nombre_cliente,
            u.apellido AS apellido_cliente,
            u.correo AS correo_cliente,
            SUM(p.total) AS total_comprado,
            COUNT(p.id) AS cantidad_pedidos,
            MAX(p.fecha_pedido) AS ultimo_pedido
        FROM usuarios u
        JOIN pedidos p ON u.id = p.usuario_id
        WHERE u.rol = 'cliente' AND p.estado = 'completado'
        GROUP BY u.id, u.nombre, u.apellido, u.correo
        ORDER BY total_comprado DESC
        LIMIT 10; -- Limitar a los 10 clientes con más compras
    ";
    $resultCustomerPurchaseHistory = mysqli_query($conexion, $queryCustomerPurchaseHistory);
    $customerPurchaseHistory = [];
    while ($row = mysqli_fetch_assoc($resultCustomerPurchaseHistory)) {
        $customerPurchaseHistory[] = $row;
    }
    $response['customerPurchaseHistory'] = $customerPurchaseHistory;

} catch (Exception $e) {
    $response = ['success' => false, 'message' => 'Error en el servidor: ' . $e->getMessage()];
} finally {
    mysqli_close($conexion);
}

echo json_encode($response);
?>
