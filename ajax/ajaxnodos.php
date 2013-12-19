<?php
require_once('../JSON.php');
require_once('../DB/db.php');

$json = new Services_JSON();

try {	
	$tree = (int)$_POST['tree'];
	$query = "SELECT * FROM nodos WHERE tree='$tree'";
	$datos = DBQueryReturnArray($query);
	$salida = $json->encode($datos);

} catch (Exception $e) {
	print('ERROR! '.$e);
}

print($salida);

?>