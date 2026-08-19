<?php
include "../config/conexion.php";

$id = $_GET["id"];

$sql = "SELECT * FROM clientes WHERE id = $id";
$res = $conn->query($sql);

$fila = $res->fetch_assoc();


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Cliente</title>
    <link rel="stylesheet" href="estilosss.css"> 
<body>
<div class="container">
    <h1>Editar Cliente</h1>

    <form action="actualizar.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $fila["id"]; ?>">

        <div class="form-row">
            <div class="form-group">
                <label>Nombre:</label>
                <input type="text" name="nombre" value="<?php echo $fila["nombre"]; ?>">
            </div>
            <div class="form-group">
                <label>Apellido:</label>
                <input type="text" name="apellido" value="<?php echo $fila["apellido"]; ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Contacto Principal:</label>
                <input type="text" name="contacto" value="<?php echo $fila["contacto"]; ?>">
            </div>
            <div class="form-group">
                <label>Teléfono:</label>
                <input type="text" name="telefono" value="<?php echo $fila["telefono"]; ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" value="<?php echo $fila["email"]; ?>">
            </div>
            <div class="form-group">
                <label>RNC:</label>
                <input type="text" name="rnc" value="<?php echo $fila["rnc"]; ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Dirección Facturación:</label>
                <textarea name="direccion_facturacion"><?php echo $fila["direccion_facturacion"]; ?></textarea>
            </div>
            <div class="form-group">
                <label>Dirección Envío:</label>
                <textarea name="direccion_envio"><?php echo $fila["direccion_envio"]; ?></textarea>
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


        <?php echo $fila["id_proveedor"]; ?>
            
    

        <button type="submit">Actualizar Cliente</button>
    </form>

    <a href="listar.php" class="back-button">Volver</a>
</div>
</body>
</html>
