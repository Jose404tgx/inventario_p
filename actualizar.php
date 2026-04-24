<?php 
include "config/auth.php"; 
include "config/database.php"; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);
    $nombre = trim($_POST['nombre'] ?? '');
    $precio = floatval($_POST['precio'] ?? 0);
    $stock = intval($_POST['stock'] ?? 0);
    $categoria_id = intval($_POST['categoria_id'] ?? 0);
    
    if ($id && $nombre && $precio > 0 && $stock >= 0) {
        try {
            $db->update("productos", $id, [
                "nombre" => $nombre,
                "precio" => $precio,
                "stock" => $stock,
                "categoria_id" => $categoria_id
            ]);
            header("Location: index.php");
            exit;
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
    } else {
        die("Datos inválidos");
    }
}

header("Location: index.php");