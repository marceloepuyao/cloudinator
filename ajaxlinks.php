<?php
require_once('JSON.php');
require_once('db.php');

$json = new Services_JSON();


try {	
	$query = 'SELECT * FROM links';
	$datos = DBquery2($query);
	$salida = $json->encode($datos);

} catch (Exception $e) {
	print('ERROR! '.$e);
}

print($salida);

?>