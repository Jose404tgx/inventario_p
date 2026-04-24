<?php include "config/database.php"; 

$id = intval($_GET['id'] ?? 0);

if ($id) {
    try {
        $db->delete("productos", $id);
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
}

header("Location: index.php");