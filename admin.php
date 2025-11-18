<?php
session_start();

// 🔒 VALIDACIÓN: SOLO ADMIN (rol 2)
if (!isset($_SESSION['id_rol']) || $_SESSION['id_rol'] != 2) {
    header("Location: login.php");
    exit();
}

// 🔹 Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_fuzzion";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// 🔹 Agregar producto
if (isset($_POST['agregar'])) {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $id_categoria = $_POST['id_categoria'];

    // Convertir Sí / No a 1 / 0 sin cambiar el estilo
    $disponible = ($_POST['disponible'] == "Sí") ? 1 : 0;

    $sql = "INSERT INTO productos (nombre, precio, descripcion, id_categoria, disponible) 
            VALUES ('$nombre', '$precio', '$descripcion', '$id_categoria', '$disponible')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Producto agregado correctamente');</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}

// 🔹 Eliminar producto de forma segura
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];

    // 1. Eliminar detalles relacionados
    $conn->query("DELETE FROM detalle_pedido WHERE id_producto=$id");

    // 2. Eliminar producto
    $conn->query("DELETE FROM productos WHERE id_producto=$id");

    header("Location: admin.php");
    exit;
}

// 🔹 Eliminar pedido de forma segura
if (isset($_POST['eliminar_pedido'])) {
    $idPedido = $_POST['id_pedido'];

    // 1. Eliminar detalles
    $conn->query("DELETE FROM detalle_pedido WHERE id_pedido=$idPedido");

    // 2. Eliminar pedido
    $conn->query("DELETE FROM pedidos WHERE id_pedido=$idPedido");

    echo "<script>alert('✅ Pedido eliminado correctamente'); window.location='admin.php';</script>";
    exit;
}

// 🔹 Consultar productos
$resultProductos = $conn->query("SELECT * FROM productos");

// 🔹 Consultar pedidos directamente desde la tabla pedidos
$resultPedidos = $conn->query("SELECT id_pedido, numero_pedido, cliente, productos, total, fecha FROM pedidos ORDER BY fecha DESC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel Administrador - Fuzzion</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { 
      font-family: 'Poppins', sans-serif; 
      background: url('images/banner.jpg') no-repeat center center/cover; 
      min-height: 100vh;
      color: #fff;
      text-shadow: 1px 1px 3px rgba(0,0,0,0.6);
    }
    h2 { margin: 20px 0; color: #ffd54f; font-size: 1.8rem; text-align: center; }
    form { margin-bottom: 20px; text-align: center; }
    input, select, button { 
      padding: 10px; 
      margin: 5px; 
      border-radius: 8px; 
      border: none; 
    }
    table { 
      width: 90%; 
      margin: 20px auto; 
      border-collapse: collapse; 
      background: rgba(255, 255, 255, 0.85); 
      color: #333; 
      border-radius: 12px; 
      overflow: hidden; 
      box-shadow: 0 6px 12px rgba(0,0,0,0.3);
    }
    th, td { padding: 12px; text-align: center; border-bottom: 1px solid #ddd; }
    th { background: #f6a06c; color: #fff; font-weight: bold; }
    tr:hover { background: #ffe0b2; }
    .btn { padding: 6px 12px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; font-size: 0.9rem; }
    .btn-eliminar { background: #e74c3c; color: #fff; }
    .btn-eliminar:hover { background: #c0392b; }
    footer { text-align: center; padding: 20px; margin-top: 40px; background: rgba(246,160,108,0.9); color: #fff; font-weight: bold; }
  </style>
</head>
<body>

  <!-- Inventario -->
  <h2>Gestión de Inventario</h2>
  <form method="POST">
    <input type="text" name="nombre" placeholder="Nombre del producto" required>
    <input type="number" name="precio" placeholder="Precio" required>
    <input type="text" name="descripcion" placeholder="Descripción">
    <input type="number" name="id_categoria" placeholder="ID Categoría">

    <select name="disponible">
      <option value="Sí">Disponible</option>
      <option value="No">No disponible</option>
    </select>

    <button type="submit" name="agregar" class="btn btn-agregar">Agregar Producto</button>
  </form>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Producto</th>
        <th>Precio</th>
        <th>Descripción</th>
        <th>ID Categoría</th>
        <th>Disponible</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = $resultProductos->fetch_assoc()) { ?>
      <tr>
        <td><?= $row['id_producto'] ?></td>
        <td><?= $row['nombre'] ?></td>
        <td>$<?= number_format($row['precio'], 2, '.', ',') ?></td>
        <td><?= $row['descripcion'] ?></td>
        <td><?= $row['id_categoria'] ?></td>
        <td><?= $row['disponible'] == 1 ? "Sí" : "No" ?></td>
        <td>
          <a href="admin.php?eliminar=<?= $row['id_producto'] ?>" class="btn btn-eliminar">Eliminar</a>
        </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>

  <!-- Pedidos -->
  <h2>Gestión de Pedidos</h2>
  <table>
    <thead>
      <tr>
        <th>ID Pedido</th>
        <th>Número Pedido</th>
        <th>Cliente</th>
        <th>Productos</th>
        <th>Total</th>
        <th>Fecha</th>
        <th>Eliminar</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      if ($resultPedidos && $resultPedidos->num_rows > 0) {
        while($pedido = $resultPedidos->fetch_assoc()) { ?>
        <tr>
          <td><?= $pedido['id_pedido'] ?></td>
          <td><?= $pedido['numero_pedido'] ?></td>
          <td><?= $pedido['cliente'] ?></td>
          <td>
            <?= !empty($pedido['productos']) ? $pedido['productos'] : '-' ?>
          </td>
          <td>$<?= number_format($pedido['total'], 2, '.', ',') ?></td>
          <td><?= $pedido['fecha'] ?></td>
          <td>
            <form method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este pedido?');" style="display:inline;">
              <input type="hidden" name="id_pedido" value="<?= $pedido['id_pedido'] ?>">
              <button type="submit" name="eliminar_pedido" class="btn btn-eliminar">Eliminar 🗑️</button>
            </form>
          </td>
        </tr>
      <?php } } else { ?>
        <tr><td colspan="7">No hay pedidos registrados</td></tr>
      <?php } ?>
    </tbody>
  </table>

<footer>© 2025 Fuzzion - Panel Administrador</footer>

</body>
</html>
