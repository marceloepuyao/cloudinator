<?php
require_once('../JSON.php');
require_once('../DB/db.php');
session_start();

$json = new Services_JSON();

$action = $_POST['action'];
if($action == 'deleteall'){
	
	try {
		$_SESSION = array();
					
		$data = array(
			'result' => true,
			'id'=>$id
		);
		
		print($json->encode($data));
	} catch (Exception $e) {
		$data = array(
			'result' => false,
			'exception' => $e
		);
		print($json->encode($data));
	}
	
	
}else if($action == 'edit'){
	try {
		if(isset($_SESSION['edit'])){
			if($_SESSION['edit'] == 1){
				$_SESSION['edit'] = 0;
			}else{
				$_SESSION['edit'] = 1;
			}
			
		}else{
			$_SESSION['edit'] = 1;
		}
					
		$data = array(
			'result' => true,
			'id'=>$id
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

		