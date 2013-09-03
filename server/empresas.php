<?php
require_once('../DB/db.php');
 require_once('../JSON.php');

$json = new Services_JSON();


if(isset($_POST["action"])){
	
	try{
		$sql = "SELECT * FROM empresas WHERE id = $_POST[id] ";
		
		$result = DBquery($sql);
		$response = $result->fetch_assoc();
		$data = array(
				'nombre' => $response['nombre'],
				'id' => $response['id'],
				'industria' => $response['industria'],
				'contactado'=> $response['contactado'],
				'areacontacto'=> $response['areacontacto'],
				'infolevantamiento'=> $response['infolevantamiento'],
				'modified'=> $response['modified']	
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
		 
		if ($empresas = DBquery($sql)){
			$data = array(
				'total' => $empresas->num_rows
			);
			$i = 0;
			while ($fetch = $empresas->fetch_assoc()) {
				$data[$i] = array(
					'nombre' => $fetch['nombre'],
					'id' => $fetch['id'], 
					'industria' => $fetch['industria'],
					'contactado'=> $fetch['contactado'],
					'areacontacto'=> $fetch['areacontacto'],
					'infolevantamiento'=> $fetch['contactado'],
					'modified'=> $fetch['modified']
				);
				$i++;
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