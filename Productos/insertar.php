<?php
include("../config/conexion.php");

$nombre = $_POST["nombre"];
$descripcion = $_POST["descripcion"];
$categoria = $_POST["categoria"];
$sku = $_POST["sku"];
$precio = $_POST["precio"];
$costo = $_POST["costo"];
$stock_actual = $_POST["stock_actual"];
$stock_minimo = $_POST["stock_minimo"];
$unidad_medida = $_POST["unidad_medida"];

$sql = "INSERT INTO productos (nombre, descripcion, categoria, sku, precio, costo, stock_actual, stock_minimo, unidad_medida) 
        VALUES ('$nombre', '$descripcion', '$categoria', '$sku', '$precio', '$costo', '$stock_actual', '$stock_minimo', '$unidad_medida')";

$conn->query($sql);
header("Location: listar.php");
?>
