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
		$userid = $_SESSION['usuario'];
		$idempresa= (int)$_POST['idempresa'];
		$respsubpregunta = $_POST['respsubpregunta'];
		
		$registro = DBQueryReturnArray("SELECT * 
							FROM registropreguntas
							WHERE preguntaid = $idpregunta AND
								subformid= $idsubform AND
								levantamientoid = $idlev
								 ");

		
		if(count($registro) > 0){
			if($registro[0]['respuestaid'] == $idnode && $registro[0]['respsubpregunta'] == $respsubpregunta){
				
			}else{
				DBQuery(" DELETE
						FROM registropreguntas 
						WHERE subformid = $idsubform AND
								levantamientoid = $idlev AND
								created >= '".$registro[0]['created']."'");
				DBQuery("INSERT INTO `registropreguntas` (`id`, `preguntaid`, `respuestaid`, `subformid`,`formid`, `levantamientoid`, `userid`, `empresaid`, `created`, `respsubpregunta`) VALUES 
				(NULL, $idpregunta , $idnode, $idsubform ,'',$idlev, '$userid',$idempresa,'".date("Y-m-d H:i:s")."', '$respsubpregunta' );
				");
				
			}
		}else{
			DBQuery("INSERT INTO `registropreguntas` (`id`, `preguntaid`, `respuestaid`, `subformid`,`formid`, `levantamientoid`, `userid`, `empresaid`, `created`, `respsubpregunta`) VALUES 
				(NULL, $idpregunta , $idnode, $idsubform ,'',$idlev, '$userid',$idempresa,'".date("Y-m-d H:i:s")."', '$respsubpregunta' );
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
}
