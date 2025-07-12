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
    $required_fields = ['codigo', 'nombre', 'precio', 'pagina', 'categoria'];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            echo json_encode(['success' => false, 'message' => "El campo $field es requerido"]);
            exit();
        }
    }

    $codigo = mysqli_real_escape_string($conexion, trim($_POST['codigo']));
    $nombre = mysqli_real_escape_string($conexion, trim($_POST['nombre']));
    $descripcion = mysqli_real_escape_string($conexion, trim($_POST['descripcion'] ?? ''));
    $categoria = mysqli_real_escape_string($conexion, trim($_POST['categoria']));
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

    // Obtener ID de categoría
    $query_categoria = "SELECT id FROM categorias WHERE nombre = '$categoria' LIMIT 1";
    $result_categoria = mysqli_query($conexion, $query_categoria);
    
    if (!$result_categoria || mysqli_num_rows($result_categoria) === 0) {
        echo json_encode(['success' => false, 'message' => 'Categoría no válida']);
        exit();
    }
    
    $categoria_id = mysqli_fetch_assoc($result_categoria)['id'];

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

    $verificar_codigo = mysqli_query($conexion, "SELECT id FROM inventario WHERE codigo='$codigo'");
    if (mysqli_num_rows($verificar_codigo) > 0) {
        echo json_encode(['success' => false, 'message' => 'Este código de producto ya existe']);
        exit();
    }

    $verificar_pagina = mysqli_query($conexion, "SELECT id FROM inventario WHERE pagina='$pagina'");
    if (mysqli_num_rows($verificar_pagina) > 0) {
        echo json_encode(['success' => false, 'message' => 'Esta página ya está asignada a otro producto']);
        exit();
    }

    if ($unidades_existentes <= 0) {
        $estado = 'agotado';
    }

    $query = "INSERT INTO inventario (codigo, nombre, descripcion, categoria_id, precio, pagina, 
              cantidad, unidades_existentes, unidades_minimas, fecha_ingreso, estado) 
              VALUES ('$codigo', '$nombre', '$descripcion', $categoria_id, $precio, '$pagina', 
              $cantidad, $unidades_existentes, $unidades_minimas, '$fecha_ingreso', '$estado')";

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
    $required_fields = ['codigo', 'nombre', 'precio', 'pagina', 'categoria'];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            echo json_encode(['success' => false, 'message' => "El campo $field es requerido"]);
            exit();
        }
    }

    $codigo = mysqli_real_escape_string($conexion, trim($_POST['codigo']));
    $nombre = mysqli_real_escape_string($conexion, trim($_POST['nombre']));
    $descripcion = mysqli_real_escape_string($conexion, trim($_POST['descripcion'] ?? ''));
    $categoria = mysqli_real_escape_string($conexion, trim($_POST['categoria']));
    $precio = floatval($_POST['precio']);
    $pagina = mysqli_real_escape_string($conexion, trim($_POST['pagina']));
    $cantidad = intval($_POST['cantidad'] ?? 0);
    $unidades_existentes = intval($_POST['unidades_existentes'] ?? $cantidad);
    $unidades_minimas = intval($_POST['unidades_minimas'] ?? 10);
    $estado = mysqli_real_escape_string($conexion, trim($_POST['estado'] ?? 'activo'));

    // Obtener ID de categoría
    $query_categoria = "SELECT id FROM categorias WHERE nombre = '$categoria' LIMIT 1";
    $result_categoria = mysqli_query($conexion, $query_categoria);
    
    if (!$result_categoria || mysqli_num_rows($result_categoria) === 0) {
        echo json_encode(['success' => false, 'message' => 'Categoría no válida']);
        exit();
    }
    
    $categoria_id = mysqli_fetch_assoc($result_categoria)['id'];

    if ($precio <= 0) {
        echo json_encode(['success' => false, 'message' => 'El precio debe ser mayor a cero']);
        exit();
    }

    if ($unidades_existentes < 0 || $cantidad < 0 || $unidades_minimas < 0) {
        echo json_encode(['success' => false, 'message' => 'Las cantidades no pueden ser negativas']);
        exit();
    }

    $verificar_codigo = mysqli_query($conexion, "SELECT id FROM inventario WHERE codigo='$codigo' AND id != $id");
    if (mysqli_num_rows($verificar_codigo) > 0) {
        echo json_encode(['success' => false, 'message' => 'Este código de producto ya existe en otro registro']);
        exit();
    }

    $verificar_pagina = mysqli_query($conexion, "SELECT id FROM inventario WHERE pagina='$pagina' AND id != $id");
    if (mysqli_num_rows($verificar_pagina) > 0) {
        echo json_encode(['success' => false, 'message' => 'Esta página ya está asignada a otro producto']);
        exit();
    }

    if ($unidades_existentes <= 0) {
        $estado = 'agotado';
    }

    $query = "UPDATE inventario SET 
              codigo = '$codigo',
              nombre = '$nombre',
              descripcion = '$descripcion',
              categoria_id = $categoria_id,
              precio = $precio,
              pagina = '$pagina',
              cantidad = $cantidad,
              unidades_existentes = $unidades_existentes,
              unidades_minimas = $unidades_minimas,
              estado = '$estado'
              WHERE id = $id";

    if (mysqli_query($conexion, $query)) {
        echo json_encode(['success' => true, 'message' => 'Producto actualizado exitosamente']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar producto: ' . mysqli_error($conexion)]);
    }
}

