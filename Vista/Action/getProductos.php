<?php
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../../Modelo/Producto.php';

$producto = new Producto();
$productosBD = $producto->listar("true"); // Trae todos los productos activos

$resultado = [];

if ($productosBD) {
    foreach ($productosBD as $p) {

        // Ruta de la imagen según la base de datos
        $imgDB = $p->getImg();

        // Verifica si el archivo existe físicamente
        $fullPath = __DIR__ . "/../$imgDB"; // __DIR__ es Vista/Action/, ../ nos lleva a Vista/
        if (!empty($imgDB) && file_exists($fullPath)) {
            // Ruta accesible por el navegador
            $img = "/TPFINAL/Vista/$imgDB";
        } else {
            // Si no existe, usar placeholder con el nombre del producto
            $titulo = urlencode($p->getNombre());
            $img = "https://dummyimage.com/300x400/000000/ffffff&text=$titulo";
        }

        // Construye la estructura JSON del producto
        $resultado[] = [
            "id" => $p->getId(),
            "title" => $p->getNombre(),
            "description" => $p->getDescripcion(),
            "price" => (float)$p->getPrecio(),
            "image" => $img,
            "tags" => [$p->getGenero(), $p->getPlataforma()],
            "stock" => [
                "quantity" => (int)$p->getCantStock()
            ],
            "available" => $p->getDeshabilitado() === null
        ];
    }
}

// Devuelve la respuesta en formato JSON
echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
