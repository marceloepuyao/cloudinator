<?php

require_once('JSON.php');
$json = new Services_JSON();

//CAMBIAR A UNA BASE DE DATOS

$datos = array(
	'¿Qué servicio desea probar sobre Cloud?', 
	'¿Cómo se desea comunicar entre su POC y su Cloud?',
	'¿Qué tipo de conexión desea?',
	'¿Cuentas IPs públicas?',
	'¿Qué ancho de banda?');


$salida = $json->encode($datos);

print($salida);

?>