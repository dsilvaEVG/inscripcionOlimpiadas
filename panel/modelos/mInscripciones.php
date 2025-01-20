<?php

class mInscripciones{

    private $tabla = 'inscripciones';
    private $conexion;

    public function __construct(){}

    public function conectar(){
        $objetoBD = new bbdd(); //Conectamos a la base de datos. Creamos objeto $objetoBD
        $this->conexion = $objetoBD->conexion; //Llamamos al metodo que realiza la conexion a la BBDD
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
        $sentencia->bind_param("is", $idPrueba, $idClase); // Asegúrate de que los tipos sean correctos
        $sentencia->execute();
        $resultado = $sentencia->get_result();

        if ($resultado && $resultado->num_rows > 0) {
            return $resultado->fetch_all(MYSQLI_ASSOC); // Devuelve el array de resultados
        }
        return null; // Si no hay resultados, devuelve null
    }

    public function mListaClase($idClase){
        $this->conectar();
    // Prepara la consulta para evitar la inyección SQL
    $sql = "SELECT idAlumno, nombre FROM alumnos WHERE idClase = ?";
    // Prepara la sentencia
    if ($sentencia = $this->conexion->prepare($sql)) {
        // Vincula el parámetro a la consulta (entero en este caso)
        $sentencia->bind_param("s", $idClase);  // "i" es para un entero (integer)
        
        // Ejecuta la sentencia
        $sentencia->execute();
        
        // Obtiene los resultados
        $resultado = $sentencia->get_result();

        // Verifica si hay resultados
        if ($resultado->num_rows > 0) {
            return $resultado->fetch_all(MYSQLI_ASSOC);  // Devuelve los resultados como un array asociativo
        } else {
            return [];  // Si no hay resultados, devuelve un array vacío
        }
        
        // Cierra la sentencia
        $sentencia->close();
    } else {
        // Si hubo un error al preparar la consulta, lo registramos
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