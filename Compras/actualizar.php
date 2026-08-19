<?php
include "../config/conexion.php";

$id = $conn->real_escape_string($_POST["id"]);
$id_proveedor = $conn->real_escape_string($_POST["id_proveedor"]);
$fecha_compra = $conn->real_escape_string($_POST["fecha_compra"]);
$numero_factura = $conn->real_escape_string($_POST["numero_factura"]);
$monto_total = $conn->real_escape_string($_POST["monto_total"]);
$metodo_pago = $conn->real_escape_string($_POST["metodo_pago"]);
$fecha_entrega = $conn->real_escape_string($_POST["fecha_entrega"]);
$estado = $conn->real_escape_string($_POST["estado"]);
$estado_compra = $conn->real_escape_string($_POST["estado_compra"]);

$sql = "
UPDATE compras SET
    id_proveedor = '$id_proveedor',
    fecha_compra = '$fecha_compra',
    numero_factura = '$numero_factura',
    monto_total = '$monto_total',
    metodo_pago = '$metodo_pago',
    fecha_entrega = '$fecha_entrega',
    estado = '$estado',
    estado_compra = '$estado_compra'
WHERE id = '$id'
";
$conn->query($sql);
$conn->close();

header("Location: listar.php");
exit();
