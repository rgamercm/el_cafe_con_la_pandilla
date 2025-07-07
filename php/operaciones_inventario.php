<?php
include 'conexion_be.php';

header('Content-Type: application/json');

if (empty($_POST['action'])) {
    echo json_encode(['success' => false, 'message' => 'Acción no especificada']);
    exit();
}

$action = $_POST['action'];

switch ($action) {
    case 'agregar':
        agregarProducto($conexion);
        break;
    case 'editar':
        editarProducto($conexion);
        break;
    case 'quitar':
        quitarProducto($conexion);
        break;
    case 'quitar_todos':
        quitarTodosProductos($conexion);
        break;
    case 'agregar_ejemplos':
        agregarProductosEjemplo($conexion);
        break;
    default:
        echo json_encode(['success' => false, 'message' => 'Acción no válida']);
        break;
}

function agregarProducto($conexion) {
    $required_fields = ['codigo', 'nombre', 'precio', 'pagina'];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            echo json_encode(['success' => false, 'message' => "El campo $field es requerido"]);
            exit();
        }
    }

    $codigo = mysqli_real_escape_string($conexion, trim($_POST['codigo']));
    $nombre = mysqli_real_escape_string($conexion, trim($_POST['nombre']));
    $descripcion = mysqli_real_escape_string($conexion, trim($_POST['descripcion'] ?? ''));
    $categoria = mysqli_real_escape_string($conexion, trim($_POST['categoria'] ?? 'Otros'));
    $precio = floatval($_POST['precio']);
    $pagina = mysqli_real_escape_string($conexion, trim($_POST['pagina']));
    $cantidad = intval($_POST['cantidad'] ?? 0);
    $unidades_existentes = intval($_POST['unidades_existentes'] ?? $cantidad);
    $unidades_minimas = intval($_POST['unidades_minimas'] ?? 10);
    $estado = mysqli_real_escape_string($conexion, trim($_POST['estado'] ?? 'activo'));

    // Validar formato de página
    if (!preg_match('/^p\d+$/', $pagina)) {
        echo json_encode(['success' => false, 'message' => 'El formato de página debe ser p1, p2, etc.']);
        exit();
    }

    $fecha_ingreso = date('Y-m-d');
    if (!empty($_POST['fecha_ingreso']) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $_POST['fecha_ingreso'])) {
        $fecha_ingreso = $_POST['fecha_ingreso'];
    }

    if ($precio <= 0) {
        echo json_encode(['success' => false, 'message' => 'El precio debe ser mayor a cero']);
        exit();
    }

    if ($unidades_existentes < 0 || $cantidad < 0 || $unidades_minimas < 0) {
        echo json_encode(['success' => false, 'message' => 'Las cantidades no pueden ser negativas']);
        exit();
    }

    $verificar_codigo = mysqli_query($conexion, "SELECT * FROM inventario WHERE codigo='$codigo'");
    if (mysqli_num_rows($verificar_codigo) > 0) {
        echo json_encode(['success' => false, 'message' => 'Este código de producto ya existe']);
        exit();
    }

    if ($unidades_existentes <= 0) {
        $estado = 'agotado';
    }

    $query = "INSERT INTO inventario (codigo, nombre, descripcion, categoria, cantidad, precio, 
              unidades_existentes, unidades_minimas, fecha_ingreso, estado, pagina) 
              VALUES ('$codigo', '$nombre', '$descripcion', '$categoria', $cantidad, $precio, 
              $unidades_existentes, $unidades_minimas, '$fecha_ingreso', '$estado', '$pagina')";

    if (mysqli_query($conexion, $query)) {
        echo json_encode(['success' => true, 'message' => 'Producto agregado exitosamente']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al agregar producto: ' . mysqli_error($conexion)]);
    }
}

function editarProducto($conexion) {
    if (empty($_POST['id'])) {
        echo json_encode(['success' => false, 'message' => 'ID de producto no especificado']);
        exit();
    }

    $id = intval($_POST['id']);
    $required_fields = ['codigo', 'nombre', 'precio', 'pagina'];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            echo json_encode(['success' => false, 'message' => "El campo $field es requerido"]);
            exit();
        }
    }

    $codigo = mysqli_real_escape_string($conexion, trim($_POST['codigo']));
    $nombre = mysqli_real_escape_string($conexion, trim($_POST['nombre']));
    $descripcion = mysqli_real_escape_string($conexion, trim($_POST['descripcion'] ?? ''));
    $categoria = mysqli_real_escape_string($conexion, trim($_POST['categoria'] ?? 'Otros'));
    $precio = floatval($_POST['precio']);
    $pagina = mysqli_real_escape_string($conexion, trim($_POST['pagina']));
    $cantidad = intval($_POST['cantidad'] ?? 0);
    $unidades_existentes = intval($_POST['unidades_existentes'] ?? $cantidad);
    $unidades_minimas = intval($_POST['unidades_minimas'] ?? 10);
    $estado = mysqli_real_escape_string($conexion, trim($_POST['estado'] ?? 'activo'));

    // Validar formato de página
    if (!preg_match('/^p\d+$/', $pagina)) {
        echo json_encode(['success' => false, 'message' => 'El formato de página debe ser p1, p2, etc.']);
        exit();
    }

    if ($precio <= 0) {
        echo json_encode(['success' => false, 'message' => 'El precio debe ser mayor a cero']);
        exit();
    }

    if ($unidades_existentes < 0 || $cantidad < 0 || $unidades_minimas < 0) {
        echo json_encode(['success' => false, 'message' => 'Las cantidades no pueden ser negativas']);
        exit();
    }

    $verificar_codigo = mysqli_query($conexion, "SELECT * FROM inventario WHERE codigo='$codigo' AND id != $id");
    if (mysqli_num_rows($verificar_codigo) > 0) {
        echo json_encode(['success' => false, 'message' => 'Este código de producto ya existe en otro registro']);
        exit();
    }

    if ($unidades_existentes <= 0) {
        $estado = 'agotado';
    }

    $query = "UPDATE inventario SET 
              codigo = '$codigo',
              nombre = '$nombre',
              descripcion = '$descripcion',
              categoria = '$categoria',
              cantidad = $cantidad,
              precio = $precio,
              unidades_existentes = $unidades_existentes,
              unidades_minimas = $unidades_minimas,
              estado = '$estado',
              pagina = '$pagina'
              WHERE id = $id";

    if (mysqli_query($conexion, $query)) {
        echo json_encode(['success' => true, 'message' => 'Producto actualizado exitosamente']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar producto: ' . mysqli_error($conexion)]);
    }
}

