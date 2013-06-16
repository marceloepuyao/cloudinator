<?php
require_once('JSON.php');
require_once('db.php');
$json = new Services_JSON();

if( array_key_exists('getIdFromName', $_POST)){
	$name = $_POST['getIdFromName'];
	try {
		$query = "SELECT id FROM nodos WHERE name = $name AND tree = $_POST[tree];";
		
		$data = DBquery3($query);
		/*
		$data = array(
			'result' => 'true'
		);
		*/
		print($json->encode($data));
	} catch (Exception $e) {
		$data = array(
			'result' => 'false'
		);
		print($json->encode($data));
	}
}

if ( array_key_exists('nodo', $_POST) ) {
	$nodo = $_POST['nodo'];
	if($nodo == 'insert'){
		try {
			$query = "INSERT INTO `cloudinator`.`nodos` (`id`, `tree`, `name`, `type`, `posx`, `posy`) VALUES 
			(NULL, ".$_POST['tree'].", '".$_POST['name']."', '".$_POST['type']."', '".$_POST['posx']."', '".$_POST['posy']."');
			";
			
			DBquery4($query);

			$data = array(
				'result' => 'true'
			);
			print($json->encode($data));
		} catch (Exception $e) {
			$data = array(
				'result' => 'false'
			);
			print($json->encode($data));
		}
	}else if($nodo == 'update'){
		try {
			$query = "UPDATE  `cloudinator`.`nodos` SET  `posx` =  ".$_POST['posx'].", `posy` =  ".$_POST['posy']." WHERE  `nodos`.`name` ='".$_POST['name']."' AND `nodos`.`tree` ='".$_POST['tree']."';";

			DBquery4($query);

			$data = array(
				'result' => 'true'
			);
			print($json->encode($data));
		} catch (Exception $e) {
			$data = array(
				'result' => 'false'
			);
			print($json->encode($data));
		}
	}else if($nodo == 'delete'){
		try {
			$query = "DELETE FROM `cloudinator`.`nodos` WHERE `nodos`.`name`='".$_POST['name']."' AND `nodos`.`tree` ='".$_POST['tree']."';";

			DBquery4($query);

			$data = array(
				'result' => 'true'
			);
			print($json->encode($data));
		} catch (Exception $e) {
			$data = array(
				'result' => 'false'
			);
			print($json->encode($data));
		}
	}else if($nodo == 'newname'){
		try {
			$query = "UPDATE  `cloudinator`.`nodos` SET  `name` =  '$_POST[name]' WHERE  `nodos`.`id` ='$_POST[id]' AND `nodos`.`tree` ='$_POST[tree]';";

			DBquery4($query);

			$data = array(
				'result' => 'true'
			);
			print($json->encode($data));
		} catch (Exception $e) {
			$data = array(
				'result' => 'false'
			);
			print($json->encode($data));
		}
	}else if($nodo == 'newnameTEST'){
		try {
			$query = "UPDATE  `cloudinator`.`nodos` SET  `name` =  '$_POST[newname]' WHERE  `nodos`.`name` ='$_POST[oldname]' AND `nodos`.`tree` ='$_POST[tree]';";

			DBquery4($query);

			$data = array(
				'result' => 'true'
			);
			print($json->encode($data));
		} catch (Exception $e) {
			$data = array(
				'result' => 'false'
			);
			print($json->encode($data));
		}
	}
}

if ( array_key_exists('link', $_POST) ) {
	$link = $_POST['link'];
	if($link == 'insert'){
		try {
			$query = "INSERT INTO `cloudinator`.`links` (`id`, `tree`, `name`, `source`, `target`) VALUES 
			(NULL, '".$_POST['tree']."', '".$_POST['name']."', '".$_POST['source']."', '".$_POST['target']."');";
			
			DBquery4($query);
			
			$data = array(
				'result' => 'true',
			);
			print($json->encode($data));
		} catch (Exception $e) {
			$data = array(
				'result' => 'false'
			);
			print($json->encode($data));
		}
	}elseif ($link == 'update') {
		try {
			$query = "UPDATE  `cloudinator`.`links` SET  `target` = '".$_POST['source']."', `source` = '".$_POST['target']."' WHERE `links`.`name` ='".$_POST['name']."' AND `nodos`.`tree` ='".$_POST['tree']."';";

			DBquery4($query);
			
			$data = array(
				'result' => 'true',
			);
			print($json->encode($data));
		} catch (Exception $e) {
			$data = array(
				'result' => 'false'
			);
			print($json->encode($data));
		}
	}elseif ($link == 'delete') {
		try {
			$query = "DELETE FROM `cloudinator`.`links` WHERE `links`.`name`='".$_POST['name']."' AND `nodos`.`tree` ='".$_POST['tree']."';";

			DBquery4($query);

			$data = array(
				'result' => 'true'
			);
			print($json->encode($data));
		} catch (Exception $e) {
			$data = array(
				'result' => 'false'
			);
			print($json->encode($data));
		}
	}
}

?>