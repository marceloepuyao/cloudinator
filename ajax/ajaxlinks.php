<?php
require_once('../JSON.php');
require_once('../DB/db.php');

$json = new Services_JSON();

try {	
	$query = "SELECT * FROM links WHERE tree='".$_POST['tree']."'";
	$datos = DBQueryReturnArray($query);
	$data = array(
		'result' => true,
		'datos' => $datos
		);
	$salida = $json->encode($data);

} catch (Exception $e) {
	$data = array(
		'result' => false,
		'exception' => $e
		);
	$salida = $json->encode($data);
}

print($salida);

?>