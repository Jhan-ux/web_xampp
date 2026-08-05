<?php
require_once __DIR__ . '/../includes/auth.php';
require_login();
require_once __DIR__ . '/../config/conexion.php';

$stmt = $conexion->query("SELECT id, nombres, usuario, telefono, correo AS email FROM usuarios ORDER BY id DESC");
$usuarios = $stmt->fetchAll();

$mensajes = [
    'agregado'          => 'Usuario agregado correctamente.',
    'editado'           => 'Usuario actualizado correctamente.',
    'eliminado'         => 'Usuario eliminado correctamente.',
    'no_autoeliminar'   => 'No podés eliminar tu propio usuario mientras estás logueado con él.',
    'error_eliminar'    => 'Ocurrió un error al eliminar el usuario.',
];
$msg = $_GET['msg'] ?? '';
$esError = in_array($msg, ['no_autoeliminar', 'error_eliminar'], true);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Usuarios</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<div class="container">
    <h2>Lista de Usuarios</h2>

    <?php if (isset($mensajes[$msg])): ?>
        <div class="<?= $esError ? 'alert-error' : 'alert-success' ?>">
            <?= htmlspecialchars($mensajes[$msg]) ?>
        </div>
    <?php endif; ?>

    <div style="margin-bottom:20px">
        <a href="agregar.php" class="btn btn-add">+ Agregar usuario</a>
        <a href="reporte.php" class="btn btn-pdf" target="_blank">Descargar PDF</a>
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
                <?php foreach ($usuarios as $u): ?>
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
