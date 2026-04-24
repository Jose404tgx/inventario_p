-- Tablas para inventario en Supabase (PostgreSQL)

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
    precio DECIMAL(10, 2) NOT NULL CHECK (precio >= 0),
    stock INT NOT NULL CHECK (stock >= 0),
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
    ('Silla ergonómica', 450.00, 15, 4, CURRENT_DATE)
ON CONFLICT DO NOTHING;