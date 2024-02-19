<?php
class RegalosConsultas{
    protected $_conexion;
   
    public function __construct($conexion)
    {
        $this->_conexion = $conexion;
    }
    public function listadoRegalos(){
        $consulta = "SELECT regalos.idRegalos AS id, regalos.nombre AS nombre, regalos.precio AS precio, reyesMagos.nombre AS reyMago
            FROM regalos 
            INNER JOIN reyesMagos ON regalos.idReyMagoFK = reyesMagos.idReyMago
            ORDER BY nombre ASC;
        ";
        $resultado = mysqli_query($this->_conexion,$consulta);

        if(!$resultado){
            echo 'Error al consultar datos';
        }else{
            return $resultado;
        }
    }
    public function datosRegalo($id){
        $consulta = "SELECT * FROM regalos WHERE idRegalos =".$id+0 .";";
        $resultado = mysqli_query($this->_conexion,$consulta);

    if(!$resultado){
        echo 'Error al consultar datos';
    }else{
        return $resultado;
    }
    }
    public function insertarRegalo($nombre, $precio, $idReyMago ){
        $consulta = "INSERT INTO regalos (nombre, precio, idReyMagoFK) 
        VALUES ('".$nombre."',".$precio.", ".$idReyMago.")";
        $resultado = mysqli_query($this->_conexion,$consulta);  // ejecutar sentencia sql
        if(!$resultado){
            echo  "Error al insertar datos<br>";
        }
    }
    public function eliminarRegalo($id){
        $consulta = "DELETE FROM regalos WHERE idRegalos =". $id+0 .";";
        $resultado = mysqli_query($this->_conexion,$consulta);  // ejecutar sentencia sql
        if(!$resultado){
            echo  "Error al eliminar datos<br>";
        }
    }
    public function modificarRegalo($id, $nombre, $precio, $idReyMago){
        $consulta = "UPDATE regalos SET nombre='".$nombre."', precio=".$precio.", idReyMagoFK=".$idReyMago."
        WHERE idRegalos=".$id+0 .";";
        $resultado = mysqli_query($this->_conexion,$consulta);  // ejecutar sentencia sql
        if(!$resultado){
            echo  "Error al modificar datos<br>";
        }
    }
    
    
}
?>