<?php

$config = parse_ini_file(Yii::app()->basePath."/config/config.ini" , true); //dirname(__FILE__).
$connconf = $config["mysql"];

function DBConnect(){
	global $connconf;

	$db = new mysqli($connconf['mysql_host'], $connconf['mysql_user'], $connconf['mysql_password'], $connconf['mysql_database']);
	if($db->connect_errno > 0){
		$db->close();
		$db = new mysqli($connconf['mysql_host'], $connconf['mysql_user'], $connconf['mysql_password']);
		if($db->connect_errno > 0){
			throw new Exception('Unable to connect to database [' . $db->connect_error . ']', 1);
		}
	}

	return $db;
}

function DBQuery($query){
	global $connconf;

	$db = new mysqli($connconf['mysql_host'], $connconf['mysql_user'], $connconf['mysql_password'], $connconf['mysql_database']);
	if($db->connect_errno > 0){
		$db->close();
		$db = new mysqli($connconf['mysql_host'], $connconf['mysql_user'], $connconf['mysql_password']);
		if($db->connect_errno > 0){
			throw new Exception('Unable to connect to database [' . $db->connect_error . ']', 1);
		}
	}
	if(!$result = $db->query($query)){
	    throw new Exception('There was an error running the query [' . $db->error . ']', 1);
	}
	$db->close();
	return $result;

	/*
	$link = mysql_connect($connconf['mysql_host'], $connconf['mysql_user'], $connconf['mysql_password']);
	mysql_select_db($connconf['mysql_database']);
	$result = mysql_query($query);
	if($result === false){
		mysql_close($link);
		throw new Exception("Error Processing Query", 1);
	}
	mysql_close($link);
	return $result;
	*/
}

function DBQueryReturnArray($query){
	global $connconf;

	$db = new mysqli($connconf['mysql_host'], $connconf['mysql_user'], $connconf['mysql_password'], $connconf['mysql_database']);
	if($db->connect_errno > 0){
		$db->close();
		$db = new mysqli($connconf['mysql_host'], $connconf['mysql_user'], $connconf['mysql_password']);
		if($db->connect_errno > 0){
			throw new Exception('Unable to connect to database [' . $db->connect_error . ']', 1);
		}
	}
	if(!$result = $db->query($query)){
	    throw new Exception('There was an error running the query [' . $db->error . ']', 1);
	}
	$datos = array();
	while($row = $result->fetch_assoc()){
    	$datos[]=$row;
	}
	$db->close();
	$result->free();
	return $datos;

	
	/*
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
	*/
}
?>