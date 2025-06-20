<!DOCTYPE html>
<html lang="en">

<head>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El Café Con La Pan-dilla</title>
    <link rel="shortcut icon" href="img/cafe.png" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
      href="https://fonts.googleapis.com/css2?family=Imperial+Script&family=Lobster&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap"
      rel="stylesheet">
  </head>
</head>

<body>
    <header class="header">
        <div class="header-container">
            <div class="logo">
                <img src="img/cafe/cafe.png" alt="Logotipo" class="logo-image">
            </div>
            
            <h1 class="header-title">El Café Con La Pan-dilla</h1>
            
            <div class="header-controls">
                <button class="theme-toggle" id="themeToggle">🌙</button>
                
                <!-- Icono del carrito mejorado -->
                <a href="carrito.php" class="cart-icon">
                    <img src="img/cart-icon.png" alt="Carrito de compras">
                    <span id="cartCounter">0</span>
                </a>
            </div>
        </div>

        <nav class="nav">
            <a href="index.php" class="nav-link active"><span>Inicio</span></a>
            <a href="catalogo.php" class="nav-link">Productos</a>
            <a href="nosotros.php" class="nav-link">Nosotros</a>
            <a href="registrar.php" class="nav-link">Registrarse</a>
            <a href="diagrama_procesos.php" class="nav-link">Flujo Productos</a>
            <a href="diagrama_bd.php" class="nav-link">Estructura BD</a>
        </nav>
    </header>
  <main>
    <div class="titulocard">
      <h2>Compra lo mejor</h2>
      <div class="card-container">
        <div class="card">
          <h2>Café Expreso</h2><a href="p3.php"> <img src="img/cafe/coffee (4).jpg" alt="Imagen 4"></a>
          <div class="card-text">
            <p>Precio: <strong>$1.80</strong></p>
            <button id="addToCart">Añadir al carrito</button>
          </div>
        </div>
        <section class="cart">
          <h2>Carrito de Compras</h2>
          <ul id="cartItems">
          </ul>
          <p id="totalPrice">Total: $0.00</p>
          <button id="checkout" disabled>Finalizar Compra</button>
        </section>


  </main>
  <footer class="footer">
    <div class="footer-content">
        <p>2024 El Café Con La Pan-dilla C.A<br>Todos los Derechos Reservados.</p>
        <p>Contactos<br>Tlf: +58-4244258944<br>Correo: cg9477083@gmail.com 
        </p>
        <div class="social-media">
            <a href="https://www.facebook.com/profile.php?id=100089772800592" class="social-link">Facebook</a>
            <a href="https://www.instagram.com/carlosgz9477/" class="social-link">Instagram</a>
            <a href="https://github.com/NoobCoderMaster69" class="social-link">Github</a>
        </div>
    </div>
</footer>
  <script src="js/carrito3.js"></script>
  <script src="js/style.js"></script>

</body>

</html>