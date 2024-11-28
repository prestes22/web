<?php
include 'conexion.php';

// Consultar las tortas disponibles
$query = "SELECT * FROM productoss WHERE stock > 0";
$result = $conexion->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprar Tortas</title>
</head>
<body>
    <h1>Tortas Disponibles</h1>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Comprar</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($torta = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $torta['nombre']; ?></td>
                    <td><?php echo $torta['precio']; ?></td>
                    <td><?php echo $torta['stock']; ?></td>
                    <td>
                        <form action="comprar.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo $torta['id']; ?>">
                            <input type="number" name="cantidad" value="1" min="1" max="<?php echo $torta['stock']; ?>">
                            <button type="submit">Comprar</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>

