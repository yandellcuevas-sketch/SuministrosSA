<?php
include("../config/conexion.php");

$id = $_GET["id"];

// Recuperar los datos del producto
$sql = "SELECT * FROM productos WHERE id = $id";
$result = $conn->query($sql);
$producto = $result->fetch_assoc();

// Obtener las unidades de medida disponibles
$query_unidades = "SELECT * FROM unidades_medida";
$result_unidades = $conn->query($query_unidades);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="container">
        <h2>Editar Producto</h2>

        <form action="actualizar.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">

            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" value="<?php echo $producto['nombre']; ?>" required>

            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" id="descripcion" required><?php echo $producto['descripcion']; ?></textarea>

            <label for="categoria">Categoría:</label>
            <input type="text" name="categoria" id="categoria" value="<?php echo $producto['categoria']; ?>" required>

            <label for="sku">SKU:</label>
            <input type="text" name="sku" id="sku" value="<?php echo $producto['sku']; ?>" required>

            <label for="precio">Precio:</label>
            <input type="number" step="0.01" name="precio" id="precio" value="<?php echo $producto['precio']; ?>" required>

            <label for="costo">Costo:</label>
            <input type="number" step="0.01" name="costo" id="costo" value="<?php echo $producto['costo']; ?>" required>

            <label for="stock_actual">Stock Actual:</label>
            <input type="number" name="stock_actual" id="stock_actual" value="<?php echo $producto['stock_actual']; ?>" required>

            <label for="stock_minimo">Stock Mínimo:</label>
            <input type="number" name="stock_minimo" id="stock_minimo" value="<?php echo $producto['stock_minimo']; ?>" required>

            <!-- Unidad de Medida -->
            <label for="unidad_medida">Unidad de Medida:</label>
            <select name="unidad_medida" id="unidad_medida" required>
                <option value="">Seleccione una unidad</option>
                <?php while ($unidad = $result_unidades->fetch_assoc()): ?>
                    <option value="<?php echo $unidad['id']; ?>" 
                        <?php echo ($unidad['id'] == $producto['unidad_medida']) ? 'selected' : ''; ?>>
                        <?php echo $unidad['nombre']; ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <button type="submit">Actualizar Producto</button>
        </form>

        <div class="extra-links">
            <a href="listar.php" class="view-list-button">Ver lista de productos</a>
        </div>

        <div class="extra-links">
            <a href="index.php" class="back-button">Volver</a>
        </div>
    </div>
</body>
</html>
