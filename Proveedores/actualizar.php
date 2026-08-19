<?php
include("../config/conexion.php");

$id = $_POST["id"];
$nombre_empresa = $_POST["nombre_empresa"];
$contacto = $_POST["contacto"];
$telefono = $_POST["telefono"];
$correo = $_POST["correo"];
$direccion = $_POST["direccion"];
$tiempo_entrega = $_POST["tiempo_entrega"];
$condiciones_pago = $_POST["condiciones_pago"];
$estado = $_POST["estado"];
$productos = $_POST["productos"];

$sql = "UPDATE proveedores SET 
        nombre_empresa='$nombre_empresa', 
        contacto='$contacto', 
        telefono='$telefono', 
        correo='$correo', 
        direccion='$direccion', 
        tiempo_entrega='$tiempo_entrega', 
        condiciones_pago='$condiciones_pago', 
        estado='$estado' 
        WHERE id=$id";

$conn->query($sql);

$conn->query("DELETE FROM ProductosProveedor WHERE proveedor_id=$id");

foreach ($productos as $producto_id) {
    $conn->query("INSERT INTO ProductosProveedor (proveedor_id, producto_id, cantidad_disponible) VALUES ('$id', '$producto_id', 0)");
}

$conn->close();

header("Location: listar.php");
exit();
?>
