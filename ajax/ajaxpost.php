<?php
require_once('../JSON.php');
require_once('../DB/db.php');
$json = new Services_JSON();

if( array_key_exists('getIdFromName', $_POST)){
	$name = $_POST['getIdFromName'];
	try {
		$query = "SELECT id FROM nodos WHERE name = '$name' AND tree = $_POST[tree];";
		
		$data = DBQuery($query);
		$aux = $data->fetch_assoc();
		print($json->encode($aux['id']));
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
			$queryifexist = "SELECT id FROM nodos WHERE name = '$_POST[name]'";
			$ifexist = DBQuery($queryifexist);
			$nifexist = $ifexist->num_rows;
			
			if($nifexist > 0){
				$data = array(
					'result' => 'false'
				);
			}else{
			
				$query = "INSERT INTO `nodos` (`id`, `tree`, `name`, `type`, `posx`, `posy`, `metaname`, `metadata`, `metatype`) VALUES 
				(NULL, $_POST[tree], '$_POST[name]', '$_POST[type]', '$_POST[posx]', '$_POST[posy]', null, null, null);
				";
				
				DBQuery($query);
	
				$data = array(
					'result' => 'true'
				);
			}
			print($json->encode($data));
		} catch (Exception $e) {
			$data = array(
				'result' =>$query ,
				'exception' => $e
			);
			print($json->encode($data));
		}
	}else if($nodo == 'update'){
		try {
			$queryifexist = "SELECT id FROM nodos WHERE name = '$_POST[name]'";
			$ifexist = DBQuery($queryifexist);
			$nifexist = $ifexist->num_rows;
			if($nifexist>1){
				$data = array(
					'result' => 'false'.$nifexist
				);
			}else{
				$query = "UPDATE  `nodos` SET  `posx` =  $_POST[posx], `posy` =  $_POST[posy] WHERE  `nodos`.`name` ='$_POST[name]' AND `nodos`.`tree` = $_POST[tree];";
				DBQuery($query);
				$data = array(
					'result' => 'true'.$nifexist
				);
			}
			
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
			$queryifexist = "SELECT id FROM nodos WHERE name = '$_POST[name]' AND tree =$_POST[tree]";
			$ifexist = DBQuery($queryifexist);
			$nifexist = $ifexist->num_rows;			
			if($nifexist == 1){
			
				$query = "UPDATE `nodos` SET `metaname` =  '$_POST[metaname]', `metadata` =  '$_POST[metadata]', `metatype` = '$_POST[metatype]' WHERE  `nodos`.`name` ='$_POST[name]' AND `nodos`.`tree` =$_POST[tree];";
	
				DBQuery($query);
	
				$data = array(
					'result' => 'true'
				);
				
			}else{
				$data = array(
					'result' => 'false'
				);
			}
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
			$queryidnodo = "SELECT id FROM `nodos`  WHERE `nodos`.`name`='$_POST[name]' AND `nodos`.`tree` = $_POST[tree];";
			$dataqueryidnodo = DBQuery($queryidnodo);
			$aux = $dataqueryidnodo->fetch_assoc();
			$idnodo = $aux['id'];
			
			$linksources = "DELETE FROM `links` WHERE `links`.`source` = '$idnodo'  AND `links`.`tree` = $_POST[tree];";
			DBQuery($linksources);
			
			$linktarget = "DELETE FROM `links` WHERE `links`.`target` = '$idnodo'  AND `links`.`tree` = $_POST[tree];";
			DBQuery($linktarget);
			
			$query = "DELETE FROM `nodos` WHERE `nodos`.`name`='$_POST[name]' AND `nodos`.`tree` = $_POST[tree];";
			DBQuery($query);

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
	}else if($nodo == 'newname'){ //METODO OFICIAL PARA CAMBIAR NOMBRE DE NODOS! (adivinando segun Klaus)
		try {
			$queryifexist = "SELECT id FROM nodos WHERE name = '$_POST[name]'";
			$ifexist = DBQuery($queryifexist);
			$nifexist = $ifexist->num_rows;
			if($nifexist>0){
				$data = array(
					'result' => 'false'
				);
			}else{
				$queryid = "SELECT id FROM nodos 
				WHERE name = '$_POST[id]' AND tree = $_POST[tree];";
				$dataid = DBQuery($queryid);
				$aux = $dataid->fetch_assoc();
				$id = $aux['id'];
			
				$query = "UPDATE `nodos` SET `name` = '$_POST[name]' WHERE `nodos`.`id` =$id AND `nodos`.`tree` ='$_POST[tree]';";
	
				DBQuery($query);
	
				$data = array(
					'result' => 'true'
				);
			}
			print($json->encode($data));
		} catch (Exception $e) {
			$data = array(
				'result' => 'false',
				'exception' => $e
			);
			print($json->encode($data));
		}
	}else if($nodo == 'newnameTEST'){ //ESTO SE USA? DEBE SER BORRADO ?
		try {
			$query = "UPDATE  `nodos` SET  `name` =  '$_POST[newname]' WHERE  `nodos`.`name` ='$_POST[oldname]' AND `nodos`.`tree` ='$_POST[tree]';";

			DBQuery($query);

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
			$prequerysource = "SELECT id, type FROM nodos WHERE name = '$_POST[source]' and tree = $_POST[tree];";
			$data1 = DBQuery($prequerysource);
			$row = $data1->fetch_assoc();
			$sourceid = $row['id'];
			$sourcetype = $row['type'];
			
			$prequerytarget = "SELECT id, type FROM nodos WHERE name = '$_POST[target]' and tree = $_POST[tree];";
			$data2 = DBQuery($prequerytarget);
			$exist = $data2->num_rows;
			
			if($exist > 0){
				//$prequerytarget = "SELECT id, type FROM nodos WHERE name = '$_POST[target]' and tree = $_POST[tree];";
				//$data3 = DBQuery($prequerytarget);
				$row = $data2->fetch_assoc();
				$targetid = $row['id'];
				$targettype = $row['type'];
			}else{
				$insertnode = "INSERT INTO `nodos` (`id`, `tree`, `name`, `type`, `posx`, `posy`, `metaname`, `metadata`, `metatype`) VALUES 
				(NULL, $_POST[tree], '$_POST[target]', '$_POST[typetarget]', '$_POST[xtarget]', '$_POST[ytarget]', null, null, null);";
				DBQuery($insertnode);
				
				//$prequerytarget = "SELECT id FROM nodos WHERE name = '$_POST[target]' and tree = $_POST[tree];";
				$data2 = DBQuery($prequerytarget);
				$row = $data2->fetch_assoc();
				$targetid = $row['id'];
				$targettype = $row['type'];
			}
			
			$problem = false;
			if($sourcetype == "state"){
				
				$nodoublelinkquery = "SELECT id FROM links WHERE source = $sourceid AND tree = $_POST[tree]";
				$nodoublelinks = DBQuery($nodoublelinkquery);
				
				if($nodoublelinks->num_rows >= 1){
					$problem = true;
				}
			}
			
			$queryloop = "SELECT id FROM links WHERE source = $targetid AND target = $sourceid AND tree = $_POST[tree]";
			$loop = DBQuery($queryloop);
			if($loop->num_rows >= 1){
				$problem = true;
			}

			if(!$problem){
				
				$query = "INSERT INTO `links` (`id`, `tree`, `name`, `source`, `target`) VALUES 
				(NULL, $_POST[tree], '$_POST[name]', '$sourceid', '$targetid');";
				
				DBQuery($query);
				
				$data = array(
					'result' => 'true',
				);
				print($json->encode($data));
			}else{
				$data = array(
					'result' => 'false',
				);
				print($json->encode($data));
			}
		} catch (Exception $e) {
			$data = array(
				'result' => 'false',
				'exception' => $e
			);
			print($json->encode($data));
		}
	}elseif ($link == 'update') {
		try {
			$query = "UPDATE  `links` SET  `target` = '$_POST[source]', `source` = '$_POST[target]' WHERE `links`.`name` ='$_POST[name]' AND `nodos`.`tree` =$_POST[tree];";

			DBQuery($query);
			
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
			
			$prequerysource = "SELECT id FROM nodos WHERE name = '$_POST[source]' and tree = $_POST[tree];";
			$data1 = DBQuery($prequerysource);
			$aux1 = $data1->fetch_assoc();
			$sourceid = $aux1['id'];
			
			$prequerytarget = "SELECT id FROM nodos WHERE name = '$_POST[target]' and tree = $_POST[tree];";
			$data2 = DBQuery($prequerytarget);
			$aux2 = $data2->fetch_assoc();
			$targetid = $aux2['id'];
			
			$query = "DELETE FROM `links` WHERE `links`.`source`='$sourceid' AND `links`.`target` ='$targetid' AND `links`.`tree` =$_POST[tree];";

			DBQuery($query);

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

if(isset($_POST['formId'])){
	$id = $_POST['formId'];
	try {
		$query = "SELECT name FROM trees WHERE id = $id";
		
		$data = DBQuery($query);
		$aux = $data->fetch_assoc();
		print($json->encode($aux["name"]));
	} catch (Exception $e) {
		
		//throw $e;
		$data = array(
			'result' => 'false'
		);
		print($json->encode($data));
		
	}
	
}

?>