-- Tablas para inventario

CREATE TABLE IF NOT EXISTS categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL,
    categoria_id INT DEFAULT NULL,
    fecha DATE NOT NULL DEFAULT (CURRENT_DATE),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO categorias (nombre) VALUES 
    ('Electrónica'),
    ('Ropa'),
    ('Alimentos'),
    ('Hogar'),
    ('Otros');

INSERT INTO productos (nombre, precio, stock, categoria_id) VALUES
    ('Laptop HP', 2500.00, 10, 1),
    ('Celular Samsung', 1500.00, 25, 1),
    ('Camisa básica', 89.90, 50, 2),
    ('Arroz', 5.50, 100, 3),
    ('Silla ergonómica', 450.00, 15, 4);

INSERT INTO usuarios (usuario, password, nombre) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrador');