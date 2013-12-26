<?php
require_once('../JSON.php');
require_once('../DB/db.php');
require_once '../lib.php';
$json = new Services_JSON();

if( array_key_exists('getIdFromName', $_POST)){
	$name = mysql_real_escape_string($_POST['getIdFromName']);
	$tree = (int)$_POST['tree'];
	try {
		$query = "SELECT id FROM nodos WHERE name = '$name' AND tree = $tree;";
		
		$data = DBQuery($query);
		$aux = $data->fetch_assoc();
		print($json->encode($aux['id']));
	} catch (Exception $e) {
		
		//throw $e;
		$data = array(
			'result' => false,
			'exception' => $e
		);
		print($json->encode($data));
	}
}

if(isset($_POST['formId'])){
	$id = (int)$_POST['formId'];
	try {
		$query = "SELECT name FROM trees WHERE id = $id";
		
		$data = DBQuery($query);
		$aux = $data->fetch_assoc();
		print($json->encode($aux["name"]));
	} catch (Exception $e) {
		//throw $e;
		$data = array(
			'result' => false,
			'exception' => $e
		);
		print($json->encode($data));
	}
}

if(array_key_exists('nodo', $_POST) || array_key_exists('link', $_POST)){
	try{
		$tree = (int)$_POST['tree'];
		$response = DBQuery("SELECT * FROM trees WHERE id = $tree");
		$aux = $response->fetch_assoc();
		$released = $aux['released'];
		$deleted = $aux['deleted'];
		if($released == "1" || $deleted == "1"){
			$deletedOrReleased = true;
			$data = array(
				'result' => false,
				'exception' => 'DeletedOrReleased'
			);
			print($json->encode($data));
		}else{
			$deletedOrReleased = false;
		}
	}catch(Exception $e){
		$deletedOrReleased = true;
		$data = array(
			'result' => false,
			'exception' => $e
		);
		print($json->encode($data));
	}
	if(!$deletedOrReleased){
		if ( array_key_exists('nodo', $_POST) ) {
			$nodo = mysql_real_escape_string($_POST['nodo']);
			if($nodo == 'insert'){
				try {
					
					$name = mysql_real_escape_string($_POST['name']);
					$tree = (int)$_POST['tree'];
					$type = mysql_real_escape_string($_POST['type']);
					$posx = (int)$_POST['posx'];
					$posy = (int)$_POST['posy'];
					
					$queryifexist = "SELECT id FROM nodos WHERE name = '$name'";
					$ifexist = DBQuery($queryifexist);
					$nifexist = $ifexist->num_rows;
					
					if($nifexist > 0){
						$data = array(
							'result' => false,
							'exception' => 'NombreOcupado'
						);
					}else{
					
						$query = "INSERT INTO `nodos` (`id`, `tree`, `name`, `type`, `posx`, `posy`, `metaname`, `metadata`, `metatype`) VALUES 
						(NULL, $tree, '$name', '$type', '$posx', '$posy', null, null, null);
						";
						
						DBQuery($query);
						
						//*************** Conexión MAGENTO
						//addProductMagento($name);			
						//*************** Fin conexión MAGENTO
			
						$data = array(
							'result' => true
						);
					}
					print($json->encode($data));
				} catch (Exception $e) {
					$data = array(
						'result' => false,
						'exception' => var_dump($e)
					);
					print($json->encode($data));
				}
			}else if($nodo == 'update'){
				$name = mysql_real_escape_string($_POST['name']);
				$tree = (int)$_POST['tree'];
				$posx = (int)$_POST['posx'];
				$posy = (int)$_POST['posy'];
				
				try {
					$queryifexist = "SELECT id FROM nodos WHERE name = '$name' AND tree = '$tree'";
					$ifexist = DBQuery($queryifexist);
					$nifexist = $ifexist->num_rows;
					if($nifexist != 1){
						$data = array(
							'result' => false,
							'exception' => 'NombreNoEncontrado'
						);
					}else{
						$query = "UPDATE  `nodos` SET  `posx` =  $posx, `posy` =  $posy WHERE  `nodos`.`name` ='$name' AND `nodos`.`tree` = $tree;";
						DBQuery($query);
						$data = array(
							'result' => true
						);
					}
					
					print($json->encode($data));
				} catch (Exception $e) {
					$data = array(
						'result' => false,
						'exception' => $e
					);
					print($json->encode($data));
				}
			}else if($nodo == 'updateMeta'){
				try {
					$name = mysql_real_escape_string($_POST['name']);
					$tree = (int)$_POST['tree'];
					$metaname = $_POST['metaname'];
					$metadata = $_POST['metadata'];
					$metatype = $_POST['metatype'];
					
					$queryifexist = "SELECT * FROM nodos WHERE name = '$name' AND tree = $tree";
					$ifexist = DBQuery($queryifexist);
					$nifexist = $ifexist->num_rows;
					if($nifexist == 1){
					
						$query = "UPDATE `nodos` SET `metaname` =  '$metaname', `metadata` =  '$metadata', `metatype` = '$metatype' WHERE `nodos`.`name` = '$name' AND `nodos`.`tree` = $tree;";
			
						DBQuery($query);
			
						$data = array(
							'result' => true,
							'nifexist' => $nifexist
						);
						
					}else{
						$data = array(
							'result' => false,
							'nifexist' => $nifexist
						);
					}
					print($json->encode($data));
				} catch (Exception $e) {
					$data = array(
						'result' => false,
						'exception' => $e
					);
					print($json->encode($data));
				}
			}else if($nodo == 'delete'){
				try {
					$name = mysql_real_escape_string($_POST['name']);
					$tree = (int)$_POST['tree'];
					
					$queryidnodo = "SELECT id FROM `nodos`  WHERE `nodos`.`name`='$name' AND `nodos`.`tree` = $tree;";
					$dataqueryidnodo = DBQuery($queryidnodo);
					$aux = $dataqueryidnodo->fetch_assoc();
					$idnodo = $aux['id'];
					
					$linksources = "DELETE FROM `links` WHERE `links`.`source` = '$idnodo'  AND `links`.`tree` = $tree;";
					DBQuery($linksources);
					
					$linktarget = "DELETE FROM `links` WHERE `links`.`target` = '$idnodo'  AND `links`.`tree` = $tree;";
					DBQuery($linktarget);
					
					$query = "DELETE FROM `nodos` WHERE `nodos`.`name`='$name' AND `nodos`.`tree` = $tree;";
					DBQuery($query);

					$data = array(
						'result' => true
					);
					print($json->encode($data));
				} catch (Exception $e) {
					$data = array(
						'result' => false,
						'exception' => $e
					);
					print($json->encode($data));
				}
			}else if($nodo == 'newname'){ //METODO OFICIAL PARA CAMBIAR NOMBRE DE NODOS! (adivinando segun Klaus)
				try {
					$name = mysql_real_escape_string($_POST['name']);
					$tree = (int)$_POST['tree'];
					
					$queryifexist = "SELECT id FROM nodos WHERE name = '$name' AND tree = $tree ";
					$ifexist = DBQuery($queryifexist);
					$nifexist = $ifexist->num_rows;
					if($nifexist>0){
						$data = array(
							'result' => false
						);
					}else{
						$id = mysql_real_escape_string($_POST['id']);
						$queryid = "SELECT id FROM nodos 
						WHERE name = '$id' AND tree = $tree;";
						$dataid = DBQuery($queryid);
						$aux = $dataid->fetch_assoc();
						$id = $aux['id'];
					
						$query = "UPDATE `nodos` SET `name` = '$name' WHERE `nodos`.`id` =$id AND `nodos`.`tree` ='$tree';";
			
						DBQuery($query);
			
						$data = array(
							'result' => true
						);
					}
					print($json->encode($data));
				} catch (Exception $e) {
					$data = array(
						'result' => false,
						'exception' => $e
					);
					print($json->encode($data));
				}
			}else if($nodo == 'newnameTEST'){ //ESTO SE USA? DEBE SER BORRADO ?
				try {
					$newname = mysql_real_escape_string($_POST['newname']);
					$oldname = mysql_real_escape_string($_POST['oldname']);
					$tree = (int)$_POST['tree'];
					
					$query = "UPDATE  `nodos` SET  `name` =  '$newname' WHERE  `nodos`.`name` ='$oldname' AND `nodos`.`tree` ='$tree';";

					DBQuery($query);

					$data = array(
						'result' => true
					);
					print($json->encode($data));
				} catch (Exception $e) {
					$data = array(
						'result' => false,
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
					$source = mysql_real_escape_string($_POST['source']);
					$target = mysql_real_escape_string($_POST['target']);
					$typetarget = mysql_real_escape_string($_POST['typetarget']);
					$tree = (int)$_POST['tree'];
					$xtarget = (int)$_POST['xtarget'];
					$ytarget = (int)$_POST['ytarget'];
					$name = mysql_real_escape_string($_POST['name']);
					
					
					$prequerysource = "SELECT id, type FROM nodos WHERE name = '$source' and tree = $tree;";
					$data1 = DBQuery($prequerysource);
					$row = $data1->fetch_assoc();
					$sourceid = $row['id'];
					$sourcetype = $row['type'];
					
					$prequerytarget = "SELECT id, type FROM nodos WHERE name = '$target' and tree = $tree;";
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
						(NULL, $tree, '$target', '$typetarget', $xtarget, $ytarget, null, null, null);";
						DBQuery($insertnode);
						
						//$prequerytarget = "SELECT id FROM nodos WHERE name = '$_POST[target]' and tree = $_POST[tree];";
						$data2 = DBQuery($prequerytarget);
						$row = $data2->fetch_assoc();
						$targetid = $row['id'];
						$targettype = $row['type'];
					}
					
					$problem = false;
					if($sourcetype == "state"){
						
						$nodoublelinkquery = "SELECT id FROM links WHERE source = $sourceid AND tree = $tree";
						$nodoublelinks = DBQuery($nodoublelinkquery);
						
						if($nodoublelinks->num_rows >= 1){
							$problem = true;
						}
					}
					
					$queryloop = "SELECT id FROM links WHERE source = $targetid AND target = $sourceid AND tree = $tree";
					$loop = DBQuery($queryloop);
					if($loop->num_rows >= 1){
						$problem = true;
					}

					if(!$problem){
						
						$query = "INSERT INTO `links` (`id`, `tree`, `name`, `source`, `target`) VALUES 
						(NULL, $tree, '$name', $sourceid, $targetid);";
						
						DBQuery($query);
						
						$data = array(
							'result' => true,
						);
						print($json->encode($data));
					}else{
						$data = array(
							'result' => false,
						);
						print($json->encode($data));
					}
					
				} catch (Exception $e) {
					$data = array(
						'result' => false,
						'exception' => var_dump($e)
					);
					print($json->encode($data));
				}
			}elseif ($link == 'update') {
				try {
					$source = (int)$_POST['source'];
					$target = (int)$_POST['target'];
					$name =  mysql_real_escape_string($_POST['name']);
					$tree = (int)$_POST['tree'];
					$query = "UPDATE  `links` SET  `target` = '$source', `source` = '$target' WHERE `links`.`name` ='$name' AND `nodos`.`tree` =$tree;";

					DBQuery($query);
					
					$data = array(
						'result' => true,
					);
					print($json->encode($data));
				} catch (Exception $e) {
					$data = array(
						'result' => false,
						'exception' => $e
					);
					print($json->encode($data));
				}
			}elseif ($link == 'delete') {
				try {
					$source = mysql_real_escape_string($_POST['source']);
					$target = mysql_real_escape_string($_POST['target']);
					$name =  mysql_real_escape_string($_POST['name']);
					$tree = (int)$_POST['tree'];
					
					$prequerysource = "SELECT id FROM nodos WHERE name = '$source' and tree = $tree;";
					$data1 = DBQuery($prequerysource);
					$aux1 = $data1->fetch_assoc();
					$sourceid = $aux1['id'];
					
					$prequerytarget = "SELECT id FROM nodos WHERE name = '$target' and tree = $tree;";
					$data2 = DBQuery($prequerytarget);
					$aux2 = $data2->fetch_assoc();
					$targetid = $aux2['id'];
					
					$query = "DELETE FROM `links` WHERE `links`.`source`='$sourceid' AND `links`.`target` ='$targetid' AND `links`.`tree` =$tree;";

					DBQuery($query);

					$data = array(
						'result' => true
					);
					print($json->encode($data));
				} catch (Exception $e) {
					$data = array(
						'result' => false,
						'exception' => $e
					);
					print($json->encode($data));
				}
			}
		}
	}
}
?>