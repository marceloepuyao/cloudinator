<?php
require_once('../DB/db.php');
 require_once('../JSON.php');

$json = new Services_JSON();
 
try {
	
	$name = mysql_real_escape_string($_POST["name"]);
	$industry = mysql_real_escape_string($_POST["industry"]);
	$contacted = mysql_real_escape_string($_POST["contacted"]);
	$areacontacto = mysql_real_escape_string($_POST["areacontacto"]);
	$textarea = mysql_real_escape_string($_POST["textarea"]);
	$modified = time();
	
	$insertempresa = "INSERT INTO `cloudinator`.`empresas` (`id`, `nombre`, `industria`, `contactado`, `areacontacto`, `infolevantamiento`, `modified`) VALUES 
				(NULL, '$name', '$industry', '$contacted', '$areacontacto', '$textarea', $modified );";
	DBquery3($insertempresa);
	
	$data = array(
				'result' => true
			);

	print($json->encode($data));

}catch (Exception $e) {
	$data = array(
				'result' => false
			);
	print($json->encode($data));
}