<?php
include "../config/conexion.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Compras</title>
    <link rel="stylesheet" href="estilosss.css">
</head>
<body>
    <div class="container">
        <h2>Historial de Compras</h2>
        
        <form action="resultado.php" method="GET">
            <label>Fecha:</label>
            <input type="date" name="fecha">

            <label>Cliente:</label>
            <select name="id_cliente">
                <option value="">Todos</option>
                <?php
                $clienteQuery = "SELECT id, nombre FROM clientes";
                $clienteRes = $conn->query($clienteQuery);
                while ($cliente = $clienteRes->fetch_assoc()) {
                    echo "<option value='{$cliente["id"]}'>{$cliente["nombre"]}</option>";
                }
                ?>
            </select>

            <label>Estado:</label>
            <select name="estado">
                <option value="">Todos</option>
                <option value="Pendiente">Pendiente</option>
                <option value="En Tránsito">En Tránsito</option>
                <option value="Entregada">Entregada</option>
                <option value="Cancelada">Cancelada</option>
            </select>

            <button type="submit">Filtrar</button>

            <a class="back-button" href="http://localhost:8080/Suministros%20SA/menuprincipal/menu.php">Volver</a>
        </form>
    </div>
</body>
</html>
