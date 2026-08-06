<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/layout.php';
require_once __DIR__ . '/../config/conexion.php';
require_login();

$usuarios = $conexion->query("SELECT id, nombres, usuario, telefono, correo FROM usuarios ORDER BY id DESC")->fetchAll();

$msg = $_GET['msg'] ?? '';
$alerts = [
    'agregado' => ['success', 'Usuario registrado con éxito.'],
    'editado'  => ['success', 'Cambios guardados correctamente.'],
    'eliminado'=> ['success', 'Usuario eliminado de la base de datos.'],
    'no_autoeliminar' => ['error', 'No puedes eliminar tu propia cuenta.'],
];

render_header("Usuarios", "usuarios");
?>

<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2.5rem;">
    <div>
        <h1 style="font-size: 2.25rem;">Directorio de Usuarios</h1>
        <p style="color: var(--text-muted); font-weight: 500;">Administra los privilegios y datos de tu equipo.</p>
    </div>
    <a href="agregar.php" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nuevo Registro
    </a>
</div>

<?php if (isset($alerts[$msg])): ?>
    <div class="alert alert-<?= $alerts[$msg][0] ?>">
        <i class="fas fa-<?= $alerts[$msg][0] === 'success' ? 'check-circle' : 'circle-exclamation' ?>"></i>
        <?= $alerts[$msg][1] ?>
    </div>
<?php endif; ?>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Identificador</th>
                <th>Usuario</th>
                <th>Nombre</th>
                <th>Contacto</th>
                <th style="text-align: right;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $u): ?>
            <tr>
                <td style="font-weight: 700; color: var(--accent);">#<?= $u['id'] ?></td>
                <td>
                    <span class="badge badge-info">@<?= htmlspecialchars($u['usuario']) ?></span>
                </td>
                <td style="font-weight: 600;"><?= htmlspecialchars($u['nombres']) ?></td>
                <td>
                    <div style="display: flex; flex-direction: column; gap: 2px;">
                        <span style="font-size: 0.85rem; font-weight: 600;"><?= htmlspecialchars($u['correo']) ?></span>
                        <span style="font-size: 0.75rem; color: var(--text-muted);"><?= htmlspecialchars($u['telefono']) ?></span>
                    </div>
                </td>
                <td style="text-align: right;">
                    <div style="display: inline-flex; gap: 0.5rem;">
                        <a href="editar.php?id=<?= $u['id'] ?>" class="btn btn-white btn-sm" title="Editar">
                            <i class="fas fa-pen-to-square"></i>
                        </a>
                        <a href="eliminar.php?id=<?= $u['id'] ?>" 
                           onclick="return confirm('¿Confirmas la eliminación definitiva?')" 
                           class="btn btn-danger btn-sm" title="Borrar">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (!$usuarios): ?>
                <tr><td colspan="5" style="text-align: center; padding: 4rem; color: var(--text-muted);">No se encontraron registros.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php render_footer(); ?>
