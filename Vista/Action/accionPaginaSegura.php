<?php
include_once("../../Configuracion.php");
include_once($ROOT . "Control/Session.php");
include_once($ROOT . "Control/AbmUsuario.php");

// Crear sesión
$sesion = new Session();

// Validar login
if(!$sesion->validar()){
    header("Location: ../login.php");
    exit;
}

// Obtener usuario logueado
$usuario = $sesion->getUsuario();

// Obtener roles usando AbmUsuario
$abmUsuario = new AbmUsuario();
$rolesObj = $abmUsuario->buscarRoles(['id' => $usuario->getId()]);
$roles = [];
foreach ($rolesObj as $r) {
    $roles[] = $r->getObjRol()->getRolDescripcion();
}

// Solo permitir acceso si es Administrador o Depósito
if(!in_array("Administrador", $roles) && !in_array("Depósito", $roles)){
    echo "No tiene permiso para acceder a esta página.";
    exit;
}

// Cerrar sesión si lo solicita
if(isset($_POST['cerrarSesion'])){
    $sesion->cerrar();
    header("Location: ../login.php");
    exit;
}

// Variables para la vista
$mostrarAdmin = in_array("Administrador", $roles);
$mostrarDeposito = in_array("Depósito", $roles);

// Cargar vista
include_once("../paginaSegura.php");
