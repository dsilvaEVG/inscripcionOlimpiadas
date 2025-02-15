<?php
    require_once 'config/config.php'; //Constantes config php
    require_once MODELOS.'conexion.php'; //Clase BBDD

if(!isset($_GET["controlador"])){$_GET["controlador"] = DEFAULT_CONTROLADOR;}
if(!isset($_GET["accion"])){$_GET["accion"] = DEFAULT_ACCION;}

$rutaControlador = CONTROLADORES.'c'.$_GET["controlador"].'.php'; // 'controller/cControlador.php'

if(!file_exists($rutaControlador)){$rutaControlador = CONTROLADORES.'c'.DEFAULT_CONTROLADOR.'.php';} // 'controller/cPais.php'

require_once $rutaControlador;

$nombreControlador = 'c'.$_GET["controlador"]; //nombre de la clase controlador (Ejemplo: cPais)
$controlador = new $nombreControlador(); //Instanciamos objeto de la clase controlador

$dataToView["data"] = array();
if(method_exists($controlador,$_GET["accion"])){
    $dataToView["data"] = $controlador->{$_GET["accion"]}();
}

if(isset($controlador->vista) && !empty($controlador->vista)){require_once 'vistas/'.$controlador->vista.'.php';}

?>