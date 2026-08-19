<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Menú Principal</title>
    <link rel="stylesheet" href="menu.css">
</head>
<body>
    <div class="menu-container">
        <div class="logo-container">
            <img src="dfctrack.jpg" alt="Logo">
            <h1>SUMINISTROS S.A.</h1>
        </div>

        <div class="menu-links">
            <a class="menu-link" href="http://localhost:8080/Suministros%20SA/Cliente/index.php">Clientes</a>
            <a class="menu-link" href="http://localhost:8080/Suministros%20SA/Proveedores/index.php">Proveedores</a>
            <a class="menu-link" href="http://localhost:8080/Suministros%20SA/Productos/index.php">Productos</a>
            <a class="menu-link" href="http://localhost:8080/Suministros%20SA/Compras/index.php">Compras</a>
            <!-- Botón de Inventario agregado -->
            <a class="menu-link" href="http://localhost:8080/Suministros%20SA/Inventario/index.php">Inventario</a>
            <a class="menu-link" href="http://localhost:8080/Suministros%20SA/Ventas/index.php">Ventas</a>
        </div>


        <div class="menu-links">
            <a class="menu-link historial" href="http://localhost:8080/Suministros%20SA/Compras/historial.php">Historial de Compras</a>
            <a class="menu-link detalles" href="http://localhost:8080/Suministros%20SA/Compras/detalle.php">Detalles de Compra</a>
        </div>

        <div class="menu-links">
            <a class="menu-link logout" href="http://localhost:8080/Suministros%20SA/LoginUser/logout.php">Cerrar Sesión</a>
        </div>
    
    </div>
</body>
</html>
