<?php

function autocargar($nombreClase) {
	include 'controladores/' . $nombreClase . '.php';
}

spl_autoload_register('autocargar');
?>