<?php
require_once('../JSON.php');
require_once('../DB/db.php');
session_start();

$json = new Services_JSON();

$action = $_POST['action'];
if($action == 'insert'){
	try {
		$email = mysql_real_escape_string($_POST["email"]);
		$name = mysql_real_escape_string($_POST["nombres"]);
		$lastname = mysql_real_escape_string($_POST["apellidos"]);
		$password = crypt($_POST["password"]);		
		$lang = mysql_real_escape_string($_POST["idioma"]);
		$superuser = (int)$_POST["superusuario"];
		
		
		//ckeckear que no exista el mismo email
		$check = DBQuery("SELECT * FROM users WHERE email = '$email'");
		if($check->num_rows > 0){
			$data = array(
				'result' => false,
			);
		}else{
		
			
			DBQuery("INSERT INTO `users` (`id`, `email`, `name`, `lastname`,`password`, `firstaccess`, `lastaccess`, `lang`, `modified`, `superuser` ) VALUES 
					(NULL, '$email', '$name', '$lastname','$password','' , '','$lang','".date("Y-m-d H:i:s")."', $superuser );
					");
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

}else if($action == "delete"){
	try {
		$iduser = (int)$_POST['iduser'];
		$who = $_SESSION["usuario"];
		
		//ckeckear que no se borre a si mismo
		$check = DBQuery("SELECT * FROM users WHERE id = '$iduser' AND email= '$who'");
		if($check->num_rows > 0){
			$data = array(
				'result' => false,
				'sameperson'=>true
			);
		}else{
			//se borra el levantamiento
			DBQuery("DELETE FROM `users` WHERE `users`.`id` = '$iduser'");
			
			$data = array(
						'result' => true	
					);
		}
		
		print($json->encode($data));
	} catch (Exception $e) {
		$data = array(
			'result' => false,
			'sameperson'=>false,
			'exception' => $e
		);
		print($json->encode($data));
	}
	
}else if($action == "update"){
	try {
		
		//TODO: evitar sql injection "escapando" los string
		$editto = (int)$_POST["editto"];
		$email = mysql_real_escape_string($_POST["email"]);
		$name = mysql_real_escape_string($_POST["nombres"]);
		$lastname = mysql_real_escape_string($_POST["apellidos"]);
		if($_POST["password"] == ""){
			$password = 0;
		}else{
		    $password = crypt($_POST["password"]);
		}
		
		
		$lang = mysql_real_escape_string($_POST["idioma"]);
		$superuser = (int)$_POST["superusuario"];
		if($password){
			$query = "UPDATE  `users` SET  `email` =  '$email', `name` =  '$name', `lastname` =  '$lastname',`password` =  '$password', `superuser` =  '$superuser', `lang` =  '$lang',`modified` =  '".date("Y-m-d H:i:s")."'
				WHERE  `users`.`id` =$editto;";
		}else{
			$query = "UPDATE  `users` SET  `email` =  '$email', `name` =  '$name', `lastname` =  '$lastname', `superuser` =  '$superuser', `lang` =  '$lang',`modified` =  '".date("Y-m-d H:i:s")."'
				WHERE  `users`.`id` =$editto;";
		}
		
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