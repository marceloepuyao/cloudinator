<?php
session_start();
require_once('../DB/db.php');
require_once('../JSON.php');

$json = new Services_JSON();

$action = $_POST['action'];
if($action == 'login'){
 
	try {	
		$usu = mysql_real_escape_string($_POST["usu"]);
		$sql = "SELECT * FROM users WHERE email='$usu'";
		
		if ($resultado = DBQuery($sql)){
		    if ($resultado->num_rows > 0){
		    	$aux = $resultado->fetch_assoc();
		    	if(crypt($_POST["pass"], $aux['password']) == $aux['password']){
			    	$_SESSION['usuario'] = $aux['email'];
			    	$_SESSION['idioma'] = $aux['lang'];
			    	$_SESSION['ultimoacceso'] = time();
			    	
			        $data = array(
						'result' => true,
						'lang' => $aux['lang']
					);
		    	}else{
			    	$data = array(
						'result' => false,
						'exception' => 'WrongPassword'
					);
			    }
		    }else{
		    	$data = array(
					'result' => false,
					'exception' => 'UserNotFound'
				);
		    }
		}
		else{
		    $data = array(
					'result' => false,
					'exception' => 'ErrorInTheQuery'
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
}else if($action == "empresa"){
	try {	
		$emp = mysql_real_escape_string($_POST["empresa"]);
		$_SESSION['empresa'] = $emp;
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
 
?>