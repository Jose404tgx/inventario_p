<?php include "config/database.php"; 

$desde = $_GET['desde'] ?? '';
$hasta = $_GET['hasta'] ?? '';

if (!$desde || !$hasta) {
    die("Fechas requeridas");
}

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=reporte.csv');

$productos = $db->select("productos", [
    "fecha" => "gte.$desde",
    "fecha" => "lte.$hasta"
]);

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