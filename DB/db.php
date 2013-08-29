<?php
function get_config(){

	//TODO hay que arreglar la llamada a ../config.ini, por que si se esta en un nivel distinto, no encuentra el archivo
	$config = parse_ini_file("../config.ini", true);

	return $config["mysql"];
}

function DBQuery($query){
	$connconf = get_config();
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
	$connconf = get_config();
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