<?php
require_once __DIR__ . '/../includes/auth.php';
require_login();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio - Menú</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="menu">
        <h2>Bienvenido, <strong><?= htmlspecialchars($_SESSION['usuario']) ?></strong></h2>

        <a href="usuarios.php">Administrar usuarios</a>
        <a href="reporte.php" target="_blank">Generar reporte PDF</a>
        <a href="logout.php" class="logout">Cerrar sesión</a>
    </div>
</body>
</html>
