<?php
include_once("../../Configuracion.php");
include_once($ROOT . "Control/AbmUsuario.php");

$abm = new AbmUsuario();

// Recupera el id del usuario desde GET
$param = ["id" => $_GET["id"]];

// Llama al método de baja (eliminar/deshabilitar) del usuario
$abm->baja($param);

// Redirige a la página de usuarios
header("Location: ../paginaUsuarios.php");
exit;
