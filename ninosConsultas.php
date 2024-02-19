<?php
class NinosConsultas{
    protected $_conexion;
   
    public function __construct($conexion)
    {
        $this->_conexion = $conexion;
    }
    public function listadoNinos(){
        $consulta = 'SELECT * FROM ninos ORDER BY nombre ASC;';
        $resultado = mysqli_query($this->_conexion,$consulta);

        if(!$resultado){
            echo 'Error al consultar datos';
        }else{
            return $resultado;
        }
    }
    public function datosNino($id){
        $consulta = "SELECT * FROM ninos WHERE idNino =". $id+0 .";";
        $resultado = mysqli_query($this->_conexion,$consulta);  // ejecutar sentencia sql
        if(!$resultado){
            echo  "Error al obtener datos<br>";
        }else{
            return $resultado;
        }
    }
    public function insertarNino($nombre, $apellidos, $fechaNacimiento, $bueno){
        $consulta= "INSERT INTO ninos (nombre, apellidos, fechaNacimiento, bueno) VALUES ('".$nombre."', '".$apellidos."', '".$fechaNacimiento."', ".$bueno+0 .");";
        $resultado = mysqli_query($this->_conexion,$consulta);  // ejecutar sentencia sql
        if(!$resultado){
            echo  "Error al insertar datos<br>";
        }
    }
    public function eliminarNino($id){
        $consulta = "DELETE FROM ninos WHERE idNino =". $id+0 .";";
        $resultado = mysqli_query($this->_conexion,$consulta);  // ejecutar sentencia sql
        if(!$resultado){
            echo  "Error al eliminar datos<br>";
        }
    }
    public function modificarNino($id, $nombre, $apellidos, $fechaNacimiento, $bueno){
        $consulta = "UPDATE ninos SET nombre='".$nombre."', apellidos='".$apellidos."', fechaNacimiento='".$fechaNacimiento."', bueno=".$bueno+0 ." WHERE idNino=".$id.";";
        $resultado = mysqli_query($this->_conexion,$consulta);  // ejecutar sentencia sql
        if(!$resultado){
            echo  "Error al modificar datos<br>";
        }
    }
    public function listaRegalosNino($id){
        $consulta = "SELECT regalos.nombre AS nombre, regalos.precio AS precio, regalos.idRegalos AS id
            FROM ninosRegalos
            INNER JOIN regalos ON ninosRegalos.idRegaloFK = regalos.idRegalos
            WHERE ninosRegalos.idNinoFK = ".$id+0 .";"; 
        $resultado = mysqli_query($this->_conexion,$consulta);  // ejecutar sentencia sql
        if(!$resultado){
            echo  "Error al obtener datos<br>";
        }else{
            return $resultado;
        }
    }
    public function listaRegalosNinoNoSeleccionado($id){
        $consulta= "SELECT regalos.idRegalos AS id, regalos.nombre AS nombre, regalos.precio AS precio 
        FROM regalos 
        LEFT JOIN ninosRegalos ON regalos.idRegalos = ninosRegalos.idRegaloFK AND ninosRegalos.idNinoFK =".$id+0 ." 
        WHERE ninosRegalos.idRegaloFK IS NULL;";
        $resultado = mysqli_query($this->_conexion,$consulta);  // ejecutar sentencia sql
        if(!$resultado){
            echo  "Error al obtener datos<br>";
        }else{
            return $resultado;
        }
    }
    public function insertaRegaloLista($idNino,$idRegalo){
        $consulta = "INSERT INTO ninosRegalos (idNinoFK, idRegaloFK) VALUES (". $idNino+0 .",". $idRegalo+0 .");";
        $resultado = mysqli_query($this->_conexion,$consulta);  // ejecutar sentencia sql
        if(!$resultado){
            echo  "Error al insertar datos<br>";
        }
    }
}
?>