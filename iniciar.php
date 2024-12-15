<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Login</title>
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
    $usuarioExistente = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($usuarioExistente && password_verify($contrasena, $usuarioExistente['contrasena'])) {
        $_SESSION['usuario'] = $usuarioExistente['usuario'];
        header('Location: dentro.php');
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}
if (empty($usuario) || empty($contrasena)) {
    $error = "El usuario o la contraseña no pueden estar vacíos.";
} else {
}

?>
<header>
  <h1>Login</h1>
  </header>
  <?php if (isset($error)): ?>
    <p style="color: red;"><?php echo $error; ?></p>
  <?php endif; ?>
  <form method="POST" action="dentro.php">
    <input type="hidden" name="accion" value="iniciar">
    <label for="usuario">Username:</label>
    <input type="text" id="usuario" name="usuario" required>
    <br><br>
    <label for="contrasena">Password:</label>
    <input type="password" id="contrasena" name="contrasena" required>
    <br><br>
    <button type="submit">Login</button>
</form>
</body>
</html>
