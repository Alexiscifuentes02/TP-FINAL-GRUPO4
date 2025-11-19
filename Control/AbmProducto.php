<?php
require_once __DIR__ . '/../Modelo/Producto.php';

class AbmProducto
{
    private function cargarObjeto($param)
    {
        $obj = null;

        if (array_key_exists('pronombre', $param) && array_key_exists('prodesarrollador', $param) && array_key_exists('proprecio', $param) && array_key_exists('prodescripcion', $param) && array_key_exists('prostock', $param) && array_key_exists('progenero', $param) && array_key_exists('plataforma', $param) && array_key_exists('prodeshabilitado', $param) && array_key_exists('proimg', $param)) {
            $obj = new Producto();
            $obj->cargar(null, $param["pronombre"], $param["prodesarrollador"], $param['proprecio'], $param["prodescripcion"],  $param["prostock"], $param['progenero'],$param['plataforma'], $param['prodeshabilitado'], $param['proimg']);
        }
        return $obj;
    }

    private function cargarObjetoConClave($param)
    {
        $obj = null;
        if (isset($param['id'])) {
            $obj = new Producto();
            $obj->buscar($param["id"]);
        }
        return $obj;
    }

    private function seteadosCamposClaves($param)
    {
        $resp = false;
        if (isset($param['id']))
            $resp = true;
        return $resp;
    }

    public function alta($param)
    {
        $resp = array();
        $elObjtTabla = $this->cargarObjeto($param);
        if ($elObjtTabla != null and $elObjtTabla->insertar()) {
            $resp = array('resultado' => true, 'error' => '', 'obj' => $elObjtTabla);
        } else {
            $resp = array('resultado' => false, 'error' => $elObjtTabla ? $elObjtTabla->getMensajeOperacion() : 'Error cargando objeto');
        }
        return $resp;
    }

    public function subirArchivo($param)
    {
        $dir = __DIR__ . "/../Vista/files/images/productos/"; 
        $resp = false;

        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        if (isset($param['imagen']) && isset($param['imagen']['error']) && $param['imagen']['error'] == 0) {
            $tmp = $param['imagen']['tmp_name'];
            $name = basename($param['imagen']['name']);
            $target = $dir . time() . "_" . preg_replace('/[^a-zA-Z0-9._-]/','_', $name);
            if (move_uploaded_file($tmp, $target)) {
                $resp = str_replace(__DIR__ . "/../Vista/", "", $target); // ruta relativa para DB
            }
        }

        return $resp;
    }

    public function altaProducto($data)
    {
        $respuesta = false;
        if (isset($data['pronombre'])) {
            $carga = $this->cargarObjeto($data);
            if ($carga && $carga->insertar()){
                $respuesta = true;
            }
        } 
        return $respuesta;
    }

    public function baja($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $elObjtTabla = $this->cargarObjetoConClave($param);
            if ($elObjtTabla != null and $elObjtTabla->eliminar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    public function modificacion($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            // cargamos con todos los campos
            $elObjtTabla = new Producto();
            $elObjtTabla->cargar($param['id'], $param['pronombre'], $param['prodesarrollador'], $param['proprecio'], $param['prodescripcion'], $param['prostock'], $param['progenero'], $param['plataforma'], isset($param['prodeshabilitado']) ? $param['prodeshabilitado'] : null, isset($param['proimg']) ? $param['proimg'] : "");
            if ($elObjtTabla != null and $elObjtTabla->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    public function buscar($param)
    {
        $where = " true ";
        $claves = ["idproducto", "pronombre", "prodesarrollador", "proprecio", "prodescripcion", "prostock", "progenero", "plataforma", "proimg"];
        $db = ["idproducto", "pronombre", "prodesarrollador", "proprecio", "prodescripcion", "prostock", "progenero", "plataforma", "proimg"];

        if ($param <> null) {
            for ($i = 0; $i < count($claves); $i++) {
                if (isset($param[$claves[$i]])) {
                    $where .= " and " . $db[$i] . " = '" . $param[$claves[$i]]  . "'";
                }
            }
        }

        $obj = new Producto();
        $arreglo = $obj->listar($where);

        return $arreglo;
    }

    public function cambiarStock($param)
{
    if (!isset($param['id']) || !isset($param['cantidad']) || !isset($param['operacion'])) {
        return false;
    }

    $obj = new Producto();
    if (!$obj->buscar($param['id'])) {
        return false;
    }

    $stockActual = $obj->getCantStock();
    $cantidad = (int)$param['cantidad'];

    if ($param["operacion"] == "resta") {
        $nuevoStock = $stockActual - $cantidad;
        if ($nuevoStock < 0) $nuevoStock = 0;
    } else {
        $nuevoStock = $stockActual + $cantidad;
    }

    $obj->setCantStock($nuevoStock);

    return $obj->modificar();
}

}
?>

