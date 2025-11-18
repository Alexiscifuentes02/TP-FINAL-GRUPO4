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

// Eliminar la frase del captcha para que no se use de nuevo
unset($_SESSION['captcha_phrase']);

// Validar usuario y contraseña
include_once("../../Configuracion.php");
include_once($ROOT . "Control/Session.php");

$sesion = new Session();
if ($sesion->iniciar($user, $psw)) {
    header("Location: accionPaginaSegura.php");
} else {
    header("Location: ../login.php?error=1");
}
exit;




