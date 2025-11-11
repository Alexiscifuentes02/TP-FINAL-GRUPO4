<?php
// vista/listarProductos.php
include_once("../configuracion.php");
include_once($ROOT . "Modelo/Producto.php");

// Creo objeto y traigo la lista de productos
$objProducto = new Producto();
$listaProductos = $objProducto->listar();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Stock de Productos</title>
</head>
<body>

<h2>Lista de Productos</h2>

<?php
if ($listaProductos != null) {
    foreach ($listaProductos as $producto) {

        echo "ID: " . $producto->getId() . " | ";
        echo "Nombre: " . $producto->getNombre() . " | ";
        echo "Stock: " . $producto->getCantStock() . " | ";

        echo "[ <a href='../control/actualizarStock.php?id=" . $producto->getId() . "&accion=sumar'>Sumar</a> ] ";
        echo "[ <a href='../control/actualizarStock.php?id=" . $producto->getId() . "&accion=restar'>Restar</a> ]";

        echo "<br><br>";
    }
} else {
    echo "No hay productos para mostrar.";
}
?>

</body>
</html>
