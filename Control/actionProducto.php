<?php
// Control/actionProducto.php
require_once __DIR__ . '/../configuracion.php';
require_once __DIR__ . '/AbmProducto.php';
require_once __DIR__ . '/../Modelo/Producto.php';

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : null;

if (!$action) {
    header("Location: ../Vista/inventario_v5.php");
    exit;
}

$abm = new AbmProducto();

switch ($action) {
    case 'create':
        // Espera campos por POST: pronombre, prodesarrollador, proprecio, prodescripcion, prostock, progenero, plataforma
        $data = [
            'pronombre' => $_POST['pronombre'] ?? '',
            'prodesarrollador' => $_POST['prodesarrollador'] ?? '',
            'proprecio' => floatval($_POST['proprecio'] ?? 0),
            'prodescripcion' => $_POST['prodescripcion'] ?? '',
            'prostock' => intval($_POST['prostock'] ?? 0),
            'progenero' => $_POST['progenero'] ?? '',
            'plataforma' => $_POST['plataforma'] ?? '',
            'prodeshabilitado' => null,
            'proimg' => ''
        ];

        // insertar producto
        $producto = new Producto();
        $producto->cargar(null, $data['pronombre'], $data['prodesarrollador'], $data['proprecio'], $data['prodescripcion'], $data['prostock'], $data['progenero'], $data['plataforma'], null, '');
        $ok = $producto->insertar();
        if ($ok) {
            $newId = $producto->getId();
            // subir imagen si existe
            if (isset($_FILES['proimg']) && $_FILES['proimg']['error'] == 0) {
                $dir = __DIR__ . "/../Vista/files/images/productos/";
                if (!is_dir($dir)) mkdir($dir,0755,true);
                $name = time() . "_" . preg_replace('/[^a-zA-Z0-9._-]/','_', $_FILES['proimg']['name']);
                $target = $dir . $name;
                if (move_uploaded_file($_FILES['proimg']['tmp_name'], $target)) {
                    $relPath = "files/images/productos/" . $name;
                    $producto->setImg($relPath);
                    $producto->modificar();
                }
            }
        }
        header("Location: ../Vista/inventario_v5.php");
        exit;
    case 'edit':
        // Espera id + campos
        $id = $_POST['id'] ?? null;
        if ($id) {
            $producto = new Producto();
            if ($producto->buscar($id)) {
                // asigno nuevos valores
                $producto->setNombre($_POST['pronombre'] ?? $producto->getNombre());
                $producto->setDesarrollador($_POST['prodesarrollador'] ?? $producto->getDesarrollador());
                $producto->setPrecio(floatval($_POST['proprecio'] ?? $producto->getPrecio()));
                $producto->setDescripcion($_POST['prodescripcion'] ?? $producto->getDescripcion());
                $producto->setCantStock(intval($_POST['prostock'] ?? $producto->getCantStock()));
                $producto->setGenero($_POST['progenero'] ?? $producto->getGenero());
                $producto->setPlataforma($_POST['plataforma'] ?? $producto->getPlataforma());

                // imagen (opcional)
                if (isset($_FILES['proimg']) && $_FILES['proimg']['error'] == 0) {
                    $dir = __DIR__ . "/../Vista/files/images/productos/";
                    if (!is_dir($dir)) mkdir($dir,0755,true);
                    $name = time() . "_" . preg_replace('/[^a-zA-Z0-9._-]/','_', $_FILES['proimg']['name']);
                    $target = $dir . $name;
                    if (move_uploaded_file($_FILES['proimg']['tmp_name'], $target)) {
                        $relPath = "files/images/productos/" . $name;
                        $producto->setImg($relPath);
                    }
                }

                $producto->modificar();
            }
        }
        header("Location: ../Vista/inventario_v5.php");
        exit;
    case 'delete':
        // delete via POST or GET id
        $id = $_REQUEST['id'] ?? null;
        if ($id) {
            $producto = new Producto();
            if ($producto->buscar($id)) {
                $producto->eliminar();
            }
        }
        header("Location: ../Vista/inventario_v5.php");
        exit;
    default:
        header("Location: ../Vista/inventario_v5.php");
        exit;
}

