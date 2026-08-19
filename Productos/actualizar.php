<?php
include("../config/conexion.php");

// Obtener el ID del producto a actualizar
$id = $_POST["id"];
$nombre = $_POST["nombre"];
$descripcion = $_POST["descripcion"];
$categoria = $_POST["categoria"];
$sku = $_POST["sku"];
$precio = $_POST["precio"];
$costo = $_POST["costo"];
$stock_actual = $_POST["stock_actual"];
$stock_minimo = $_POST["stock_minimo"];
$unidad_medida = $_POST["unidad_medida"];

// Verifica que la unidad de medida sea válida
$query_unidad = "SELECT * FROM unidades_medida WHERE id = '$unidad_medida'";
$res_unidad = $conn->query($query_unidad);

if ($res_unidad->num_rows == 0) {
    die("La unidad de medida seleccionada no existe.");
}

// Actualizar producto
$sql = "UPDATE productos SET 
            nombre = '$nombre', 
            descripcion = '$descripcion', 
            categoria = '$categoria', 
            sku = '$sku', 
            precio = '$precio', 
            costo = '$costo', 
            stock_actual = '$stock_actual', 
            stock_minimo = '$stock_minimo', 
            unidad_medida = '$unidad_medida' 
        WHERE id = '$id'";

if ($conn->query($sql)) {
    echo "<script>
            alert('Producto actualizado correctamente.');
            window.location.href='listar.php';
          </script>";
} else {
    echo "<script>
            alert('Error al actualizar el producto: " . $conn->error . "');
          </script>";
}

$conn->close();
?>
