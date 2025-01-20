<?php

class mAlumnos{

    private $tabla = 'alumnos';
    private $conexion;

    public function __construct(){}

    public function conectar(){
        $objetoBD = new bbdd(); //Conectamos a la base de datos. Creamos objeto $objetoBD
        $this->conexion = $objetoBD->conexion; //Llamamos al metodo que realiza la conexion a la BBDD
    }

    public function mListaAlumnos(){
        $this->conectar();
        $sql = "SELECT a.idAlumno, a.nombre, c.nomClase FROM ".$this->tabla." AS a INNER JOIN clase AS c ON a.idClase = c.idClase ORDER BY a.idAlumno";
        $resultado = $this->conexion->query($sql);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function mInsertAlumno($idAlumno, $nombre, $idClase){
        $this->conectar();

        $sql = "INSERT INTO " . $this->tabla . " (idAlumno, nombre, idClase) VALUES (?, ?, ?)";
        $sentencia = $this->conexion->prepare($sql);

        if ($sentencia === false) {
            die('Error en la preparación de la consulta: ' . $this->conexion->error);
        }

        $sentencia->bind_param('iss', $idAlumno, $nombre, $idClase);
    
        $resultado = $sentencia->execute();
    
        if ($resultado) {
            return true;
        } else {
            return false;
        }
    }

}
?>