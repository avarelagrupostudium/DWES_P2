<?php 
class Conexion{
    private $_servidor;
    private $_usuario;
    private $_clave;
    private $_bd;

    public function __construct()
    {
        $this->_servidor = 'localhost';
        $this->_usuario = 'studium';
        $this->_clave = 'studium__';
        $this->_bd = 'studium_dws_p2';
    }

    public function connectarBD(){
        $conexion = new mysqli($this->_servidor, $this->_usuario, $this->_clave, $this->_bd);

        if($conexion->connect_error){
            throw new Exception('Error de Conexion (' . $conexion->connect_errno . ') ' . $conexion->connect_error);
        }
            
        return $conexion;
    }
    
}


    
?>