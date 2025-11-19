<?php
session_start();

$user = $_POST['user'] ?? '';
$psw  = $_POST['psw'] ?? '';
$captcha_input = $_POST['captcha_input'] ?? '';

// Validar captcha
if (!isset($_SESSION['captcha_phrase']) || $captcha_input !== $_SESSION['captcha_phrase']) {
    header("Location: ../login.php?error=captcha");
    exit;
}

unset($_SESSION['captcha_phrase']);

// Validar usuario y contraseña
include_once("../../Configuracion.php");
include_once($ROOT . "Control/Session.php");
include_once($ROOT . "Control/AbmUsuario.php");

$sesion = new Session();
if ($sesion->iniciar($user, $psw)) {
    // Obtener usuario y roles
    $usuario = $sesion->getUsuario();
    $abmUsuario = new AbmUsuario();
    $rolesObj = $abmUsuario->buscarRoles(['id' => $usuario->getId()]);
    $roles = [];
    foreach ($rolesObj as $r) {
        $roles[] = $r->getObjRol()->getRolDescripcion();
    }

    // Guardar en sesión
    $_SESSION['usuario'] = [
        'id' => $usuario->getId(),
        'nombre' => $usuario->getNombre(),
        'roles' => $roles
    ];

    // Redirigir al catálogo
    header("Location: ../catalogo_v3.php");
    exit;
} else {
    header("Location: ../login.php?error=1");
    exit;
}





