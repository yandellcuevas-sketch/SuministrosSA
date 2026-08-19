<?php
include "../config/conexion.php";

$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    die("ID no válido.");
}

$query_inventario = "DELETE FROM inventario WHERE id_producto = ?";
$stmt_inv = $conn->prepare($query_inventario);
$stmt_inv->bind_param("i", $id);

if (!$stmt_inv->execute()) {
    die("Error al eliminar del inventario: " . $stmt_inv->error);
}

$query_producto = "DELETE FROM productos WHERE id = ?";
$stmt_prod = $conn->prepare($query_producto);
$stmt_prod->bind_param("i", $id);

if (!$stmt_prod->execute()) {
    die("Error al eliminar el producto: " . $stmt_prod->error);
}

header("Location: listar.php");
exit();
?>
