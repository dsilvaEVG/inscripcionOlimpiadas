<?php

class mClases{

    private $tabla = 'clase';
    private $conexion;

    public function __construct(){}

    public function conectar(){
        $objetoBD = new bbdd(); //Conectamos a la base de datos. Creamos objeto $objetoBD
        $this->conexion = $objetoBD->conexion; //Llamamos al metodo que realiza la conexion a la BBDD
    }

    public function mListaClases(){
        $this->conectar();
        $sql = "SELECT * FROM " .$this->tabla;
        $resultado = $this->conexion->query($sql);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function mInsertClase($idClase, $nomClase){
        $this->conectar();

        $sql = "INSERT INTO " . $this->tabla . " (idClase, nomClase) VALUES (?, ?)";
        $sentencia = $this->conexion->prepare($sql);

        if ($sentencia === false) {
            die('Error en la preparación de la consulta: ' . $this->conexion->error);
        }

        $sentencia->bind_param('ss', $idClase, $nomClase);
    
        $resultado = $sentencia->execute();
    
        if ($resultado) {
            return true;
        } else {
            return false;
        }
    }

}
?>