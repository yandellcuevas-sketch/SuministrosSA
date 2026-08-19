<?php
include "../config/conexion.php";
session_start();

$usuario = $conn->real_escape_string($_POST["usuario"] ?? "");
$password = $_POST["password"] ?? "";

$query = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
$res = $conn->query($query);
$fila = $res->num_rows > 0 ? $res->fetch_assoc() : null;

$autenticado = $fila && $password === $fila["password"];

$_SESSION["usuario"] = $autenticado ? $usuario : null;

$mensaje = $autenticado ? "" : "alert('Usuario o contraseña incorrectos');";
$redirect = $autenticado ? "../menuprincipal/menu.php" : "login.php";

echo "<script>$mensaje window.location='$redirect';</script>";

$conn->close();
?>
