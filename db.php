<?php
function get_config(){
	$config = parse_ini_file("config.ini", true);
	return $config["mysql"];
}

function DBquery($sql_query){
	$connconf = get_config();
	$connection = mysqli_connect($connconf['mysql_host'], $connconf['mysql_user'], $connconf['mysql_password'], $connconf['mysql_database']);

	// Execute query
	$result = mysqli_query($connection, $sql_query);
	
	if($result === false){
		mysqli_close($connection);
		throw $e;
	}
	
	return $result;
	mysqli_close($connection);
}

function DBquery2($query){
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

function DBquery3($query){
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
function DBquery4($query){
	$connconf = get_config();
	$link = mysql_connect($connconf['mysql_host'], $connconf['mysql_user'], $connconf['mysql_password']);

	mysql_select_db($connconf['mysql_database']);

	if(mysql_query($query) === false){
		mysql_close($link);
		throw new Exception("Error Processing Query", 1);
	}

	mysql_close($link);
}
?>