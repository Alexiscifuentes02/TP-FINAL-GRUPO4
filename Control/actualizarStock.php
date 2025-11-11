<?php
include_once("../configuracion.php");
include_once($ROOT . "Modelo/Producto.php");

$id = isset($_GET['id']) ? $_GET['id'] : null;
$accion = isset($_GET['accion']) ? $_GET['accion'] : null;

if ($id && ($accion == "sumar" || $accion == "restar")) {

    $objProducto = new Producto();

    if ($objProducto->buscar($id)) {
        $stockActual = $objProducto->getCantStock();

        if ($accion == "sumar") {
            $objProducto->setCantStock($stockActual + 1);
        } elseif ($accion == "restar" && $stockActual > 0) {
            $objProducto->setCantStock($stockActual - 1);
        }

        $objProducto->modificar();
    }
}

header("Location: ../vista/paginaDeposito.php");
exit();
