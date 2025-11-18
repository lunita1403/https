<?php
// conexión a la base de datos 
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_fuzzion";

$conexion = mysqli_connect($host, $user, $pass, $db);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>
