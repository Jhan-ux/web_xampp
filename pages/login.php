<?php
require_once __DIR__ . '/../includes/auth.php';

// Si ya hay sesión activa, directo al menú
if (isset($_SESSION['usuario'])) {
    header("Location: inicio.php");
    exit();
}

$error = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../config/conexion.php';

    $usuario  = trim($_POST['usuario'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($usuario === '' || $password === '') {
        $error = true;
    } else {
        // Buscamos al usuario en la tabla "usuarios" (¡con s!)
        $stmt = $conexion->prepare("SELECT id, usuario, password FROM usuarios WHERE usuario = ? LIMIT 1");
        $stmt->execute([$usuario]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password'])) {
            $error = true;
        } else {
            // LOGIN CORRECTO → creamos sesión
            $_SESSION['usuario']    = $user['usuario'];
            $_SESSION['id_usuario'] = $user['id']; // útil para evitar auto-eliminación

            header("Location: inicio.php");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="container container-form login-box">
        <h2>Iniciar sesión</h2>

        <?php if ($error): ?>
            <div class="error">Usuario o contraseña incorrectos</div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <label for="usuario">Usuario:</label>
            <input type="text" id="usuario" name="usuario" required autofocus>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>
