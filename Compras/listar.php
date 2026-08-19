<?php
include "../config/conexion.php";
$sql = "SELECT * FROM compras";
$res = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Compras</title>
    <link rel="stylesheet" href="estilosss.css">
</head>
<body>
<div class="container">
    <h2>LISTA DE COMPRAS</h2>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ID Proveedor</th>
                    <th>Fecha Compra</th>
                    <th>Número Factura</th>
                    <th>Monto Total</th>
                    <th>Método Pago</th>
                    <th>Fecha Entrega</th>
                    <th>Estado</th>
                    <th>Estado Compra</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php while($fila = $res->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $fila['id']; ?></td>
                    <td><?php echo $fila['id_proveedor']; ?></td>
                    <td><?php echo $fila['fecha_compra']; ?></td>
                    <td><?php echo $fila['numero_factura']; ?></td>
                    <td><?php echo $fila['monto_total']; ?></td>
                    <td><?php echo $fila['metodo_pago']; ?></td>
                    <td><?php echo $fila['fecha_entrega']; ?></td>
                    <td><?php echo $fila['estado']; ?></td>
                    <td><?php echo $fila['estado_compra']; ?></td>
                    <td class="acciones">
                        <a href="editar.php?id=<?php echo $fila['id']; ?>">Editar</a>
                        <a href="eliminar.php?id=<?php echo $fila['id']; ?>">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <a href="index.php" class="back-button">Volver</a>
</div>
</body>
</html>
<?php $conn->close(); ?>
