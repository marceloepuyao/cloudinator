<?php
require_once('../JSON.php');
require_once('../DB/db.php');

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
		$userid = (int)$_POST['iduser'];
		$idempresa= (int)$_POST['idempresa'];
		$respsubpregunta = $_POST['respsubpregunta'];
	
		DBQuery("INSERT INTO `registropreguntas` (`id`, `preguntaid`, `respuestaid`, `subformid`,`formid`, `levantamientoid`, `userid`, `empresaid`, `created`, `respsubpregunta`) VALUES 
				(NULL, $idpregunta , $idnode, $idsubform ,'',$idlev, $userid,$idempresa,'".date("Y-m-d H:i:s")."', '$respsubpregunta' );
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
}
