<?php
require_once('../DB/db.php');
 require_once('../JSON.php');

$json = new Services_JSON();
 
try {
	
	$name = mysql_real_escape_string($_POST["name"]);
	$industry = mysql_real_escape_string($_POST["industry"]);
	$textarea = mysql_real_escape_string($_POST["textarea"]);
	$modified = time();
	
	$existing = DBQuery("SELECT * FROM empresas WHERE nombre = '$name'");
	if($existing->num_rows > 0){
		$data = array(
				'result' => false,
				'exception'=> 'existing'
			);
	}else{
		$insertempresa = "INSERT INTO `empresas` (`id`, `nombre`, `industria`, `contactado`, `areacontacto`, `infolevantamiento`, `modified`) VALUES 
				(NULL, '$name', '$industry', '', '', '$textarea', $modified );";
		DBQuery($insertempresa);

		$nueva = DBQuery("SELECT * FROM empresas WHERE nombre = '$name'");
		$response = $nueva->fetch_array(MYSQLI_ASSOC);
		$data = array(
					'result' => true,
					'id' => $response['id']
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