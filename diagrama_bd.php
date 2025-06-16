<?php
include('conexion.php');
include('header.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Estructura de Base de Datos - Panadería</title>
  <script src="https://cdn.jsdelivr.net/npm/mermaid@10/dist/mermaid.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <link rel="stylesheet" href="style.css">
  <style>
    /* Estilos específicos para el diagrama de BD */
    .mermaid {
      background: white;
      padding: 20px;
      border-radius: 8px;
      border: 1px solid #ffa07a;
      margin: 20px auto;
      max-width: 900px;
    }
    
    .info-box {
      background: #fff9f5;
      border: 1px solid #ffa07a;
      padding: 15px;
      margin: 20px auto;
      max-width: 800px;
      border-radius: 8px;
      box-shadow: 0 0 10px #ffd8c2;
      animation: fadeIn 1.5s;
    }
    
    .controls {
      text-align: center;
      margin: 15px 0;
    }
    
    .controls button {
      background: #ffa07a;
      border: none;
      padding: 8px 15px;
      margin: 0 5px;
      border-radius: 5px;
      cursor: pointer;
      transition: all 0.3s;
    }
    
    .controls button:hover {
      background: #ff8c61;
    }
    
    .table-info {
      margin-top: 30px;
      width: 100%;
      border-collapse: collapse;
    }
    
    .table-info th, .table-info td {
      border: 1px solid #ffa07a;
      padding: 8px;
      text-align: left;
    }
    
    .table-info th {
      background-color: #ffd8c2;
    }
    
    .table-info tr:nth-child(even) {
      background-color: #fff9f5;
    }
    
    .error-box {
      background: #ffebee;
      border: 1px solid #ffcdd2;
      padding: 15px;
      margin: 20px auto;
      max-width: 800px;
      border-radius: 8px;
      color: #c62828;
    }
  </style>
</head>
<body>
  <div class="content-wrapper">
    <h1 class="animate__animated animate__fadeInDown">Estructura de la Base de Datos</h1>
    
    <div class="controls">
      <button onclick="location.reload()">Actualizar Diagrama</button>
      <button onclick="toggleTables()">Mostrar/Ocultar Detalles</button>
    </div>
    
    <div class="mermaid" id="mermaidDiagram">
      <?php
      // Función para limpiar nombres para Mermaid
      function cleanForMermaid($str) {
        return preg_replace('/[^a-zA-Z0-9_]/', '_', $str);
      }
      
      try {
        // Obtener información de las tablas
        $tables = $conn->query("SHOW TABLES");
        $mermaidCode = "erDiagram\n";
        
        while ($table = $tables->fetch_array()) {
          $tableName = cleanForMermaid($table[0]);
          $mermaidCode .= "    $tableName {\n";
          
          // Obtener columnas de cada tabla
          $columns = $conn->query("SHOW COLUMNS FROM `{$table[0]}`");
          while ($column = $columns->fetch_assoc()) {
            $field = cleanForMermaid($column['Field']);
            $type = cleanForMermaid($column['Type']);
            $key = '';
            if ($column['Key'] == 'PRI') $key = ' PK';
            if ($column['Key'] == 'MUL') $key = ' FK';
            $mermaidCode .= "      $field $type$key\n";
          }
          $mermaidCode .= "    }\n";
        }
        
        // Obtener relaciones (claves foráneas)
        $relations = $conn->query("
          SELECT 
            TABLE_NAME, 
            COLUMN_NAME, 
            REFERENCED_TABLE_NAME, 
            REFERENCED_COLUMN_NAME 
          FROM 
            INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
          WHERE 
            REFERENCED_TABLE_SCHEMA = '$database' 
            AND REFERENCED_TABLE_NAME IS NOT NULL
        ");
        
        while ($rel = $relations->fetch_assoc()) {
          $table1 = cleanForMermaid($rel['TABLE_NAME']);
          $table2 = cleanForMermaid($rel['REFERENCED_TABLE_NAME']);
          $col1 = cleanForMermaid($rel['COLUMN_NAME']);
          $col2 = cleanForMermaid($rel['REFERENCED_COLUMN_NAME']);
          $mermaidCode .= "    $table1 ||--o{ $table2 : \"$col1 → $col2\"\n";
        }
        
        echo htmlspecialchars($mermaidCode);
      } catch (Exception $e) {
        echo "<div class='error-box'>Error al generar el diagrama: " . htmlspecialchars($e->getMessage()) . "</div>";
      }
      ?>
    </div>
    
    <div class="info-box animate__animated animate__fadeInUp" id="tablesInfo" style="display: none;">
      <h3>Detalles de las Tablas</h3>
      <?php
      $tables = $conn->query("SHOW TABLES");
      while ($table = $tables->fetch_array()) {
        $tableName = $table[0];
        echo "<h4>Tabla: $tableName</h4>";
        echo "<table class='table-info'>";
        echo "<tr><th>Campo</th><th>Tipo</th><th>Nulo</th><th>Clave</th><th>Predeterminado</th><th>Extra</th></tr>";
        
        $columns = $conn->query("SHOW COLUMNS FROM `$tableName`");
        while ($column = $columns->fetch_assoc()) {
          echo "<tr>";
          echo "<td>{$column['Field']}</td>";
          echo "<td>{$column['Type']}</td>";
          echo "<td>{$column['Null']}</td>";
          echo "<td>{$column['Key']}</td>";
          echo "<td>{$column['Default']}</td>";
          echo "<td>{$column['Extra']}</td>";
          echo "</tr>";
        }
        echo "</table><br>";
      }
      ?>
    </div>
    
    <div class="info-box animate__animated animate__fadeInUp">
      <h3>¿Cómo interpretar este diagrama?</h3>
      <p>Este diagrama ER (Entidad-Relación) muestra la estructura completa de tu base de datos:</p>
      <ul>
        <li><strong>Rectángulos:</strong> Representan tablas</li>
        <li><strong>Líneas:</strong> Indican relaciones entre tablas</li>
        <li><strong>PK:</strong> Primary Key (Clave Primaria)</li>
        <li><strong>FK:</strong> Foreign Key (Clave Foránea)</li>
      </ul>
      <p>Puedes hacer clic en el botón "Mostrar/Ocultar Detalles" para ver información técnica detallada de cada tabla.</p>
    </div>
  </div>

  <script>
    // Función para inicializar Mermaid con manejo de errores
    function initMermaid() {
      try {
        mermaid.initialize({ 
          startOnLoad: true,
          theme: 'default',
          flowchart: { 
            useMaxWidth: true,
            htmlLabels: true 
          },
          er: {
            diagramPadding: 20,
            layoutDirection: 'TB'
          }
        });
        
        // Forzar renderizado después de un pequeño retraso
        setTimeout(() => {
          mermaid.init(undefined, '#mermaidDiagram');
        }, 100);
      } catch (e) {
        console.error("Error al inicializar Mermaid:", e);
        document.getElementById('mermaidDiagram').innerHTML = 
          '<div class="error-box">Error al renderizar el diagrama: ' + e.message + '</div>';
      }
    }
    
    // Inicializar Mermaid cuando el DOM esté listo
    document.addEventListener('DOMContentLoaded', initMermaid);
    
    function toggleTables() {
      const infoDiv = document.getElementById('tablesInfo');
      infoDiv.style.display = infoDiv.style.display === 'none' ? 'block' : 'none';
    }
  </script>

<?php include('footer.php'); ?>
</body>
</html>