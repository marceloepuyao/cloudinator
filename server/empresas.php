<?php
require_once('../db.php');
 require_once('../JSON.php');

$json = new Services_JSON();


if(isset($_POST["action"])){
	
	try{
		$sql = "SELECT * FROM empresas WHERE id = $_POST[id] ";
		
		$response = DBquery3($sql);
		
		$data = array(
				'nombre' => mysql_result($response, 0, 'empresas.nombre'), 
				'id' =>mysql_result($response, 0, 'empresas.id')
				);

		print($json->encode($data));
		
	}catch(Exception $e){
		$data = array(
					'exception' => $e
				);
	}
	
	
	
}else{
 
	try {	
			 
		$sql = "SELECT * FROM empresas";
		 
		if ($empresas = DBquery3($sql)){
		    if (mysql_num_rows($empresas) > 0){
		    	
		        $data = array(
		        	'total' => mysql_num_rows($empresas)
				);
				
				for ($i = 0; $i < mysql_num_rows($empresas); $i++) {
					$data[$i] = array(
						'nombre' => mysql_result($empresas, $i, 'empresas.nombre'),
						'id' => mysql_result($empresas, $i, 'empresas.id')
					);
				}
				
				
				
		    }else{
		    	$data = array(
					'total' => 0
				);
		    	
		    }
		    
		}
		else{
		    $data = array(
					'total' => 0
			);
		}
		print($json->encode($data));
		
	}catch (Exception $e) {
		$data = array(
					'total' => 0,
					'exception' => $e
				);
		print($json->encode($data));
	}
}