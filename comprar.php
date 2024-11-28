<?php
include 'conexion.php';

// Verificar si se ha enviado el formulario con los datos
if (isset($_POST['id']) && isset($_POST['cantidad'])) {
    $producto_id = $_POST['id'];
    $cantidad = $_POST['cantidad'];

    // Comenzar la transacción
    $conexion->begin_transaction();

    try {
        // Consultar el stock del producto
        $sql = "SELECT stock FROM productoss WHERE id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $producto_id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($stock);
        $stmt->fetch();

        // Verificar si hay suficiente stock
        if ($stock >= $cantidad) {
            // Reducir el stock
            $nuevo_stock = $stock - $cantidad;
            $update_sql = "UPDATE productoss SET stock = ? WHERE id = ?";
            $update_stmt = $conexion->prepare($update_sql);
            $update_stmt->bind_param("ii", $nuevo_stock, $producto_id);
            $update_stmt->execute();

            // Confirmar transacción
            $conexion->commit();
            $mensaje = "<div style='color:green;'>Compra realizada exitosamente.</div>";
        } else {
            $mensaje = "<div style='color:red;'>Lo sentimos, no hay suficiente stock.</div>";
            $conexion->rollback(); // Deshacer si no hay stock suficiente
        }

    } catch (Exception $e) {
        // Si ocurre un error, deshacer la transacción
        $conexion->rollback();
        $mensaje = "<div style='color:red;'>Error: " . $e->getMessage() . "</div>";
    }

} else {
    $mensaje = "<div style='color:red;'>Por favor, complete todos los campos.</div>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra Tortas</title>
</head>
<body>
    <h1>Resultado de la Compra</h1>
    <?php echo isset($mensaje) ? $mensaje : ''; ?>
    <a href="index.php">Volver a la tienda</a>
</body>
</html>

