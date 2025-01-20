<?php
    require_once CONFIG.'configBBDD.php'; //Archivo de configuraciÃ³n

    class bbdd {

        private $host; //Servidor
        private $db; // Nombre BBDD
        private $user; //Nombre usuario
        private $pass; //ContraseÃ±a (vacio)
        public $conexion;
    
        public function __construct() {		
    
            $this->host = SERVIDOR;
            $this->db = BBDD;
            $this->user = USUARIO;
            $this->pass = PASSWORD;
    
            $this->conexion = new mysqli(SERVIDOR, USUARIO, PASSWORD, BBDD); //Conecta con la base de datos
            $this->conexion->set_charset("utf8"); //Usa juego caracteres UTF8
            $controlador = new mysqli_driver();//Desactivar errores
            $controlador->report_mode = MYSQLI_REPORT_OFF;//Desactivar errores
            $texto_error=$this->conexion->errno;
        }  
    }
?>