<?php
include "../config/conexion.php";

$error_message   = "";
$success_message = "";

$res_clientes = $conn->query("SELECT id, nombre FROM clientes");
$res_productos = $conn->query("SELECT id, nombre_producto, precio FROM productos");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cliente_id   = $_POST['cliente_id']   ?? '';
    $fecha_venta = $_POST['fecha_venta'] ?? '';
    $pago_recibido = floatval($_POST['pago_recibido'] ?? 0);

    $productosPost = $_POST['productos'] ?? [];
    $preciosPost   = $_POST['precios']   ?? [];
    $tiene_producto = false;

    foreach ($productosPost as $cant) {
        if (intval($cant) > 0) { $tiene_producto = true; break; }
    }

    if (empty($cliente_id) || empty($fecha_venta)) {
        $error_message = "Todos los campos son obligatorios (cliente y fecha).";
    } elseif (!$tiene_producto) {
        $error_message = "Debes seleccionar al menos un producto con cantidad mayor a 0.";
    }

    if (empty($error_message)) {
        $subtotal = 0;
        foreach ($productosPost as $prod_id => $cant) {
            $cantInt = intval($cant);
            if ($cantInt > 0) {
                $precio = floatval($preciosPost[$prod_id] ?? 0);
                $subtotal += ($cantInt * $precio);
            }
        }

        $descuento = $subtotal * 0.05;
        $impuesto  = ($subtotal - $descuento) * 0.18;
        $total     = $subtotal - $descuento + $impuesto;
        $cambio    = max(0, $pago_recibido - $total);

        $conn->begin_transaction();
        try {
            $sql_venta = "INSERT INTO ventas (cliente_id, fecha_venta, subtotal, descuento, impuesto, total, pago_recibido, cambio)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt_venta = $conn->prepare($sql_venta);
            $stmt_venta->bind_param("isdddddd", $cliente_id, $fecha_venta, $subtotal, $descuento, $impuesto, $total, $pago_recibido, $cambio);
            if (!$stmt_venta->execute()) throw new Exception("Error al insertar la venta: " . $stmt_venta->error);
            $id_venta = $conn->insert_id;

            $sql_detalle = "INSERT INTO detalle_venta (id_venta, producto_id, cantidad) VALUES (?, ?, ?)";
            $stmt_detalle = $conn->prepare($sql_detalle);

            foreach ($productosPost as $prod_id => $cant) {
                $cantInt = intval($cant);
                if ($cantInt > 0) {
                    $stmt_detalle->bind_param("iii", $id_venta, $prod_id, $cantInt);
                    if (!$stmt_detalle->execute()) throw new Exception("Error al insertar detalle: " . $stmt_detalle->error);
                }
            }
            $conn->commit();
            header("Location: listar.php?success=" . urlencode("Venta registrada correctamente."));
            exit();
        } catch (Exception $e) {
            $conn->rollback();
            $error_message = $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Venta</title>
    <link rel="stylesheet" href="venta.css">
    <script>
        function actualizarTotales() {
            let subtotal = 0;
            document.querySelectorAll('.fila-producto').forEach(row => {
                const c = parseFloat(row.querySelector('.cantidad').value) || 0;
                const p = parseFloat(row.querySelector('.precio').value) || 0;
                const sub = c * p;
                row.querySelector('.subtotal').textContent = "$" + sub.toFixed(2);
                subtotal += sub;
            });
            let descuento = subtotal * 0.05;
            let impuesto  = (subtotal - descuento) * 0.18;
            let total     = subtotal - descuento + impuesto;
            document.getElementById('subtotal').value = subtotal.toFixed(2);
            document.getElementById('descuento').value = descuento.toFixed(2);
            document.getElementById('impuesto').value = impuesto.toFixed(2);
            document.getElementById('total').value = total.toFixed(2);
            calcularCambio();
        }

        function calcularCambio() {
            let pago = parseFloat(document.getElementById('pago_recibido').value) || 0;
            let total = parseFloat(document.getElementById('total').value) || 0;
            let cambio = pago - total;
            document.getElementById('cambio').value = cambio.toFixed(2);
            document.getElementById('cambio').style.color = (cambio < 0) ? "red" : "black";
        }

        function filtrarProductos() {
            const input = document.getElementById('filtro-productos').value.toLowerCase();
            document.querySelectorAll('.fila-producto').forEach(row => {
                const nombre = row.querySelector('.nombre-producto').textContent.toLowerCase();
                row.style.display = nombre.includes(input) ? '' : 'none';
            });
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Registrar Nueva Venta</h2>
        <?php if (!empty($error_message)): ?><p style="color:red;"><?= $error_message ?></p><?php endif; ?>
        <form method="POST">

            <label>Cliente:</label>
            <select name="cliente_id" required>
                <option value="">Seleccione un cliente</option>
                <?php while ($cli = $res_clientes->fetch_assoc()): ?>
                    <option value="<?= $cli['id'] ?>"><?= htmlspecialchars($cli['nombre']) ?></option>
                <?php endwhile; ?>
            </select>

            <label>Fecha de Venta:</label>
            <input type="date" name="fecha_venta" required>

            <label>Buscar Productos:</label>
            <input type="text" id="filtro-productos" placeholder="🔍 Filtrar..." onkeyup="filtrarProductos()">

            <table class="table">
                <thead><tr><th>Producto</th><th>Cantidad</th><th>Precio</th><th>Subtotal</th></tr></thead>
                <tbody>
                <?php $res_productos->data_seek(0); while ($p = $res_productos->fetch_assoc()): ?>
                    <tr class="fila-producto">
                        <td class="nombre-producto"><?= htmlspecialchars($p['nombre_producto']) ?></td>
                        <td><input type="number" class="cantidad" name="productos[<?= $p['id'] ?>]" min="0" value="0" step="1" oninput="actualizarTotales()"></td>
                        <td><input type="text" class="precio" value="<?= $p['precio'] ?>" readonly name="precios[<?= $p['id'] ?>]"></td>
                        <td><span class="subtotal">$0.00</span></td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>

            <label>Subtotal:</label><input type="text" id="subtotal" readonly>
            <label>Descuento (5%):</label><input type="text" id="descuento" readonly>
            <label>Impuesto (18%):</label><input type="text" id="impuesto" readonly>
            <label>Total:</label><input type="text" id="total" name="total_venta" readonly>
            <label>Pago Recibido:</label><input type="number" id="pago_recibido" name="pago_recibido" step="0.01" oninput="calcularCambio()" required>
            <label>Cambio:</label><input type="text" id="cambio" readonly>

            <button type="submit">Registrar Venta</button>
        </form>

        <a href="listar.php" class="action-button">Ver Ventas</a>
        <a href="../menuprincipal/menu.php" class="back-button">Volver al Menú</a>
    </div>
</body>
</html>