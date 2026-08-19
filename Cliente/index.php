<?php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Clientes</title>
    <link rel="stylesheet" href="estilosss.css">
</head>
<body>
<div class="container">
    <h1>REGISTRO DE CLIENTES</h1>

    <form action="insertar.php" method="POST">
        <div class="form-row">
            <div class="form-group">
                <label>Nombre:</label>
                <input type="text" name="nombre">
            </div>
            <div class="form-group">
                <label>Apellido:</label>
                <input type="text" name="apellido">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Contacto Principal:</label>
                <input type="text" name="contacto">
            </div>
            <div class="form-group">
                <label>Teléfono:</label>
                <input type="text" name="telefono">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email">
            </div>
            <div class="form-group">
                <label>RNC:</label>
                <input type="text" name="rnc">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Dirección Facturación:</label>
                <textarea name="direccion_facturacion"></textarea>
            </div>
            <div class="form-group">
                <label>Dirección Envío:</label>
                <textarea name="direccion_envio"></textarea>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Tipo de Cliente:</label>
                <select name="tipo_cliente">
                    <option value="Minorista">Minorista</option>
                    <option value="Mayorista">Mayorista</option>
                    <option value="Corporativo">Corporativo</option>
                </select>
            </div>
            <div class="form-group">
                <label>Condiciones de Pago:</label>
                <select name="condiciones_pago">
                    <option value="Contado">Contado</option>
                    <option value="Crédito">Crédito</option>
                    <option value="Pagos Parciales">Pagos Parciales</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Estado:</label>
                <select name="estado">
                    <option value="Activo">Activo</option>
                    <option value="Inactivo">Inactivo</option>
                </select>
            </div>
        </div>

        <button type="submit">Registrar Cliente</button>
    </form>

    <a href="listar.php" class="view-list-button">Ver lista de clientes</a>
    <a href="../menuprincipal/menu.php" class="back-button">Volver</a>

    

</div>
</body>
</html>
