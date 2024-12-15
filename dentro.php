<?php
session_start();
require_once 'config.php';
function recoge($var, $default = '') {
    if (!isset($_REQUEST[$var])) {
        return $default;
    }
    $valor = $_REQUEST[$var];
    $valor = trim($valor);
    $valor = htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
    return $valor;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $accion = recoge('accion');
    if ($accion === 'iniciar') {
        $usuario = recoge('usuario');
        $contrasena = recoge('contrasena');
        if (empty($usuario) || empty($contrasena)) {
            $error = "El usuario o la contraseña no pueden estar vacíos.";
        } else {
            $sql = "SELECT * FROM usuarios WHERE usuario = :usuario";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['usuario' => $usuario]);
            $usuarioExistente = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($usuarioExistente && password_verify($contrasena, $usuarioExistente['contrasena'])) {
                $_SESSION['usuario'] = $usuarioExistente['usuario'];
            } else {
                $error = "Usuario o contraseña incorrectos.";
            }
        }
    }
    if ($accion === 'registro') {
        $usuario = recoge('usuario');
        $contrasena = recoge('contrasena');
        if (empty($usuario) || empty($contrasena)) {
            $error = "El usuario o la contraseña no pueden estar vacíos.";
        } else {
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
            }
        }
    }
}
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit;
}
$sql = "SELECT * FROM usuarios";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
$usuario = $_SESSION['usuario'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="proyecto.css" title="Color">
</head>
<body>
<header>
    <h1>Welcome, <?php echo htmlspecialchars($usuario); ?>!</h1>
    <nav>
        <ul class="nav-links">
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</header>
<main>
    <h2>Users</h2>
    <ul>
        <?php foreach ($usuarios as $user): ?>
            <li><?php echo htmlspecialchars($user['usuario'], ENT_QUOTES, 'UTF-8'); ?></li>
        <?php endforeach; ?>
    </ul>
</main>
</body>
</html>
