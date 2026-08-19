<?php
include "../config/conexion.php";

$id = $conn->real_escape_string($_POST["id"]);
$nombre = $conn->real_escape_string($_POST["nombre"]);
$apellido = $conn->real_escape_string($_POST["apellido"]);
$contacto = $conn->real_escape_string($_POST["contacto"]);
$telefono = $conn->real_escape_string($_POST["telefono"]);
$email = $conn->real_escape_string($_POST["email"]);
$rnc = $conn->real_escape_string($_POST["rnc"]);
$direccion_facturacion = $conn->real_escape_string($_POST["direccion_facturacion"]);
$direccion_envio = $conn->real_escape_string($_POST["direccion_envio"]);
$tipo_cliente = $conn->real_escape_string($_POST["tipo_cliente"]);
$condiciones_pago = $conn->real_escape_string($_POST["condiciones_pago"]);
$estado = $conn->real_escape_string($_POST["estado"]);

$sql = "
    UPDATE clientes SET
        nombre = '$nombre',
        apellido = '$apellido',
        contacto = '$contacto',
        telefono = '$telefono',
        email = '$email',
        rnc = '$rnc',
        direccion_facturacion = '$direccion_facturacion',
        direccion_envio = '$direccion_envio',
        tipo_cliente = '$tipo_cliente',
        condiciones_pago = '$condiciones_pago',
        estado = '$estado'
    WHERE id = $id
";

$conn->query($sql);

$conn->close();

header("Location: listar.php");
exit();
