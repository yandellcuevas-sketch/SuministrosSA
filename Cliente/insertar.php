<?php
include "../config/conexion.php";

$nombre = $conn->real_escape_string($_POST["nombre"]);
$apellido = $conn->real_escape_string($_POST["apellido"]);
$contacto = $conn->real_escape_string($_POST["contacto"]);
$telefono = $conn->real_escape_string($_POST["telefono"]);
$email = $conn->real_escape_string($_POST["email"]);
$direccion_facturacion = $conn->real_escape_string($_POST["direccion_facturacion"]);
$direccion_envio = $conn->real_escape_string($_POST["direccion_envio"]);
$tipo_cliente = $conn->real_escape_string($_POST["tipo_cliente"]);
$estado = $conn->real_escape_string($_POST["estado"]);
$rnc = $conn->real_escape_string($_POST["rnc"]);

$query = "
    INSERT INTO clientes (
        nombre,
        apellido,
        contacto,
        telefono,
        email,
        direccion_facturacion,
        direccion_envio,
        tipo_cliente,
        estado,
        rnc
    ) VALUES (
        '$nombre',
        '$apellido',
        '$contacto',
        '$telefono',
        '$email',
        '$direccion_facturacion',
        '$direccion_envio',
        '$tipo_cliente',
        '$estado',
        '$rnc'
    )
";

$conn->query($query);
$conn->close();

header("Location: listar.php");
exit();
