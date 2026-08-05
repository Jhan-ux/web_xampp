CREATE DATABASE IF NOT EXISTS bd_entregable CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE bd_entregable;


CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(100) NOT NULL,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    telefono VARCHAR(20),
    correo VARCHAR(100)
);

-- Datos de prueba para que veas que el PDF funciona ya
INSERT INTO usuarios (nombres, usuario, password, telefono, correo) VALUES
('Juan Pérez', 'juan', '1234', '987654321', 'juan@gmail.com'),
('María López', 'maria', '1234', '912345678', 'maria@hotmail.com'),
('Carlos Ramírez', 'carlos', 'admin', '999888777', 'carlos@outlook.com');