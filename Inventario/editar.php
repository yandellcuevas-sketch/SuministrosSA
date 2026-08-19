<?php
include "../config/conexion.php";

$id = $_GET['id'] ?? null;
if (!$id) die("ID no válido.");

$query = "SELECT * FROM productos WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();

$query_inventario = "SELECT * FROM inventario WHERE id_producto = ?";
$stmt_inventario = $conn->prepare($query_inventario);
$stmt_inventario->bind_param("i", $id);
$stmt_inventario->execute();
$res_inventario = $stmt_inventario->get_result();
$row_inventario = $res_inventario->fetch_assoc();

$result_unidades = $conn->query("SELECT * FROM unidades_medida");
$result_categorias = $conn->query("SELECT * FROM categorias");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $categoria = $_POST['categoria'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $ubicacion = $_POST['ubicacion'];
    $stock_minimo = $_POST['stock_minimo'];
    $stock_maximo = $_POST['stock_maximo'];
    $unidad_medida = $_POST['unidad_medida'];
    $costo_unitario = $_POST['costo_unitario'];
    $estado = $_POST['estado'];
    $lote = $_POST['lote'];

    $query_producto = "UPDATE productos SET nombre = ?, categoria = ?, precio = ?, stock_actual = ? WHERE id = ?";
    $stmt_producto = $conn->prepare($query_producto);
    $stmt_producto->bind_param("sidii", $nombre, $categoria, $precio, $stock, $id);
    $stmt_producto->execute();

    $query_inv = "UPDATE inventario SET ubicacion = ?, cantidad = ?, stock_minimo = ?, stock_maximo = ?, unidad_medida = ?, costo_unitario = ?, estado = ?, lote = ? WHERE id_producto = ?";
    $stmt_inv = $conn->prepare($query_inv);
    $stmt_inv->bind_param("siiiidssi", $ubicacion, $stock, $stock_minimo, $stock_maximo, $unidad_medida, $costo_unitario, $estado, $lote, $id);
    $stmt_inv->execute();

    header("Location: listar.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="inventario.css">
</head>
<body>
<div class="container">
    <h2>Editar Producto</h2>
    <form method="POST">
        <label>Nombre del Producto:</label>
        <input type="text" name="nombre" value="<?= htmlspecialchars($row['nombre']) ?>" required>

        <label>Categoría:</label>
        <select name="categoria" required>
            <option value="">Seleccione la categoría</option>
            <?php while ($cat = $result_categorias->fetch_assoc()): ?>
                <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $row['categoria'] ? 'selected' : '' ?>>
                    <?= $cat['nombre'] ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label>Precio:</label>
        <input type="number" step="0.01" name="precio" value="<?= $row['precio'] ?>" required>

        <label>Stock Actual:</label>
        <input type="number" name="stock" value="<?= $row['stock_actual'] ?>" required>

        <label>Ubicación en el Almacén:</label>
        <input type="text" name="ubicacion" value="<?= htmlspecialchars($row_inventario['ubicacion']) ?>" required>

        <label>Stock Mínimo:</label>
        <input type="number" name="stock_minimo" value="<?= $row_inventario['stock_minimo'] ?>" required>

        <label>Stock Máximo:</label>
        <input type="number" name="stock_maximo" value="<?= $row_inventario['stock_maximo'] ?>" required>

        <label>Unidad de Medida:</label>
        <select name="unidad_medida" required>
            <option value="">Seleccione una unidad</option>
            <?php while ($um = $result_unidades->fetch_assoc()): ?>
                <option value="<?= $um['id'] ?>" <?= $um['id'] == $row_inventario['unidad_medida'] ? 'selected' : '' ?>>
                    <?= $um['nombre'] ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label>Costo Unitario:</label>
        <input type="number" step="0.01" name="costo_unitario" value="<?= $row_inventario['costo_unitario'] ?>" required>

        <label>Estado del Producto:</label>
        <select name="estado" required>
            <option value="disponible" <?= $row_inventario['estado'] == 'disponible' ? 'selected' : '' ?>>Disponible</option>
            <option value="reservado" <?= $row_inventario['estado'] == 'reservado' ? 'selected' : '' ?>>Reservado</option>
            <option value="en_tránsito" <?= $row_inventario['estado'] == 'en_tránsito' ? 'selected' : '' ?>>En Tránsito</option>
            <option value="dañado" <?= $row_inventario['estado'] == 'dañado' ? 'selected' : '' ?>>Dañado</option>
        </select>

        <label>Lote o Número de Serie:</label>
        <input type="text" name="lote" value="<?= htmlspecialchars($row_inventario['lote']) ?>" required>

        <button type="submit">Actualizar Producto</button>
    </form>

    <a href="listar.php" class="back-button">Volver a la lista</a>
</div>
</body>
</html>
