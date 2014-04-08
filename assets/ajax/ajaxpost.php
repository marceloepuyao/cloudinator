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
						
						$result = DBQuery($query);
						
						$id = DBQueryReturnArray("SELECT id from nodos ORDER BY id DESC ");
						
						//*************** Conexión MAGENTO
						//addProductMagento($name);			
						//*************** Fin conexión MAGENTO
			
						$data = array(
							'result' => true,
							'id' => $id[0]['id']
							
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
				$id = mysql_real_escape_string($_POST['id']);
				$tree = (int)$_POST['tree'];
				$posx = (int)$_POST['posx'];
				$posy = (int)$_POST['posy'];
				
				try {
					$queryifexist = "SELECT id FROM nodos WHERE id = '$id' AND tree = '$tree'";
					$ifexist = DBQuery($queryifexist);
					$nifexist = $ifexist->num_rows;
					if($nifexist != 1){
						$data = array(
							'result' => false,
							'exception' => 'NombreNoEncontrado'
						);
					}else{
						$query = "UPDATE  `nodos` SET  `posx` =  $posx, `posy` =  $posy WHERE  `nodos`.`id` ='$id' AND `nodos`.`tree` = $tree;";
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
					$metaname = mysql_real_escape_string($_POST['metaname']);
					$metadata = mysql_real_escape_string($_POST['metadata']);
					$metatype = mysql_real_escape_string($_POST['metatype']);
					$idnode = (int)$_POST['idnode'];
					
					
					$queryifexist = "SELECT * FROM nodos WHERE id = $idnode AND tree = $tree";
					$ifexist = DBQueryReturnArray($queryifexist);
			
					
					$nifexist2 = 0;
					
					if($ifexist[0]['name'] != $name){
						
						$queryifexist2 = "SELECT * FROM nodos WHERE name = '$name' AND tree = $tree AND id NOT IN ($idnode)";
						$ifexist2 = DBQueryReturnArray($queryifexist2);
						$nifexist2 = count($ifexist2);
					}
					if($nifexist2==0){
					
						$query = "UPDATE `nodos` SET `name` = '$name', `metaname` =  '$metaname', `metadata` =  '$metadata', `metatype` = '$metatype' WHERE `nodos`.`id` = $idnode AND `nodos`.`tree` = $tree;";
			
						DBQuery($query);
			
						$data = array(
							'result' => true,
							'nifexist' => 0
						);
						
					}else{
						$data = array(
							'result' => false,
							'nifexist' => $nifexist2
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
					$nodeid = (int)($_POST['nodeid']);
					$tree = (int)$_POST['tree'];
					
					//borramos los link donde el nodo es la fuente
					$linksources = "DELETE FROM `links` WHERE `links`.`source` = '$nodeid'  AND `links`.`tree` = $tree;";
					DBQuery($linksources);
					
					//borramos los link donde el nodo es el target
					$linktarget = "DELETE FROM `links` WHERE `links`.`target` = '$nodeid'  AND `links`.`tree` = $tree;";
					DBQuery($linktarget);
					
					$query = "DELETE FROM `nodos` WHERE `nodos`.`id`='$nodeid' AND `nodos`.`tree` = $tree;";
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
					$idsource = (int)($_POST['idsource']);
					$idtarget = (int)($_POST['idtarget']);
					$typetarget = mysql_real_escape_string($_POST['typetarget']);
					$typesource = mysql_real_escape_string($_POST['typesource']);
					$tree = (int)$_POST['tree'];
					$xtarget = (int)$_POST['xtarget'];
					$ytarget = (int)$_POST['ytarget'];
					$name = mysql_real_escape_string($_POST['name']);
						
					
					
					if($idtarget == 0){
						$insertnode = "INSERT INTO `nodos` (`id`, `tree`, `name`, `type`, `posx`, `posy`, `metaname`, `metadata`, `metatype`) VALUES 
						(NULL, $tree, '$target', '$typetarget', $xtarget, $ytarget, null, null, null);";
						DBQuery($insertnode);
						
						$prequerytarget = "SELECT id FROM nodos ORDER BY id DESC;";
						$data2 = DBQueryReturnArray($prequerytarget);
						$idtarget = $data2[0]['id'];
					}
					
					$problem = false;
					if($typesource == "state"){
						
						$nodoublelinkquery = "SELECT id FROM links WHERE source = $idsource AND tree = $tree";
						$nodoublelinks = DBQuery($nodoublelinkquery);
						
						if($nodoublelinks->num_rows >= 1){
							$problem = true;
						}
					}
					
					$queryloop = "SELECT id FROM links WHERE source = $idtarget AND target = $idsource AND tree = $tree";
					$loop = DBQuery($queryloop);
					if($loop->num_rows >= 1){
						$problem = true;
					}

					if(!$problem){
						
						$query = "INSERT INTO `links` (`id`, `tree`, `name`, `source`, `target`) VALUES 
						(NULL, $tree, '$name', $idsource, $idtarget);";
						
						DBQuery($query);
						
						$data = array(
							'result' => true,
						);
						print($json->encode($data));
					}else{
						$data = array(
							'result' => false,
							'problem' => true
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
					$name =  (int)($_POST['name']);
					$tree = (int)$_POST['tree'];
					
					$query = "DELETE FROM `links` WHERE `links`.`id`='$name' AND `links`.`tree` =$tree;";

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