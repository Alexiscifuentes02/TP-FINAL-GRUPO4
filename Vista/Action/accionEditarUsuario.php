<?php
include_once("../../Configuracion.php");
include_once($ROOT . "Control/AbmUsuario.php");

$abm = new AbmUsuario();

// Para editar también es necesario enviarlo
$_POST["deshabilitado"] = "0000-00-00 00:00:00";

$abm->modificacion($_POST);

header("Location: ../paginaUsuarios.php");
exit;
