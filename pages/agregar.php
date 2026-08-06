<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/layout.php';
require_once __DIR__ . '/../config/conexion.php';
require_login();

$mensaje = '';
$tipo_alerta = 'alert-error';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar CSRF
    validate_csrf_token($_POST['csrf_token'] ?? '');

    $nombres   = trim($_POST['nombres'] ?? '');
    $usuario   = trim($_POST['usuario'] ?? '');
    $password  = $_POST['password'] ?? '';
    $telefono  = trim($_POST['telefono'] ?? '');
    $correo    = trim($_POST['email'] ?? '');

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

render_header("Agregar Usuario");
?>

<div class="container container-form">
    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 2rem;">
        <a href="usuarios.php" class="btn btn-gray" style="padding: 0.5rem 1rem;">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2 style="margin-bottom: 0;">Nuevo Usuario</h2>
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
            <input type="text" id="nombres" name="nombres" required autocomplete="off" placeholder="Ej: Juan Pérez">
        </div>

        <div class="form-group">
            <label for="usuario">Usuario de acceso *</label>
            <input type="text" id="usuario" name="usuario" required autocomplete="off" placeholder="Ej: jperez123">
        </div>

        <div class="form-group">
            <label for="password">Contraseña *</label>
            <input type="password" id="password" name="password" required placeholder="Mínimo 6 caracteres">
        </div>

        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="text" id="telefono" name="telefono" placeholder="Ej: 987654321">
        </div>

        <div class="form-group">
            <label for="email">Correo electrónico</label>
            <input type="email" id="email" name="email" placeholder="ejemplo@dominio.com">
        </div>

        <button type="submit" class="btn btn-success" style="width: 100%; justify-content: center; margin-top: 10px;">
            <i class="fas fa-save"></i> Guardar Usuario
        </button>
    </form>
</div>

<?php render_footer(); ?>
