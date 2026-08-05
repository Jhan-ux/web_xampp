<?php
session_start();
if(!isset($_SESSION['usuario'])){
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio - Menú</title>
    <style>
        body{font-family: Arial; background:#f0f0f0; text-align:center; padding-top:40px;}
        .menu{background:#fff;width:400px;margin:auto;padding:20px;border-radius:8px;box-shadow:0 0 8px rgba(0,0,0,.1);}
        a{display:block;margin:8px 0;padding:10px;border-radius:6px;text-decoration:none;color:#fff;background:#007bff}
        a.logout{background:#d9534f}
    </style>
</head>
<body>
    <div class="menu">
        <h2>Bienvenido, <strong><?php echo htmlspecialchars($_SESSION['usuario']); ?></strong></h2>

        <a href="usuarios.php">Administrar usuarios</a>
        <a href="reporte.php" target="_blank">Generar reporte PDF</a>
        <a href="logout.php" class="logout">Cerrar sesión</a>
    </div>
</body>
</html>
