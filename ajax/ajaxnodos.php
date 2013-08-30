<?php
require_once('../JSON.php');
require_once('../DB/db.php');

$json = new Services_JSON();

try {	
	$query = "SELECT * FROM nodos WHERE tree='".$_POST['tree']."'";
	$datos = DBQueryReturnArray($query);
	$salida = $json->encode($datos);

} catch (Exception $e) {
	print('ERROR! '.$e);
}

print($salida);

?>