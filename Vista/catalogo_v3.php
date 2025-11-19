<?php
// Vista/catalogo_v3.php

require_once(__DIR__ . "/Action/sesion.php"); // incluye sesión y setea $usuario, $mostrarAdmin, $mostrarDeposito
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="CSS/catalogo.css">
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<nav class="navbar sticky-top navbar-dark bg-dark px-3">
  <ul class="navbar-nav d-flex flex-row me-auto">
    <li class="nav-item me-3">
      <a class="nav-link active" href="#">Tienda</a>
    </li>
    <li class="nav-item me-3">
      <a class="nav-link" href="#">Contacto</a>
    </li>
    <?php if ($mostrarDeposito): ?>
    <li class="nav-item me-3">
      <a class="nav-link btn btn-outline-warning text-white" href="inventario_v5.php">Depósito</a>
    </li>
    <?php endif; ?>
    <?php if ($mostrarAdmin): ?>
    <li class="nav-item me-3">
      <a class="nav-link btn btn-outline-info text-white" href="paginaUsuarios.php">Administrar usuarios</a>
    </li>
    <?php endif; ?>
  </ul>

  <div class="d-flex flex-row align-items-center">
    <form class="d-flex me-3">
      <input class="form-control me-2" type="search" placeholder="Búsqueda">
      <button class="btn btn-outline-success" type="submit">Buscar</button>
    </form>

    <?php if ($usuario): ?>
      <form method="post" class="m-0">
        <button type="submit" name="cerrarSesion" class="btn btn-danger">Cerrar sesión</button>
      </form>
      <?php else: ?>
    <div class="d-flex gap-2">
        <a class="btn btn-primary" href="login.php">Iniciar sesión</a>
        <a class="btn btn-success" href="registrar.php">Registrarse</a>
    </div>
<?php endif; ?>


  </div>
</nav>

<div class="container my-4">
    <h2 class="mb-4">Catálogo</h2>
    <div class="catalog-container" id="catalogContainer"></div>
</div>

<div id="fullscreenView" class="fullscreen-overlay">
    <span class="fullscreen-close-btn">&times;</span>
    <div id="fullscreenContent" class="fullscreen-item"></div>
</div>

<script src="js/catalogo.js"></script>
</body>
</html>
