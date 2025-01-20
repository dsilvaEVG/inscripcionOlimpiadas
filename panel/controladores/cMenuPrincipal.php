<?php

// require_once MODELOS.'mMenuPrincipal.php';

class cMenuPrincipal {
    public $tituloPagina;
    public $vista;

    public function __construct() {

        $this->tituloPagina = '';
        $this->vista = '';
        // $this->objMenuPrincipal = new mMenuPrincipal(); //objPais es el nombre del objeto instanciado de la clase modelo Pais (mPais). Creamos objeto
    }

    public function cMenuPrincipal(){
        $this->vista = 'menuPrincipal';
    }
}
    ?>