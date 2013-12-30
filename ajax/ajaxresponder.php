<?php
require_once('../JSON.php');
require_once('../DB/db.php');
session_start();

$json = new Services_JSON();

$action = $_POST['action'];
if($action == 'insert'){

	try {
		$db = DBConnect();
		$db->autocommit(FALSE);
		$idlev = (int)$_POST['idlev'];
		$idsubform = (int)$_POST['idsubform'];
		$idnode = (int)$_POST['idnode'];
		$idpregunta = (int)$_POST['idpregunta'];
		$idempresa= (int)$_POST['idempresa'];
		$idclone= (int)$_POST['idclone'];
		$respsubpregunta = mysql_real_escape_string($_POST['respsubpregunta']);
		$emailuser = $_SESSION['usuario'];
		
		$user = DBQueryReturnArray("SELECT * FROM users WHERE email = '$emailuser'");
		$userid = $user[0]['id'];
		
		if($idclone){
			$change = "clonedid= $idclone AND"; 
		}else{
			$change = "subformid= $idsubform AND"; 
		}
		
		$registro = DBQueryReturnArray("SELECT * 
							FROM registropreguntas
							WHERE preguntaid = $idpregunta AND
								$change
								levantamientoid = $idlev
								 ");
		

		
		if(count($registro) > 0){
			if($registro[0]['respuestaid'] == $idnode && $registro[0]['respsubpregunta'] == $respsubpregunta){
				
			}else{
				DBQuery(" DELETE
						FROM registropreguntas 
						WHERE $change
								levantamientoid = $idlev AND
								created >= '".$registro[0]['created']."'");
				DBQuery("INSERT INTO `registropreguntas` (`id`, `preguntaid`, `respuestaid`, `subformid`,`formid`, `levantamientoid`, `userid`, `empresaid`, `created`, `respsubpregunta`, `clonedid` ) VALUES 
				(NULL, $idpregunta , $idnode, $idsubform ,'',$idlev, $userid,$idempresa,'".date("Y-m-d H:i:s")."', '$respsubpregunta' , $idclone);
				");
				
			}
		}else{
			DBQuery("INSERT INTO `registropreguntas` (`id`, `preguntaid`, `respuestaid`, `subformid`,`formid`, `levantamientoid`, `userid`, `empresaid`, `created`, `respsubpregunta`, `clonedid`) VALUES 
				(NULL, $idpregunta , $idnode, $idsubform ,'',$idlev, $userid,$idempresa,'".date("Y-m-d H:i:s")."', '$respsubpregunta', $idclone);
				");
		}
	
		
		$data = array(
				'result' => true
				);
		
		print($json->encode($data));
	
	} catch (Exception $e) {
		$db->rollback();
		$db->close();
		$data = array(
			'result' => false,
			'exception' => $e
			);
		print($json->encode($data));
	}
}else if($action == "deletelast"){
	
	try {
		$db = DBConnect();
		$db->autocommit(FALSE);
		$idlev = (int)$_POST['idlev'];
		$idsubform = (int)$_POST['idsubform'];

	
		$check = DBQuery("	SELECT * 
							FROm registropreguntas 
							WHERE subformid = $idsubform AND levantamientoid = $idlev ORDER by id DESC limit 1 ");
		if($check->num_rows > 0){
		
			DBQuery(" 	DELETE
						FROm registropreguntas 
						WHERE subformid = $idsubform AND levantamientoid = $idlev ORDER by id DESC limit 1 ");
			
			$data = array(
				'result' => true,
				);
		}else{
			
			$data = array(
				'result' => true,
				'moreinfo' => "no hay respuestas anteriores"
				);
		}
		
		
		print($json->encode($data));
	
	} catch (Exception $e) {
		$db->rollback();
		$db->close();
		$data = array(
			'result' => false,
			'exception' => $e
			);
		print($json->encode($data));
	}
	
}else if($action == "subpregunta"){
	try {
		$db = DBConnect();
		$db->autocommit(FALSE);
		
		$idnodo = (int)$_POST['idpregunta'];

		$node = DBQueryReturnArray("SELECT * 
							FROM nodos 
							WHERE id =$idnodo ");
		$metatype = $node[0]['metatype'];
		
		if($metatype != null){
			$data = array(
				'result' => true,
				'subpregunta' => true, 
				'node' => $node[0]
				);
		}else{
			$data = array(
				'result' => true,
				'subpregunta' => false
				);
		}
		
		print($json->encode($data));
	
	} catch (Exception $e) {
		$db->rollback();
		$db->close();
		$data = array(
			'result' => false,
			'exception' => $e
			);
		print($json->encode($data));
	}
}else if($action == "deleteall"){
	
	try {
		$db = DBConnect();
		$db->autocommit(FALSE);
		$idlev = (int)$_POST['idlev'];
		$idsubform = (int)$_POST['idsubform'];
		$idclone = (int)$_POST['idclone'];
		
		if($idclone){
			$change = "clonedid = $idclone AND";
		}else{
			$change = "subformid = $idsubform AND";
		}
		
		$check = DBQuery("	SELECT * 
							FROm registropreguntas 
							WHERE $change levantamientoid = $idlev ");
		if($check->num_rows > 0){
		
			DBQuery(" 	DELETE
						FROm registropreguntas 
						WHERE $change levantamientoid = $idlev ");
			
			$data = array(
				'result' => true,
				);
		}else{
			
			$data = array(
				'result' => true,
				'moreinfo' => "no hay respuestas"
				);
		}
		
		
		print($json->encode($data));
	
	} catch (Exception $e) {
		$db->rollback();
		$db->close();
		$data = array(
			'result' => false,
			'exception' => $e
			);
		print($json->encode($data));
	}
	
}else if($action == "cloneanswers"){

	try {
		$db = DBConnect();
		$db->autocommit(FALSE);
		$idlev = (int)$_POST['idlev'];
		$idsubform = (int)$_POST['idsubform'];
		$idform = (int)$_POST['idform'];
		$nombre = $idsubform." cloned";

		DBQuery("INSERT INTO `cloned` (`id`, `idlev`, `name`, `subformid`,`modified`, `formid` ) VALUES 
				(NULL, $idlev , '$nombre', $idsubform, NULL , $idform );
				");
		$data = array(
			'result' => true
			);		
		print($json->encode($data));
	
	} catch (Exception $e) {
		$db->rollback();
		$db->close();
		$data = array(
			'result' => false,
			'exception' => $e
			);
		print($json->encode($data));
	}
	
}else if($action == "deleteclone"){

	try {
		$db = DBConnect();
		$db->autocommit(FALSE);
		$idclone = (int)$_POST['idclone'];
		$idlev = (int)$_POST['idlev'];

		DBQuery(" 	DELETE
					FROm registropreguntas 
					WHERE clonedid = $idclone AND levantamientoid = $idlev ");
		
		DBQuery(" 	DELETE
					FROM cloned 
					WHERE id = $idclone ");
		$data = array(
			'result' => true
			);		
		print($json->encode($data));
	
	} catch (Exception $e) {
		$db->rollback();
		$db->close();
		$data = array(
			'result' => false,
			'exception' => $e
			);
		print($json->encode($data));
	}
	
}
