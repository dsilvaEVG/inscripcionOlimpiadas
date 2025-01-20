<?php

require_once MODELOS.'mAlumnos.php';

class cAlumnos {
    public $tituloPagina;
    public $vista;

    public function __construct() {

        $this->tituloPagina = '';
        $this->vista = '';
        $this->objAlumnos = new mAlumnos(); //objPais es el nombre del objeto instanciado de la clase modelo Pais (mPais). Creamos objeto
    }

    public function cListaAlumnos(){
        //Abro la vista listaPruebas, que me sacará el listado de la tabla pruebas, y hago return de la sentencia select * from pruebas
        $this->vista = 'listaAlumnos';
        return $this->objAlumnos->mListaAlumnos();
    }


    public function cInsertAlumno(){
       //Aquí haríamos la validación antes de llamar a la base de datos
       $idAlumno = $_POST["idAlumno"];
       $nombre = $_POST["nombre"];
       $idClase = $_POST["idClase"];

        $insercionExitosa = $this->objAlumnos->mInsertAlumno($idAlumno, $nombre, $idClase);
        if ($insercionExitosa) {
            echo "true"; // Indicamos que la inserción fue exitosa
        } else {
            echo "false"; // Indicamos que hubo un problema con la inserción
        }
    }

   
}
    ?>