<?php
include "../config/conexion.php";

$id = $_GET["id"];
$query = "DELETE FROM compras WHERE id = '$id'";
$conn->query($query);
$conn->close();

header("Location: listar.php");
exit();
?>
