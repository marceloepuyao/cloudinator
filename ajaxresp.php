<?php

require_once('JSON.php');
$json = new Services_JSON();

//CAMBIAR A UNA BASE DE DATOS

$datos = array();
	$datos[0] = "Web";
	$datos[1] = "App";
	$datos[2] = "BBDD";
	$datos[3] = "TS";
	$datos[4] = "FServer";


$salida = $json->encode($datos);

print($salida);

?>