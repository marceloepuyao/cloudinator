<?php
require_once('../JSON.php');
require_once('../DB/db.php');
require_once('../lib.php');

$json = new Services_JSON();

if(isset($_POST['type'])) { //DEPRICATED: por favor usar ajaxMegaTrees.php, action="add", name="<newname>"
	try {
		$name = $_POST['name'];
		
		DBQuery("INSERT INTO `megatrees` (`id`, `name`, `chain`, `deleted`, `created`, `modified` ) VALUES 
			(NULL, '$name', NULL, 0, '".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."' );
			");

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
}else if(isset($_POST['clonename'])) {
	$name = $_POST['name'];
	$to = (int)$_POST['to'];
	//primero comprobamos si existe un subform con el mismo nombre en el form
	$idclone = $_POST['clonename'];
	
	$check = DBQuery("SELECT * FROM trees WHERE name = '$name' AND megatree = $to AND deleted = 0");
	if($check->num_rows > 0){
		$data = array(
			'result' => false
		);
		print($json->encode($data));
	}else{
		try{
			$sql2 = "SELECT name, type, posx, posy, metaname, metadata, metatype FROM nodos WHERE tree = $idclone";
			$data2 = DBQuery($sql2);
			
			DBQuery("INSERT INTO `trees` (`id`, `name`,`megatree`, `deleted`, `created`) VALUES 
					(NULL, '$_POST[name]', $_POST[to] ,0,'".date("Y-m-d H:i:s")."');
					");
			
			$sqlgettree = "SELECT id FROM trees WHERE name = '$name'";
			$data4 = DBQuery($sqlgettree);
			$aux4 = $data4->fetch_assoc();
			$idnew = $aux4['id'];
			
			while ($fetch = $data2->fetch_assoc()) {
				$name = $fetch['name'];
				$type = $fetch['type'];
				$posx = $fetch['posx'];
				$posy = $fetch['posy'];
				$metaname = $fetch['metaname'];
				$metadata = $fetch['metadata'];
				$metatype = $fetch['metatype'];
		
				$query = "INSERT INTO `nodos` (`id`, `tree`, `name`, `type`, `posx`, `posy`, `metaname`, `metadata`, `metatype`) VALUES 
						(NULL, $idnew, '$name', '$type', '$posx', '$posy', '$metaname', '$metadata', '$metatype');
						";
				DBQuery($query);
			}
		
			$linksprevquery = "SELECT source, target FROM links WHERE tree = $idclone";
			$linksprev= DBQuery($linksprevquery);
		
			while ($fetch = $linksprev->fetch_assoc()) {
				$targeta = $fetch['target'];
				$querytarget = "SELECT id
								FROM nodos
								WHERE name = (SELECT name FROM nodos WHERE id = $targeta ) order by id desc";
				$newtarget = DBQuery($querytarget);
				$aux = $newtarget->fetch_assoc();
				$idnewtarget = $aux['id'];
				
				$sourca = $fetch['source'];
				$querysource = "SELECT id
								FROM nodos
								WHERE name = (SELECT name FROM nodos WHERE id = $sourca ) order by id desc";
				$newsource = DBQuery($querysource);
				$aux = $newsource->fetch_assoc();
				$idnewsource = $aux['id'];
				
				
				$query = "INSERT INTO `links` (`id`, `tree`, `name`, `source`, `target`) VALUES 
						(NULL, $idnew, '', '$idnewsource', '$idnewtarget');";
						
				DBQuery($query);
			}

			$data = array(
				'result' => true
			);
			print($json->encode($data));
		}catch(Exception $e){
			$data = array(
				'result' => false,
				'exception' => $e
			);
			print($json->encode($data));
		}

	}
}else if(isset($_POST['name'])) {
	try {
		$name = $_POST['name'];
		$megatree = (int)$_POST['megatree'];
		//primero comprobamos si existe un subform con el mismo nombre en el form
		$check = DBQuery("SELECT * FROM trees WHERE name = '$name' AND megatree = $megatree AND deleted = 1");
		if($check->num_rows > 0){
			$data = array(
				'result' => false
			);
			print($json->encode($data));
		}else{
			DBQuery("INSERT INTO `trees` (`id`, `name`, `megatree`,`deleted`, `created`) VALUES 
				(NULL, '$name',$megatree ,0, '".date("Y-m-d H:i:s")."');
				");
			$data = array(
				'result' => true
			);
			print($json->encode($data));
		}
	} catch (Exception $e) {
		$data = array(
			'result' => false,
			'exception' => $e
		);
		print($json->encode($data));
	}
}else if(isset($_POST['action']) && $_POST['action'] == "deleteTree") {
	
	$tree = (int)$_POST['tree'];
	try {
		DBQuery("UPDATE trees SET deleted = 1 WHERE id = $tree");
		$data = array(
			'result' => true
		);
		print($json->encode($data));
	}catch (Exception $e){
		$data = array(
			'result' => false,
			'exception' => $e
		);
		print($json->encode($data));
	}
}else if(isset($_POST['action']) && $_POST['action'] == "release") {
	try {
		$id = (int)$_POST['id'];
		
		//first we check if the subform is complete ;)
		if($subform = getSubForm($id)){
			DBQuery("UPDATE trees SET released = 1 WHERE id = $id");
			$data = array(
				'result' => true
			);
			
		}else{
			$data = array(
				'result' => false,
				'reason' => "incomplete"
			);
		}
		
		
		
	}catch (Exception $e){
		$data = array(
			'result' => false,
			'reason' => "error",
			'exception' => $e
		);
	}
	print($json->encode($data));
}else if(isset($_POST['action']) && $_POST['action'] == "checkReleasedAndDeleted") {
	try {
		$id = (int)$_POST['id'];
		$response = DBQuery("SELECT * FROM trees WHERE id = $id");
		$aux = $response->fetch_assoc();
		$deleted = $aux['deleted'];
		$released = $aux['released'];
		$data = array(
			'result' => true,
			'deleted' => $deleted,
			'released' => $released
		);
	}catch (Exception $e){
		$data = array(
			'result' => false,
			'exception' => $e
		);
	}
	print($json->encode($data));
}else if(isset($_POST['nuevonombre'])) {
	try {
		$nuevonombre = $_POST['nuevonombre'];
		$tree = (int)$_POST['tree'];
		
		$response = DBQuery("SELECT * FROM trees WHERE name = '$nuevonombre' AND megatree = (SELECT megatree FROM trees WHERE id = $tree)");
		if($response->num_rows > 0){
			$data = array(
				'result' => false,
				'exception' => 'NombreOcupado'
			);
		}else{
			DBQuery("UPDATE trees SET name = '$nuevonombre' WHERE id = $tree");
			$data = array(
				'result' => true
			);
		}
	}catch (Exception $e){
		$data = array(
			'result' => false,
			'exception' => $e
		);
	}
	print($json->encode($data));
}else{
	try {	
		$query = 'SELECT * FROM trees WHERE deleted = 0';
		$datos = DBQueryReturnArray($query);
		try {
			$data = array(
				'result' => true,
				'datos' => $datos
			);
			$salida = $json->encode($data);
			print($salida);
		} catch (Exception $e) {
			$data = array(
			'result' => false,
			'exception' => $e
		);
		print($json->encode($data));
		}
	} catch (Exception $e) {
		$data = array(
			'result' => false,
			'exception' => $e
		);
		print($json->encode($data));
	}
}
?> 