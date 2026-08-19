<?php
include "../config/conexion.php";

$filtro_fecha = $_GET["fecha"] ?? "";
$filtro_cliente = $_GET["id_cliente"] ?? "";
$filtro_estado = $_GET["estado"] ?? "";

$condiciones = array_filter([
    $filtro_fecha ? "c.fecha_compra = '$filtro_fecha'" : null,
    $filtro_cliente ? "c.id_cliente = '$filtro_cliente'" : null,
    $filtro_estado ? "c.estado = '$filtro_estado'" : null
]);

$query = "SELECT c.id, cl.nombre AS nombre_cliente, c.fecha_compra, c.monto_total, c.estado 
          FROM compras c 
          JOIN clientes cl ON c.id_cliente = cl.id "
          . (count($condiciones) ? " WHERE " . implode(" AND ", $condiciones) : "");

$res = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado de Historial de Compras</title>
    <link rel="stylesheet" href="estilosss.css">
</head>
<body>
    <div class="container">
        <h2>Resultados de Historial de Compras</h2>

        <table>
            <thead>
                <tr>
                    <th>ID Compra</th>
                    <th>Cliente</th>
                    <th>Fecha Compra</th>
                    <th>Monto Total</th>
                    <th>Estado</th>
                    <th>Ver Detalles</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($fila = $res->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $fila["id"]; ?></td>
                    <td><?php echo $fila["nombre_cliente"]; ?></td>
                    <td><?php echo $fila["fecha_compra"]; ?></td>
                    <td>$<?php echo number_format($fila["monto_total"], 2); ?></td>
                    <td><?php echo $fila["estado"]; ?></td>
                    <td><a class="btn-ver" href="detalle.php?id=<?php echo $fila["id"]; ?>">Ver</a></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="historial.php" class="back-button">Volver</a>
    </div>
</body>
</html>
<?php $conn->close(); ?>
