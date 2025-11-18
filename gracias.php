 <?php
session_start();
include('conexion.php');

// 📅 Definir zona horaria y fecha
date_default_timezone_set('America/Bogota');
$fecha_actual = date('d/m/Y H:i');

// Variables iniciales
$numero_pedido = $cliente_nombre = $total = '';
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $total = $_POST['total'];
    $productos_str = $_POST['productos']; 
    $cliente_nombre = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : 'Invitado';

    $numero_pedido = 'FZ-' . rand(1000, 9999);

    // Insertar pedido en la tabla pedidos usando la columna correcta
    $sql_pedido = "INSERT INTO pedidos (numero_pedido, cliente, total, fecha)
                   VALUES ('$numero_pedido', '$cliente_nombre', '$total', NOW())";

    if (mysqli_query($conexion, $sql_pedido)) {
        $pedido_id = mysqli_insert_id($conexion); // ID del pedido recién insertado

        // Separar los productos
        $productos_arr = explode(',', $productos_str);
        foreach ($productos_arr as $prod) {
            // Extraer nombre y precio usando expresión regular
            if (preg_match('/(.+?) \(\$(\d+)\)/', trim($prod), $matches)) {
                $nombre_producto = $matches[1];
                $precio = $matches[2];

                // Obtener id_producto desde la tabla productos
                $res = mysqli_query($conexion, "SELECT id_producto FROM productos WHERE nombre_producto = '$nombre_producto' LIMIT 1");
                if ($res && mysqli_num_rows($res) > 0) {
                    $row = mysqli_fetch_assoc($res);
                    $id_producto = $row['id_producto'];

                    // Insertar en detalle_pedido
                    mysqli_query($conexion, "INSERT INTO detalle_pedido (id_pedido, id_producto, precio, cantidad)
                                             VALUES ($pedido_id, $id_producto, $precio, 1)");
                }
            }
        }

        $mensaje = "✅ Tu pedido fue registrado correctamente.";
    } else {
        $mensaje = "❌ Error al guardar el pedido: " . mysqli_error($conexion);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gracias por tu compra - Fuzzion</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: url('images/banner.jpg') no-repeat center center/cover;
      color: #fff;
      text-align: center;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .card {
      background: rgba(255, 255, 255, 0.95);
      color: #333;
      border-radius: 20px;
      padding: 30px;
      max-width: 400px;
      box-shadow: 0 6px 15px rgba(0,0,0,0.2);
    }
    h1 { color: #f57c00; }
    .detalle { text-align: left; margin-top: 20px; font-size: 15px; }
    .btn { display: inline-block; margin-top: 20px; background: #f57c00; color: white; padding: 10px 20px; border-radius: 10px; text-decoration: none; transition: 0.3s; }
    .btn:hover { background: #ff8f00; }
  </style>
</head>
<body>
  <div class="card">
    <h1>🎉 ¡Gracias por tu compra!</h1>
    <p><?php echo $mensaje; ?></p>

    <div class="detalle">
      <p><strong>Número de Pedido:</strong> <?php echo $numero_pedido; ?></p>
      <p><strong>Cliente:</strong> <?php echo $cliente_nombre; ?></p>
      <p><strong>Productos:</strong> <?php echo $productos_str; ?></p>
      <p><strong>Total:</strong> $<?php echo number_format((float)$total, 2, '.', ','); ?></p>
      <p><strong>Fecha:</strong> <?php echo $fecha_actual; ?></p>
    </div>

    <a href="comprar.php" class="btn">⬅️ Volver a la tienda</a>
  </div>
</body>
</html>
