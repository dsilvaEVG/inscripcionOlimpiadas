<?php

require_once MODELOS.'mInscripciones.php';

class cInscripciones {
    public $tituloPagina;
    public $vista;

    public function __construct() {

        $this->tituloPagina = '';
        $this->vista = '';
        $this->objInscripciones = new mInscripciones(); //objPais es el nombre del objeto instanciado de la clase modelo Pais (mPais). Creamos objeto
    }

    public function cListaInscripciones(){
        //Abro la vista listaPruebas, que me sacará el listado de la tabla pruebas, y hago return de la sentencia select * from pruebas
        $this->vista = 'listaInscripciones';
        return $this->objInscripciones->mListaInscripciones();
    }

    public function cBuscarInscritos(){
        $idPrueba = $_POST["idPrueba"];
        $idClase = $_POST["idClase"];
        $resultado = $this->objInscripciones->mBuscarInscritos($idPrueba, $idClase);
        header('Content-Type: application/json');
        if ($resultado) {
            echo json_encode($resultado);
        } else {
            echo json_encode(['mensaje' => 'No se encontraron alumnos']);
        }
    }

    public function cListaClase(){
        $idClase = $_POST["idClase"];
        header('Content-Type: application/json');
        $datos = $this->objInscripciones->mListaClase($idClase);
        if ($datos) {
            echo json_encode($datos);
        } else {
            echo json_encode(['error' => 'No se encontraron datos']);
        }
    }

    public function cUpdateInscripciones(){
        $idClase = $_POST["idClase"];
        $idAlumno = $_POST["idAlumno"];
        $idPrueba = $_POST["idPrueba"];
        $resultado = $this->objInscripciones->mUpdateInscripciones($idClase, $idAlumno, $idPrueba);
        echo $resultado ? "true" : "false";
    }

   
}
    ?>