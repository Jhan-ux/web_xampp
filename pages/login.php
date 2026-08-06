<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/layout.php';

if (isset($_SESSION['usuario'])) {
    header("Location: inicio.php");
    exit();
}

$error = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../config/conexion.php';

    $usuario  = trim($_POST['usuario'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($usuario && $password) {
        $stmt = $conexion->prepare("SELECT id, usuario, password FROM usuarios WHERE usuario = ? LIMIT 1");
        $stmt->execute([$usuario]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['usuario']    = $user['usuario'];
            $_SESSION['id_usuario'] = $user['id'];
            header("Location: inicio.php");
            exit();
        }
    }
    $error = true;
}

render_header("Acceso");
?>

<div class="login-screen">
    <div class="login-card">
        <div style="text-align: center; margin-bottom: 2.5rem;">
            <div style="width: 64px; height: 64px; background: rgba(99, 102, 241, 0.1); border-radius: 18px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                <i class="fas fa-bolt-lightning" style="font-size: 2rem; color: var(--accent);"></i>
            </div>
            <h2 style="font-size: 1.75rem;">Bienvenido de nuevo</h2>
            <p style="color: var(--text-muted); margin-top: 0.5rem; font-weight: 500;">Ingresa tus credenciales para continuar</p>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-error">
                <i class="fas fa-circle-exclamation"></i> Acceso denegado.
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="form-group">
                <label>Nombre de usuario</label>
                <input type="text" name="usuario" required autofocus placeholder="ej. nexus_admin">
            </div>

            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" name="password" required placeholder="••••••••">
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem; font-size: 1rem; margin-top: 1rem;">
                Iniciar Sesión <i class="fas fa-arrow-right"></i>
            </button>
        </form>
    </div>
</div>

<?php render_footer(); ?>
