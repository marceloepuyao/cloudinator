<?php

require_once('../DB/db.php');
 require_once('../JSON.php');

$json = new Services_JSON();
 
try {	
	$usu = mysql_real_escape_string($_POST["usu"]);
	$pass = mysql_real_escape_string($_POST["pass"]);
	$empresa = mysql_real_escape_string($_POST["empresa"]);
	 
	$sql = "SELECT * FROM users WHERE email='$usu' AND password='$pass'";
	 
	if ($resultado = DBQuery($sql)){
	    if ($resultado->num_rows > 0){
	    	$aux = $resultado->fetch_assoc();
	    	
	    	session_start();
	    	$_SESSION['usuario'] = $aux['email'];
	    	$_SESSION['idioma'] = $aux['lang'];
	    	$_SESSION['ultimoacceso'] = time();
	    	$_SESSION['empresa'] = $empresa;
	    	
	        $data = array(
				'result' => true,
				'lang' => $aux['lang']
			);
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
 
?>