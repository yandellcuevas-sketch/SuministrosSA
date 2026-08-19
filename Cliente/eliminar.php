<?php
include "../config/conexion.php";

$id = (int)$_GET["id"];

$query = "DELETE FROM clientes WHERE id = $id";
$conn->query($query);
$conn->close();

header("Location: listar.php");
exit();
