<?php
require_once __DIR__ . '/../includes/auth.php';
require_login();
require_once __DIR__ . '/../config/conexion.php';

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
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<div class="container container-form">
    <h2>Agregar Nuevo Usuario</h2>

    <?php if ($mensaje): ?>
        <div class="error"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <form method="POST">
        <label for="nombres">Nombre completo *</label>
        <input type="text" id="nombres" name="nombres" required autocomplete="off" placeholder="Ej: Juan Pérez">

        <label for="usuario">Usuario *</label>
        <input type="text" id="usuario" name="usuario" required autocomplete="off" placeholder="Nombre de acceso">

        <label for="password">Contraseña *</label>
        <input type="password" id="password" name="password" required placeholder="Mínimo 6 caracteres">

        <label for="telefono">Teléfono</label>
        <input type="text" id="telefono" name="telefono" placeholder="Ej: 987654321">

        <label for="email">Correo electrónico</label>
        <input type="email" id="email" name="email" placeholder="ejemplo@dominio.com">

        <button type="submit">Guardar Usuario</button>
    </form>

    <a href="usuarios.php">Volver a la lista de usuarios</a>
</div>
</body>
</html>
