<?php
// Vista/catalogo_v3.php


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Define que rol tiene el usuario
$esAdministrador = false;
$esDeposito = false;

if (isset($_SESSION['usuario']['roles'])) {
    $rolesUsuario = $_SESSION['usuario']['roles'];
    
    // Comprueba si el rol 'administrador' está en la lista
    if (in_array('Administrador', $rolesUsuario)) {
        $esAdministrador = true;
    }

    // Comprueba si el rol 'deposito' está en la lista
    if (in_array('Depósito', $rolesUsuario)) {
        $esDeposito = true;
    }
}

setcookie("idusuario", 3, 0, "/");
setcookie("idproducto", "a", 0, "/");


if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    echo "ID: " . $usuario['id'] . "<br>";
    echo "Nombre: " . $usuario['nombre'] . "<br>";
    echo "Roles: " . implode(", ", $usuario['roles']);
} else {
    echo "No hay usuario logueado";
}

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
    <?php if ($esDeposito): ?>
    <li class="nav-item me-3">
      <a class="nav-link btn btn-outline-warning text-white" href="inventario_v5.php">Depósito</a>
    </li>
    <?php endif; ?>
    <?php if ($esAdministrador): ?>
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
        <a class="btn btn-warning me-3" href="carrito.php">Carrito</a>
<?php if (isset($_SESSION["idusuario"])): ?>
<form method="post" action="Action/cerrarSession.php" class="m-0">
    <button type="submit" name="cerrarSesion" class="btn btn-danger">Cerrar sesión</button>
</form>
    <?php endif; ?>
    <div class="d-flex gap-2">
    <?php if (!isset($_SESSION["idusuario"])): ?>
        <a class="btn btn-primary" href="login.php">Iniciar sesión</a>
    <?php endif; ?>
    <?php if (!isset($_SESSION["idusuario"])): ?>
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
