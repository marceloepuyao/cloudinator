<?php

require_once('../db.php');
 require_once('../JSON.php');

$json = new Services_JSON();
 
try {	
	$usu = mysql_real_escape_string($_POST["usu"]);
	$pass = mysql_real_escape_string($_POST["pass"]);
	 
	$sql = "SELECT name, lastname FROM users WHERE email='$usu' AND password='$pass'";
	 
	if ($resultado = DBquery3($sql)){
	    if (mysql_num_rows($resultado) > 0){
	        $data = array(
				'result' => 'true'
			);
	    }else{
	    	$data = array(
				'result' => 'false'
			);
	    	
	    }
	    
	}
	else{
	    $data = array(
				'result' => 'false'
		);
	}
	print($json->encode($data));
	
}catch (Exception $e) {
	$data = array(
				'result' => 'false',
				'exception' => $e
			);
	print($json->encode($data));
}
 
?>