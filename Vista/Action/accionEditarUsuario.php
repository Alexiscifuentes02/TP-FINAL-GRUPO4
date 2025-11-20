<?php
include_once("../../Configuracion.php");
include_once($ROOT . "Control/AbmUsuario.php");

// Crear instancia de la clase que maneja usuarios
$abm = new AbmUsuario();

// Para edición, se requiere un campo "deshabilitado" aunque el formulario no lo envíe
$_POST["deshabilitado"] = "0000-00-00 00:00:00";

// Llama al método de modificación enviando todos los datos del formulario
$abm->modificacion($_POST);

// Redirige a la página de usuarios
header("Location: ../paginaUsuarios.php");
exit;
