<?php
include_once __DIR__ . "/Conector/BaseDatos.php";
class Producto extends BaseDatos{
    private $id;
    private $nombre;
    private $proDesarrollador;
    private $proPrecio;
    private $proDescripcion;
    private $proStock;
    private $proGenero;
    private $proPlataforma;
    private $proImg;
    private $proDeshabilitado;
    private $mensajeOperacion;

    public function __construct()
    {
        parent::__construct();
        $this->id = -1;
        $this->nombre = "";
        $this->proDesarrollador = "";
        $this->proPrecio = 0;
        $this->proDescripcion = "";
        $this->proStock = 0;
        $this->proGenero = "";
        $this->proPlataforma = "";
        $this->proDeshabilitado = null;
        $this->proImg = "";
    }

    public function cargar($id, $nombre, $proDesarrollador, $proPrecio, $proDescripcion, $proStock, $proGenero, $proPlataforma, $proDeshabilitado, $proImg){
        $this->setId($id);
        $this->setNombre($nombre);
        $this->setDesarrollador($proDesarrollador);
        $this->setPrecio($proPrecio);
        $this->setDescripcion($proDescripcion);
        $this->setCantStock($proStock);
        $this->setGenero($proGenero);
        $this->setPlataforma($proPlataforma);
        $this->setDeshabilitado($proDeshabilitado);
        $this->setImg($proImg);
    }

    public function getId(){ return $this->id; }
    public function setId($id){ $this->id = $id; }
    public function getNombre(){ return $this->nombre; }
    public function setNombre($nombre){ $this->nombre = $nombre; }
    public function getDesarrollador(){ return $this->proDesarrollador; }
    public function setDesarrollador($proDesarrollador){ $this->proDesarrollador = $proDesarrollador; }
    public function getPrecio(){ return $this->proPrecio; }
    public function setPrecio($proPrecio){ $this->proPrecio = $proPrecio; }
    public function getDescripcion(){ return $this->proDescripcion; }
    public function setDescripcion($proDescripcion){ $this->proDescripcion = $proDescripcion; }
    public function getCantStock(){ return $this->proStock; }
    public function setCantStock($proStock){ $this->proStock = $proStock; }
    public function getGenero(){ return $this->proGenero; }
    public function setGenero($proGenero){ $this->proGenero = $proGenero; }
    public function getPlataforma(){ return $this->proPlataforma; }
    public function setPlataforma($proPlataforma){ $this->proPlataforma = $proPlataforma; }
    public function getDeshabilitado(){ return $this->proDeshabilitado; }
    public function setDeshabilitado($timestamp){ $this->proDeshabilitado = $timestamp; }
    public function getImg(){ return $this->proImg; }
    public function setImg($img){ $this->proImg = $img; }
    public function getMensajeOperacion(){ return $this->mensajeOperacion; }
    public function setMensajeOperacion($mensajeOperacion){ $this->mensajeOperacion = $mensajeOperacion; }

    public function buscar($id){
        $encontro = false;
        $consulta = "SELECT * FROM producto WHERE idproducto = '" . $id . "'";

        if($this->Iniciar()){
            if($this->Ejecutar($consulta)){
                if($fila = $this->Registro()){
                    $this->cargar(
                        $fila["idproducto"],
                        $fila["pronombre"],
                        $fila["prodesarrollador"],
                        $fila["proprecio"],
                        $fila["prodescripcion"],
                        $fila["prostock"],
                        $fila["progenero"],
                        $fila["plataforma"],
                        $fila["prodeshabilitado"],
                        $fila["proimg"]
                    );
                    $encontro = true;
                }
            }else{$this->setMensajeOperacion("producto->buscar: ".$this->getError());}
        }else{$this->setMensajeOperacion("producto->buscar: ".$this->getError());}

        return $encontro;
    }

    public function listar($condicion = ""){
        $arreglo = null;
        $consulta = "SELECT * FROM producto";
        if($condicion != ""){
            $consulta .= " WHERE " . $condicion;
        }
        if($this->Iniciar()){
            if($this->Ejecutar($consulta)){
                $arreglo = [];
                while($fila = $this->Registro()){
                    $objProducto = new Producto();
                    $objProducto->cargar(
                        $fila["idproducto"],
                        $fila["pronombre"],
                        $fila["prodesarrollador"],
                        $fila["proprecio"],
                        $fila["prodescripcion"],
                        $fila["prostock"],
                        $fila["progenero"],
                        $fila["plataforma"],
                        $fila["prodeshabilitado"],
                        $fila["proimg"]
                    );
                    array_push($arreglo, $objProducto);
                }
            }else{$this->setMensajeOperacion("producto->listar: ".$this->getError());}
        }else{$this->setMensajeOperacion("producto->listar: ".$this->getError());}

        return $arreglo;
    }

    public function insertar(){
    $resultado = false;

    $nombre = $this->getNombre();
    $desarrollador = $this->getDesarrollador();
    $precio = $this->getPrecio();
    $descripcion = $this->getDescripcion();
    $stock = $this->getCantStock();
    $genero = $this->getGenero();
    $plataforma = $this->getPlataforma();
    $deshabilitado = $this->getDeshabilitado() === null ? "NULL" : ("'" . $this->getDeshabilitado() . "'");
    $img = $this->getImg();

    $consulta = "INSERT INTO producto (pronombre, prodesarrollador, proprecio, prodescripcion, prostock, progenero, plataforma, prodeshabilitado, proimg)
        VALUES ('$nombre', '$desarrollador', $precio, '$descripcion', $stock, '$genero', '$plataforma', $deshabilitado, '$img');";

    if ($this->Iniciar()){
        $idInsert = $this->Ejecutar($consulta); // Devuelve lastInsertId()
        if ($idInsert) {
            $this->setId($idInsert);
            $resultado = true;
        } else {
            $this->setMensajeOperacion("producto->insertar: ".$this->getError());
        }
    } else {
        $this->setMensajeOperacion("producto->insertar: ".$this->getError());
    }

    return $resultado;
}


    public function modificar(){
        $seConcreto = false;
        $deshabilitado = $this->getDeshabilitado() === null ? 'null' : ("'" . $this->getDeshabilitado() . "'");

        $consulta = "UPDATE producto SET 
            pronombre = '". $this->getNombre() ."',
            prodesarrollador = '" . $this->getDesarrollador() . "',
            proprecio = ". $this->getPrecio() .",
            prodescripcion = '". $this->getDescripcion() ."',
            prostock = ". $this->getCantStock() .",
            progenero = '" . $this->getGenero() . "',
            plataforma = '". $this->getPlataforma() ."',
            prodeshabilitado = " . $deshabilitado . ",
            proimg = '" . $this->getImg() . "'
            WHERE idproducto = '" . $this->getId(). "'";

        if($this->Iniciar()){
            if($this->Ejecutar($consulta)){
                $seConcreto = true;
            }else{$this->setMensajeOperacion("producto->modificar: ".$this->getError());}
        }else{$this->setMensajeOperacion("producto->modificar: ".$this->getError());}

        return $seConcreto;
    }

    public function eliminar(){
        $seConcreto = false;
        $consulta = "DELETE FROM producto WHERE idproducto = '" . $this->getId() ."'";
        if($this->Iniciar()){
            if($this->Ejecutar($consulta)){
                $seConcreto = true;
            }else{$this->setMensajeOperacion("producto->eliminar: ".$this->getError());}
        }else{$this->setMensajeOperacion("producto->eliminar: ".$this->getError());}
        return $seConcreto;
    }
}
?>
