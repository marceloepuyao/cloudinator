<?php
require_once('../JSON.php');
require_once('../DB/db.php');

$json = new Services_JSON();

try {	
	$tree = (int)$_POST['tree'];
	
	
	$query = "SELECT * FROM links WHERE tree='$tree'";
	$datos = DBQueryReturnArray($query);
	foreach ($datos as $dato){
		
		$source = DBQueryReturnArray("SELECT * FROM nodos WHERE id = '$dato[source]'");
		$target = DBQueryReturnArray("SELECT * FROM nodos WHERE id = '$dato[target]'");
		
	}
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