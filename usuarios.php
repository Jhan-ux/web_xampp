<?php
session_start();
require "conexion.php";

if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit();
}

// Ahora seleccionamos TODAS las columnas que queremos mostrar
$stmt = $conexion->query("SELECT id, nombres, usuario, telefono, correo AS email FROM usuarios ORDER BY id DESC");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Usuarios</title>
    <style>
        body{font-family:Arial,sans-serif;background:#f4f6f9;padding:20px}
        .container{max-width:1100px;margin:0 auto;background:white;padding:30px;border-radius:10px;box-shadow:0 5px 15px rgba(0,0,0,0.1)}
        h2{color:#007bff;text-align:center;margin-bottom:30px}
        .btn{padding:12px 20px;border:none;border-radius:6px;color:white;text-decoration:none;display:inline-block;margin:5px;font-weight:bold}
        .btn-add{background:#28a745}
        .btn-pdf{background:#007bff}
        .btn-back{background:#6c757d}
        .btn-logout{background:#dc3545;float:right}
        table{width:100%;border-collapse:collapse;margin-top:20px}
        th, td{padding:15px;text-align:left;border-bottom:1px solid #ddd}
        th{background:#007bff;color:white}
        tr:hover{background:#f1f1f1}
        .actions a{padding:8px 15px;border-radius:4px;text-decoration:none;margin:0 5px}
        .edit{background:#ffc107;color:black}
        .delete{background:#dc3545;color:white}
        .no-data{padding:50px;text-align:center;color:#888;font-size:18px}
    </style>
</head>
<body>
<div class="container">
    <h2>Lista de Usuarios</h2>

    <div style="margin-bottom:20px">
        <a href="agregar.php" class="btn btn-add">+ Agregar usuario</a>
        <a href="reporte.php" class="btn btn-pdf">Descargar PDF</a>
        <a href="inicio.php" class="btn btn-back">Volver al menú</a>
        <a href="logout.php" class="btn btn-logout">Cerrar sesión</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre completo</th>
                <th>Usuario</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($usuarios && count($usuarios) > 0): ?>
                <?php foreach($usuarios as $u): ?>
                    <tr>
                        <td><?= $u['id'] ?></td>
                        <td><?= htmlspecialchars($u['nombres'] ?? 'Sin nombre') ?></td>
                        <td><?= htmlspecialchars($u['usuario']) ?></td>
                        <td><?= htmlspecialchars($u['telefono'] ?? 'Sin teléfono') ?></td>
                        <td><?= htmlspecialchars($u['email'] ?? 'Sin email') ?></td>
                        <td class="actions">
                            <a class="edit" href="editar.php?id=<?= $u['id'] ?>">Editar</a>
                            <a class="delete" href="eliminar.php?id=<?= $u['id'] ?>"
                               onclick="return confirm('¿Seguro que quieres eliminar este usuario?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6" class="no-data">No hay usuarios registrados aún</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>