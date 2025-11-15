<?php
include_once("../../Configuracion.php");
include_once($ROOT . "Control/AbmUsuario.php");

$abm = new AbmUsuario();

$param = ["id" => $_GET["id"]];

$abm->baja($param);

header("Location: ../paginaUsuarios.php");
exit;
