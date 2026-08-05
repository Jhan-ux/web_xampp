<?php
session_start();
require "conexion.php";

if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit();
}

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombres   = trim($_POST['nombres'] ?? '');
    $usuario   = trim($_POST['usuario'] ?? '');
    $password  = $_POST['password'] ?? '';
    $telefono  = trim($_POST['telefono'] ?? '');
    $correo    = trim($_POST['email'] ?? '');

    // Validación
    if ($nombres === '' || $usuario === '' || $password === '') {
        $mensaje = "Nombre, usuario y contraseña son obligatorios.";
    } else {
        try {
            $sql = "INSERT INTO usuarios (nombres, usuario, password, telefono, correo) 
                    VALUES (:nombres, :usuario, :password, :telefono, :correo)";
            
            $stmt = $conexion->prepare($sql);
            $stmt->execute([
                ':nombres'  => $nombres,
                ':usuario'  => $usuario,
                ':password' => password_hash($password, PASSWORD_DEFAULT),
                ':telefono' => $telefono,
                ':correo'   => $correo
            ]);

            header("Location: usuarios.php?msg=agregado");
            exit();

        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $mensaje = "El nombre de usuario ya está en uso.";
            } else {
                $mensaje = "Error al guardar: " . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Usuario</title>
    <style>
        body{font-family:Arial,sans-serif;background:#f4f6f9;padding:40px 20px}
        .container{max-width:550px;margin:0 auto;background:white;padding:35px;border-radius:12px;box-shadow:0 10px 30px rgba(0,0,0,0.1)}
        h2{color:#007bff;text-align:center;margin-bottom:30px;font-size:26px}
        label{display:block;margin:18px 0 8px;font-weight:bold;color:#333}
        input{width:100%;padding:14px;border:1px solid #ddd;border-radius:6px;box-sizing:border-box;font-size:16px}
        input:focus{border-color:#007bff;outline:none;box-shadow:0 0 8px rgba(0,123,255,0.3)}
        button{width:100%;padding:15px;background:#28a745;color:white;border:none;border-radius:6px;font-size:18px;cursor:pointer;margin-top:20px}
        button:hover{background:#218838}
        .error{color:#dc3545;font-weight:bold;text-align:center;margin:15px 0;padding:10px;background:#ffebee;border-radius:6px}
        a{color:#007bff;display:block;text-align:center;margin-top:25px;font-size:16px}
    </style>
</head>
<body>
<div class="container">
    <h2>Agregar Nuevo Usuario</h2>

    <?php if ($mensaje): ?>
        <div class="error"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <form method="POST">
        <label>Nombre completo *</label>
        <input type="text" name="nombres" required autocomplete="off" placeholder="Ej: Juan Pérez">

        <label>Usuario *</label>
        <input type="text" name="usuario" required autocomplete="off" placeholder="Nombre de acceso">

        <label>Contraseña *</label>
        <input type="password" name="password" required placeholder="Mínimo 6 caracteres">

        <label>Teléfono</label>
        <input type="text" name="telefono" placeholder="Ej: 987654321">

        <label>Correo electrónico</label>
        <input type="email" name="email" placeholder="ejemplo@dominio.com">

        <button type="submit">Guardar Usuario</button>
    </form>

    <a href="usuarios.php">Volver a la lista de usuarios</a>
</div>
</body>
</html>