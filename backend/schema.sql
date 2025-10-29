-- ============================================================================
-- SCHEMA DE BASE DE DATOS - Sistema de Gestión de Productos
-- ============================================================================
-- Versión: 1.0.0
-- Fecha: Octubre 2025
-- Autor: Sistema de Gestión de Productos
-- Descripción: Script SQL para crear la base de datos y tabla de productos
-- ============================================================================

-- ----------------------------------------------------------------------------
-- 1. CREAR BASE DE DATOS
-- ----------------------------------------------------------------------------
-- Si la base de datos existe, eliminarla (usar con precaución en producción)
DROP DATABASE IF EXISTS gestion_productos;

-- Crear la base de datos con charset UTF-8
CREATE DATABASE gestion_productos 
    CHARACTER SET utf8mb4 
    COLLATE utf8mb4_unicode_ci;

-- Seleccionar la base de datos
USE gestion_productos;

-- ----------------------------------------------------------------------------
-- 2. CREAR TABLA DE PRODUCTOS
-- ----------------------------------------------------------------------------
CREATE TABLE productos (
    -- ID autoincremental (clave primaria)
    id INT AUTO_INCREMENT PRIMARY KEY,
    
    -- Nombre del producto (requerido, máximo 255 caracteres)
    nombre VARCHAR(255) NOT NULL,
    
    -- Categoría del producto (requerido, máximo 100 caracteres)
    categoria VARCHAR(100) NOT NULL,
    
    -- Precio del producto (decimal con 2 decimales, no puede ser negativo)
    precio DECIMAL(10, 2) NOT NULL CHECK (precio >= 0),
    
    -- Stock disponible (entero, no puede ser negativo)
    stock INT NOT NULL DEFAULT 0 CHECK (stock >= 0),
    
    -- Fecha de creación del registro (automática)
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    -- Fecha de última actualización (automática al modificar)
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Índices para mejorar el rendimiento de las consultas
    INDEX idx_categoria (categoria),
    INDEX idx_nombre (nombre),
    INDEX idx_stock (stock)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 3. INSERTAR DATOS INICIALES (OPCIONAL)
-- ----------------------------------------------------------------------------
-- Productos de ejemplo para probar el sistema

INSERT INTO productos (nombre, categoria, precio, stock) VALUES
    -- Electrónica
    ('Laptop Dell', 'Electrónica', 45000.00, 5),
    ('Mouse Logitech', 'Electrónica', 1500.00, 25),
    ('Teclado Mecánico', 'Electrónica', 8000.00, 15),
    ('Monitor 24 pulgadas', 'Electrónica', 55000.00, 3),
    
    -- Ropa
    ('Remera Nike', 'Ropa', 3500.00, 50),
    ('Pantalón Levis', 'Ropa', 12000.00, 30),
    ('Zapatillas Adidas', 'Ropa', 25000.00, 20),
    
    -- Alimentos
    ('Arroz 1kg', 'Alimentos', 800.00, 100),
    ('Fideos', 'Alimentos', 600.00, 150),
    ('Aceite', 'Alimentos', 1200.00, 80),
    ('Papitas Pay', 'Alimentos', 1400.00, 2),
    
    -- Hogar
    ('Lámpara LED', 'Hogar', 2500.00, 40),
    ('Silla Gamer', 'Hogar', 35000.00, 8);

-- ----------------------------------------------------------------------------
-- 4. VERIFICAR LOS DATOS INSERTADOS
-- ----------------------------------------------------------------------------
SELECT 
    'Base de datos creada exitosamente' AS mensaje,
    COUNT(*) AS total_productos 
FROM productos;
