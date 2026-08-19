<?php
include("../config/conexion.php");
$sql = "SELECT * FROM productos";
$result = $conn->query($sql);

$productos_stock_bajo = array_map(
    fn($row) => $row['stock_actual'] < $row['stock_minimo'] ? $row['nombre'] : null,
    $result->fetch_all(MYSQLI_ASSOC)
);

$productos_stock_bajo = array_filter($productos_stock_bajo);
$result->data_seek(0); 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Productos</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="container">
        <h2>Lista de Productos</h2>

        <?php echo count($productos_stock_bajo) ? '<div class="alerta-stock">⚠️ Los siguientes productos tienen stock bajo: <strong>' . implode(", ", $productos_stock_bajo) . '</strong>. Considera reabastecerlos.</div>' : ''; ?>

        <div class="table-container">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Categoría</th>
                    <th>SKU</th>
                    <th>Precio</th>
                    <th>Costo</th>
                    <th>Stock Actual</th>
                    <th>Stock Mínimo</th>
                    <th>Unidad de Medida</th>
                    <th>Acciones</th>
                </tr>

                <?php while ($row = $result->fetch_assoc()) { ?>
                <tr class="<?php echo str_repeat('stock-bajo', $row['stock_actual'] < $row['stock_minimo']); ?>">
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['descripcion']; ?></td>
                    <td><?php echo $row['categoria']; ?></td>
                    <td><?php echo $row['sku']; ?></td>
                    <td><?php echo $row['precio']; ?></td>
                    <td><?php echo $row['costo']; ?></td>
                    <td><?php echo $row['stock_actual']; ?></td>
                    <td><?php echo $row['stock_minimo']; ?></td>
                    <td><?php echo $row['unidad_medida']; ?></td>
                    
                    <td class="acciones">
                    <a href="editar.php?id=<?php echo $row['id']; ?>">Editar</a>
                    <a href="eliminar.php?id=<?php echo $row['id']; ?>" onclick="return confirm('¿Seguro que deseas eliminar este producto?')">Eliminar</a>
                    <a href="qr_generador.php?id=<?php echo $row['id']; ?>" target="_blank">Generar QR</a>
</td>

                </tr>
                <?php } ?>
            </table>
        </div>

        <a href="index.php" class="back-button">Volver</a>
    </div>
</body>
</html>

<?php $conn->close(); ?>
