<?php
include "../config/conexion.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$result_unidades = $conn->query("SELECT * FROM unidades_medida");
$result_categorias = $conn->query("SELECT * FROM categorias");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $categoria = $_POST['categoria'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $ubicacion = trim($_POST['ubicacion']);
    $stock_minimo = $_POST['stock_minimo'];
    $stock_maximo = $_POST['stock_maximo'];
    $unidad_medida = $_POST['unidad_medida'];
    $costo_unitario = $_POST['costo_unitario'];
    $estado = $_POST['estado'];
    $lote = trim($_POST['lote']);

    if ($stock_minimo > $stock_maximo) {
        $error_message = "❌ El stock mínimo no puede ser mayor que el stock máximo.";
    } elseif (
        empty($nombre) || empty($categoria) || empty($precio) || empty($stock) ||
        empty($ubicacion) || empty($stock_minimo) || empty($stock_maximo) ||
        empty($unidad_medida) || empty($costo_unitario) || empty($estado) || empty($lote)
    ) {
        $error_message = "❌ Todos los campos son obligatorios.";
    } else {
        $verificar = $conn->prepare("SELECT id FROM productos WHERE nombre = ? AND categoria = ?");
        $verificar->bind_param("si", $nombre, $categoria);
        $verificar->execute();
        $resultado = $verificar->get_result();
        if ($resultado->num_rows > 0) {
            $error_message = "❌ Ya existe un producto con ese nombre en esa categoría.";
        } else {
            $stmt = $conn->prepare("INSERT INTO productos (nombre, categoria, precio, stock_actual) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sidi", $nombre, $categoria, $precio, $stock);
            $stmt->execute();
            $id_producto = $conn->insert_id;

            $stmt_inv = $conn->prepare("INSERT INTO inventario (id_producto, ubicacion, cantidad, stock_minimo, stock_maximo, unidad_medida, costo_unitario, estado, lote)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt_inv->bind_param("isiiiidss", $id_producto, $ubicacion, $stock, $stock_minimo, $stock_maximo, $unidad_medida, $costo_unitario, $estado, $lote);
            $stmt_inv->execute();

            header("Location: index.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Nuevo Producto</title>
    <link rel="stylesheet" href="inventario.css">
</head>
<body>
    <div class="container">
        <h2>Agregar Nuevo Producto</h2>

        <?php if (isset($error_message)): ?>
            <div class="error-box"><?= $error_message ?></div>
        <?php endif; ?>

        <form method="POST">
            <label>Nombre del Producto:</label>
            <input type="text" name="nombre" required minlength="3">

            <label>Categoría:</label>
            <select name="categoria" required>
                <option value="" disabled selected hidden>Seleccione la categoría</option>
                <?php while ($row_categoria = $result_categorias->fetch_assoc()): ?>
                    <option value="<?= $row_categoria['id'] ?>"><?= $row_categoria['nombre'] ?></option>
                <?php endwhile; ?>
            </select>

            <label>Precio:</label>
            <input type="number" step="0.01" min="0.01" name="precio" required>

            <label>Stock Actual:</label>
            <input type="number" min="0" name="stock" required>

            <label>Ubicación en el Almacén:</label>
            <input type="text" name="ubicacion" required minlength="2">

            <label>Stock Mínimo:</label>
            <input type="number" min="0" name="stock_minimo" required>

            <label>Stock Máximo:</label>
            <input type="number" min="0" name="stock_maximo" required>

            <label>Unidad de Medida:</label>
            <select name="unidad_medida" required>
                <option value="" disabled selected hidden>Seleccione una unidad</option>
                <?php while ($row_unidad = $result_unidades->fetch_assoc()): ?>
                    <option value="<?= $row_unidad['id'] ?>"><?= $row_unidad['unidad'] ?></option>
                <?php endwhile; ?>
            </select>

            <label>Costo Unitario:</label>
            <input type="number" step="0.01" min="0" name="costo_unitario" required>

            <label>Estado del Producto:</label>
            <select name="estado" required>
                <option value="disponible">Disponible</option>
                <option value="reservado">Reservado</option>
                <option value="en_tránsito">En Tránsito</option>
                <option value="dañado">Dañado</option>
            </select>

            <label>Lote o Número de Serie:</label>
            <input type="text" name="lote" required>

            <button type="submit">Agregar Producto</button>
        </form>

        <a href="index.php" class="back-button">Volver al Inventario</a>
    </div>
</body>
</html>
