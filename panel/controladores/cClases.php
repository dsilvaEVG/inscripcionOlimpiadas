<?php

require_once MODELOS.'mClases.php';

class cClases {
    public $tituloPagina;
    public $vista;

    public function __construct() {

        $this->tituloPagina = '';
        $this->vista = '';
        $this->objClases = new mClases(); //objPais es el nombre del objeto instanciado de la clase modelo Pais (mPais). Creamos objeto
    }

    public function cListaClases(){
        //Abro la vista listaPruebas, que me sacará el listado de la tabla pruebas, y hago return de la sentencia select * from pruebas
        $this->vista = 'listaClases';
        return $this->objClases->mListaClases();
    }

    public function cSelectClases(){
        header('Content-Type: application/json');
        $datos = $this->objClases->mListaClases();
        if ($datos) {
            echo json_encode($datos);  // Convertir los datos a JSON y enviarlos como respuesta
        } else {
            // Si no hay datos, puedes devolver un mensaje de error o un array vacío
            echo json_encode(['error' => 'No se encontraron datos']);
        }
    }

    public function cInsertClase(){
       //Aquí haríamos la validación antes de llamar a la base de datos
       $idClase = $_POST["idClase"];
       $nomClase = $_POST["nomClase"];
        $insercionExitosa = $this->objClases->mInsertClase($idClase, $nomClase);
        if ($insercionExitosa) {
            echo "true"; // Indicamos que la inserción fue exitosa
        } else {
            echo "false"; // Indicamos que hubo un problema con la inserción
        }
    }

   
}
    ?>