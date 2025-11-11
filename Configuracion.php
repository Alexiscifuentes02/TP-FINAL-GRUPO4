<?php 

header('Content-Type: text/html; charset=utf-8');
header ("Cache-Control: no-cache, must-revalidate ");

/////////////////////////////
// CONFIGURACION APP//
/////////////////////////////

$PROYECTO ='TPFINAL';
$ROOT =$_SERVER['DOCUMENT_ROOT']."/$PROYECTO/";

include_once($ROOT.'Util/funciones.php');

$GLOBALS['ROOT']=$ROOT;

// Página de Autenticación
$INICIO = "Location:http://".$_SERVER['HTTP_HOST']."/$PROYECTO/vista/"; // COMPLETAR

// Página Principal
$PRINCIPAL = "Location:http://".$_SERVER['HTTP_HOST']."/$PROYECTO/home/index.php";

?>