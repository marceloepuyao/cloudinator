<?php
require_once('JSON.php');
require_once('db.php');

$json = new Services_JSON();

if (isset($_POST['name'])) {
	try {
		DBquery3("INSERT INTO `cloudinator`.`trees` (`id`, `name`, `deleted`, `created`) VALUES 
			(NULL, '".$_POST['name']."', 0, '".date("Y-m-d H:i:s")."');
			");

		//la siguiente linea no esta funcionando )= se supone que envia el id de vuelta para poder ponerlo en el querystring
		$data = DBquery4("SELECT id FROM trees WHERE name='".$_POST['name']."'");
		
		print($json->encode($data));
	} catch (Exception $e) {
		print($e);
	}
}else{
	try {	
		$query = 'SELECT * FROM trees';
		$datos = DBquery2($query);
		$salida = $json->encode($datos);

	} catch (Exception $e) {
		print('ERROR! '.$e);
	}

	print($salida);
}
?> 