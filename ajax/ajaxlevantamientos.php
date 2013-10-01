<?php
require_once('../JSON.php');
require_once('../DB/db.php');

$json = new Services_JSON();

try {
	$check = DBQuery("SELECT * FROM levantamientos WHERE titulo = '$_POST[titulo]' AND empresaid = '$_POST[empresaid]'");
	if($check->num_rows > 0){
		$data = array(
			'result' => false,
		);
	}else{
		DBQuery("INSERT INTO `levantamientos` (`id`, `titulo`, `empresaid`, `info`,`formsactivos`, `conctadopor`, `areacontacto`, `completitud`, `created`, `modified` ) VALUES 
			(NULL, '$_POST[titulo]', '$_POST[empresaid]', '$_POST[info]','$_POST[forms]','$_POST[contactado]', '$_POST[area]','0','".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."' );
			");
		
		$info = DBQueryReturnArray("SELECT MAX(id) as id FROM levantamientos");
		$id = $info[0]['id'];
		
		$data = array(
			'result' => true,
			'id'=>$id
		);
	}
	print($json->encode($data));
} catch (Exception $e) {
	print('ERROR! '.$e);
}


		
