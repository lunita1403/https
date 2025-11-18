<?php
session_start();

// ===============================
// CONEXIÓN A LA BD
// ===============================
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_fuzzion";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}


// ============================================================
// REGISTRO DE USUARIO (GUARDA id_rol = 1 - ESTUDIANTE)
// ============================================================
if (isset($_POST['register'])) {
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $correo = $conn->real_escape_string($_POST['correo']);
    $passw  = password_hash($_POST['clave'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nombre, correo, contrasena, rol) 
            VALUES ('$nombre', '$correo', '$passw', 'estudiante')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Usuario registrado correctamente');</script>";
    } else {
        echo "Error al registrar: " . $conn->error;
    }
}


// ============================================================
// LOGIN
// ============================================================
if (isset($_POST['login'])) {

    $correo = $conn->real_escape_string($_POST['correo']);
    $clave  = $_POST['clave'];

    // ========================
    // LOGIN DIRECTO ADMIN
    // ========================
    if ($correo === "gloriafuzzion@gmail.com" && $clave === "54321") {
        $_SESSION['id_usuario'] = 1;
        $_SESSION['usuario'] = "Gloria Admin";
        $_SESSION['rol'] = "admin";

        header("Location: admin.php");
        exit;
    }

    // ========================
    // LOGIN BD
    // ========================
    $sql = "SELECT * FROM usuarios WHERE correo='$correo' LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows == 1) {

        $row = $result->fetch_assoc();

        // VERIFICAR CONTRASEÑA
        if (password_verify($clave, $row['contrasena'])) {

            $_SESSION['id_usuario'] = $row['id_usuario'];
            $_SESSION['usuario'] = $row['nombre'];
            $_SESSION['rol'] = $row['rol'];

            // REDIRECCIÓN SEGÚN ROL
            if ($row['rol'] === "admin") {
                header("Location: admin.php");
                exit;
            } else {
                header("Location: inventario.php");
                exit;
            }

        } else {
            $error = "Contraseña incorrecta";
        }
    } else {
        $error = "Correo no registrado";
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pantalla Login</title>

  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    
    body { 
      background: url("Images/banner.jpg") no-repeat center center fixed;
      background-size: cover;
      display: flex; 
      justify-content: center; 
      align-items: center; 
      height: 100vh; 
    }

    .container { 
      background: rgba(255,255,255,0.9);
      border-radius: 15px; 
      box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22); 
      position: relative; 
      overflow: hidden; 
      width: 768px; 
      max-width: 100%; 
      min-height: 480px; 
    }

    .form-container { position: absolute; top: 0; height: 100%; transition: all 0.6s ease-in-out; }
    .sign-in-container { left: 0; width: 50%; z-index: 2; }
    .sign-up-container { left: 0; width: 50%; opacity: 0; z-index: 1; }
    .container.right-panel-active .sign-in-container { transform: translateX(100%); }
    .container.right-panel-active .sign-up-container { transform: translateX(100%); opacity: 1; z-index: 5; animation: show 0.6s; }

    @keyframes show { 0% { opacity: 0; } 100% { opacity: 1; } }

    form { background: #fff; display: flex; flex-direction: column; padding: 0 50px; height: 100%; justify-content: center; align-items: center; text-align: center; }
    form h1 { font-weight: bold; margin-bottom: 20px; }

    input { background: #eee; border: none; padding: 12px 15px; margin: 8px 0; width: 100%; border-radius: 5px; }

    button { border-radius: 20px; border: 1px solid #f6a06c; background: #f6a06c; color: #fff; font-size: 12px; font-weight: bold; padding: 12px 45px; letter-spacing: 1px; text-transform: uppercase; cursor: pointer; margin-top: 10px; }
    button:active { transform: scale(0.95); }

    .overlay-container { position: absolute; top: 0; left: 50%; width: 50%; height: 100%; overflow: hidden; transition: transform 0.6s ease-in-out; z-index: 100; }
    .container.right-panel-active .overlay-container{ transform: translateX(-100%); }

    .overlay { background: linear-gradient(to right, #f6a06c, #f6a06c); color: #fff; position: relative; left: -100%; height: 100%; width: 200%; transform: translateX(0); transition: transform 0.6s ease-in-out; }
    .container.right-panel-active .overlay { transform: translateX(50%); }

    .overlay-panel { position: absolute; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 0 40px; text-align: center; top: 0; height: 100%; width: 50%; }
    .overlay-left { transform: translateX(-20%); left: 0; }
    .container.right-panel-active .overlay-left { transform: translateX(0); }
    .overlay-right { right: 0; }
    .container.right-panel-active .overlay-right { transform: translateX(20%); }

    .error { color: red; font-size: 13px; margin-top: 10px; display: none; }
  </style>
</head>
<body>

  <div class="container" id="container">

    <!-- Registro -->
    <div class="form-container sign-up-container">
      <form method="POST" action="">
        <h1>Crear Cuenta</h1>
        <input type="text" name="nombre" placeholder="Nombre" required/>
        <input type="email" name="correo" placeholder="Correo" required/>
        <input type="password" name="clave" placeholder="Contraseña" required/>
        <button type="submit" name="register">Registrarse</button>
      </form>
    </div>

    <!-- Login -->
    <div class="form-container sign-in-container">
      <form method="POST" action="">
        <h1>Iniciar Sesión</h1>
        <input type="email" name="correo" placeholder="Correo" required/>
        <input type="password" name="clave" placeholder="Contraseña" required/>
        <button type="submit" name="login">Entrar</button>

        <?php if (isset($error)) { ?>
          <p class="error" style="display:block;"><?= $error ?></p>
        <?php } ?>
      </form>
    </div>

    <!-- Overlay -->
    <div class="overlay-container">
      <div class="overlay">
        <div class="overlay-panel overlay-left">
          <h1>¡Bienvenido de nuevo!</h1>
          <p>Para mantenerse conectado, inicie sesión con su información personal</p>
          <button class="ghost" id="signIn">Iniciar Sesión</button>
        </div>

        <div class="overlay-panel overlay-right">
          <h1>¡Hola!</h1>
          <p>Ingresa tus datos y comienza con nosotros</p>
          <button class="ghost" id="signUp">Registrarse</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const container = document.getElementById('container');

    signUpButton.addEventListener('click', () => {
      container.classList.add("right-panel-active");
    });

    signInButton.addEventListener('click', () => {
      container.classList.remove("right-panel-active");
    });

    if (window.location.search.includes('registro=1')) {
      container.classList.add("right-panel-active");
    }
  </script>

</body>
</html>
