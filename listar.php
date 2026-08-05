<?php

require_once 'conexion.php';

$sql = "SELECT * FROM usuarios";
$stmt = $conexion->prepare($sql);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Usuarios</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <h1>Lista de Usuarios</h1>
    <a href="principal.php">Volver al menú</a>
    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Nombres</th>
            <th>Usuario</th>
            <th>Contraseña</th>
            <th>Teléfono</th>
            <th>Correo</th>
            <th>Acciones</th>
        </tr>

        <?php foreach ($usuarios as $usuario): ?>
        <tr>
            <td><?= $usuario['id'] ?></td>
            <td><?= $usuario['nombres'] ?></td>
            <td><?= $usuario['usuario'] ?></td>
            <td><?= $usuario['contra'] ?></td>
            <td><?= $usuario['telefono'] ?></td>
            <td><?= $usuario['correo'] ?></td>
            <td>
                <a href="editar.php?id=<?= $usuario['id'] ?>">Editar</a> | 
                <a href="eliminar.php?id=<?= $usuario['id'] ?>" onclick="return confirm('¿Deseas eliminar este usuario?');">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>

