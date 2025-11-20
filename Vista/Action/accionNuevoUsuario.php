<?php
include_once("../../Configuracion.php");
include_once($ROOT . "Control/AbmUsuario.php");

$abm = new AbmUsuario();

// El formulario NO envía el campo "deshabilitado", pero AbmUsuario lo necesita
$_POST["deshabilitado"] = "0000-00-00 00:00:00";

// Llama al método de alta para crear un nuevo usuario
$resp = $abm->alta($_POST);

// Redirige a la página de usuarios
header("Location: ../paginaUsuarios.php");
exit;