function quitarProducto($conexion) {
    if (empty($_POST['id'])) {
        echo json_encode(['success' => false, 'message' => 'ID de producto no especificado']);
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
    $verificar = mysqli_query($conexion, "SELECT COUNT(*) as total FROM inventario");
    $row = mysqli_fetch_assoc($verificar);
    
    if ($row['total'] == 0) {
        echo json_encode(['success' => false, 'message' => 'No hay productos para eliminar']);
        exit();
    }

    $query = "DELETE FROM inventario";
    
    if (mysqli_query($conexion, $query)) {
        echo json_encode(['success' => true, 'message' => 'Todos los productos han sido eliminados']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar productos: ' . mysqli_error($conexion)]);
    }
}

function agregarProductosEjemplo($conexion) {
    // Primero verificar si ya hay productos
    $verificar = mysqli_query($conexion, "SELECT COUNT(*) as total FROM inventario");
    $row = mysqli_fetch_assoc($verificar);
    
    if ($row['total'] > 0) {
        echo json_encode(['success' => false, 'message' => 'No se pueden agregar ejemplos porque ya existen productos']);
        exit();
    }

    // Obtener IDs de categorías
    $categorias = [
        'Bebidas' => null,
        'Panadería' => null,
        'Postres' => null
    ];
    
    foreach ($categorias as $nombre => $id) {
        $query = "SELECT id FROM categorias WHERE nombre = '$nombre' LIMIT 1";
        $result = mysqli_query($conexion, $query);
        
        if ($result && mysqli_num_rows($result) > 0) {
            $categorias[$nombre] = mysqli_fetch_assoc($result)['id'];
        } else {
            // Si la categoría no existe, crearla
            $insert = "INSERT INTO categorias (nombre) VALUES ('$nombre')";
            if (mysqli_query($conexion, $insert)) {
                $categorias[$nombre] = mysqli_insert_id($conexion);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al crear categoría: ' . mysqli_error($conexion)]);
                exit();
            }
        }
    }

    $productosEjemplo = [
        [
            'codigo' => 'CAFE-001',
            'nombre' => 'Café Capuchino',
            'descripcion' => 'Café espresso con leche vaporizada y espuma',
            'categoria' => 'Bebidas',
            'categoria_id' => $categorias['Bebidas'],
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
            'categoria_id' => $categorias['Panadería'],
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
            'categoria_id' => $categorias['Postres'],
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
        $query = "INSERT INTO inventario (codigo, nombre, descripcion, categoria_id, cantidad, precio, 
                  unidades_existentes, unidades_minimas, fecha_ingreso, estado, pagina) 
                  VALUES (
                  '".mysqli_real_escape_string($conexion, $producto['codigo'])."',
                  '".mysqli_real_escape_string($conexion, $producto['nombre'])."',
                  '".mysqli_real_escape_string($conexion, $producto['descripcion'])."',
                  ".$producto['categoria_id'].",
                  ".$producto['cantidad'].",
                  ".$producto['precio'].",
                  ".$producto['unidades_existentes'].",
                  ".$producto['unidades_minimas'].",
                  '".$producto['fecha_ingreso']."',
                  '".$producto['estado']."',
                  '".$producto['pagina']."')";

        if (mysqli_query($conexion, $query)) {
            $agregados++;
            
            // Insertar imagen por defecto
            $producto_id = mysqli_insert_id($conexion);
            $imagen_url = "img/cafe/".$producto['codigo'].".jpg";
            $query_img = "INSERT INTO imagenes_producto (producto_id, url_imagen, es_principal) 
                         VALUES ($producto_id, '$imagen_url', TRUE)";
            mysqli_query($conexion, $query_img);
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