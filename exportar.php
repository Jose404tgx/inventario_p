<?php include "config/database.php"; 

$desde = $_GET['desde'] ?? '';
$hasta = $_GET['hasta'] ?? '';

if (!$desde || !$hasta) {
    die("Fechas requeridas");
}

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=reporte.csv');

$stmt = $db->pdo->prepare("SELECT * FROM productos WHERE fecha BETWEEN ? AND ?");
$stmt->execute([$desde, $hasta]);
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$output = fopen("php://output", "w");
fputcsv($output, ["ID", "Nombre", "Precio", "Stock", "Fecha"]);

foreach($productos as $p) {
    fputcsv($output, [
        $p['id'],
        $p['nombre'],
        $p['precio'],
        $p['stock'],
        $p['fecha']
    ]);
}

fclose($output);