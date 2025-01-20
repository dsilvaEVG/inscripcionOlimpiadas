<?php

class mInscripciones{

    private $tabla = 'inscripciones';
    private $conexion;

    public function __construct(){}

    public function conectar(){
        $objetoBD = new bbdd(); 
        $this->conexion = $objetoBD->conexion; 
    }

    public function mListaInscripciones(){
        $this->conectar();
        $sql = "SELECT * FROM pruebas";
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

    public function mBuscarInscritos($idPrueba, $idClase){
        $this->conectar();
        $sql = "SELECT alumnos.idAlumno, alumnos.nombre 
            FROM alumnos 
            INNER JOIN inscripciones ON alumnos.idAlumno = inscripciones.idAlumno 
            WHERE inscripciones.idPrueba = ? AND alumnos.idClase = ?";
        $sentencia = $this->conexion->prepare($sql);
        $sentencia->bind_param("is", $idPrueba, $idClase);
        $sentencia->execute();
        $resultado = $sentencia->get_result();

        if ($resultado && $resultado->num_rows > 0) {
            return $resultado->fetch_all(MYSQLI_ASSOC); 
        }
        return null; 
    }

    public function mListaClase($idClase){
        $this->conectar();
    $sql = "SELECT idAlumno, nombre FROM alumnos WHERE idClase = ?";
    if ($sentencia = $this->conexion->prepare($sql)) {
        $sentencia->bind_param("s", $idClase);
        $sentencia->execute();
        $resultado = $sentencia->get_result();

        if ($resultado->num_rows > 0) {
            return $resultado->fetch_all(MYSQLI_ASSOC); 
        } else {
            return [];
        }
        $sentencia->close();
    } else {
        error_log("Error al preparar la consulta: " . $this->conexion->error);
        return false;
    }
    }

    public function mUpdateInscripciones($idClase, $idAlumno, $idPrueba){
        $this->conectar();
        
        $this->conexion->begin_transaction();

        try{
            $sqlBorrar = "DELETE i FROM inscripciones AS i INNER JOIN alumnos AS a ON i.idAlumno = a.idAlumno WHERE i.idPrueba = ? AND a.idClase = ?";
            $sentenciaBorrar = $this->conexion->prepare($sqlBorrar);
            $sentenciaBorrar->bind_param("is", $idPrueba, $idClase);

            if (!$sentenciaBorrar->execute()) {
                throw new Exception("Error al ejecutar el DELETE: " . $sentenciaBorrar->error);
            }
            
            $sentenciaBorrar->close();
            $sqlInsert = "INSERT INTO inscripciones (idPrueba, idAlumno) VALUES (?, ?)";
            $sentenciaInsert = $this->conexion->prepare($sqlInsert);
            $sentenciaInsert->bind_param("ii", $idPrueba, $idAlumno);

            if (!$sentenciaInsert->execute()) {
                throw new Exception("Error al ejecutar el INSERT: " . $sentenciaInsert->error);
            }

            $this->conexion->commit();
            $sentenciaInsert->close();

            return true;

        } catch (Exception $e){
            $this->conexion->rollback();
            echo "Error: ".$e->getMessage();
            return false;
        } finally{
            $this->conexion->close();
        }
    }

}
?>