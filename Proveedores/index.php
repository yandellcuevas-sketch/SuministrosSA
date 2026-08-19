<?php include("../config/conexion.php"); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Proveedores</title>
    <link rel="stylesheet" href="estiloss.css">
</head>
<body>
    <div class="container">
        <h2>Registro de Proveedores</h2>

        <form action="insertar.php" method="POST">
            <div class="form-row">
                <div class="form-group">
                    <label for="nombre_empresa"><strong>Nombre de la Empresa:</strong></label>
                    <input type="text" name="nombre_empresa" id="nombre_empresa" required>
                </div>
                <div class="form-group">
                    <label for="contacto"><strong>Contacto:</strong></label>
                    <input type="text" name="contacto" id="contacto" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="telefono"><strong>Teléfono:</strong></label>
                    <input type="text" name="telefono" id="telefono" required>
                </div>
                <div class="form-group">
                    <label for="correo"><strong>Correo:</strong></label>
                    <input type="email" name="correo" id="correo" required>
                </div>
            </div>

            <label for="direccion"><strong>Dirección:</strong></label>
            <textarea name="direccion" id="direccion" required></textarea>

            <div class="form-row">
                <div class="form-group">
                    <label for="tiempo_entrega"><strong>Tiempo de Entrega (días):</strong></label>
                    <input type="number" name="tiempo_entrega" id="tiempo_entrega" required>
                </div>
                <div class="form-group">
                    <label for="condiciones_pago"><strong>Condiciones de Pago:</strong></label>
                    <input type="text" name="condiciones_pago" id="condiciones_pago" required>
                </div>
            </div>

            <label for="estado"><strong>Estado:</strong></label>
            <select name="estado" id="estado" required>
                <option value="Activo">Activo</option>
                <option value="Inactivo">Inactivo</option>
            </select>

            <label for="productos"><strong>Productos que Ofrece:</strong></label>
            <select name="productos[]" id="productos" multiple required>
                <?php
                $sql = "SELECT id, nombre FROM Productos";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['nombre']}</option>";
                }
                ?>
            </select>

            <button type="submit">Registrar Proveedor</button>
        </form>

        <div class="extra-links">
            <a href="listar.php" class="view-list-button">Ver lista de proveedores</a>
        </div>

        <div class="extra-links">
            <a href="../menuprincipal/menu.php" class="back-button">Volver</a>

            
        </div>
    </div>
</body>
</html>
