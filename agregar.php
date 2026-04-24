<?php 
include "config/auth.php"; 
include "config/database.php"; 

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $precio = floatval($_POST['precio'] ?? 0);
    $stock = intval($_POST['stock'] ?? 0);
    $categoria_id = intval($_POST['categoria_id'] ?? 0);
    
    if ($nombre && $precio > 0 && $stock >= 0) {
        try {
            $db->insert("productos", [
                "nombre" => $nombre,
                "precio" => $precio,
                "stock" => $stock,
                "categoria_id" => $categoria_id,
                "fecha" => date('Y-m-d')
            ]);
            header("Location: index.php");
            exit;
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    } else {
        $error = "Datos inválidos";
    }
}

$categorias = $db->select("categorias");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Producto</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<div class="container">
<h1>Agregar Producto</h1>

<?php if(isset($error)): ?>
<p style="color:red"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form action="agregar.php" method="POST">
    <input type="text" name="nombre" placeholder="Nombre" required><br><br>
    <input type="number" name="precio" step="0.01" placeholder="Precio" required><br><br>
    <input type="number" name="stock" placeholder="Stock" required><br><br>

    <select name="categoria_id">
        <?php foreach($categorias as $c): ?>
        <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nombre']) ?></option>
        <?php endforeach; ?>
    </select><br><br>

  <div class="form-actions">
    <button type="submit" class="btn">Guardar</button>
    <a href="index.php"><button type="button" class="btn">Volver</button></a>
  </div>
</form>
</div>

</body>
</html>