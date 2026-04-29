-- ===============================
-- CREAR BASE DE DATOS
-- ===============================
CREATE DATABASE usuarios_db;

-- ===============================
-- USAR BASE DE DATOS
-- ===============================
USE usuarios_db;

-- ===============================
-- CREAR TABLA USUARIOS
-- ===============================
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    cedula VARCHAR(50) NOT NULL UNIQUE,
    telefono VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);