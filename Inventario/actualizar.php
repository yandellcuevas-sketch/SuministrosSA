<?php
include "../config/conexion.php";

$id_producto = $_GET['id'] ?? null;

if (!$id_producto) {
    die("Producto no encontrado.");
}

$query_producto = "SELECT * FROM productos WHERE id = ?";
$stmt_prod = $conn->prepare($query_producto);
$stmt_prod->bind_param("i", $id_producto);
$stmt_prod->execute();
$res_prod = $stmt_prod->get_result();
$producto = $res_prod->fetch_assoc();

$query_inv = "SELECT * FROM inventario WHERE id_producto = ?";
$stmt_inv = $conn->prepare($query_inv);
$stmt_inv->bind_param("i", $id_producto);
$stmt_inv->execute();
$res_inv = $stmt_inv->get_result();
$inventario = $res_inv->fetch_assoc();

$result_unidades = $conn->query("SELECT * FROM unidades_medida");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];
    $stock_minimo = $_POST['stock_minimo'];
    $stock_maximo = $_POST['stock_maximo'];
    $unidad_medida = $_POST['unidad_medida'];
    $costo_unitario = $_POST['costo_unitario'];
    $estado = $_POST['estado'];
    $lote = $_POST['lote'];

    $sql_prod = "UPDATE productos SET nombre = ?, precio = ? WHERE id = ?";
    $stmt = $conn->prepare($sql_prod);
    $stmt->bind_param("sdi", $nombre, $precio, $id_producto);
    $stmt->execute();

    $sql_inv = "UPDATE inventario SET 
        cantidad = ?, 
        stock_minimo = ?, 
        stock_maximo = ?, 
        unidad_medida = ?, 
        costo_unitario = ?, 
        estado = ?, 
        lote = ? 
        WHERE id_producto = ?";
    $stmt2 = $conn->prepare($sql_inv);
    $stmt2->bind_param("iiiisdsi", $cantidad, $stock_minimo, $stock_maximo, $unidad_medida, $costo_unitario, $estado, $lote, $id_producto);
    $stmt2->execute();

    header("Location: listar.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Producto</title>
    <link rel="stylesheet" href="inventario.css">
</head>
<body>
    <div class="container">
        <h1>Actualizar Producto</h1>
        <form method="POST">
            <div class="form-row">
                <label>Nombre:</label>
                <input type="text" name="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>" required>
            </div>
            <div class="form-row">
                <label>Precio:</label>
                <input type="number" step="0.01" name="precio" value="<?= $producto['precio'] ?>" required>
            </div>
            <div class="form-row">
                <label>Cantidad:</label>
                <input type="number" name="cantidad" value="<?= $inventario['cantidad'] ?>" required>
            </div>
            <div class="form-row">
                <label>Stock Mínimo:</label>
                <input type="number" name="stock_minimo" value="<?= $inventario['stock_minimo'] ?>" required>
            </div>
            <div class="form-row">
                <label>Stock Máximo:</label>
                <input type="number" name="stock_maximo" value="<?= $inventario['stock_maximo'] ?>" required>
            </div>
            <div class="form-row">
                <label>Unidad de Medida:</label>
                <select name="unidad_medida" required>
                    <?php while ($row = $result_unidades->fetch_assoc()): ?>
                        <option value="<?= $row['id'] ?>" <?= $row['id'] == $inventario['unidad_medida'] ? 'selected' : '' ?>>
                            <?= $row['nombre'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-row">
                <label>Costo Unitario:</label>
                <input type="number" step="0.01" name="costo_unitario" value="<?= $inventario['costo_unitario'] ?>" required>
            </div>
            <div class="form-row">
                <label>Estado:</label>
                <select name="estado" required>
                    <option value="disponible" <?= $inventario['estado'] === 'disponible' ? 'selected' : '' ?>>Disponible</option>
                    <option value="reservado" <?= $inventario['estado'] === 'reservado' ? 'selected' : '' ?>>Reservado</option>
                    <option value="en_tránsito" <?= $inventario['estado'] === 'en_tránsito' ? 'selected' : '' ?>>En Tránsito</option>
                    <option value="dañado" <?= $inventario['estado'] === 'dañado' ? 'selected' : '' ?>>Dañado</option>
                </select>
            </div>
            <div class="form-row">
                <label>Lote:</label>
                <input type="text" name="lote" value="<?= htmlspecialchars($inventario['lote']) ?>" required>
            </div>
            <button type="submit">Actualizar Producto</button>
        </form>
        <a href="listar.php" class="back-button">Volver al Listado</a>
    </div>
</body>
</html>
