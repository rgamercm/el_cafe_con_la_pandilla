<?php include 'header.php'; ?>

<main class="cart-page">
    <div class="cart-container">
        <h2>Tu Carrito de Compras</h2>
        <div class="cart-content">
            <ul id="cartItems"></ul>
            <div class="cart-summary">
                <p id="totalPrice">Total: $0.00</p>
                <button id="checkout" disabled>Finalizar Compra</button>
            </div>
        </div>
        <div class="continue-shopping">
            <a href="catalogo.php" class="continue-btn">← Seguir Comprando</a>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>

<script>
// Cargar el carrito al iniciar la página
document.addEventListener('DOMContentLoaded', function() {
    loadCartFromStorage();
    
    // Configurar botón de checkout
    const checkoutButton = document.getElementById('checkout');
    if (checkoutButton) {
        checkoutButton.addEventListener('click', checkout);
    }
});
</script>