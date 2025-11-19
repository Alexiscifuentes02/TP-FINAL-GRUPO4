<?php
// Vista/Action/sesion.php

// Incluir configuración para obtener $ROOT
require_once(realpath(__DIR__ . "/../../Configuracion.php"));

// Incluir clases necesarias usando $ROOT
require_once($ROOT . "Control/Session.php");
require_once($ROOT . "Control/AbmUsuario.php");

// Inicializar sesión
$sesion = new Session();

$usuario = null;
$mostrarAdmin = false;
$mostrarDeposito = false;

// Si hay usuario válido, obtenemos sus datos y roles
if ($sesion->validar()) {
    $usuario = $sesion->getUsuario();
    $rolesObj = (new AbmUsuario())->buscarRoles(['id' => $usuario->getId()]);
    $roles = [];
    foreach ($rolesObj as $r) {
        $roles[] = $r->getObjRol()->getRolDescripcion();
    }

    $mostrarAdmin = in_array("Administrador", $roles);
    $mostrarDeposito = in_array("Depósito", $roles);
}

// Solo cerrar sesión si se envió el formulario de cerrar sesión
if (isset($_POST['cerrarSesion'])) {
    $sesion->cerrar();
    header("Location: ../Vista/catalogo_v3.php");
    exit;

}
