<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Register</title>
    <link rel="stylesheet" href="proyecto.css" title="Color">
</head>
<body>
<?php
session_start();
require_once 'config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];
    $sql = "SELECT * FROM usuarios WHERE usuario = :usuario";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['usuario' => $usuario]);
    if ($stmt->rowCount() > 0) {
        $error = "El usuario ya existe.";
    } else {
        $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios (usuario, contrasena) VALUES (:usuario, :contrasena)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['usuario' => $usuario, 'contrasena' => $hashed_password]);
        $_SESSION['usuario'] = $usuario;
        header('Location: dentro.php');
        exit;
    }
}
?>
<header>
    <h1>Register</h1>
</header>
<?php if (isset($error)): ?>
    <p style="color: red;"><?php echo $error; ?></p>
<?php endif; ?>

<form method="POST" action="dentro.php">
    <input type="hidden" name="accion" value="registro">
    <label for="usuario">Username:</label>
    <input type="text" id="usuario" name="usuario" required>
    <br><br>
    <label for="contrasena">Password:</label>
    <input type="password" id="contrasena" name="contrasena" required>
    <br><br>
    <button type="submit">Register</button>
</form>
</body>
</html>
