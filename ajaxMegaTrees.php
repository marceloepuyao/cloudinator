<?php
require_once('JSON.php');
require_once('db.php');

$json = new Services_JSON();

if(isset($_POST['action'])) {
	
	if($_POST['action']=="delete"){
		try {
			$id = $_POST['id'];
			$sqltreescount = "SELECT count(id) FROM trees WHERE megatree=$id";
			$data1 = DBquery3($sqltreescount);
			$maxtrees = mysql_result($data1, 0);
			
			$sqltrees = "SELECT id FROM trees WHERE megatree=$id";
			$data2 = DBquery3($sqltrees);
			
			for ($i = 0; $i < $maxtrees; $i++) {
				$idtree= mysql_result($data2, $i, 'trees.id');
				$querydeletenodes = "DELETE FROM nodos WHERE tree=$idtree";	
				DBquery4($querydeletenodes);
			}
			//TODO:falta borrar links
			
			$querytree = "DELETE FROM trees WHERE megatree=$id;";
			DBquery4($querytree);
			
			$querymegatree = "DELETE FROM megatrees WHERE id=$id;";
			DBquery4($querymegatree);
			
			$data = array(
			'result' => 'true',
			);
			print($json->encode($data));
		}catch (Exception $e) {
			print($json->encode($e));
		}
	}else if($_POST['action']== "setname"){
		try{
			$id = $_POST['id'];
			$query = "SELECT * FROM  megatrees WHERE id = $id";
			$datos = DBquery2($query);
		
			$salida = $json->encode($datos);
			
		}catch (Exception $e){
			print('ERROR! '.$e);
		}
		print($salida);
		
	}
		
}else{

	try {	
		$query = 'SELECT * FROM  megatrees';
		$datos = DBquery2($query);
		
		$salida = $json->encode($datos);
	
	} catch (Exception $e) {
		print('ERROR! '.$e);
	}
	
	print($salida);
}