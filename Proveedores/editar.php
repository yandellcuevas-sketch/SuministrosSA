<?php
include("../config/conexion.php");

$id = $_GET["id"];

$sql = "SELECT * FROM proveedores WHERE id = $id";
$result = $conn->query($sql);
$proveedor = $result->fetch_assoc();

$sql_productos = "SELECT id, nombre FROM productos";
$result_productos = $conn->query($sql_productos);


$sql_seleccionados = "SELECT producto_id FROM ProductosProveedor WHERE proveedor_id = $id";
$result_seleccionados = $conn->query($sql_seleccionados);
$productos_seleccionados = [];

while ($row = $result_seleccionados->fetch_assoc()) {
    $productos_seleccionados[] = $row['producto_id'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Proveedor</title>
    <link rel="stylesheet" href="estiloss.css">
</head>
<body>
    <div class="container">
        <h2>Editar Proveedor</h2>

        <form action="actualizar.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $proveedor['id']; ?>">

            <div class="form-row">
                <div class="form-group">
                    <label for="nombre_empresa">Nombre de la Empresa:</label>
                    <input type="text" name="nombre_empresa" id="nombre_empresa" value="<?php echo $proveedor['nombre_empresa']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="contacto">Contacto:</label>
                    <input type="text" name="contacto" id="contacto" value="<?php echo $proveedor['contacto']; ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="telefono">Teléfono:</label>
                    <input type="text" name="telefono" id="telefono" value="<?php echo $proveedor['telefono']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="correo">Correo:</label>
                    <input type="email" name="correo" id="correo" value="<?php echo $proveedor['correo']; ?>" required>
                </div>
            </div>

            <label for="direccion">Dirección:</label>
            <textarea name="direccion" id="direccion" required><?php echo $proveedor['direccion']; ?></textarea>

            <div class="form-row">
                <div class="form-group">
                    <label for="tiempo_entrega">Tiempo de Entrega (días):</label>
                    <input type="number" name="tiempo_entrega" id="tiempo_entrega" value="<?php echo $proveedor['tiempo_entrega']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="condiciones_pago">Condiciones de Pago:</label>
                    <input type="text" name="condiciones_pago" id="condiciones_pago" value="<?php echo $proveedor['condiciones_pago']; ?>" required>
                </div>
            </div>

            <label for="estado">Estado:</label>
            <select name="estado" id="estado" required>
                <option value="Activo" <?php echo ($proveedor['estado'] == 'Activo') ? 'selected' : ''; ?>>Activo</option>
                <option value="Inactivo" <?php echo ($proveedor['estado'] == 'Inactivo') ? 'selected' : ''; ?>>Inactivo</option>
            </select>

            <label for="productos">Productos que ofrece:</label>
            <select name="productos[]" id="productos" multiple required>
                <?php while ($row = $result_productos->fetch_assoc()) {
                    $selected = in_array($row['id'], $productos_seleccionados) ? "selected" : "";
                    echo "<option value='{$row['id']}' $selected>{$row['nombre']}</option>";
                } ?>
            </select>

            <button type="submit">Actualizar Proveedor</button>
        </form>

        <div class="extra-links">
            <a href="listar.php" class="view-list-button">Ver lista de proveedores</a>
        </div>

        <div class="extra-links">
            <a href="index.php" class="back-button">Volver</a>
        </div>
    </div>
</body>
</html>
