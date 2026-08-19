<?php
include "../config/conexion.php";

$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    die("ID no válido.");
}

$query_venta = "SELECT v.*, 
                    c.nombre AS cliente_nombre, 
                    c.apellido AS cliente_apellido, 
                    u.usuario AS usuario_registro, 
                    m.metodo AS metodo_pago
                FROM ventas v
                INNER JOIN clientes c ON v.id_cliente = c.id
                INNER JOIN usuarios u ON v.id_usuario = u.id
                INNER JOIN metodos_pago m ON v.id_metodo_pago = m.id
                WHERE v.id = ?";
$stmt_venta = $conn->prepare($query_venta);
$stmt_venta->bind_param("i", $id);
$stmt_venta->execute();
$res_venta = $stmt_venta->get_result();

if ($res_venta->num_rows === 0) {
    die("Venta no encontrada.");
}
$venta = $res_venta->fetch_assoc();

$query_productos = "SELECT p.nombre, vd.cantidad, vd.precio_unitario, vd.subtotal
                     FROM ventas_detalles vd
                     INNER JOIN productos p ON vd.id_producto = p.id
                     WHERE vd.id_venta = ?";
$stmt_productos = $conn->prepare($query_productos);
$stmt_productos->bind_param("i", $id);
$stmt_productos->execute();
$res_productos = $stmt_productos->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Venta</title>
    <link rel="stylesheet" href="venta.css">
</head>
<body>
    <div class="container">
        <h2>Detalle de la Venta #<?= $venta['id'] ?></h2>

        <table class="detalle-venta">
            <tr>
                <td><strong>Cliente:</strong></td>
                <td><?= htmlspecialchars($venta['cliente_nombre'] . ' ' . $venta['cliente_apellido']) ?></td>
            </tr>
            <tr>
                <td><strong>Usuario:</strong></td>
                <td><?= htmlspecialchars($venta['usuario_registro']) ?></td>
            </tr>
            <tr>
                <td><strong>Fecha:</strong></td>
                <td><?= $venta['fecha'] ?></td>
            </tr>
            <tr>
                <td><strong>Estado:</strong></td>
                <td><?= ucfirst($venta['estado']) ?></td>
            </tr>
            <tr>
                <td><strong>Subtotal:</strong></td>
                <td>$<?= number_format($venta['subtotal'], 2) ?></td>
            </tr>
            <tr>
                <td><strong>Descuento:</strong></td>
                <td>$<?= number_format($venta['descuento'], 2) ?></td>
            </tr>
            <tr>
                <td><strong>Impuesto:</strong></td>
                <td>$<?= number_format($venta['impuesto'], 2) ?></td>
            </tr>
            <tr>
                <td><strong>Total:</strong></td>
                <td>$<?= number_format($venta['total'], 2) ?></td>
            </tr>
            <tr>
                <td><strong>Pago Recibido:</strong></td>
                <td>$<?= number_format($venta['pago_recibido'], 2) ?></td>
            </tr>
            <tr>
                <td><strong>Cambio:</strong></td>
                <td>$<?= number_format($venta['cambio'], 2) ?></td>
            </tr>
            <tr>
                <td><strong>Método de Pago:</strong></td>
                <td><?= htmlspecialchars($venta['metodo_pago']) ?></td>
            </tr>
            <tr>
                <td><strong>Observación:</strong></td>
                <td><?= $venta['observacion'] ? htmlspecialchars($venta['observacion']) : "Ninguna" ?></td>
            </tr>
        </table>

        <div class="title-box">
            <h3>Productos en la Venta</h3>
        </div>

        <div class="table-container">
            <table class="detalle-productos">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($res_productos->num_rows > 0): ?>
                        <?php while ($producto = $res_productos->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($producto['nombre']) ?></td>
                                <td><?= intval($producto['cantidad']) ?></td>
                                <td>$<?= number_format($producto['precio_unitario'], 2) ?></td>
                                <td>$<?= number_format($producto['subtotal'], 2) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">No se encontraron productos.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <a href="listar.php" class="back-button">Volver al Listado de Ventas</a>
    </div>
</body>
</html>

<?php $conn->close(); ?>