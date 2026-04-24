<?php include "config/database.php"; 

$desde = $_GET['desde'] ?? '';
$hasta = $_GET['hasta'] ?? '';
$data = [];

if($desde && $hasta){
    $data = $db->raw("productos", [
        "fecha" => "gte.$desde",
        "fecha" => "lte.$hasta"
    ]);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<div class="container">
<h1>Reporte de Productos</h1>

<form method="GET" class="filters">
    <div class="grupo">
        <label>Desde</label>
        <input type="date" name="desde" value="<?= htmlspecialchars($desde) ?>">
    </div>
    <div class="grupo">
        <label>Hasta</label>
        <input type="date" name="hasta" value="<?= htmlspecialchars($hasta) ?>">
    </div>
    <div class="acciones">
        <button type="submit" class="btn">Buscar</button>
        <a href="index.php"><button type="button" class="btn">Volver</button></a>
    </div>
</form>

<div style="text-align:center; margin:15px;">
<?php if($desde && $hasta): ?>
    <a href="exportar.php?desde=<?= urlencode($desde) ?>&hasta=<?= urlencode($hasta) ?>">
        <button class="btn">Exportar CSV</button>
    </a>
<?php endif; ?>
</div>

<table>
<thead>
<tr>
<th>ID</th><th>Nombre</th><th>Precio</th><th>Stock</th><th>Fecha</th>
</tr>
</thead>

<tbody>
<?php foreach($data as $d): ?>
<tr>
<td><?= $d['id'] ?></td>
<td><?= htmlspecialchars($d['nombre']) ?></td>
<td>S/. <?= number_format($d['precio'], 2) ?></td>
<td><?= (int)$d['stock'] ?></td>
<td><?= $d['fecha'] ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

</div>

</body>
</html>