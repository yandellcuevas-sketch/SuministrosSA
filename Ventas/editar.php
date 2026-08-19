<?php
include "../config/conexion.php";

$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    die("ID no válido.");
}

$query = "SELECT * FROM ventas WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$res_venta = $stmt->get_result();

if ($res_venta->num_rows == 0) {
    die("Venta no encontrada.");
}

$venta = $res_venta->fetch_assoc();

$res_clientes = $conn->query("SELECT id, nombre, apellido FROM clientes");
$res_usuarios = $conn->query("SELECT id, usuario FROM usuarios");
$res_metodos  = $conn->query("SELECT id, metodo FROM metodos_pago");

$res_productos = $conn->query("
    SELECT p.id, p.nombre, vd.cantidad, vd.precio_unitario
    FROM ventas_detalles vd
    INNER JOIN productos p ON vd.id_producto = p.id
    WHERE vd.id_venta = $id
");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_cliente     = $_POST['id_cliente'];
    $id_usuario     = $_POST['id_usuario'];
    $id_metodo_pago = $_POST['id_metodo_pago'];
    $estado         = $_POST['estado'];
    $observacion    = $_POST['observacion'];
    $subtotal       = floatval($_POST['subtotal']);
    $descuento      = floatval($_POST['descuento']);
    $impuesto       = floatval($_POST['impuesto']);
    $total          = floatval($_POST['total']);
    $pago_recibido  = floatval($_POST['pago_recibido']);
    $cambio         = floatval($_POST['cambio']);

    $stmt_update = $conn->prepare("
        UPDATE ventas SET 
            id_cliente=?, id_usuario=?, subtotal=?, descuento=?, impuesto=?, total=?, 
            pago_recibido=?, cambio=?, id_metodo_pago=?, observacion=?, estado=? 
        WHERE id=?
    ");
    $stmt_update->bind_param(
        "iidddddisssi",
        $id_cliente, $id_usuario, $subtotal, $descuento, $impuesto, $total,
        $pago_recibido, $cambio, $id_metodo_pago, $observacion, $estado, $id
    );

    if ($stmt_update->execute()) {
        foreach ($_POST['productos'] as $prod_id => $data) {
            $cantidad = intval($data['cantidad']);
            $precio   = floatval($data['precio_unitario']);
            $sub_prod = $cantidad * $precio;

            $stmt_det = $conn->prepare("
                UPDATE ventas_detalles
                SET cantidad=?, precio_unitario=?, subtotal=?
                WHERE id_venta=? AND id_producto=?
            ");
            $stmt_det->bind_param("iddii", $cantidad, $precio, $sub_prod, $id, $prod_id);
            $stmt_det->execute();
        }
        header("Location: listar.php?success=Venta actualizada");
        exit();
    } else {
        echo "Error al actualizar la venta.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Venta</title>
    <link rel="stylesheet" href="venta.css">
    <script>
        function recalcularTotales() {
            let subtotal = 0;
            document.querySelectorAll(".fila-producto").forEach(row => {
                const cantidad = parseFloat(row.querySelector(".cantidad").value) || 0;
                const precio   = parseFloat(row.querySelector(".precio_unitario").value) || 0;
                const sub      = cantidad * precio;
                row.querySelector(".subtotal-producto").textContent = "$" + sub.toFixed(2);
                subtotal += sub;
            });

            let descuento = subtotal * 0.05;
            let impuesto  = (subtotal - descuento) * 0.18;
            let total     = subtotal - descuento + impuesto;
            let pago      = parseFloat(document.getElementById("pago_recibido").value) || 0;
            let cambio    = pago - total;

            document.getElementById("subtotal").value  = subtotal.toFixed(2);
            document.getElementById("descuento").value = descuento.toFixed(2);
            document.getElementById("impuesto").value  = impuesto.toFixed(2);
            document.getElementById("total").value    = total.toFixed(2);
            document.getElementById("cambio").value   = cambio.toFixed(2);
        }
    </script>
</head>
<body>
<div class="container">
    <h2>Editar Venta</h2>

    <form method="POST" class="editar-venta-form">

        <div class="form-section">
            <div class="form-block">
                <label>Cliente:</label>
                <select name="id_cliente" required>
                    <option value="">Seleccione un cliente</option>
                    <?php while($cli = $res_clientes->fetch_assoc()): ?>
                        <option value="<?= $cli['id'] ?>" <?= $cli['id'] == $venta['id_cliente'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cli['nombre'] . ' ' . $cli['apellido']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-block">
                <label>Usuario:</label>
                <select name="id_usuario" required>
                    <?php while($u = $res_usuarios->fetch_assoc()): ?>
                        <option value="<?= $u['id'] ?>" <?= $u['id'] == $venta['id_usuario'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($u['usuario']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-block">
                <label>Método de Pago:</label>
                <select name="id_metodo_pago" required>
                    <?php while($m = $res_metodos->fetch_assoc()): ?>
                        <option value="<?= $m['id'] ?>" <?= $m['id'] == $venta['id_metodo_pago'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($m['metodo']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>

        <div class="title-box">
            <h3>Productos</h3>
        </div>

        <div class="product-table-container">
            <?php while ($prod = $res_productos->fetch_assoc()): ?>
                <div class="fila-producto">
                    <div class="producto-nombre">
                        <label><?= htmlspecialchars($prod['nombre']) ?>:</label>
                    </div>
                    <div class="producto-cantidad">
                        <input type="number" class="cantidad"
                               name="productos[<?= $prod['id'] ?>][cantidad]"
                               value="<?= $prod['cantidad'] ?>"
                               min="0" oninput="recalcularTotales()">
                    </div>
                    <div class="producto-precio-label">
                        <label>Precio:</label>
                    </div>
                    <div class="producto-precio-input">
                        <input type="number" step="0.01" class="precio_unitario"
                               name="productos[<?= $prod['id'] ?>][precio_unitario]"
                               value="<?= $prod['precio_unitario'] ?>"
                               oninput="recalcularTotales()">
                    </div>
                    <div class="producto-subtotal">
                        <span class="subtotal-producto">
                            $<?= number_format($prod['cantidad'] * $prod['precio_unitario'], 2) ?>
                        </span>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <div class="totales-section">
            <div class="total-block">
                <label>Subtotal:</label>
                <input type="text" id="subtotal" name="subtotal"
                           value="<?= $venta['subtotal'] ?>" readonly>
            </div>
            <div class="total-block">
                <label>Descuento:</label>
                <input type="text" id="descuento" name="descuento"
                           value="<?= $venta['descuento'] ?>" readonly>
            </div>
            <div class="total-block">
                <label>Impuesto:</label>
                <input type="text" id="impuesto" name="impuesto"
                           value="<?= $venta['impuesto'] ?>" readonly>
            </div>
            <div class="total-block">
                <label>Total:</label>
                <input type="text" id="total" name="total"
                           value="<?= $venta['total'] ?>" readonly>
            </div>
            <div class="total-block">
                <label>Pago Recibido:</label>
                <input type="number" step="0.01" id="pago_recibido"
                               name="pago_recibido"
                               value="<?= $venta['pago_recibido'] ?>"
                               oninput="recalcularTotales()">
            </div>
            <div class="total-block">
                <label>Cambio:</label>
                <input type="text" id="cambio" name="cambio"
                           value="<?= $venta['cambio'] ?>" readonly>
            </div>
        </div>

        <div class="observaciones-section">
            <div class="observaciones">
                <label>Observación:</label>
                <textarea name="observacion"><?= htmlspecialchars($venta['observacion']) ?></textarea>
            </div>
            <div class="estado-venta">
                <label>Estado:</label>
                <select name="estado" required>
                    <option value="completada" <?= $venta['estado'] == 'completada' ? 'selected' : '' ?>>
                        Completada
                    </option>
                    <option value="pendiente" <?= $venta['estado'] == 'pendiente' ? 'selected' : '' ?>>
                        Pendiente
                    </option>
                    <option value="anulada" <?= $venta['estado'] == 'anulada' ? 'selected' : '' ?>>
                        Anulada
                    </option>
                </select>
            </div>
        </div>

        <div class="form-buttons">
            <button type="submit">Actualizar Venta</button>
        </div>
    </form>

    <a href="listar.php" class="back-button">Volver</a>
</div>
</body>
</html>

<?php $conn->close(); ?>