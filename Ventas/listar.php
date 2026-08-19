<?php
include "../config/conexion.php";

$sql = "SELECT v.*, c.nombre AS nombre, c.apellido AS apellido, u.usuario AS usuario_registro, m.metodo AS metodo_pago
        FROM ventas v
        INNER JOIN clientes c ON v.id_cliente = c.id
        INNER JOIN usuarios u ON v.id_usuario = u.id
        INNER JOIN metodos_pago m ON v.id_metodo_pago = m.id
        ORDER BY v.fecha DESC";
$res = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Ventas</title>
    <link rel="stylesheet" href="venta.css">
</head>
<body>
    <div class="container">
        <h1>Listado Completo de Ventas</h1>

        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Usuario</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Subtotal</th>
                        <th>Descuento</th>
                        <th>Impuesto</th>
                        <th>Total</th>
                        <th>Pago Recibido</th>
                        <th>Cambio</th>
                        <th>Método de Pago</th>
                        <th>Observación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($res->num_rows > 0): ?>
                        <?php while ($venta = $res->fetch_assoc()): ?>
                            <tr>
                                <td><?= $venta['id'] ?></td>
                                <td><?= htmlspecialchars($venta['nombre'] . ' ' . $venta['apellido']) ?></td>
                                <td><?= htmlspecialchars($venta['usuario_registro']) ?></td>
                                <td><?= $venta['fecha'] ?></td>
                                <td><?= ucfirst($venta['estado']) ?></td>
                                <td>$<?= number_format($venta['subtotal'], 2) ?></td>
                                <td>$<?= number_format($venta['descuento'], 2) ?></td>
                                <td>$<?= number_format($venta['impuesto'], 2) ?></td>
                                <td>$<?= number_format($venta['total'], 2) ?></td>
                                <td>$<?= number_format($venta['pago_recibido'], 2) ?></td>
                                <td>$<?= number_format($venta['cambio'], 2) ?></td>
                                <td><?= htmlspecialchars($venta['metodo_pago']) ?></td>
                                <td><?= htmlspecialchars($venta['observacion'] ?: 'Sin observación') ?></td>
                                <td>
                                    <a href="detalle.php?id=<?= $venta['id'] ?>" 
                                        class="action-button ver">Ver</a>
                                    <a href="editar.php?id=<?= $venta['id'] ?>" 
                                        class="action-button editar">Editar</a>
                                    <a href="eliminar.php?id=<?= $venta['id'] ?>" 
                                        onclick="return confirm('¿Seguro que deseas eliminar esta venta?')" 
                                        class="action-button eliminar">Eliminar</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="14">No hay ventas registradas.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <a href="index.php" class="back-button">Volver</a>
    </div>
</body>
</html>

<?php $conn->close(); ?>