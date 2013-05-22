<?php
require_once('JSON.php');
require_once('db.php');
$json = new Services_JSON();

if ( array_key_exists('nodo', $_POST) ) {
	
	try {
		$query = "INSERT INTO `cloudinator`.`nodos` (`id`, `name`, `type`, `posx`, `posy`) VALUES 
		(NULL, '".$_POST['name']."', '".$_POST['type']."', '".$_POST['posx']."', '".$_POST['posy']."');
		";
		
		DBquery4($query);

		$data = array(
			'result' => 'true',
		);
		print($json->encode($data));
	} catch (Exception $e) {}
}

if ( array_key_exists('link', $_POST) ) {
	
	try {
		$query = "INSERT INTO `cloudinator`.`links` (`id`, `name`, `source`, `target`) VALUES 
		(NULL, '".$_POST['name']."', '".$_POST['source']."', '".$_POST['target']."');";
		
		DBquery4($query);
		
		$data = array(
			'result' => 'true',
		);
		print($json->encode($data));
	} catch (Exception $e) {}
	
}

?>