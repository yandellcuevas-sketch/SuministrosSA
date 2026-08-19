<?php
include "../config/conexion.php";

$id_compra = $_GET['id'] ?? null;

$query = "
SELECT c.id, 
       COALESCE(p.nombre_empresa, 'Proveedor No Registrado') AS proveedor, 
       COALESCE(c.fecha_compra, 'No disponible') AS fecha_compra, 
       COALESCE(c.monto_total, 0) AS monto_total, 
       COALESCE(c.estado, 'No registrado') AS estado
FROM compras c
LEFT JOIN proveedores p ON c.id_proveedor = p.id
WHERE c.id = '$id_compra'
";
$res = $conn->query($query);
$compra = $res->fetch_assoc() ?? [
    "proveedor" => "Proveedor No Registrado", 
    "fecha_compra" => "No disponible", 
    "monto_total" => "0.00", 
    "estado" => "No registrado"
];

$query_productos = "
SELECT COALESCE(pr.nombre_producto, 'Producto No Disponible') AS nombre_producto, 
       COALESCE(d.cantidad, 0) AS cantidad, 
       COALESCE(d.precio_unitario, 0) AS precio_unitario 
FROM detalles_compras d
LEFT JOIN productos pr ON d.id_producto = pr.id
WHERE d.id_compra = '$id_compra'
";
$res_productos = $conn->query($query_productos);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles de la Compra</title>
    <link rel="stylesheet" href="detalle.css">
</head>
<body>
    <div class="container">
        <h1>DETALLES DE LA COMPRA</h1>

        <div class="detalles-info">
            <p><strong>Proveedor:</strong> <?php echo htmlspecialchars($compra["proveedor"]); ?></p>
            <p><strong>Fecha de Compra:</strong> <?php echo htmlspecialchars($compra["fecha_compra"]); ?></p>
            <p><strong>Monto Total:</strong> $<?php echo number_format($compra["monto_total"], 2); ?></p>
            <p><strong>Estado:</strong> <?php echo htmlspecialchars($compra["estado"]); ?></p>
        </div>

        <h2>Productos Comprados</h2>
        <div class="products-container">
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($fila = $res_productos->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($fila["nombre_producto"]); ?></td>
                        <td><?php echo htmlspecialchars($fila["cantidad"]); ?></td>
                        <td>$<?php echo number_format($fila["precio_unitario"], 2); ?></td>
                        <td>$<?php echo number_format($fila["cantidad"] * $fila["precio_unitario"], 2); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div class="button-container">
            <a href="resultado.php" class="back-button">Volver</a>
            <a href="http://localhost:8080/Suministros%20SA/menuprincipal/menu.php" class="menu-button">Ir al Menú Principal</a>
        </div>
    </div>
</body>
</html>
<?php $conn->close(); ?>
