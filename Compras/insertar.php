<?php
include "../config/conexion.php";

$id_proveedor    = $conn->real_escape_string($_POST["id_proveedor"]);
$fecha_compra    = $conn->real_escape_string($_POST["fecha_compra"]);
$numero_factura  = $conn->real_escape_string($_POST["numero_factura"]);
$monto_total     = $conn->real_escape_string($_POST["monto_total"]);
$metodo_pago     = $conn->real_escape_string($_POST["metodo_pago"]);
$fecha_entrega   = $conn->real_escape_string($_POST["fecha_entrega"]);
$estado          = $conn->real_escape_string($_POST["estado"]);
$estado_compra   = $conn->real_escape_string($_POST["estado_compra"]);


$sql = "
INSERT INTO compras (
    id_proveedor,
    fecha_compra,
    numero_factura,
    monto_total,
    metodo_pago,
    fecha_entrega,
    estado,
    estado_compra
) VALUES (
    '$id_proveedor',
    '$fecha_compra',
    '$numero_factura',
    '$monto_total',
    '$metodo_pago',
    '$fecha_entrega',
    '$estado',
    '$estado_compra'
)";
$conn->query($sql);

$conn->close();

header("Location: listar.php");
exit();
