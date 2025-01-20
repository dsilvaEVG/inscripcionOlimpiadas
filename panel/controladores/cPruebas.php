<?php

require_once MODELOS.'mPruebas.php';

class cPruebas {
    public $tituloPagina;
    public $vista;

    public function __construct() {

        $this->tituloPagina = '';
        $this->vista = '';
        $this->objPruebas = new mPruebas(); //objPais es el nombre del objeto instanciado de la clase modelo Pais (mPais). Creamos objeto
    }

    public function cListaPruebas(){
        //Abro la vista listaPruebas, que me sacará el listado de la tabla pruebas, y hago return de la sentencia select * from pruebas
        $this->vista = 'listaPruebas';
        return $this->objPruebas->mListaPruebas();
    }

    public function cInsertPrueba(){
       //Aquí haríamos la validación antes de llamar a la base de datos
       $idPrueba = $_POST["idPrueba"];
       $nombrePrueba = $_POST["nombrePrueba"];
        $insercionExitosa = $this->objPruebas->mInsertPrueba($idPrueba, $nombrePrueba);
        if ($insercionExitosa) {
            echo "true"; // Indicamos que la inserción fue exitosa
        } else {
            echo "false"; // Indicamos que hubo un problema con la inserción
        }
    }

   
}
    ?>