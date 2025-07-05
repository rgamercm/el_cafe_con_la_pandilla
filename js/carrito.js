let cart = [];
let total = 0;

// Función para añadir producto al carrito
function addToCart(product) {
  cart.push(product);
  total += product.price;
  updateCart();
  saveCartToStorage();
  alert(`${product.name} añadido al carrito`);
}

// Actualizar visualización del carrito
function updateCart() {
  const cartItems = document.getElementById("cartItems");
  const totalPrice = document.getElementById("totalPrice");
  const checkoutButton = document.getElementById("checkout");
  const cartCounter = document.getElementById("cartCounter");

  if (cartItems) cartItems.innerHTML = "";
  
  cart.forEach((item, index) => {
    const li = document.createElement("li");
    li.className = "cart-item";
    li.innerHTML = `
      <span class="item-name">${item.name}</span>
      <span class="item-price">$${item.price.toFixed(2)}</span>
      <button class="remove-btn" onclick="removeFromCart(${index})">×</button>
    `;
    if (cartItems) cartItems.appendChild(li);
  });

  if (totalPrice) totalPrice.textContent = `Total: $${total.toFixed(2)}`;
  if (checkoutButton) checkoutButton.disabled = cart.length === 0;
  if (cartCounter) cartCounter.textContent = cart.length;
}

// Eliminar producto del carrito
function removeFromCart(index) {
  total -= cart[index].price;
  cart.splice(index, 1);
  updateCart();
  saveCartToStorage();
}

// Finalizar compra
function checkout() {
  if (cart.length > 0) {
    alert("¡Gracias por tu compra!");
    cart = [];
    total = 0;
    updateCart();
    localStorage.removeItem("cart");
    localStorage.removeItem("cartTotal");
  }
}

// Guardar en localStorage
function saveCartToStorage() {
  localStorage.setItem("cart", JSON.stringify(cart));
  localStorage.setItem("cartTotal", total.toString());
}

// Cargar carrito al iniciar
function loadCartFromStorage() {
  const savedCart = localStorage.getItem("cart");
  const savedTotal = localStorage.getItem("cartTotal");
  
  if (savedCart) {
    cart = JSON.parse(savedCart);
    total = parseFloat(savedTotal) || 0;
    updateCart();
  }
}

// Inicialización
document.addEventListener("DOMContentLoaded", () => {
  loadCartFromStorage();
  
  const checkoutButton = document.getElementById("checkout");
  if (checkoutButton) {
    checkoutButton.addEventListener("click", checkout);
  }
});