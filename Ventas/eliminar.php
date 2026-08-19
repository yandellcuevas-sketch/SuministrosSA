<?php
include "../config/conexion.php";

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    header("Location: listar.php?error=" . urlencode("ID no válido."));
    exit();
}

try {
    $conn->begin_transaction();

    $stmt_check = $conn->prepare("SELECT id FROM ventas WHERE id = ?");
    $stmt_check->bind_param("i", $id);
    $stmt_check->execute();
    $res_check = $stmt_check->get_result();

    if ($res_check->num_rows === 0) {
        throw new Exception("La venta no existe o ya fue eliminada.");
    }

    $stmt_det = $conn->prepare("DELETE FROM ventas_detalles WHERE id_venta = ?");
    $stmt_det->bind_param("i", $id);
    if (!$stmt_det->execute()) {
        throw new Exception("Error al eliminar los detalles de la venta: " . $stmt_det->error);
    }

    $stmt_venta = $conn->prepare("DELETE FROM ventas WHERE id = ?");
    $stmt_venta->bind_param("i", $id);
    if (!$stmt_venta->execute()) {
        throw new Exception("Error al eliminar la venta: " . $stmt_venta->error);
    }

    $conn->commit();
    header("Location: listar.php?success=" . urlencode("Venta eliminada correctamente."));
    exit();

} catch (Exception $e) {
    $conn->rollback();
    header("Location: listar.php?error=" . urlencode("Error: " . $e->getMessage()));
    exit();
}
?>