<?php
require_once 'conexion_be.php';

function obtenerProductoPorPagina($pagina) {
    global $conexion;
    
    $query = "SELECT i.*, c.nombre as categoria_nombre 
              FROM inventario i
              LEFT JOIN categorias c ON i.categoria_id = c.id
              WHERE i.pagina = '$pagina' AND i.estado = 'activo' 
              LIMIT 1";
    $result = mysqli_query($conexion, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $producto = mysqli_fetch_assoc($result);
        $producto['disponible'] = ($producto['unidades_existentes'] > 0);
        
        // Normalizar nombre de categoría para la ruta
        $categoria = strtolower($producto['categoria_nombre']);
        $categoria = str_replace(
            ['á', 'é', 'í', 'ó', 'ú', 'ñ'],
            ['a', 'e', 'i', 'o', 'u', 'n'],
            $categoria
        );
        
        // Construir ruta de imagen
        $imagen_ruta = "img/$categoria/" . $producto['codigo'] . ".jpg";
        
        // Verificar si existe la imagen específica
        if (file_exists($imagen_ruta)) {
            $producto['imagen'] = $imagen_ruta;
        } 
        // Si no existe, buscar imagen principal en la base de datos
        else {
            $query_img = "SELECT url_imagen FROM imagenes_producto 
                          WHERE producto_id = {$producto['id']} AND es_principal = TRUE
                          LIMIT 1";
            $result_img = mysqli_query($conexion, $query_img);
            
            if ($result_img && mysqli_num_rows($result_img) > 0) {
                $imagen = mysqli_fetch_assoc($result_img);
                $producto['imagen'] = $imagen['url_imagen'];
            } 
            // Si no hay imagen en BD, usar default
            else {
                $producto['imagen'] = "img/cafe/default.jpg";
            }
        }
        
        return $producto;
    }
    
    return null;
}

function verificarDisponibilidad($producto_id, $cantidad_deseada = 1) {
    global $conexion;
    
    $query = "SELECT unidades_existentes FROM inventario 
              WHERE id = $producto_id AND estado = 'activo'
              FOR UPDATE";
    
    $result = mysqli_query($conexion, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $producto = mysqli_fetch_assoc($result);
        return [
            'disponible' => $producto['unidades_existentes'] >= $cantidad_deseada,
            'existencias' => $producto['unidades_existentes']
        ];
    }
    
    return ['disponible' => false, 'existencias' => 0];
}

function obtenerCategorias() {
    global $conexion;
    
    $query = "SELECT * FROM categorias ORDER BY nombre";
    $result = mysqli_query($conexion, $query);
    
    $categorias = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $categorias[] = $row;
        }
    }
    
    return $categorias;
}

function obtenerProductoPorId($id) {
    global $conexion;
    
    $query = "SELECT i.*, c.nombre as categoria_nombre 
              FROM inventario i
              LEFT JOIN categorias c ON i.categoria_id = c.id
              WHERE i.id = $id 
              LIMIT 1";
    $result = mysqli_query($conexion, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $producto = mysqli_fetch_assoc($result);
        
        // Normalizar categoría para ruta de imágenes
        $categoria = strtolower($producto['categoria_nombre']);
        $categoria = str_replace(
            ['á', 'é', 'í', 'ó', 'ú', 'ñ'],
            ['a', 'e', 'i', 'o', 'u', 'n'],
            $categoria
        );
        
        // Obtener todas las imágenes del producto
        $query_img = "SELECT * FROM imagenes_producto WHERE producto_id = $id";
        $result_img = mysqli_query($conexion, $query_img);
        
        $producto['imagenes'] = [];
        if ($result_img && mysqli_num_rows($result_img) > 0) {
            while ($img = mysqli_fetch_assoc($result_img)) {
                // Si la imagen no tiene ruta absoluta, construirla según categoría
                if (!filter_var($img['url_imagen'], FILTER_VALIDATE_URL)) {
                    $img_ruta = "img/$categoria/" . basename($img['url_imagen']);
                    if (file_exists($img_ruta)) {
                        $img['url_imagen'] = $img_ruta;
                    }
                }
                $producto['imagenes'][] = $img;
            }
        }
        
        // Si no hay imágenes, usar imagen por defecto
        if (empty($producto['imagenes'])) {
            $default_img = "img/cafe/default.jpg";
            $producto['imagenes'][] = [
                'url_imagen' => $default_img,
                'es_principal' => true
            ];
        }
        
        return $producto;
    }
    
    return null;
}
?>