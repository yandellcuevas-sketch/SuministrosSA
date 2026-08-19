<?php
include "../config/conexion.php";

$usuario = $_POST['usuario'];
$password = $_POST['password'];  
$rol = "usuario";

$sql = "INSERT INTO usuarios (usuario, password, rol) VALUES ('$usuario', '$password', '$rol')";
$conn->query($sql);
$conn->close();

echo "<script>alert('Registro exitoso'); window.location='login.php';</script>";
?>
