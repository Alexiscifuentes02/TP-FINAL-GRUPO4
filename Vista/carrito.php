<?php
require_once(__DIR__ . "/Action/sesion.php"); // incluye sesión y setea $usuario, $mostrarAdmin, $mostrarDeposito

$usuario = $sesion->getUsuario();
echo $_COOKIE["idproducto"];
print_r($_SESSION["idusuario"]);

