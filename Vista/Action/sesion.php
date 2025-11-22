<?php
// Incluir configuración
require_once(realpath(__DIR__ . "/../../Configuracion.php"));

// Incluir clases de sesión y usuario
require_once($ROOT . "Control/Session.php");
require_once($ROOT . "Control/AbmUsuario.php");

// Inicializa sesión
if (session_status() === PHP_SESSION_NONE) {
    $sesion = new Session();
}

$usuario = null;
$mostrarAdmin = false;
$mostrarDeposito = false;

// Validar si hay sesión activa
if ($sesion->validar()) {
    $usuario = $sesion->getUsuario();
    $rolesObj = (new AbmUsuario())->buscarRoles(['id' => $usuario->getId()]);

    // Extrae los roles del usuario
    $roles = [];
    foreach ($rolesObj as $r) {
        $roles[] = $r->getObjRol()->getRolDescripcion();
    }

    // Determina si se muestran secciones de administrador o depósito
    $mostrarAdmin = in_array("Administrador", $roles);
    $mostrarDeposito = in_array("Depósito", $roles);
}

// Cerrar sesión si se envía el formulario correspondiente
if (isset($_POST['cerrarSesion'])) {
    $sesion->cerrar();
    header("Location: ../Vista/catalogo_v3.php");
    exit;
}
