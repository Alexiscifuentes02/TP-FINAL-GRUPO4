<?php
// Inicia la sesión para poder usar $_SESSION
session_start();

// Recupera los datos enviados por POST. Si no vienen, asigna cadena vacía
$user = $_POST['user'] ?? '';
$psw  = $_POST['psw'] ?? '';
$captcha_input = $_POST['captcha_input'] ?? '';

// ---------------------------
// Validación del CAPTCHA
// ---------------------------
// Verifica si la frase del captcha guardada en sesión existe y coincide con lo ingresado
if (!isset($_SESSION['captcha_phrase']) || $captcha_input !== $_SESSION['captcha_phrase']) {
    // Si no coincide, redirige a login con error de captcha
    header("Location: ../login.php?error=captcha");
    exit;
}

// Elimina la frase del captcha de la sesión para que no se pueda reutilizar
unset($_SESSION['captcha_phrase']);

// ---------------------------
// Validación de usuario y contraseña
// ---------------------------
// Se incluyen archivos necesarios para la configuración y control de sesiones y usuarios
include_once("../../Configuracion.php");
include_once($ROOT . "Control/Session.php");
include_once($ROOT . "Control/AbmUsuario.php");

// Crea una instancia de la clase Session
$sesion = new Session();

// Intenta iniciar sesión con usuario y contraseña
if ($sesion->iniciar($user, $psw)) {
    // Si inicia correctamente, obtiene el objeto usuario
    $usuario = $sesion->getUsuario();

    // Crea instancia de AbmUsuario para buscar roles del usuario
    $abmUsuario = new AbmUsuario();
    $rolesObj = $abmUsuario->buscarRoles(['id' => $usuario->getId()]);

    // Extrae la descripción de los roles en un arreglo simple
    $roles = [];
    foreach ($rolesObj as $r) {
        $roles[] = $r->getObjRol()->getRolDescripcion();
    }

    // Guarda información del usuario y sus roles en sesión
    $_SESSION['usuario'] = [
        'id' => $usuario->getId(),
        'nombre' => $usuario->getNombre(),
        'roles' => $roles
    ];

    // Redirige al catálogo principal después del login exitoso
    header("Location: ../catalogo_v3.php");
    exit;
} else {
    // Si usuario/contraseña no coinciden, redirige al login con error
    header("Location: ../login.php?error=1");
    exit;
}
