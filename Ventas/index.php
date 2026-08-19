<?php
include "../config/conexion.php";

$error_message = "";

$res_clientes  = $conn->query("SELECT id, nombre, apellido FROM clientes");
$res_productos = $conn->query("SELECT id, nombre, precio FROM productos");
$res_metodos   = $conn->query("SELECT id, metodo FROM metodos_pago");
$res_usuarios  = $conn->query("SELECT id, usuario FROM usuarios");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_cliente     = $_POST['id_cliente']     ?? '';
    $id_usuario     = $_POST['id_usuario']     ?? '';
    $id_metodo_pago = $_POST['id_metodo_pago'] ?? '';
    $estado         = $_POST['estado']         ?? 'pendiente';
    $observacion    = $_POST['observacion']    ?? '';
    $pago_recibido  = floatval($_POST['pago_recibido'] ?? 0);

    $productosPost = $_POST['productos'] ?? [];
    $preciosPost   = $_POST['precios']   ?? [];

    if (empty($id_cliente) || empty($id_usuario) || empty($id_metodo_pago)) {
        $error_message = "Completa todos los campos obligatorios.";
    }

    $hayProducto = false;
    foreach ($productosPost as $cant) {
        if (intval($cant) > 0) {
            $hayProducto = true;
            break;
        }
    }
    if (!$hayProducto) {
        $error_message = "Debes seleccionar al menos un producto con cantidad mayor a 0.";
    }

    if (empty($error_message)) {
        $subtotal = 0;
        foreach ($productosPost as $prod_id => $cant) {
            $cant = intval($cant);
            if ($cant > 0) {
                $precio = floatval($preciosPost[$prod_id]);
                $subtotal += $cant * $precio;
            }
        }

        $descuento = $subtotal * 0.05;
        $impuesto  = ($subtotal - $descuento) * 0.18;
        $total     = $subtotal - $descuento + $impuesto;
        $cambio    = max(0, $pago_recibido - $total);

        $sql = "INSERT INTO ventas 
                    (id_cliente, total, fecha, estado, subtotal, descuento, impuesto, 
                     pago_recibido, cambio, id_metodo_pago, observacion, id_usuario) 
                VALUES (?, ?, NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "idddddddisi",
            $id_cliente,
            $total,
            $estado,
            $subtotal,
            $descuento,
            $impuesto,
            $pago_recibido,
            $cambio,
            $id_metodo_pago,
            $observacion,
            $id_usuario
        );

        if ($stmt->execute()) {
            $id_venta = $conn->insert_id;

            $sql_detalle = "INSERT INTO ventas_detalles 
                                    (id_venta, id_producto, cantidad, precio_unitario, subtotal)
                                VALUES (?, ?, ?, ?, ?)";
            $stmt_detalle = $conn->prepare($sql_detalle);

            foreach ($productosPost as $prod_id => $cant) {
                $cant = intval($cant);
                if ($cant > 0) {
                    $precio_unitario  = floatval($preciosPost[$prod_id]);
                    $subtotal_producto = $cant * $precio_unitario;
                    $stmt_detalle->bind_param("iiidd",
                        $id_venta, $prod_id, $cant, $precio_unitario, $subtotal_producto
                    );
                    $stmt_detalle->execute();
                }
            }

            header("Location: listar.php?success=Venta registrada correctamente.");
            exit();
        } else {
            $error_message = "Error al guardar la venta: " . $conn->error;
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
            const filas = document.querySelectorAll('.fila-producto');
            filas.forEach(row => {
                const c = parseFloat(row.querySelector('.cantidad').value) || 0;
                const p = parseFloat(row.querySelector('.precio').value) || 0;
                const sub = c * p;
                row.querySelector('.subtotal').textContent = '$' + sub.toFixed(2);
                subtotal += sub;
            });

            const desc = subtotal * 0.05;
            const imp  = (subtotal - desc) * 0.18;
            const total = subtotal - desc + imp;

            document.getElementById('subtotal').value  = subtotal.toFixed(2);
            document.getElementById('descuento').value = desc.toFixed(2);
            document.getElementById('impuesto').value  = imp.toFixed(2);
            document.getElementById('total').value    = total.toFixed(2);

            const pago = parseFloat(document.getElementById('pago_recibido').value) || 0;
            document.getElementById('cambio').value   = (pago - total).toFixed(2);
        }

        function filtrarProductos() {
            const input = document.getElementById('filtro-productos').value.toLowerCase();
            const filas = document.querySelectorAll('.fila-producto');
            filas.forEach(row => {
                const nombre = row.querySelector('.nombre-producto').textContent.toLowerCase();
                row.style.display = nombre.includes(input) ? '' : 'none';
            });
        }
    </script>
</head>
<body>
<div class="container">
    <h2>Registrar Venta</h2>

    <form method="POST" class="registrar-venta-form">
        <?php if (!empty($error_message)): ?>
            <p style="color: red;"><?= $error_message ?></p>
        <?php endif; ?>

        <div class="form-section">
            <div class="form-block">
                <label>Cliente:</label>
                <select name="id_cliente" required>
                    <option value="">Seleccione un cliente</option>
                    <?php while ($cli = $res_clientes->fetch_assoc()): ?>
                        <option value="<?= $cli['id'] ?>">
                            <?= htmlspecialchars($cli['nombre'] . ' ' . $cli['apellido']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-block">
                <label>Usuario:</label>
                <select name="id_usuario" required>
                    <option value="">Seleccione un usuario</option>
                    <?php while ($u = $res_usuarios->fetch_assoc()): ?>
                        <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['usuario']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-block">
                <label>Método de Pago:</label>
                <select name="id_metodo_pago" required>
                    <option value="">Seleccione método</option>
                    <?php while ($m = $res_metodos->fetch_assoc()): ?>
                        <option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['metodo']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>

        <div class="buscador-productos">
            <label for="filtro-productos">Buscar Productos:</label>
            <input type="text" id="filtro-productos" placeholder=" Buscar..." onkeyup="filtrarProductos()">
        </div>

        <div class="product-table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $res_productos->data_seek(0); ?>
                    <?php while ($p = $res_productos->fetch_assoc()): ?>
                        <tr class="fila-producto">
                            <td class="nombre-producto">
                                <?= htmlspecialchars($p['nombre']) ?>
                            </td>
                            <td>
                                <input type="number"
                                       class="cantidad"
                                       name="productos[<?= $p['id'] ?>]"
                                       value="0"
                                       min="0"
                                       oninput="actualizarTotales()">
                            </td>
                            <td>
                                <input type="text"
                                       class="precio"
                                       value="<?= $p['precio'] ?>"
                                       name="precios[<?= $p['id'] ?>]"
                                       readonly>
                            </td>
                            <td>
                                <span class="subtotal">$0.00</span>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div class="totales-section">
            <div class="total-block">
                <label for="subtotal">Subtotal:</label>
                <input type="text" id="subtotal" readonly>
            </div>
            <div class="total-block">
                <label for="descuento">Descuento:</label>
                <input type="text" id="descuento" readonly>
            </div>
            <div class="total-block">
                <label for="impuesto">Impuesto:</label>
                <input type="text" id="impuesto" readonly>
            </div>
            <div class="total-block">
                <label for="total">Total:</label>
                <input type="text" id="total" readonly>
            </div>
            <div class="total-block">
                <label for="pago_recibido">Pago Recibido:</label>
                <input type="number" id="pago_recibido" name="pago_recibido"
                       oninput="actualizarTotales()" required>
            </div>
            <div class="total-block">
                <label for="cambio">Cambio:</label>
                <input type="text" id="cambio" readonly>
            </div>
        </div>

        <div class="observaciones-section">
            <div class="observaciones">
                <label>Observación:</label>
                <textarea name="observacion" placeholder="Observaciones..."></textarea>
            </div>
            <div class="estado-venta">
                <label>Estado:</label>
                <select name="estado" required>
                    <option value="pendiente">Pendiente</option>
                    <option value="completada">Completada</option>
                    <option value="anulada">Anulada</option>
                </select>
            </div>
        </div>

        <div class="form-buttons">
            <button type="submit">Registrar Venta</button>
        </div>
    </form>

    <a href="listar.php" class="action-button">Ver Lista De Ventas</a>
    <a href="../menuprincipal/menu.php" class="back-button">Ir al Menú Principal</a>
</div>
</body>
</html>

<?php $conn->close(); ?>