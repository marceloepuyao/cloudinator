<?php
require_once('../JSON.php');
require_once('../DB/db.php');

$json = new Services_JSON();

$action = $_POST['action'];
if($action == 'insert'){

	try {
		$check = DBQuery("SELECT * FROM levantamientos WHERE titulo = '$_POST[titulo]' AND empresaid = '$_POST[empresaid]'");
		if($check->num_rows > 0){
			$data = array(
				'result' => false,
			);
		}else{
			DBQuery("INSERT INTO `levantamientos` (`id`, `titulo`, `empresaid`, `info`,`formsactivos`, `conctadopor`, `areacontacto`, `completitud`, `created`, `modified` ) VALUES 
				(NULL, '$_POST[titulo]', '$_POST[empresaid]', '$_POST[info]','$_POST[forms]','$_POST[contactado]', '$_POST[area]','0','".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."' );
				");
			
			$info = DBQueryReturnArray("SELECT MAX(id) as id FROM levantamientos");
			$id = $info[0]['id'];
			
			$data = array(
				'result' => true,
				'id'=>$id
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

}else if($action == "delete"){
	try {
		$idlev = (int)$_POST['idlev'];
		
		//TODO:no se deber�an borrar, se deber�a crear un campo delete = 1
		
		//se borra el levantamiento
		DBQuery("DELETE FROM `levantamientos` WHERE `levantamientos`.`id` = '$idlev'");
		//se borra las preguntas y respuestas
		DBQuery("DELETE FROM `registropreguntas` WHERE `registropreguntas`.`levantamientoid` = '$idlev'");
		
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
	
}else if($action == "update"){
	
	try {
		
		$query = "UPDATE  `levantamientos` SET  `titulo` =  '$_POST[titulo]', `empresaid` =  $_POST[empresaid], `info` =  '$_POST[info]',`formsactivos` =  '$_POST[forms]', `conctadopor` =  '$_POST[contactado]',`areacontacto` =  '$_POST[area]',`modified` =  '".date("Y-m-d H:i:s")."'
				WHERE  `levantamientos`.`id` =$_POST[idlev];";
		DBQuery($query);
	
		
		$data = array(
			'result' => true,
			'id'=>$_POST['idlev']
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

		
