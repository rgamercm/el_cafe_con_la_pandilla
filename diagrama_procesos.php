<?php
include('conexion.php');
include('header.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Diagrama de Flujo de Procesos - Panadería</title>
  <script src="https://cdn.jsdelivr.net/npm/vis-network@9.1.2/dist/vis-network.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <link rel="stylesheet" href="style.css">
  <style>
    /* Estilos específicos para el diagrama */
    #network {
      width: 100%;
      height: 600px;
      border: 1px solid #ffa07a;
      border-radius: 8px;
      background: white;
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
    .node-tooltip {
      position: absolute;
      background: white;
      padding: 10px;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0,0,0,0.2);
      max-width: 300px;
      display: none;
      z-index: 100;
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
  </style>
</head>
<body>
  <div class="content-wrapper">
    <h1 class="animate__animated animate__fadeInDown">Diagrama de Flujo de Procesos</h1>
    
    <div class="controls">
      <button id="zoomIn">+ Zoom</button>
      <button id="zoomOut">- Zoom</button>
      <button id="centerView">Centrar Vista</button>
      <button id="animate">Animación</button>
    </div>
    
    <div id="network"></div>
    
    <div class="info-box animate__animated animate__fadeInUp">
      <h3>¿Cómo interpretar este diagrama?</h3>
      <p>Este diagrama muestra el flujo de productos en tu panadería:</p>
      <ul>
        <li><strong>Nodos azules:</strong> Representan productos</li>
        <li><strong>Nodos verdes:</strong> Representan usuarios/roles</li>
        <li><strong>Flechas naranjas:</strong> Indican entradas de productos</li>
        <li><strong>Flechas rojas:</strong> Indican salidas de productos</li>
      </ul>
      <p>Haz clic en cualquier nodo o flecha para ver detalles. Puedes arrastrar los nodos para reorganizar el diagrama.</p>
    </div>
    
    <div class="node-tooltip" id="nodeTooltip"></div>
  </div>

  <script>
    // Contenedor para el diagrama
    const container = document.getElementById('network');
    
    // Obtener datos desde PHP
    fetch('diagrama_data.php')
      .then(response => response.json())
      .then(data => {
        // Procesar datos para vis.js
        const nodes = new vis.DataSet();
        const edges = new vis.DataSet();
        const nodeIds = new Set();
        
        // Agregar nodos para productos y usuarios
        data.forEach(movimiento => {
          // Nodo para el producto
          if (!nodeIds.has(`producto_${movimiento.producto}`)) {
            nodes.add({
              id: `producto_${movimiento.producto}`,
              label: movimiento.producto,
              title: `${movimiento.producto}\n${movimiento.descripcion}`,
              color: {
                background: '#6fa8dc',
                border: '#3d85c6',
                highlight: { background: '#6fa8dc', border: '#2b78d8' }
              },
              shape: 'box',
              font: { size: 14 },
              margin: 10
            });
            nodeIds.add(`producto_${movimiento.producto}`);
          }
          
          // Nodo para el usuario/rol
          if (!nodeIds.has(`usuario_${movimiento.usuario}`)) {
            nodes.add({
              id: `usuario_${movimiento.usuario}`,
              label: `${movimiento.usuario}\n(${movimiento.rol})`,
              title: `${movimiento.usuario}\nRol: ${movimiento.rol}`,
              color: {
                background: '#93c47d',
                border: '#6aa84f',
                highlight: { background: '#93c47d', border: '#4a8c2b' }
              },
              shape: 'ellipse',
              font: { size: 12 },
              margin: 8
            });
            nodeIds.add(`usuario_${movimiento.usuario}`);
          }
          
          // Crear conexión (flecha)
          if (movimiento.tipo === 'entrada') {
            edges.add({
              from: `usuario_${movimiento.usuario}`,
              to: `producto_${movimiento.producto}`,
              label: `+${movimiento.cantidad}`,
              title: `Entrada de ${movimiento.cantidad} unidades\nFecha: ${movimiento.fecha}`,
              color: { color: '#e69138', highlight: '#f1c232' },
              arrows: 'to',
              smooth: { type: 'curvedCW', roundness: 0.2 },
              font: { size: 12, strokeWidth: 0 }
            });
          } else {
            edges.add({
              from: `producto_${movimiento.producto}`,
              to: `usuario_${movimiento.usuario}`,
              label: `-${movimiento.cantidad}`,
              title: `Salida de ${movimiento.cantidad} unidades\nFecha: ${movimiento.fecha}`,
              color: { color: '#cc0000', highlight: '#ff3333' },
              arrows: 'to',
              smooth: { type: 'curvedCW', roundness: 0.2 },
              font: { size: 12, strokeWidth: 0 }
            });
          }
        });
        
        // Configuración del diagrama
        const options = {
          nodes: {
            shadow: true,
            size: 30,
            borderWidth: 2
          },
          edges: {
            width: 2,
            shadow: true,
            smooth: {
              type: 'continuous'
            },
            font: {
              align: 'middle'
            }
          },
          physics: {
            enabled: true,
            solver: 'forceAtlas2Based',
            forceAtlas2Based: {
              gravitationalConstant: -50,
              centralGravity: 0.01,
              springLength: 100,
              springConstant: 0.08,
              damping: 0.4
            },
            stabilization: {
              iterations: 1000
            }
          },
          interaction: {
            hover: true,
            tooltipDelay: 200,
            hideEdgesOnDrag: true
          },
          layout: {
            improvedLayout: true
          }
        };
        
        // Crear la red
        const network = new vis.Network(container, { nodes, edges }, options);
        
        // Mostrar tooltip personalizado
        network.on("click", function(params) {
          const tooltip = document.getElementById('nodeTooltip');
          tooltip.style.display = 'none';
          
          if (params.nodes.length > 0) {
            const nodeId = params.nodes[0];
            const node = nodes.get(nodeId);
            tooltip.innerHTML = `<strong>${node.label}</strong><br>${node.title}`;
            tooltip.style.display = 'block';
            tooltip.style.left = params.pointer.DOM.x + 'px';
            tooltip.style.top = params.pointer.DOM.y + 'px';
          } else if (params.edges.length > 0) {
            const edgeId = params.edges[0];
            const edge = edges.get(edgeId);
            tooltip.innerHTML = `<strong>Movimiento:</strong><br>${edge.title}`;
            tooltip.style.display = 'block';
            tooltip.style.left = params.pointer.DOM.x + 'px';
            tooltip.style.top = params.pointer.DOM.y + 'px';
          }
        });
        
        // Ocultar tooltip al mover el mouse
        network.on("blurNode", function() {
          document.getElementById('nodeTooltip').style.display = 'none';
        });
        
        // Controles de zoom
        document.getElementById('zoomIn').onclick = function() {
          network.moveTo({ scale: network.getScale() * 1.3 });
        };
        
        document.getElementById('zoomOut').onclick = function() {
          network.moveTo({ scale: network.getScale() / 1.3 });
        };
        
        document.getElementById('centerView').onclick = function() {
          network.fit({ animation: { duration: 1000 } });
        };
        
        document.getElementById('animate').onclick = function() {
          network.startSimulation();
          setTimeout(() => network.stopSimulation(), 3000);
        };
        
        // Animación inicial
        setTimeout(() => {
          network.startSimulation();
          setTimeout(() => network.stopSimulation(), 2000);
        }, 500);
      })
      .catch(error => console.error('Error al cargar los datos:', error));
  </script>

<?php include('footer.php'); ?>
</body>
</html>