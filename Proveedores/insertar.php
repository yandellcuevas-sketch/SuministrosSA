<?php 
include("../config/conexion.php");

$nombre_empresa = mysqli_real_escape_string($conn, $_POST["nombre_empresa"]);
$contacto = mysqli_real_escape_string($conn, $_POST["contacto"]);
$telefono = mysqli_real_escape_string($conn, $_POST["telefono"]);
$correo = mysqli_real_escape_string($conn, $_POST["correo"]);
$direccion = mysqli_real_escape_string($conn, $_POST["direccion"]);
$tiempo_entrega = mysqli_real_escape_string($conn, $_POST["tiempo_entrega"]);
$condiciones_pago = mysqli_real_escape_string($conn, $_POST["condiciones_pago"]);
$estado = mysqli_real_escape_string($conn, $_POST["estado"]);
$productos = $_POST["productos"];

$sql_proveedor = "INSERT INTO proveedores (nombre_empresa, contacto, telefono, correo, direccion, tiempo_entrega, condiciones_pago, estado) 
                  VALUES ('$nombre_empresa', '$contacto', '$telefono', '$correo', '$direccion', '$tiempo_entrega', '$condiciones_pago', '$estado')";
$conn->query($sql_proveedor);

$proveedor_id = $conn->insert_id;

foreach ($productos as $producto_id) {
    $producto_id = mysqli_real_escape_string($conn, $producto_id);
    $sql_producto = "INSERT INTO ProductosProveedor (proveedor_id, producto_id, cantidad_disponible) 
                     VALUES ('$proveedor_id', '$producto_id', 0)";
    $conn->query($sql_producto);
}

$conn->close();

header("Location: listar.php");
exit();
?>
