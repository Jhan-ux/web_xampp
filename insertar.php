<?php
require_once 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombres = $_POST['nombres'];
    $usuario = $_POST['usuario'];
    $contra = $_POST['contra'];
    $hash = password_hash($contra, PASSWORD_DEFAULT);
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];

    $sql = "INSERT INTO usuarios (nombres, usuario, contra, telefono, correo) VALUES (:nombres, :usuario, :contra, :telefono, :correo)";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':nombres', $nombres);
    $stmt->bindParam(':usuario', $usuario);
    $stmt->bindParam(':contra', $hash);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->bindParam(':correo', $correo);
    $stmt->execute();

    header("Location: listar.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Insertar Usuario</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <h1>Agregar Usuario</h1>
    <form method="post">
        <label>Nombres:</label><br>
        <input type="text" name="nombres" required><br><br>

        <label>Usuario:</label><br>
        <input type="text" name="usuario" required><br><br>

        <label>Contraseña:</label><br>
        <input type="text" name="contra" required><br><br>

        <label>Teléfono:</label><br>
        <input type="text" name="telefono" required><br><br>

        <label>Correo:</label><br>
        <input type="email" name="correo" required><br><br>

        <input type="submit" value="Guardar">
    </form>
    <br>
    <a href="principal.php">Volver al menú</a>
    
</body>
</html>

