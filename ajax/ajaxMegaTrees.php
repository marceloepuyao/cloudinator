<?php
require_once('../JSON.php');
require_once('../DB/db.php');

$json = new Services_JSON();

if(isset($_POST['action'])) {
	
	if($_POST['action']=="delete"){
		try {
			$db = DBConnect();
			$db->autocommit(FALSE);
			try {
				$id = $_POST['id'];
/* //Esto no hace nada, creo. (Klaus)
				$sqltrees = "SELECT id FROM trees WHERE megatree=$id";
				if(!$result = $db->query($sqltrees)){
				    throw new Exception('There was an error running the query [' . $db->error . ']', 1);
				}
*/
				$querytree = "UPDATE trees SET deleted = 1 WHERE megatree=$id;";
				if(!$result = $db->query($querytree)){
				    throw new Exception('There was an error running the query [' . $db->error . ']', 1);
				}
				$querymegatree = "UPDATE megatrees SET deleted = 1 WHERE id=$id;";
				if(!$result = $db->query($querymegatree)){
				    throw new Exception('There was an error running the query [' . $db->error . ']', 1);
				}

			} catch (Exception $e) {
				$db->rollback();
				$db->close();
				throw new Exception("Error Processing Query", 1);
			}

			$db->commit();
			$db->close();
			//$result->free();
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
	}else if($_POST['action']== "setname"){
		try{
			$id = $_POST['id'];
			$query = "SELECT * FROM  megatrees WHERE id = $id";
			$datos = DBQueryReturnArray($query);
		
			$data = array(
				'result' => true,
				'datos' => $datos
			);
			$salida = $json->encode($data);
			
		}catch (Exception $e){
			$data = array(
				'result' => false,
				'exception' => $e
			);
			print($json->encode($data));
		}
		print($salida);
	}else if($_POST['action']=="add"){
		try {
			//primero comprobamos si existe un subform con el mismo nombre en el form
			$check = DBQuery("SELECT * FROM megatrees WHERE name = '$_POST[name]' AND deleted = 0");
			if($check->num_rows > 0){
				$data = array(
					'result' => false
				);
				print($json->encode($data));
			}else{
				DBQuery("INSERT INTO `megatrees` (`id`, `name`, `chain`, `deleted`, `created`, `modified` ) VALUES 
					(NULL, '$_POST[name]', NULL, 0, '".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."' );
					");
				$data = array(
					'result' => true
				);
				print($json->encode($data));
			}
		} catch (Exception $e) {
			$data = array(
				'result' => false,
				'exception' => $e
			);
			print($json->encode($data));
		}
	}
		
}else{

	try {	
		$query = 'SELECT * FROM  megatrees WHERE deleted = 0';
		$datos = DBQueryReturnArray($query);
		$data = array(
			'result' => true,
			'datos' => $datos
		);
		$salida = $json->encode($data);
	
	} catch (Exception $e) {
		$data = array(
			'result' => false,
			'exception' => $e
		);
		print($json->encode($data));
	}
	
	print($salida);
}