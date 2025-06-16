// script.js
let cart = [];
let total = 0;

// Referencias a elementos del DOM
const addToCartButton = document.getElementById("addToCart");
const cartItems = document.getElementById("cartItems");
const totalPrice = document.getElementById("totalPrice");
const checkoutButton = document.getElementById("checkout");

// Función para añadir un producto al carrito
addToCartButton.addEventListener("click", () => {
  const product = {
    name: "Pan Artesanal",
    price: 3.60
  };

  cart.push(product);
  total += product.price;

  updateCart();
});

// Función para actualizar el carrito en la interfaz
function updateCart() {
  // Limpiar el carrito actual
  cartItems.innerHTML = "";

  // Mostrar los productos en el carrito
  cart.forEach((item, index) => {
    const li = document.createElement("li");
    li.textContent = `${item.name} - $${item.price.toFixed(2)}`;

    // Crear botón de eliminar
    const removeButton = document.createElement("button");
    removeButton.textContent = "Eliminar";
    removeButton.style.marginLeft = "10px";
    removeButton.addEventListener("click", () => removeFromCart(index));

    li.appendChild(removeButton);
    cartItems.appendChild(li);
  });

  // Actualizar el precio total
  totalPrice.textContent = `Total: $${total.toFixed(2)}`;

  // Habilitar o deshabilitar el botón de finalizar compra
  checkoutButton.disabled = cart.length === 0;
}

// Función para eliminar un producto del carrito
function removeFromCart(index) {
  total -= cart[index].price; // Restar el precio del producto eliminado
  cart.splice(index, 1); // Eliminar el producto del carrito
  updateCart(); // Actualizar la interfaz
}

// Función para finalizar la compra
checkoutButton.addEventListener("click", () => {
  if (cart.length > 0) {
    alert("¡Gracias por tu compra!");
    cart = [];
    total = 0;
    updateCart();
  }
});