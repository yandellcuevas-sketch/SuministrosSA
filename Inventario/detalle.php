<?php
include "../config/conexion.php";

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID no válido.");
}

$query = "SELECT * FROM productos WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    die("Producto no encontrado.");
}

$row = $res->fetch_assoc();

$categoria_nombre = "No asignada";
if (!empty($row['categoria'])) {
    $query_categoria = "SELECT nombre FROM categorias WHERE id = ?";
    $stmt_cat = $conn->prepare($query_categoria);
    $stmt_cat->bind_param("i", $row['categoria']);
    $stmt_cat->execute();
    $res_cat = $stmt_cat->get_result();
    if ($res_cat->num_rows > 0) {
        $categoria = $res_cat->fetch_assoc();
        $categoria_nombre = $categoria['nombre'];
    }
}

$unidad_nombre = "No asignada";
$estado_clase = "gris";
$estado_texto = "No disponible";

$row_inventario = [];
$query_inv = "SELECT * FROM inventario WHERE id_producto = ?";
$stmt_inv = $conn->prepare($query_inv);
$stmt_inv->bind_param("i", $id);
$stmt_inv->execute();
$res_inv = $stmt_inv->get_result();
if ($res_inv->num_rows > 0) {
    $row_inventario = $res_inv->fetch_assoc();

    if (!empty($row_inventario['unidad_medida'])) {
        $query_unidad = "SELECT nombre FROM unidades_medida WHERE id = ?";
        $stmt_um = $conn->prepare($query_unidad);
        $stmt_um->bind_param("i", $row_inventario['unidad_medida']);
        $stmt_um->execute();
        $res_um = $stmt_um->get_result();
        if ($res_um->num_rows > 0) {
            $unidad = $res_um->fetch_assoc();
            $unidad_nombre = $unidad['nombre'];
        }
    }

    $estado_texto = $row_inventario['estado'] ?? "No disponible";
    $estado_clase = match ($estado_texto) {
        'disponible' => 'verde',
        'reservado' => 'amarillo',
        'en_tránsito' => 'azul',
        'dañado' => 'rojo',
        default => 'gris'
    };
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles del Producto</title>
    <link rel="stylesheet" href="inventario.css">
</head>
<body>
    <div class="container details-container">
        <h2>DETALLES DEL PRODUCTO</h2>

        <table class="detalle-producto">
            <thead>
                <tr>
                    <th>Campo</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Nombre</td>
                    <td><?= htmlspecialchars($row['nombre']) ?></td>
                </tr>
                <tr>
                    <td>Categoría</td>
                    <td><?= htmlspecialchars($categoria_nombre) ?></td>
                </tr>
                <tr>
                    <td>Precio</td>
                    <td>$<?= number_format($row['precio'], 2) ?></td>
                </tr>
                <tr>
                    <td>Stock Actual</td>
                    <td><?= $row['stock_actual'] ?></td>
                </tr>
                <tr>
                    <td>Ubicación</td>
                    <td><?= htmlspecialchars($row_inventario['ubicacion'] ?? 'No disponible') ?></td>
                </tr>
                <tr>
                    <td>Stock Mínimo</td>
                    <td><?= $row_inventario['stock_minimo'] ?? 'No disponible' ?></td>
                </tr>
                <tr>
                    <td>Stock Máximo</td>
                    <td><?= $row_inventario['stock_maximo'] ?? 'No disponible' ?></td>
                </tr>
                <tr>
                    <td>Unidad de Medida</td>
                    <td><?= htmlspecialchars($unidad_nombre) ?></td>
                </tr>
                <tr>
                    <td>Costo Unitario</td>
                    <td>$<?= number_format($row_inventario['costo_unitario'] ?? 0, 2) ?></td>
                </tr>
                <tr>
                    <td>Estado</td>
                    <td class="<?= $estado_clase ?>"><?= htmlspecialchars($estado_texto) ?></td>
                </tr>
                <tr>
                    <td>Lote</td>
                    <td><?= htmlspecialchars($row_inventario['lote'] ?? 'No disponible') ?></td>
                </tr>
            </tbody>
        </table>

        <a href="listar.php" class="back-button">Volver al Inventario</a>
    </div>
</body>
</html>
