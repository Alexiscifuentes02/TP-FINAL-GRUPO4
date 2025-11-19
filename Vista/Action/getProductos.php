<?php
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../../Modelo/Producto.php';

$producto = new Producto();
$productosBD = $producto->listar("true");

$resultado = [];

if ($productosBD) {
    foreach ($productosBD as $p) {

        // Ruta original desde la base de datos
        $imgDB = $p->getImg();

        // Verificamos si existe el archivo físicamente
        $fullPath = __DIR__ . "/../$imgDB"; // __DIR__ es Vista/Action/, ../ nos lleva a Vista/
        if (!empty($imgDB) && file_exists($fullPath)) {
            // Ruta que el navegador puede usar
            $img = "/TPFINAL/Vista/$imgDB";
        } else {
            // Placeholder si no existe
            $titulo = urlencode($p->getNombre());
            $img = "https://dummyimage.com/300x400/000000/ffffff&text=$titulo";
        }

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

echo json_encode($resultado, JSON_UNESCAPED_UNICODE);






