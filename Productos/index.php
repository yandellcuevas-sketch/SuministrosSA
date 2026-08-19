<?php include("../config/conexion.php"); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Productos</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="header">
        <img src="dfctrack.jpg" alt="Suministros S.A." class="logo">
        <h1 class="titulo-principal">Suministros S.A.</h1>
    </div>

    <div class="container">
        <h2>Registro de Productos</h2>

        <form action="insertar.php" method="POST">
            <label><strong>Nombre:</strong></label>
            <input type="text" name="nombre" required>

            <label><strong>Descripción:</strong></label>
            <textarea name="descripcion" required></textarea>

            <label><strong>Categoría:</strong></label>
            <select name="categoria" required>
                <option value="">Seleccione una categoría</option>
                <?php
                $result_categorias = $conn->query("SELECT id, nombre FROM categorias");
                while ($row = $result_categorias->fetch_assoc()) {
                    echo "<option value='" . $row["nombre"] . "'>" . $row["nombre"] . "</option>";
                }
                ?>
            </select>

            <label><strong>SKU:</strong></label>
            <input type="text" name="sku" required>

            <label><strong>Precio:</strong></label>
            <input type="number" step="0.01" name="precio" required>

            <label><strong>Costo:</strong></label>
            <input type="number" step="0.01" name="costo" required>

            <label><strong>Stock Actual:</strong></label>
            <input type="number" name="stock_actual" required>

            <label><strong>Stock Mínimo:</strong></label>
            <input type="number" name="stock_minimo" required>

            <label><strong>Unidad de Medida:</strong></label>
            <select name="unidad_medida" required>
                <option value="">Seleccione una unidad</option>
                <?php
                $result_unidades = $conn->query("SELECT id, nombre FROM unidades_medida");
                while ($row = $result_unidades->fetch_assoc()) {
                    echo "<option value='" . $row["nombre"] . "'>" . $row["nombre"] . "</option>";
                }
                ?>
            </select>

            <button type="submit">Registrar Producto</button>
        </form>

        <div class="extra-links">
            <p>¿No estás registrado como proveedor?</p>
            <a href="../proveedores/index.php" class="small-button">Regístrate aquí</a>
        </div>

        <a href="listar.php" class="view-list-button">Ver Lista de Productos</a>

        <a href="http://localhost:8080/Suministros%20SA/menuprincipal/menu.php" class="back-button">Ir al Menú Principal</a>
    </div>
</body>
</html>
