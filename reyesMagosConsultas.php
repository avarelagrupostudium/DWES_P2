<?php
class ReyesMagosConsultas{
    protected $_conexion;
   
    public function __construct($conexion)
    {
        $this->_conexion = $conexion;
    }
    public function listadoReyesMagos(){
        $consulta = "SELECT * FROM reyesMagos";
        $resultado = mysqli_query($this->_conexion,$consulta);

        if(!$resultado){
            echo 'Error al consultar datos';
        }else{
            return $resultado;
        }
    }
    public function listadoRegalosReyMago($reyMago){
        $consulta = "SELECT regalos.nombre AS nombreRegalo, ninos.nombre AS nombreNino, regalos.precio, ninos.apellidos AS apellidosNino, ninos.bueno 
        FROM regalos 
        INNER JOIN ninosRegalos ON regalos.idRegalos = ninosRegalos.idRegaloFK 
        INNER JOIN ninos ON ninosRegalos.idNinoFK = ninos.idNino 
        INNER JOIN reyesMagos ON regalos.idReyMagoFK = reyesMagos.idReyMago 
        WHERE reyesMagos.nombre = '".$reyMago."';";
        $resultado = mysqli_query($this->_conexion,$consulta);
        if(!$resultado){
            echo 'Error al consultar datos';
        }else{
            return $resultado;
        }
    }
}
?>