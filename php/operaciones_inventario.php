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

// ... (código anterior se mantiene igual)

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
        // Bebidas
        [
            'codigo' => 'CAFE-001',
            'nombre' => 'Maracaibo Mocha',
            'descripcion' => 'Chocolate venezolano + espresso + leche cremosa',
            'categoria' => 'Bebidas',
            'categoria_id' => $categorias['Bebidas'],
            'cantidad' => 100,
            'precio' => 3.50,
            'unidades_existentes' => 100,
            'unidades_minimas' => 20,
            'fecha_ingreso' => date('Y-m-d'),
            'estado' => 'activo',
            'pagina' => 'p1'
        ],
        [
            'codigo' => 'CAFE-002',
            'nombre' => 'Café Catire',
            'descripcion' => 'Leche dorada (cúrcuma) + espresso + miel de abeja',
            'categoria' => 'Bebidas',
            'categoria_id' => $categorias['Bebidas'],
            'cantidad' => 80,
            'precio' => 3.20,
            'unidades_existentes' => 80,
            'unidades_minimas' => 15,
            'fecha_ingreso' => date('Y-m-d'),
            'estado' => 'activo',
            'pagina' => 'p2'
        ],
        [
            'codigo' => 'CAFE-003',
            'nombre' => 'Chorreado de Oriente',
            'descripcion' => 'Café colado en tela con notas de cacao',
            'categoria' => 'Bebidas',
            'categoria_id' => $categorias['Bebidas'],
            'cantidad' => 60,
            'precio' => 2.80,
            'unidades_existentes' => 60,
            'unidades_minimas' => 10,
            'fecha_ingreso' => date('Y-m-d'),
            'estado' => 'activo',
            'pagina' => 'p3'
        ],
        [
            'codigo' => 'CAFE-004',
            'nombre' => 'Paragüitas',
            'descripcion' => 'Café helado con coco rallado y leche de almendras',
            'categoria' => 'Bebidas',
            'categoria_id' => $categorias['Bebidas'],
            'cantidad' => 70,
            'precio' => 3.75,
            'unidades_existentes' => 70,
            'unidades_minimas' => 15,
            'fecha_ingreso' => date('Y-m-d'),
            'estado' => 'activo',
            'pagina' => 'p4'
        ],
        [
            'codigo' => 'CAFE-005',
            'nombre' => 'Café en Piedra',
            'descripcion' => 'Espresso servido sobre una piedra de chocolate para rallar',
            'categoria' => 'Bebidas',
            'categoria_id' => $categorias['Bebidas'],
            'cantidad' => 50,
            'precio' => 4.00,
            'unidades_existentes' => 50,
            'unidades_minimas' => 10,
            'fecha_ingreso' => date('Y-m-d'),
            'estado' => 'activo',
            'pagina' => 'p5'
        ],
        
        // Panadería
        [
            'codigo' => 'PAN-001',
            'nombre' => 'Pan de PANA',
            'descripcion' => 'Pan artesanal con harina de maíz y mantequilla',
            'categoria' => 'Panadería',
            'categoria_id' => $categorias['Panadería'],
            'cantidad' => 50,
            'precio' => 2.50,
            'unidades_existentes' => 50,
            'unidades_minimas' => 15,
            'fecha_ingreso' => date('Y-m-d'),
            'estado' => 'activo',
            'pagina' => 'p6'
        ],
        [
            'codigo' => 'PAN-002',
            'nombre' => 'Cachitos Rebeldes',
            'descripcion' => 'Hojaldre relleno de pernil y queso amarillo',
            'categoria' => 'Panadería',
            'categoria_id' => $categorias['Panadería'],
            'cantidad' => 40,
            'precio' => 3.00,
            'unidades_existentes' => 40,
            'unidades_minimas' => 10,
            'fecha_ingreso' => date('Y-m-d'),
            'estado' => 'activo',
            'pagina' => 'p7'
        ],
        [
            'codigo' => 'PAN-003',
            'nombre' => 'Bollitos Pelones',
            'descripcion' => 'Pan de maíz relleno de caraotas negras',
            'categoria' => 'Panadería',
            'categoria_id' => $categorias['Panadería'],
            'cantidad' => 45,
            'precio' => 2.75,
            'unidades_existentes' => 45,
            'unidades_minimas' => 12,
            'fecha_ingreso' => date('Y-m-d'),
            'estado' => 'activo',
            'pagina' => 'p8'
        ],
        [
            'codigo' => 'PAN-004',
            'nombre' => 'Pan de Queso Llanero',
            'descripcion' => 'Queso de mano derretido en pan campesino',
            'categoria' => 'Panadería',
            'categoria_id' => $categorias['Panadería'],
            'cantidad' => 35,
            'precio' => 3.25,
            'unidades_existentes' => 35,
            'unidades_minimas' => 10,
            'fecha_ingreso' => date('Y-m-d'),
            'estado' => 'activo',
            'pagina' => 'p9'
        ],
        [
            'codigo' => 'PAN-005',
            'nombre' => 'Pan de Coco Punk',
            'descripcion' => 'Coco rallado y panela en masa esponjosa',
            'categoria' => 'Panadería',
            'categoria_id' => $categorias['Panadería'],
            'cantidad' => 30,
            'precio' => 2.80,
            'unidades_existentes' => 30,
            'unidades_minimas' => 8,
            'fecha_ingreso' => date('Y-m-d'),
            'estado' => 'activo',
            'pagina' => 'p10'
        ],
        [
            'codigo' => 'PAN-006',
            'nombre' => 'Palos de Ajo',
            'descripcion' => 'Bastones de pan con ajo y perejil, estilo venezolano',
            'categoria' => 'Panadería',
            'categoria_id' => $categorias['Panadería'],
            'cantidad' => 55,
            'precio' => 2.90,
            'unidades_existentes' => 55,
            'unidades_minimas' => 15,
            'fecha_ingreso' => date('Y-m-d'),
            'estado' => 'activo',
            'pagina' => 'p11'
        ],
        
        // Postres
        [
            'codigo' => 'POST-001',
            'nombre' => 'Mochila de Chocolate',
            'descripcion' => 'Torta negra con relleno de ganache y café',
            'categoria' => 'Postres',
            'categoria_id' => $categorias['Postres'],
            'cantidad' => 25,
            'precio' => 12.50,
            'unidades_existentes' => 25,
            'unidades_minimas' => 5,
            'fecha_ingreso' => date('Y-m-d'),
            'estado' => 'activo',
            'pagina' => 'p12'
        ],
        [
            'codigo' => 'POST-002',
            'nombre' => 'Dulce de Lechosa',
            'descripcion' => 'Lechosa verde en almíbar con especias',
            'categoria' => 'Postres',
            'categoria_id' => $categorias['Postres'],
            'cantidad' => 30,
            'precio' => 8.00,
            'unidades_existentes' => 30,
            'unidades_minimas' => 10,
            'fecha_ingreso' => date('Y-m-d'),
            'estado' => 'activo',
            'pagina' => 'p13'
        ],
        [
            'codigo' => 'POST-003',
            'nombre' => 'Conservas de Coco',
            'descripcion' => 'Dulce tradicional venezolano hecho con coco rallado y azúcar',
            'categoria' => 'Postres',
            'categoria_id' => $categorias['Postres'],
            'cantidad' => 40,
            'precio' => 7.50,
            'unidades_existentes' => 40,
            'unidades_minimas' => 10,
            'fecha_ingreso' => date('Y-m-d'),
            'estado' => 'activo',
            'pagina' => 'p14'
        ],
        [
            'codigo' => 'POST-004',
            'nombre' => 'Torta Mandarinas en Miel',
            'descripcion' => 'Gajos de mandarina caramelizados con anís',
            'categoria' => 'Postres',
            'categoria_id' => $categorias['Postres'],
            'cantidad' => 20,
            'precio' => 14.00,
            'unidades_existentes' => 20,
            'unidades_minimas' => 5,
            'fecha_ingreso' => date('Y-m-d'),
            'estado' => 'activo',
            'pagina' => 'p15'
        ]
    ];

    $agregados = 0;
    $errores = 0;

    foreach ($productosEjemplo as $producto) {
        $query = "INSERT INTO inventario (codigo, nombre, descripcion, categoria_id, precio, pagina, 
                  cantidad, unidades_existentes, unidades_minimas, fecha_ingreso, estado) 
                  VALUES (
                  '".mysqli_real_escape_string($conexion, $producto['codigo'])."',
                  '".mysqli_real_escape_string($conexion, $producto['nombre'])."',
                  '".mysqli_real_escape_string($conexion, $producto['descripcion'])."',
                  ".$producto['categoria_id'].",
                  ".$producto['precio'].",
                  '".$producto['pagina']."',
                  ".$producto['cantidad'].",
                  ".$producto['unidades_existentes'].",
                  ".$producto['unidades_minimas'].",
                  '".$producto['fecha_ingreso']."',
                  '".$producto['estado']."')";

        if (mysqli_query($conexion, $query)) {
            $agregados++;
            
            // Insertar imagen por defecto
            $producto_id = mysqli_insert_id($conexion);
            $imagen_url = "../img/".strtolower($producto['categoria'])."/".$producto['codigo'].".jpg";
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