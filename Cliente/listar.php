<?php
include "../config/conexion.php";
$query = "SELECT * FROM clientes"; 
$resultado = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Clientes</title>
    <link rel="stylesheet" href="estilosss.css">
</head>
<body>
<div class="container">
    <h2>Lista de Clientes</h2>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Contacto</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>RNC</th>
                    <th>Tipo Cliente</th>
                    <th>Condiciones Pago</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                while ($fila = $resultado->fetch_assoc()):
                ?>
                <tr>
                    <td><?php echo $fila['id']; ?></td>
                    <td><?php echo $fila['nombre']; ?></td>
                    <td><?php echo $fila['apellido']; ?></td>
                    <td><?php echo $fila['contacto']; ?></td>
                    <td><?php echo $fila['telefono']; ?></td>
                    <td><?php echo $fila['email']; ?></td>
                    <td><?php echo $fila['rnc']; ?></td>
                    <td><?php echo $fila['tipo_cliente']; ?></td>
                    <td><?php echo $fila['condiciones_pago']; ?></td>
                    <td><?php echo $fila['estado']; ?></td>
                    <td class="acciones">
                        <a href="editar.php?id=<?php echo $fila['id']; ?>">Editar</a>
                        <a href="eliminar.php?id=<?php echo $fila['id']; ?>">Eliminar</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <a href="index.php" class="back-button">Volver</a>
</div>
</body>
</html>
<?php
$conn->close();
