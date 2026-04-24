<?php include "config/database.php"; 

$productos = $db->select("productos", [], "categorias");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<div class="container">
    <h1>Sistema de Inventario</h1>

    <div class="actions">
        <a href="agregar.php"><button class="btn">+ Agregar</button></a>
        <a href="reporte.php"><button class="btn">Reporte</button></a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th><th>Nombre</th><th>Precio</th>
                <th>Stock</th><th>Categoría</th><th>Fecha</th><th>Acciones</th>
            </tr>
        </thead>

        <tbody>
        <?php if($productos): foreach($productos as $p): 
            $stock = (int)$p['stock'];
            $stockClass = $stock >= 51 ? 'stock-green' : ($stock >= 11 ? 'stock-yellow' : 'stock-red');
        ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><?= htmlspecialchars($p['nombre']) ?></td>
                <td>S/. <?= number_format($p['precio'], 2) ?></td>
                <td><span class="stock-indicator <?= $stockClass ?>"><?= $stock ?></span></td>
                <td><?= htmlspecialchars($p['categoria'] ?? 'Sin categoría') ?></td>
                <td><?= $p['fecha'] ?></td>
                <td>
                    <a href="editar.php?id=<?= $p['id'] ?>"><button class="btn">Editar</button></a>
                    <a href="eliminar.php?id=<?= $p['id'] ?>" onclick="return confirm('¿Eliminar?')"><button class="btn">Eliminar</button></a>
                </td>
            </tr>
        <?php endforeach; else: ?>
            <tr><td colspan="7">No hay productos</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>