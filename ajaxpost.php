<?php
require_once('JSON.php');
require_once('db.php');
$json = new Services_JSON();

if( array_key_exists('getIdFromName', $_POST)){
	$name = $_POST['getIdFromName'];
	try {
		$query = "SELECT id FROM nodos WHERE name = '".$name."' AND tree = $_POST[tree];";
		
		$data = DBquery3($query);
		
		print($json->encode(mysql_result($data, 0)));
	} catch (Exception $e) {
		
		//throw $e;
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
			$query = "INSERT INTO `cloudinator`.`nodos` (`id`, `tree`, `name`, `type`, `posx`, `posy`, `metaname`, `metadata`, `metatype`) VALUES 
			(NULL, $_POST[tree], '$_POST[name]', '$_POST[type]', '$_POST[posx]', '$_POST[posy]', null, null, null);
			";
			
			DBquery4($query);

			$data = array(
				'result' => 'true'
			);
			print($json->encode($data));
		} catch (Exception $e) {
			$data = array(
				'result' => 'false',
				'exception' => $e
			);
			print($json->encode($data));
		}
	}else if($nodo == 'update'){
		try {
			$query = "UPDATE  `cloudinator`.`nodos` SET  `posx` =  $_POST[posx], `posy` =  $_POST[posy] WHERE  `nodos`.`name` ='$_POST[name]' AND `nodos`.`tree` = $_POST[tree];";

			DBquery4($query);

			$data = array(
				'result' => 'true'
			);
			print($json->encode($data));
		} catch (Exception $e) {
			$data = array(
				'result' => 'false',
				'exception' => $e
			);
			print($json->encode($data));
		}
	}else if($nodo == 'updateMeta'){
		try {
			$query = "UPDATE  `cloudinator`.`nodos` SET  `metaname` =  '$_POST[metaname]', `metadata` =  '$_POST[metadata]', `metatype` = '$_POST[metatype]' WHERE  `nodos`.`name` ='".$_POST['name']."' AND `nodos`.`tree` ='".$_POST['tree']."';";

			DBquery4($query);

			$data = array(
				'result' => 'true'
			);
			print($json->encode($data));
		} catch (Exception $e) {
			$data = array(
				'result' => 'false',
				'exception' => $e
			);
			print($json->encode($data));
		}
	}else if($nodo == 'delete'){
		try {
			$query = "DELETE FROM `cloudinator`.`nodos` WHERE `nodos`.`name`='$_POST[name]' AND `nodos`.`tree` = $_POST[tree];";

			DBquery4($query);

			$data = array(
				'result' => 'true'
			);
			print($json->encode($data));
		} catch (Exception $e) {
			$data = array(
				'result' => 'false',
				'exception' => $e
			);
			print($json->encode($data));
		}
	}else if($nodo == 'newname'){
		try {
			$query = "UPDATE  `cloudinator`.`nodos` SET  `name` =  '$_POST[name]' WHERE  `nodos`.`id` =$_POST[id] AND `nodos`.`tree` ='$_POST[tree]';";

			DBquery4($query);

			$data = array(
				'result' => 'true'
			);
			print($json->encode($data));
		} catch (Exception $e) {
			$data = array(
				'result' => 'false',
				'exception' => $e
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
				'result' => 'false',
				'exception' => $e
			);
			print($json->encode($data));
		}
	}
}

if ( array_key_exists('link', $_POST) ) {
	$link = $_POST['link'];
	if($link == 'insert'){
		try {
			$prequerysource = "SELECT id FROM nodos WHERE name = '$_POST[source]';";
			$data1 = DBquery3($prequerysource);
			$sourceid = mysql_result($data1, 0);
			
			$prequerytarget = "SELECT id FROM nodos WHERE name = '$_POST[target]';";
			$data2 = DBquery3($prequerytarget);
			$targetid = mysql_result($data2, 0);
			
			$query = "INSERT INTO `cloudinator`.`links` (`id`, `tree`, `name`, `source`, `target`) VALUES 
			(NULL, $_POST[tree], '$_POST[name]', '$sourceid', '$targetid');";
			
			DBquery4($query);
			
			$data = array(
				'result' => 'true',
			);
			print($json->encode($data));
		} catch (Exception $e) {
			$data = array(
				'result' => 'false',
				'exception' => $e
			);
			print($json->encode($data));
		}
	}elseif ($link == 'update') {
		try {
			$query = "UPDATE  `cloudinator`.`links` SET  `target` = '$_POST[source]', `source` = '$_POST[target]' WHERE `links`.`name` ='$_POST[name]' AND `nodos`.`tree` ='$_POST[tree]';";

			DBquery4($query);
			
			$data = array(
				'result' => 'true',
			);
			print($json->encode($data));
		} catch (Exception $e) {
			$data = array(
				'result' => 'false',
				'exception' => $e
			);
			print($json->encode($data));
		}
	}elseif ($link == 'delete') {
		try {
			
			$prequerysource = "SELECT id FROM nodos WHERE name = '$_POST[source]';";
			$data1 = DBquery3($prequerysource);
			$sourceid = mysql_result($data1, 0);
			
			$prequerytarget = "SELECT id FROM nodos WHERE name = '$_POST[target]';";
			$data2 = DBquery3($prequerytarget);
			$targetid = mysql_result($data2, 0);
			
			$query = "DELETE FROM `cloudinator`.`links` WHERE `links`.`source`='$sourceid' AND `links`.`target` ='$targetid' AND `links`.`tree` =$_POST[tree];";

			DBquery4($query);

			$data = array(
				'result' => 'true'
			);
			print($json->encode($data));
		} catch (Exception $e) {
			$data = array(
				'result' => 'false',
				'exception' => $e
			);
			print($json->encode($data));
		}
	}
}

?>