<?php
include "../config/conexion.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Compras</title>
    <link rel="stylesheet" href="estilosss.css">
</head>
<body>
<div class="container">
    <h1>REGISTRO DE COMPRAS</h1>

    <form action="insertar.php" method="POST">
        <div class="form-row">
            <div class="form-group">
                <label>Proveedor:</label>
                <select name="id_proveedor">
                    <?php
                    $sql = "SELECT id, nombre_empresa FROM proveedores";
                    $res = $conn->query($sql);
                    while ($p = $res->fetch_assoc()) {
                        echo "<option value='".$p["id"]."'>".$p["nombre_empresa"]."</option>";
                    }
                    $conn->close();
                    ?>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Fecha de Compra:</label>
                <input type="date" name="fecha_compra">
            </div>
            <div class="form-group">
                <label>Número de Factura:</label>
                <input type="text" name="numero_factura">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Monto Total:</label>
                <input type="number" step="0.01" name="monto_total">
            </div>
            <div class="form-group">
                <label>Método de Pago:</label>
                <select name="metodo_pago">
                    <option value="Efectivo">Efectivo</option>
                    <option value="Transferencia">Transferencia</option>
                    <option value="Crédito">Crédito</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Fecha de Entrega:</label>
                <input type="date" name="fecha_entrega">
            </div>
            <div class="form-group">
                <label>Estado:</label>
                <select name="estado">
                    <option value="Pendiente">Pendiente</option>
                    <option value="Aprobado">Aprobado</option>
                    <option value="Cancelado">Cancelado</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Estado de la Compra:</label>
                <select name="estado_compra">
                    <option value="Pendiente">Pendiente</option>
                    <option value="En Transito">En Transito</option>
                    <option value="Entregada">Entregada</option>
                    <option value="Cancelada">Cancelada</option>
                </select>
            </div>
        </div>

        <button type="submit">Registrar Compra</button>
    </form>

    <a href="listar.php" class="view-list-button">Ver lista de compras</a>


    <a href="http://localhost:8080/Suministros%20SA/menuprincipal/menu.php" class="back-button">Ir al Menú Principal</a>
</div>
</body>
</html>
