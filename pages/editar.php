<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/layout.php';
require_once __DIR__ . '/../config/conexion.php';
require_login();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header("Location: usuarios.php");
    exit();
}

$mensaje = '';
$tipo_alerta = 'alert-error';

// Cargar datos del usuario
$stmt = $conexion->prepare("SELECT * FROM usuarios WHERE id = ? LIMIT 1");
$stmt->execute([$id]);
$u = $stmt->fetch();

if (!$u) {
    header("Location: usuarios.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar CSRF
    validate_csrf_token($_POST['csrf_token'] ?? '');

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
                $sql = "UPDATE usuarios SET nombres = ?, usuario = ?, telefono = ?, correo = ? WHERE id = ?";
                $stmt = $conexion->prepare($sql);
                $stmt->execute([$nombres, $usuario, $telefono, $correo, $id]);
            } else {
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

render_header("Editar Usuario");
?>

<div class="container container-form">
    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 2rem;">
        <a href="usuarios.php" class="btn btn-gray" style="padding: 0.5rem 1rem;">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2 style="margin-bottom: 0;">Editar Usuario</h2>
    </div>

    <?php if ($mensaje): ?>
        <div class="alert <?= $tipo_alerta ?>">
            <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($mensaje) ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <input type="hidden" name="csrf_token" value="<?= get_csrf_token() ?>">

        <div class="form-group">
            <label for="nombres">Nombre completo *</label>
            <input type="text" id="nombres" name="nombres" value="<?= htmlspecialchars($u['nombres'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label for="usuario">Usuario *</label>
            <input type="text" id="usuario" name="usuario" value="<?= htmlspecialchars($u['usuario']) ?>" required>
        </div>

        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="text" id="telefono" name="telefono" value="<?= htmlspecialchars($u['telefono'] ?? '') ?>" placeholder="Ej: 987654321">
        </div>

        <div class="form-group">
            <label for="email">Correo electrónico</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($u['correo'] ?? '') ?>" placeholder="opcional">
        </div>

        <div class="form-group">
            <label for="password">Nueva contraseña</label>
            <input type="password" id="password" name="password" placeholder="Dejar vacío para no cambiar">
            <small style="color: var(--gray); font-size: 0.8rem;">Solo si deseas actualizar la clave actual.</small>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; margin-top: 10px;">
            <i class="fas fa-sync-alt"></i> Actualizar Usuario
        </button>
    </form>
</div>

<?php render_footer(); ?>
