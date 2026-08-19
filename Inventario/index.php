<?php
include "../config/conexion.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$result_unidades   = $conn->query("SELECT * FROM unidades_medida");
$result_categorias = $conn->query("SELECT * FROM categorias");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre         = trim($_POST['nombre']);
    $categoria      = $_POST['categoria'];
    $precio         = $_POST['precio'];
    $stock          = $_POST['stock'];
    $ubicacion      = trim($_POST['ubicacion']);
    $stock_minimo   = $_POST['stock_minimo'];
    $stock_maximo   = $_POST['stock_maximo'];
    $unidad_medida  = $_POST['unidad_medida'];
    $costo_unitario = $_POST['costo_unitario'];
    $estado         = $_POST['estado'];
    $lote           = trim($_POST['lote']);

    if ($stock_minimo > $stock_maximo) {
        $error_message = "❌ El stock mínimo no puede ser mayor que el stock máximo.";
    } elseif (
        empty($nombre) || empty($categoria) || empty($precio) || empty($stock) ||
        empty($ubicacion) || empty($stock_minimo) || empty($stock_maximo) ||
        empty($unidad_medida) || empty($costo_unitario) || empty($estado) || empty($lote)
    ) {
        $error_message = "❌ Todos los campos son obligatorios.";
    } else {
        $stmt = $conn->prepare("
            INSERT INTO productos (nombre, categoria, precio, stock_actual)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->bind_param("sidi", $nombre, $categoria, $precio, $stock);
        $stmt->execute();
        $id_producto = $conn->insert_id;

        $stmt_inv = $conn->prepare("
            INSERT INTO inventario 
                (id_producto, ubicacion, cantidad, stock_minimo, stock_maximo, unidad_medida, costo_unitario, estado, lote)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt_inv->bind_param("isiiiidss", 
            $id_producto, $ubicacion, $stock, $stock_minimo, $stock_maximo,
            $unidad_medida, $costo_unitario, $estado, $lote
        );
        $stmt_inv->execute();

        header("Location: index.php");
        exit();
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

    <form method="POST" class="agregar-producto-form">
        <div class="product-form-section">
            <div class="product-form-block">
                <label>Nombre del Producto:</label>
                <input type="text" name="nombre" required>
            </div>
            <div class="product-form-block">
                <label>Categoría:</label>
                <select name="categoria" required>
                    <option value="">Seleccione una categoría</option>
                    <?php while ($cat = $result_categorias->fetch_assoc()): ?>
                        <option value="<?= $cat['id'] ?>"><?= $cat['nombre'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="product-form-block">
                <label>Precio:</label>
                <input type="number" step="0.01" min="0" name="precio" required>
            </div>
            <div class="product-form-block">
                <label>Stock Actual:</label>
                <input type="number" min="0" name="stock" required>
            </div>
        </div>

        <div class="product-form-section">
            <div class="product-form-block">
                <label>Ubicación en el Almacén:</label>
                <input type="text" name="ubicacion" required>
            </div>
            <div class="product-form-block">
                <label>Stock Mínimo:</label>
                <input type="number" min="0" name="stock_minimo" required>
            </div>
            <div class="product-form-block">
                <label>Stock Máximo:</label>
                <input type="number" min="0" name="stock_maximo" required>
            </div>
            <div class="product-form-block">
                <label>Unidad de Medida:</label>
                <select name="unidad_medida" required>
                    <option value="">Seleccione una unidad</option>
                    <?php while ($um = $result_unidades->fetch_assoc()): ?>
                        <option value="<?= $um['id'] ?>"><?= $um['nombre'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>

        <div class="product-form-section">
            <div class="product-form-block">
                <label>Costo Unitario:</label>
                <input type="number" step="0.01" min="0" name="costo_unitario" required>
            </div>
            <div class="product-form-block">
                <label>Estado del Producto:</label>
                <select name="estado" required>
                    <option value="disponible">Disponible</option>
                    <option value="reservado">Reservado</option>
                    <option value="en_tránsito">En Tránsito</option>
                    <option value="dañado">Dañado</option>
                </select>
            </div>
            <div class="product-form-block">
                <label>Lote o Número de Serie:</label>
                <input type="text" name="lote" required>
            </div>
        </div>

        <div class="product-form-buttons">
            <button type="submit">Agregar Producto</button>
        </div>
    </form>

    <a href="listar.php" class="button-blue">Ver Lista de Inventario</a>
    <a href="http://localhost:8080/Suministros%20SA/menuprincipal/menu.php" class="back-button">Menú Principal</a>
</div>
</body>
</html>
<?php $conn->close(); ?>