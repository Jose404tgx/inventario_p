<?php

$supabase_url = "https://iayiolnypcezhxilybzm.supabase.co";
$service_key = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImlheWlvbG55cGNlemh4aWx5YnptIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc3Njk4Mzc1NCwiZXhwIjoyMDkyNTU5NzU0fQ.bGEVrrCXz8YJdQXOCwAceBF75lXbEIVUXUs9v0PUCVw";

$schema = "
-- Tabla de categorías
CREATE TABLE IF NOT EXISTS categorias (
    id BIGSERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW()
);

-- Tabla de productos
CREATE TABLE IF NOT EXISTS productos (
    id BIGSERIAL PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL,
    categoria_id BIGINT REFERENCES categorias(id) ON DELETE SET NULL,
    fecha DATE NOT NULL DEFAULT CURRENT_DATE,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW()
);

-- Insertar categorías iniciales
INSERT INTO categorias (nombre) VALUES 
    ('Electrónica'),
    ('Ropa'),
    ('Alimentos'),
    ('Hogar'),
    ('Otros')
ON CONFLICT (nombre) DO NOTHING;

-- Insertar productos de ejemplo
INSERT INTO productos (nombre, precio, stock, categoria_id, fecha) VALUES
    ('Laptop HP', 2500.00, 10, 1, CURRENT_DATE),
    ('Celular Samsung', 1500.00, 25, 1, CURRENT_DATE),
    ('Camisa básica', 89.90, 50, 2, CURRENT_DATE),
    ('Arroz', 5.50, 100, 3, CURRENT_DATE),
    ('Silla ergonómica', 450.00, 15, 4, CURRENT_DATE);
";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $supabase_url . "/rest/v1/rpc/exec_sql");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'apikey: ' . $service_key,
    'Authorization: Bearer ' . $service_key,
    'Content-Type: application/json'
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['query' => $schema]));

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Code: $httpCode\n";
echo "Response: $response\n";