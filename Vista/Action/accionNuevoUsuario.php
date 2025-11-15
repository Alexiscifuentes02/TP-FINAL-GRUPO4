<?php
include_once("../../Configuracion.php");
include_once($ROOT . "Control/AbmUsuario.php");

$abm = new AbmUsuario();

// El form NO envía este campo, pero AbmUsuario lo necesita
$_POST["deshabilitado"] = "0000-00-00 00:00:00";

$resp = $abm->alta($_POST);

header("Location: ../paginaUsuarios.php");
exit;
