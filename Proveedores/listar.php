<?php
include("../config/conexion.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Proveedores</title>
    <link rel="stylesheet" href="estiloss.css">
</head>
<body>
    <div class="container">
        <h2>Lista de Proveedores</h2>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Empresa</th>
                        <th>Contacto</th>
                        <th>Teléfono</th>
                        <th>Correo</th>
                        <th>Dirección</th>
                        <th>Entrega</th>
                        <th>Pago</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM proveedores ORDER BY id DESC";
                    $result = $conn->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['nombre_empresa']}</td>
                                <td>{$row['contacto']}</td>
                                <td>{$row['telefono']}</td>
                                <td>{$row['correo']}</td>
                                <td>{$row['direccion']}</td>
                                <td>{$row['tiempo_entrega']} días</td>
                                <td>{$row['condiciones_pago']}</td>
                                <td>{$row['estado']}</td>
                                <td class='acciones'>
                                    <a href='editar.php?id={$row['id']}' class='edit-button'>Editar</a>
                                    <a href='eliminar.php?id={$row['id']}' class='delete-button' onclick='return confirm(\"¿Estás seguro de eliminar este proveedor?\")'>Eliminar</a>
                                </td>
                            </tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>

        <div class="extra-links">
            <a href="index.php" class="back-button">Volver</a>
        </div>
    </div>
</body>
</html>
