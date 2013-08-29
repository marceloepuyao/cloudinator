<?php
require_once('JSON.php');
require_once('DB/db.php');

$json = new Services_JSON();

try {	
	$query = "SELECT * FROM links WHERE tree='".$_POST['tree']."'";
	$datos = DBquery2($query);
	$salida = $json->encode($datos);

} catch (Exception $e) {
	print('ERROR! '.$e);
}

print($salida);

?>