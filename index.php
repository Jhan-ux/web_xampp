<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Inicio de Sesión</title>
</head>

<body>
    <h2>Iniciar sesión</h2>

    <form action="login.php" method="POST">
        <label>Usuario:</label><br>
        <input type="text" name="usuario" required><br><br>

        <label>Contraseña:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Entrar</button>
    </form>
<?php if (isset($_GET['error'])): ?>
    <div class="error">
        Usuario o contraseña incorrectos
    </div>
<?php endif; ?>
</body>
</html>