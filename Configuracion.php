<?php 

header('Content-Type: text/html; charset=utf-8');
header ("Cache-Control: no-cache, must-revalidate ");

/////////////////////////////
// CONFIGURACION APP//
/////////////////////////////

$PROYECTO ='TPFINAL';
$ROOT =$_SERVER['DOCUMENT_ROOT']."/$PROYECTO/";

include_once($ROOT.'Util/funciones.php');
include_once($ROOT."Modelo/Conector/BaseDatos.php");
include_once($ROOT."Modelo/Producto.php");
include_once ($ROOT . "Modelo/Rol.php");
include_once ($ROOT . "Modelo/UsuarioRol.php");
include_once ($ROOT . "Modelo/Usuario.php");


$GLOBALS['ROOT']=$ROOT;

// Página de Autenticación
$INICIO = "Location:http://".$_SERVER['HTTP_HOST']."/$PROYECTO/vista/"; // COMPLETAR

// Página Principal
$PRINCIPAL = "Location:http://".$_SERVER['HTTP_HOST']."/$PROYECTO/home/index.php";

?>