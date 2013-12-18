<?php
require_once('../DB/db.php');
 require_once('../JSON.php');
 session_start();

$json = new Services_JSON();
 
$action = $_POST['action'];
if($action == 'insert'){
	try {
		
		$name = mysql_real_escape_string($_POST["name"]);
		$industry = mysql_real_escape_string($_POST["industry"]);
		$textarea = mysql_real_escape_string($_POST["textarea"]);
		
		$existing = DBQuery("SELECT * FROM empresas WHERE nombre = '$name'");
		if($existing->num_rows > 0){
			$data = array(
					'result' => false,
					'exception'=> 'existing'
				);
		}else{
			
			$insertempresa = "INSERT INTO `empresas` (`id`, `nombre`, `industria`, `info`) VALUES 
					(NULL, '$name', '$industry', '$textarea' );";
			DBQuery($insertempresa);
	
			$nueva = DBQuery("SELECT * FROM empresas WHERE nombre = '$name'");
			$response = $nueva->fetch_array(MYSQLI_ASSOC);
			$_SESSION['empresa'] = $response['id'];
			
			
			$data = array(
						'id' => $response['id'],
						'result' => true
					);
		}
	
		print($json->encode($data));
	
	}catch (Exception $e) {
		$data = array(
					'result' => false,
					'exception' => $e
				);
		print($json->encode($data));
	}
}else if($action == "delete"){
	try {
		$idcompany = (int)$_POST["idcompany"];
		$existing = DBQuery("SELECT * FROM empresas WHERE id = $idcompany");
		if($existing->num_rows > 0){
			//se borra la empresa
			DBQuery("DELETE FROM empresas WHERE id = $idcompany");
			//se borran todos los registro de preguntas asociadas a los levantamientos
			$levantamientos = DBQueryReturnArray("SELECT * FROM levantamientos WHERE empresaid = $idcompany");
			foreach ($levantamientos as $levantamiento){
				DBQuery("DELETE FROM registropreguntas WHERE levantamientoid = $levantamiento[id]");
			}
			//se borran todos los levantamientos asociados a la empresa
			DBQuery("DELETE FROM levantamientos WHERE empresaid = $idcompany");
			
			$data = array(
					'result' => true
				);
		}else{
			$data = array(
					'result' => false
				);
		}
	
		print($json->encode($data));
	
	}catch (Exception $e) {
		$data = array(
					'result' => false,
					'exception' => $e
				);
		print($json->encode($data));
	}
	
	
}else if($action == "edit"){
	try {
		$name = mysql_real_escape_string($_POST["name"]);
		$industry = mysql_real_escape_string($_POST["industry"]);
		$textarea = mysql_real_escape_string($_POST["textarea"]);
		$id = (int)$_POST["empresaid"];
		
		$query = "UPDATE  `empresas` SET  `nombre` =  '$name', `industria` =  '$industry', `info` =  '$textarea'
				WHERE  `empresas`.`id` =$id;";
		DBQuery($query);
		$data = array(
					'result' => true
				);
		print($json->encode($data));
		
		
	}catch (Exception $e) {
		$data = array(
					'result' => false,
					'exception' => $e
				);
		print($json->encode($data));
	}
	
}