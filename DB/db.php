<?php

$config = parse_ini_file(dirname(__FILE__)."/../config.ini", true);
$connconf = $config["mysql"];


function DBQuery($query){
	global $connconf;
	$link = mysql_connect($connconf['mysql_host'], $connconf['mysql_user'], $connconf['mysql_password']);
	mysql_select_db($connconf['mysql_database']);
	$result = mysql_query($query);
	if($result === false){
		mysql_close($link);
		throw new Exception("Error Processing Query", 1);
	}
	return $result;
	mysql_close($link);
}

function DBQueryReturnArray($query){
	global $connconf;
	$link = mysql_connect($connconf['mysql_host'], $connconf['mysql_user'], $connconf['mysql_password']);
	mysql_select_db($connconf['mysql_database']);
	$result = mysql_query($query);
	if($result === false){
		mysql_close($link);
		throw new Exception("Error Processing Query", 1);
	}

	$datos = array();
	//lleno el array $datos con el resultado de la consulta a MySQL:
	while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$datos[]=$line;
	}
	
	mysql_free_result($result);
	mysql_close($link);
	return $datos;
}
?>