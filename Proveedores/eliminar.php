<?php
include("../config/conexion.php");

$id = $_GET["id"];

$sql = "DELETE FROM proveedores WHERE id=$id";
$conn->query($sql);
$conn->close();

header("Location: listar.php");
exit();
?>
