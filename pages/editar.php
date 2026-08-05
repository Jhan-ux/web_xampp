<?php
require_once __DIR__ . '/../includes/auth.php';
require_login();
require_once __DIR__ . '/../config/conexion.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header("Location: usuarios.php");
    exit();
}

$mensaje = '';

// Cargar datos del usuario
$stmt = $conexion->prepare("SELECT * FROM usuarios WHERE id = ? LIMIT 1");
$stmt->execute([$id]);
$u = $stmt->fetch();

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
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<div class="container container-form">
    <h2>Editar Usuario</h2>

    <?php if ($mensaje): ?>
        <div class="error"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <form method="POST">
        <label for="nombres">Nombre completo *</label>
        <input type="text" id="nombres" name="nombres" value="<?= htmlspecialchars($u['nombres'] ?? '') ?>" required>

        <label for="usuario">Usuario *</label>
        <input type="text" id="usuario" name="usuario" value="<?= htmlspecialchars($u['usuario']) ?>" required>

        <label for="telefono">Teléfono</label>
        <input type="text" id="telefono" name="telefono" value="<?= htmlspecialchars($u['telefono'] ?? '') ?>" placeholder="Ej: 987654321">

        <label for="email">Correo electrónico</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($u['correo'] ?? '') ?>" placeholder="opcional">

        <label for="password">Nueva contraseña (dejar vacío para no cambiar)</label>
        <input type="password" id="password" name="password" placeholder="Solo si quieres cambiarla">

        <button type="submit">Actualizar Usuario</button>
    </form>

    <a href="usuarios.php">Volver a la lista</a>
</div>
</body>
</html>
