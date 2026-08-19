<?php
include "../config/conexion.php";

$sql = "SELECT 
            p.id AS id_producto,
            p.nombre,
            p.descripcion,
            c.nombre AS categoria,
            p.sku,
            p.precio,
            p.costo,
            i.cantidad,
            i.stock_minimo,
            i.stock_maximo,
            u.nombre AS unidad_medida,
            i.costo_unitario,
            i.estado,
            i.lote
        FROM productos p
        INNER JOIN inventario i ON p.id = i.id_producto
        LEFT JOIN categorias c ON p.categoria = c.id
        LEFT JOIN unidades_medida u ON i.unidad_medida = u.id";

$res = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario - Lista de Productos</title>
    <link rel="stylesheet" href="inventario.css">
</head>
<body>
    <div class="container">
        <h1>Lista de Inventario</h1>

        <input type="text" id="buscar" placeholder="🔍 Buscar producto..." onkeyup="filtrarTabla()" style="margin-bottom: 20px; padding: 10px; width: 100%; max-width: 500px;">

        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Categoría</th>
                        <th>SKU</th>
                        <th>Precio</th>
                        <th>Costo</th>
                        <th>Cantidad</th>
                        <th>Stock Min</th>
                        <th>Stock Max</th>
                        <th>Unidad</th>
                        <th>Costo Unitario</th>
                        <th>Estado</th>
                        <th>Lote</th>
                        <th style="text-align:right;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($producto = $res->fetch_assoc()): ?>
                        <?php
                        $estado = $producto['estado'];
                        $claseEstado = match ($estado) {
                            'disponible' => 'verde',
                            'reservado' => 'amarillo',
                            'en_tránsito' => 'azul',
                            'dañado' => 'rojo',
                            default => 'gris'
                        };
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($producto['id_producto']) ?></td>
                            <td><?= htmlspecialchars($producto['nombre']) ?></td>
                            <td><?= htmlspecialchars($producto['descripcion']) ?></td>
                            <td><?= htmlspecialchars($producto['categoria']) ?></td>
                            <td><?= htmlspecialchars($producto['sku']) ?></td>
                            <td>$<?= number_format($producto['precio'], 2) ?></td>
                            <td>$<?= number_format($producto['costo'], 2) ?></td>
                            <td><?= $producto['cantidad'] ?></td>
                            <td><?= $producto['stock_minimo'] ?></td>
                            <td><?= $producto['stock_maximo'] ?></td>
                            <td><?= htmlspecialchars($producto['unidad_medida']) ?></td>
                            <td>$<?= number_format($producto['costo_unitario'], 2) ?></td>
                            <td class="<?= $claseEstado ?>"><?= htmlspecialchars($estado) ?></td>
                            <td><?= htmlspecialchars($producto['lote']) ?></td>
                            <td style="text-align:right;">
                                <a href="detalle.php?id=<?= $producto['id_producto'] ?>" class="action-button">Ver</a>
                                <a href="editar.php?id=<?= $producto['id_producto'] ?>" class="action-button">Editar</a>
                                <a href="eliminar.php?id=<?= $producto['id_producto'] ?>" class="action-button" onclick="return confirm('¿Estás completamente seguro de eliminar este producto? Esta acción no se puede deshacer.')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <a href="insertar.php" class="action-button">Agregar Producto</a>
        <a href="index.php" class="back-button">Volver al Inventario</a>
    </div>

    <script>
        function filtrarTabla() {
            let input = document.getElementById("buscar").value.toLowerCase();
            let filas = document.querySelectorAll("tbody tr");
            filas.forEach(fila => {
                fila.style.display = fila.innerText.toLowerCase().includes(input) ? "" : "none";
            });
        }
    </script>
</body>
</html>

<?php $conn->close(); ?>
