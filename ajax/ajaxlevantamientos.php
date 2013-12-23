<?php
require_once('../JSON.php');
require_once('../DB/db.php');

$json = new Services_JSON();

$action = $_POST['action'];
if($action == 'insert'){

	try {
		$titulo = mysql_real_escape_string($_POST['titulo']);
		$empresaid = (int)($_POST['empresaid']);
		$info = mysql_real_escape_string($_POST['info']);
		$forms = $_POST['forms'];
		$contactado = mysql_real_escape_string($_POST['contactado']);
		$area = mysql_real_escape_string($_POST['area']);
		
		$check = DBQuery("SELECT * FROM levantamientos WHERE titulo = '$titulo' AND empresaid = '$empresaid'");
		if($check->num_rows > 0){
			$data = array(
				'result' => false,
			);
		}else{
			DBQuery("INSERT INTO `levantamientos` (`id`, `titulo`, `empresaid`, `info`,`formsactivos`, `conctadopor`, `areacontacto`, `completitud`, `created`, `modified` ) VALUES 
				(NULL, '$titulo', '$empresaid', '$_POST[info]','$forms','$contactado', '$area','0','".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."' );
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
		
		$titulo = mysql_real_escape_string($_POST['titulo']);
		$empresaid = (int)($_POST['empresaid']);
		$info = mysql_real_escape_string($_POST['info']);
		$forms = $_POST['forms'];
		$contactado = mysql_real_escape_string($_POST['contactado']);
		$area = mysql_real_escape_string($_POST['area']);
		$idlev = (int)($_POST['idlev']);
		
		$query = "UPDATE  `levantamientos` SET  `titulo` =  '$titulo', `empresaid` =  '$empresaid', `info` =  '$info',`formsactivos` =  '$forms', `conctadopor` =  '$contactado',`areacontacto` =  '$area',`modified` =  '".date("Y-m-d H:i:s")."'
				WHERE  `levantamientos`.`id` = '$idlev';";
		DBQuery($query);
	
		
		$data = array(
			'result' => true,
			'id'=>$idlev
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

		
