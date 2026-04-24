<?php include "config/database.php"; 

$id = intval($_GET['id'] ?? 0);
$producto = $db->select("productos", ["id" => "eq.$id"]);
$producto = $producto[0] ?? null;

if (!$producto) {
    die("Producto no encontrado");
}

$categorias = $db->select("categorias");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<div class="container">
<h1>Editar Producto</h1>

<form action="actualizar.php" method="POST">
<input type="hidden" name="id" value="<?= $producto['id'] ?>">

<input name="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>"><br><br>
<input name="precio" value="<?= $producto['precio'] ?>"><br><br>
<input name="stock" value="<?= $producto['stock'] ?>"><br><br>

<select name="categoria_id">
<?php foreach($categorias as $c): ?>
<option value="<?= $c['id'] ?>" <?= $c['id']==$producto['categoria_id']?'selected':'' ?>>
<?= htmlspecialchars($c['nombre']) ?>
</option>
<?php endforeach; ?>
</select><br><br>

<div class="form-actions">
    <button class="btn">Actualizar</button>
    <a href="index.php"><button type="button" class="btn">Volver</button></a>
</div>
</form>
</div>

</body>
</html>