function quitarProducto($conexion) {
    if (empty($_POST['action']) || empty($_POST['id'])) {
        echo json_encode(['success' => false, 'message' => 'Parámetros incompletos']);
        exit();
    }

    $id = intval($_POST['id']);
    
    $verificar = mysqli_query($conexion, "SELECT * FROM inventario WHERE id = $id");
    if (mysqli_num_rows($verificar) === 0) {
        echo json_encode(['success' => false, 'message' => 'El producto no existe']);
        exit();
    }

    $query = "DELETE FROM inventario WHERE id = $id";
    
    if (mysqli_query($conexion, $query)) {
        echo json_encode(['success' => true, 'message' => 'Producto eliminado exitosamente']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar producto: ' . mysqli_error($conexion)]);
    }
}

function quitarTodosProductos($conexion) {
    if (empty($_POST['action'])) {
        echo json_encode(['success' => false, 'message' => 'Acción no especificada']);
        exit();
    }

    $verificar = mysqli_query($conexion, "SELECT COUNT(*) as total FROM inventario");
    $row = mysqli_fetch_assoc($verificar);
    
    if ($row['total'] == 0) {
        echo json_encode(['success' => false, 'message' => 'No hay productos para eliminar']);
        exit();
    }

    $query = "TRUNCATE TABLE inventario";
    
    if (mysqli_query($conexion, $query)) {
        echo json_encode(['success' => true, 'message' => 'Todos los productos han sido eliminados']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar productos: ' . mysqli_error($conexion)]);
    }
}

function agregarProductosEjemplo($conexion) {
    $productosEjemplo = [
        [
            'codigo' => 'CAFE-001',
            'nombre' => 'Café Capuchino',
            'descripcion' => 'Café espresso con leche vaporizada y espuma',
            'categoria' => 'Bebidas',
            'cantidad' => 100,
            'precio' => 1.60,
            'unidades_existentes' => 100,
            'unidades_minimas' => 20,
            'fecha_ingreso' => date('Y-m-d'),
            'estado' => 'activo',
            'pagina' => 'p1'
        ],
        [
            'codigo' => 'PAN-001',
            'nombre' => 'Pan Artesanal',
            'descripcion' => 'Pan elaborado con masa madre y fermentación lenta',
            'categoria' => 'Panadería',
            'cantidad' => 50,
            'precio' => 3.60,
            'unidades_existentes' => 50,
            'unidades_minimas' => 15,
            'fecha_ingreso' => date('Y-m-d'),
            'estado' => 'activo',
            'pagina' => 'p2'
        ],
        [
            'codigo' => 'POST-001',
            'nombre' => 'Torta de Chocolate',
            'descripcion' => 'Torta de chocolate con relleno cremoso',
            'categoria' => 'Postres',
            'cantidad' => 30,
            'precio' => 10.10,
            'unidades_existentes' => 30,
            'unidades_minimas' => 10,
            'fecha_ingreso' => date('Y-m-d'),
            'estado' => 'activo',
            'pagina' => 'p4'
        ]
    ];

    $agregados = 0;
    $errores = 0;

    foreach ($productosEjemplo as $producto) {
        $query = "INSERT INTO inventario (codigo, nombre, descripcion, categoria, cantidad, precio, 
                  unidades_existentes, unidades_minimas, fecha_ingreso, estado, pagina) 
                  VALUES (
                  '".mysqli_real_escape_string($conexion, $producto['codigo'])."',
                  '".mysqli_real_escape_string($conexion, $producto['nombre'])."',
                  '".mysqli_real_escape_string($conexion, $producto['descripcion'])."',
                  '".mysqli_real_escape_string($conexion, $producto['categoria'])."',
                  ".$producto['cantidad'].",
                  ".$producto['precio'].",
                  ".$producto['unidades_existentes'].",
                  ".$producto['unidades_minimas'].",
                  '".$producto['fecha_ingreso']."',
                  '".$producto['estado']."',
                  '".$producto['pagina']."')";

        if (mysqli_query($conexion, $query)) {
            $agregados++;
        } else {
            $errores++;
        }
    }

    if ($errores == 0) {
        echo json_encode(['success' => true, 'message' => "Se agregaron $agregados productos de ejemplo"]);
    } else {
        echo json_encode(['success' => false, 'message' => "Se agregaron $agregados productos, pero hubo $errores errores"]);
    }
}

mysqli_close($conexion);
?>