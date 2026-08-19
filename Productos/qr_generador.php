<?php
include("../config/conexion.php");
require_once("phpqrcode/qrlib.php");


$id = $_GET['id'];


$sql = "SELECT * FROM productos WHERE id = '$id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();


$datos_producto = "📌 Producto: " . $row['nombre'] . "\n";
$datos_producto .= "📄 Descripción: " . $row['descripcion'] . "\n";
$datos_producto .= "📦 Categoría: " . $row['categoria'] . "\n";
$datos_producto .= "🆔 SKU: " . $row['sku'] . "\n";
$datos_producto .= "💰 Precio: $" . $row['precio'] . "\n";
$datos_producto .= "📊 Stock Actual: " . $row['stock_actual'] . "\n";
$datos_producto .= "⚠️ Stock Mínimo: " . $row['stock_minimo'] . "\n";
$datos_producto .= "⚖️ Unidad de Medida: " . $row['unidad_medida'] . "\n";


$ruta_qr = "qr_codes/";
$nombre_archivo = $ruta_qr . "producto_" . $id . ".png";


QRcode::png($datos_producto, $nombre_archivo, QR_ECLEVEL_L, 10, 2);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Código QR del Producto</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

    <div class="container qr-container">
        <h2>Código QR del Producto</h2>
        <p>Escanea este QR para ver la información del producto:</p>
        
        <div class="qr-box">
            <img src="<?php echo $nombre_archivo; ?>" alt="QR del producto">
        </div>

        <a href="listar.php" class="back-button">Volver</a>
    </div>

</body>
</html>

<?php $conn->close(); ?>
