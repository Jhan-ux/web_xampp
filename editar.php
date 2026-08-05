<?php
session_start();
require "conexion.php";

if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit();
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header("Location: usuarios.php");
    exit();
}

$mensaje = '';

// Cargar datos del usuario
$stmt = $conexion->prepare("SELECT * FROM usuarios WHERE id = ? LIMIT 1");
$stmt->execute([$id]);
$u = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$u) {
    header("Location: usuarios.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombres   = trim($_POST['nombres'] ?? '');
    $usuario   = trim($_POST['usuario'] ?? '');
    $telefono  = trim($_POST['telefono'] ?? '');
    $correo    = trim($_POST['email'] ?? '');
    $password  = $_POST['password'] ?? '';

    if ($nombres === '' || $usuario === '') {
        $mensaje = "Nombre completo y usuario son obligatorios.";
    } else {
        try {
            if ($password === '') {
                // Solo actualiza sin cambiar contraseña
                $sql = "UPDATE usuarios SET nombres = ?, usuario = ?, telefono = ?, correo = ? WHERE id = ?";
                $stmt = $conexion->prepare($sql);
                $stmt->execute([$nombres, $usuario, $telefono, $correo, $id]);
            } else {
                // Cambia también la contraseña
                $sql = "UPDATE usuarios SET nombres = ?, usuario = ?, password = ?, telefono = ?, correo = ? WHERE id = ?";
                $stmt = $conexion->prepare($sql);
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt->execute([$nombres, $usuario, $hash, $telefono, $correo, $id]);
            }

            header("Location: usuarios.php?msg=editado");
            exit();

        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $mensaje = "El nombre de usuario ya está en uso.";
            } else {
                $mensaje = "Error: " . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <style>
        body{font-family:Arial,sans-serif;background:#f4f6f9;padding:40px 20px}
        .container{max-width:600px;margin:0 auto;background:white;padding:40px;border-radius:12px;box-shadow:0 10px 30px rgba(0,0,0,0.15)}
        h2{color:#007bff;text-align:center;margin-bottom:30px;font-size:28px}
        label{display:block;margin:20px 0 8px;font-weight:bold;color:#333;font-size:16px}
        input{width:100%;padding:14px;border:1px solid #ddd;border-radius:6px;box-sizing:border-box;font-size:16px}
        input:focus{border-color:#007bff;outline:none;box-shadow:0 0 8px rgba(0,123,255,0.3)}
        button{width:100%;padding:16px;background:#007bff;color:white;border:none;border-radius:6px;font-size:18px;cursor:pointer;margin-top:25px;font-weight:bold}
        button:hover{background:#0056b3}
        .error{color:#dc3545;background:#ffebee;padding:15px;border-radius:6px;text-align:center;font-weight:bold;margin:15px 0}
        a{color:#007bff;display:block;text-align:center;margin-top:30px;font-size:17px;text-decoration:none}
        a:hover{text-decoration:underline}
    </style>
</head>
<body>
<div class="container">
    <h2>Editar Usuario</h2>

    <?php if ($mensaje): ?>
        <div class="error"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <form method="POST">
        <label>NOMBRE COMPLETO *</label>
        <input type="text" name="nombres" value="<?= htmlspecialchars($u['nombres'] ?? '') ?>" required>

        <label>USUARIO *</label>
        <input type="text" name="usuario" value="<?= htmlspecialchars($u['usuario']) ?>" required>

        <label>TELÉFONO</label>
        <input type="text" name="telefono" value="<?= htmlspecialchars($u['telefono'] ?? '') ?>" placeholder="Ej: 987654321">

        <label>CORREO ELECTRÓNICO</label>
        <input type="email" name="email" value="<?= htmlspecialchars($u['correo'] ?? '') ?>" placeholder="opcional">

        <label>NUEVA CONTRASEÑA (dejar vacío para no cambiar)</label>
        <input type="password" name="password" placeholder="Solo si quieres cambiarla">

        <button type="submit">Actualizar Usuario</button>
    </form>

    <a href="usuarios.php">Volver a la lista</a>
</div>
</body>
</html>