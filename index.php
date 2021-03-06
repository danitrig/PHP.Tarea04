<?php

//Autocarga de controladores
require_once 'autoload.php';

session_start();

//Si logueado  y mantener no existen, volverá a la página de login y mostrará el error FUERA
if (!isset($_SESSION['logueado']) && (!isset($_COOKIE['mantener']))) {

	if (($_GET['accion']) == "addUser") {
		$controlador = new UsuarioControlador();
		$controlador->addUser();
	}else{
		$controlador = new UsuarioControlador();
		$controlador->login();
	}
} else {
//Comprueba que la url recibe un controlador
	if (isset($_GET['controlador'])) {
		$nombre_controlador = $_GET['controlador'] . 'Controlador';
	} else {
		echo"La pagina no existe!";
		exit();
	}
//Si el controlador es una clase, creamos una instancia.
	if (class_exists($nombre_controlador)) {

		$controlador = new $nombre_controlador();

// Si existe la acción en la url la ejecutamos sino volvemos al índice.
		if (isset($_GET['accion']) && method_exists($controlador, $_GET['accion'])) {
			$accion = filter_input(INPUT_GET, "accion", FILTER_SANITIZE_STRING);
			$controlador->$accion();
		} else {
			$controlador->index();
		}
	} else {
		$controlador->index();
	}
}
?>