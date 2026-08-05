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

-- Datos de prueba (contraseñas hasheadas con password_hash/PASSWORD_DEFAULT)
-- juan   -> 1234
-- maria  -> 1234
-- carlos -> admin
INSERT INTO usuarios (nombres, usuario, password, telefono, correo) VALUES
('Juan Pérez', 'juan', '$2y$12$1l1fMkWJSvS1uv0jR0eAgOC1AfPwbHc7ReNYU.msymIM1xJ2EAhZm', '987654321', 'juan@gmail.com'),
('María López', 'maria', '$2y$12$C0fGxwddgAoXgrK2n5zJVOTCfUdWTSRAufB7.Qr2gZxnu3p8bhmlm', '912345678', 'maria@hotmail.com'),
('Carlos Ramírez', 'carlos', '$2y$12$B5hAoEyoA3EJxSBpMCEv3u.6.a0RSz/9G0swuQUXiwmmDoK9b/5N2', '999888777', 'carlos@outlook.com');
