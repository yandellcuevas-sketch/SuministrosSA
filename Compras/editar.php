<?php
include "../config/conexion.php";

$id = $_GET["id"];

$sqlCompra = "SELECT * FROM compras WHERE id = '$id'";
$resCompra = $conn->query($sqlCompra);
$fila = $resCompra->fetch_assoc();

$sqlProv = "SELECT id, nombre_empresa FROM proveedores";
$resProv = $conn->query($sqlProv);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Compra</title>
    <link rel="stylesheet" href="estilosss.css">
</head>
<body>
<div class="container">
    <h1>EDITAR COMPRA</h1>

    <form action="actualizar.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $fila['id']; ?>">

        <div class="form-row">
            <div class="form-group">
                <label>Proveedor:</label>
                <select name="id_proveedor">
                    <?php
                    while ($p = $resProv->fetch_assoc()) {
                        $selected = ($p["id"] == $fila["id_proveedor"]) ? "selected" : "";
                        echo "<option value='".$p["id"]."' $selected>".$p["nombre_empresa"]."</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Fecha de Compra:</label>
                <input type="date" name="fecha_compra" value="<?php echo $fila['fecha_compra']; ?>">
            </div>
            <div class="form-group">
                <label>Número de Factura:</label>
                <input type="text" name="numero_factura" value="<?php echo $fila['numero_factura']; ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Monto Total:</label>
                <input type="number" step="0.01" name="monto_total" value="<?php echo $fila['monto_total']; ?>">
            </div>
            <div class="form-group">
                <label>Método de Pago:</label>
                <select name="metodo_pago">
                    <?php
                    $metodos = ["Efectivo", "Transferencia", "Crédito"];
                    foreach ($metodos as $m) {
                        $selected = ($m == $fila["metodo_pago"]) ? "selected" : "";
                        echo "<option value='$m' $selected>$m</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Fecha de Entrega:</label>
                <input type="date" name="fecha_entrega" value="<?php echo $fila['fecha_entrega']; ?>">
            </div>
            <div class="form-group">
                <label>Estado:</label>
                <select name="estado">
                    <?php
                    $estados = ["Pendiente", "Aprobado", "Cancelado"];
                    foreach ($estados as $e) {
                        $selected = ($e == $fila["estado"]) ? "selected" : "";
                        echo "<option value='$e' $selected>$e</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Estado de la Compra:</label>
                <select name="estado_compra">
                    <?php
                    $estados_compra = ["Pendiente", "En Transito", "Entregada", "Cancelada"];
                    foreach ($estados_compra as $ec) {
                        $selected = ($ec == $fila["estado_compra"]) ? "selected" : "";
                        echo "<option value='$ec' $selected>$ec</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <button type="submit">Actualizar Compra</button>
    </form>

    <a href="listar.php" class="view-list-button">Ver Lista de Compras</a>
    <a href="listar.php" class="back-button">Volver</a>
</div>
</body>
</html>
<?php
$conn->close();
