
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Fuzzion - Catálogo</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    html, body {
      font-family: 'Poppins', sans-serif;
      min-height: 100vh;
      overflow-x: hidden;
      position: relative;
    }

    /* Fondo con imagen */
    body {
      background: url('images/banner.jpg') center/cover no-repeat fixed;
    }

    /* Capa para opacar un poco */
    body::after {
      content: "";
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.2); /* 🔥 Opacidad suave */
      z-index: -1;
    }

    /* NAVBAR */
    nav {
      background-color: #f6a06c;
      padding: 1rem 2rem;
      position: relative;
      z-index: 1000;
    }
    .nav-container {
      max-width: 1200px;
      margin: auto;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .logo img { height: 100px; width: auto; }
    .nav-links { display: flex; align-items: center; }
    .nav-links a {
      color: white; text-decoration: none; margin-left: 2rem;
      font-weight: bold; font-size: 18px; transition: color 0.3s ease;
    }
    .nav-links a:hover { color: #ffd54f; }
    .menu-toggle { display: none; flex-direction: column; cursor: pointer; gap: 5px; }
    .menu-toggle span { width: 28px; height: 3px; background: white; border-radius: 2px; }

    @media (max-width: 768px) {
      .nav-links {
        position: absolute; top: 90px; left: 0; width: 100%;
        background: #f6a06c; flex-direction: column; align-items: center;
        gap: 1.5rem; padding: 2rem 0;
        border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;
        box-shadow: 0 6px 12px rgba(0,0,0,0.2); display: none;
      }
      .nav-links.active { display: flex; }
      .menu-toggle { display: flex; }
    }

    header {
      background-color: rgba(246, 160, 108, 0.9);
      color: white; text-align: center; padding: 2rem 1rem;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    section {
      padding: 2rem 1rem;
      max-width: 1200px;
      margin: auto;
    }
    section h2 {
      margin-bottom: 1rem;
      color: #d35400;
      border-bottom: 2px solid #f6a06c;
      padding-bottom: 0.5rem;
      background: rgba(255,255,255,0.8);
      display: inline-block;
      border-radius: 8px;
      padding: 5px 15px;
    }

    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
      gap: 1.5rem;
    }

    .producto {
      background-color: rgba(255,255,255,0.9);
      padding: 1.5rem;
      border-radius: 16px;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      text-align: center;
      cursor: pointer;
    }
    .producto:hover {
      transform: translateY(-8px);
      box-shadow: 0 16px 30px rgba(0, 0, 0, 0.2);
    }
    .producto h3 { color: #ffc107; margin-bottom: 0.5rem; }
    .precio { font-weight: bold; color: #388e3c; font-size: 1.1rem; }

    .centrado {
      text-align: center;
      padding: 2rem;
    }
    .boton-comprar {
      display: inline-block;
      background-color: #f8bbd0;
      color: #4a148c;
      font-weight: 600;
      padding: 0.8rem 2rem;
      border: none;
      border-radius: 30px;
      text-decoration: none;
      text-align: center;
      font-size: 1rem;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      transition: all 0.3s ease;
      cursor: pointer;
    }
    .boton-comprar:hover {
      background-color: #f48fb1;
      color: white;
      transform: translateY(-3px);
      box-shadow: 0 6px 14px rgba(0,0,0,0.2);
    }
  </style>
</head>
<body>

  <nav>
    <div class="nav-container">
      <div class="logo">
        <img src="images/logo.png" alt="Fuzzion Logo">
      </div>
      <div class="menu-toggle" id="menu-toggle">
        <span></span><span></span><span></span>
      </div>
      <div class="nav-links" id="nav-links">
        <a href="index.html">Inicio</a>
        <a href="login.php">Registro</a>
        <a href="inventario.php">Inventario</a>
        <a href="sobrenosotros.html">Sobre nosotros</a>
        <a href="terminos_y_condiciones.html">Términos y condiciones</a>
      </div>
    </div>
  </nav>

  <header>
    <h1>Catálogo de Productos - Fuzzion</h1>
  </header>

  <!-- 🍹 Bebidas -->
  <section>
    <h2>🍹 Bebidas</h2>
    <div class="grid">
      <div class="producto"><h3>🥤 Gaseosa Pool</h3><p class="precio">$2.000</p></div>
      <div class="producto"><h3>☕ Tintos</h3><p class="precio">$1.000</p></div>
      <div class="producto"><h3>🥤 Coca Cola</h3><p class="precio">$3.200</p></div>
    </div>
  </section>

  <!-- 🍟 Snacks -->
  <section>
    <h2>🍟 Snacks</h2>
    <div class="grid">
      <div class="producto"><h3>🍟 Papitas Chiss</h3><p class="precio">$600</p></div>
      <div class="producto"><h3>🥔 Papas Limón-Pimienta</h3><p class="precio">$2..500</p></div>
      <div class="producto"><h3>🍌 Platanitos</h3><p class="precio">$1.800</p></div>
      <div class="producto"><h3>🧀 Quesuditos</h3><p class="precio">$1.500</p></div>
    </div>
  </section>

  <!-- 🍬 Dulces -->
  <section>
    <h2>🍬 Dulces</h2>
    <div class="grid">
      <div class="producto"><h3>🍓 Fruticas</h3><p class="precio">$100</p></div>
      <div class="producto"><h3>🍬 Frunas</h3><p class="precio">$100</p></div>
      <div class="producto"><h3>🍃 Chaos</h3><p class="precio">$100</p></div>
      <div class="producto"><h3>🐄 Muu</h3><p class="precio">$600</p></div>
      <div class="producto"><h3>🍭 Candy</h3><p class="precio">$600</p></div>
      <div class="producto"><h3>🍫 Chocodis</h3><p class="precio">$1.000</p></div>
      <div class="producto"><h3>🍬 Gomitas</h3><p class="precio">$2.000</p></div>
      <div class="producto"><h3>🍫 Mini Jumbo</h3><p class="precio">$1.500</p></div>
      <div class="producto"><h3>🍬 Oka Loka</h3><p class="precio">$700</p></div>
      <div class="producto"><h3>🍭 PimPom</h3><p class="precio">$1.000</p></div>
      <div class="producto"><h3>🎉 Revolcón</h3><p class="precio">$200</p></div>
    </div>
  </section>

  <!-- 🥐 Pan y otros -->
  <section>
    <h2>🥐 Pan y Otros</h2>
    <div class="grid">
      <div class="producto"><h3>🍕 Pancerotis</h3><p class="precio">$3.000</p></div>
      <div class="producto"><h3>🧀 Palitos de Queso</h3><p class="precio">$1.700</p></div>
      <div class="producto"><h3>🍩 Rosquillas</h3><p class="precio">$3.000</p></div>
    </div>
  </section>

  <div class="centrado">
    <a href="comprar.php" class="boton-comprar">Ir a Comprar 🛒</a>
  </div>

  <script>
    const menuToggle = document.getElementById("menu-toggle");
    const navLinks = document.getElementById("nav-links");
    menuToggle.addEventListener("click", () => {
      navLinks.classList.toggle("active");
    });
  </script>

</body>
</html>