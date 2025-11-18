<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Fuzzion - Comprar</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    html, body {
      font-family: 'Poppins', sans-serif;
      min-height: 100vh;
      position: relative;
      overflow-x: hidden;
    }

    body {
      background: url('images/banner.jpg') center/cover no-repeat fixed;
    }

    body::after {
      content: "";
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.25);
      z-index: -1;
    }

    nav { background-color: #f6a06c; padding: 1rem 2rem; position: relative; z-index: 1000; }
    .nav-container { max-width: 1200px; margin: auto; display: flex; align-items: center; justify-content: space-between; }
    .logo img { height: 80px; width: auto; }
    .nav-links { display: flex; align-items: center; gap: 2rem; }
    .nav-links a { color: white; text-decoration: none; font-weight: bold; font-size: 18px; transition: color 0.3s ease; }
    .nav-links a:hover { color: #ffd54f; }

    .menu-toggle { display: none; flex-direction: column; cursor: pointer; gap: 5px; }
    .menu-toggle span { width: 28px; height: 3px; background: white; border-radius: 2px; }

    @media (max-width: 768px) {
      .nav-links {
        position: absolute;
        top: 90px;
        left: 0;
        width: 100%;
        background: #f6a06c;
        flex-direction: column;
        align-items: center;
        gap: 1.5rem;
        padding: 2rem 0;
        border-bottom-left-radius: 20px;
        border-bottom-right-radius: 20px;
        box-shadow: 0 6px 12px rgba(0,0,0,0.2);
        display: none;
      }
      .nav-links.active { display: flex; }
      .menu-toggle { display: flex; }
    }

    header {
      background-color: rgba(255, 177, 124, 0.9);
      color: white; text-align: center;
      padding: 2rem 1rem; box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    section { padding: 2rem 1rem; max-width: 1200px; margin: auto; }
    section h2 { margin-bottom: 1rem; color: #d35400; border-bottom: 2px solid #f6a06c; background: rgba(255,255,255,0.8); display: inline-block; padding: 5px 15px; border-radius: 8px; }
    .productos-grid {
      display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.5rem;
    }
    .producto {
      background: rgba(255,255,255,0.9);
      padding: 1.2rem; border-radius: 16px;
      box-shadow: 0 10px 20px rgba(0,0,0,0.1); text-align: center;
    }
    .producto h3 { color: #ffc107; margin-bottom: 0.5rem; }
    .precio { font-weight: bold; color: #388e3c; margin-bottom: 1rem; }
    .btn-comprar {
      background: #f8bbd0; color: #4a148c; padding: 0.5rem 1rem;
      border: none; border-radius: 30px; font-weight: bold;
      cursor: pointer;
    }
    .btn-comprar:hover { background: #f48fb1; color: white; }

    .carrito-btn {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background: #f6a06c;
      border: none;
      border-radius: 50%;
      width: 60px;
      height: 60px;
      font-size: 28px;
      color: white;
      cursor: pointer;
      box-shadow: 0 6px 12px rgba(0,0,0,0.2);
      z-index: 1000;
    }
    .carrito-btn:hover { background: #ff9800; }

    .carrito {
      position: fixed;
      top: 0;
      right: -100%;
      width: 320px;
      height: 100%;
      background: white;
      box-shadow: -4px 0 10px rgba(0,0,0,0.2);
      padding: 20px;
      transition: right 0.3s ease;
      z-index: 2000;
      display: flex;
      flex-direction: column;
    }
    .carrito.active { right: 0; }
    .carrito h3 { margin-bottom: 15px; color: #d35400; text-align: center; }
    .lista-carrito { list-style: none; margin-bottom: 15px; max-height: 200px; overflow-y: auto; padding: 0; }
    .lista-carrito li { padding: 5px 0; border-bottom: 1px solid #eee; font-size: 14px; }

    .btn-finalizar {
      background: #f8bbd0; color: #4a148c; padding: 0.8rem 1.5rem;
      border: none; border-radius: 30px; font-size: 1rem;
      cursor: pointer; margin-top: 10px;
    }
    .btn-finalizar:hover { background: #f48fb1; color: white; }

    .btn-cerrar {
      background: none;
      border: none;
      font-size: 1rem;
      cursor: pointer;
      color: #d35400;
      margin-bottom: 1rem;
      font-weight: bold;
      text-align: left;
    }
    .btn-cerrar:hover { color: #e74c3c; }
  </style>
</head>
<body>

  <!-- NAVBAR -->
  <nav>
    <div class="nav-container">
      <div class="logo"><img src="images/logo.png" alt="Fuzzion Logo"></div>
      <div class="menu-toggle" id="menu-toggle"><span></span><span></span><span></span></div>
      <div class="nav-links" id="nav-links">
        <a href="index.html">Inicio</a>
        <a href="login.php">Registro</a>
        <a href="comprar.php">Compra</a>
        <a href="sobrenosotros.html">Sobre nosotros</a>
        <a href="terminos_y_condiciones.html">Términos y condiciones</a>
      </div>
    </div>
  </nav>

  <header><h1>Compra de Productos - Fuzzion</h1></header>

  <!-- 🍹 BEBIDAS -->
  <section>
    <h2>🍹 Bebidas</h2>
    <div class="productos-grid">
      <div class="producto" data-disponible="Sí"><h3>🥤 Gaseosa Pool</h3><p class="precio" data-precio="2000">$2.000</p><button class="btn-comprar">Comprar 🛒</button></div>
      <div class="producto" data-disponible="Sí"><h3>☕ Tintos</h3><p class="precio" data-precio="1000">$1.000</p><button class="btn-comprar">Comprar 🛒</button></div>
      <div class="producto" data-disponible="Sí"><h3>🥤 Coca Cola</h3><p class="precio" data-precio="3200">$3.200</p><button class="btn-comprar">Comprar 🛒</button></div>
    </div>
  </section>

  <!-- 🍟 SNACKS -->
  <section>
    <h2>🍟 Snacks</h2>
    <div class="productos-grid">
      <div class="producto" data-disponible="Sí"><h3>🍟 Papitas Chiss</h3><p class="precio" data-precio="600">$600</p><button class="btn-comprar">Comprar 🛒</button></div>
      <div class="producto" data-disponible="Sí"><h3>🥔 Papas Limón-Pimienta</h3><p class="precio" data-precio="2500">$2.500</p><button class="btn-comprar">Comprar 🛒</button></div>
      <div class="producto" data-disponible="Sí"><h3>🍌 Platanitos</h3><p class="precio" data-precio="1800">$1.800</p><button class="btn-comprar">Comprar 🛒</button></div>
      <div class="producto" data-disponible="Sí"><h3>🧀 Quesuditos</h3><p class="precio" data-precio="1500">$1.500</p><button class="btn-comprar">Comprar 🛒</button></div>
    </div>
  </section>

  <!-- 🍬 DULCES -->
  <section>
    <h2>🍬 Dulces</h2>
    <div class="productos-grid">
      <div class="producto" data-disponible="Sí"><h3>🍓 Fruticas</h3><p class="precio" data-precio="100">$100</p><button class="btn-comprar">Comprar 🛒</button></div>
      <div class="producto" data-disponible="Sí"><h3>🍬 Frunas</h3><p class="precio" data-precio="100">$100</p><button class="btn-comprar">Comprar 🛒</button></div>
      <div class="producto" data-disponible="Sí"><h3>🍃 Chaos</h3><p class="precio" data-precio="100">$100</p><button class="btn-comprar">Comprar 🛒</button></div>
      <div class="producto" data-disponible="Sí"><h3>🐄 Muu</h3><p class="precio" data-precio="600">$600</p><button class="btn-comprar">Comprar 🛒</button></div>
      <div class="producto" data-disponible="Sí"><h3>🍭 Candy</h3><p class="precio" data-precio="600">$600</p><button class="btn-comprar">Comprar 🛒</button></div>
      <div class="producto" data-disponible="Sí"><h3>🍫 Chocodis</h3><p class="precio" data-precio="1000">$1.000</p><button class="btn-comprar">Comprar 🛒</button></div>
      <div class="producto" data-disponible="Sí"><h3>🍬 Gomitas</h3><p class="precio" data-precio="2000">$2.000</p><button class="btn-comprar">Comprar 🛒</button></div>
      <div class="producto" data-disponible="Sí"><h3>🍫 Mini Jumbo</h3><p class="precio" data-precio="1500">$1.500</p><button class="btn-comprar">Comprar 🛒</button></div>
      <div class="producto" data-disponible="Sí"><h3>🍬 Oka Loka</h3><p class="precio" data-precio="700">$700</p><button class="btn-comprar">Comprar 🛒</button></div>
      <div class="producto" data-disponible="Sí"><h3>🍭 PimPom</h3><p class="precio" data-precio="1000">$1.000</p><button class="btn-comprar">Comprar 🛒</button></div>
      <div class="producto" data-disponible="Sí"><h3>🎉 Revolcón</h3><p class="precio" data-precio="200">$200</p><button class="btn-comprar">Comprar 🛒</button></div>
    </div>
  </section>

  <!-- 🥐 PAN Y OTROS -->
  <section>
    <h2>🥐 Pan y Otros</h2>
    <div class="productos-grid">
      <div class="producto" data-disponible="Sí"><h3>🍕 Pancerotis</h3><p class="precio" data-precio="3000">$3.000</p><button class="btn-comprar">Comprar 🛒</button></div>
      <div class="producto" data-disponible="Sí"><h3>🧀 Palitos de Queso</h3><p class="precio" data-precio="1700">$1.700</p><button class="btn-comprar">Comprar 🛒</button></div>
      <div class="producto" data-disponible="Sí"><h3>🍩 Rosquillas</h3><p class="precio" data-precio="3000">$3.000</p><button class="btn-comprar">Comprar 🛒</button></div>
    </div>
  </section>

  <!-- Botón carrito -->
  <button class="carrito-btn" id="carritoBtn">🛒</button>

  <!-- Panel carrito -->
  <div class="carrito" id="carritoPanel">
    <button id="cerrarCarrito" class="btn-cerrar">⬅️ Volver</button>
    <h3>Mi Carrito</h3>
    <ul id="listaCarrito" class="lista-carrito"></ul>
    <p><strong>Total:</strong> $<span id="total">0</span></p>
    <form id="formPedido" action="gracias.php" method="POST">
      <input type="hidden" name="productos" id="productos">
      <input type="hidden" name="total" id="totalInput">
      <button type="submit" class="btn-finalizar">Confirmar Pedido ✅</button>
    </form>
  </div>

<script>
const botones = document.querySelectorAll(".btn-comprar");
const totalSpan = document.getElementById("total");
const totalInput = document.getElementById("totalInput");
const productosInput = document.getElementById("productos");
const listaCarrito = document.getElementById("listaCarrito");

let total = 0;
let listaProductos = [];

// ✅ Bloquea productos no disponibles
botones.forEach(boton => {
  boton.addEventListener("click", () => {
    const disponible = boton.parentElement.getAttribute("data-disponible");
    if (disponible === "No") {
      alert("❌ Este producto no está disponible actualmente.");
      return;
    }

    const nombre = boton.parentElement.querySelector("h3").innerText;
    const precio = parseInt(boton.parentElement.querySelector(".precio").dataset.precio);

    total += precio;
    totalSpan.textContent = total;
    totalInput.value = total;

    listaProductos.push(nombre + " ($" + precio + ")");
    productosInput.value = listaProductos.join(", ");

    const li = document.createElement("li");
    li.textContent = nombre + " - $" + precio;
    listaCarrito.appendChild(li);
  });
});

// Carrito
const carritoBtn = document.getElementById("carritoBtn");
const carritoPanel = document.getElementById("carritoPanel");
const cerrarCarrito = document.getElementById("cerrarCarrito");

carritoBtn.addEventListener("click", () => carritoPanel.classList.add("active"));
cerrarCarrito.addEventListener("click", () => carritoPanel.classList.remove("active"));

// Menú
const menuToggle = document.getElementById("menu-toggle");
const navLinks = document.getElementById("nav-links");
menuToggle.addEventListener("click", () => navLinks.classList.toggle("active"));
</script>

</body>
</html>
