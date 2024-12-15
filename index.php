<?php
session_start();
if (isset($_SESSION['usuario'])) {
    header('Location: dentro.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>acasmar0506b DataBase</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="proyecto.css" title="Color">
</head>
<body>
<header>
  <h1>DataBase acasmar0506b</h1>
  <nav>
  <ul class="nav-links">
  <li><a href="conectarse.php">Connect</a></li>
  </ul>
  </nav>
</header>
</body>
</html>
